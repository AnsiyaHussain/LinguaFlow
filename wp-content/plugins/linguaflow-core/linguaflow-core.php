<?php
/**
 * Plugin Name: LinguaFlow Core
 * Plugin URI: https://linguaflow.app
 * Description: Core engine for LinguaFlow — Multilingual translation, voice transcription, pronunciation practice, and language learning SaaS application.
 * Version: 1.0.0
 * Author: LinguaFlow Engineering Team
 * Text Domain: linguaflow
 * License: GPL-2.0+
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('LINGUAFLOW_VERSION', '1.0.0');
define('LINGUAFLOW_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('LINGUAFLOW_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required classes
require_once LINGUAFLOW_PLUGIN_DIR . 'includes/class-linguaflow-db.php';
require_once LINGUAFLOW_PLUGIN_DIR . 'includes/class-linguaflow-post-types.php';
require_once LINGUAFLOW_PLUGIN_DIR . 'includes/class-linguaflow-security.php';

// Include provider abstractions & services
require_once LINGUAFLOW_PLUGIN_DIR . 'includes/services/interface-translation-provider.php';
require_once LINGUAFLOW_PLUGIN_DIR . 'includes/services/class-mock-translation-provider.php';
require_once LINGUAFLOW_PLUGIN_DIR . 'includes/services/interface-speech-provider.php';
require_once LINGUAFLOW_PLUGIN_DIR . 'includes/services/class-mock-speech-provider.php';
require_once LINGUAFLOW_PLUGIN_DIR . 'includes/services/interface-tts-provider.php';
require_once LINGUAFLOW_PLUGIN_DIR . 'includes/services/class-mock-tts-provider.php';
require_once LINGUAFLOW_PLUGIN_DIR . 'includes/services/interface-pronunciation-provider.php';
require_once LINGUAFLOW_PLUGIN_DIR . 'includes/services/class-mock-pronunciation-provider.php';

// Include REST API Controller
require_once LINGUAFLOW_PLUGIN_DIR . 'api/class-linguaflow-rest-controller.php';

/**
 * Main Plugin Class
 */
class LinguaFlow_Core {
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));

        add_action('plugins_loaded', array($this, 'init'));
    }

    public function init() {
        LinguaFlow_Post_Types::init();
        LinguaFlow_REST_Controller::init();
    }

    public function activate() {
        LinguaFlow_DB::create_tables();
        LinguaFlow_Post_Types::register_all();
        flush_rewrite_rules();
    }

    public function deactivate() {
        flush_rewrite_rules();
    }
}

// Instantiate plugin
LinguaFlow_Core::get_instance();
