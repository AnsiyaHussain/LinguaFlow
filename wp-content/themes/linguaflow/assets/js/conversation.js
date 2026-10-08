/**
 * LinguaFlow - Conversation Mode Interactive Controller
 */

window.LinguaFlow = window.LinguaFlow || {};

(function(LF) {
    'use strict';

    document.addEventListener('DOMContentLoaded', () => {
        const chatContainer = document.getElementById('lf-conversation-list');
        const micPersonA = document.getElementById('lf-mic-person-a');
        const micPersonB = document.getElementById('lf-mic-person-b');
        const langASelect = document.getElementById('lf-lang-a');
        const langBSelect = document.getElementById('lf-lang-b');

        if (!chatContainer) return; // Exit if not on conversation page

        let activePerson = null;

        function setupMic(button, person, sourceLangEl, targetLangEl) {
            if (!button) return;

            button.addEventListener('click', () => {
                const sourceLang = sourceLangEl ? sourceLangEl.value : (person === 'A' ? 'en' : 'fr');
                const targetLang = targetLangEl ? targetLangEl.value : (person === 'A' ? 'fr' : 'en');

                if (LF.SpeechEngine.isListening && activePerson === person) {
                    LF.SpeechEngine.stop();
                    button.classList.remove('recording');
                    activePerson = null;
                } else {
                    if (micPersonA) micPersonA.classList.remove('recording');
                    if (micPersonB) micPersonB.classList.remove('recording');
                    button.classList.add('recording');
                    activePerson = person;

                    LF.SpeechEngine.start(
                        sourceLang,
                        async (result) => {
                            if (result.final) {
                                LF.SpeechEngine.stop();
                                button.classList.remove('recording');
                                activePerson = null;
                                await appendConversationTurn(person, result.final, sourceLang, targetLang);
                            }
                        },
                        (err) => {
                            button.classList.remove('recording');
                            activePerson = null;
                            LF.toast(err, 'warning');
                        },
                        () => {
                            button.classList.remove('recording');
                            activePerson = null;
                        }
                    );
                }
            });
        }

        setupMic(micPersonA, 'A', langASelect, langBSelect);
        setupMic(micPersonB, 'B', langBSelect, langASelect);

        async function appendConversationTurn(person, originalText, sourceLang, targetLang) {
            let translatedText = '';
            try {
                const res = await LF.api.request('translate', 'POST', {
                    source_text: originalText,
                    source_lang: sourceLang,
                    target_lang: targetLang
                });
                translatedText = res.translated_text;
            } catch (err) {
                translatedText = `[Translated to ${targetLang.toUpperCase()}]: ${originalText}`;
            }

            const targetConfig = LF.getLanguageConfig ? LF.getLanguageConfig(targetLang) : { isRTL: targetLang === 'ar' };
            const rtlAttr = (targetConfig.isRTL || targetLang === 'ar') ? 'dir="rtl" style="text-align:right;"' : '';

            const bubble = document.createElement('div');
            bubble.className = `lf-chat-bubble person-${person.toLowerCase()}`;
            bubble.innerHTML = `
                <div class="lf-demo-label">Person ${person} (${sourceLang.toUpperCase()})</div>
                <div class="lf-demo-text">${originalText}</div>
                <div class="lf-chat-translation" ${rtlAttr}>
                    <strong>Translated (${targetLang.toUpperCase()}):</strong> ${translatedText}
                    <button class="lf-btn lf-btn-sm lf-btn-outline lf-play-chat" style="margin-left: 0.5rem; padding: 0.2rem 0.5rem;" title="Listen to translation in target language voice">🔊 Listen</button>
                </div>
            `;

            chatContainer.appendChild(bubble);
            bubble.scrollIntoView({ behavior: 'smooth' });

            const playBtn = bubble.querySelector('.lf-play-chat');
            if (playBtn) {
                playBtn.addEventListener('click', () => {
                    LF.speakTranslation(translatedText, targetLang);
                });
            }
        }
    });

})(window.LinguaFlow);
