<?php
/**
 * View partial: Recovery List report tab (Pro-locked).
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
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0; font-size: 20px; font-weight: 600; color: #1d2327;">
                <?php esc_html_e( 'Recovery List', 'recart' ); ?>
            </h2>
            <button disabled class="rc-excel-btn">
                <span class="dashicons dashicons-download"></span>
                <?php esc_html_e( 'Export CSV', 'recart' ); ?>
            </button>
        </div>

        <div class="rc-recovery-excel">
            <div class="rc-excel-row rc-excel-cell-header">
                <div class="rc-excel-cell">OrderID</div>
                <div class="rc-excel-cell">Customer Email</div>
                <div class="rc-excel-cell">Recovered Date</div>
                <div class="rc-excel-cell">Cart Total</div>
                <div class="rc-excel-cell">Coupon Used</div>
            </div>
            <?php
            $rows = array(
                array( '#1024', 'john.doe@email.com',    '2023-11-05 14:32', '$145.00', 'AC20-Unique-B' ),
                array( '#1023', 'jane.smith@mail.co.uk', '2023-11-04 09:15', '$89.50',  '' ),
                array( '#1018', 'mick.jones@yahoo.com',  '2023-11-03 17:48', '$310.00', 'FREE-Unique-F' ),
                array( '#1015', 'sarah.w@gmail.com',     '2023-11-03 11:22', '$45.00',  '' ),
            );
            foreach ( $rows as $row ) :
            ?>
            <div class="rc-excel-row rc-excel-cell-data">
                <div class="rc-excel-cell"><?php echo esc_html( $row[0] ); ?></div>
                <div class="rc-excel-cell rc-excel-cell-email"><?php echo esc_html( $row[1] ); ?></div>
                <div class="rc-excel-cell"><?php echo esc_html( $row[2] ); ?></div>
                <div class="rc-excel-cell"><?php echo esc_html( $row[3] ); ?></div>
                <div class="rc-excel-cell">
                    <?php if ( $row[4] ) : ?>
                        <span class="rc-excel-cell-code"><?php echo esc_html( $row[4] ); ?></span>
                    <?php else : ?>
                        None
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
