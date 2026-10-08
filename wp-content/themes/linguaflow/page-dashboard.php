<?php
/**
 * Template Name: Dashboard & History Notebook
 */
get_header();
?>

<div class="lf-container" style="padding-top: 2rem; padding-bottom: 5rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--lf-text-muted);">Personal Intelligence Workspace</div>
            <h2>Good morning, Ansiya.</h2>
        </div>
        <a href="<?php echo esc_url(home_url('/translate')); ?>" class="lf-btn lf-btn-primary">+ New Translation</a>
    </div>

    <!-- Analytics & Stats Grid -->
    <div class="lf-stats-grid">
        <div class="lf-stat-card">
            <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--lf-text-muted);">Daily Streak</div>
            <div id="lf-stat-streak" class="lf-stat-val">7 <span style="font-size:1.2rem;">Days 🔥</span></div>
        </div>

        <div class="lf-stat-card">
            <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--lf-text-muted);">Total Translations</div>
            <div id="lf-stat-translations" class="lf-stat-val">48</div>
        </div>

        <div class="lf-stat-card">
            <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--lf-text-muted);">Practice Sessions</div>
            <div class="lf-stat-val">19</div>
        </div>

        <div class="lf-stat-card">
            <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--lf-text-muted);">Saved Phrases</div>
            <div class="lf-stat-val">14</div>
        </div>
    </div>

    <!-- Notebook & History Sections -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;" class="lf-practice-grid">
        <!-- Translation History Panel -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                <h3>Translation History</h3>
                <span style="font-size: 0.85rem; color: var(--lf-text-muted);">Recent activity</span>
            </div>

            <div id="lf-history-list">
                <!-- Rendered by assets/js/dashboard.js -->
            </div>
        </div>

        <!-- Saved Notebook Panel -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                <h3>Saved Notebook</h3>
                <span style="font-size: 0.85rem; color: var(--lf-text-muted);">Bookmarked phrases</span>
            </div>

            <div id="lf-saved-list">
                <!-- Rendered by assets/js/dashboard.js -->
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
