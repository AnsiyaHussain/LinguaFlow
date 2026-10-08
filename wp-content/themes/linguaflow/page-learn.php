<?php
/**
 * Template Name: Language Learning
 */
get_header();
?>

<div class="lf-container" style="padding-top: 2rem; padding-bottom: 5rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--lf-text-muted);">Learning Curriculum</div>
            <h2>Language Modules</h2>
        </div>
        <div class="lf-brand-badge" style="background: var(--lf-stone); color: var(--lf-black);">DAILY GOAL: 7 / 10 PHRASES</div>
    </div>

    <!-- Active Languages Progress -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div class="lf-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                <span style="font-weight: 700; font-size: 1.1rem;">🇫🇷 French</span>
                <span style="font-size: 0.85rem; font-weight: 600;">78% Complete</span>
            </div>
            <div style="width: 100%; height: 8px; background: var(--lf-stone); border-radius: 4px; overflow: hidden; margin-bottom: 1rem;">
                <div style="width: 78%; height: 100%; background: var(--lf-black);"></div>
            </div>
            <div style="font-size: 0.85rem; color: var(--lf-text-muted);">B1 Intermediate • 14 lessons finished</div>
        </div>

        <div class="lf-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                <span style="font-weight: 700; font-size: 1.1rem;">🇪🇸 Spanish</span>
                <span style="font-size: 0.85rem; font-weight: 600;">42% Complete</span>
            </div>
            <div style="width: 100%; height: 8px; background: var(--lf-stone); border-radius: 4px; overflow: hidden; margin-bottom: 1rem;">
                <div style="width: 42%; height: 100%; background: var(--lf-black);"></div>
            </div>
            <div style="font-size: 0.85rem; color: var(--lf-text-muted);">A2 Elementary • 6 lessons finished</div>
        </div>

        <div class="lf-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                <span style="font-weight: 700; font-size: 1.1rem;">🇩🇪 German</span>
                <span style="font-size: 0.85rem; font-weight: 600;">25% Complete</span>
            </div>
            <div style="width: 100%; height: 8px; background: var(--lf-stone); border-radius: 4px; overflow: hidden; margin-bottom: 1rem;">
                <div style="width: 25%; height: 100%; background: var(--lf-black);"></div>
            </div>
            <div style="font-size: 0.85rem; color: var(--lf-text-muted);">A1 Beginner • 3 lessons finished</div>
        </div>
    </div>

    <!-- Curated Lessons List -->
    <h3>Recommended Lessons</h3>
    <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-top: 1.25rem;">
        <div class="lf-card" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span class="lf-brand-badge" style="margin-bottom: 0.5rem; display: inline-block;">FRENCH B1</span>
                <h4 style="font-size: 1.2rem; margin-bottom: 0.25rem;">Essential Conversational French & Cafe Etiquette</h4>
                <p style="font-size: 0.9rem; max-width: 600px;">Master everyday polite phrases, transport inquiries, and café dining conversations.</p>
            </div>
            <a href="<?php echo esc_url(home_url('/practice')); ?>" class="lf-btn lf-btn-primary">Start Lesson →</a>
        </div>

        <div class="lf-card" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span class="lf-brand-badge" style="margin-bottom: 0.5rem; display: inline-block;">SPANISH A2</span>
                <h4 style="font-size: 1.2rem; margin-bottom: 0.25rem;">Spanish Travel & Hotel Reservation Mastery</h4>
                <p style="font-size: 0.9rem; max-width: 600px;">Confidently check in, order meals, and navigate cities in Spanish.</p>
            </div>
            <a href="<?php echo esc_url(home_url('/travel')); ?>" class="lf-btn lf-btn-secondary">Open Travel Pack →</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
