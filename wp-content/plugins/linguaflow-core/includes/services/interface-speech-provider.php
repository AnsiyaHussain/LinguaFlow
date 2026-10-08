<?php
/**
 * Speech Recognition Provider Interface
 */
if (!defined('ABSPATH')) {
    exit;
}

interface LinguaFlow_Speech_Provider_Interface {
    public function transcribe_audio($audio_data, $language);
}
