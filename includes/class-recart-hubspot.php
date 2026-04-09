<?php
/**
 * Handles syncing abandoned cart data to the HubSpot CRM via their v3 REST API.
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ReCart_HubSpot {

    /** @var ReCart_Logger */
    private $logger;

    /**
     * @param ReCart_Logger $logger
     */
    public function __construct( ReCart_Logger $logger ) {
        $this->logger = $logger;
    }

    /**
     * Upsert a HubSpot contact with abandoned-cart properties.
     *
     * @param string $email Customer email.
     * @param string $url   Magic recovery URL.
     */
    public function sync( $email, $url ) {
        $token = get_option( 'wj_hs_token' );
        if ( ! $token || ! $url ) {
            $this->logger->log( 'HubSpot sync aborted. Missing Private App Token or Cart URL.', 'error' );
            return;
        }

        $headers = array(
            'Authorization' => 'Bearer ' . $token,
            'Content-Type'  => 'application/json',
        );

        // Check whether the contact already exists.
        $check_response = wp_remote_get(
            'https://api.hubapi.com/crm/v3/objects/contacts/' . urlencode( $email ) . '?idProperty=email',
            array( 'headers' => $headers )
        );
        $res    = json_decode( wp_remote_retrieve_body( $check_response ), true );
        $is_new = ! isset( $res['id'] );
        $api    = $is_new
            ? 'https://api.hubapi.com/crm/v3/objects/contacts'
            : 'https://api.hubapi.com/crm/v3/objects/contacts/' . $res['id'];

        $data = array(
            'properties' => array(
                'cart_abandoned_status' => 'Abandoned',
                'abandoned_cart_url'    => $url,
                'last_abandoned_date'   => strtotime( 'today UTC' ) * 1000,
            ),
        );
        if ( $is_new ) {
            $data['properties']['email'] = $email;
        }

        $sync_req = wp_remote_post( $api, array(
            'method'  => $is_new ? 'POST' : 'PATCH',
            'headers' => $headers,
            'body'    => wp_json_encode( $data ),
        ) );

        if ( is_wp_error( $sync_req ) ) {
            $this->logger->log(
                sprintf( 'HubSpot Sync Error for %s: %s', sanitize_email( $email ), $sync_req->get_error_message() ),
                'error'
            );
        } else {
            $this->logger->log(
                sprintf( 'Successfully synced abandoned cart data to HubSpot for %s', sanitize_email( $email ) ),
                'success'
            );
        }
    }
}
