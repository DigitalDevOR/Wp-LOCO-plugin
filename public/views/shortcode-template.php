<?php

if (!defined('ABSPATH')) {
    exit;
}

?>

<main class="LOCO_main">
    <!-- Header section -->
    <header class="LOCO_header">
        <img src="<?php echo esc_url(WIDGET_LOCO_URL . 'public/images/logo.png'); ?>" alt="Kiss Kiss logo" class="LOCO_header_img">
    </header>

    <!-- Vinci Ibiza section -->
    <section class="LOCO_vinci_Ibiza">
        <!--Testo  -->
        <div style="margin-bottom:16px" class="LOCO_centered_p">
            <p class="LOCO_eyebrow">Concorso esclusivo Radio Kiss Kiss</p>
        </div>
        <!-- Loghi -->
        <div class="LOCO_loghi">
            <img src="<?php echo esc_url(WIDGET_LOCO_URL . 'public/images/logo.png'); ?>" alt="Kiss Kiss logo" class="LOCO_eyebrow_KK">
            <img src="<?php echo esc_url(WIDGET_LOCO_URL . 'public/icons/cross.svg'); ?>" alt="Cross icon" class="LOCO_eyebrow_cross">
            <img src="<?php echo esc_url(WIDGET_LOCO_URL . 'public/images/pacha.svg'); ?>" alt="Ibiza logo" class="LOCO_eyebrow_Pacha">
        </div>
        <!-- VINCI IBIZA -->
        <h1 class="LOCO_title">
            <span class="LOCO_title_vinci">
                Vinci
            </span>
            <span class="LOCO_title_ibiza">
                Ibiza
            </span>
        </h1>
        <!-- Subtitle -->
        <p class="LOCO_subtitle">
            Vivi il <strong>Closing Party di Gordo al Pacha</strong><br>
            insieme a Radio Kiss Kiss. Un'esperienza unica nell'isola della musica.
        </p>
        <!-- Cta section -->
        <div class="LOCO_flex_centered_col">
            <div class="LOCO_deadline">Candidati entro il 28 luglio 2026 alle 23:59</div>
            <a href="#partecipa" class="LOCO_cta">Inserisci il Codice LOCO</a>
        </div>
    </section>
    <!-- Tre passi verso Ibiza section -->
    <section>
        <!-- wave divider -->
        <div class="wave-divider">
            <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0,25 C360,50 720,0 1080,25 C1260,38 1380,20 1440,25 L1440,50 L0,50 Z" fill="#f4f8fb"></path>
            </svg>
        </div>
        <!-- steps -->
        <div class="LOCO_tre_steps_section">
            <p class="LOCO_steps_label">Come partecipare</p>
            <h2 class="LOCO_steps_title">Tre passi verso Ibiza</h2>
            <div class="LOCO_steps_grid">
                <div class="LOCO_steps_card">
                    <div class="LOCO_steps_card_num">01</div>
                    <div class="LOCO_steps_card_title">Ascolta Kiss Kiss</div>
                    <div class="LOCO_steps_card_desc">Sintonizzati su Radio Kiss Kiss e individua il <strong>Codice LOCO</strong> trasmesso in onda. Tienilo pronto: ti servirà per candidarti.</div>
                </div>
                <div class="LOCO_steps_card">
                    <div class="LOCO_steps_card_num">02</div>
                    <div class="LOCO_steps_card_title">Registrati o accedi</div>
                    <div class="LOCO_steps_card_desc">Accedi alla Community Radio Kiss Kiss o crea il tuo account gratuitamente. Un solo profilo, un'unica candidatura.</div>
                </div>
                <div class="LOCO_steps_card">
                    <div class="LOCO_steps_card_num">03</div>
                    <div class="LOCO_steps_card_title">Convinci noi</div>
                    <div class="LOCO_steps_card_desc">Compila il modulo con i tuoi dati e il Codice LOCO. Poi rispondi: perché proprio tu meriti di vivere questa notte al Pacha?</div>
                </div>
            </div>
        </div>
    </section>
    <!-- Form Section -->
    <div class="LOCO_form_section" id="partecipa">
        <div class="LOCO_form_inner">
            <div class="LOCO_form_header">
                <p class="LOCO_form_header_label">Fase 2 – Candidatura</p>
                <h2 class="LOCO_form_header_title" style="margin-bottom:8px">La tua candidatura</h2>
                <p style="color:var(--text-muted); font-size:14px">Hai tempo fino al <strong style="color:var(--text)">28 luglio 2026 ore 23:59</strong></p>
            </div>
            <form onsubmit="return false;">
                <div class="LOCO_form_grid">
                    <div class="LOCO_codice_loco_field">
                        <label>Nome *</label>
                        <input type="text" placeholder="Il tuo nome">
                    </div>
                    <div class="LOCO_codice_loco_field">
                        <label>Cognome *</label>
                        <input type="text" placeholder="Il tuo cognome">
                    </div>
                    <div class="LOCO_codice_loco_field">
                        <label>Email *</label>
                        <input type="email" placeholder="nome@email.com">
                    </div>
                    <div class="LOCO_codice_loco_field">
                        <label>Telefono *</label>
                        <input type="tel" placeholder="+39 000 000 0000">
                    </div>
                    <div class="LOCO_codice_loco_field full">
                        <label>Codice LOCO *</label>
                        <input type="text" placeholder="INSERISCI IL CODICE" maxlength="20" id="codice-input" class="LOCO_codice_loco_input">
                    </div>
                    <div class="LOCO_codice_loco_field full">
                        <p class="LOCO_form_motivazione_question">"Perché proprio tu dovresti vivere il Closing Party di Gordo al Pacha insieme a Radio Kiss Kiss?"</p>
                        <textarea id="motivazione" maxlength="500" placeholder="Racconta in massimo 500 caratteri perché meriti questa notte…" oninput="updateCounter()"></textarea>
                        <div class="LOCO_form_char_counter"><span id="counter">0</span> / 500 caratteri</div>
                    </div>
                    <div class="LOCO_codice_loco_field full">
                        <label class="LOCO_form_privacy_note">
                            <input style="margin-top: 3px;" type="checkbox">
                            <span>Acconsento al trattamento dei miei dati personali ai sensi del D.Lgs. 196/2003 e del GDPR 2016/679 per la partecipazione al concorso. <a href="#" style="color:var(--kk-blue)">Leggi il regolamento completo.</a></span>
                        </label>
                    </div>
                </div>
                <button type="submit" class="LOCO_form_btn_submit">🍒 Invia la mia candidatura</button>
                <p class="LOCO_one_shot_note">Ogni partecipante può inviare una sola candidatura</p>
            </form>
        </div>
    </div>
    <!-- Prize section -->
    <div class="LOCO_prize_section">
        <div class="LOCO_prize_card">
            <div class="LOCO_prize_tag">Il Premio</div>
            <h2 class="LOCO_prize_title">Una Notte al Pacha di Ibiza<br>con Radio Kiss Kiss</h2>
            <p class="LOCO_prize_subtitle">Vivi il leggendario <strong>Closing Party di Gordo</strong> nel club più iconico di Ibiza, ospite esclusivo di Radio Kiss Kiss.</p>
            <div class="LOCO_prize_details">
                <div class="LOCO_prize_item">
                    <span class="LOCO_prize_item_label">Viaggio</span>
                    <span class="LOCO_prize_item_value">Incluso</span>
                </div>
                <div class="LOCO_prize_item_divider"></div>
                <div class="LOCO_prize_item">
                    <span class="LOCO_prize_item_label">Ingresso</span>
                    <span class="LOCO_prize_item_value">Pacha Ibiza</span>
                </div>
                <div class="LOCO_prize_item_divider"></div>
                <div class="LOCO_prize_item">
                    <span class="LOCO_prize_item_label">Artista</span>
                    <span class="LOCO_prize_item_value">Gordo</span>
                </div>
                <div class="LOCO_prize_item_divider"></div>
                <div class="LOCO_prize_item">
                    <span class="LOCO_prize_item_label">Con</span>
                    <span class="LOCO_prize_item_value">Kiss Kiss</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
     <footer class="LOCO_footer">
        <p>
            © 2026 Radio Kiss Kiss. Concorso valido fino al 28/07/2026 ore 23:59.<br>
            Iniziativa soggetta al regolamento disponibile su <a href="https://www.kisskiss.it">www.kisskiss.it</a>. Vietato ai minori di 18 anni.<br>
            Radio Kiss Kiss non è affiliata a Pacha Ibiza. Tutti i marchi citati sono di proprietà dei rispettivi titolari.
        </p>
    </footer>

</main>