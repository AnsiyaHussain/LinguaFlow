<?php
/**
 * Mock Text-To-Speech Provider
 */

if (!defined('ABSPATH')) {
    exit;
}

class LinguaFlow_Mock_TTS_Provider implements LinguaFlow_TTS_Provider_Interface {

    public function synthesize_speech($text, $language, $voice = 'default') {
        return array(
            'status' => 'success',
            'text' => $text,
            'language' => $language,
            'voice' => $voice,
            'audio_url' => '', // Web Speech API used primarily on client side; fallback audio data structural representation
            'format' => 'audio/mp3',
            'provider' => 'mock_tts'
        );
    }
}
