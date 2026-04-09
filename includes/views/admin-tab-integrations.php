<?php
/**
 * View partial: Integrations tab.
 *
 * @var string $crm_provider
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<form method="post" action="options.php">
    <?php settings_fields( 'wj_integrations_group' ); ?>
    <div class="rc-card">

        <div class="rc-row">
            <div class="rc-row-info">
                <h4><?php esc_html_e( 'CRM Provider', 'recart' ); ?></h4>
                <p><?php esc_html_e( 'Automatically sync abandoned cart data and recovery links to your connected CRM.', 'recart' ); ?></p>
            </div>
            <div class="rc-row-action">
                <select name="wj_crm_provider" id="wj_crm_provider">
                    <option value="none"          <?php selected( $crm_provider, 'none' ); ?>><?php esc_html_e( 'None (Internal WooCommerce Emails Only)', 'recart' ); ?></option>
                    <option value="hubspot"        <?php selected( $crm_provider, 'hubspot' ); ?>><?php esc_html_e( 'HubSpot CRM', 'recart' ); ?></option>
                    <option value="salesforce"     disabled><?php esc_html_e( 'Salesforce CRM (Pro Only)', 'recart' ); ?></option>
                    <option value="activecampaign" disabled><?php esc_html_e( 'ActiveCampaign (Pro Only)', 'recart' ); ?></option>
                    <option value="klaviyo"        disabled><?php esc_html_e( 'Klaviyo (Pro Only)', 'recart' ); ?></option>
                </select>
            </div>
        </div>

        <div id="wj-hubspot-config" style="<?php echo ( $crm_provider === 'hubspot' ) ? '' : 'display: none;'; ?> padding-top: 20px;">
            <div class="rc-row" style="border-top: 1px solid #eef0f2; padding-top: 30px;">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'HubSpot Access Token', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Enter your HubSpot Private App token to authorize the data sync.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <input type="password" name="wj_hs_token"
                        value="<?php echo esc_attr( get_option( 'wj_hs_token' ) ); ?>"
                        placeholder="pat-na1-...">
                    <div class="rc-scopes">
                        <strong><?php esc_html_e( 'Required Scopes:', 'recart' ); ?></strong>
                        <?php esc_html_e( 'Ensure your app has', 'recart' ); ?>
                        <span class="rc-code">crm.objects.contacts.read</span>
                        <?php esc_html_e( 'and', 'recart' ); ?>
                        <span class="rc-code">crm.objects.contacts.write</span>.
                    </div>
                </div>
            </div>

            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Property Mapping', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Please create these custom properties in your HubSpot Contact records to receive the synced data.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action">
                    <table class="rc-table">
                        <thead>
                            <tr>
                                <th><?php esc_html_e( 'Label Name', 'recart' ); ?></th>
                                <th><?php esc_html_e( 'Internal ID', 'recart' ); ?></th>
                                <th><?php esc_html_e( 'Type', 'recart' ); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Abandoned Cart URL</td><td><span class="rc-code">abandoned_cart_url</span></td><td>Single-line text</td></tr>
                            <tr><td>Cart Status</td><td><span class="rc-code">cart_abandoned_status</span></td><td>Text</td></tr>
                            <tr><td>Last Abandoned Date</td><td><span class="rc-code">last_abandoned_date</span></td><td>Date/Time</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



            

    </div>

    <div class="rc-footer" id="rc-integrations-footer"
         style="<?php echo ( $crm_provider === 'mailchimp' ) ? 'display: none;' : ''; ?>">
        <?php submit_button( __( 'Save Settings', 'recart' ), 'primary rc-btn-primary', 'submit', false ); ?>
    </div>
</form>