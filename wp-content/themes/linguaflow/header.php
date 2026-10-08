<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php wp_title('|', true, 'right'); ?> LinguaFlow — Speak. Understand. Connect.</title>

    <link rel="manifest" href="<?php echo esc_url(get_template_directory_uri() . '/manifest.json'); ?>">
    <meta name="theme-color" content="#141413">
    <meta name="description" content="LinguaFlow — Multilingual translation, voice transcription, pronunciation practice, and language-learning SaaS platform.">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Main Header Desktop Navigation -->
<header class="lf-header">
    <div class="lf-container lf-header-inner">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="lf-brand">
            LINGUAFLOW
            <span class="lf-brand-badge">PRO</span>
        </a>

        <nav class="lf-nav-desktop">
            <a href="<?php echo esc_url(home_url('/translate')); ?>" class="lf-nav-link <?php echo is_page('translate') || $_SERVER['REQUEST_URI'] === '/translate' ? 'active' : ''; ?>">Translate</a>
            <a href="<?php echo esc_url(home_url('/conversation')); ?>" class="lf-nav-link <?php echo is_page('conversation') || $_SERVER['REQUEST_URI'] === '/conversation' ? 'active' : ''; ?>">Conversation</a>
            <a href="<?php echo esc_url(home_url('/practice')); ?>" class="lf-nav-link <?php echo is_page('practice') || $_SERVER['REQUEST_URI'] === '/practice' ? 'active' : ''; ?>">Practice</a>
            <a href="<?php echo esc_url(home_url('/travel')); ?>" class="lf-nav-link <?php echo is_page('travel') || $_SERVER['REQUEST_URI'] === '/travel' ? 'active' : ''; ?>">Travel Packs</a>
            <a href="<?php echo esc_url(home_url('/learn')); ?>" class="lf-nav-link <?php echo is_page('learn') || $_SERVER['REQUEST_URI'] === '/learn' ? 'active' : ''; ?>">Learning</a>
            <a href="<?php echo esc_url(home_url('/dashboard')); ?>" class="lf-nav-link <?php echo is_page('dashboard') || $_SERVER['REQUEST_URI'] === '/dashboard' ? 'active' : ''; ?>">Dashboard</a>
        </nav>

        <div class="lf-header-actions">
            <button id="lf-pwa-install-btn" class="lf-btn lf-btn-sm lf-btn-outline" style="display: none;">📲 Install App</button>
            <a href="<?php echo esc_url(home_url('/dashboard')); ?>" class="lf-btn lf-btn-sm lf-btn-primary">Notebook & Profile</a>
        </div>
    </div>
</header>

<!-- Mobile Bottom Navigation (< 768px Viewports) -->
<nav class="lf-bottom-nav">
    <div class="lf-bottom-nav-items">
        <a href="<?php echo esc_url(home_url('/translate')); ?>" class="lf-bottom-item <?php echo $_SERVER['REQUEST_URI'] === '/translate' || is_front_page() ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M5 8l6 6M4 14l6-6 2 2M2 5h12M9 2v3M22 22l-5-10-5 10M14 18h6"/></svg>
            <span>Translate</span>
        </a>
        <a href="<?php echo esc_url(home_url('/conversation')); ?>" class="lf-bottom-item <?php echo $_SERVER['REQUEST_URI'] === '/conversation' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
            <span>Talk</span>
        </a>
        <a href="<?php echo esc_url(home_url('/practice')); ?>" class="lf-bottom-item <?php echo $_SERVER['REQUEST_URI'] === '/practice' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
            <span>Practice</span>
        </a>
        <a href="<?php echo esc_url(home_url('/travel')); ?>" class="lf-bottom-item <?php echo $_SERVER['REQUEST_URI'] === '/travel' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
            <span>Travel</span>
        </a>
        <a href="<?php echo esc_url(home_url('/dashboard')); ?>" class="lf-bottom-item <?php echo $_SERVER['REQUEST_URI'] === '/dashboard' ? 'active' : ''; ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <span>Profile</span>
        </a>
    </div>
</nav>

<main class="lf-main-content">
