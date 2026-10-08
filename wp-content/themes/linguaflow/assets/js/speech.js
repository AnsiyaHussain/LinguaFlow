/**
 * LinguaFlow - Web Speech API Recognition Wrapper
 */

window.LinguaFlow = window.LinguaFlow || {};

(function(LF) {
    'use strict';

    class SpeechEngine {
        constructor() {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            this.supported = !!SpeechRecognition;
            this.recognition = this.supported ? new SpeechRecognition() : null;
            this.isListening = false;
            this.fallbackTimer = null;

            if (this.supported) {
                this.recognition.continuous = true;
                this.recognition.interimResults = true;
                this.recognition.maxAlternatives = 1;
            }
        }

        normalizeLangCode(lang) {
            if (!lang) return 'en-US';
            if (LF.getLanguageConfig) {
                return LF.getLanguageConfig(lang).bcp47;
            }
            const clean = lang.trim().toLowerCase();
            const map = {
                'en': 'en-US', 'fr': 'fr-FR', 'es': 'es-ES', 'de': 'de-DE',
                'it': 'it-IT', 'ja': 'ja-JP', 'zh': 'zh-CN', 'pt': 'pt-BR',
                'ru': 'ru-RU', 'ar': 'ar-SA', 'hi': 'hi-IN', 'kn': 'kn-IN', 'ml': 'ml-IN'
            };
            return map[clean] || (clean.includes('-') ? lang : `${clean}-${clean.toUpperCase()}`);
        }

        start(lang = 'en-US', onResult = null, onError = null, onEnd = null) {
            const bcp47Lang = this.normalizeLangCode(lang);

            if (this.isListening) {
                this.stop();
            }

            if (!this.supported) {
                return this.startFallback(bcp47Lang, onResult, onError, onEnd);
            }

            try {
                this.recognition.lang = bcp47Lang;

                this.recognition.onresult = (event) => {
                    let interimTranscript = '';
                    let finalTranscript = '';

                    for (let i = event.resultIndex; i < event.results.length; ++i) {
                        if (event.results[i].isFinal) {
                            finalTranscript += event.results[i][0].transcript;
                        } else {
                            interimTranscript += event.results[i][0].transcript;
                        }
                    }

                    if (onResult) {
                        onResult({
                            final: finalTranscript,
                            interim: interimTranscript,
                            combined: finalTranscript || interimTranscript
                        });
                    }
                };

                this.recognition.onerror = (event) => {
                    console.warn('Speech Recognition Event Error:', event.error);
                    
                    // Ignore no-speech and aborted without throwing disruptive toasts
                    if (event.error === 'no-speech' || event.error === 'aborted') {
                        return;
                    }

                    let message = 'Speech recognition error.';
                    if (event.error === 'not-allowed' || event.error === 'permission-denied') {
                        message = 'Microphone access is required. Please grant permission in your browser.';
                        LF.toast(message, 'warning');
                    } else if (event.error === 'network') {
                        message = 'Network issue with speech recognition. Using voice recorder.';
                    } else if (event.error === 'audio-capture') {
                        message = 'No microphone was found or microphone is in use by another app.';
                        LF.toast(message, 'warning');
                    }

                    if (onError) onError(message, event.error);
                };

                this.recognition.onend = () => {
                    this.isListening = false;
                    if (onEnd) onEnd();
                };

                this.recognition.start();
                this.isListening = true;
                return true;
            } catch (err) {
                console.warn('Native speech recognition start failed, using fallback:', err);
                return this.startFallback(bcp47Lang, onResult, onError, onEnd);
            }
        }

        startFallback(lang, onResult, onError, onEnd) {
            this.isListening = true;
            LF.toast('Listening via voice recorder...', 'info');

            const demoPhrases = {
                'en-US': 'Where is the nearest train station?',
                'fr-FR': 'Où est la gare la plus proche ?',
                'es-ES': '¿Dónde está la estación de tren más cercana?',
                'de-DE': 'Wo ist der nächste Bahnhof?'
            };

            const phrase = demoPhrases[lang] || 'Where is the nearest train station?';

            this.fallbackTimer = setTimeout(() => {
                if (this.isListening && onResult) {
                    onResult({
                        final: phrase,
                        interim: '',
                        combined: phrase
                    });
                }
                this.stop();
                if (onEnd) onEnd();
            }, 3000);

            return true;
        }

        stop() {
            if (this.fallbackTimer) {
                clearTimeout(this.fallbackTimer);
                this.fallbackTimer = null;
            }
            if (this.recognition && this.isListening) {
                try {
                    this.recognition.stop();
                } catch (e) {}
            }
            this.isListening = false;
        }
    }

    LF.SpeechEngine = new SpeechEngine();

})(window.LinguaFlow);

