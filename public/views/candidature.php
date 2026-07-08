<div style="margin:24px 0;overflow-x:auto;">

<form method="get" style="margin-bottom:16px;display:flex;gap:8px;">
    <input
        type="text"
        name="search"
        value="<?php echo esc_attr($search ?? ''); ?>"
        placeholder="Cerca per nome, email..."
        style="padding:10px 12px;border:1px solid #ccc;border-radius:6px;min-width:260px;"
    >

    <button
        type="submit"
        style="padding:10px 16px;border:0;border-radius:6px;background:#2563eb;color:#fff;font-weight:bold;cursor:pointer;"
    >
        Cerca
    </button>
</form>

<table style="width:100%;border-collapse:collapse;background:#fff;border:1px solid #ddd;font-size:14px;">
        <thead style="background:#1f2937;color:#fff;">
            <tr>
                <th style="padding:14px 16px;text-align:left;">ID</th>
                <th style="padding:14px 16px;text-align:left;">Nome</th>
                <th style="padding:14px 16px;text-align:left;">Email</th>
                <th style="padding:14px 16px;text-align:left;">Data</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($candidature)) : ?>
                <?php foreach ($candidature as $candidatura) : ?>
                    <tr>
                        <td style="padding:12px 16px;border-bottom:1px solid #eee;">
                            <?php echo esc_html($candidatura->id ?? ''); ?>
                        </td>

                        <td style="padding:12px 16px;border-bottom:1px solid #eee;">
                            <?php echo esc_html($candidatura->nome ?? ''); ?>
                        </td>

                        <td style="padding:12px 16px;border-bottom:1px solid #eee;">
                            <?php echo esc_html($candidatura->email ?? ''); ?>
                        </td>

                        <td style="padding:12px 16px;border-bottom:1px solid #eee;">
                            <?php echo esc_html($candidatura->created_at ?? ''); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4" style="padding:18px;text-align:center;color:#666;">
                        Nessuna candidatura trovata.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ($total_pages > 1) : ?>
        <div style="display:flex;justify-content:center;gap:8px;margin-top:20px;">

            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>

                <a
                    href="<?php echo esc_url(add_query_arg([
                        'page'     => $i,
                        'per_page' => $per_page,
                        'search'   => $search ?? '',
                    ])); ?>"
                    data-page="<?php echo esc_attr($i); ?>"
                    style="
                        display:inline-block;
                        min-width:38px;
                        padding:10px 14px;
                        text-align:center;
                        text-decoration:none;
                        border:1px solid <?php echo $i === $page ? '#2563eb' : '#ccc'; ?>;
                        background:<?php echo $i === $page ? '#2563eb' : '#fff'; ?>;
                        color:<?php echo $i === $page ? '#fff' : '#333'; ?>;
                        border-radius:6px;
                        font-weight:bold;
                    "
                >
                    <?php echo esc_html($i); ?>
                </a>

            <?php endfor; ?>

        </div>
    <?php endif; ?>
</div>