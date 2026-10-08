<?php
/**
 * LinguaFlow Post Types & Taxonomies
 * Registers Custom Post Types for WordPress Admin backend.
 */

if (!defined('ABSPATH')) {
    exit;
}

class LinguaFlow_Post_Types {

    public static function init() {
        add_action('init', array(__CLASS__, 'register_all'));
    }

    public static function register_all() {
        self::register_taxonomies();
        self::register_post_types();
    }

    private static function register_taxonomies() {
        // Difficulty Taxonomy
        register_taxonomy('lf_difficulty', array('lf_lesson', 'lf_phrase', 'lf_exercise'), array(
            'labels' => array(
                'name' => __('Difficulties', 'linguaflow'),
                'singular_name' => __('Difficulty', 'linguaflow'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'show_in_rest' => true,
        ));

        // Category Taxonomy
        register_taxonomy('lf_category', array('lf_phrase', 'lf_travel_pack', 'lf_vocabulary'), array(
            'labels' => array(
                'name' => __('Categories', 'linguaflow'),
                'singular_name' => __('Category', 'linguaflow'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'show_in_rest' => true,
        ));

        // Topic Taxonomy
        register_taxonomy('lf_topic', array('lf_lesson', 'lf_travel_pack'), array(
            'labels' => array(
                'name' => __('Topics', 'linguaflow'),
                'singular_name' => __('Topic', 'linguaflow'),
            ),
            'hierarchical' => true,
            'show_ui' => true,
            'show_in_rest' => true,
        ));
    }

    private static function register_post_types() {
        // 1. Languages
        register_post_type('lf_language', array(
            'labels' => array(
                'name' => __('Languages', 'linguaflow'),
                'singular_name' => __('Language', 'linguaflow'),
            ),
            'public' => true,
            'has_archive' => false,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-translation',
            'supports' => array('title', 'editor', 'custom-fields', 'thumbnail'),
        ));

        // 2. Lessons
        register_post_type('lf_lesson', array(
            'labels' => array(
                'name' => __('Lessons', 'linguaflow'),
                'singular_name' => __('Lesson', 'linguaflow'),
            ),
            'public' => true,
            'has_archive' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-welcome-learn-more',
            'supports' => array('title', 'editor', 'excerpt', 'custom-fields', 'thumbnail'),
        ));

        // 3. Phrases
        register_post_type('lf_phrase', array(
            'labels' => array(
                'name' => __('Phrases', 'linguaflow'),
                'singular_name' => __('Phrase', 'linguaflow'),
            ),
            'public' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-format-quote',
            'supports' => array('title', 'editor', 'custom-fields'),
        ));

        // 4. Vocabulary
        register_post_type('lf_vocabulary', array(
            'labels' => array(
                'name' => __('Vocabulary', 'linguaflow'),
                'singular_name' => __('Vocabulary Item', 'linguaflow'),
            ),
            'public' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-book-alt',
            'supports' => array('title', 'editor', 'custom-fields'),
        ));

        // 5. Exercises
        register_post_type('lf_exercise', array(
            'labels' => array(
                'name' => __('Pronunciation Exercises', 'linguaflow'),
                'singular_name' => __('Exercise', 'linguaflow'),
            ),
            'public' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-microphone',
            'supports' => array('title', 'editor', 'custom-fields'),
        ));

        // 6. Travel Phrase Packs
        register_post_type('lf_travel_pack', array(
            'labels' => array(
                'name' => __('Travel Phrase Packs', 'linguaflow'),
                'singular_name' => __('Travel Pack', 'linguaflow'),
            ),
            'public' => true,
            'show_in_rest' => true,
            'menu_icon' => 'dashicons-airplane',
            'supports' => array('title', 'editor', 'custom-fields'),
        ));
    }
}
