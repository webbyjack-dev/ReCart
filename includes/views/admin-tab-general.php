<?php
/**
 * View partial: General Settings tab.
 *
 * @var array  $wp_roles
 * @var array  $wc_statuses
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<form method="post" action="options.php">
    <?php settings_fields( 'wj_general_group' ); ?>
    <div class="rc-card">

        <div class="rc-row">
            <div class="rc-row-info">
                <h4><?php esc_html_e( 'Enable Tracking', 'recart' ); ?></h4>
                <p><?php esc_html_e( 'Toggle cart tracking and recovery emails on or off.', 'recart' ); ?></p>
            </div>
            <div class="rc-row-action">
                <input type="hidden" name="wj_enable_tracking" value="no">
                <label class="rc-real-toggle">
                    <input type="checkbox" name="wj_enable_tracking" value="yes"
                        <?php checked( get_option( 'wj_enable_tracking', 'yes' ), 'yes' ); ?>>
                    <span class="rc-real-slider"></span>
                </label>
            </div>
        </div>

        <div class="rc-row">
            <div class="rc-row-info">
                <h4><?php esc_html_e( 'Cart Abandoned Cut-Off Time', 'recart' ); ?></h4>
                <p><?php esc_html_e( 'Consider cart abandoned after above entered time of item being added to cart and order not placed.', 'recart' ); ?></p>
            </div>
            <div class="rc-row-action">
                <div class="rc-input-group">
                    <input type="number" name="wj_hs_delay_val"
                        value="<?php echo esc_attr( get_option( 'wj_hs_delay_val', '30' ) ); ?>"
                        style="width: 80px;">
                    <select name="wj_hs_delay_unit" style="width: 140px;">
                        <option value="minutes" <?php selected( get_option( 'wj_hs_delay_unit' ), 'minutes' ); ?>><?php esc_html_e( 'Minutes', 'recart' ); ?></option>
                        <option value="hours"   <?php selected( get_option( 'wj_hs_delay_unit' ), 'hours' ); ?>><?php esc_html_e( 'Hours', 'recart' ); ?></option>
                    </select>
                </div>
            </div>
        </div>

        <div class="rc-row">
            <div class="rc-row-info">
                <h4><?php esc_html_e( 'Disable Tracking For', 'recart' ); ?></h4>
                <p><?php esc_html_e( 'It will ignore selected users from abandonment process when they are logged in, preventing them from receiving recovery emails.', 'recart' ); ?></p>
            </div>
            <div class="rc-row-action">
                <?php $saved_roles = get_option( 'wj_disable_tracking_roles', array( 'administrator' ) ); ?>
                <select name="wj_disable_tracking_roles[]" multiple>
                    <?php foreach ( $wp_roles as $role_key => $role_name ) : ?>
                        <option value="<?php echo esc_attr( $role_key ); ?>"
                            <?php echo in_array( $role_key, (array) $saved_roles, true ) ? 'selected' : ''; ?>>
                            <?php echo esc_html( $role_name ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p style="font-size: 12px; color: #8c8f94; margin-top: 6px;">Hold Cmd/Ctrl to select multiple roles.</p>
            </div>
        </div>

        <div class="rc-row">
            <div class="rc-row-info">
                <h4><?php esc_html_e( 'Exclude Email Sending For', 'recart' ); ?></h4>
                <p><?php esc_html_e( 'It will not send future recovery emails if the order reaches these statuses and will mark as recovered.', 'recart' ); ?></p>
            </div>
            <div class="rc-row-action">
                <?php $saved_statuses = get_option( 'wj_exclude_email_status', array( 'wc-processing', 'wc-completed' ) ); ?>
                <select name="wj_exclude_email_status[]" multiple>
                    <?php foreach ( $wc_statuses as $status_key => $status_name ) : ?>
                        <option value="<?php echo esc_attr( $status_key ); ?>"
                            <?php echo in_array( $status_key, (array) $saved_statuses, true ) ? 'selected' : ''; ?>>
                            <?php echo esc_html( $status_name ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p style="font-size: 12px; color: #8c8f94; margin-top: 6px;">Hold Cmd/Ctrl to select multiple statuses.</p>
            </div>
        </div>

        <div class="rc-row">
            <div class="rc-row-info">
                <h4><?php esc_html_e( 'Notify Recovery To Admin', 'recart' ); ?></h4>
                <p><?php esc_html_e( 'This option will send an email to the admin on new order recovery.', 'recart' ); ?></p>
            </div>
            <div class="rc-row-action">
                <input type="hidden" name="wj_admin_recovery_notice" value="no">
                <label class="rc-real-toggle">
                    <input type="checkbox" name="wj_admin_recovery_notice" value="yes"
                        <?php checked( get_option( 'wj_admin_recovery_notice', 'no' ), 'yes' ); ?>>
                    <span class="rc-real-slider"></span>
                </label>
            </div>
        </div>

    </div>
    <div class="rc-footer">
        <?php submit_button( __( 'Save Settings', 'recart' ), 'primary rc-btn-primary', 'submit', false ); ?>
    </div>
</form>
