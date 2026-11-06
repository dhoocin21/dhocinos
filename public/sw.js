// Service Worker for Hyundai AutoShow Pro PWA (Network-First Strategy for HTML)
const CACHE_NAME = 'autoshow-pwa-v2';
const STATIC_ASSETS = [
  '/manifest.json',
  '/assets/images/hyundai_logo.png'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => {
      return cache.addAll(STATIC_ASSETS);
    })
  );
  self.skipWaiting();
});

// Clear ALL old caches on activation to immediately eliminate stale HTML/CSS
self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((cacheNames) => {
      return Promise.all(
        cacheNames.map((name) => {
          if (name !== CACHE_NAME) {
            console.log('Purging legacy cache:', name);
            return caches.delete(name);
          }
        })
      );
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', (event) => {
  if (event.request.method !== 'GET') return;

  // 1. Navigation requests (HTML pages): ALWAYS NETWORK FIRST!
  // Never serve stale HTML that references deleted CSS hash bundles
  if (event.request.mode === 'navigate') {
    event.respondWith(
      fetch(event.request)
        .then((networkResponse) => {
          return networkResponse;
        })
        .catch(() => {
          // Fallback to cache only when completely offline
          return caches.match(event.request) || caches.match('/');
        })
    );
    return;
  }

  // 2. Static image/font assets: Cache-first with network fallback
  if (event.request.destination === 'image' || event.request.destination === 'font') {
    event.respondWith(
      caches.match(event.request).then((cached) => {
        if (cached) return cached;
        return fetch(event.request).then((res) => {
          if (res && res.status === 200) {
            const clone = res.clone();
            caches.open(CACHE_NAME).then((cache) => cache.put(event.request, clone));
          }
          return res;
        }).catch(() => null);
      })
    );
    return;
  }

  // 3. For CSS and JS chunks: Network first to avoid stale Vite hashes
  event.respondWith(
    fetch(event.request).catch(() => caches.match(event.request))
  );
});
