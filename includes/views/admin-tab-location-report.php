<?php
/**
 * View partial: Location Map report tab (Pro-locked).
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$pro_icon  = 'dashicons-star-filled';
$pro_title = 'ReCart Pro Report';
$pro_body  = __( 'Upgrade to ReCart Pro to unlock detailed order tracking, customer segmentation, and visual heatmaps. Discover exactly where you are losing revenue and download performance data.', 'recart' );
?>
<div class="rc-pro-lock" style="margin-top: 0;">
    <?php include __DIR__ . '/admin-pro-overlay.php'; ?>
    <div class="rc-blur">
        <h2 style="margin: 0 0 20px 0; font-size: 20px; font-weight: 600; color: #1d2327;">
            <?php esc_html_e( 'Global Recovery Heatmap', 'recart' ); ?>
        </h2>
        <div class="rc-map-mockup">
            <div class="rc-map-land" style="width: 150px; height: 100px; top: 30%; left: 10%;"></div>
            <div class="rc-map-land" style="width: 100px; height: 150px; top: 10%; left: 45%;"></div>
            <div class="rc-map-land" style="width: 120px; height:  90px; top: 60%; left: 70%;"></div>
            <div class="rc-map-land" style="width:  80px; height:  60px; top: 50%; left: 30%;"></div>

            <div class="rc-map-mark" style="top: 35%; left: 15%;"></div>
            <div class="rc-map-mark" style="top: 45%; left: 18%;"></div>
            <div class="rc-map-mark" style="top: 25%; left: 50%;"></div>
            <div class="rc-map-mark" style="top: 65%; left: 75%;"></div>
            <div class="rc-map-mark" style="top: 30%; left: 52%;"></div>
            <div class="rc-map-mark" style="top: 55%; left: 32%;"></div>
        </div>
    </div>
</div>
