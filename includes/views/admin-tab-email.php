<?php
/**
 * View partial: Email Configuration tab.
 *
 * @var string $email_engine
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<form method="post" action="options.php">
    <?php settings_fields( 'wj_email_group' ); ?>
    <div class="rc-card">

        <div class="rc-row">
            <div class="rc-row-info">
                <h4><?php esc_html_e( 'Email Delivery Engine', 'recart' ); ?></h4>
                <p><?php esc_html_e( 'Choose how your recovery emails are sent. Native uses your default WordPress configuration.', 'recart' ); ?></p>
            </div>
            <div class="rc-row-action">
                <select name="wj_email_engine" id="wj_email_engine">
                    <option value="native"  <?php selected( $email_engine, 'native' ); ?>><?php esc_html_e( 'Native WooCommerce (Default)', 'recart' ); ?></option>
                    <option value="smtp"    <?php selected( $email_engine, 'smtp' ); ?>><?php esc_html_e( 'Custom SMTP', 'recart' ); ?></option>
                    <option value="klaviyo" disabled><?php esc_html_e( 'Klaviyo Transactional (Pro Only)', 'recart' ); ?></option>
                </select>
            </div>
        </div>

        <div id="wj-smtp-config" style="<?php echo ( $email_engine === 'smtp' ) ? '' : 'display: none;'; ?>">
            <div class="rc-row" style="padding-top: 0; border-top: none;">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'SMTP Settings', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Configure your custom SMTP server details to improve email deliverability and avoid spam folders.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <input type="text" name="wj_smtp_host"
                        value="<?php echo esc_attr( get_option( 'wj_smtp_host' ) ); ?>"
                        placeholder="smtp.example.com"
                        style="margin-bottom: 10px; width: 100%;">
                    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                        <input type="number" name="wj_smtp_port"
                            value="<?php echo esc_attr( get_option( 'wj_smtp_port', '587' ) ); ?>"
                            placeholder="587" style="width: 100px;">
                        <select name="wj_smtp_enc" style="width: 140px;">
                            <option value="tls"  <?php selected( get_option( 'wj_smtp_enc', 'tls' ), 'tls' ); ?>>TLS</option>
                            <option value="ssl"  <?php selected( get_option( 'wj_smtp_enc', 'tls' ), 'ssl' ); ?>>SSL</option>
                            <option value="none" <?php selected( get_option( 'wj_smtp_enc', 'tls' ), 'none' ); ?>>None</option>
                        </select>
                    </div>
                    <input type="text" name="wj_smtp_user"
                        value="<?php echo esc_attr( get_option( 'wj_smtp_user' ) ); ?>"
                        placeholder="SMTP Username"
                        style="margin-bottom: 10px; width: 100%;">
                    <input type="password" name="wj_smtp_pass"
                        value="<?php echo esc_attr( get_option( 'wj_smtp_pass' ) ); ?>"
                        placeholder="SMTP Password"
                        style="width: 100%;">
                </div>
            </div>
        </div>

        <div class="rc-row">
            <div class="rc-row-info">
                <h4><?php esc_html_e( 'Sender Name Override', 'recart' ); ?></h4>
                <p><?php esc_html_e( 'Override the global WooCommerce "From Name" specifically for abandoned cart recovery emails.', 'recart' ); ?></p>
            </div>
            <div class="rc-row-action">
                <input type="text" name="wj_ac_from_name"
                    value="<?php echo esc_attr( get_option( 'wj_ac_from_name' ) ); ?>"
                    placeholder="<?php echo esc_attr( get_option( 'woocommerce_email_from_name' ) ); ?>">
            </div>
        </div>

        <div class="rc-row">
            <div class="rc-row-info">
                <h4><?php esc_html_e( 'Sender Address Override', 'recart' ); ?></h4>
                <p><?php esc_html_e( 'Override the global WooCommerce "From Email" specifically for abandoned cart recovery emails.', 'recart' ); ?></p>
            </div>
            <div class="rc-row-action">
                <input type="email" name="wj_ac_from_email"
                    value="<?php echo esc_attr( get_option( 'wj_ac_from_email' ) ); ?>"
                    placeholder="<?php echo esc_attr( get_option( 'woocommerce_email_from_address' ) ); ?>">
            </div>
        </div>

    </div>
    <div class="rc-footer">
        <?php submit_button( __( 'Save Email Settings', 'recart' ), 'primary rc-btn-primary', 'submit', false ); ?>
    </div>
</form>
