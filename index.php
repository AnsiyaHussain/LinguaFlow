<?php
/**
 * LinguaFlow - Main Application Entry & Server Router Bootstrap
 * Supports standard WordPress execution and standalone PHP Built-In Web Server execution.
 */

// If running via PHP built-in web server, serve static files directly
if (php_sapi_name() === 'cli-server') {
    $request_file = __DIR__ . strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    if (is_file($request_file)) {
        return false;
    }
}

// Define standard WordPress ABSPATH if not present
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

// Helper stub functions for standalone execution
if (!function_exists('add_action')) {
    function add_action($hook, $callback) {}
    function add_theme_support($feature) {}
    function register_nav_menus($menus) {}
    function wp_enqueue_style($handle, $src = '', $deps = array(), $ver = false) {}
    function wp_enqueue_script($handle, $src = '', $deps = array(), $ver = false, $in_footer = false) {}
    function wp_localize_script($handle, $object_name, $l10n) {}
    function esc_url($url) { return htmlspecialchars($url ?? '', ENT_QUOTES, 'UTF-8'); }
    function esc_url_raw($url) { return $url; }
    function esc_attr($text) { return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8'); }
    function home_url($path = '') { return '/' . ltrim($path, '/'); }
    function get_template_directory_uri() { return '/wp-content/themes/linguaflow'; }
    function get_template_directory() { return __DIR__ . '/wp-content/themes/linguaflow'; }
    function wp_title($sep = '|', $display = true, $seplocation = '') { echo 'LinguaFlow'; }
    function language_attributes() { echo 'lang="en-US"'; }
    function body_class() { echo 'class="linguaflow-app"'; }
    function wp_head() {
        echo '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&display=swap">';
        echo '<link rel="stylesheet" href="/wp-content/themes/linguaflow/assets/css/linguaflow-main.css">';
    }
    function wp_body_open() {}
    function wp_footer() {
        echo '<script src="/wp-content/themes/linguaflow/assets/js/app.js"></script>';
        echo '<script src="/wp-content/themes/linguaflow/assets/js/speech.js"></script>';
        echo '<script src="/wp-content/themes/linguaflow/assets/js/recorder.js"></script>';
        echo '<script src="/wp-content/themes/linguaflow/assets/js/translator.js"></script>';
        echo '<script src="/wp-content/themes/linguaflow/assets/js/pronunciation.js"></script>';
        echo '<script src="/wp-content/themes/linguaflow/assets/js/conversation.js"></script>';
        echo '<script src="/wp-content/themes/linguaflow/assets/js/travel.js"></script>';
        echo '<script src="/wp-content/themes/linguaflow/assets/js/dashboard.js"></script>';
        echo '<script src="/wp-content/themes/linguaflow/assets/js/pwa.js"></script>';
    }
    function get_header() { include __DIR__ . '/wp-content/themes/linguaflow/header.php'; }
    function get_footer() { include __DIR__ . '/wp-content/themes/linguaflow/footer.php'; }
    function is_front_page() { return $_SERVER['REQUEST_URI'] === '/' || $_SERVER['REQUEST_URI'] === '/index.php'; }
    function is_page($page) { return strpos($_SERVER['REQUEST_URI'], $page) !== false; }
    function get_current_user_id() { return 1; }
    function bloginfo($show = 'name') {
        if ($show === 'charset') echo 'UTF-8';
        elseif ($show === 'name') echo 'LinguaFlow';
        elseif ($show === 'description') echo 'Speak. Understand. Connect.';
        else echo '';
    }
    function have_posts() { return false; }
    function the_post() {}
    function the_ID() { echo '1'; }
    function post_class($class = '') { echo 'class="' . esc_attr($class) . '"'; }
    function the_title() { echo 'LinguaFlow'; }
    function the_content() { echo ''; }
    function sanitize_text_field($str) { return trim(strip_tags($str)); }
    function sanitize_textarea_field($str) { return trim(strip_tags($str)); }
    function wp_create_nonce($action) { return md5($action . 'lf_secret'); }
    function wp_verify_nonce($nonce, $action) { return true; }
    function rest_url($path = '') { return '/wp-json/' . ltrim($path, '/'); }
}

// Load Core Services
require_once __DIR__ . '/wp-content/plugins/linguaflow-core/includes/services/interface-translation-provider.php';
require_once __DIR__ . '/wp-content/plugins/linguaflow-core/includes/services/class-mock-translation-provider.php';
require_once __DIR__ . '/wp-content/plugins/linguaflow-core/includes/services/interface-speech-provider.php';
require_once __DIR__ . '/wp-content/plugins/linguaflow-core/includes/services/class-mock-speech-provider.php';
require_once __DIR__ . '/wp-content/plugins/linguaflow-core/includes/services/interface-tts-provider.php';
require_once __DIR__ . '/wp-content/plugins/linguaflow-core/includes/services/class-mock-tts-provider.php';
require_once __DIR__ . '/wp-content/plugins/linguaflow-core/includes/services/interface-pronunciation-provider.php';
require_once __DIR__ . '/wp-content/plugins/linguaflow-core/includes/services/class-mock-pronunciation-provider.php';

// Dispatch REST API Requests
$request_uri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');

if (strpos($request_uri, '/wp-json/linguaflow/v1/') === 0) {
    header('Content-Type: application/json; charset=utf-8');
    $endpoint = str_replace('/wp-json/linguaflow/v1/', '', $request_uri);
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $raw_input = file_get_contents('php://input');
    $input_json = json_decode($raw_input, true) ?: array();
    $request_data = array_merge($_REQUEST, $_POST, $input_json);

    if ($endpoint === 'translate' && ($method === 'POST' || $method === 'GET')) {
        $provider = new LinguaFlow_Mock_Translation_Provider();
        $source_text = $request_data['source_text'] ?? $request_data['text'] ?? '';
        $source_lang = $request_data['source_lang'] ?? 'en';
        $target_lang = $request_data['target_lang'] ?? 'fr';
        echo json_encode($provider->translate($source_text, $source_lang, $target_lang));
        exit;
    }

    if ($endpoint === 'practice' && $method === 'POST') {
        $provider = new LinguaFlow_Mock_Pronunciation_Provider();
        $target = $input_json['target_phrase'] ?? '';
        $transcript = $input_json['user_transcript'] ?? '';
        $lang = $input_json['language'] ?? 'fr';
        echo json_encode($provider->evaluate_pronunciation($target, $transcript, $lang));
        exit;
    }

    if ($endpoint === 'saved' && $method === 'POST') {
        echo json_encode(array(
            'status' => 'success',
            'message' => 'Saved to notebook',
            'data' => $input_json
        ));
        exit;
    }

    if ($endpoint === 'saved') {
        echo json_encode(array(
            'status' => 'success',
            'data' => array(
                array('id' => 101, 'source_lang' => 'en', 'target_lang' => 'fr', 'source_text' => 'Where is the nearest train station?', 'translated_text' => 'Où est la gare la plus proche ?', 'category' => 'Transport', 'created_at' => '2026-10-07 10:00:00'),
                array('id' => 102, 'source_lang' => 'en', 'target_lang' => 'fr', 'source_text' => 'Do you have vegetarian food?', 'translated_text' => 'Avez-vous des plats végétariens ?', 'category' => 'Restaurant', 'created_at' => '2026-10-06 16:45:00')
            )
        ));
        exit;
    }

    if ($endpoint === 'history') {
        echo json_encode(array(
            'status' => 'success',
            'data' => array(
                array('id' => 1, 'source_lang' => 'en', 'target_lang' => 'fr', 'source_text' => 'Where is the nearest train station?', 'translated_text' => 'Où est la gare la plus proche ?', 'created_at' => '2026-10-07 14:30:00'),
                array('id' => 2, 'source_lang' => 'en', 'target_lang' => 'es', 'source_text' => 'Can I see the menu, please?', 'translated_text' => '¿Puedo ver el menú, por favor?', 'created_at' => '2026-10-07 12:15:00')
            )
        ));
        exit;
    }

    if ($endpoint === 'travel') {
        echo json_encode(array(
            'status' => 'success',
            'data' => array(
                'restaurant' => array(
                    'title' => 'Restaurant & Dining',
                    'phrases' => array(
                        array('id' => 't1', 'en' => 'Can I see the menu, please?', 'fr' => 'Puis-je voir le menu, s\'il vous plaît ?'),
                        array('id' => 't2', 'en' => 'Do you have vegetarian food?', 'fr' => 'Avez-vous des plats végétariens ?'),
                        array('id' => 't3', 'en' => 'How much does this cost?', 'fr' => 'Combien cela coûte-t-il ?'),
                        array('id' => 't4', 'en' => 'The bill, please.', 'fr' => 'L\'addition, s\'il vous plaît.')
                    )
                ),
                'transport' => array(
                    'title' => 'Transport & Travel',
                    'phrases' => array(
                        array('id' => 't5', 'en' => 'Where is the nearest train station?', 'fr' => 'Où est la gare la plus proche ?'),
                        array('id' => 't6', 'en' => 'Where can I buy a ticket?', 'fr' => 'Où puis-je acheter un billet ?')
                    )
                ),
                'hotel' => array(
                    'title' => 'Hotel & Accommodation',
                    'phrases' => array(
                        array('id' => 't8', 'en' => 'I have a reservation.', 'fr' => 'J\'ai une réservation.'),
                        array('id' => 't9', 'en' => 'What time is check-out?', 'fr' => 'À quelle heure est le départ ?')
                    )
                ),
                'medical' => array(
                    'title' => 'Emergency & Medical',
                    'phrases' => array(
                        array('id' => 't11', 'en' => 'I need help, please.', 'fr' => 'J\'ai besoin d\'aide, s\'il vous plaît.'),
                        array('id' => 't12', 'en' => 'Where is the nearest pharmacy?', 'fr' => 'Où est la pharmacie la plus proche ?')
                    )
                )
            )
        ));
        exit;
    }
}

// Dispatch Frontend Views
$routes = array(
    '/'             => '/wp-content/themes/linguaflow/front-page.php',
    '/translate'    => '/wp-content/themes/linguaflow/page-translate.php',
    '/conversation' => '/wp-content/themes/linguaflow/page-conversation.php',
    '/practice'     => '/wp-content/themes/linguaflow/page-practice.php',
    '/travel'       => '/wp-content/themes/linguaflow/page-travel.php',
    '/learn'        => '/wp-content/themes/linguaflow/page-learn.php',
    '/dashboard'    => '/wp-content/themes/linguaflow/page-dashboard.php',
);

$target_file = $routes[$request_uri] ?? '/wp-content/themes/linguaflow/front-page.php';
include __DIR__ . $target_file;
