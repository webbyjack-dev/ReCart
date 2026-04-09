<?php
/**
 * View partial: Activity Logs tab.
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound

$logger = new ReCart_Logger();
$logs   = $logger->get_all();
?>
<div class="rc-card" style="padding-top: 30px; padding-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <p style="margin: 0; color: #646970; font-size: 14px;">
            <?php esc_html_e( 'View the latest email sends and CRM sync events.', 'recart' ); ?>
        </p>
        <a href="<?php echo esc_url( admin_url( 'admin.php?page=recart-settings&tab=logs&clear_logs=1' ) ); ?>"
           class="button"
           onclick="return confirm('<?php esc_attr_e( 'Are you sure you want to clear all logs?', 'recart' ); ?>');">
            <?php esc_html_e( 'Clear Logs', 'recart' ); ?>
        </a>
    </div>

    <table class="rc-table">
        <thead>
            <tr>
                <th style="width: 180px;"><?php esc_html_e( 'Date & Time', 'recart' ); ?></th>
                <th><?php esc_html_e( 'Event Detail', 'recart' ); ?></th>
                <th style="width: 100px; text-align: center;"><?php esc_html_e( 'Status', 'recart' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ( ! empty( $logs ) ) : ?>
                <?php foreach ( $logs as $log ) : ?>
                    <?php
                    $is_error  = ( $log['status'] === 'error' );
                    $bg_col    = $is_error ? '#fef2f2' : '#ecfdf5';
                    $txt_col   = $is_error ? '#991b1b'  : '#065f46';
                    $label     = $is_error ? __( 'Failed', 'recart' ) : __( 'Success', 'recart' );
                    ?>
                    <tr>
                        <td style="color: #646970;">
                            <?php echo esc_html( date_i18n(
                                get_option( 'date_format' ) . ' ' . get_option( 'time_format' ),
                                strtotime( $log['time'] )
                            ) ); ?>
                        </td>
                        <td style="font-weight: 500; color: #1d2327;"><?php echo esc_html( $log['msg'] ); ?></td>
                        <td style="text-align: center;">
                            <span style="background: <?php echo esc_attr( $bg_col ); ?>; color: <?php echo esc_attr( $txt_col ); ?>; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 700; text-transform: uppercase;">
                                <?php echo esc_html( $label ); ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3" style="text-align: center; padding: 30px; color: #8c8f94;">
                        <?php esc_html_e( 'No recovery events recorded yet.', 'recart' ); ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
