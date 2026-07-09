<?php

        use Widget_Loco\Includes\CheckDate;

        if (!defined('ABSPATH')) {
            exit;
        }
        
        $checkDate = new CheckDate();

        if ($checkDate->getIsConcorsoTerminato() || $checkDate->getIsAbreveOnline() || ! $checkDate->getIsAppActive()) {
            wp_safe_redirect(get_permalink());
            exit;
        }

        $current_action   = isset( $_GET['action'] ) ? sanitize_key( $_GET['action'] ) : '';
        $is_register_view = ( $current_action === 'register' );
        $page_url         = get_permalink();
        $form_url         = add_query_arg( 'view', 'form', $page_url );
        $guest_base_url   = add_query_arg( 'view', 'login', $page_url );
        $register_url     = add_query_arg( 'action', 'register', $guest_base_url );
        $login_url        = $guest_base_url;

        // Messaggi di errore registrazione
        $reg_errors = [
            'nonce'            => __( 'Richiesta non valida. Riprova.', 'widget-loco' ),
            'disabled'         => __( 'Le registrazioni sono attualmente disabilitate.', 'widget-loco' ),
            'empty'            => __( 'Compila tutti i campi obbligatori.', 'widget-loco' ),
            'email'            => __( 'Inserisci un indirizzo email valido.', 'widget-loco' ),
            'password_mismatch'=> __( 'Le password non coincidono.', 'widget-loco' ),
            'password_short'   => __( 'La password deve essere di almeno 8 caratteri.', 'widget-loco' ),
            'user_exists'      => __( 'Username già in uso. Scegline un altro.', 'widget-loco' ),
            'email_exists'     => __( 'Esiste già un account con questa email.', 'widget-loco' ),
            'create'           => __( 'Errore durante la creazione dell\'account. Riprova.', 'widget-loco' ),
        ];

?>

<main class="LOCO_main_login">

    <?php include WIDGET_LOCO_PATH . 'public/views/partials/header.php'; ?>

    <div style="width:100%; display:flex; justify-content:center; align-items:center; padding-top:40px; padding-left:20px; padding-right:20px;">
        <div style="width:480px">
            <?php include WIDGET_LOCO_PATH . 'public/views/partials/quantoSeiLoco.php'; ?>
        </div>
    </div>


    <div class="LOCO_auth_wrap">
        <?php if ( $is_register_view ) : ?>

            <!-- ───── FORM REGISTRAZIONE ───── -->

            <?php if ( isset( $_GET['reg'] ) && $_GET['reg'] === 'error' && isset( $_GET['err'] ) ) :
                $err_key = sanitize_key( $_GET['err'] );
                $err_msg = $reg_errors[ $err_key ] ?? __( 'Si è verificato un errore. Riprova.', 'widget-loco' );
            ?>
                <p class="LOCO_login_error"><?php echo esc_html( $err_msg ); ?></p>
            <?php endif; ?>

            <form  class="LOCO_login_form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                <input type="hidden" name="action"      value="loco_register">
                <input type="hidden" name="redirect_to" value="<?php echo esc_url( $form_url ); ?>">
                <?php wp_nonce_field( 'loco-register-nonce', 'loco_register_nonce' ); ?>

                <div class="LOCO_field">
                    <label for="loco_reg_username"><?php esc_html_e( 'Username', 'widget-loco' ); ?></label>
                    <input
                        type="text"
                        id="loco_reg_username"
                        name="reg_username"
                        autocomplete="username"
                        value="<?php echo esc_attr( sanitize_user( wp_unslash( $_POST['reg_username'] ?? '' ) ) ); ?>"
                        required
                    >
                </div>

                <div class="LOCO_field">
                    <label for="loco_reg_email"><?php esc_html_e( 'Email', 'widget-loco' ); ?></label>
                    <input
                        type="email"
                        id="loco_reg_email"
                        name="reg_email"
                        autocomplete="email"
                        value="<?php echo esc_attr( sanitize_email( wp_unslash( $_POST['reg_email'] ?? '' ) ) ); ?>"
                        required
                    >
                </div>

                <div class="LOCO_field">
                    <label for="loco_reg_password"><?php esc_html_e( 'Password', 'widget-loco' ); ?></label>
                    <input
                        type="password"
                        id="loco_reg_password"
                        name="reg_password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >
                </div>

                <div class="LOCO_field">
                    <label for="loco_reg_confirm"><?php esc_html_e( 'Conferma Password', 'widget-loco' ); ?></label>
                    <input
                        type="password"
                        id="loco_reg_confirm"
                        name="reg_confirm"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >
                </div>

                <button type="submit" class="LOCO_cta">
                    <?php esc_html_e( 'Crea account', 'widget-loco' ); ?>
                </button>

                <p style="margin-bottom: 4rem;" class="LOCO_auth_toggle">
                    <?php esc_html_e( 'Hai già un account?', 'widget-loco' ); ?>
                    <a href="<?php echo esc_url( $login_url ); ?>"><?php esc_html_e( 'Accedi', 'widget-loco' ); ?></a>
                </p>
            </form>

            <p class="LOCO_auth_toggle">
                <?php esc_html_e( 'Hai già un account?', 'widget-loco' ); ?>
                <a href="<?php echo esc_url( $login_url ); ?>"><?php esc_html_e( 'Accedi', 'widget-loco' ); ?></a>
            </p>

        <?php else : ?>

            <!-- ───── FORM LOGIN ───── -->

            <?php if ( isset( $_GET['login'] ) && $_GET['login'] === 'failed' ) :
                $login_err = isset( $_GET['err'] ) ? sanitize_key( $_GET['err'] ) : '';
                if ( $login_err === 'verify_email' ) :
            ?>
                <p class="LOCO_login_error"><?php esc_html_e( 'Controlla la tua casella email e verifica il tuo account prima di accedere.', 'widget-loco' ); ?></p>
            <?php else : ?>
                <p class="LOCO_login_error"><?php esc_html_e( 'Credenziali non valide. Riprova.', 'widget-loco' ); ?></p>
            <?php endif; endif; ?>

            <?php if ( isset( $_GET['reg'] ) && $_GET['reg'] === 'success' ) : ?>
                <p class="LOCO_login_success"><?php esc_html_e( 'Registrazione completata! Ora puoi accedere.', 'widget-loco' ); ?></p>
            <?php endif; ?>

            <form class="LOCO_login_form" method="post" action="<?php echo esc_url( wp_login_url() ); ?>">
                <div class="LOCO_field">
                    <label for="loco_user_login"><?php esc_html_e( 'Email', 'widget-loco' ); ?></label>
                    <input
                        type="email"
                        id="loco_user_login"
                        name="log"
                        autocomplete="email"
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

                <input type="hidden" name="redirect_to" value="<?php echo esc_url( $form_url ); ?>">
                <?php wp_nonce_field( 'login-nonce', 'login_nonce' ); ?>

                <button type="submit" class="LOCO_cta">
                    <?php esc_html_e( 'Accedi', 'widget-loco' ); ?>
                </button>
            </form>

            <?php if ( get_option( 'users_can_register' ) ) : ?>
                <p class="LOCO_auth_toggle">
                    <?php esc_html_e( 'Non hai un account?', 'widget-loco' ); ?>
                    <a href="<?php echo esc_url( $register_url ); ?>"><?php esc_html_e( 'Registrati', 'widget-loco' ); ?></a>
                </p>
            <?php endif; ?>

        <?php endif; ?>

    </div><!-- .LOCO_auth_wrap -->
    
    <div style="width:100%; position:absolute; bottom:0; left:0;">
        <?php include WIDGET_LOCO_PATH . 'public/views/partials/footer.php'; ?>
    </div>
    
</main>
