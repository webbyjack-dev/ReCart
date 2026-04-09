<?php
/**
 * Handles all wp-admin UI for ReCart: settings page, tab routing, and stats.
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ReCart_Admin {

    /**
     * Entry point called by add_submenu_page().
     */
    public function render() {
        if ( ! current_user_can( 'manage_woocommerce' ) ) {
            return;
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'general';

        // Clear logs action.
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( isset( $_GET['clear_logs'] ) && current_user_can( 'manage_woocommerce' ) ) {
            $logger = new ReCart_Logger();
            $logger->clear();
            wp_safe_redirect( admin_url( 'admin.php?page=recart-settings&tab=logs' ) );
            exit;
        }

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $current_range = isset( $_GET['range'] ) ? sanitize_text_field( wp_unslash( $_GET['range'] ) ) : 'last_30_days';

        $ranges = array(
            'today'        => __( 'Today', 'recart' ),
            'last_7_days'  => __( 'Last 7 Days', 'recart' ),
            'last_30_days' => __( 'Last 30 Days', 'recart' ),
            'this_month'   => __( 'This Month', 'recart' ),
            'all_time'     => __( 'All Time', 'recart' ),
        );
        $active_range_label = isset( $ranges[ $current_range ] ) ? $ranges[ $current_range ] : $ranges['last_30_days'];

        $cutoff = $this->cutoff_from_range( $current_range );

        $stats   = new ReCart_Stats();
        $summary = $stats->get_summary( $cutoff );

        $tab_names = array(
            'general'            => 'General Settings',
            'email'              => 'Email Configuration',
            'popup'              => 'Exit-Intent Popup', // <-- PRO TAB ADDED HERE
            'sms'                => 'SMS Recovery',
            'whatsapp'           => 'WhatsApp Recovery',
            'integrations'       => 'Integrations',
            'automations'        => 'Automations',
            'webhooks'           => 'Webhooks',
            'permissions'        => 'Team Permissions',
            'logs'               => 'Activity Logs',
            'analytics'          => 'Dashboard',
            'location-report'    => 'Location Report',
            'recovery-report'    => 'Recovered Orders',
            'lost-orders-report' => 'Lost Orders',
        );
        $current_tab_name = isset( $tab_names[ $active_tab ] ) ? $tab_names[ $active_tab ] : 'General Settings';

        $dashboard_views  = array( 'analytics', 'location-report', 'recovery-report', 'lost-orders-report' );
        $is_dashboard_view = in_array( $active_tab, $dashboard_views, true );

        $crm_provider = get_option( 'wj_crm_provider', 'none' );
        $email_engine = get_option( 'wj_email_engine', 'native' );
        $wp_roles     = function_exists( 'wp_roles' ) ? wp_roles()->get_names() : array();
        $wc_statuses  = function_exists( 'wc_get_order_statuses' )
            ? wc_get_order_statuses()
            : array( 'wc-processing' => 'Processing', 'wc-completed' => 'Completed' );

        // Build a single context array passed to every partial.
        $ctx = compact(
            'active_tab', 'current_range', 'ranges', 'active_range_label',
            'summary', 'current_tab_name', 'is_dashboard_view',
            'crm_provider', 'email_engine', 'wp_roles', 'wc_statuses'
        );

        $this->include_view( 'page', $ctx );
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Convert a named range key into a Unix timestamp cutoff.
     *
     * @param string $range
     * @return int
     */
    private function cutoff_from_range( $range ) {
        switch ( $range ) {
            case 'today':
                return strtotime( 'today' );
            case 'last_7_days':
                return strtotime( '-7 days' );
            case 'last_30_days':
                return strtotime( '-30 days' );
            case 'this_month':
                return strtotime( 'first day of this month' );
            default:
                return 0;
        }
    }

    /**
     * Load a view partial from includes/views/, extracting $ctx into local vars.
     *
     * @param string $name  Partial filename without extension, e.g. 'page'.
     * @param array  $ctx   Variables to extract into the partial's scope.
     */
    public function include_view( $name, array $ctx = array() ) {
        $file = RECART_PLUGIN_DIR . 'includes/views/admin-' . $name . '.php';
        if ( file_exists( $file ) ) {
            extract( $ctx, EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract
            include $file;
        }
    }
}
