<?php
/**
 * LinguaFlow REST API Controller
 * Defines all REST API endpoints under /wp-json/linguaflow/v1/
 */

if (!defined('ABSPATH')) {
    exit;
}

class LinguaFlow_REST_Controller {

    const NAMESPACE = 'linguaflow/v1';

    public static function init() {
        add_action('rest_api_init', array(__CLASS__, 'register_routes'));
    }

    public static function register_routes() {
        // 1. Languages Endpoint
        register_rest_route(self::NAMESPACE, '/languages', array(
            'methods'  => WP_REST_Server::READABLE,
            'callback' => array(__CLASS__, 'get_languages'),
            'permission_callback' => '__return_true',
        ));

        // 2. Translate Endpoint
        register_rest_route(self::NAMESPACE, '/translate', array(
            'methods'  => WP_REST_Server::CREATABLE,
            'callback' => array(__CLASS__, 'translate_text'),
            'permission_callback' => array('LinguaFlow_Security', 'verify_request_nonce'),
        ));

        // 3. Transcribe Endpoint
        register_rest_route(self::NAMESPACE, '/transcribe', array(
            'methods'  => WP_REST_Server::CREATABLE,
            'callback' => array(__CLASS__, 'transcribe_audio'),
            'permission_callback' => array('LinguaFlow_Security', 'verify_request_nonce'),
        ));

        // 4. TTS Endpoint
        register_rest_route(self::NAMESPACE, '/tts', array(
            'methods'  => WP_REST_Server::CREATABLE,
            'callback' => array(__CLASS__, 'synthesize_speech'),
            'permission_callback' => '__return_true',
        ));

        // 5. Practice Endpoint
        register_rest_route(self::NAMESPACE, '/practice', array(
            'methods'  => WP_REST_Server::CREATABLE,
            'callback' => array(__CLASS__, 'evaluate_practice'),
            'permission_callback' => array('LinguaFlow_Security', 'verify_request_nonce'),
        ));

        // 6. History Endpoints
        register_rest_route(self::NAMESPACE, '/history', array(
            array(
                'methods'  => WP_REST_Server::READABLE,
                'callback' => array(__CLASS__, 'get_history'),
                'permission_callback' => '__return_true',
            ),
            array(
                'methods'  => WP_REST_Server::CREATABLE,
                'callback' => array(__CLASS__, 'add_history'),
                'permission_callback' => array('LinguaFlow_Security', 'verify_request_nonce'),
            ),
        ));

        register_rest_route(self::NAMESPACE, '/history/(?P<id>\d+)', array(
            'methods'  => WP_REST_Server::DELETABLE,
            'callback' => array(__CLASS__, 'delete_history'),
            'permission_callback' => array('LinguaFlow_Security', 'verify_request_nonce'),
        ));

        // 7. Saved Phrases Endpoints
        register_rest_route(self::NAMESPACE, '/saved', array(
            array(
                'methods'  => WP_REST_Server::READABLE,
                'callback' => array(__CLASS__, 'get_saved'),
                'permission_callback' => '__return_true',
            ),
            array(
                'methods'  => WP_REST_Server::CREATABLE,
                'callback' => array(__CLASS__, 'add_saved'),
                'permission_callback' => array('LinguaFlow_Security', 'verify_request_nonce'),
            ),
        ));

        register_rest_route(self::NAMESPACE, '/saved/(?P<id>\d+)', array(
            'methods'  => WP_REST_Server::DELETABLE,
            'callback' => array(__CLASS__, 'delete_saved'),
            'permission_callback' => array('LinguaFlow_Security', 'verify_request_nonce'),
        ));

        // 8. Progress Endpoint
        register_rest_route(self::NAMESPACE, '/progress', array(
            array(
                'methods'  => WP_REST_Server::READABLE,
                'callback' => array(__CLASS__, 'get_progress'),
                'permission_callback' => '__return_true',
            ),
            array(
                'methods'  => WP_REST_Server::CREATABLE,
                'callback' => array(__CLASS__, 'update_progress'),
                'permission_callback' => array('LinguaFlow_Security', 'verify_request_nonce'),
            )
        ));

        // 9. Travel Phrases Endpoint
        register_rest_route(self::NAMESPACE, '/travel', array(
            'methods'  => WP_REST_Server::READABLE,
            'callback' => array(__CLASS__, 'get_travel_phrases'),
            'permission_callback' => '__return_true',
        ));

        // 10. Lessons Endpoint
        register_rest_route(self::NAMESPACE, '/lessons', array(
            'methods'  => WP_REST_Server::READABLE,
            'callback' => array(__CLASS__, 'get_lessons'),
            'permission_callback' => '__return_true',
        ));
    }

    // Handlers
    public static function get_languages($request) {
        $languages = array(
            array('code' => 'en', 'name' => 'English', 'native' => 'English', 'flag' => '🇬🇧', 'speech' => true, 'tts' => true, 'pronunciation' => true),
            array('code' => 'fr', 'name' => 'French', 'native' => 'Français', 'flag' => '🇫🇷', 'speech' => true, 'tts' => true, 'pronunciation' => true),
            array('code' => 'es', 'name' => 'Spanish', 'native' => 'Español', 'flag' => '🇪🇸', 'speech' => true, 'tts' => true, 'pronunciation' => true),
            array('code' => 'de', 'name' => 'German', 'native' => 'Deutsch', 'flag' => '🇩🇪', 'speech' => true, 'tts' => true, 'pronunciation' => true),
            array('code' => 'it', 'name' => 'Italian', 'native' => 'Italiano', 'flag' => '🇮🇹', 'speech' => true, 'tts' => true, 'pronunciation' => true),
            array('code' => 'ja', 'name' => 'Japanese', 'native' => '日本語', 'flag' => '🇯🇵', 'speech' => true, 'tts' => true, 'pronunciation' => true),
            array('code' => 'zh', 'name' => 'Mandarin Chinese', 'native' => '中文', 'flag' => '🇨🇳', 'speech' => true, 'tts' => true, 'pronunciation' => true),
            array('code' => 'pt', 'name' => 'Portuguese', 'native' => 'Português', 'flag' => '🇵🇹', 'speech' => true, 'tts' => true, 'pronunciation' => true),
            array('code' => 'ru', 'name' => 'Russian', 'native' => 'Русский', 'flag' => '🇷🇺', 'speech' => true, 'tts' => true, 'pronunciation' => false),
            array('code' => 'ar', 'name' => 'Arabic', 'native' => 'العربية', 'flag' => '🇸🇦', 'speech' => true, 'tts' => true, 'pronunciation' => false),
        );
        return rest_ensure_response(array('status' => 'success', 'data' => $languages));
    }

    public static function translate_text($request) {
        if (!LinguaFlow_Security::check_rate_limit()) {
            return new WP_Error('rate_limit_exceeded', 'Too many requests. Please wait a moment.', array('status' => 429));
        }

        $params = $request->get_json_params();
        $source_text = LinguaFlow_Security::sanitize_text_input($params['source_text'] ?? '');
        $source_lang = sanitize_text_field($params['source_lang'] ?? 'en');
        $target_lang = sanitize_text_field($params['target_lang'] ?? 'fr');

        if (empty($source_text)) {
            return new WP_Error('empty_input', 'Text to translate cannot be empty.', array('status' => 400));
        }

        $provider = new LinguaFlow_Mock_Translation_Provider();
        $result = $provider->translate($source_text, $source_lang, $target_lang);

        // Auto-log to history if DB available
        global $wpdb;
        $table_history = $wpdb->prefix . 'lf_translation_history';
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_history'") === $table_history) {
            $user_id = get_current_user_id();
            $wpdb->insert($table_history, array(
                'user_id' => $user_id,
                'source_lang' => $source_lang,
                'target_lang' => $target_lang,
                'source_text' => $source_text,
                'translated_text' => $result['translated_text'],
                'created_at' => current_time('mysql')
            ));
            $result['history_id'] = $wpdb->insert_id;
        }

        return rest_ensure_response($result);
    }

    public static function transcribe_audio($request) {
        $provider = new LinguaFlow_Mock_Speech_Provider();
        $language = sanitize_text_field($request->get_param('language') ?? 'en');
        $result = $provider->transcribe_audio(null, $language);
        return rest_ensure_response($result);
    }

    public static function synthesize_speech($request) {
        $params = $request->get_json_params();
        $text = LinguaFlow_Security::sanitize_text_input($params['text'] ?? '');
        $lang = sanitize_text_field($params['language'] ?? 'en');

        $provider = new LinguaFlow_Mock_TTS_Provider();
        $result = $provider->synthesize_speech($text, $lang);
        return rest_ensure_response($result);
    }

    public static function evaluate_practice($request) {
        $params = $request->get_json_params();
        $target_phrase = LinguaFlow_Security::sanitize_text_input($params['target_phrase'] ?? '');
        $user_transcript = LinguaFlow_Security::sanitize_text_input($params['user_transcript'] ?? '');
        $language = sanitize_text_field($params['language'] ?? 'fr');

        if (empty($target_phrase) || empty($user_transcript)) {
            return new WP_Error('invalid_practice', 'Both target phrase and user transcript are required.', array('status' => 400));
        }

        $provider = new LinguaFlow_Mock_Pronunciation_Provider();
        $result = $provider->evaluate_pronunciation($target_phrase, $user_transcript, $language);

        // Record attempt in DB if table exists
        global $wpdb;
        $table_practice = $wpdb->prefix . 'lf_practice_attempts';
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_practice'") === $table_practice) {
            $user_id = get_current_user_id();
            $wpdb->insert($table_practice, array(
                'user_id' => $user_id,
                'target_text' => $target_phrase,
                'transcript_text' => $user_transcript,
                'score' => $result['score'],
                'feedback_json' => wp_json_encode($result['word_analysis']),
                'created_at' => current_time('mysql')
            ));
        }

        return rest_ensure_response($result);
    }

    public static function get_history($request) {
        global $wpdb;
        $user_id = get_current_user_id();
        $table_history = $wpdb->prefix . 'lf_translation_history';

        if ($wpdb->get_var("SHOW TABLES LIKE '$table_history'") === $table_history) {
            $items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_history WHERE user_id = %d OR user_id = 0 ORDER BY created_at DESC LIMIT 50", $user_id), ARRAY_A);
            return rest_ensure_response(array('status' => 'success', 'data' => $items));
        }

        // Mock history for initial presentation
        $mock_items = array(
            array('id' => 1, 'source_lang' => 'en', 'target_lang' => 'fr', 'source_text' => 'Where is the nearest train station?', 'translated_text' => 'Où est la gare la plus proche ?', 'created_at' => '2026-10-07 14:30:00'),
            array('id' => 2, 'source_lang' => 'en', 'target_lang' => 'es', 'source_text' => 'Can I see the menu, please?', 'translated_text' => '¿Puedo ver el menú, por favor?', 'created_at' => '2026-10-07 12:15:00'),
            array('id' => 3, 'source_lang' => 'en', 'target_lang' => 'de', 'source_text' => 'Thank you very much for your help.', 'translated_text' => 'Vielen Dank für Ihre Hilfe.', 'created_at' => '2026-10-06 18:20:00'),
        );
        return rest_ensure_response(array('status' => 'success', 'data' => $mock_items));
    }

    public static function add_history($request) {
        return self::translate_text($request);
    }

    public static function delete_history($request) {
        $id = (int)$request->get_param('id');
        global $wpdb;
        $table_history = $wpdb->prefix . 'lf_translation_history';
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_history'") === $table_history) {
            $wpdb->delete($table_history, array('id' => $id));
        }
        return rest_ensure_response(array('status' => 'success', 'message' => 'History record deleted', 'id' => $id));
    }

    public static function get_saved($request) {
        global $wpdb;
        $user_id = get_current_user_id();
        $table_saved = $wpdb->prefix . 'lf_saved_phrases';

        if ($wpdb->get_var("SHOW TABLES LIKE '$table_saved'") === $table_saved) {
            $items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_saved WHERE user_id = %d OR user_id = 0 ORDER BY created_at DESC", $user_id), ARRAY_A);
            return rest_ensure_response(array('status' => 'success', 'data' => $items));
        }

        $mock_saved = array(
            array('id' => 101, 'source_lang' => 'en', 'target_lang' => 'fr', 'source_text' => 'Where is the nearest train station?', 'translated_text' => 'Où est la gare la plus proche ?', 'category' => 'Transport', 'created_at' => '2026-10-07 10:00:00'),
            array('id' => 102, 'source_lang' => 'en', 'target_lang' => 'fr', 'source_text' => 'Do you have vegetarian food?', 'translated_text' => 'Avez-vous des plats végétariens ?', 'category' => 'Restaurant', 'created_at' => '2026-10-06 16:45:00'),
        );
        return rest_ensure_response(array('status' => 'success', 'data' => $mock_saved));
    }

    public static function add_saved($request) {
        $params = $request->get_json_params();
        $source_text = LinguaFlow_Security::sanitize_text_input($params['source_text'] ?? '');
        $translated_text = LinguaFlow_Security::sanitize_text_input($params['translated_text'] ?? '');
        $source_lang = sanitize_text_field($params['source_lang'] ?? 'en');
        $target_lang = sanitize_text_field($params['target_lang'] ?? 'fr');
        $category = sanitize_text_field($params['category'] ?? 'General');

        global $wpdb;
        $table_saved = $wpdb->prefix . 'lf_saved_phrases';
        $user_id = get_current_user_id();

        if ($wpdb->get_var("SHOW TABLES LIKE '$table_saved'") === $table_saved) {
            $wpdb->insert($table_saved, array(
                'user_id' => $user_id,
                'source_lang' => $source_lang,
                'target_lang' => $target_lang,
                'source_text' => $source_text,
                'translated_text' => $translated_text,
                'category' => $category,
                'created_at' => current_time('mysql')
            ));
            $id = $wpdb->insert_id;
        } else {
            $id = rand(100, 999);
        }

        return rest_ensure_response(array(
            'status' => 'success',
            'message' => 'Phrase saved to notebook',
            'data' => array(
                'id' => $id,
                'source_lang' => $source_lang,
                'target_lang' => $target_lang,
                'source_text' => $source_text,
                'translated_text' => $translated_text,
                'category' => $category
            )
        ));
    }

    public static function delete_saved($request) {
        $id = (int)$request->get_param('id');
        global $wpdb;
        $table_saved = $wpdb->prefix . 'lf_saved_phrases';
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_saved'") === $table_saved) {
            $wpdb->delete($table_saved, array('id' => $id));
        }
        return rest_ensure_response(array('status' => 'success', 'message' => 'Saved phrase removed', 'id' => $id));
    }

    public static function get_progress($request) {
        return rest_ensure_response(array(
            'status' => 'success',
            'data' => array(
                'xp_points' => 1240,
                'streak_days' => 7,
                'translations_count' => 48,
                'practice_sessions' => 19,
                'saved_phrases' => 14,
                'languages' => array(
                    array('code' => 'fr', 'name' => 'French', 'level' => 'B1 Intermediate', 'progress' => 78),
                    array('code' => 'es', 'name' => 'Spanish', 'level' => 'A2 Elementary', 'progress' => 42),
                    array('code' => 'de', 'name' => 'German', 'level' => 'A1 Beginner', 'progress' => 25),
                )
            )
        ));
    }

    public static function update_progress($request) {
        return rest_ensure_response(array('status' => 'success', 'message' => 'Progress updated'));
    }

    public static function get_travel_phrases($request) {
        $travel_packs = array(
            'restaurant' => array(
                'title' => 'Restaurant & Dining',
                'icon' => 'utensils',
                'phrases' => array(
                    array('id' => 't1', 'en' => 'Can I see the menu, please?', 'fr' => 'Puis-je voir le menu, s\'il vous plaît ?', 'es' => '¿Puedo ver el menú, por favor?'),
                    array('id' => 't2', 'en' => 'Do you have vegetarian food?', 'fr' => 'Avez-vous des plats végétariens ?', 'es' => '¿Tienen comida vegetariana?'),
                    array('id' => 't3', 'en' => 'How much does this cost?', 'fr' => 'Combien cela coûte-t-il ?', 'es' => '¿Cuánto cuesta esto?'),
                    array('id' => 't4', 'en' => 'The bill, please.', 'fr' => 'L\'addition, s\'il vous plaît.', 'es' => 'La cuenta, por favor.'),
                )
            ),
            'transport' => array(
                'title' => 'Transport & Travel',
                'icon' => 'train',
                'phrases' => array(
                    array('id' => 't5', 'en' => 'Where is the nearest train station?', 'fr' => 'Où est la gare la plus proche ?', 'es' => '¿Dónde está la estación de tren más cercana?'),
                    array('id' => 't6', 'en' => 'Where can I buy a ticket?', 'fr' => 'Où puis-je acheter un billet ?', 'es' => '¿Dónde puedo comprar un billete?'),
                    array('id' => 't7', 'en' => 'Does this train go to Paris?', 'fr' => 'Ce train va-t-il à Paris ?', 'es' => '¿Este tren va a París?'),
                )
            ),
            'hotel' => array(
                'title' => 'Hotel & Accommodation',
                'icon' => 'hotel',
                'phrases' => array(
                    array('id' => 't8', 'en' => 'I have a reservation.', 'fr' => 'J\'ai une réservation.', 'es' => 'Tengo una reserva.'),
                    array('id' => 't9', 'en' => 'What time is check-out?', 'fr' => 'À quelle heure est le départ ?', 'es' => '¿A qué hora es la salida?'),
                    array('id' => 't10', 'en' => 'Is Wi-Fi included?', 'fr' => 'Le Wi-Fi est-il inclus ?', 'es' => '¿El Wi-Fi está incluido?'),
                )
            ),
            'medical' => array(
                'title' => 'Emergency & Medical',
                'icon' => 'hospital',
                'phrases' => array(
                    array('id' => 't11', 'en' => 'I need help, please.', 'fr' => 'J\'ai besoin d\'aide, s\'il vous plaît.', 'es' => 'Necesito ayuda, por favor.'),
                    array('id' => 't12', 'en' => 'Where is the nearest pharmacy?', 'fr' => 'Où est la pharmacie la plus proche ?', 'es' => '¿Dónde está la farmacia más cercana?'),
                )
            )
        );
        return rest_ensure_response(array('status' => 'success', 'data' => $travel_packs));
    }

    public static function get_lessons($request) {
        $lessons = array(
            array(
                'id' => 'l1',
                'title' => 'Essential Conversational French',
                'level' => 'B1 Intermediate',
                'language' => 'fr',
                'duration' => '15 mins',
                'completed' => 78,
                'description' => 'Master everyday polite phrases, transport inquiries, and cafe dining conversations.'
            ),
            array(
                'id' => 'l2',
                'title' => 'Spanish Travel & Hotel Mastery',
                'level' => 'A2 Elementary',
                'language' => 'es',
                'duration' => '12 mins',
                'completed' => 42,
                'description' => 'Confidently check in, order meals, and navigate cities in Spanish.'
            ),
            array(
                'id' => 'l3',
                'title' => 'German Business & Pronunciation Focus',
                'level' => 'A1 Beginner',
                'language' => 'de',
                'duration' => '20 mins',
                'completed' => 25,
                'description' => 'Learn precise German phonetics, stress rules, and formal greetings.'
            )
        );
        return rest_ensure_response(array('status' => 'success', 'data' => $lessons));
    }
}
