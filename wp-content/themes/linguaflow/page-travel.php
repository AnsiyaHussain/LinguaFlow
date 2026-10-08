<?php
/**
 * Template Name: Travel Mode
 */
get_header();
?>

<div class="lf-container" style="padding-top: 2rem; padding-bottom: 5rem;">
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.12em; color: var(--lf-text-muted);">Quick Travel Phrases</div>
            <h2>Travel Packs</h2>
        </div>
        <div style="font-size: 0.85rem; color: var(--lf-text-muted);">
            📲 Cached offline in Service Worker
        </div>
    </div>

    <!-- Category Tabs -->
    <div class="lf-category-tabs">
        <button class="lf-tab-btn active" data-cat="restaurant">🍽 Restaurant & Dining</button>
        <button class="lf-tab-btn" data-cat="transport">🚆 Transport & Travel</button>
        <button class="lf-tab-btn" data-cat="hotel">🏨 Hotel & Stay</button>
        <button class="lf-tab-btn" data-cat="medical">🏥 Emergency & Health</button>
    </div>

    <!-- Dynamic Travel Phrases Grid -->
    <div id="lf-travel-phrases-list" class="lf-phrases-grid">
        <!-- Rendered dynamically by assets/js/travel.js -->
    </div>
</div>

<?php get_footer(); ?>
