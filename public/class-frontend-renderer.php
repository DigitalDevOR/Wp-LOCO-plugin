<?php

namespace Widget_Loco\Public_Frontend;

use Widget_Loco\Includes\Database;
use Widget_Loco\Includes\CheckDate;

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
        'landing' => 'public/views/landing.php',
        'guest'   => 'public/views/guest.php',
        'form'    => 'public/views/logged-in.php',
    ];

    /**
     * Renderizza il frontend del plugin.
     *
     * Routing basato su ?view=:
     *   - (nessun param) → landing.php (sempre visibile)
     *   - ?view=form     → form codice LOCO se autenticato, altrimenti login
     *   - ?view=login    → login/registrazione se non autenticato, altrimenti form
     *
     * @param array $atts Attributi ricevuti dallo shortcode.
     *
     * @return string
     */
    public function render(array $atts = []): string
    {
        $checkDate = new CheckDate();

        $view_param   = isset( $_GET['view'] ) ? sanitize_key( $_GET['view'] ) : '';
        $is_logged_in = is_user_logged_in();

        $already_submitted = $is_logged_in
            ? Database::userHasSubmitted( get_current_user_id() )
            : false;

        if ( $view_param === 'form' || $view_param === 'login' ) {
            $view = $is_logged_in ? 'form' : 'guest';
        } else {
            $view = 'landing';
        }

        $data = [
            'title' => $atts['title'] ?? 'Widget Loco',
        ];

        if ( $is_logged_in ) {
            $user           = wp_get_current_user();
            $data['user']   = $user;
            $data['name']   = $user->display_name;
            $data['email']  = $user->user_email;
            $data['avatar'] = get_avatar_url( $user->ID );

            if ( $already_submitted ) {
                $data['already_submitted'] = true;
            }
        }

        return widget_loco_view( self::VIEWS[ $view ], $data );
    }
}
