<?php
/**
 * Plugin Name: Widget Loco
 * Description: Plugin con shortcode, rendering server-side, admin dashboard e asset frontend.
 * Version: 1.0.1
 * Author: Only Radio
 * Text Domain: widget-loco
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WIDGET_LOCO_VERSION', '1.0.0');
define('WIDGET_LOCO_FILE', __FILE__);
define('WIDGET_LOCO_PATH', plugin_dir_path(__FILE__));
define('WIDGET_LOCO_URL', plugin_dir_url(__FILE__));

require_once WIDGET_LOCO_PATH . 'includes/helpers.php';
require_once WIDGET_LOCO_PATH . 'includes/class-plugin.php';
require_once WIDGET_LOCO_PATH . 'includes/class-assets.php';
require_once WIDGET_LOCO_PATH . 'includes/class-shortcode.php';
require_once WIDGET_LOCO_PATH . 'includes/class-rest-api.php';
require_once WIDGET_LOCO_PATH . 'public/class-frontend-renderer.php';
require_once WIDGET_LOCO_PATH . 'admin/class-admin-page.php';

function widget_loco_run(): void
{
    $plugin = new Widget_Loco\Includes\Plugin();
    $plugin->run();
}

try {
    widget_loco_run();
} catch (\Exception $e) {
    error_log('Errore durante l\'esecuzione del plugin Widget Loco: ' . $e->getMessage());
}
