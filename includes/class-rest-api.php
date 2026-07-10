<?php

namespace Widget_Loco\Includes;
use Widget_Loco\Includes\Send_Email;

if (!defined('ABSPATH')) {
    exit;
}

class Rest_Api
{
    /**
     * Registra gli hook REST API e le azioni per la registrazione utenti.
     */
    public function register(): void
    {
        add_action('rest_api_init', [$this, 'registerRoutes']);
        add_action('admin_post_nopriv_loco_register', [$this, 'handleRegistration']);
        add_action('admin_post_loco_register',        [$this, 'handleRegistration']);

        // Rimanda i login falliti alla form custom invece di wp-login.php
        add_action('wp_login_failed', [$this, 'redirectFailedLogin'], 10, 2);

        add_filter('rest_pre_serve_request', [$this, 'serveHtmlResponse'], 10, 4);
    }

    /**
     * Registra gli endpoint del plugin.
     */
    public function registerRoutes(): void
    {
        register_rest_route('widget-loco/v1', '/test', [
            'methods'             => 'POST',
            'callback'            => [$this, 'handleTest'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('widget-loco/v1', '/submit-form', [
            'methods'             => 'POST',
            'callback'            => [$this, 'handleLocoForm'],
            'permission_callback' => '__return_true',
        ]);

        register_rest_route('widget-loco/v1', '/candidature', [
            'methods'             => 'GET',
            'callback'            => [$this, 'getCandidature'],
            'permission_callback' => '__return_true',
        ]);
        
        register_rest_route('widget-loco/v1', '/candidature-login', [
            'methods'             => 'POST',
            'callback'            => [$this, 'candidatureLogin'],
            'permission_callback' => '__return_true',
        ]);
    }

    /**
     * Intercetta i login falliti da wp-login.php e reindirizza alla form custom.
     * Distingue errori di verifica email (uv_authentication_failed) da credenziali errate.
     */
    public function redirectFailedLogin(string $username, \WP_Error $error): void
    {
        $redirect_to = isset($_POST['redirect_to'])
            ? esc_url_raw(wp_unslash($_POST['redirect_to']))
            : '';

        // Intercetta solo le richieste provenienti dalla nostra form custom
        if (empty($redirect_to) || strpos($redirect_to, 'wp-login.php') !== false) {
            return;
        }

        $err_codes = $error->get_error_codes();
        $err_param = 'credentials';

        foreach ($err_codes as $code) {
            if ($code === 'uv_authentication_failed') {
                $err_param = 'verify_email';
                break;
            }
        }

        // Reindirizza alla pagina guest con ?view=login e il messaggio di errore
        $login_url = add_query_arg('view', 'login', $redirect_to);
        wp_safe_redirect(
            add_query_arg(['login' => 'failed', 'err' => $err_param], $login_url)
        );
        exit;
    }

    /**
     * Gestisce la richiesta POST /wp-json/widget-loco/v1/test.
     */
    public function handleTest(\WP_REST_Request $request): \WP_REST_Response
    {
        $message = sanitize_text_field($request->get_param('message'));

        return new \WP_REST_Response([
            'success' => true,
            'message' => 'Risposta dal backend WordPress',
            'received' => $message,
        ], 200);
    }

    /**
     * Processa il form di registrazione via admin-post.php.
     * Crea utenti con ruolo subscriber (permessi minimi).
     */
    public function handleRegistration(): void
    {
        $checkDate = new CheckDate();

        if ($checkDate->getIsConcorsoTerminato() || $checkDate->getIsAbreveOnline() || ! $checkDate->getIsAppActive()) {
            wp_safe_redirect(get_permalink());
            exit;
        }

        $redirect_to = isset($_POST['redirect_to'])
            ? esc_url_raw(wp_unslash($_POST['redirect_to']))
            : home_url();

        $register_url = add_query_arg(
            ['view' => 'login', 'action' => 'register'],
            $redirect_to
        );

        // Controlla se la registrazione è abilitata in WordPress
        if (! get_option('users_can_register')) {
            wp_safe_redirect(add_query_arg(['reg' => 'error', 'err' => 'disabled'], $register_url));
            exit;
        }

        $username = isset($_POST['reg_username']) ? sanitize_user(wp_unslash($_POST['reg_username'])) : '';
        $email    = isset($_POST['reg_email'])    ? sanitize_email(wp_unslash($_POST['reg_email']))    : '';
        $password = isset($_POST['reg_password']) ? wp_unslash($_POST['reg_password'])                 : '';
        $confirm  = isset($_POST['reg_confirm'])  ? wp_unslash($_POST['reg_confirm'])                  : '';

        // Campi obbligatori
        if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
            wp_safe_redirect(add_query_arg(['reg' => 'error', 'err' => 'empty'], $register_url));
            exit;
        }

        // Formato email
        if (! is_email($email)) {
            wp_safe_redirect(add_query_arg(['reg' => 'error', 'err' => 'email'], $register_url));
            exit;
        }

        // Corrispondenza password
        if ($password !== $confirm) {
            wp_safe_redirect(add_query_arg(['reg' => 'error', 'err' => 'password_mismatch'], $register_url));
            exit;
        }

        // Lunghezza minima password
        if (strlen($password) < 8) {
            wp_safe_redirect(add_query_arg(['reg' => 'error', 'err' => 'password_short'], $register_url));
            exit;
        }

        // Username già in uso
        if (username_exists($username)) {
            wp_safe_redirect(add_query_arg(['reg' => 'error', 'err' => 'user_exists'], $register_url));
            exit;
        }

        // Email già in uso
        if (email_exists($email)) {
            wp_safe_redirect(add_query_arg(['reg' => 'error', 'err' => 'email_exists'], $register_url));
            exit;
        }

        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
            wp_safe_redirect(add_query_arg(['reg' => 'error', 'err' => 'create'], $register_url));
            exit;
        }

        // Imposta ruolo subscriber (permessi minimi)
        $user = new \WP_User($user_id);
        $user->set_role('community');

        // Auto-login immediato
        // wp_set_current_user($user_id);
        // wp_set_auth_cookie($user_id, false);

        // Reindirizza alla form del codice LOCO
        $login_url = add_query_arg(
        [
            'view'   => 'login',
            'action' => 'login',
        ],
            $redirect_to
        );

        wp_safe_redirect($login_url);
        exit;
    }

    /**
     * Gestisce il form di candidatura via REST API.
     */
    public function handleLocoForm(\WP_REST_Request $request): \WP_REST_Response
    {
        
        $checkDate = new CheckDate();

        if ($checkDate->getIsConcorsoTerminato() || $checkDate->getIsAbreveOnline() || ! $checkDate->getIsAppActive()) {
            wp_safe_redirect(get_permalink());
            exit;
        }


        $user = wp_get_current_user();

        if ($user->ID === 0) {
            return new \WP_REST_Response([
                'success' => false,
                'message' => 'Utente non loggato.',
            ], 401);
        }

        $userMail    = $user->user_email;
        $email       = sanitize_email($request->get_param('email') ?? '');
        $nome        = sanitize_text_field($request->get_param('nome') ?? '');
        $cognome     = sanitize_text_field($request->get_param('cognome') ?? '');
        $codice_1    = sanitize_text_field($request->get_param('codice_loco_1') ?? '');
        $codice_2    = sanitize_text_field($request->get_param('codice_loco_2') ?? '');
        $codice_3    = sanitize_text_field($request->get_param('codice_loco_3') ?? '');
        $codice_4    = sanitize_text_field($request->get_param('codice_loco_4') ?? '');
        $codice_5    = sanitize_text_field($request->get_param('codice_loco_5') ?? '');
        $motivazione = sanitize_textarea_field($request->get_param('motivazione') ?? '');
        $urlSocial   = trim(wp_strip_all_tags(wp_unslash((string) ($request->get_param('urlSocial') ?? ''))));
        $privacy     = (bool) $request->get_param('privacy');
        $age         = (bool) $request->get_param('age');
        $residenza   = (bool) $request->get_param('residenza');

        // Campi obbligatori
        if (empty($email) || empty($nome) || empty($cognome) || empty($codice_1) || empty($motivazione) || empty($urlSocial) || ! $privacy || ! $age || ! $residenza) {
            return new \WP_REST_Response([
                'success' => false,
                'message' => 'Compila tutti i campi obbligatori.',
            ], 422);
        }

        // L'email deve corrispondere a quella dell'utente loggato
        if ($userMail !== $email) {
            return new \WP_REST_Response([
                'success' => false,
                'message' => 'Impossibile partecipare al concorso.',
            ], 422);
        }

        if (! is_email($email)) {
            return new \WP_REST_Response([
                'success' => false,
                'message' => 'Indirizzo email non valido.',
            ], 422);
        }

        // Validazione URL social (Instagram o Facebook)
        if (! $this->isValidSocialUrl($urlSocial)) {
            return new \WP_REST_Response([
                'success' => false,
                'message' => 'Inserisci un URL valido di Instagram o Facebook.',
            ], 422);
        }

        // Controlla se l'utente ha già inviato una candidatura
        if (Database::userHasSubmitted($user->ID)) {
            return new \WP_REST_Response([
                'success' => false,
                'message' => 'Hai già inviato una candidatura.',
            ], 409);
        }

        // Calcolo validated
        $validated = $privacy
            && $age
            && $residenza
            && ! empty($motivazione)
            && $this->areCodesValid($codice_1, $codice_2, $codice_3, $codice_4, $codice_5)
            && $this->isValidSocialUrl($urlSocial);

        // Salvataggio nel database
        $ip = isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '';

        $inserted = Database::insertCandidatura([
            'user_id'       => $user->ID,
            'nome'          => $nome,
            'cognome'       => $cognome,
            'email'         => $email,
            'codice_loco_1' => $codice_1,
            'codice_loco_2' => $codice_2,
            'codice_loco_3' => $codice_3,
            'codice_loco_4' => $codice_4,
            'codice_loco_5' => $codice_5,
            'motivazione'   => $motivazione,
            'urlSocial'     => $urlSocial,
            'privacy'       => $privacy,
            'age'           => $age,
            'residenza'     => $residenza,
            'validated'     => $validated ? 1 : 0,
            'ip_address'    => $ip,
        ]);

        if ($inserted === false) {
            return new \WP_REST_Response([
                'success' => false,
                'message' => 'Errore durante il salvataggio. Riprova.',
                'error' => $inserted->get_error_message() ?? 'Errore sconosciuto',
            ], 500);
        }

        $sendEmail = new Send_Email();
        $sendEmail->sendEmail($email, 'Kiss Kiss, Concorso LOCO - Candidatura ricevuta', [], []);

        return new \WP_REST_Response([
            'success' => true,
            'message' => 'Candidatura ricevuta! Ti contatteremo presto.',
        ], 200);
    }

    /**
     * Verifica che i codici LOCO inseriti siano corretti.
     * TODO: implementare il confronto con i codici validi quando disponibili.
     */
    private function areCodesValid(string $c1, string $c2, string $c3, string $c4, string $c5): bool
    {
        if (empty($c1) || empty($c2) || empty($c3) || empty($c4) || empty($c5)) {
            return false;
        }

        // TODO: aggiungere qui il confronto con i codici validi
        return true;
    }

    /**
     * Verifica che l'URL sia un profilo Instagram o Facebook valido.
     */
    private function isValidSocialUrl(string $url): bool
    {
        if (empty($url) || filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $host = strtolower(parse_url($url, PHP_URL_HOST) ?? '');
        $host = preg_replace('/^www\./', '', $host);

        return in_array($host, ['instagram.com', 'facebook.com'], true);
    }

    public function serveHtmlResponse($served, $result, $request, $server): bool
    {
        if ($request->get_route() !== '/widget-loco/v1/candidature') {
            return $served;
        }

        $data = $result->get_data();

        if (! is_string($data)) {
            return $served;
        }

        header('Content-Type: text/html; charset=' . get_option('blog_charset'));

        echo $data;

        return true;
    }

    public function getCandidature(\WP_REST_Request $request): \WP_REST_Response
    {
        $password = sanitize_text_field($request->get_param('password') ?? '');

        if ($password !== 'LumekoPardi84') {
            $html = '
                <div style="width:100vw; height:100vh; display:flex; flex-direction:column; justify-content:center; align-items:center;"> 
                    <h2 style="margin-bottom:20px; font-family:Arial, sans-serif;">Accedi per visualizzare le candidature</h2>
                    <form id="candidature-password-form">
                        <input style="padding:10px 16px;border:1px solid #ddd;border-radius:6px;margin-bottom:10px;" type="password" name="password" placeholder="Inserisci password" required>
                        <button type="submit" style="padding:10px 16px;border:0;border-radius:6px;background:#2563eb;color:#fff;font-weight:bold;cursor:pointer;">Accedi</button>
                        <p id="candidature-error" style="display:none;color:red;">Password non valida</p>
                    </form>
                </div>
                
            ';

            return new \WP_REST_Response($html, 200);
        }

        // qui renderizzi solo se password corretta
        $search = sanitize_text_field($request->get_param('search') ?? '');
        $page = max(1, (int) ($request->get_param('page') ?? 1));

        $per_page = max(1, (int) ($request->get_param('per_page') ?? 25));
        $offset = ($page - 1) * $per_page;

        $candidature = Database::getCandidaturePaginated($per_page, $offset, $search);
        $total = Database::countCandidature($search);
        $total_pages = max(1, (int) ceil($total / $per_page));

        $html = widget_loco_view('public/views/candidature.php', [
            'candidature' => $candidature,
            'page' => $page,
            'per_page' => $per_page,
            'total' => $total,
            'total_pages' => $total_pages,
            'search' => $search,
        ]);

        return new \WP_REST_Response($html, 200);
    }

    
}