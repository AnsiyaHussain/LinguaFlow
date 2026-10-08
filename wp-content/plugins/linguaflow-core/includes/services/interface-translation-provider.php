<?php
/**
 * Translation Provider Interface
 */
if (!defined('ABSPATH')) {
    exit;
}

interface LinguaFlow_Translation_Provider_Interface {
    /**
     * Translate text from source language to target language.
     *
     * @param string $text Source text to translate.
     * @param string $source_lang Source language ISO code (e.g., 'en').
     * @param string $target_lang Target language ISO code (e.g., 'fr').
     * @return array Array with 'translated_text', 'detected_source_lang', and 'status'.
     */
    public function translate($text, $source_lang, $target_lang);
}
