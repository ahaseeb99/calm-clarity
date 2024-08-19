const QUICKAI_SERVICE = "QUICKAI_SERVICE_CACHE";

self.addEventListener("activate", function (event) {
    console.log("ServiceWorker activated.");
});

self.addEventListener("install", function (event) {
    event.waitUntil(
        caches.open(QUICKAI_SERVICE).then(function (cache) {
            return cache.addAll([]);
        }),
    );
});

self.addEventListener("fetch", (e) => {});