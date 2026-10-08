<?php
/**
 * Text-to-Speech (TTS) Provider Interface
 */
if (!defined('ABSPATH')) {
    exit;
}

interface LinguaFlow_TTS_Provider_Interface {
    public function synthesize_speech($text, $language, $voice = 'default');
}
