<?php
/**
 * LinguaFlow Theme Functions
 */

if (!defined('ABSPATH')) {
    exit;
}

define('LINGUAFLOW_THEME_DIR', get_template_directory());
define('LINGUAFLOW_THEME_URI', get_template_directory_uri());

function linguaflow_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

    register_nav_menus(array(
        'primary' => __('Primary Header Navigation', 'linguaflow'),
        'mobile_bottom' => __('Mobile Bottom Navigation', 'linguaflow'),
    ));
}
add_action('after_setup_theme', 'linguaflow_theme_setup');

function linguaflow_enqueue_assets() {
    // Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&display=swap', array(), null);

    // Main Styling
    wp_enqueue_style('linguaflow-main', LINGUAFLOW_THEME_URI . '/assets/css/linguaflow-main.css', array(), '1.0.0');

    // JS Scripts
    wp_enqueue_script('linguaflow-app', LINGUAFLOW_THEME_URI . '/assets/js/app.js', array(), '1.0.0', true);
    wp_enqueue_script('linguaflow-speech', LINGUAFLOW_THEME_URI . '/assets/js/speech.js', array('linguaflow-app'), '1.0.0', true);
    wp_enqueue_script('linguaflow-recorder', LINGUAFLOW_THEME_URI . '/assets/js/recorder.js', array('linguaflow-app'), '1.0.0', true);
    wp_enqueue_script('linguaflow-translator', LINGUAFLOW_THEME_URI . '/assets/js/translator.js', array('linguaflow-speech', 'linguaflow-recorder'), '1.0.0', true);
    wp_enqueue_script('linguaflow-pronunciation', LINGUAFLOW_THEME_URI . '/assets/js/pronunciation.js', array('linguaflow-recorder'), '1.0.0', true);
    wp_enqueue_script('linguaflow-conversation', LINGUAFLOW_THEME_URI . '/assets/js/conversation.js', array('linguaflow-speech'), '1.0.0', true);
    wp_enqueue_script('linguaflow-travel', LINGUAFLOW_THEME_URI . '/assets/js/travel.js', array('linguaflow-app'), '1.0.0', true);
    wp_enqueue_script('linguaflow-dashboard', LINGUAFLOW_THEME_URI . '/assets/js/dashboard.js', array('linguaflow-app'), '1.0.0', true);
    wp_enqueue_script('linguaflow-pwa', LINGUAFLOW_THEME_URI . '/assets/js/pwa.js', array(), '1.0.0', true);

    // Localize Script Configuration
    $nonce = class_exists('LinguaFlow_Security') ? LinguaFlow_Security::create_nonce() : wp_create_nonce('linguaflow_api_nonce');
    wp_localize_script('linguaflow-app', 'LinguaFlowConfig', array(
        'apiUrl' => esc_url_raw(rest_url('linguaflow/v1')),
        'nonce'  => $nonce,
        'siteUrl' => esc_url(home_url('/')),
        'themeUrl' => esc_url(LINGUAFLOW_THEME_URI),
        'currentUser' => get_current_user_id()
    ));
}
add_action('wp_enqueue_scripts', 'linguaflow_enqueue_assets');

// Custom Template Virtual Routing
function linguaflow_virtual_template_redirect() {
    $request_uri = strtok($_SERVER['REQUEST_URI'] ?? '', '?');
    $path = trim($request_uri, '/');

    $routes = array(
        'translate'    => 'page-translate.php',
        'conversation' => 'page-conversation.php',
        'practice'     => 'page-practice.php',
        'travel'       => 'page-travel.php',
        'learn'        => 'page-learn.php',
        'dashboard'    => 'page-dashboard.php',
    );

    if (isset($routes[$path])) {
        $template_file = LINGUAFLOW_THEME_DIR . '/' . $routes[$path];
        if (file_exists($template_file)) {
            status_header(200);
            include $template_file;
            exit;
        }
    }
}
add_action('template_redirect', 'linguaflow_virtual_template_redirect');
