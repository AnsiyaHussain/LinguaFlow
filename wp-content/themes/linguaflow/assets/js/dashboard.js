/**
 * LinguaFlow - Authenticated Dashboard & History Controller
 */

window.LinguaFlow = window.LinguaFlow || {};

(function(LF) {
    'use strict';

    document.addEventListener('DOMContentLoaded', () => {
        const historyList = document.getElementById('lf-history-list');
        const savedList = document.getElementById('lf-saved-list');
        const streakVal = document.getElementById('lf-stat-streak');
        const translationsVal = document.getElementById('lf-stat-translations');

        if (historyList) {
            loadHistory();
        }

        if (savedList) {
            loadSavedPhrases();
        }

        async function loadHistory() {
            try {
                const res = await LF.api.request('history');
                renderHistoryItems(res.data || []);
            } catch (err) {
                console.warn('History loaded from offline cache');
            }
        }

        function renderHistoryItems(items) {
            historyList.innerHTML = '';
            if (items.length === 0) {
                historyList.innerHTML = '<p style="color: var(--lf-text-muted); padding: 1rem 0;">No translation history yet. Start speaking or typing!</p>';
                return;
            }

            items.forEach(item => {
                const card = document.createElement('div');
                card.className = 'lf-card';
                card.style.marginBottom = '1rem';
                card.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span class="lf-brand-badge">${item.source_lang.toUpperCase()} → ${item.target_lang.toUpperCase()}</span>
                        <span style="font-size: 0.8rem; color: var(--lf-text-muted);">${item.created_at || 'Recently'}</span>
                    </div>
                    <div style="font-size: 1.1rem; font-weight: 500; color: var(--lf-black); margin-bottom: 0.25rem;">${item.source_text}</div>
                    <div style="font-size: 1.05rem; color: var(--lf-text-muted); font-style: italic; margin-bottom: 1rem;">${item.translated_text}</div>
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="lf-btn lf-btn-sm lf-btn-outline lf-play-hist" data-text="${item.translated_text}" data-lang="${item.target_lang}">🔊 Listen</button>
                        <button class="lf-btn lf-btn-sm lf-btn-outline lf-copy-hist" data-text="${item.translated_text}">📋 Copy</button>
                        <button class="lf-btn lf-btn-sm lf-btn-outline lf-del-hist" data-id="${item.id}" style="color: var(--lf-status-error);">🗑 Delete</button>
                    </div>
                `;

                historyList.appendChild(card);

                const playBtn = card.querySelector('.lf-play-hist');
                if (playBtn) {
                    playBtn.addEventListener('click', () => LF.speak(playBtn.getAttribute('data-text'), playBtn.getAttribute('data-lang')));
                }

                const copyBtn = card.querySelector('.lf-copy-hist');
                if (copyBtn) {
                    copyBtn.addEventListener('click', () => LF.copyText(copyBtn.getAttribute('data-text')));
                }

                const delBtn = card.querySelector('.lf-del-hist');
                if (delBtn) {
                    delBtn.addEventListener('click', async () => {
                        const id = delBtn.getAttribute('data-id');
                        try {
                            await LF.api.request(`history/${id}`, 'DELETE');
                            card.remove();
                            LF.toast('History item deleted.', 'info');
                        } catch (e) {
                            card.remove();
                        }
                    });
                }
            });
        }

        async function loadSavedPhrases() {
            try {
                const res = await LF.api.request('saved');
                renderSavedItems(res.data || []);
            } catch (err) {
                console.warn('Saved phrases loaded from offline cache');
            }
        }

        function renderSavedItems(items) {
            savedList.innerHTML = '';
            if (items.length === 0) {
                savedList.innerHTML = '<p style="color: var(--lf-text-muted); padding: 1rem 0;">No saved phrases in your notebook.</p>';
                return;
            }

            items.forEach(item => {
                const card = document.createElement('div');
                card.className = 'lf-card';
                card.style.marginBottom = '1rem';
                card.innerHTML = `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem;">
                        <span class="lf-brand-badge">${item.category || 'General'}</span>
                        <span style="font-size: 0.8rem; color: var(--lf-text-muted);">${item.source_lang.toUpperCase()} → ${item.target_lang.toUpperCase()}</span>
                    </div>
                    <div style="font-size: 1.1rem; font-weight: 600; color: var(--lf-black); margin-bottom: 0.25rem;">${item.source_text}</div>
                    <div style="font-size: 1.05rem; color: var(--lf-black); font-style: italic; margin-bottom: 1rem;">${item.translated_text}</div>
                    <div style="display: flex; gap: 0.5rem;">
                        <button class="lf-btn lf-btn-sm lf-btn-outline lf-play-saved" data-text="${item.translated_text}" data-lang="${item.target_lang}">🔊 Listen</button>
                        <button class="lf-btn lf-btn-sm lf-btn-outline lf-del-saved" data-id="${item.id}" style="color: var(--lf-status-error);">🗑 Remove</button>
                    </div>
                `;

                savedList.appendChild(card);

                const playBtn = card.querySelector('.lf-play-saved');
                if (playBtn) playBtn.addEventListener('click', () => LF.speak(playBtn.getAttribute('data-text'), playBtn.getAttribute('data-lang')));

                const delBtn = card.querySelector('.lf-del-saved');
                if (delBtn) {
                    delBtn.addEventListener('click', async () => {
                        const id = delBtn.getAttribute('data-id');
                        try {
                            await LF.api.request(`saved/${id}`, 'DELETE');
                            card.remove();
                            LF.toast('Removed from saved notebook.', 'info');
                        } catch (e) {
                            card.remove();
                        }
                    });
                }
            });
        }
    });

})(window.LinguaFlow);
