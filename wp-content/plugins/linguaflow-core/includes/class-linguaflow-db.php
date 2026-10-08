<?php
/**
 * LinguaFlow Database Management
 * Handles custom DB tables creation and data access layer.
 */

if (!defined('ABSPATH')) {
    exit;
}

class LinguaFlow_DB {

    public static function create_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // 1. Translation History Table
        $table_history = $wpdb->prefix . 'lf_translation_history';
        $sql_history = "CREATE TABLE $table_history (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL DEFAULT 0,
            source_lang varchar(10) NOT NULL,
            target_lang varchar(10) NOT NULL,
            source_text text NOT NULL,
            translated_text text NOT NULL,
            audio_url varchar(255) DEFAULT '',
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            KEY user_id (user_id),
            KEY created_at (created_at)
        ) $charset_collate;";

        // 2. Practice Attempts Table
        $table_practice = $wpdb->prefix . 'lf_practice_attempts';
        $sql_practice = "CREATE TABLE $table_practice (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL DEFAULT 0,
            phrase_id bigint(20) DEFAULT 0,
            target_text text NOT NULL,
            transcript_text text NOT NULL,
            score int(11) NOT NULL DEFAULT 0,
            feedback_json text DEFAULT '',
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            KEY user_id (user_id),
            KEY score (score)
        ) $charset_collate;";

        // 3. User Progress Table
        $table_progress = $wpdb->prefix . 'lf_user_progress';
        $sql_progress = "CREATE TABLE $table_progress (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL DEFAULT 0,
            language_code varchar(10) NOT NULL DEFAULT 'fr',
            xp_points int(11) NOT NULL DEFAULT 0,
            streak_days int(11) NOT NULL DEFAULT 1,
            phrases_learned int(11) NOT NULL DEFAULT 0,
            last_active datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY user_lang (user_id, language_code)
        ) $charset_collate;";

        // 4. Saved Phrases Table
        $table_saved = $wpdb->prefix . 'lf_saved_phrases';
        $sql_saved = "CREATE TABLE $table_saved (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            user_id bigint(20) NOT NULL DEFAULT 0,
            source_lang varchar(10) NOT NULL,
            target_lang varchar(10) NOT NULL,
            source_text text NOT NULL,
            translated_text text NOT NULL,
            category varchar(50) DEFAULT 'General',
            created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id),
            KEY user_id (user_id),
            KEY category (category)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql_history);
        dbDelta($sql_practice);
        dbDelta($sql_progress);
        dbDelta($sql_saved);
    }
}
