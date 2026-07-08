<?php

namespace Widget_Loco\Includes;

if (!defined('ABSPATH')) {
    exit;
}

class Database
{
    /**
     * Nome della tabella senza prefisso WP.
     */
    private const TABLE = 'loco_candidature';

    /**
     * Ritorna il nome completo della tabella (con prefisso wpdb).
     */
    public static function tableName(): string
    {
        global $wpdb;
        return $wpdb->prefix . self::TABLE;
    }

    /**
     * Crea (o aggiorna) la tabella usando dbDelta.
     * Chiamato da Plugin::run() al cambio di WIDGET_LOCO_VERSION.
     */
    public static function createTable(): void
    {
        global $wpdb;

        $table   = self::tableName();
        $charset = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$table} (
            id              BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            user_id         BIGINT(20) UNSIGNED NOT NULL DEFAULT 0,
            nome            VARCHAR(100) NOT NULL DEFAULT '',
            cognome         VARCHAR(100) NOT NULL DEFAULT '',
            email           VARCHAR(200) NOT NULL DEFAULT '',
            codice_loco_1   VARCHAR(50)  NOT NULL DEFAULT '',
            codice_loco_2   VARCHAR(50)  NOT NULL DEFAULT '',
            codice_loco_3   VARCHAR(50)  NOT NULL DEFAULT '',
            codice_loco_4   VARCHAR(50)  NOT NULL DEFAULT '',
            codice_loco_5   VARCHAR(50)  NOT NULL DEFAULT '',
            motivazione     TEXT         NOT NULL,
            urlSocial       VARCHAR(200) NOT NULL DEFAULT '',
            privacy         TINYINT(1)   NOT NULL DEFAULT 0,
            age             TINYINT(1)   NOT NULL DEFAULT 0,
            residenza       TINYINT(1)   NOT NULL DEFAULT 0,
            validated       TINYINT(1)   NOT NULL DEFAULT 0,
            ip_address      VARCHAR(45)  NOT NULL DEFAULT '',
            created_at      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY user_id (user_id)
        ) {$charset};";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    /**
     * Inserisce una candidatura nella tabella.
     *
     * @param array $data Dati già sanitizzati.
     * @return int|false  ID della riga inserita, o false in caso di errore.
     */
    public static function insertCandidatura(array $data): int|false
    {
        global $wpdb;

        $inserted = $wpdb->insert(
            self::tableName(),
            [
                'user_id'       => (int)    ($data['user_id']       ?? 0),
                'nome'          => (string) ($data['nome']           ?? ''),
                'cognome'       => (string) ($data['cognome']        ?? ''),
                'email'         => (string) ($data['email']          ?? ''),
                'codice_loco_1' => (string) ($data['codice_loco_1']  ?? ''),
                'codice_loco_2' => (string) ($data['codice_loco_2']  ?? ''),
                'codice_loco_3' => (string) ($data['codice_loco_3']  ?? ''),
                'codice_loco_4' => (string) ($data['codice_loco_4']  ?? ''),
                'codice_loco_5' => (string) ($data['codice_loco_5']  ?? ''),
                'motivazione'   => (string) ($data['motivazione']    ?? ''),
                'urlSocial'     => esc_url_raw((string) ($data['urlSocial'] ?? '')),
                'privacy'       => (int)    ($data['privacy']        ?? 0),
                'age'           => (int)    ($data['age']            ?? 0),
                'residenza'     => (int)    ($data['residenza']      ?? 0),
                'validated'     => (int)    ($data['validated']      ?? 0),
                'ip_address'    => (string) ($data['ip_address']     ?? ''),
                'created_at'    => current_time('mysql'),
            ],
            ['%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%s', '%s']
        );

        return $inserted ? $wpdb->insert_id : false;
    }

    /**
     * Controlla se un utente ha già inviato una candidatura.
     */
    public static function userHasSubmitted(int $user_id): bool
    {
        global $wpdb;

        $count = $wpdb->get_var(
            $wpdb->prepare(
                'SELECT COUNT(*) FROM %i WHERE user_id = %d',
                self::tableName(),
                $user_id
            )
        );

        return (int) $count > 0;
    }

    /**
     * Ritorna le candidature con filtri opzionali.
     *
     * @param array $filters  Chiavi: search (string), validated (0|1|'')
     * @param int   $per_page Righe per pagina.
     * @param int   $offset   Offset per la paginazione.
     * @return array
     */
    public static function getCandidature(array $filters = [], int $per_page = 20, int $offset = 0): array
    {
        global $wpdb;

        $table = self::tableName();

        $where  = ['1=1'];
        $params = [];

        if (! empty($filters['search'])) {
            $like     = '%' . $wpdb->esc_like($filters['search']) . '%';
            $where[]  = '(c.email LIKE %s OR c.nome LIKE %s OR c.cognome LIKE %s)';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        if (isset($filters['validated']) && $filters['validated'] !== '') {
            $where[]  = 'c.validated = %d';
            $params[] = (int) $filters['validated'];
        }

        $where_sql = implode(' AND ', $where);
        $limit_sql = $wpdb->prepare('LIMIT %d OFFSET %d', $per_page, $offset);

        $sql = "SELECT c.*
                FROM {$table} c
                WHERE {$where_sql}
                ORDER BY c.created_at DESC
                {$limit_sql}";

        if (! empty($params)) {
            // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $sql = $wpdb->prepare($sql, ...$params);
        }

        // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        return $wpdb->get_results($sql, ARRAY_A) ?: [];
    }

    public static function getCandidaturePaginated(int $limit, int $offset, string $search = ''): array
    {
        global $wpdb;

        $table = self::tableName();

        if (! empty($search)) {
            $like = '%' . $wpdb->esc_like($search) . '%';
            return $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM {$table} WHERE email LIKE %s OR nome LIKE %s OR cognome LIKE %s ORDER BY created_at DESC LIMIT %d OFFSET %d",
                    $like,
                    $like,
                    $like,
                    $limit,
                    $offset
                )
            );
        }

        return $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM {$table} ORDER BY created_at DESC LIMIT %d OFFSET %d",
                $limit,
                $offset
            )
        );
    }
    
    /**
     * Conta le candidature con gli stessi filtri (per la paginazione).
     *
     * @param array $filters Stesse chiavi di getCandidature().
     * @return int
     */
    public static function countCandidature(string $search = ''): int
    {
        global $wpdb;

        $table = self::tableName();

        if ($search !== '') {
            $like = '%' . $wpdb->esc_like($search) . '%';

            return (int) $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT COUNT(*) FROM {$table}
                    WHERE nome LIKE %s
                        OR cognome LIKE %s
                        OR email LIKE %s",
                    $like,
                    $like,
                    $like
                )
            );
        }

        return (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table}");
    }

     /**
     * Conta le candidature con gli stessi filtri (per la paginazione).
     *
     * @param array $filters Stesse chiavi di getCandidature().
     * @return int
     */
    public static function countCandidatureAdmin(array $filters = []): int
    {
        global $wpdb;

        $table = self::tableName();

        $where  = ['1=1'];
        $params = [];

        if (! empty($filters['search'])) {
            $like     = '%' . $wpdb->esc_like($filters['search']) . '%';
            $where[]  = '(c.email LIKE %s OR c.nome LIKE %s OR c.cognome LIKE %s)';
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        if (isset($filters['validated']) && $filters['validated'] !== '') {
            $where[]  = 'c.validated = %d';
            $params[] = (int) $filters['validated'];
        }

        $where_sql = implode(' AND ', $where);

        $sql = "SELECT COUNT(*) FROM {$table} c WHERE {$where_sql}";

        if (! empty($params)) {
            // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $sql = $wpdb->prepare($sql, ...$params);
        }

        // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        return (int) $wpdb->get_var($sql);
    }
}
