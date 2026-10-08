<?php
/**
 * Template Name: Conversation Mode
 */
get_header();
?>

<div class="lf-container" style="padding-top: 2rem; padding-bottom: 6rem;">
    <div style="text-align: center; max-width: 600px; margin: 0 auto 2rem;">
        <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--lf-text-muted);">Real-time Dialogue</div>
        <h2>Conversation Mode</h2>
        <p>Alternate speaking between Person A and Person B for live translated dialogue.</p>
    </div>

    <!-- Language Selector Pair Header -->
    <div style="display: flex; justify-content: center; align-items: center; gap: 1rem; margin-bottom: 2.5rem; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 0.5rem; background: var(--lf-bg-card); padding: 0.5rem 1rem; border-radius: var(--lf-radius-md); border: 1px solid var(--lf-border-subtle);">
            <span style="font-weight: 600;">Person A:</span>
            <select id="lf-lang-a" class="lf-lang-select" style="padding: 0.3rem 0.6rem; font-size: 0.9rem;">
                <option value="en" selected>🇬🇧 English</option>
                <option value="fr">🇫🇷 French (Français)</option>
                <option value="es">🇪🇸 Spanish (Español)</option>
                <option value="de">🇩🇪 German (Deutsch)</option>
                <option value="it">🇮🇹 Italian (Italiano)</option>
                <option value="pt">🇵🇹 Portuguese (Português)</option>
                <option value="ar">🇸🇦 Arabic (العربية)</option>
                <option value="hi">🇮🇳 Hindi (हिन्दी)</option>
                <option value="kn">🇮🇳 Kannada (ಕನ್ನಡ)</option>
                <option value="ml">🇮🇳 Malayalam (മലയാളം)</option>
                <option value="ja">🇯🇵 Japanese (日本語)</option>
                <option value="zh">🇨🇳 Mandarin Chinese (中文)</option>
                <option value="ru">🇷🇺 Russian (Русский)</option>
            </select>
        </div>

        <span style="font-weight: 700; font-size: 1.2rem;">↔</span>

        <div style="display: flex; align-items: center; gap: 0.5rem; background: var(--lf-bg-card); padding: 0.5rem 1rem; border-radius: var(--lf-radius-md); border: 1px solid var(--lf-border-subtle);">
            <span style="font-weight: 600;">Person B:</span>
            <select id="lf-lang-b" class="lf-lang-select" style="padding: 0.3rem 0.6rem; font-size: 0.9rem;">
                <option value="ar" selected>🇸🇦 Arabic (العربية)</option>
                <option value="fr">🇫🇷 French (Français)</option>
                <option value="hi">🇮🇳 Hindi (हिन्दी)</option>
                <option value="kn">🇮🇳 Kannada (ಕನ್ನಡ)</option>
                <option value="ml">🇮🇳 Malayalam (മലയാളം)</option>
                <option value="en">🇬🇧 English</option>
                <option value="es">🇪🇸 Spanish (Español)</option>
                <option value="de">🇩🇪 German (Deutsch)</option>
                <option value="it">🇮🇹 Italian (Italiano)</option>
                <option value="pt">🇵🇹 Portuguese (Português)</option>
                <option value="ja">🇯🇵 Japanese (日本語)</option>
                <option value="zh">🇨🇳 Mandarin Chinese (中文)</option>
                <option value="ru">🇷🇺 Russian (Русский)</option>
            </select>
        </div>
    </div>

    <!-- Conversation Message Timeline Flow -->
    <div id="lf-conversation-list" class="lf-conversation-flow">
        <!-- Default Initial Sample Turns -->
        <div class="lf-chat-bubble person-a">
            <div class="lf-demo-label">Person A (English)</div>
            <div class="lf-demo-text">"Hello, where are you going?"</div>
            <div class="lf-chat-translation">
                <strong>Translated (French):</strong> "Bonjour, où allez-vous ?"
                <button class="lf-btn lf-btn-sm lf-btn-outline" style="margin-left: 0.5rem; padding: 0.2rem 0.5rem;" onclick="LinguaFlow.speak('Bonjour, où allez-vous ?', 'fr');">🔊 Listen</button>
            </div>
        </div>

        <div class="lf-chat-bubble person-b">
            <div class="lf-demo-label">Person B (French)</div>
            <div class="lf-demo-text">"Je vais à la gare."</div>
            <div class="lf-chat-translation">
                <strong>Translated (English):</strong> "I am going to the train station."
                <button class="lf-btn lf-btn-sm lf-btn-outline" style="margin-left: 0.5rem; padding: 0.2rem 0.5rem; color:#fff;" onclick="LinguaFlow.speak('I am going to the train station.', 'en');">🔊 Listen</button>
            </div>
        </div>
    </div>

    <!-- Floating Thumb-friendly Recording Controls Bar -->
    <div class="lf-conversation-controls">
        <button id="lf-mic-person-a" class="lf-btn lf-btn-primary">
            🎙 Speak (Person A)
        </button>

        <span style="color: var(--lf-text-muted); font-size: 0.85rem; font-weight: 600;">OR</span>

        <button id="lf-mic-person-b" class="lf-btn lf-btn-secondary">
            🎙 Speak (Person B)
        </button>
    </div>
</div>

<?php get_footer(); ?>
