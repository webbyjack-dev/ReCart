<?php
/**
 * View partial: Team Permissions tab (Pro-locked).
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$pro_icon  = 'dashicons-groups';
$pro_title = __( 'Unlock Team Permissions', 'recart' );
$pro_body  = __( 'Restrict access to sensitive revenue data, limit who can export reports, and create custom roles for your support and marketing teams with ReCart Pro.', 'recart' );
?>
<div class="rc-pro-lock" style="margin-top: 0;">
    <?php include __DIR__ . '/admin-pro-overlay.php'; ?>
    <div class="rc-blur">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 600; color: #1d2327;"><?php esc_html_e( 'Role Access Control', 'recart' ); ?></h2>
            <button disabled class="rc-btn-primary" style="background:#c3c4c7 !important; cursor:not-allowed;">
                <span class="dashicons dashicons-plus-alt2" style="margin-top:4px;"></span>
                <?php esc_html_e( 'Create New Role', 'recart' ); ?>
            </button>
        </div>

        <div class="rc-card">
            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Role: Marketing Managers', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Assigned to 3 users. Configure what this team can view and edit within ReCart.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action" style="gap: 12px;">
                    <label style="display:flex; align-items:center; gap:10px; font-size:13px; color:#3c434a;"><input type="checkbox" disabled checked> View Dashboard Analytics</label>
                    <label style="display:flex; align-items:center; gap:10px; font-size:13px; color:#3c434a;"><input type="checkbox" disabled checked> Edit Email Templates</label>
                    <label style="display:flex; align-items:center; gap:10px; font-size:13px; color:#3c434a;"><input type="checkbox" disabled> Export CSV Reports</label>
                    <label style="display:flex; align-items:center; gap:10px; font-size:13px; color:#3c434a;"><input type="checkbox" disabled> Manage Integrations &amp; Webhooks</label>
                </div>
            </div>
            <div class="rc-row">
                <div class="rc-row-info">
                    <h4><?php esc_html_e( 'Role: Customer Support', 'recart' ); ?></h4>
                    <p><?php esc_html_e( 'Assigned to 8 users. Configure what this team can view and edit within ReCart.', 'recart' ); ?></p>
                </div>
                <div class="rc-row-action" style="gap: 12px;">
                    <label style="display:flex; align-items:center; gap:10px; font-size:13px; color:#3c434a;"><input type="checkbox" disabled> View Dashboard Analytics</label>
                    <label style="display:flex; align-items:center; gap:10px; font-size:13px; color:#3c434a;"><input type="checkbox" disabled> Edit Email Templates</label>
                    <label style="display:flex; align-items:center; gap:10px; font-size:13px; color:#3c434a;"><input type="checkbox" disabled> Export CSV Reports</label>
                    <label style="display:flex; align-items:center; gap:10px; font-size:13px; color:#3c434a;"><input type="checkbox" disabled checked> View Activity Logs</label>
                </div>
            </div>
        </div>
    </div>
</div>
