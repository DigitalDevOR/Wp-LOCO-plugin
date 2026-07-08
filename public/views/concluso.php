<?php

if (!defined('ABSPATH')) {
    exit;
}

?>

<main style="min-height:100vh; justify-content:space-between; width:100%; align-items: center;" class="LOCO_main">
    <?php include WIDGET_LOCO_PATH . 'public/views/partials/header.php'; ?>
    <section class="LOCO_li_section LOCO_li_hero_content">
        

        <?php include WIDGET_LOCO_PATH . 'public/views/partials/quantoSeiLoco.php'; ?>

        <div class="LOCO_form_header" style="text-align:center; padding: 40px 0; height:100%; margin: 0 auto;">
            <p style="margin-bottom: 40px;" class="LOCO_form_header_label"><?php esc_html_e( 'Vi ringraziamo!', 'widget-loco' ); ?></p>
            <h2 class="LOCO_already_candidate_header">🍒 <?php esc_html_e( 'Il concorso è ufficialmente terminato', 'widget-loco' ); ?></h2>
            <p class="LOCO_form_header_subtitle">
                <?php esc_html_e( 'Ti contatteremo presto se sei tra i selezionati.', 'widget-loco' ); ?>
            </p>
        </div>
    </section>
   
    
    <?php include WIDGET_LOCO_PATH . 'public/views/partials/footer.php'; ?>
</main>