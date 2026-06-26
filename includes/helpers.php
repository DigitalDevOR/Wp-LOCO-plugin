<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Renderizza un template PHP e restituisce l'HTML generato.
 *
 * @param string $path Percorso relativo del template.
 * @param array  $data Variabili da rendere disponibili nel template.
 *
 * @return string
 */
function widget_loco_view(string $path, array $data = []): string
{
    $fullPath = WIDGET_LOCO_PATH . $path;

    if (!file_exists($fullPath)) {
        return '';
    }

    // Estrae le variabili dall'array $data, evitando conflitti con variabili già esistenti
    extract($data, EXTR_SKIP);

    // Avvia l'output buffering per catturare l'output del template
    ob_start();

    // Include il template PHP dove è possibile accedere alle variabili estratte
    include $fullPath;

    // Restituisce l'output catturato e pulisce il buffer
    return ob_get_clean();
}