<?php
/**
 * Records abandoned / recovered cart statistics used by the Dashboard tab.
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class ReCart_Stats {

    /**
     * Append a stat record, keeping the store capped at 2 000 entries.
     *
     * @param string $type   'abandoned' or 'recovered'.
     * @param float  $amount Cart / order total.
     */
    public function record( $type, $amount ) {
        $stats = get_option( 'wj_recart_stats', array() );
        if ( ! is_array( $stats ) ) {
            $stats = array();
        }

        $stats[] = array(
            'time'   => time(),
            'type'   => sanitize_text_field( $type ),
            'amount' => (float) $amount,
        );

        if ( count( $stats ) > 2000 ) {
            $stats = array_slice( $stats, -2000 );
        }

        update_option( 'wj_recart_stats', $stats );
    }

    /**
     * Return stats filtered by a Unix timestamp cutoff.
     *
     * @param int $cutoff Only include records at or after this timestamp. 0 = all time.
     * @return array { abandoned_carts, recovered_carts, abandoned_value, recovered_rev, lost_rev, recovery_rate }
     */
    public function get_summary( $cutoff = 0 ) {
        $stats           = get_option( 'wj_recart_stats', array() );
        $abandoned_carts = 0;
        $recovered_carts = 0;
        $abandoned_value = 0.0;
        $recovered_rev   = 0.0;

        if ( is_array( $stats ) ) {
            foreach ( $stats as $stat ) {
                if ( isset( $stat['time'] ) && $stat['time'] >= $cutoff ) {
                    if ( isset( $stat['type'] ) && $stat['type'] === 'abandoned' ) {
                        $abandoned_carts++;
                        $abandoned_value += (float) $stat['amount'];
                    } elseif ( isset( $stat['type'] ) && $stat['type'] === 'recovered' ) {
                        $recovered_carts++;
                        $recovered_rev += (float) $stat['amount'];
                    }
                }
            }
        }

        return array(
            'abandoned_carts' => $abandoned_carts,
            'recovered_carts' => $recovered_carts,
            'abandoned_value' => $abandoned_value,
            'recovered_rev'   => $recovered_rev,
            'lost_rev'        => max( 0, $abandoned_value - $recovered_rev ),
            'recovery_rate'   => ( $abandoned_carts > 0 ) ? round( ( $recovered_carts / $abandoned_carts ) * 100, 1 ) : 0,
        );
    }
}
