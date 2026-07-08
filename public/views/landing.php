<?php

if (!defined('ABSPATH')) {
    exit;
}

$loco_cta_url = is_user_logged_in()
    ? add_query_arg( 'view', 'form', get_permalink() )
    : add_query_arg( 'view', 'login', get_permalink() );
?>

<main class="LOCO_main">

    <?php include WIDGET_LOCO_PATH . 'public/views/partials/gifHeader.php'; ?>

    <!-- ── HERO ── -->
    <section id="LOCO_hero" style="background-size: cover; max-height: 700px; background-image:url('<?php echo esc_url( WIDGET_LOCO_URL . 'public/images/sfondorosso.jpg' ); ?>'); overflow: hidden;" class="LOCO_li_hero LOCO_section_background">
        
        <div class="LOCO_li_hero_content">

            <div style="color:white;" class="LOCO_eyebrow"><?php esc_html_e( 'Concorso esclusivo Radio Kiss Kiss', 'widget-loco' ); ?></div>

            <div class="LOCO_li_partner_row">
                <img style="background-color:white;" 
                    class="LOCO_li_kk_mini"
                     src="<?php echo esc_url( WIDGET_LOCO_URL . 'public/images/logo.png' ); ?>"
                     alt="<?php esc_attr_e( 'Kiss Kiss', 'widget-loco' ); ?>">
                <div class="LOCO_li_x_mark">×</div>
                <div style="width: 65px;
                            padding-left: 5px;
                            border: solid 1px white;
                            border-radius: 10px;
                            padding-right: 5px;
                            padding-top: 5px;
                            padding-bottom: 4px;
                            display: flex;
                            justify-content: center;
                            align-items: center;">
                   <p style="color:white; margin: 0; font-family: 'Bebas Neue', sans-serif; font-size: 19px;"> GORDO </p>
                </div>
            </div>
            
            <!-- Quanto sei LOCO image -->
            <div id="quanto_sei_loco" style="width:100%; display:flex; justify-content:center; align-items:center;">
                <img src="<?php echo esc_url( WIDGET_LOCO_URL . 'public/images/quantoseiloco.svg' ); ?>"
                     alt="<?php esc_attr_e( 'Quanto sei LOCO', 'widget-loco' ); ?>"
                     style="width: 100%; max-width: 800px; height: auto;">
            </div>
            
            <!-- Testa Gordo image -->
            <div id="testa_gordo">
                <img src="<?php echo esc_url( WIDGET_LOCO_URL . 'public/images/testa_gordo.png' ); ?>"
                     alt="<?php esc_attr_e( 'Testa Gordo', 'widget-loco' ); ?>">
            </div>

        </div>
    </section>

    <?php include WIDGET_LOCO_PATH . 'public/views/partials/gifHeader.php'; ?>

    <!-- ── COUNTDOWN ── -->
    <section class="LOCO_li_countdown_section">
        <!--<div class="LOCO_li_countdown_bg"
             style="background-image:url('<?php echo esc_url( WIDGET_LOCO_URL . 'public/images/countdown-bg.jpg' ); ?>')"></div> -->
        <div class="LOCO_li_countdown_overlay"></div>
        <div class="LOCO_li_countdown_content">
            <div style="font-size: 18px" class="LOCO_li_deadline_pill">
                <?php 
                    if ( $data['is_abreve_online'] ) {
                        esc_html_e( 'A breve online', 'widget-loco' ); 
                    } elseif ( $data['is_app_active'] ) {
                        esc_html_e( '⏳ Candidati entro il 28 luglio 2026, ore 23:59', 'widget-loco' ); 
                    } 
                ?>
            </div>

            <div class="LOCO_li_countdown" data-deadline=<?php $data['is_abreve_online'] ? print( '"2026-07-20T00:00:00+02:00"' ) : print( '"2026-07-28T23:59:00+02:00"' ); ?>>
                <div>
                    <div class="LOCO_li_num">00</div>
                    <div class="LOCO_li_lab"><?php esc_html_e( 'giorni', 'widget-loco' ); ?></div>
                </div>
                <div>
                    <div class="LOCO_li_num">00</div>
                    <div class="LOCO_li_lab"><?php esc_html_e( 'ore', 'widget-loco' ); ?></div>
                </div>
                <div>
                    <div class="LOCO_li_num">00</div>
                    <div class="LOCO_li_lab"><?php esc_html_e( 'min', 'widget-loco' ); ?></div>
                </div>
                <div>
                    <div class="LOCO_li_num">00</div>
                    <div class="LOCO_li_lab"><?php esc_html_e( 'sec', 'widget-loco' ); ?></div>
                </div>
            </div>
            <?php 
                if ( $data['is_app_active'] ) {

                    $url = esc_url( $loco_cta_url );
                    $content = esc_html__( 'Inserisci il Codice LOCO', 'widget-loco' );

                    echo '
                            <a href="' . $url . '" class="LOCO_li_btn_primary">
                                ' . $content . '
                            </a>
                        ';
                }

                if ( $data['is_abreve_online'] ) {
                    $linkRegolamento = esc_url( WIDGET_LOCO_URL . 'public/docs/Regolamento_ConcorsoIbiza.pdf' );
                    $content = esc_html__( 'Scarica il regolamento', 'widget-loco' );
                    echo '
                            <a href="'.$linkRegolamento.'" download class="LOCO_li_btn_primary">
                                ' . $content . '
                            </a>
                        ';
                }
            
            ?>
           
            <a href="#come-funziona" class="LOCO_li_btn_secondary LOCO_li_btn_secondary--light">
                <?php esc_html_e( 'Come si trova il codice? ↓', 'widget-loco' ); ?>
            </a>
        </div>
    </section>
    


    <!-- ── IL CODICE LOCO ── -->
    <section class="LOCO_li_section LOCO_li_section--tint" id="come-funziona">
        <div class="LOCO_li_section_head">
            <div class="LOCO_eyebrow"><?php esc_html_e( 'Fase 1 · 20–24 luglio', 'widget-loco' ); ?></div>
            <h2><?php esc_html_e( 'Il Codice LOCO', 'widget-loco' ); ?></h2>
            <p><?php esc_html_e( 'Radio Kiss Kiss diffonde in radio 5 elementi, uno alla volta. Ricomponili tutti per sbloccare l\'accesso alla candidatura.', 'widget-loco' ); ?></p>
        </div>
        
        <div class="LOCO_li_code_tiles">
            <div class="LOCO_li_tile">L</div>
            <div class="LOCO_li_tile">O</div>
            <div class="LOCO_li_tile">C</div>
            <div class="LOCO_li_tile LOCO_li_tile--locked">?</div>
            <div class="LOCO_li_tile LOCO_li_tile--locked">?</div>
        </div>
        
    </section>
    <!--
    <section class="LOCO_li_section LOCO_li_section--tint" id="come-funziona">
        <div class="LOCO_li_section_head">
            <div class="LOCO_eyebrow"><?php esc_html_e( 'Fase 1 · 20–24 luglio', 'widget-loco' ); ?></div>
        </div>
        <div style="width:100%; display:flex; justify-content:center; align-items:center; position:relative;">
            <img src="<?php echo esc_url( WIDGET_LOCO_URL . 'public/images/biglietto_loco.svg' ); ?>"
                 alt="<?php esc_attr_e( 'Biglietto loco', 'widget-loco' ); ?>"
                 style="width: 100%; max-width: 800px; height: auto;"/>
        </div>
    </section>
    -->
    <!-- ── COME PARTECIPARE ── -->
    <section style="padding-bottom:50px;" class="LOCO_li_section">
        <div class="LOCO_li_section_head">
            <div class="LOCO_eyebrow"><?php esc_html_e( 'Fase 2 · entro il 28 luglio', 'widget-loco' ); ?></div>
            <h2><?php esc_html_e( 'Come partecipare', 'widget-loco' ); ?></h2>
        </div>
        <div class="LOCO_li_steps">
            <div class="LOCO_li_step">
                <div class="LOCO_li_step_n">1</div>
                <div>
                    <h3><?php esc_html_e( 'Accedi o registrati', 'widget-loco' ); ?></h3>
                    <p><?php esc_html_e( 'Entra nella Community Radio Kiss Kiss (o registrati se non lo sei già).', 'widget-loco' ); ?></p>
                </div>
            </div>
            <div class="LOCO_li_step">
                <div class="LOCO_li_step_n">2</div>
                <div>
                    <h3><?php esc_html_e( 'Inserisci il Codice LOCO', 'widget-loco' ); ?></h3>
                    <p><?php esc_html_e( 'Il codice ricomposto seguendo la programmazione radiofonica.', 'widget-loco' ); ?></p>
                </div>
            </div>
            <div class="LOCO_li_step">
                <div class="LOCO_li_step_n">3</div>
                <div>
                    <h3><?php esc_html_e( 'Racconta perché tocca a te', 'widget-loco' ); ?></h3>
                    <p><?php esc_html_e( 'Rispondi in massimo 500 caratteri: perché dovresti vivere il Closing Party di Gordo al Pacha con Radio Kiss Kiss?', 'widget-loco' ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- ── IL PREMIO ── -->
    <section style="background-image:url('<?php echo esc_url( WIDGET_LOCO_URL . 'public/images/backgroundBiglietti.PNG' ); ?>')" class="LOCO_li_section LOCO_li_section--tint LOCO_premio_backgorund">
        <div class="LOCO_li_section_head">
            <div class="LOCO_eyebrow"><?php esc_html_e( 'Il premio', 'widget-loco' ); ?></div>
            <h2><?php esc_html_e( 'Cosa vinci', 'widget-loco' ); ?></h2>
        </div>
        <div class="LOCO_li_prize_card">
            <div class="LOCO_li_prize_band">
                <div class="LOCO_li_prize_band_label"><?php esc_html_e( 'PACCHETTO VIAGGIO', 'widget-loco' ); ?></div>
                <div class="LOCO_li_prize_band_val"><?php esc_html_e( '2 persone', 'widget-loco' ); ?></div>
            </div>
            <div class="LOCO_li_prize_body">
                <h3><?php esc_html_e( 'Ibiza, 29–30 set. 2026', 'widget-loco' ); ?></h3>
                <div class="LOCO_li_prize_list">
                    <div>
                        <span class="LOCO_li_ico">✈️</span>
                        <?php esc_html_e( 'Volo A/R dall\'Italia (Milano, Roma o Napoli)', 'widget-loco' ); ?>
                    </div>
                    <div>
                        <span class="LOCO_li_ico">🏨</span>
                        <?php esc_html_e( '1 notte in hotel 3 stelle, camera doppia', 'widget-loco' ); ?>
                    </div>
                    <div>
                        <span class="LOCO_li_ico">🍒</span>
                        <?php esc_html_e( '2 ingressi al Closing Party di Gordo al Pacha', 'widget-loco' ); ?>
                    </div>
                    <div>
                        <span class="LOCO_li_ico">🚐</span>
                        <?php esc_html_e( 'Transfer aeroporto–hotel–Pacha A/R', 'widget-loco' ); ?>
                    </div>
                </div>
            </div>
        </div>
       
        <!-- ── BOTTOM CTA ── -->
        <section class="LOCO_li_section">
             <?php 
                if ( $data['is_app_active'] ) {

                    $url = esc_url( $loco_cta_url );
                    $content = esc_html__( 'Inserisci il Codice LOCO', 'widget-loco' );

                    echo '
                            <a href="' . $url . '" class="LOCO_li_btn_primary"  style="max-width:480px; margin:0 auto;">
                                ' . $content . '
                            </a>
                        ';
                }

                if ( $data['is_abreve_online'] ) {
                    $linkRegolamento = esc_url( WIDGET_LOCO_URL . 'public/docs/Regolamento_ConcorsoIbiza.pdf' );
                    $content = esc_html__( 'Scarica il regolamento', 'widget-loco' );
                    echo '
                            <a href="'.$linkRegolamento.'" download class="LOCO_li_btn_primary" style="max-width:480px; margin:0 auto;">
                                ' . $content . '
                            </a>
                        ';
                }
            
            ?>
        </section>
    </section>

    

    <?php include WIDGET_LOCO_PATH . 'public/views/partials/footer.php'; ?>
</main>
