<?php
/**
 * View partial: Lost Orders report tab (Pro-locked).
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
                <?php esc_html_e( 'Lost Orders List', 'recart' ); ?>
            </h2>
            <button disabled class="rc-excel-btn">
                <span class="dashicons dashicons-download"></span>
                <?php esc_html_e( 'Export CSV', 'recart' ); ?>
            </button>
        </div>

        <div class="rc-recovery-excel">
            <div class="rc-excel-row rc-excel-cell-header">
                <div class="rc-excel-cell">Customer Email</div>
                <div class="rc-excel-cell">Abandoned Date</div>
                <div class="rc-excel-cell">Lost Value</div>
                <div class="rc-excel-cell">Last Communication</div>
                <div class="rc-excel-cell">Status</div>
            </div>
            <?php
            $rows = array(
                array( 'david.miller@email.com', '2023-10-30 08:12', '$450.00',    'SMS Sent (3 days ago)' ),
                array( 'emily.r@mail.co.uk',     '2023-10-28 14:45', '$125.50',    'Email 3 Sent (7 days ago)' ),
                array( 'guest_8923@yahoo.com',   '2023-10-25 11:30', '$89.00',     'Email 1 Sent' ),
                array( 'robert.h@gmail.com',     '2023-10-22 16:15', '$1,050.00',  'WhatsApp Sent' ),
            );
            foreach ( $rows as $row ) :
            ?>
            <div class="rc-excel-row rc-excel-cell-data">
                <div class="rc-excel-cell rc-excel-cell-email"><?php echo esc_html( $row[0] ); ?></div>
                <div class="rc-excel-cell"><?php echo esc_html( $row[1] ); ?></div>
                <div class="rc-excel-cell"><?php echo esc_html( $row[2] ); ?></div>
                <div class="rc-excel-cell"><?php echo esc_html( $row[3] ); ?></div>
                <div class="rc-excel-cell rc-excel-status-lost">Lost</div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
