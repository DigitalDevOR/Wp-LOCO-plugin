<?php

if (!defined('ABSPATH')) {
    exit;
}

?>

<main class="LOCO_main">

    <?php include WIDGET_LOCO_PATH . 'public/views/partials/header.php'; ?>

    <!-- ── FORM INSERIMENTO CODICE LOCO ── -->
    <div class="LOCO_form_section" id="partecipa">
        <div class="LOCO_form_inner">

            <div class="LOCO_form_header">
                <p class="LOCO_form_header_label"><?php esc_html_e( 'Fase 2 – Candidatura', 'widget-loco' ); ?></p>
                <h2 class="LOCO_form_header_title"><?php esc_html_e( 'La tua candidatura', 'widget-loco' ); ?></h2>
                <p style="color:var(--text-muted); font-size:14px">
                    <?php
                    if ( isset( $name ) && $name ) {
                        printf(
                            /* translators: %s: nome utente */
                            esc_html__( 'Benvenuto, %s!', 'widget-loco' ),
                            '<strong>' . esc_html( $name ) . '</strong>'
                        );
                        echo ' ';
                    }
                    ?>
                    <?php esc_html_e( 'Hai tempo fino al', 'widget-loco' ); ?>
                    <strong><?php esc_html_e( '28 luglio 2026 ore 23:59', 'widget-loco' ); ?></strong>
                </p>
            </div>

            <form class="LOCO_code_form" method="post"
                  action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

                <input type="hidden" name="action" value="loco_submit_code">
                <?php wp_nonce_field( 'loco-submit-code', 'loco_code_nonce' ); ?>

                <div class="LOCO_form_grid">

                    <div class="LOCO_codice_loco_field full">
                        <label for="loco_email"><?php esc_html_e( 'Email', 'widget-loco' ); ?></label>
                        <input type="email" id="loco_email" name="email"
                               value="<?php echo isset( $email ) ? esc_attr( $email ) : ''; ?>"
                               readonly>
                    </div>

                    <div class="LOCO_codice_loco_field full">
                        <label for="loco_codice"><?php esc_html_e( 'Codice LOCO *', 'widget-loco' ); ?></label>
                        <input type="text" id="loco_codice" name="codice_loco"
                               placeholder="<?php esc_attr_e( 'INSERISCI IL CODICE', 'widget-loco' ); ?>"
                               maxlength="20" class="LOCO_codice_loco_input" required>
                    </div>

                    <div class="LOCO_codice_loco_field full">
                        <p class="LOCO_form_motivazione_question">
                            "<?php esc_html_e( 'Perché proprio tu dovresti vincere il Closing Party di Gordo al Pacha?', 'widget-loco' ); ?>"
                        </p>
                        <textarea id="loco_motivazione" name="motivazione"
                                  maxlength="500"
                                  placeholder="<?php esc_attr_e( 'Racconta in massimo 500 caratteri perché meriti questa notte…', 'widget-loco' ); ?>"
                                  oninput="document.getElementById('loco_counter').textContent=this.value.length"
                                  required></textarea>
                        <div class="LOCO_form_char_counter">
                            <span id="loco_counter">0</span> / 500 <?php esc_html_e( 'caratteri', 'widget-loco' ); ?>
                        </div>
                    </div>

                    <div class="LOCO_codice_loco_field full">
                        <label class="LOCO_form_privacy_note">
                            <input style="margin-top:3px" type="checkbox" name="privacy" value="1" required>
                            <span>
                                <?php esc_html_e( 'Acconsento al trattamento dei miei dati personali ai sensi del D.Lgs. 196/2003 e del GDPR 2016/679 per la partecipazione al concorso.', 'widget-loco' ); ?>
                                <a href="#" style="color:var(--kk-blue)"><?php esc_html_e( 'Leggi il regolamento completo.', 'widget-loco' ); ?></a>
                            </span>
                        </label>
                    </div>

                </div><!-- .LOCO_form_grid -->

                <button type="submit" class="LOCO_form_btn_submit">
                    🍒 <?php esc_html_e( 'Invia la mia candidatura', 'widget-loco' ); ?>
                </button>
                <p class="LOCO_one_shot_note">
                    <?php esc_html_e( 'Ogni partecipante può inviare una sola candidatura', 'widget-loco' ); ?>
                </p>

            </form>

        </div><!-- .LOCO_form_inner -->
    </div>
    <!-- .LOCO_form_section -->
    <div style="width:100%; position:relative; bottom:0; left:0;">
        <?php include WIDGET_LOCO_PATH . 'public/views/partials/footer.php'; ?>
    </div>
    

</main>
