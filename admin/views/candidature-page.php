<?php

if (!defined('ABSPATH')) {
    exit;
}

$base_url   = admin_url('admin.php?page=widget-loco-candidature');
$export_url = wp_nonce_url(
    add_query_arg(
        ['action' => 'loco_export_csv', 'search' => $search, 'validated' => $validated],
        admin_url('admin-post.php')
    ),
    'loco_export_csv'
);

?>

<div class="wrap">

    <h1 class="wp-heading-inline">Candidature LOCO</h1>
    <span style="margin-left:12px; color:#666; font-size:14px">
        <?php echo esc_html($total); ?> risultati
    </span>

    <hr class="wp-header-end">

    <!-- ── FILTRI ── -->
    <form method="get" action="<?php echo esc_url($base_url); ?>" style="margin:16px 0; display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
        <input type="hidden" name="page" value="widget-loco-candidature">

        <input
            type="text"
            name="search"
            value="<?php echo esc_attr($search); ?>"
            placeholder="Cerca per nome, cognome o email…"
            class="regular-text"
        >

        <select name="validated">
            <option value="">— Tutti —</option>
            <option value="1" <?php selected($validated, '1'); ?>>&#x2705; Validati</option>
            <option value="0" <?php selected($validated, '0'); ?>>&#x274C; Non validati</option>
        </select>

        <button type="submit" class="button button-primary">Filtra</button>
        <a href="<?php echo esc_url($base_url); ?>" class="button">Reset</a>
        <a href="<?php echo esc_url($export_url); ?>" class="button button-secondary" style="margin-left:auto">
            &#x2B07; Esporta CSV (Excel)
        </a>
    </form>

    <!-- ── TABELLA ── -->
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th style="width:40px">ID</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Email</th>
                <th style="width:80px">Cod. 1</th>
                <th style="width:80px">Cod. 2</th>
                <th style="width:80px">Cod. 3</th>
                <th style="width:80px">Cod. 4</th>
                <th style="width:80px">Cod. 5</th>
                <th>Motivazione</th>
                <th>URL Social</th>
                <th style="width:80px">Validated</th>
                <th style="width:130px">Data</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rows)) : ?>
                <tr>
                        <td colspan="13" style="text-align:center; padding:24px; color:#666;">
                        Nessuna candidatura trovata.
                    </td>
                </tr>
            <?php else : ?>
                <?php foreach ($rows as $row) : ?>
                    <tr>
                        <td><?php echo esc_html($row['id']); ?></td>
                        <td><?php echo esc_html($row['nome'] ?? '—'); ?></td>
                        <td><?php echo esc_html($row['cognome'] ?? '—'); ?></td>
                        <td><?php echo esc_html($row['email']); ?></td>
                        <td><code><?php echo esc_html($row['codice_loco_1']); ?></code></td>
                        <td><code><?php echo esc_html($row['codice_loco_2']); ?></code></td>
                        <td><code><?php echo esc_html($row['codice_loco_3']); ?></code></td>
                        <td><code><?php echo esc_html($row['codice_loco_4']); ?></code></td>
                        <td><code><?php echo esc_html($row['codice_loco_5']); ?></code></td>
                        <td title="<?php echo esc_attr($row['motivazione']); ?>">
                            <?php echo esc_html(mb_strimwidth($row['motivazione'], 0, 80, '…')); ?>
                        </td>
                        <td>
                            <?php if (! empty($row['urlSocial'])) : ?>
                                <a href="<?php echo esc_url($row['urlSocial']); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr($row['urlSocial']); ?>">
                                    <?php echo esc_html(mb_strimwidth($row['urlSocial'], 0, 40, '…')); ?>
                                </a>
                            <?php else : ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td style="text-align:center">
                            <?php echo $row['validated'] ? '&#x2705;' : '&#x274C;'; ?>
                        </td>
                        <td><?php echo esc_html($row['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- ── PAGINAZIONE ── -->
    <?php if ($pages > 1) : ?>
        <div class="tablenav bottom" style="margin-top:12px">
            <div class="tablenav-pages">
                <?php
                echo wp_kses_post(paginate_links([
                    'base'     => add_query_arg('paged', '%#%', $base_url),
                    'format'   => '',
                    'current'  => $paged,
                    'total'    => $pages,
                    'add_args' => array_filter([
                        'search'    => $search,
                        'validated' => $validated,
                    ]),
                ]));
                ?>
            </div>
        </div>
    <?php endif; ?>

</div>
