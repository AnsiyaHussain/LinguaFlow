<?php
/**
 * Pronunciation Provider Interface
 */
if (!defined('ABSPATH')) {
    exit;
}

interface LinguaFlow_Pronunciation_Provider_Interface {
    /**
     * Evaluate spoken user transcript against target phrase.
     *
     * @param string $target_phrase Expected correct phrase.
     * @param string $user_transcript Spoken transcript captured from microphone.
     * @param string $language Target language ISO code.
     * @return array Evaluation details including overall score, word-level breakdown, and rating.
     */
    public function evaluate_pronunciation($target_phrase, $user_transcript, $language);
}
