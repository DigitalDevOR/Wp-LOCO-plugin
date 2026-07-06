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