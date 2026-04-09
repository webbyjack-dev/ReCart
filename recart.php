<?php
/**
 * Plugin Name: ReCart: Abandoned Cart Recovery for WooCommerce
 * Description: Recover lost revenue with native WooCommerce emails and CRM syncing.
 * Version: 1.1.0
 * Author: WEBBYJACK
 * License: GPLv2 or later
 * Text Domain: recart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'RECART_VERSION', '1.1.0' );
define( 'RECART_PLUGIN_FILE', __FILE__ );
define( 'RECART_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'RECART_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

add_action( 'plugins_loaded', function() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        return;
    }
    if ( ! class_exists( 'WC_WJ_Abandoned_Cart_Integration' ) ) {
        require_once RECART_PLUGIN_DIR . 'includes/class-recart-main.php';
        new WC_WJ_Abandoned_Cart_Integration();
    }
} );
