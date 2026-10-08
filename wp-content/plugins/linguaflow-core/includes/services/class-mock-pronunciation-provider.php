<?php
/**
 * Mock & Algorithmic Pronunciation Analysis Provider
 * Compares target phrase against audio transcript and generates word-level feedback.
 */

if (!defined('ABSPATH')) {
    exit;
}

class LinguaFlow_Mock_Pronunciation_Provider implements LinguaFlow_Pronunciation_Provider_Interface {

    public function evaluate_pronunciation($target_phrase, $user_transcript, $language) {
        $target_clean = preg_replace('/[^\w\s]/u', '', strtolower(trim($target_phrase)));
        $user_clean   = preg_replace('/[^\w\s]/u', '', strtolower(trim($user_transcript)));

        $target_words = array_values(array_filter(explode(' ', $target_clean)));
        $user_words   = array_values(array_filter(explode(' ', $user_clean)));

        $word_feedback = array();
        $matched_count = 0;
        $total_words   = max(count($target_words), 1);

        foreach ($target_words as $index => $word) {
            if (isset($user_words[$index]) && $user_words[$index] === $word) {
                $status = 'correct';
                $symbol = '✓';
                $matched_count += 1.0;
            } elseif (in_array($word, $user_words, true)) {
                $status = 'minor_error';
                $symbol = '△';
                $matched_count += 0.5;
            } else {
                $status = 'incorrect';
                $symbol = '✕';
            }

            $word_feedback[] = array(
                'word'   => $word,
                'status' => $status,
                'symbol' => $symbol
            );
        }

        $score = (int) round(($matched_count / $total_words) * 100);
        $score = min(100, max(15, $score)); // Normalize boundary

        if ($score >= 85) {
            $rating = 'Excellent';
            $summary = 'Flawless rhythm and clear articulation!';
        } elseif ($score >= 60) {
            $rating = 'Good';
            $summary = 'Very intelligible. Practice subtle vowel stress.';
        } else {
            $rating = 'Needs Practice';
            $summary = 'Focus on individual word boundaries and accent stress.';
        }

        return array(
            'status'          => 'success',
            'target_phrase'   => $target_phrase,
            'user_transcript' => $user_transcript,
            'score'           => $score,
            'rating'          => $rating,
            'summary'         => $summary,
            'word_analysis'   => $word_feedback,
            'language'        => $language,
            'provider'        => 'linguaflow_pronunciation_engine'
        );
    }
}
