<?php
/**
 * View partial: WhatsApp Recovery tab (Pro-locked).
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$pro_icon  = 'dashicons-format-chat';
$pro_title = __( 'Unlock WhatsApp Recovery', 'recart' );
$pro_body  = __( 'Send rich-media WhatsApp messages with images, buttons, and automated cart rehydration links directly via the official WhatsApp Business API.', 'recart' );
?>
<div class="rc-pro-lock" style="margin-top: 0;">
    <?php include __DIR__ . '/admin-pro-overlay.php'; ?>
    <div class="rc-blur">
        <div class="rc-card">
            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Enable WhatsApp Recovery', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Activate WhatsApp alerts for abandoned checkouts.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <div class="rc-toggle" style="background:#c3c4c7;"></div>
                </div>
            </div>
            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Meta API Configuration', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Connect your WhatsApp Business API credentials from the Meta Developer Dashboard.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <input type="text"     disabled placeholder="Phone Number ID"               style="margin-bottom: 10px; width: 100%;">
                    <input type="text"     disabled placeholder="WhatsApp Business Account ID"  style="margin-bottom: 10px; width: 100%;">
                    <input type="password" disabled placeholder="Permanent Access Token"        style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
</div>
