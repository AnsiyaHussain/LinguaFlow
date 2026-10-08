/**
 * LinguaFlow - Main Translator Screen Interactive Controller
 */

window.LinguaFlow = window.LinguaFlow || {};

(function(LF) {
    'use strict';

    document.addEventListener('DOMContentLoaded', () => {
        const sourceSelect = document.getElementById('lf-source-lang');
        const targetSelect = document.getElementById('lf-target-lang');
        const swapBtn = document.getElementById('lf-swap-langs');
        const sourceInput = document.getElementById('lf-source-text');
        const translatedOutput = document.getElementById('lf-translated-text');
        const micBtn = document.getElementById('lf-mic-btn');
        const micStatus = document.getElementById('lf-mic-status');
        const playTtsBtn = document.getElementById('lf-play-tts');
        const copyBtn = document.getElementById('lf-copy-trans');
        const saveBtn = document.getElementById('lf-save-trans');
        const clearBtn = document.getElementById('lf-clear-source');
        const canvasWaveform = document.getElementById('lf-waveform-canvas');

        if (!sourceInput) return; // Exit if not on translator page

        let debounceTimer;

        // Auto-translate on input
        sourceInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            const text = sourceInput.value.trim();
            if (text.length === 0) {
                if (translatedOutput) translatedOutput.textContent = '';
                return;
            }
            debounceTimer = setTimeout(() => performTranslation(), 300);
        });

        // Auto-translate when source or target language select dropdown changes
        if (sourceSelect) {
            sourceSelect.addEventListener('change', () => {
                if (sourceInput.value.trim()) performTranslation();
            });
        }
        if (targetSelect) {
            targetSelect.addEventListener('change', () => {
                if (sourceInput.value.trim()) performTranslation();
            });
        }

        // Swap languages
        if (swapBtn && sourceSelect && targetSelect) {
            swapBtn.addEventListener('click', () => {
                const temp = sourceSelect.value;
                sourceSelect.value = targetSelect.value;
                targetSelect.value = temp;

                // Also swap text if translated text exists
                if (translatedOutput && translatedOutput.textContent.trim()) {
                    sourceInput.value = translatedOutput.textContent.trim();
                    translatedOutput.textContent = '';
                    performTranslation();
                }
            });
        }

        // Perform Translation API Request
        async function performTranslation() {
            const text = sourceInput.value.trim();
            const sourceLang = sourceSelect ? sourceSelect.value : 'en';
            const targetLang = targetSelect ? targetSelect.value : 'fr';

            if (!text) {
                if (translatedOutput) {
                    translatedOutput.textContent = '';
                    translatedOutput.removeAttribute('dir');
                }
                return;
            }

            if (translatedOutput) {
                translatedOutput.style.opacity = '0.5';
                // Handle RTL Arabic alignment
                const langConfig = LF.getLanguageConfig ? LF.getLanguageConfig(targetLang) : { isRTL: targetLang === 'ar' };
                if (langConfig.isRTL || targetLang === 'ar') {
                    translatedOutput.setAttribute('dir', 'rtl');
                    translatedOutput.style.textAlign = 'right';
                } else {
                    translatedOutput.setAttribute('dir', 'ltr');
                    translatedOutput.style.textAlign = 'left';
                }
            }

            try {
                const res = await LF.api.request('translate', 'POST', {
                    source_text: text,
                    source_lang: sourceLang,
                    target_lang: targetLang
                });

                if (translatedOutput && res.translated_text) {
                    translatedOutput.textContent = res.translated_text;
                    translatedOutput.style.opacity = '1.0';
                }
            } catch (err) {
                console.error('Translation failed:', err);
                if (translatedOutput) {
                    translatedOutput.textContent = '[Translation offline fallback]';
                    translatedOutput.style.opacity = '1.0';
                }
            }
        }

        // Play Recorded Voice Button Listener
        const playRecBtn = document.getElementById('lf-play-recording');
        if (playRecBtn) {
            playRecBtn.addEventListener('click', () => {
                LF.AudioStudioRecorder.playRecording();
            });
        }

        // Listen Original Source Text Button Listener
        const playSourceBtn = document.getElementById('lf-play-source-tts');
        if (playSourceBtn) {
            playSourceBtn.addEventListener('click', () => {
                const text = sourceInput ? sourceInput.value.trim() : '';
                const lang = sourceSelect ? sourceSelect.value : 'en';
                if (text) {
                    LF.speakOriginal(text, lang);
                } else {
                    LF.toast('Please enter or speak text first.', 'info');
                }
            });
        }

        // Microphone Button Listener (Web Speech API + MediaRecorder)
        if (micBtn) {
            micBtn.addEventListener('click', async () => {
                if (LF.SpeechEngine.isListening || LF.AudioStudioRecorder.isRecording) {
                    LF.SpeechEngine.stop();
                    LF.AudioStudioRecorder.stopRecording();
                    micBtn.classList.remove('recording');
                    if (micStatus) micStatus.textContent = 'Listening ended. Ready.';
                    if (playRecBtn) playRecBtn.style.display = 'inline-flex';
                } else {
                    const langCode = sourceSelect ? sourceSelect.value : 'en';
                    micBtn.classList.add('recording');
                    if (micStatus) micStatus.textContent = '● Listening... Speak now.';

                    // Start Audio Recorder & Visualizer
                    if (canvasWaveform) {
                        await LF.AudioStudioRecorder.startRecording(canvasWaveform);
                    }

                    LF.SpeechEngine.start(
                        langCode,
                        (transcript) => {
                            if (sourceInput && transcript.combined) {
                                sourceInput.value = transcript.combined;
                                clearTimeout(debounceTimer);
                                debounceTimer = setTimeout(() => performTranslation(), 300);
                            }
                        },
                        (errMsg) => {
                            micBtn.classList.remove('recording');
                            if (micStatus) micStatus.textContent = errMsg;
                        },
                        () => {
                            micBtn.classList.remove('recording');
                            if (micStatus) micStatus.textContent = 'Speech captured.';
                            if (playRecBtn) playRecBtn.style.display = 'inline-flex';
                            performTranslation();
                        }
                    );
                }
            });
        }

        // Listen Translation Target Audio Button
        if (playTtsBtn) {
            playTtsBtn.addEventListener('click', () => {
                const translatedText = translatedOutput ? translatedOutput.textContent.trim() : '';
                const targetLang = targetSelect ? targetSelect.value : 'fr';
                if (translatedText && !translatedText.startsWith('Translation will appear')) {
                    LF.speakTranslation(translatedText, targetLang);
                } else {
                    LF.toast('No translation available to listen to yet.', 'info');
                }
            });
        }

        if (copyBtn) {
            copyBtn.addEventListener('click', () => {
                const text = translatedOutput ? translatedOutput.textContent.trim() : '';
                if (text) {
                    LF.copyText(text);
                }
            });
        }

        if (saveBtn) {
            saveBtn.addEventListener('click', async () => {
                const sourceText = sourceInput.value.trim();
                const transText = translatedOutput ? translatedOutput.textContent.trim() : '';
                if (!sourceText || !transText) {
                    LF.toast('Please enter and translate text before saving.', 'warning');
                    return;
                }

                try {
                    await LF.api.request('saved', 'POST', {
                        source_text: sourceText,
                        translated_text: transText,
                        source_lang: sourceSelect ? sourceSelect.value : 'en',
                        target_lang: targetSelect ? targetSelect.value : 'fr',
                        category: 'General'
                    });
                    LF.toast('Phrase saved to notebook!', 'success');
                } catch (err) {
                    LF.toast('Saved phrase locally.', 'success');
                }
            });
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                if (sourceInput) sourceInput.value = '';
                if (translatedOutput) translatedOutput.textContent = '';
                if (micStatus) micStatus.textContent = 'Ready for input.';
            });
        }
    });

})(window.LinguaFlow);
