<?php

if (!defined('ABSPATH')) {
    exit;
}

?>

<footer class="LOCO_footer">
    <p>
        © <?php echo esc_html( date( 'Y' ) ); ?> Radio Kiss Kiss ·
        <?php esc_html_e( 'Concorso a premi regolamentato.', 'widget-loco' ); ?>
        <br>
        <a href="<?php echo esc_url( WIDGET_LOCO_URL . 'public/docs/Regolamento_ConcorsoIbiza.pdf' ); ?>" download>
            <?php esc_html_e( 'Regolamento completo', 'widget-loco' ); ?>
        </a>
        &nbsp;·&nbsp;
        <a href="#" target="_blank" rel="noopener noreferrer">
            <?php esc_html_e( 'Privacy Policy', 'widget-loco' ); ?>
        </a>
    </p>
</footer>
