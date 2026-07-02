<?php

if (!defined('ABSPATH')) {
    exit;
}

?>

<div class="LOCO_main">

    <?php if ( isset( $_GET['login'] ) && $_GET['login'] === 'failed' ) : ?>
        <p class="LOCO_login_error"><?php esc_html_e( 'Credenziali non valide. Riprova.', 'widget-loco' ); ?></p>
    <?php endif; ?>

    <form class="LOCO_login_form" method="post" action="<?php echo esc_url( wp_login_url() ); ?>">
        <div class="LOCO_field">
            <label for="loco_user_login"><?php esc_html_e( 'Username o Email', 'widget-loco' ); ?></label>
            <input
                type="text"
                id="loco_user_login"
                name="log"
                autocomplete="username"
                required
            >
        </div>

        <div class="LOCO_field">
            <label for="loco_user_pass"><?php esc_html_e( 'Password', 'widget-loco' ); ?></label>
            <input
                type="password"
                id="loco_user_pass"
                name="pwd"
                autocomplete="current-password"
                required
            >
        </div>

        <div class="LOCO_field LOCO_field--checkbox">
            <input type="checkbox" id="loco_rememberme" name="rememberme" value="forever">
            <label for="loco_rememberme"><?php esc_html_e( 'Ricordami', 'widget-loco' ); ?></label>
        </div>

        <input type="hidden" name="redirect_to" value="<?php echo esc_url( get_permalink() ); ?>">
        <?php wp_nonce_field( 'login-nonce', 'login_nonce' ); ?>

        <button type="submit" class="LOCO_cta">
            <?php esc_html_e( 'Accedi', 'widget-loco' ); ?>
        </button>
    </form>

</div>
