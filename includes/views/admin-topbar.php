<?php
/**
 * View partial: top navigation bar.
 *
 * @var string $active_tab
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$report_tabs = array( 'location-report', 'recovery-report', 'lost-orders-report' );
?>
<div class="rc-topbar">
    <div class="rc-brand">
        <div class="rc-brand-icon"><span class="dashicons dashicons-cart"></span></div>
        ReCart
    </div>
    <div class="rc-top-nav">
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=recart-settings&tab=analytics' ) ); ?>"
           class="<?php echo $active_tab === 'analytics' ? 'active' : ''; ?>">
            <?php esc_html_e( 'Dashboard', 'recart' ); ?>
        </a>

        <div class="rc-nav-dropdown" id="rc-reports-dropdown">
            <a href="#" class="rc-nav-dropdown-toggle <?php echo in_array( $active_tab, $report_tabs, true ) ? 'active' : ''; ?>">
                <?php esc_html_e( 'Reports', 'recart' ); ?> <span class="dashicons dashicons-arrow-down-alt2"></span>
            </a>
            <div class="rc-nav-dropdown-menu">
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=recart-settings&tab=location-report' ) ); ?>"
                   class="<?php echo $active_tab === 'location-report' ? 'active' : ''; ?>">
                    <?php esc_html_e( 'Location Map', 'recart' ); ?> <span class="dashicons dashicons-lock"></span>
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=recart-settings&tab=recovery-report' ) ); ?>"
                   class="<?php echo $active_tab === 'recovery-report' ? 'active' : ''; ?>">
                    <?php esc_html_e( 'Recovery List', 'recart' ); ?> <span class="dashicons dashicons-lock"></span>
                </a>
                <a href="<?php echo esc_url( admin_url( 'admin.php?page=recart-settings&tab=lost-orders-report' ) ); ?>"
                   class="<?php echo $active_tab === 'lost-orders-report' ? 'active' : ''; ?>">
                    <?php esc_html_e( 'Lost Orders', 'recart' ); ?> <span class="dashicons dashicons-lock"></span>
                </a>
            </div>
        </div>

        <?php
        $settings_tabs    = array( 'analytics', 'location-report', 'recovery-report', 'lost-orders-report' );
        $settings_active  = ! in_array( $active_tab, $settings_tabs, true );
        ?>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=recart-settings&tab=general' ) ); ?>"
           class="<?php echo $settings_active ? 'active' : ''; ?>">
            <?php esc_html_e( 'Settings', 'recart' ); ?>
        </a>
    </div>

    <div class="rc-top-right" style="display: flex; align-items: center; gap: 15px;">
        <a href="https://docs.webbyjack.dev" target="_blank" class="rc-saas-help" style="text-decoration: none; color: #8c8f94; display: inline-flex; align-items: center; gap: 5px; font-weight: 500; font-size: 13px; transition: color 0.2s ease;" onmouseover="this.style.color='#1d2327'" onmouseout="this.style.color='#8c8f94'">
            <span class="dashicons dashicons-editor-help" style="font-size: 17px; width: 17px; height: 17px;"></span>
            <?php esc_html_e( 'Docs & Support', 'recart' ); ?>
        </a>
        <span style="width: 1px; height: 16px; background: #dcdcde;"></span>
        <span class="rc-version">v<?php echo esc_html( RECART_VERSION ); ?></span>
    </div>
</div>
