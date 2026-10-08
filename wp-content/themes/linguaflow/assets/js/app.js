/**
 * LinguaFlow - Core JavaScript Infrastructure
 * Handles REST API client requests, toast notifications, state management.
 */

window.LinguaFlow = window.LinguaFlow || {};

(function(LF) {
    'use strict';

    // API Wrapper
    LF.api = {
        async request(endpoint, method = 'GET', data = null) {
            const config = window.LinguaFlowConfig || { apiUrl: '/wp-json/linguaflow/v1', nonce: '' };
            const url = `${config.apiUrl.replace(/\/$/, '')}/${endpoint.replace(/^\//, '')}`;

            const headers = {
                'Content-Type': 'application/json',
                'X-LinguaFlow-Nonce': config.nonce
            };

            const options = {
                method,
                headers
            };

            if (data && (method === 'POST' || method === 'PUT' || method === 'PATCH')) {
                options.body = JSON.stringify(data);
            }

            try {
                const response = await fetch(url, options);
                const result = await response.json();
                if (!response.ok) {
                    throw new Error(result.message || 'API request failed');
                }
                return result;
            } catch (err) {
                console.warn('LinguaFlow API Error/Fallback:', err.message);
                throw err;
            }
        }
    };

    // Toast Notifications System
    LF.toast = function(message, type = 'info') {
        let container = document.querySelector('.lf-toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'lf-toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = `lf-toast lf-toast-${type}`;
        toast.textContent = message;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    };

    // Centralized Language Registry
    LF.languages = {
        'en': { code: 'en', name: 'English', native: 'English', flag: '🇬🇧', bcp47: 'en-US', isRTL: false },
        'fr': { code: 'fr', name: 'French', native: 'Français', flag: '🇫🇷', bcp47: 'fr-FR', isRTL: false },
        'es': { code: 'es', name: 'Spanish', native: 'Español', flag: '🇪🇸', bcp47: 'es-ES', isRTL: false },
        'de': { code: 'de', name: 'German', native: 'Deutsch', flag: '🇩🇪', bcp47: 'de-DE', isRTL: false },
        'it': { code: 'it', name: 'Italian', native: 'Italiano', flag: '🇮🇹', bcp47: 'it-IT', isRTL: false },
        'pt': { code: 'pt', name: 'Portuguese', native: 'Português', flag: '🇵🇹', bcp47: 'pt-BR', isRTL: false },
        'ar': { code: 'ar', name: 'Arabic', native: 'العربية', flag: '🇸🇦', bcp47: 'ar-SA', isRTL: true },
        'hi': { code: 'hi', name: 'Hindi', native: 'हिन्दी', flag: '🇮🇳', bcp47: 'hi-IN', isRTL: false },
        'kn': { code: 'kn', name: 'Kannada', native: 'ಕನ್ನಡ', flag: '🇮🇳', bcp47: 'kn-IN', isRTL: false },
        'ml': { code: 'ml', name: 'Malayalam', native: 'മലയാളം', flag: '🇮🇳', bcp47: 'ml-IN', isRTL: false },
        'ja': { code: 'ja', name: 'Japanese', native: '日本語', flag: '🇯🇵', bcp47: 'ja-JP', isRTL: false },
        'zh': { code: 'zh', name: 'Mandarin Chinese', native: '中文', flag: '🇨🇳', bcp47: 'zh-CN', isRTL: false },
        'ru': { code: 'ru', name: 'Russian', native: 'Русский', flag: '🇷🇺', bcp47: 'ru-RU', isRTL: false }
    };

    LF.getLanguageConfig = function(code) {
        if (!code) return LF.languages['en'];
        const clean = code.trim().toLowerCase().split('-')[0];
        return LF.languages[clean] || {
            code: clean,
            name: code.toUpperCase(),
            native: code.toUpperCase(),
            flag: '🌐',
            bcp47: code.includes('-') ? code : `${code}-${code.toUpperCase()}`,
            isRTL: clean === 'ar' || clean === 'he' || clean === 'fa' || clean === 'ur'
        };
    };

    // Pre-warm browser voices
    if ('speechSynthesis' in window) {
        window.speechSynthesis.getVoices();
        if (typeof window.speechSynthesis.onvoiceschanged !== 'undefined') {
            window.speechSynthesis.onvoiceschanged = () => {
                window.speechSynthesis.getVoices();
            };
        }
    }

    // Target Language Voice Selection Resolver
    LF.resolveVoice = function(langCode) {
        if (!('speechSynthesis' in window)) return null;
        const config = LF.getLanguageConfig(langCode);
        const targetBcp47 = config.bcp47.toLowerCase();
        const baseLang = targetBcp47.split('-')[0];

        const voices = window.speechSynthesis.getVoices();
        if (!voices || voices.length === 0) {
            return null;
        }

        // 1. Exact BCP-47 locale match (e.g. ar-SA, hi-IN, kn-IN, ml-IN, fr-FR)
        let match = voices.find(v => {
            const vLang = v.lang.toLowerCase().replace('_', '-');
            return vLang === targetBcp47;
        });
        if (match) return match;

        // 2. Base language prefix match (e.g. ar-AE, ar-EG, hi-*, fr-*)
        match = voices.find(v => {
            const vLang = v.lang.toLowerCase().replace('_', '-');
            return vLang.startsWith(baseLang);
        });
        if (match) return match;

        // 3. Match voice name against language name/native name
        const langName = config.name.toLowerCase();
        const nativeName = config.native.toLowerCase();
        match = voices.find(v => {
            const nameLower = v.name.toLowerCase();
            return nameLower.includes(langName) || nameLower.includes(nativeName);
        });
        if (match) return match;

        // Return null: DO NOT fall back to English voice!
        return null;
    };

    // Text to Speech Client (Target-Language Aware)
    LF.speak = function(text, langCode = 'en', isTranslation = false) {
        if (!text || !text.trim()) {
            LF.toast('No text available to read aloud.', 'info');
            return;
        }

        if (!('speechSynthesis' in window)) {
            LF.toast('Text-to-speech is not supported in this browser.', 'warning');
            return;
        }

        window.speechSynthesis.cancel(); // Stop active audio

        const config = LF.getLanguageConfig(langCode);
        const targetBcp47 = config.bcp47;
        const voice = LF.resolveVoice(langCode);

        const utterance = new SpeechSynthesisUtterance(text.trim());
        utterance.lang = targetBcp47;
        utterance.rate = 0.92;
        utterance.pitch = 1.0;

        if (voice) {
            utterance.voice = voice;
            LF.toast(`Speaking ${config.native} (${config.name})...`, 'info');
            window.speechSynthesis.speak(utterance);
        } else {
            const voices = window.speechSynthesis.getVoices();
            if (voices.length === 0) {
                // Voices array might still be loading, set lang attribute and play
                LF.toast(`Speaking ${config.native} (${config.name})...`, 'info');
                window.speechSynthesis.speak(utterance);
            } else {
                // Voices ARE loaded, and no target-language voice is available
                // DO NOT FALL BACK TO ENGLISH VOICE SILENTLY!
                console.warn(`No native voice found for ${config.name} (${targetBcp47}). Available voices:`, voices.map(v => `${v.name} [${v.lang}]`));
                LF.toast(`${config.name} (${config.native}) voice is not installed in this browser speech engine.`, 'warning');
            }
        }
    };

    // Explicit audio methods for Source vs Target
    LF.speakOriginal = function(sourceText, sourceLang = 'en') {
        LF.speak(sourceText, sourceLang, false);
    };

    LF.speakTranslation = function(translatedText, targetLang = 'fr') {
        LF.speak(translatedText, targetLang, true);
    };

    // Copy to Clipboard Helper
    LF.copyText = function(text) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(() => {
                LF.toast('Copied to clipboard!', 'success');
            }).catch(() => {
                LF.fallbackCopy(text);
            });
        } else {
            LF.fallbackCopy(text);
        }
    };

    LF.fallbackCopy = function(text) {
        const input = document.createElement('textarea');
        input.value = text;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        LF.toast('Copied to clipboard!', 'success');
    };

})(window.LinguaFlow);
