<?php

namespace Widget_Loco\Admin;

if (!defined('ABSPATH')) {
    exit;
}

class Admin_Page
{
    /**
     * Registra gli hook della parte amministrativa.
     */
    public function register(): void
    {
        add_action('admin_menu', [$this, 'addMenuPage']);
    }

    /**
     * Aggiunge la voce di menu nella dashboard.
     */
    public function addMenuPage(): void
    {
        add_menu_page(
            'Widget Loco',                 // Titolo della pagina
            'Widget Loco',                 // Nome nel menu
            'manage_options',              // Permesso richiesto
            'widget-loco',                 // Slug della pagina
            [$this, 'renderPage'],         // Callback
            'dashicons-admin-generic',     // Icona
            80                             // Posizione nel menu
        );
    }

    /**
     * Renderizza la pagina amministrativa.
     */
    public function renderPage(): void
    {
        echo widget_loco_view(
            'admin/views/settings-page.php'
        );
    }
}