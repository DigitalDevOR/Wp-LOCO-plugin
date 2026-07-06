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

    public function render($atts = []): string
    {
        $atts = shortcode_atts([
            'title' => 'Widget Loco',
        ], $atts, 'widget_loco');

        return $this->renderer->render($atts);
    }
}