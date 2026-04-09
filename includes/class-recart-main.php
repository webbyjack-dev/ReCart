<?php
/**
 * Main plugin class — registers all hooks and loads sub-components.
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WC_WJ_Abandoned_Cart_Integration {

    /** @var ReCart_Admin */
    private $admin;

    public function __construct() {
        $this->load_dependencies();
        $this->admin = new ReCart_Admin();

        add_filter( 'woocommerce_email_classes', array( $this, 'register_email_class' ) );
        add_action( 'admin_menu',                array( $this, 'add_admin_menu' ), 99 );
        add_action( 'admin_init',                array( $this, 'register_settings' ) );
        
        add_action( 'admin_enqueue_scripts',     array( $this, 'enqueue_admin_assets' ) );
        
        add_filter( 'plugin_action_links_' . plugin_basename( RECART_PLUGIN_FILE ), array( $this, 'add_plugin_action_links' ) );
        add_filter( 'plugin_row_meta',           array( $this, 'add_plugin_row_meta' ), 10, 2 );

        add_action( 'wp_footer',                     array( $this, 'inject_tracking_script' ) );
        add_action( 'wp_ajax_wj_sch_back',           array( $this, 'ajax_schedule_recovery' ) );
        add_action( 'wp_ajax_nopriv_wj_sch_back',    array( $this, 'ajax_schedule_recovery' ) );
        add_action( 'wp_ajax_wj_f_idle',             array( $this, 'ajax_force_idle_trigger' ) );
        add_action( 'wp_ajax_nopriv_wj_f_idle',      array( $this, 'ajax_force_idle_trigger' ) );
        add_action( 'wj_cron_sync',                  array( $this, 'master_recovery_trigger' ), 10, 2 );

        add_action( 'template_redirect',                    array( $this, 'handle_cart_restoration' ) );
        add_action( 'woocommerce_checkout_order_processed', array( $this, 'cleanup_on_purchase' ), 10, 3 );
    }

    private function load_dependencies() {
        require_once RECART_PLUGIN_DIR . 'includes/class-recart-logger.php';
        require_once RECART_PLUGIN_DIR . 'includes/class-recart-stats.php';
        require_once RECART_PLUGIN_DIR . 'includes/class-recart-hubspot.php';
        require_once RECART_PLUGIN_DIR . 'includes/class-recart-cart.php';
        require_once RECART_PLUGIN_DIR . 'includes/class-recart-admin.php';
    }

    public function enqueue_admin_assets( $hook ) {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( ! isset( $_GET['page'] ) || $_GET['page'] !== 'recart-settings' ) {
            return;
        }

        $css_file = RECART_PLUGIN_DIR . 'assets/css/admin-style.css';
        $js_file  = RECART_PLUGIN_DIR . 'assets/js/admin-script.js';

        $css_ver = file_exists( $css_file ) ? filemtime( $css_file ) : RECART_VERSION;
        $js_ver  = file_exists( $js_file ) ? filemtime( $js_file ) : RECART_VERSION;

        wp_enqueue_style( 'recart-admin-css', RECART_PLUGIN_URL . 'assets/css/admin-style.css', array(), $css_ver );
        wp_enqueue_script( 'recart-admin-js', RECART_PLUGIN_URL . 'assets/js/admin-script.js', array( 'jquery' ), $js_ver, true );
    }

    public function register_email_class( $email_classes ) {
        $email_file = RECART_PLUGIN_DIR . 'includes/class-recart-abandonment-email.php';
        if ( file_exists( $email_file ) ) {
            require_once $email_file;
            $email_classes['ReCart_Abandonment_Email'] = new ReCart_Abandonment_Email();
        }
        return $email_classes;
    }

    public function add_admin_menu() {
        add_submenu_page( 'woocommerce', 'ReCart', 'ReCart', 'manage_options', 'recart-settings', array( $this->admin, 'render' ) );
    }

    public function add_plugin_action_links( $links ) {
        $plugin_links = array( '<a href="' . esc_url( admin_url( 'admin.php?page=recart-settings' ) ) . '">' . esc_html__( 'Settings', 'recart' ) . '</a>' );
        return array_merge( $plugin_links, $links );
    }

    public function add_plugin_row_meta( $links, $file ) {
        if ( plugin_basename( RECART_PLUGIN_FILE ) === $file ) {
            $new_links = array(
                'support' => '<a href="https://docs.webbyjack.dev" target="_blank">' . esc_html__( 'Docs & Support', 'recart' ) . '</a>',
                'store'   => '<a href="https://store.webbyjack.com/recart-pro" target="_blank" style="color:#e05d22; font-weight:bold;">' . esc_html__( 'Explore ReCart Pro', 'recart' ) . '</a>',
            );
            return array_merge( $links, $new_links );
        }
        return $links;
    }

    public function register_settings() {
        $text  = array( 'sanitize_callback' => 'sanitize_text_field' );
        $int   = array( 'sanitize_callback' => 'absint' );
        $email = array( 'sanitize_callback' => 'sanitize_email' );
        $array = array( 'sanitize_callback' => function( $val ) { return is_array( $val ) ? array_map( 'sanitize_text_field', $val ) : array(); } );

        register_setting( 'wj_general_group', 'wj_enable_tracking',         $text );
        register_setting( 'wj_general_group', 'wj_disable_tracking_roles',  $array );
        register_setting( 'wj_general_group', 'wj_exclude_email_status',    $array );
        register_setting( 'wj_general_group', 'wj_admin_recovery_notice',   $text );
        register_setting( 'wj_general_group', 'wj_hs_delay_val',            $int );
        register_setting( 'wj_general_group', 'wj_hs_delay_unit',           $text );

        register_setting( 'wj_email_group', 'wj_email_engine',  $text );
        register_setting( 'wj_email_group', 'wj_smtp_host',     $text );
        register_setting( 'wj_email_group', 'wj_smtp_port',     $int );
        register_setting( 'wj_email_group', 'wj_smtp_user',     $text );
        register_setting( 'wj_email_group', 'wj_smtp_pass',     $text );
        register_setting( 'wj_email_group', 'wj_smtp_enc',      $text );
        register_setting( 'wj_email_group', 'wj_ac_from_name',  $text );
        register_setting( 'wj_email_group', 'wj_ac_from_email', $email );

        register_setting( 'wj_integrations_group', 'wj_crm_provider', $text );
        register_setting( 'wj_integrations_group', 'wj_hs_token',     $text );
    }

    public function inject_tracking_script() {
        if ( get_option( 'wj_enable_tracking', 'yes' ) !== 'yes' ) {
            return;
        }
        $user = wp_get_current_user();
        if ( $user->ID !== 0 ) {
            $disabled_roles = get_option( 'wj_disable_tracking_roles', array() );
            if ( ! empty( array_intersect( (array) $disabled_roles, $user->roles ) ) ) {
                return;
            }
        }

       if ( ( is_cart() || is_checkout() ) && ! is_order_received_page() ) {
            $email    = ( $user->ID !== 0 ) ? $user->user_email : '';
            $val      = (int) get_option( 'wj_hs_delay_val', 30 );
            $unit     = get_option( 'wj_hs_delay_unit', 'minutes' );
            $delay_ms = ( ( $unit === 'hours' ) ? $val * 3600 : $val * 60 ) * 1000;
            ?>
            <script>
                jQuery(document).ready(function($) {
                    var delay = <?php echo esc_js( $delay_ms ); ?>, timer;
                    function startEng(e) {
                        $.post('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {action:'wj_sch_back', email:e, nonce:'<?php echo esc_js( wp_create_nonce( 'wj_c_n' ) ); ?>'});
                        clearTimeout(timer);
                        timer = setTimeout(function() {
                            $.post('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', {action:'wj_f_idle', email:e, nonce:'<?php echo esc_js( wp_create_nonce( 'wj_c_n' ) ); ?>'});
                        }, delay);
                    }
                    var curE = '<?php echo esc_js( $email ); ?>'; if(curE) startEng(curE);
                    $(document).on('blur', '#billing_email', function() { var em=$(this).val(); if(em.indexOf('@')>0) startEng(em); });
                });
            </script>
            <?php
        }
    }

    public function ajax_schedule_recovery() {
        check_ajax_referer( 'wj_c_n', 'nonce' );
        // phpcs:ignore WordPress.Security.NonceVerification.Missing
        if ( ! isset( $_POST['email'] ) ) {
            wp_send_json_error();
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Missing
        $email     = sanitize_email( wp_unslash( $_POST['email'] ) );
        $md5_email = md5( $email );
        $cart      = new ReCart_Cart();

        $cart_total = 0;
        if ( isset( WC()->cart ) ) {
            $totals     = WC()->cart->get_totals();
            $cart_total = isset( $totals['total'] ) ? $totals['total'] : 0;
        }

        set_transient( 'wj_url_' . $md5_email, $cart->generate_recovery_url( $email ), DAY_IN_SECONDS );
        set_transient( 'wj_amt_' . $md5_email, $cart_total, DAY_IN_SECONDS );

        $val   = (int) get_option( 'wj_hs_delay_val', 30 );
        $delay = ( get_option( 'wj_hs_delay_unit' ) === 'hours' ) ? $val * 3600 : $val * 60;

        if ( ! wp_next_scheduled( 'wj_cron_sync', array( $email ) ) ) {
            wp_schedule_single_event( time() + $delay, 'wj_cron_sync', array( $email ) );
        }

        wp_send_json_success();
    }

    public function ajax_force_idle_trigger() {
        check_ajax_referer( 'wj_c_n', 'nonce' );
        // phpcs:ignore WordPress.Security.NonceVerification.Missing
        if ( ! isset( $_POST['email'] ) ) {
            wp_send_json_error();
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Missing
        $email = sanitize_email( wp_unslash( $_POST['email'] ) );
        $cart  = new ReCart_Cart();
        $this->master_recovery_trigger( $email, $cart->generate_recovery_url( $email ) );
        wp_send_json_success();
    }

    public function master_recovery_trigger( $email, $url = '' ) {
        $md5_email = md5( $email );
        $logger    = new ReCart_Logger();
        $stats     = new ReCart_Stats();

        if ( ! $url ) {
            $url = get_transient( 'wj_url_' . $md5_email );
        }

        $amt = get_transient( 'wj_amt_' . $md5_email );
        if ( $amt !== false ) {
            $stats->record( 'abandoned', $amt );
        }

        $crm_provider = get_option( 'wj_crm_provider', 'none' );
        if ( $crm_provider === 'hubspot' ) {
            $hubspot = new ReCart_HubSpot( $logger );
            $hubspot->sync( $email, $url );
        }

        if ( get_option( 'wj_email_engine', 'native' ) === 'smtp' ) {
            add_action( 'phpmailer_init', array( $this, 'configure_custom_smtp' ), 999 );
        }

        $emails = WC()->mailer()->get_emails();
        if ( isset( $emails['ReCart_Abandonment_Email'] ) ) {
            $sent = $emails['ReCart_Abandonment_Email']->trigger( $email, $url );
            if ( $sent ) {
                $logger->log( sprintf( 'Recovery email successfully sent to %s', sanitize_email( $email ) ), 'success' );
            }
        }

        if ( get_option( 'wj_email_engine', 'native' ) === 'smtp' ) {
            remove_action( 'phpmailer_init', array( $this, 'configure_custom_smtp' ), 999 );
        }
    }

    public function configure_custom_smtp( $phpmailer ) {
        $phpmailer->isSMTP();
        $phpmailer->Host       = get_option( 'wj_smtp_host' );
        $phpmailer->SMTPAuth   = true;
        $phpmailer->Port       = get_option( 'wj_smtp_port' );
        $phpmailer->Username   = get_option( 'wj_smtp_user' );
        $phpmailer->Password   = get_option( 'wj_smtp_pass' );

        $enc = get_option( 'wj_smtp_enc', 'tls' );
        if ( $enc !== 'none' ) {
            $phpmailer->SMTPSecure = $enc;
        }

        $from_name  = get_option( 'wj_ac_from_name' );
        $from_email = get_option( 'wj_ac_from_email' );
        if ( $from_email ) {
            $phpmailer->setFrom( $from_email, $from_name ? $from_name : '' );
        }
    }

    public function handle_cart_restoration() {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( isset( $_GET['wj_recover'] ) ) {
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $token = sanitize_text_field( wp_unslash( $_GET['wj_recover'] ) );
            $cart  = get_transient( 'wj_rec_' . $token );

            if ( $cart && function_exists( 'WC' ) && isset( WC()->cart ) ) {
                WC()->cart->empty_cart();
                foreach ( $cart as $i ) {
                    WC()->cart->add_to_cart( $i['product_id'], $i['quantity'], $i['variation_id'], $i['variation'] );
                }
                wc_add_notice( __( 'Welcome back! Your cart has been restored.', 'recart' ), 'success' );
            }
            wp_safe_redirect( wc_get_cart_url() );
            exit;
        }
    }

    public function cleanup_on_purchase( $order_id, $posted, $order ) {
        $email     = $order->get_billing_email();
        $md5_email = md5( $email );
        $logger    = new ReCart_Logger();
        $stats     = new ReCart_Stats();

        wp_clear_scheduled_hook( 'wj_cron_sync', array( $email ) );

        if ( get_transient( 'wj_url_' . $md5_email ) ) {
            $stats->record( 'recovered', $order->get_total() );
            $logger->log( sprintf( 'Cart recovered! Order #%s completed by %s.', $order_id, sanitize_email( $email ) ), 'success' );

            if ( get_option( 'wj_admin_recovery_notice', 'no' ) === 'yes' ) {
                $admin_email = get_option( 'admin_email' );
                /* translators: %s: Order ID */
                $subject     = sprintf( __( '[ReCart] Order #%s Recovered!', 'recart' ), $order_id );
                /* translators: 1: Customer email, 2: Order ID */
                $message     = sprintf( __( 'Great news! An abandoned cart was successfully recovered by %1$s for order #%2$s.', 'recart' ), sanitize_email( $email ), $order_id );
                wp_mail( $admin_email, $subject, $message );
            }
        } else {
            $logger->log( sprintf( 'Order completed by %s. Cleared scheduled recovery emails.', sanitize_email( $email ) ), 'success' );
        }

        delete_transient( 'wj_url_' . $md5_email );
        delete_transient( 'wj_amt_' . $md5_email );
    }
}