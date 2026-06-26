<?php

namespace Widget_Loco\Includes;

use Widget_Loco\Public_Frontend\Frontend_Renderer;

if (!defined('ABSPATH')) {
    exit;
}

class Shortcode
{
    private Frontend_Renderer $renderer;

    public function __construct(Frontend_Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function register(): void
    {
        add_shortcode('widget_loco', [$this, 'render']);
    }

    public function render(array $atts = []): string
    {
        wp_enqueue_style('widget-loco-frontend');
        wp_enqueue_script('widget-loco-frontend');

        $atts = shortcode_atts([
            'title' => 'Widget Loco',
        ], $atts, 'widget_loco');

        return $this->renderer->render($atts);
    }
}