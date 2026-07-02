<?php

namespace Widget_Loco\Includes;

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
        $redirect_to = isset($_POST['redirect_to'])
            ? esc_url_raw(wp_unslash($_POST['redirect_to']))
            : home_url();

        $register_url = add_query_arg(
            ['view' => 'login', 'action' => 'register'],
            $redirect_to
        );

        // Verifica nonce
        if (
            ! isset($_POST['loco_register_nonce']) ||
            ! wp_verify_nonce(
                sanitize_text_field(wp_unslash($_POST['loco_register_nonce'])),
                'loco-register-nonce'
            )
        ) {
            wp_safe_redirect(add_query_arg(['reg' => 'error', 'err' => 'nonce'], $register_url));
            exit;
        }

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
        $user->set_role('subscriber');

        // Auto-login immediato
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id, false);

        // Reindirizza alla form del codice LOCO
        wp_safe_redirect($redirect_to);
        exit;
    }
}