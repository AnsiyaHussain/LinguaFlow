<?php
/**
 * Template Name: Translator Screen
 */
get_header();
?>

<div class="lf-container" style="padding-top: 2rem; padding-bottom: 4rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--lf-text-muted);">Main Product Studio</div>
            <h2>Multilingual Studio</h2>
        </div>
        <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--lf-text-muted);">
            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #48BB78;"></span>
            Speech Engine Ready
        </div>
    </div>

    <!-- Translator Layout Container -->
    <div class="lf-translator-layout">
        <!-- LEFT PANEL: SOURCE INPUT -->
        <div class="lf-card lf-translator-panel">
            <div class="lf-panel-header">
                <select id="lf-source-lang" class="lf-lang-select">
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

                <div style="display: flex; gap: 0.5rem; align-items: center;">
                    <button id="lf-play-source-tts" class="lf-btn lf-btn-sm lf-btn-outline" style="padding: 0.3rem 0.65rem; font-size: 0.8rem;" title="Listen to original source text in source language">🔊 Listen Original</button>
                    <button id="lf-clear-source" class="lf-btn lf-btn-sm lf-btn-outline" style="padding: 0.3rem 0.65rem; font-size: 0.8rem;">Clear</button>
                </div>
            </div>

            <textarea id="lf-source-text" class="lf-textarea" placeholder="Type or tap the microphone to speak..."></textarea>

            <!-- Real-time HTML5 Canvas Audio Waveform Visualizer -->
            <div class="lf-waveform-container">
                <canvas id="lf-waveform-canvas" class="lf-waveform-canvas" width="400" height="60"></canvas>
            </div>

            <div class="lf-panel-footer">
                <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                    <button id="lf-mic-btn" class="lf-mic-btn" aria-label="Start Voice Recording">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
                    </button>
                    <span id="lf-mic-status" style="font-size: 0.88rem; font-weight: 500; color: var(--lf-text-muted);">Tap to speak...</span>
                    <button id="lf-play-recording" class="lf-btn lf-btn-sm lf-btn-secondary" style="display: none; padding: 0.35rem 0.75rem; font-size: 0.82rem;">▶ Play Recorded Voice</button>
                </div>

                <button id="lf-swap-langs" class="lf-swap-btn" title="Swap languages">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="17 1 21 5 17 9"/><line x1="3" y1="5" x2="21" y2="5"/><polyline points="7 23 3 19 7 15"/><line x1="21" y1="19" x2="3" y2="19"/></svg>
                </button>
            </div>
        </div>

        <!-- RIGHT PANEL: TARGET TRANSLATION -->
        <div class="lf-card lf-translator-panel" style="background: #FBFBFA;">
            <div class="lf-panel-header">
                <select id="lf-target-lang" class="lf-lang-select">
                    <option value="fr" selected>🇫🇷 French (Français)</option>
                    <option value="en">🇬🇧 English</option>
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

                <span class="lf-brand-badge" style="background: var(--lf-stone); color: var(--lf-black);">TRANSLATION</span>
            </div>

            <div id="lf-translated-text" class="lf-textarea" style="color: var(--lf-black); font-style: italic;" readonly>
                Translation will appear here automatically...
            </div>

            <div class="lf-panel-footer" style="flex-wrap: wrap; gap: 0.5rem;">
                <button id="lf-play-tts" class="lf-btn lf-btn-secondary" title="Listen to translation in target language voice">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"/></svg>
                    Listen Translation
                </button>

                <div style="display: flex; gap: 0.5rem;">
                    <button id="lf-copy-trans" class="lf-btn lf-btn-outline">📋 Copy</button>
                    <button id="lf-save-trans" class="lf-btn lf-btn-primary">🔖 Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
