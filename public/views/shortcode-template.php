<?php

if (!defined('ABSPATH')) {
    exit;
}

?>

<div style="width: 100vw; all: initial; display: block; font-family: 'Bebas Neue', sans-serif;">
    <style>
        .loco-widget {
            font-family: 'Inter', sans-serif;
        }

        .loco-widget h1,
        .loco-widget h2,
        .loco-widget h3,
        .loco-widget h4,
        .loco-widget h5,
        .loco-widget h6,
        .loco-widget .hero-title,
        .loco-widget .section-title,
        .loco-widget .prize-title,
        .loco-widget .step-title,
        .loco-widget .step-num,
        .loco-widget .btn-submit,
        .loco-widget .btn-cta {
            font-family: 'Bebas Neue', sans-serif;
        }
    </style>


    <!-- TOPBAR: solo Kiss Kiss -->
    <div class="topbar">
        <img class="topbar-logo-kk" />

    <!-- HERO -->
    <section class="hero">
        <p class="eyebrow">Concorso esclusivo Radio Kiss Kiss</p>

        <div class="hero-logos">
            <div class="logos-section">
                <img class="custom-logo-style" src="<?php echo WIDGET_LOCO_URL . 'public/logo.png'; ?>" alt="Logo Radio Kiss Kiss" />
                <span class="hero-logos-x">×</span>
                <img class="custom-logo-pacha-style" src="<?php echo WIDGET_LOCO_URL . 'public/pacha.svg'; ?>" alt="Logo pacha" />
            </div>
        <div>

        <h1 class="hero-title">
            <span class="line-vinci">VINCI</span>
            <span class="line-ibiza">IBIZA</span>
        </h1>

        <p class="hero-subtitle">
            Vivi il <strong>Closing Party di Gordo al Pacha</strong><br>
            insieme a Radio Kiss Kiss. Un'esperienza unica nell'isola della musica.
        </p>

        <div class="hero-actions">
            <div class="hero-deadline">Candidati entro il 28 luglio 2026 alle 23:59</div>
            <a href="#partecipa" class="btn-cta">Inserisci il Codice LOCO</a>
        </div>
    </section>

    <!-- WAVE -->
    <div class="wave-divider">
        <svg viewBox="0 0 1440 50" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
            <path d="M0,25 C360,50 720,0 1080,25 C1260,38 1380,20 1440,25 L1440,50 L0,50 Z" fill="#f4f8fb" />
        </svg>
    </div>

    <!-- STEPS -->
    <div class="section">
        <p class="section-label">Come partecipare</p>
        <h2 class="section-title">Tre passi verso Ibiza</h2>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">01</div>
                <div class="step-title">Ascolta Kiss Kiss</div>
                <div class="step-desc">Sintonizzati su Radio Kiss Kiss e individua il <strong>Codice LOCO</strong> trasmesso in onda. Tienilo pronto: ti servirà per candidarti.</div>
            </div>
            <div class="step-card">
                <div class="step-num">02</div>
                <div class="step-title">Registrati o accedi</div>
                <div class="step-desc">Accedi alla Community Radio Kiss Kiss o crea il tuo account gratuitamente. Un solo profilo, un'unica candidatura.</div>
            </div>
            <div class="step-card">
                <div class="step-num">03</div>
                <div class="step-title">Convinci noi</div>
                <div class="step-desc">Compila il modulo con i tuoi dati e il Codice LOCO. Poi rispondi: perché proprio tu meriti di vivere questa notte al Pacha?</div>
            </div>
        </div>
    </div>

    <!-- FORM -->
    <div class="form-section" id="partecipa">
        <div class="form-inner">
            <div class="form-header">
                <p class="section-label">Fase 2 – Candidatura</p>
                <h2 class="section-title" style="margin-bottom:8px">La tua candidatura</h2>
                <p style="color:var(--text-muted); font-size:14px">Hai tempo fino al <strong style="color:var(--text)">28 luglio 2026 ore 23:59</strong></p>
            </div>
            <form onsubmit="return false;">
                <div class="form-grid">
                    <div class="field">
                        <label>Nome *</label>
                        <input type="text" placeholder="Il tuo nome">
                    </div>
                    <div class="field">
                        <label>Cognome *</label>
                        <input type="text" placeholder="Il tuo cognome">
                    </div>
                    <div class="field">
                        <label>Email *</label>
                        <input type="email" placeholder="nome@email.com">
                    </div>
                    <div class="field">
                        <label>Telefono *</label>
                        <input type="tel" placeholder="+39 000 000 0000">
                    </div>
                    <div class="field full codice-loco-field">
                        <label>Codice LOCO *</label>
                        <input type="text" placeholder="INSERISCI IL CODICE" maxlength="20" id="codice-input">
                    </div>
                    <div class="field full">
                        <p class="motivazione-question">"Perché proprio tu dovresti vivere il Closing Party di Gordo al Pacha insieme a Radio Kiss Kiss?"</p>
                        <textarea id="motivazione" maxlength="500" placeholder="Racconta in massimo 500 caratteri perché meriti questa notte…" oninput="updateCounter()"></textarea>
                        <div class="char-counter"><span id="counter">0</span> / 500 caratteri</div>
                    </div>
                    <div class="field full">
                        <label class="privacy-note">
                            <input type="checkbox">
                            <span>Acconsento al trattamento dei miei dati personali ai sensi del D.Lgs. 196/2003 e del GDPR 2016/679 per la partecipazione al concorso. <a href="#" style="color:var(--kk-blue)">Leggi il regolamento completo.</a></span>
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn-submit">🍒 Invia la mia candidatura</button>
                <p class="one-shot-note">Ogni partecipante può inviare una sola candidatura</p>
            </form>
        </div>
    </div>

    <!-- PRIZE -->
    <div class="prize-section">
        <div class="prize-card">
            <div class="prize-tag">Il Premio</div>
            <h2 class="prize-title">Una Notte al Pacha di Ibiza<br>con Radio Kiss Kiss</h2>
            <p class="prize-subtitle">Vivi il leggendario <strong>Closing Party di Gordo</strong> nel club più iconico di Ibiza, ospite esclusivo di Radio Kiss Kiss.</p>
            <div class="prize-details">
                <div class="prize-item">
                    <span class="label">Viaggio</span>
                    <span class="value">Incluso</span>
                </div>
                <div class="prize-divider"></div>
                <div class="prize-item">
                    <span class="label">Ingresso</span>
                    <span class="value">Pacha Ibiza</span>
                </div>
                <div class="prize-divider"></div>
                <div class="prize-item">
                    <span class="label">Artista</span>
                    <span class="value">Gordo</span>
                </div>
                <div class="prize-divider"></div>
                <div class="prize-item">
                    <span class="label">Con</span>
                    <span class="value">Kiss Kiss</span>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <p>
            © 2026 Radio Kiss Kiss. Concorso valido fino al 28/07/2026 ore 23:59.<br>
            Iniziativa soggetta al regolamento disponibile su <a href="#">www.kisskiss.it</a>. Vietato ai minori di 18 anni.<br>
            Radio Kiss Kiss non è affiliata a Pacha Ibiza. Tutti i marchi citati sono di proprietà dei rispettivi titolari.
        </p>
    </footer>

    <script>
        function updateCounter() {
            document.getElementById('counter').textContent = document.getElementById('motivazione').value.length;
        }
        document.getElementById('codice-input').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });
        document.querySelector('.btn-cta').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('partecipa').scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>
</div>

