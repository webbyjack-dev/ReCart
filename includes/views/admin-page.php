<?php
/**
 * View: Full admin page shell.
 *
 * Available variables (extracted by ReCart_Admin::include_view):
 * $active_tab, $current_range, $ranges, $active_range_label,
 * $summary, $current_tab_name, $is_dashboard_view,
 * $crm_provider, $email_engine, $wp_roles, $wc_statuses
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>


<div class="rc-app">

    <?php $this->include_view( 'topbar', compact( 'active_tab' ) ); ?>

    <div class="rc-layout">

        <?php if ( ! $is_dashboard_view ) : ?>
            <?php $this->include_view( 'sidebar', compact( 'active_tab' ) ); ?>
        <?php endif; ?>

        <div class="rc-content">

            <?php if ( ! $is_dashboard_view ) : ?>
                <h2 class="rc-page-title"><?php echo esc_html( $current_tab_name ); ?></h2>
            <?php endif; ?>

            <?php
            $tab_views = array(
                'general'            => 'tab-general',
                'email'              => 'tab-email',
                'popup'              => 'tab-popup', // <-- Added Popup Tab mapping here
                'integrations'       => 'tab-integrations',
                'sms'                => 'tab-sms',
                'whatsapp'           => 'tab-whatsapp',
                'automations'        => 'tab-automations',
                'webhooks'           => 'tab-webhooks',
                'permissions'        => 'tab-permissions',
                'logs'               => 'tab-logs',
                'analytics'          => 'tab-analytics',
                'location-report'    => 'tab-location-report',
                'recovery-report'    => 'tab-recovery-report',
                'lost-orders-report' => 'tab-lost-orders-report',
            );

            if ( isset( $tab_views[ $active_tab ] ) ) {
                $this->include_view( $tab_views[ $active_tab ], compact(
                    'active_tab', 'current_range', 'ranges', 'active_range_label',
                    'summary', 'crm_provider', 'email_engine', 'wp_roles', 'wc_statuses'
                ) );
            }
            ?>

        </div></div></div>
