<?php
/**
 * Handles cart serialisation and magic-link URL generation.
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ReCart_Cart {

    /**
     * Snapshot the current WooCommerce cart and return a signed recovery URL.
     *
     * @param string $email Customer email (used to salt the token).
     * @return string Recovery URL, or plain cart URL if the cart is empty.
     */
    public function generate_recovery_url( $email ) {
        if ( is_null( WC()->cart ) ) {
            wc_load_cart();
        }

        $cart = WC()->cart->get_cart();
        if ( empty( $cart ) ) {
            return wc_get_cart_url();
        }

        $token = md5( $email . time() . wp_rand() );
        set_transient( 'wj_rec_' . $token, $cart, 30 * DAY_IN_SECONDS );

        return add_query_arg( 'wj_recover', $token, wc_get_cart_url() );
    }
}
