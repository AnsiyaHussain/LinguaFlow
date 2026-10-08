/**
 * LinguaFlow - Service Worker for Offline Caching & PWA Support
 */

const CACHE_NAME = 'linguaflow-v1.0.0';
const ASSETS_TO_CACHE = [
  '/',
  '/translate',
  '/conversation',
  '/practice',
  '/travel',
  '/learn',
  '/dashboard',
  '/wp-content/themes/linguaflow/assets/css/linguaflow-main.css',
  '/wp-content/themes/linguaflow/assets/js/app.js',
  '/wp-content/themes/linguaflow/assets/js/translator.js',
  '/wp-content/themes/linguaflow/assets/js/speech.js',
  '/wp-content/themes/linguaflow/assets/js/recorder.js',
  '/wp-content/themes/linguaflow/assets/js/pronunciation.js',
  '/wp-content/themes/linguaflow/assets/js/conversation.js',
  '/wp-content/themes/linguaflow/assets/js/travel.js',
  '/wp-content/themes/linguaflow/assets/js/dashboard.js',
  '/wp-content/themes/linguaflow/assets/js/pwa.js'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      console.log('[LinguaFlow ServiceWorker] Caching app shell assets');
      return cache.addAll(ASSETS_TO_CACHE).catch(err => console.warn('Cache addAll non-fatal warning:', err));
    })
  );
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keyList) => {
      return Promise.all(keyList.map((key) => {
        if (key !== CACHE_NAME) {
          console.log('[LinguaFlow ServiceWorker] Removing old cache:', key);
          return caches.delete(key);
        }
      }));
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  if (event.request.method !== 'GET') return;

  event.respondWith(
    caches.match(event.request).then((cachedResponse) => {
      if (cachedResponse) {
        return cachedResponse;
      }
      return fetch(event.request).then((networkResponse) => {
        if (networkResponse && networkResponse.status === 200 && networkResponse.type === 'basic') {
          const responseToCache = networkResponse.clone();
          caches.open(CACHE_NAME).then((cache) => {
            cache.put(event.request, responseToCache);
          });
        }
        return networkResponse;
      }).catch(() => {
        // Return offline fallback if offline and asset not in cache
        if (event.request.mode === 'navigate') {
          return caches.match('/translate') || caches.match('/');
        }
      });
    })
  );
});
