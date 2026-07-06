<?php

namespace Widget_Loco\Admin;

use Widget_Loco\Includes\Database;

if (!defined('ABSPATH')) {
    exit;
}

class Admin_Page
{
    private const PER_PAGE = 25;

    /**
     * Registra gli hook della parte amministrativa.
     */
    public function register(): void
    {
        add_action('admin_menu',                 [$this, 'addMenuPage']);
        add_action('admin_post_loco_export_csv', [$this, 'exportCsv']);
    }

    /**
     * Aggiunge la voce di menu e il sottomenu nella dashboard.
     */
    public function addMenuPage(): void
    {
        add_menu_page(
            'Widget Loco',
            'Widget Loco',
            'manage_options',
            'widget-loco',
            [$this, 'renderPage'],
            'dashicons-admin-generic',
            80
        );

        add_submenu_page(
            'widget-loco',
            'Candidature LOCO',
            'Candidature',
            'manage_options',
            'widget-loco-candidature',
            [$this, 'renderCandidaturePage']
        );
    }

    /**
     * Renderizza la pagina impostazioni.
     */
    public function renderPage(): void
    {
        echo widget_loco_view('admin/views/settings-page.php');
    }

    /**
     * Renderizza la pagina candidature con filtri e tabella.
     */
    public function renderCandidaturePage(): void
    {
        if (! current_user_can('manage_options')) {
            wp_die(esc_html__('Permesso negato.', 'widget-loco'));
        }

        $search    = isset($_GET['search'])    ? sanitize_text_field(wp_unslash($_GET['search']))    : '';
        $validated = isset($_GET['validated']) ? sanitize_text_field(wp_unslash($_GET['validated'])) : '';
        $paged     = isset($_GET['paged'])     ? max(1, (int) $_GET['paged'])                        : 1;

        $filters = ['search' => $search, 'validated' => $validated];
        $offset  = ($paged - 1) * self::PER_PAGE;
        $rows    = Database::getCandidature($filters, self::PER_PAGE, $offset);
        $total   = Database::countCandidature($filters);
        $pages   = (int) ceil($total / self::PER_PAGE);

        echo widget_loco_view('admin/views/candidature-page.php', compact(
            'rows', 'total', 'pages', 'paged', 'search', 'validated'
        ));
    }

    /**
     * Esporta le candidature filtrate in CSV e forza il download.
     */
    public function exportCsv(): void
    {
        if (! current_user_can('manage_options')) {
            wp_die(esc_html__('Permesso negato.', 'widget-loco'));
        }

        check_admin_referer('loco_export_csv');

        $search    = isset($_GET['search'])    ? sanitize_text_field(wp_unslash($_GET['search']))    : '';
        $validated = isset($_GET['validated']) ? sanitize_text_field(wp_unslash($_GET['validated'])) : '';

        $rows = Database::getCandidature(['search' => $search, 'validated' => $validated], 9999, 0);

        $filename = 'candidature-loco-' . gmdate('Y-m-d') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');

        $out = fopen('php://output', 'w');

        // BOM per Excel (UTF-8)
        fputs($out, "\xEF\xBB\xBF");

        fputcsv($out, ['ID', 'Nome', 'Cognome', 'Email', 'Codice 1', 'Codice 2', 'Codice 3', 'Codice 4', 'Codice 5', 'Motivazione', 'URL Social', 'Validated', 'Data'], ';');

        foreach ($rows as $row) {
            fputcsv($out, [
                $row['id'],
                $row['nome']         ?? '',
                $row['cognome']      ?? '',
                $row['email'],
                $row['codice_loco_1'],
                $row['codice_loco_2'],
                $row['codice_loco_3'],
                $row['codice_loco_4'],
                $row['codice_loco_5'],
                $row['motivazione'],
                $row['urlSocial']    ?? '',
                $row['validated'] ? 'Sì' : 'No',
                $row['created_at'],
            ], ';');
        }

        fclose($out);
        exit;
    }
}
