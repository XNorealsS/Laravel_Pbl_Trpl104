<!-- ======================================================================
     ACCEPT COOKIES BANNER (Sesuai Mockup Gambar: BG Black, Text White, Button Hijau JajanRia)
     ====================================================================== -->
<div id="cookieConsentBannerGlobal" class="cookie-consent-bar" role="dialog" aria-live="polite" aria-label="Persetujuan Privasi & Cookie">
  <div class="cookie-consent-container">
    <div class="cookie-text-col">
      <h4 class="cookie-heading-main">Kami menghargai Privasi anda</h4>
      <p class="cookie-desc-paragraph">
        Situs web ini menyimpan cookies di computer anda. Cookies ini digunakan untuk mengumpulkan informasi tentang bagaimana anda berinteraksi dengan situs web kami dan memungkinkan kami untuk mengingat anda. Kami menggunakan informasi ini untuk meningkatkan dan menyesuaikan pengalaman penjelajahan anda dan untuk analitik dan metrik tentang pengunjung kami baik di situs web ini maupun media lainnya. Untuk mengetahui lebih lanjut tentang cookies yang kami gunakan, lihat <a href="javascript:void(0)" onclick="openGlobalCookiePolicy()" class="cookie-policy-link">Kebijakan Cookie</a>
      </p>
    </div>
    <div class="cookie-btns-col">
      <button type="button" class="btn-cookie-manage" onclick="manageGlobalCookieSettings()">
        Kelola Cookie
      </button>
      <button type="button" class="btn-cookie-accept-all" id="btnAcceptAllCookiesGlobal" onclick="acceptGlobalCookies()">
        Terima Semua Cookie
      </button>
    </div>
  </div>
</div>

<script>
  function checkGlobalCookieConsent() {
    var banner = document.getElementById('cookieConsentBannerGlobal');
    if (!banner) return;
    var consent = localStorage.getItem('jajanria_cookie_consent');
    if (!consent) {
      setTimeout(function() {
        banner.classList.add('visible');
      }, 400);
    }
  }

  function acceptGlobalCookies() {
    localStorage.setItem('jajanria_cookie_consent', 'accepted');
    var banner = document.getElementById('cookieConsentBannerGlobal');
    if (banner) banner.classList.remove('visible');
  }

  function manageGlobalCookieSettings() {
    alert("Pengaturan Cookie: Hanya cookies esensial dan preferensi jarak toko terdekat yang aktif di JajanRia.");
    acceptGlobalCookies();
  }

  function openGlobalCookiePolicy() {
    alert("Kebijakan Cookie JajanRia:\nCookies digunakan murni untuk menyimpan preferensi filter lokasi kampus, jarak UMKM terdekat, dan sesi login akun pengguna.");
  }

  document.addEventListener('DOMContentLoaded', checkGlobalCookieConsent);
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    checkGlobalCookieConsent();
  }
</script>
