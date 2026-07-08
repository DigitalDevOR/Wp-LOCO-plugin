<?php

namespace Widget_Loco\Includes;

if (!defined('ABSPATH')) {
    exit;
}

class Assets
{
    public function register(): void
    {
        // CSS il prima possibile nel <head>
        add_action('wp_enqueue_scripts', [$this, 'enqueueFrontendCss'], 1);

        // JS più tardi, nel footer
        add_action('wp_enqueue_scripts', [$this, 'enqueueFrontendJs']);

        add_action('admin_enqueue_scripts', [$this, 'enqueueAdminAssets']);
    }

    public function enqueueFrontendCss(): void
    {
        wp_enqueue_style(
            'widget-loco-frontend',
            WIDGET_LOCO_URL . 'assets/frontend/css/frontend.css',
            [],
            WIDGET_LOCO_VERSION
        );

        // Critical CSS minimo anti-FOUC
        wp_add_inline_style(
            'widget-loco-frontend',
            '
            .LOCO_li_section {
                position: relative;
                overflow: hidden;
            }

            .LOCO_li_section_head,
            .LOCO_li_prize_card,
            .LOCO_li_section > section {
                position: relative;
                z-index: 2;
            }

            .LOCO_li_bg_tickets {
                position: absolute;
                inset: 0;
                z-index: 1;
                pointer-events: none;
                overflow: hidden;
            }
            '
        );
    }

    public function enqueueFrontendJs(): void
    {
        wp_enqueue_script(
            'widget-loco-frontend',
            WIDGET_LOCO_URL . 'assets/frontend/js/frontend.js',
            [],
            WIDGET_LOCO_VERSION,
            true
        );

        wp_localize_script(
            'widget-loco-frontend',
            'WidgetLoco',
            [
                'ajaxUrl'   => admin_url('admin-ajax.php'),
                'nonce'     => wp_create_nonce('widget_loco_nonce'),
                'restUrl'   => rest_url('widget-loco/v1'),
                'restNonce' => wp_create_nonce('wp_rest'),
            ]
        );
    }

    public function enqueueAdminAssets(string $hook): void
    {
        if ($hook !== 'toplevel_page_widget-loco') {
            return;
        }

        wp_enqueue_style(
            'widget-loco-admin',
            WIDGET_LOCO_URL . 'assets/admin/css/admin.css',
            [],
            WIDGET_LOCO_VERSION
        );

        wp_enqueue_script(
            'widget-loco-admin',
            WIDGET_LOCO_URL . 'assets/admin/js/admin.js',
            [],
            WIDGET_LOCO_VERSION,
            true
        );
    }
}