<?php
/**
 * Template Name: Landing Page (Front Page)
 */
get_header();
?>

<section class="lf-hero-section">
    <div class="lf-container">
        <div class="lf-hero-badge">
            <span>✨ Multilingual Intelligence Platform</span>
        </div>

        <h1 class="lf-hero-title">
            Speak. <span class="editorial-title">Understand.</span> Connect.
        </h1>

        <p class="lf-hero-subtitle">
            Translate conversations, understand spoken language, and practice pronunciation — all in one intelligent, minimal luxury language platform.
        </p>

        <div class="lf-hero-cta">
            <a href="<?php echo esc_url(home_url('/translate')); ?>" class="lf-btn lf-btn-lg lf-btn-primary">Start Translating →</a>
            <a href="<?php echo esc_url(home_url('/practice')); ?>" class="lf-btn lf-btn-lg lf-btn-outline">Practice Pronunciation</a>
        </div>

        <!-- Premium Interactive Hero Visual Demo -->
        <div class="lf-hero-demo">
            <div class="lf-demo-header">
                <div class="lf-demo-langs">
                    <span class="active">English</span>
                    <span>→</span>
                    <span class="active">French</span>
                </div>
                <span class="lf-brand-badge" style="background: rgba(255,255,255,0.15);">LIVE DEMO</span>
            </div>

            <div class="lf-demo-flow">
                <div class="lf-demo-step">
                    <div class="lf-demo-step-num">1</div>
                    <div class="lf-demo-content">
                        <div class="lf-demo-label">Source Audio / Input (English)</div>
                        <div class="lf-demo-text">"Where is the nearest train station?"</div>
                    </div>
                </div>

                <div class="lf-demo-step" style="padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                    <div class="lf-demo-step-num">2</div>
                    <div class="lf-demo-content">
                        <div class="lf-demo-label">Target Translation (French)</div>
                        <div class="lf-demo-text" style="color: var(--lf-light); font-style: italic;">"Où est la gare la plus proche ?"</div>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                    <button class="lf-btn lf-btn-sm lf-btn-secondary" onclick="LinguaFlow.speak('Où est la gare la plus proche ?', 'fr');">🔊 Listen Playback</button>
                    <a href="<?php echo esc_url(home_url('/translate')); ?>" class="lf-btn lf-btn-sm lf-btn-outline" style="color: #FFFFFF; border-color: rgba(255,255,255,0.3);">Try Live Mic Input</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Core Features Section -->
<section style="padding: 5rem 0; background: var(--lf-bg-surface); border-top: 1px solid var(--lf-border-subtle); border-bottom: 1px solid var(--lf-border-subtle);">
    <div class="lf-container">
        <div style="text-align: center; max-width: 600px; margin: 0 auto 4rem;">
            <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--lf-text-muted); margin-bottom: 0.5rem;">Core Architecture</div>
            <h2>Engineered for seamless voice & translation flow.</h2>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div class="lf-card">
                <div style="font-size: 1.75rem; margin-bottom: 1rem;">🎙</div>
                <h3 style="margin-bottom: 0.5rem;">Voice Transcription</h3>
                <p>Near-live speech-to-text recognition with visual waveform feedback powered by browser Web Speech APIs.</p>
            </div>

            <div class="lf-card">
                <div style="font-size: 1.75rem; margin-bottom: 1rem;">🌐</div>
                <h3 style="margin-bottom: 0.5rem;">Multilingual Translation</h3>
                <p>Broad language coverage with abstracted provider architecture supporting Google, Azure, OpenAI & offline fallbacks.</p>
            </div>

            <div class="lf-card">
                <div style="font-size: 1.75rem; margin-bottom: 1rem;">🎯</div>
                <h3 style="margin-bottom: 0.5rem;">Pronunciation Coach</h3>
                <p>Word-level accuracy analysis (<span style="font-weight:700;">✓</span> <span style="color:var(--lf-greige);">△</span> <span style="color:var(--lf-status-error);">✕</span>) and actionable phonetic feedback for phrase mastery.</p>
            </div>

            <div class="lf-card">
                <div style="font-size: 1.75rem; margin-bottom: 1rem;">💬</div>
                <h3 style="margin-bottom: 0.5rem;">Conversation Mode</h3>
                <p>Dual-person split dialogue interface for instant real-time back-and-forth speech translation.</p>
            </div>

            <div class="lf-card">
                <div style="font-size: 1.75rem; margin-bottom: 1rem;">✈️</div>
                <h3 style="margin-bottom: 0.5rem;">Travel Packs</h3>
                <p>Categorized essential travel phrases (Hotel, Transport, Restaurant, Emergency) available offline.</p>
            </div>

            <div class="lf-card">
                <div style="font-size: 1.75rem; margin-bottom: 1rem;">📲</div>
                <h3 style="margin-bottom: 0.5rem;">PWA Offline Shell</h3>
                <p>Installable as a mobile application with service worker caching for offline travel notebooks and saved phrases.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section style="padding: 6rem 0; text-align: center;">
    <div class="lf-container" style="max-width: 720px;">
        <h2>Ready to experience effortless translation?</h2>
        <p style="margin: 1rem 0 2.5rem; font-size: 1.15rem;">Open LinguaFlow directly in your browser or install it as a PWA on your phone.</p>
        <a href="<?php echo esc_url(home_url('/translate')); ?>" class="lf-btn lf-btn-lg lf-btn-primary">Launch Translator Screen →</a>
    </div>
</section>

<?php get_footer(); ?>
