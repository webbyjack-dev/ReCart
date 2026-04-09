<?php
/**
 * View partial: Webhooks tab (Pro-locked).
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$pro_icon  = 'dashicons-admin-links';
$pro_title = __( 'Unlock Custom Webhooks', 'recart' );
$pro_body  = __( 'Send real-time abandoned cart data to Zapier, Make, or your own custom endpoints with ReCart Pro.', 'recart' );
?>
<div class="rc-pro-lock" style="margin-top: 0;">
    <?php include __DIR__ . '/admin-pro-overlay.php'; ?>
    <div class="rc-blur">
        <div class="rc-card">
            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Cart Abandoned Webhook', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Trigger a payload whenever a cart hits the abandonment threshold.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <div class="rc-toggle" style="background:#c3c4c7;"></div>
                    <div style="margin-top: 15px;">
                        <input type="text" disabled placeholder="https://hooks.zapier.com/hooks/catch/..." style="width: 100%;">
                    </div>
                </div>
            </div>
            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Cart Recovered Webhook', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Trigger a payload whenever an abandoned cart is successfully recovered and purchased.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <div class="rc-toggle" style="background:#c3c4c7;"></div>
                    <div style="margin-top: 15px;">
                        <input type="text" disabled placeholder="https://hooks.zapier.com/hooks/catch/..." style="width: 100%;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
