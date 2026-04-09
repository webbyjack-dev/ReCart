<?php
/**
 * View partial: reusable Pro upgrade overlay card.
 * Include this inside any .rc-pro-lock wrapper.
 *
 * Required variables (pass via include or extract before including):
 *   $pro_icon  – Dashicons class, e.g. 'dashicons-smartphone'
 *   $pro_title – Heading text
 *   $pro_body  – Description paragraph
 *
 * @package ReCart
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
?>
<div class="rc-overlay">
    <div class="rc-overlay-card">
        <span class="dashicons <?php echo esc_attr( $pro_icon ); ?>"
              style="font-size: 40px; width: 40px; height: 40px; color: #e05d22; margin-bottom: 20px;"></span>
        <h3><?php echo esc_html( $pro_title ); ?></h3>
        <p><?php echo esc_html( $pro_body ); ?></p>
        <a href="https://store.webbyjack.com/recart-pro" target="_blank" class="rc-btn-primary">
            <?php esc_html_e( 'Upgrade to Pro &rarr;', 'recart' ); ?>
        </a>
    </div>
</div>
