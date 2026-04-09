<?php
/**
 * View partial: Automations tab (Pro-locked).
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$pro_icon  = 'dashicons-controls-repeat';
$pro_title = __( 'Unlock Powerful Automations', 'recart' );
$pro_body  = __( 'Auto-generate unique discount coupons, trigger custom exit-intent popups, and deploy sequence delays with ReCart Pro.', 'recart' );
?>
<div class="rc-pro-lock" style="margin-top: 0;">
    <?php include __DIR__ . '/admin-pro-overlay.php'; ?>
    <div class="rc-blur">
        <div class="rc-card">
            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Auto-Discount Codes', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Automatically generate and inject a unique, single-use discount code into the recovery email to incentivize checkout.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <div class="rc-toggle"></div>
                    <div style="margin-top: 15px; display: flex; gap: 10px;">
                        <input type="text" disabled placeholder="10" style="width: 80px;">
                        <select disabled style="width: 140px;"><option>Percentage (%)</option></select>
                    </div>
                </div>
            </div>
            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Exit Intent Popup', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Trigger a dynamic popup offering to save the user\'s cart via email when they move to close the browser tab.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <div class="rc-toggle" style="background:#c3c4c7;"></div>
                    <div style="margin-top: 15px;">
                        <select disabled style="width: 100%;"><option>Select Popup Template...</option></select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
