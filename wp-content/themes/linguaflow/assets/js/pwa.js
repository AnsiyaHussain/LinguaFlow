/**
 * LinguaFlow - Progressive Web App (PWA) Manager & Offline Indicator
 */

(function() {
    'use strict';

    // Register Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/service-worker.js')
                .then((reg) => {
                    console.log('LinguaFlow PWA ServiceWorker registered with scope:', reg.scope);
                })
                .catch((err) => {
                    console.warn('LinguaFlow PWA ServiceWorker registration failed:', err);
                });
        });
    }

    // Monitor Online/Offline Status
    function updateOnlineStatus() {
        const isOnline = navigator.onLine;
        let banner = document.getElementById('lf-offline-banner');

        if (!isOnline) {
            if (!banner) {
                banner = document.createElement('div');
                banner.id = 'lf-offline-banner';
                banner.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    right: 0;
                    background: #141413;
                    color: #F5F4EF;
                    font-size: 0.82rem;
                    font-weight: 500;
                    text-align: center;
                    padding: 0.4rem;
                    z-index: 99999;
                    letter-spacing: 0.05em;
                `;
                banner.innerHTML = '⚡ <strong>Offline Mode:</strong> Saved phrases and travel notebook accessible. Live cloud translation paused.';
                document.body.appendChild(banner);
            }
        } else if (banner) {
            banner.remove();
        }
    }

    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);
    document.addEventListener('DOMContentLoaded', updateOnlineStatus);

    // PWA Install Prompt Capture
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        const installBtn = document.getElementById('lf-pwa-install-btn');
        if (installBtn) {
            installBtn.style.display = 'inline-flex';
            installBtn.addEventListener('click', () => {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted PWA installation');
                    }
                    deferredPrompt = null;
                    installBtn.style.display = 'none';
                });
            });
        }
    });

})();
