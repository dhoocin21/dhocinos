// Auto-uninstall Service Worker & purge all legacy caches permanently
self.addEventListener('install', () => {
  self.skipWaiting();
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => {
      return Promise.all(keys.map((k) => caches.delete(k)));
    }).then(() => {
      return self.registration.unregister();
    }).then(() => {
      return self.clients.claim();
    })
  );
});

// Pass all requests directly to the network with zero interception
self.addEventListener('fetch', () => {
  return;
});
