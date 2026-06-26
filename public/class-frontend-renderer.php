<?php

namespace Widget_Loco\Public_Frontend;

if (!defined('ABSPATH')) {
    exit;
}

class Frontend_Renderer
{
    /**
     * Renderizza il frontend del plugin.
     *
     * @param array $atts Attributi ricevuti dallo shortcode.
     *
     * @return string
     */
    public function render(array $atts = []): string
    {
        // per ora utilizziamo dei dati di default ma in futuro potremmo voler passare dati dinamici, la possibile logica potrebbe essere implementata qui.
        $data = [
            'title' => $atts['title'] ?? 'Widget Loco',
        ];

        return widget_loco_view(
            'public/views/shortcode-template.php',
            $data
        );
    }
}