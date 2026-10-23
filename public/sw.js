self.addEventListener('install', (event) => {
    event.waitUntil(caches.open('filo-v1').then((cache) => cache.addAll(['/css/app.css'])));
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        fetch(event.request).catch(() => caches.match(event.request))
    );
});
