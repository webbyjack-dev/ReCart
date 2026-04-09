<?php
/**
 * Handles the WooCommerce Email template for Abandoned Cart Recovery.
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WC_Email' ) ) {
    return;
}

class ReCart_Abandonment_Email extends WC_Email {

    /**
     * @var string
     */
    public $recovery_url;

    public function __construct() {
        $this->id             = 'wj_abandoned_cart';
        $this->title          = __( 'ReCart Abandoned Cart', 'recart' );
        $this->description    = __( 'This email is sent to customers who leave items in their cart without checking out.', 'recart' );
        $this->customer_email = true;
        $this->heading        = __( 'You left something behind!', 'recart' );
        $this->subject        = __( 'Complete your purchase before it sells out', 'recart' );

        parent::__construct();
    }

    public function trigger( $recipient_email, $recovery_url ) {
        if ( ! $recipient_email || ! $recovery_url ) {
            return false;
        }

        $this->recipient    = $recipient_email;
        $this->recovery_url = $recovery_url;

        return $this->send(
            $this->get_recipient(),
            $this->get_subject(),
            $this->get_content_html(),
            $this->get_headers(),
            $this->get_attachments()
        );
    }

    public function get_content_html() {
        ob_start();
        $email_heading = $this->get_heading();
        
        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
        do_action( 'woocommerce_email_header', $email_heading, $this );
        ?>
        <p><?php esc_html_e( 'Hi there,', 'recart' ); ?></p>
        <p><?php esc_html_e( 'We noticed you left some great items in your cart. They are still waiting for you, but stock is moving fast! Click the button below to restore your cart and complete your purchase securely.', 'recart' ); ?></p>
        
        <table cellspacing="0" cellpadding="0" style="margin: 30px 0; width: 100%;">
            <tr>
                <td align="center">
                    <table cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center" bgcolor="#e05d22" style="border-radius: 4px;">
                                <a href="<?php echo esc_url( $this->recovery_url ); ?>" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; padding: 14px 28px; display: inline-block; font-weight: bold; border-radius: 4px;">
                                    <?php esc_html_e( 'Return to your cart', 'recart' ); ?>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <p><?php esc_html_e( 'If you had any trouble checking out or need assistance, simply reply to this email and our support team will be happy to help.', 'recart' ); ?></p>
        <?php
        // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
        do_action( 'woocommerce_email_footer', $this );
        
        return ob_get_clean();
    }
}