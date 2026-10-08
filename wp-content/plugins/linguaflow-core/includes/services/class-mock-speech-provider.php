<?php
/**
 * Mock Speech Recognition Provider
 */

if (!defined('ABSPATH')) {
    exit;
}

class LinguaFlow_Mock_Speech_Provider implements LinguaFlow_Speech_Provider_Interface {

    public function transcribe_audio($audio_data, $language) {
        // Return structured transcription response
        return array(
            'status' => 'success',
            'transcript' => 'Where is the nearest train station?',
            'confidence' => 0.96,
            'language' => $language,
            'provider' => 'mock_speech'
        );
    }
}
