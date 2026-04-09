<?php
/**
 * View partial: Exit Intent Popup tab (Pro-locked).
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$pro_icon  = 'dashicons-external';
$pro_title = __( 'Unlock Exit-Intent Lead Capture', 'recart' );
$pro_body  = __( 'Catch anonymous shoppers before they disappear. Trigger a customizable popup when a user moves their mouse to close the page, capture their email, and automatically feed them into your recovery engine.', 'recart' );
?>
<div class="rc-pro-lock" style="margin-top: 0;">
    <?php include __DIR__ . '/admin-pro-overlay.php'; ?>
    <div class="rc-blur">
        <div class="rc-card">
            
            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Enable Exit-Intent Popup', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Show a popup when a user attempts to leave the site with items in their cart.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <div class="rc-toggle" style="background:#c3c4c7;"></div>
                </div>
            </div>

            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Popup Headline', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'The main attention-grabbing text.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <input type="text" disabled value="Wait! Don't leave your cart behind." style="width: 100%;">
                </div>
            </div>

            <div class="rc-row" style="border-bottom: none;">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Discount Offer (Optional)', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Offer a WooCommerce coupon code in exchange for their email.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <select disabled style="width: 100%;"><option>Select a Coupon...</option></select>
                </div>
            </div>

        </div>
    </div>
</div>