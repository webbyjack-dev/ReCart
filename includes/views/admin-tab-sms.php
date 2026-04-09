<?php
/**
 * View partial: SMS Recovery tab (Pro-locked).
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$pro_icon  = 'dashicons-smartphone';
$pro_title = __( 'Unlock SMS Recovery', 'recart' );
$pro_body  = __( 'Connect your Twilio account to instantly send personalized SMS recovery reminders and magic cart links directly to your customers\' phones.', 'recart' );
?>
<div class="rc-pro-lock" style="margin-top: 0;">
    <?php include __DIR__ . '/admin-pro-overlay.php'; ?>
    <div class="rc-blur">
        <div class="rc-card">
            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Enable SMS Recovery', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Activate text message reminders for abandoned checkouts.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <div class="rc-toggle" style="background:#c3c4c7;"></div>
                </div>
            </div>
            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Twilio Configuration', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Provide your API credentials to connect ReCart to your Twilio SMS sender.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <input type="text"     disabled placeholder="Twilio Account SID"    style="margin-bottom: 10px; width: 100%;">
                    <input type="password" disabled placeholder="Twilio Auth Token"      style="margin-bottom: 10px; width: 100%;">
                    <input type="text"     disabled placeholder="Sender Phone Number"    style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
</div>
