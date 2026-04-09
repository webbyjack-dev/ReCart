<?php
/**
 * View partial: Dashboard / Analytics tab.
 *
 * @var array  $summary            { abandoned_carts, recovered_carts, recovered_rev, lost_rev, recovery_rate }
 * @var array  $ranges             Keyed range labels.
 * @var string $current_range      Active range key.
 * @var string $active_range_label Human-readable active range.
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
$pro_icon  = 'dashicons-chart-area';
$pro_title = __( 'Unlock Visual Trends & Reports', 'recart' );
$pro_body  = __( 'Upgrade to Pro to unlock detailed revenue tracking, cart drop-off analysis, and exact recovery metrics.', 'recart' );
?>
<div class="rc-analytics">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2 style="margin: 0; font-size: 20px; font-weight: 600; color: #1d2327;">
            <?php esc_html_e( 'Performance Overview', 'recart' ); ?>
        </h2>

        <div class="rc-dropdown-container">
            <div class="rc-date-filter" id="rc-date-toggle">
                <span class="dashicons dashicons-calendar-alt" style="color: #8c8f94; font-size: 16px; width: 16px; height: 16px;"></span>
                <span style="font-weight: 500;"><?php echo esc_html( $active_range_label ); ?></span>
                <span class="dashicons dashicons-arrow-down-alt2" style="color: #8c8f94; font-size: 14px; width: 14px; height: 14px; margin-left: 4px;"></span>
            </div>
            <div class="rc-dropdown-menu" id="rc-date-menu">
                <?php foreach ( $ranges as $key => $label ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=recart-settings&tab=analytics&range=' . $key ) ); ?>"
                       class="<?php echo $current_range === $key ? 'active' : ''; ?>">
                        <?php echo esc_html( $label ); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Stat cards -->
    <div class="rc-stat-grid">
        <div class="rc-stat-card">
            <div class="rc-stat-title"><?php esc_html_e( 'Recovered Revenue', 'recart' ); ?></div>
            <div class="rc-stat-val"><?php echo wp_kses_post( wc_price( $summary['recovered_rev'] ) ); ?></div>
        </div>
        <div class="rc-stat-card">
            <div class="rc-stat-title"><?php esc_html_e( 'Lost Revenue', 'recart' ); ?></div>
            <div class="rc-stat-val"><?php echo wp_kses_post( wc_price( $summary['lost_rev'] ) ); ?></div>
        </div>
        <div class="rc-stat-card">
            <div class="rc-stat-title"><?php esc_html_e( 'Abandoned Carts', 'recart' ); ?></div>
            <div class="rc-stat-val"><?php echo esc_html( $summary['abandoned_carts'] ); ?></div>
        </div>
        <div class="rc-stat-card">
            <div class="rc-stat-title"><?php esc_html_e( 'Recovery Rate', 'recart' ); ?></div>
            <div class="rc-stat-val"><?php echo esc_html( $summary['recovery_rate'] ); ?>%</div>
        </div>
    </div>

    <!-- Chart (Pro-locked) -->
    <div class="rc-pro-lock" style="margin-top: 0;">
        <?php include __DIR__ . '/admin-pro-overlay.php'; ?>
        <div class="rc-blur">
            <div style="display:flex; justify-content: space-between; align-items:center; margin-bottom: 15px;">
                <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1d2327;">
                    <?php esc_html_e( 'Revenue over time', 'recart' ); ?>
                </h3>
            </div>
            <div class="rc-chart">
                <div class="rc-chart-bar" style="height: 30%;"></div>
                <div class="rc-chart-bar" style="height: 50%;"></div>
                <div class="rc-chart-bar" style="height: 40%;"></div>
                <div class="rc-chart-bar" style="height: 70%;"></div>
                <div class="rc-chart-bar" style="height: 60%;"></div>
                <div class="rc-chart-bar" style="height: 90%;"></div>
                <div class="rc-chart-bar" style="height: 80%;"></div>
                <div class="rc-chart-bar" style="height: 45%;"></div>
                <div class="rc-chart-bar" style="height: 85%;"></div>
                <div class="rc-chart-bar" style="height: 65%;"></div>
            </div>
        </div>
    </div>
</div>
