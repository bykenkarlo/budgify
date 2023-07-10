const shortly = "budgify-v1"
const assets = [
  "/",
  "assets/css/all.css",
  "assets/css/app.min.css",
  "assets/css/bootstrap-datepicker.min.css",
  "assets/css/daterangepicker.css",
  "assets/css/default.css",
  "assets/css/styles.css",
  "assets/css/select2.min.css",
  "assets/css/theme.css",
  "assets/js/jquery-3.6.3.min.js",
  "assets/js/clipboard.min.js",
  "assets/js/auth/app.js",
  "assets/js/auth/_csrf.js",
  "assets/js/_access.js",
  "assets/js/_webapp.js",
  "assets/js/_user.js",
  "assets/js/_web_package.min.js",
  "assets/js/sweetalert2.all.min.js",
  "assets/images/logo/hh-logo.webp",
  "assets/images/logo/mm-logo.webp",
  "assets/images/logo/logo.png",
  "assets/images/logo/hh-logo-light.webp",
  "assets/images/thumbnail.webp",
  "assets/images/bg/bg1.webp",
  "assets/images/bg/bg2.webp",
  "assets/images/other/loader.gif",
]
self.addEventListener("install", installEvent => {
  installEvent.waitUntil(
    caches.open(shortly).then(cache => {
      cache.addAll(assets)
    })
  )
})

self.addEventListener("fetch", fetchEvent => {
  fetchEvent.respondWith(
    caches.match(fetchEvent.request).then(res => {
      return res || fetch(fetchEvent.request)
    })
  )
})