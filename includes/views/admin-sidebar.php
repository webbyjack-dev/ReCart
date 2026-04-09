<?php
/**
 * View partial: settings sidebar navigation.
 *
 * @var string $active_tab
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$nav_items = array(
    'general'      => array( 'icon' => 'dashicons-admin-generic', 'label' => __( 'General', 'recart' ),      'pro' => false ),
    'email'        => array( 'icon' => 'dashicons-email',         'label' => __( 'Email', 'recart' ),        'pro' => false ),
    'popup'        => array( 'icon' => 'dashicons-external',      'label' => __( 'Exit Popup', 'recart' ),   'pro' => true ),
    'sms'          => array( 'icon' => 'dashicons-smartphone',    'label' => __( 'SMS', 'recart' ),          'pro' => true ),
    'whatsapp'     => array( 'icon' => 'dashicons-format-chat',   'label' => __( 'WhatsApp', 'recart' ),     'pro' => true ),
    'integrations' => array( 'icon' => 'dashicons-networking',    'label' => __( 'Integrations', 'recart' ), 'pro' => false ),
    'automations'  => array( 'icon' => 'dashicons-controls-repeat','label' => __( 'Automations', 'recart' ), 'pro' => true ),
    'webhooks'     => array( 'icon' => 'dashicons-admin-links',   'label' => __( 'Webhooks', 'recart' ),     'pro' => true ),
    'permissions'  => array( 'icon' => 'dashicons-groups',        'label' => __( 'Permissions', 'recart' ),  'pro' => true ),
    'logs'         => array( 'icon' => 'dashicons-list-view',     'label' => __( 'Activity Logs', 'recart' ),'pro' => false ),
);
?>
<div class="rc-sidebar">
    <?php foreach ( $nav_items as $tab => $item ) : ?>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=recart-settings&tab=' . $tab ) ); ?>"
           class="<?php echo $active_tab === $tab ? 'active' : ''; ?>">
            <span class="dashicons <?php echo esc_attr( $item['icon'] ); ?>"></span>
            <?php echo esc_html( $item['label'] ); ?>
            <?php if ( $item['pro'] ) : ?>
                <span class="dashicons dashicons-lock"></span>
            <?php endif; ?>
        </a>
    <?php endforeach; ?>

    <div class="rc-pro-upsell">
        <a href="https://webbyjack.com/store" target="_blank">
            <span class="dashicons dashicons-star-filled"></span>
            <?php esc_html_e( 'Upgrade to Pro', 'recart' ); ?>
        </a>
    </div>
</div>
