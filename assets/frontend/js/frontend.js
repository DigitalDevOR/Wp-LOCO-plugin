document.addEventListener('DOMContentLoaded', () => {
    console.log('Widget Loco frontend.js loaded');
    // ── COUNTDOWN ──
    const countdownEl = document.querySelector('.LOCO_li_countdown');
    if (countdownEl) {
        const deadline = new Date(countdownEl.dataset.deadline).getTime();
        const nums = countdownEl.querySelectorAll('.LOCO_li_num');

        function updateCountdown() {
            const now = Date.now();
            const diff = deadline - now;

            if (diff <= 0) {
                nums[0].textContent = '00';
                nums[1].textContent = '00';
                nums[2].textContent = '00';
                nums[3].textContent = '00';
                return;
            }

            const days    = Math.floor(diff / 86400000);
            const hours   = Math.floor((diff % 86400000) / 3600000);
            const minutes = Math.floor((diff % 3600000) / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);

            nums[0].textContent = String(days).padStart(2, '0');
            nums[1].textContent = String(hours).padStart(2, '0');
            nums[2].textContent = String(minutes).padStart(2, '0');
            nums[3].textContent = String(seconds).padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    const form = document.querySelector('.LOCO_code_form');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const btn = form.querySelector('.LOCO_form_btn_submit');
        if (btn) {
            btn.disabled = true;
            btn.textContent = 'Invio in corso…';
        }

        const data = Object.fromEntries(new FormData(form).entries());

        try {
            const response = await fetch(WidgetLoco.restUrl + '/submit-form', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': WidgetLoco.restNonce,
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();

            if (response.ok && result.success) {
                form.innerHTML = '<p class="LOCO_form_success">' + (result.message || 'Candidatura inviata con successo!') + '</p>';
            } else {
                const msg = result.message || 'Si è verificato un errore. Riprova.';
                showFormError(form, msg);
                if (btn) { btn.disabled = false; btn.textContent = '🍒 Invia la mia candidatura'; }
            }
        } catch (err) {
            showFormError(form, 'Errore di rete. Controlla la connessione e riprova.');
            if (btn) { btn.disabled = false; btn.textContent = '🍒 Invia la mia candidatura'; }
        }
    });

    function showFormError(form, message) {
        let el = form.querySelector('.LOCO_form_error');
        if (!el) {
            el = document.createElement('p');
            el.className = 'LOCO_form_error';
            form.prepend(el);
        }
        el.textContent = message;
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});


let LOCOParallaxTicking = false;
let LOCOParallaxStart = -100;
let LOCOParallaxEnd = 0;

const LOCO_START_TESTA = 100;
const LOCO_DISTANZA = 150;

const LOCO_DISTANZA_QUANTO = 150;
const LOCO_DISTANZA_TESTA = 300;

function clamp(value, min, max) {
    return Math.min(Math.max(value, min), max);
}

function getParallaxConfig() {

    const width = window.innerWidth;

    if (width <= 441) {
        return {
            startTesta: 350,
            moveQuanto: 600,
            moveTesta: 400,
            maxQuanto: 335,
            maxTesta: 80
        };
    }

    if (width <= 480) {
        return {
            startTesta: 300,
            moveQuanto: 400,
            moveTesta: 400,
            maxQuanto: 215,
            maxTesta: 170
        };
    }

    if (width <= 768) {
        return {
            startTesta: 180,
            moveQuanto: 600,
            moveTesta: 300,
            maxQuanto: 440,
            maxTesta: -20
        };
    }

    if (width <= 1024) {
        return {
            startTesta: 220,
            moveQuanto: 600,
            moveTesta: 400,
            maxQuanto: 360,
            maxTesta: 0
        };
    }

    return {
        startTesta: 340,
        moveQuanto: 600,
        moveTesta: 500,
        maxQuanto: 500,
        maxTesta: 80
    };
}

function setupParallax() {
    const section = document.querySelector(".LOCO_li_hero");
    if (!section) return;

    const sectionTop = section.offsetTop;
    const sectionHeight = section.offsetHeight;

    LOCOParallaxStart = sectionTop;
    LOCOParallaxEnd = sectionTop + sectionHeight;
}

function handleParallax() {
    const quanto = document.getElementById("quanto_sei_loco");
    const testa = document.getElementById("testa_gordo");

    if (!quanto || !testa) return;

    const config = getParallaxConfig();
    const scrollY = window.scrollY;

    const progress = clamp(
        (scrollY - LOCOParallaxStart) /
        (LOCOParallaxEnd - LOCOParallaxStart),
        0,
        1
    );

    let quantoY = progress * config.moveQuanto;
    let testaY = config.startTesta - progress * config.moveTesta;

    quantoY = clamp(quantoY, 0, config.maxQuanto);
    testaY = clamp(testaY, config.maxTesta, config.startTesta);

    quanto.style.transform = `translateY(${quantoY}px)`;
    testa.style.transform = `translateY(${testaY}px)`;
}

function handleScroll(e) {
    e.preventDefault();
    console.log('Scroll event detected');
    if (LOCOParallaxTicking) return;

    LOCOParallaxTicking = true;

    requestAnimationFrame(() => {
        handleParallax();
        LOCOParallaxTicking = false;
    });
}

document.addEventListener("DOMContentLoaded", () => {
    setupParallax();

    window.addEventListener("scroll", handleScroll);

    window.addEventListener("resize", () => {
        setupParallax();
        handleParallax();
    });

    handleParallax();
});
