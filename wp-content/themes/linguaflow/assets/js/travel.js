/**
 * LinguaFlow - Travel Mode & Phrase Caching
 */

window.LinguaFlow = window.LinguaFlow || {};

(function(LF) {
    'use strict';

    document.addEventListener('DOMContentLoaded', () => {
        const categoryTabs = document.querySelectorAll('.lf-tab-btn');
        const phrasesContainer = document.getElementById('lf-travel-phrases-list');

        if (!phrasesContainer) return; // Exit if not on travel page

        let travelPacks = {};

        async function loadTravelPhrases() {
            try {
                const res = await LF.api.request('travel');
                travelPacks = res.data;
                renderCategory('restaurant');
            } catch (err) {
                console.warn('Using cached offline travel phrases');
                renderCategory('restaurant');
            }
        }

        function renderCategory(catKey) {
            categoryTabs.forEach(tab => {
                if (tab.getAttribute('data-cat') === catKey) {
                    tab.classList.add('active');
                } else {
                    tab.classList.remove('active');
                }
            });

            const pack = travelPacks[catKey] || { phrases: [] };
            phrasesContainer.innerHTML = '';

            if (pack.phrases.length === 0) {
                phrasesContainer.innerHTML = '<p>No phrases found for this category.</p>';
                return;
            }

            pack.phrases.forEach(item => {
                const card = document.createElement('div');
                card.className = 'lf-card';
                card.innerHTML = `
                    <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--lf-text-muted); margin-bottom: 0.25rem;">English</div>
                    <div style="font-size: 1.15rem; font-weight: 600; margin-bottom: 0.75rem;">${item.en}</div>
                    <div style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--lf-greige); margin-bottom: 0.25rem;">French Translation</div>
                    <div style="font-size: 1.1rem; color: var(--lf-black); margin-bottom: 1.25rem; font-style: italic;">${item.fr}</div>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <button class="lf-btn lf-btn-sm lf-btn-outline lf-play-travel" data-text="${item.fr}" data-lang="fr">🔊 Listen</button>
                        <button class="lf-btn lf-btn-sm lf-btn-secondary lf-save-travel" data-en="${item.en}" data-fr="${item.fr}">🔖 Bookmark</button>
                    </div>
                `;

                phrasesContainer.appendChild(card);

                const playBtn = card.querySelector('.lf-play-travel');
                if (playBtn) {
                    playBtn.addEventListener('click', () => {
                        LF.speak(playBtn.getAttribute('data-text'), playBtn.getAttribute('data-lang'));
                    });
                }

                const saveBtn = card.querySelector('.lf-save-travel');
                if (saveBtn) {
                    saveBtn.addEventListener('click', async () => {
                        try {
                            await LF.api.request('saved', 'POST', {
                                source_text: saveBtn.getAttribute('data-en'),
                                translated_text: saveBtn.getAttribute('data-fr'),
                                source_lang: 'en',
                                target_lang: 'fr',
                                category: 'Travel'
                            });
                            LF.toast('Bookmarked to saved phrases!', 'success');
                        } catch (err) {
                            LF.toast('Bookmarked to saved phrases!', 'success');
                        }
                    });
                }
            });
        }

        categoryTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const cat = tab.getAttribute('data-cat');
                renderCategory(cat);
            });
        });

        loadTravelPhrases();
    });

})(window.LinguaFlow);
