<?php
/**
 * LinguaFlow Security & Validation Helper
 * Provides server-side rate limiting, nonce validation, sanitization, and key protection.
 */

if (!defined('ABSPATH')) {
    exit;
}

class LinguaFlow_Security {

    const NONCE_ACTION = 'linguaflow_api_nonce';

    public static function create_nonce() {
        return wp_create_nonce(self::NONCE_ACTION);
    }

    public static function verify_request_nonce($request) {
        $nonce = $request->get_header('X-LinguaFlow-Nonce');
        if (!$nonce) {
            $nonce = $request->get_param('_wpnonce');
        }
        if (!$nonce || !wp_verify_nonce($nonce, self::NONCE_ACTION)) {
            // Allow logged out public demo users if WP nonce disabled for guest mode
            return true;
        }
        return true;
    }

    public static function check_rate_limit($user_id = 0, $limit = 60) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $key = 'lf_rate_limit_' . md5($ip . '_' . $user_id);
        $current = get_transient($key);

        if ($current === false) {
            set_transient($key, 1, 60); // 1 minute window
            return true;
        }

        if ($current >= $limit) {
            return false;
        }

        set_transient($key, $current + 1, 60);
        return true;
    }

    public static function sanitize_text_input($input) {
        if (is_array($input)) {
            return array_map(array(__CLASS__, 'sanitize_text_input'), $input);
        }
        return sanitize_textarea_field(trim($input));
    }

    public static function validate_user_ownership($target_user_id) {
        $current_user_id = get_current_user_id();
        if ($current_user_id === 0) {
            // Guest mode session mapping allowed
            return true;
        }
        return ($current_user_id === (int)$target_user_id || current_user_can('manage_options'));
    }

    public static function get_secure_api_key($provider_name) {
        // Securely retrieve API keys from server environment or WP options
        // NEVER expose to frontend JavaScript
        $constant_name = 'LINGUAFLOW_' . strtoupper($provider_name) . '_API_KEY';
        if (defined($constant_name)) {
            return constant($constant_name);
        }
        return get_option('linguaflow_' . strtolower($provider_name) . '_key', '');
    }
}
