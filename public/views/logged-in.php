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

            <?php if ( ! empty( $already_submitted ) ) : ?>

                <div class="LOCO_form_header" style="text-align:center; padding: 40px 0;">
                    <p class="LOCO_form_header_label"><?php esc_html_e( 'Candidatura inviata', 'widget-loco' ); ?></p>
                    <h2 class="LOCO_already_candidate_header">🍒 <?php esc_html_e( 'Hai già partecipato!', 'widget-loco' ); ?></h2>
                    <p class="LOCO_form_header_subtitle">
                        <?php esc_html_e( 'La tua candidatura è stata ricevuta. Ti contatteremo presto se sei tra i selezionati.', 'widget-loco' ); ?>
                    </p>
                </div>

            <?php else : ?>

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

            <?php $already_submitted = isset( $already_submitted ) ? $already_submitted : false; ?>

            <form class="LOCO_code_form">

                    <div class="LOCO_form_grid">
                        <!-- Nome -->
                        <div class="LOCO_codice_loco_field full">
                            <label for="loco_nome"><?php esc_html_e( 'Nome *', 'widget-loco' ); ?></label>
                            <input type="text" id="loco_nome" name="nome"
                                value="<?php echo isset( $nome ) ? esc_attr( $nome ) : ''; ?>"
                                required>
                        </div>
                        <!-- Cognome -->
                        <div class="LOCO_codice_loco_field full">
                            <label for="loco_cognome"><?php esc_html_e( 'Cognome *', 'widget-loco' ); ?></label>
                            <input type="text" id="loco_cognome" name="cognome"
                                value="<?php echo isset( $cognome ) ? esc_attr( $cognome ) : ''; ?>"
                                required>
                        </div>
                        <!-- Cellulare -->
                        <div class="LOCO_codice_loco_field full">
                            <label for="loco_cellulare"><?php esc_html_e( 'Cellulare', 'widget-loco' ); ?></label>
                            <input type="text" id="loco_cellulare" name="cellulare"
                                value="<?php echo isset( $cellulare ) ? esc_attr( $cellulare ) : ''; ?>"
                                >
                        </div>
                        <!-- Email -->
                        <div class="LOCO_codice_loco_field full">
                            <label for="loco_email"><?php esc_html_e( 'Email', 'widget-loco' ); ?></label>
                            <input type="email" id="loco_email" name="email"
                                value="<?php echo isset( $email ) ? esc_attr( $email ) : ''; ?>"
                                readonly>
                        </div>
                        <!-- URL Social -->
                        <div class="LOCO_codice_loco_field full">
                            <label for="loco_urlSocial"><?php esc_html_e( 'URL Social', 'widget-loco' ); ?></label>
                            <input type="text" id="loco_urlSocial" name="urlSocial"
                                value="<?php echo isset( $urlSocial ) ? esc_attr( $urlSocial ) : ''; ?>"
                                >
                        </div>
                    </div><!-- .LOCO_form_grid -->  
                    <!-- Codice Loco -->
                    <div style="width: 100%;
                        display: flex;
                        flex-direction: column;
                        gap: 12px;
                        margin-top: 30px;
                        margin-bottom: 30px;
                        background-color: white;
                        padding: 20px;
                        border-radius: 10px;
                        border: 1px solid #00000014;">
                        <div class="LOCO_codice_loco_field full">
                            <label for="loco_codice_1"><?php esc_html_e( 'Codice LOCO *', 'widget-loco' ); ?></label>
                            <input type="text" id="loco_codice_1" name="codice_loco_1"
                                placeholder="<?php esc_attr_e( 'PRIMO CODICE', 'widget-loco' ); ?>"
                                maxlength="20" class="LOCO_codice_loco_input" required>
                        </div>

                        <div class="LOCO_codice_loco_field full">
                            <input type="text" id="loco_codice_2" name="codice_loco_2"
                                placeholder="<?php esc_attr_e( 'SECONDO CODICE', 'widget-loco' ); ?>"
                                maxlength="20" class="LOCO_codice_loco_input" required>
                        </div>
                        
                        <div class="LOCO_codice_loco_field full">
                            <input type="text" id="loco_codice_3" name="codice_loco_3"
                                placeholder="<?php esc_attr_e( 'TERZO CODICE', 'widget-loco' ); ?>"
                                maxlength="20" class="LOCO_codice_loco_input" required>
                        </div>

                        <div class="LOCO_codice_loco_field full">
                            <input type="text" id="loco_codice_4" name="codice_loco_4"
                                placeholder="<?php esc_attr_e( 'QUARTO CODICE', 'widget-loco' ); ?>"
                                maxlength="20" class="LOCO_codice_loco_input" required>
                        </div>

                        <div class="LOCO_codice_loco_field full">
                            <input type="text" id="loco_codice_5" name="codice_loco_5"
                                placeholder="<?php esc_attr_e( 'QUINTO CODICE', 'widget-loco' ); ?>"
                                maxlength="20" class="LOCO_codice_loco_input" required>
                        </div>
                    </div>

                    <!-- Motivazione -->
                    <div class="LOCO_codice_loco_field full">
                        <p class="LOCO_form_motivazione_question">
                            "<?php esc_html_e( 'Perché proprio tu dovresti vincere il Closing Party di Gordo al Pacha?', 'widget-loco' ); ?>"
                        </p>
                        <textarea style="border-radius: 10px; border: 1px solid #00000014;"
                                  id="loco_motivazione" 
                                  name="motivazione"
                                  maxlength="500"
                                  placeholder="<?php esc_attr_e( 'Racconta in massimo 500 caratteri perché meriti questa notte…', 'widget-loco' ); ?>"
                                  oninput="document.getElementById('loco_counter').textContent=this.value.length"
                                  required></textarea>
                        <div class="LOCO_form_char_counter">
                            <span id="loco_counter">0</span> / 500 <?php esc_html_e( 'caratteri', 'widget-loco' ); ?>
                        </div>
                    </div>

                    <!-- Agreement -->
                    <div class="LOCO_codice_loco_field full">
                        <label class="LOCO_form_privacy_note">
                            <input style="margin-top:3px" type="checkbox" name="privacy" value="1" required>
                            <span>
                                <?php esc_html_e( 'Acconsento al trattamento dei miei dati personali ai sensi del D.Lgs. 196/2003 e del GDPR 2016/679 per la partecipazione al concorso.', 'widget-loco' ); ?>
                                <a href="#" style="color:var(--kk-blue)"><?php esc_html_e( 'Leggi il regolamento completo.', 'widget-loco' ); ?></a>
                            </span>
                        </label>
                        <label class="LOCO_form_privacy_note">
                            <input style="margin-top:3px" type="checkbox" name="age" value="1" required>
                            <span>
                                <?php esc_html_e( 'Dichiaro di avere almeno 18 anni.', 'widget-loco' ); ?>
                            </span>
                        </label>
                        <label class="LOCO_form_privacy_note">
                            <input style="margin-top:3px" type="checkbox" name="residenza" value="1" required>
                            <span>
                                <?php esc_html_e( 'Dichiaro di essere residente in Italia o nella Repubblica di San Marino.', 'widget-loco' ); ?>
                            </span>
                        </label>                       
                    </div>

                    <button type="submit" class="LOCO_form_btn_submit">
                        🍒 <?php esc_html_e( 'Invia la mia candidatura', 'widget-loco' ); ?>
                    </button>
                
                    <p class="LOCO_one_shot_note">
                        <?php esc_html_e( 'Ogni partecipante può inviare una sola candidatura', 'widget-loco' ); ?>
                    </p>
            </form>

            <?php endif; ?>

        </div><!-- .LOCO_form_inner -->
    </div>
    <!-- .LOCO_form_section -->
    <div style="width:100%; position:absolute; bottom:0; left:0;">
        <?php include WIDGET_LOCO_PATH . 'public/views/partials/footer.php'; ?>
    </div>
    

</main>
