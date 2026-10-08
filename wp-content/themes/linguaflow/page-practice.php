<?php
/**
 * Template Name: Pronunciation Practice Coach
 */
get_header();
?>

<div class="lf-container" style="padding-top: 2rem; padding-bottom: 5rem;">
    <div style="text-align: center; max-width: 650px; margin: 0 auto 2.5rem;">
        <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--lf-text-muted);">Phonetic Intelligence</div>
        <h2>Pronunciation Coach</h2>
        <p>Listen to authentic pronunciation, record your attempt, and receive instant word-by-word accuracy feedback.</p>
    </div>

    <div class="lf-practice-grid">
        <!-- LEFT: TARGET PHRASE CARD -->
        <div class="lf-target-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <span class="lf-brand-badge" style="background: rgba(255,255,255,0.2);">TARGET PHRASE</span>
                <span style="font-size: 0.85rem; color: var(--lf-greige);">French (fr)</span>
            </div>

            <div style="font-size: 0.95rem; color: var(--lf-greige); margin-bottom: 0.4rem;">English Meaning:</div>
            <div style="font-size: 1.25rem; font-weight: 500; margin-bottom: 1.5rem;">"Where is the nearest train station?"</div>

            <div style="font-size: 0.95rem; color: var(--lf-greige); margin-bottom: 0.4rem;">French Target Phrase:</div>
            <div id="lf-practice-target" data-target="Où est la gare la plus proche ?" data-lang="fr" style="font-size: 1.85rem; font-family: var(--lf-font-serif); font-style: italic; color: #FFFFFF; line-height: 1.3; margin-bottom: 2rem;">
                "Où est la gare la plus proche ?"
            </div>

            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <button id="lf-listen-target" class="lf-btn lf-btn-secondary">
                    🔊 Listen Audio
                </button>
                <button id="lf-record-attempt" class="lf-btn lf-btn-outline" style="color: #FFFFFF; border-color: rgba(255,255,255,0.4);">
                    🎙 Record Attempt
                </button>
            </div>

            <div id="lf-practice-status" style="margin-top: 1.5rem; font-size: 0.9rem; color: var(--lf-greige);">
                Tap "Record Attempt" and speak out loud into your microphone.
            </div>
        </div>

        <!-- RIGHT: EVALUATION RESULTS -->
        <div class="lf-card" id="lf-feedback-results" style="display: block;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid var(--lf-border-subtle);">
                <h3>Pronunciation Score</h3>
                <div id="lf-score-badge" style="font-size: 1.85rem; font-weight: 700; color: var(--lf-black);">88%</div>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--lf-text-muted); margin-bottom: 0.25rem;">Evaluation Rating</div>
                <div id="lf-rating-text" style="font-size: 1.3rem; font-weight: 600; color: var(--lf-black);">Excellent</div>
                <p id="lf-advice-text" style="margin-top: 0.3rem;">Flawless rhythm and clear articulation of French vowels.</p>
            </div>

            <div>
                <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--lf-text-muted); margin-bottom: 0.75rem;">Word-by-Word Breakdown</div>
                <div id="lf-word-breakdown" style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                    <span class="lf-word-badge correct">Où <span class="lf-word-symbol">✓</span></span>
                    <span class="lf-word-badge correct">est <span class="lf-word-symbol">✓</span></span>
                    <span class="lf-word-badge minor_error">la <span class="lf-word-symbol">△</span></span>
                    <span class="lf-word-badge correct">gare <span class="lf-word-symbol">✓</span></span>
                    <span class="lf-word-badge correct">la <span class="lf-word-symbol">✓</span></span>
                    <span class="lf-word-badge correct">plus <span class="lf-word-symbol">✓</span></span>
                    <span class="lf-word-badge correct">proche <span class="lf-word-symbol">✓</span></span>
                </div>
            </div>

            <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--lf-border-subtle); display: flex; gap: 0.5rem; font-size: 0.8rem; color: var(--lf-text-muted);">
                <span>Key:</span>
                <span><strong>✓</strong> Correct</span>
                <span style="color: var(--lf-status-warning);"><strong>△</strong> Stress/Vowel Accent</span>
                <span style="color: var(--lf-status-error);"><strong>✕</strong> Mispronounced</span>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
