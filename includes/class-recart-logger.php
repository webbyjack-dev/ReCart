<?php
/**
 * Handles writing to the ReCart activity log stored in wp_options.
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ReCart_Logger {

    /**
     * Prepend an entry to the log, capped at 50 entries.
     *
     * @param string $message Human-readable event description.
     * @param string $status  'success' or 'error'.
     */
    public function log( $message, $status = 'success' ) {
        $logs = get_option( 'wj_ac_logs', array() );
        if ( ! is_array( $logs ) ) {
            $logs = array();
        }

        array_unshift( $logs, array(
            'time'   => current_time( 'mysql' ),
            'msg'    => sanitize_text_field( $message ),
            'status' => sanitize_text_field( $status ),
        ) );

        $logs = array_slice( $logs, 0, 50 );
        update_option( 'wj_ac_logs', $logs );
    }

    /**
     * Retrieve all stored log entries.
     *
     * @return array
     */
    public function get_all() {
        $logs = get_option( 'wj_ac_logs', array() );
        return is_array( $logs ) ? $logs : array();
    }

    /**
     * Wipe all log entries.
     */
    public function clear() {
        delete_option( 'wj_ac_logs' );
    }
}
