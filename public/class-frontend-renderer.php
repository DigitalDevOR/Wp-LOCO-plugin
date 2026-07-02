<?php

namespace Widget_Loco\Public_Frontend;

if (!defined('ABSPATH')) {
    exit;
}

class Frontend_Renderer
{
    /**
     * Mappa delle view disponibili: slug => file template.
     * Aggiungere qui ogni nuova view prima di usarla.
     */
    private const VIEWS = [
        'guest'     => 'public/views/guest.php',
        'logged-in' => 'public/views/logged-in.php',
    ];

    /**
     * Renderizza il frontend del plugin.
     * Seleziona automaticamente la view in base allo stato di autenticazione.
     *
     * @param array $atts Attributi ricevuti dallo shortcode.
     *
     * @return string
     */
    public function render(array $atts = []): string
    {
        $is_logged_in = is_user_logged_in();
        $view         = $is_logged_in ? 'logged-in' : 'guest';


        $data = [
            'title' => $atts['title'] ?? 'Widget Loco',
        ];

        if ($is_logged_in) {
            $user           = wp_get_current_user();
            $data['user']   = $user;
            $data['name']   = $user->display_name;
            $data['email']  = $user->user_email;
            $data['avatar'] = get_avatar_url($user->ID);
        }

        return widget_loco_view(self::VIEWS[$view], $data);
    }
}