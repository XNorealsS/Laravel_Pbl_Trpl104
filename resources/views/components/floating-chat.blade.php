{{-- Popup chat & riwayat pesanan mengambang untuk pengunjung --}}

{{-- Speed-Dial Menu Pop-up (Menampilkan Pilihan Chat & History) --}}
<div class="floating-nav-menu" id="floatingNavMenu" style="display: none;">
  <div class="nav-menu-card">
    <div class="nav-menu-header">
      <span class="nav-menu-title">Akses Cepat</span>
      <span class="nav-menu-sub">Pilih menu navigasi layanan</span>
    </div>

    <button type="button" class="nav-menu-item" id="btnNavOpenChat">
      <div class="nav-menu-icon support-icon" style="background: #E8F5E9; color: #2E8B3D;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
          <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
        </svg>
      </div>
      <div class="nav-menu-text">
        <strong>Customer Support</strong>
        <span>Pusat bantuan & kendala aplikasi</span>
      </div>
      <svg class="nav-menu-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
    </button>

    <button type="button" class="nav-menu-item" id="btnNavOpenHistory">
      <div class="nav-menu-icon history-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"></circle>
          <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
      </div>
      <div class="nav-menu-text">
        <strong>History Pesanan</strong>
        <span>Riwayat transaksi & status bukti bayar</span>
      </div>
      <svg class="nav-menu-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
    </button>
  </div>
</div>

{{-- Tombol Utama Floating Navigation Launcher --}}
<div class="floating-nav-fab" id="floatingNavFab">
  <button type="button" class="fab-nav-btn" id="btnToggleNav" aria-label="Buka Navigasi JajanRia">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <circle cx="12" cy="12" r="10"></circle>
      <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
    </svg>
    <span class="fab-nav-text">Navigasi</span>
  </button>
  {{-- Hidden button for backward compatibility with topbar triggers --}}
  <button type="button" id="btnToggleChat" style="display:none;"></button>
</div>

{{-- Backdrop Gelap Saat Chat / History Terbuka Agar Pengunjung Fokus --}}
<div class="floating-chat-backdrop" id="chatBackdrop" aria-hidden="true"></div>

{{-- Drawer Chat Popup --}}
<div class="floating-chat-drawer hidden" id="chatDrawer" role="dialog" aria-labelledby="chatTargetName">

  @if(!session('user'))
    {{-- Gateway Login Google Firebase Jika Pengunjung Belum Masuk --}}
    <div class="chat-drawer-head">
      <div class="chat-drawer-head-info">
        <strong>Masuk Akun Pengunjung</strong>
        <span>JajanRia Chat & Review</span>
      </div>
      <button type="button" class="chat-close-btn" id="btnCloseChat" aria-label="Tutup chat">&times;</button>
    </div>

    <div class="chat-auth-gate-body">
      <div class="auth-gate-icon">
        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--green);">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
        </svg>
      </div>
      <h3>Masuk untuk Mulai Chat</h3>
      <p>Untuk bertanya ketersediaan menu ke UMKM atau memberi ulasan pesanan, silakan masuk dengan akun Google Anda.</p>

      <div class="auth-gate-benefit">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
        <span>Otomatis terdaftar tanpa form manual</span>
      </div>

      <button type="button" class="btn-google-chat" id="btnGoogleChatAuth" title="Masuk Dengan Akun Google">
        <svg class="google-icon-svg" width="18" height="18" viewBox="0 0 24 24">
          <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
          <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
          <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
          <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
        </svg>
        <span id="chatGoogleBtnText">Masuk Dengan Google</span>
      </button>

      <a href="{{ route('login') }}" style="margin-top: 18px; font-size: 0.8rem; color: #64748b; text-decoration: underline;">
        Atau login sebagai Seller / Admin
      </a>
    </div>

  @else
    {{-- Header Customer Support untuk Pengguna yang Sudah Login --}}
    <div class="chat-drawer-head support-drawer-head">
      <div class="support-head-profile">
        <div class="support-agent-avatar">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
            <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
          </svg>
          <span class="support-online-dot" title="Tim Support Online"></span>
        </div>
        <div class="chat-drawer-head-info">
          <strong id="chatTargetName">Customer Support JajanRia</strong>
          <span id="chatTargetArea" class="support-head-sub">Pusat Bantuan & Layanan Pengguna</span>
        </div>
      </div>
      <div style="display: flex; align-items: center; gap: 6px;">
        <button type="button" class="chat-close-btn" id="btnCloseChat" aria-label="Tutup customer support">&times;</button>
      </div>
    </div>

    {{-- Support Quick Pills (Bantuan Cepat) --}}
    <div class="support-quick-pills" id="supportQuickPills">
      <button type="button" class="quick-pill-btn" onclick="window.kirimPesanQuickSupport('Status verifikasi bukti transfer pembayaran saya')">
        💳 Status Verifikasi
      </button>
      <button type="button" class="quick-pill-btn" onclick="window.kirimPesanQuickSupport('Bagaimana cara upload bukti transfer?')">
        📸 Cara Upload Bukti
      </button>
      <button type="button" class="quick-pill-btn" onclick="window.kirimPesanQuickSupport('Saya mengalami kendala pada pesanan saya')">
        ⚠️ Kendala Pesanan
      </button>
    </div>

    {{-- Riwayat Pesan Customer Support --}}
    <div class="chat-messages-body" id="chatMessagesBody">
      <div style="text-align: center; color: var(--muted); font-size: .85rem; padding-top: 40px;">
        Memuat percakapan bantuan...
      </div>
    </div>

    {{-- Formulir Kirim Pesan Support --}}
    <form class="chat-input-bar" id="chatInputForm">
      @csrf
      <input type="text" id="chatInputText" placeholder="Ketik pertanyaan atau kendala..." aria-label="Ketik pesan bantuan" required>
      <button type="submit" class="chat-send-btn">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        <span>Kirim</span>
      </button>
    </form>
  @endif

</div>

{{-- Drawer Riwayat Pesanan (History) --}}
<div class="floating-chat-drawer hidden" id="historyDrawer" role="dialog" aria-labelledby="historyDrawerTitle">
  <div class="chat-drawer-head">
    <div class="chat-drawer-head-info">
      <strong id="historyDrawerTitle">Riwayat Pesanan Saya</strong>
      <span>Status belanja, menu, & konfirmasi</span>
    </div>
    <div style="display: flex; align-items: center; gap: 6px;">
      <button type="button" class="chat-close-btn" id="btnCloseHistory" aria-label="Tutup riwayat">&times;</button>
    </div>
  </div>

  @if(!session('user'))
    <div class="chat-auth-gate-body">
      <div class="auth-gate-icon">
        <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--green);">
          <circle cx="12" cy="12" r="10"></circle>
          <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
      </div>
      <h3>Masuk Akun Pengunjung</h3>
      <p>Silakan masuk dengan akun Google Anda untuk melihat riwayat pesanan dan status bukti pembayaran.</p>

      <button type="button" class="btn-google-chat" onclick="document.getElementById('btnGoogleChatAuth')?.click()" title="Masuk Dengan Akun Google">
        <svg class="google-icon-svg" width="18" height="18" viewBox="0 0 24 24">
          <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
          <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
          <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
          <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
        </svg>
        <span>Masuk Dengan Google</span>
      </button>
    </div>
  @else
    <div class="history-drawer-body" id="historyDrawerBody" style="flex: 1; overflow-y: auto; padding: 14px 16px; background: #f8fafc;">
      <div style="text-align: center; color: var(--muted); font-size: .85rem; padding-top: 40px;">
        Memuat riwayat pesanan...
      </div>
    </div>
  @endif
</div>

{{-- Modal Penilaian & Ulasan (F008, F009) --}}
<div class="review-modal-backdrop" id="reviewModal" style="display:none;">
  <div class="review-modal-card" role="dialog" aria-labelledby="modalReviewTitle">
    <h3 id="modalReviewTitle" style="font-size: 1.15rem; font-weight: 800; margin-bottom: 4px;">Beri Penilaian Lapak</h3>
    <p style="font-size: .85rem; color: var(--muted);">Bagikan pengalaman Anda memesan di lapak ini.</p>

    <form id="reviewSubmitForm" style="margin-top: 14px;">
      @csrf
      <input type="hidden" id="reviewOrderId" value="">
      
      <div style="text-align: center;">
        <label style="font-size: .82rem; font-weight: 700; color: var(--text);">Rating Bintang (1 - 5):</label>
        <div class="review-stars" id="starContainer">
          <span class="star-btn active" data-rating="1">&#9733;</span>
          <span class="star-btn active" data-rating="2">&#9733;</span>
          <span class="star-btn active" data-rating="3">&#9733;</span>
          <span class="star-btn active" data-rating="4">&#9733;</span>
          <span class="star-btn active" data-rating="5">&#9733;</span>
        </div>
        <input type="hidden" id="reviewStarValue" value="5">
      </div>

      <label for="reviewCommentText" style="display: block; font-size: .82rem; font-weight: 700; margin-bottom: 4px;">Ulasan Anda:</label>
      <textarea id="reviewCommentText" placeholder="Tuliskan ulasan mengenai rasa makanan, porsi, atau pelayanan..." required></textarea>

      <div style="display: flex; gap: 8px; justify-content: flex-end;">
        <button type="button" class="btn" id="btnCancelReview" style="padding: 8px 16px;">Batal</button>
        <button type="submit" class="btn primary" style="padding: 8px 18px;">Kirim Ulasan</button>
      </div>
    </form>
  </div>
</div>

{{-- Modal Upload Bukti Pembayaran --}}
<div class="review-modal-backdrop" id="paymentProofModal" style="display:none; z-index: 10001;">
  <div class="review-modal-card" role="dialog" aria-labelledby="modalPaymentTitle">
    <h3 id="modalPaymentTitle" style="font-size: 1.15rem; font-weight: 800; margin-bottom: 4px;">Upload Bukti Pembayaran</h3>
    <p style="font-size: .85rem; color: var(--muted);">Unggah foto struk transfer atau bukti pembayaran Anda.</p>

    <form id="paymentProofSubmitForm" style="margin-top: 14px;" enctype="multipart/form-data">
      @csrf
      <input type="hidden" id="proofOrderId" value="">

      <div style="margin-bottom: 12px;">
        <label for="proofFileInput" style="display: block; font-size: .82rem; font-weight: 700; margin-bottom: 6px;">Pilih Foto Struk / Bukti Bayar:</label>
        <input type="file" id="proofFileInput" accept="image/*" required style="width: 100%; font-size: 0.85rem; border: 1px solid var(--border); padding: 8px; border-radius: 8px;">
        <div id="proofImagePreviewContainer" style="display: none; margin-top: 8px; text-align: center;">
          <img id="proofImagePreview" src="" alt="Preview Bukti" style="max-height: 180px; max-width: 100%; border-radius: 8px; margin: 0 auto; border: 1px solid var(--border);">
        </div>
      </div>

      <div style="margin-bottom: 14px;">
        <label for="proofNoteText" style="display: block; font-size: .82rem; font-weight: 700; margin-bottom: 4px;">Catatan (Opsional):</label>
        <input type="text" id="proofNoteText" placeholder="Contoh: Transfer via BCA / Mandiri a.n..." style="width: 100%; padding: 8px 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 0.85rem;">
      </div>

      <div style="display: flex; gap: 8px; justify-content: flex-end;">
        <button type="button" class="btn" id="btnCancelProof" style="padding: 8px 16px;">Batal</button>
        <button type="submit" class="btn primary" id="btnSubmitProof" style="padding: 8px 18px;">Kirim Bukti</button>
      </div>
    </form>
  </div>
</div>

<script>
(function() {
  const isLoggedIn = {{ session('user') ? 'true' : 'false' }};

  // Nav Launcher & Menu Elements
  const btnToggleNav = document.getElementById('btnToggleNav');
  const navMenu = document.getElementById('floatingNavMenu');
  const btnNavOpenChat = document.getElementById('btnNavOpenChat');
  const btnNavOpenHistory = document.getElementById('btnNavOpenHistory');

  // Chat Elements
  const btnToggleChat = document.getElementById('btnToggleChat');
  const btnCloseChat = document.getElementById('btnCloseChat');
  const chatDrawer = document.getElementById('chatDrawer');
  const backdrop = document.getElementById('chatBackdrop');
  const storeSelect = document.getElementById('chatStoreSelect');
  const targetName = document.getElementById('chatTargetName');
  const targetArea = document.getElementById('chatTargetArea');
  const statusPill = document.getElementById('chatStatusPill');
  const reviewPrompt = document.getElementById('chatReviewPrompt');
  const messagesBody = document.getElementById('chatMessagesBody');
  const inputForm = document.getElementById('chatInputForm');
  const inputText = document.getElementById('chatInputText');

  // History Drawer Elements
  const historyDrawer = document.getElementById('historyDrawer');
  const btnCloseHistory = document.getElementById('btnCloseHistory');
  const historyBody = document.getElementById('historyDrawerBody');

  // Modals
  const reviewModal = document.getElementById('reviewModal');
  const btnOpenReview = document.getElementById('btnOpenReviewModal');
  const btnCancelReview = document.getElementById('btnCancelReview');
  const reviewForm = document.getElementById('reviewSubmitForm');
  const reviewOrderId = document.getElementById('reviewOrderId');
  const reviewStarValue = document.getElementById('reviewStarValue');
  const reviewComment = document.getElementById('reviewCommentText');
  const stars = document.querySelectorAll('.star-btn');

  let activeUmkmId = null;
  let currentOrderId = null;

  // Toggle & Close Floating Navigation Speed-Dial Menu
  function toggleNavMenu() {
    if (!navMenu) return;
    const isHidden = navMenu.style.display === 'none' || navMenu.style.display === '';
    if (isHidden) {
      closeChatDrawer();
      closeHistoryDrawer();
      navMenu.style.display = 'block';
      if (btnToggleNav) btnToggleNav.classList.add('active');
    } else {
      closeNavMenu();
    }
  }

  function closeNavMenu() {
    if (navMenu) navMenu.style.display = 'none';
    if (btnToggleNav) btnToggleNav.classList.remove('active');
  }

  if (btnToggleNav) {
    btnToggleNav.addEventListener('click', function(e) {
      e.stopPropagation();
      toggleNavMenu();
    });
  }

  // Open Customer Support Drawer from Navigation Menu
  function openChatDrawer() {
    closeNavMenu();
    closeHistoryDrawer();
    if (chatDrawer) chatDrawer.classList.remove('hidden');
    if (backdrop) backdrop.classList.add('active');
    if (isLoggedIn) {
      loadSupportMessages();
    }
  }

  function closeChatDrawer() {
    if (chatDrawer) chatDrawer.classList.add('hidden');
    if (!historyDrawer || historyDrawer.classList.contains('hidden')) {
      if (backdrop) backdrop.classList.remove('active');
    }
  }

  // Open History Drawer from Navigation Menu
  function openHistoryDrawer() {
    closeNavMenu();
    closeChatDrawer();
    if (historyDrawer) historyDrawer.classList.remove('hidden');
    if (backdrop) backdrop.classList.add('active');
    loadOrderHistory();
  }

  function closeHistoryDrawer() {
    if (historyDrawer) historyDrawer.classList.add('hidden');
    if (!chatDrawer || chatDrawer.classList.contains('hidden')) {
      if (backdrop) backdrop.classList.remove('active');
    }
  }

  window.bukaHistoryPesanan = openHistoryDrawer;
  window.bukaCustomerSupport = openChatDrawer;

  // Global helper untuk kompatibilitas
  window.bukaChatToko = function(idUmkm, pesanAwal = '') {
    openChatDrawer();
    if (pesanAwal) {
      setTimeout(() => {
        const input = document.getElementById('chatInputText');
        if (input) {
          input.value = pesanAwal;
          input.focus();
        }
      }, 250);
    }
  };

  if (btnNavOpenChat) {
    btnNavOpenChat.addEventListener('click', function() {
      openChatDrawer();
    });
  }

  if (btnNavOpenHistory) {
    btnNavOpenHistory.addEventListener('click', function() {
      openHistoryDrawer();
    });
  }

  // Legacy button triggers (from topbar button or external code)
  if (btnToggleChat) {
    btnToggleChat.addEventListener('click', function() {
      if (!chatDrawer) return;
      if (chatDrawer.classList.contains('hidden')) {
        openChatDrawer();
      } else {
        closeChatDrawer();
      }
    });
  }

  if (btnCloseChat) {
    btnCloseChat.addEventListener('click', closeChatDrawer);
  }

  if (btnCloseHistory) {
    btnCloseHistory.addEventListener('click', closeHistoryDrawer);
  }

  if (backdrop) {
    backdrop.addEventListener('click', function() {
      closeChatDrawer();
      closeHistoryDrawer();
      closeNavMenu();
    });
  }

  // Close menus on outside click or Escape key
  document.addEventListener('click', function(e) {
    if (navMenu && navMenu.style.display !== 'none') {
      if (!navMenu.contains(e.target) && !btnToggleNav.contains(e.target)) {
        closeNavMenu();
      }
    }
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      closeNavMenu();
      closeChatDrawer();
      closeHistoryDrawer();
    }
  });

  // Bantuan Cepat (FAQ Quick Pills)
  window.kirimPesanQuickSupport = function(teks) {
    const input = document.getElementById('chatInputText');
    if (input) {
      input.value = teks;
      kirimSupportMessage(teks);
    }
  };

  // Muat Pesan Customer Support
  function loadSupportMessages() {
    if (!messagesBody) return;
    if (!isLoggedIn) return;

    messagesBody.innerHTML = '<div style="text-align: center; color: var(--muted); font-size: .85rem; padding-top: 40px;">Memuat percakapan bantuan...</div>';

    fetch("{{ route('api.support.messages') }}")
      .then(r => {
        if (r.status === 401) {
          window.location.reload();
          return null;
        }
        return r.json();
      })
      .then(res => {
        if (!res) return;
        if (res.status === 'success') {
          messagesBody.innerHTML = '';

          // Bubble pesan sambutan resmi Tim Customer Support
          const welcomeBubble = document.createElement('div');
          welcomeBubble.className = 'chat-bubble theirs support-welcome-bubble';
          welcomeBubble.innerHTML = `
            <div style="font-weight: 700; color: #2E8B3D; margin-bottom: 4px; display: flex; align-items: center; gap: 5px;">
              <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
              <span>Tim Layanan Bantuan JajanRia</span>
            </div>
            <div style="font-size: 0.82rem; line-height: 1.45;">
              Halo 👋 Selamat datang di Customer Support JajanRia! Jika Anda memiliki pertanyaan seputar verifikasi bukti transfer, pesanan lapak, atau kendala aplikasi, silakan sampaikan di sini. Tim kami siap membantu Anda.
            </div>
            <span class="chat-time">Online</span>
          `;
          messagesBody.appendChild(welcomeBubble);

          const msgs = res.messages || [];
          msgs.forEach(m => {
            const b = document.createElement('div');
            const isUser = m.pengirim === 'pengunjung';
            b.className = 'chat-bubble ' + (isUser ? 'mine' : 'theirs');

            let bubbleContent = '';
            if (!isUser) {
              bubbleContent += '<div style="font-size: 0.72rem; font-weight: 700; color: #2E8B3D; margin-bottom: 2px;">Admin Support</div>';
            }
            if (m.lampiran_url) {
              bubbleContent += '<div style="white-space:pre-line; margin-bottom: 6px;">' + m.isi_pesan + '</div>'
                + '<div class="bubble-img-proof"><a href="' + m.lampiran_url + '" target="_blank" rel="noopener"><img src="' + m.lampiran_url + '" alt="Lampiran"></a></div>';
            } else {
              bubbleContent += '<div style="white-space:pre-line;">' + m.isi_pesan + '</div>';
            }

            b.innerHTML = bubbleContent + '<span class="chat-time">' + m.waktu + '</span>';
            messagesBody.appendChild(b);
          });

          messagesBody.scrollTop = messagesBody.scrollHeight;
        }
      })
      .catch(() => {
        if (messagesBody) messagesBody.innerHTML = '<div style="text-align:center;color:var(--danger);font-size:.85rem;padding-top:20px;">Gagal memuat pesan bantuan.</div>';
      });
  }

  // Kirim Pesan Customer Support
  function kirimSupportMessage(text) {
    if (!text) return;
    const input = document.getElementById('chatInputText');
    if (input) input.value = '';

    fetch("{{ route('api.support.send') }}", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({
        isi_pesan: text
      })
    })
    .then(r => {
      if (r.status === 401) {
        alert('Silakan masuk dengan akun Google terlebih dahulu.');
        window.location.reload();
        return null;
      }
      return r.json();
    })
    .then(res => {
      if (res && res.status === 'success') {
        loadSupportMessages();
      } else {
        alert(res?.message || 'Gagal mengirim pesan.');
      }
    })
    .catch(() => {
      alert('Gagal mengirim pesan bantuan.');
    });
  }

  if (inputForm) {
    inputForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const text = inputText ? inputText.value.trim() : '';
      if (!text) return;
      kirimSupportMessage(text);
    });
  }

  // Modal Ulasan
  if (btnOpenReview && reviewModal) {
    btnOpenReview.addEventListener('click', function() {
      reviewModal.style.display = 'flex';
    });
  }

  if (btnCancelReview && reviewModal) {
    btnCancelReview.addEventListener('click', function() {
      reviewModal.style.display = 'none';
    });
  }

  // Interaksi Bintang (1 - 5)
  stars.forEach(s => {
    s.addEventListener('click', function() {
      const val = parseInt(this.dataset.rating);
      if (reviewStarValue) reviewStarValue.value = val;
      stars.forEach(st => {
        if (parseInt(st.dataset.rating) <= val) st.classList.add('active');
        else st.classList.remove('active');
      });
    });
  });

  // Submit Ulasan
  if (reviewForm) {
    reviewForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const orderId = reviewOrderId ? reviewOrderId.value : null;
      const rating = reviewStarValue ? reviewStarValue.value : 5;
      const comment = reviewComment ? reviewComment.value.trim() : '';

      fetch("{{ route('api.ulasan.store') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          id_pesanan: orderId,
          rating: rating,
          komentar: comment
        })
      })
      .then(r => {
        if (r.status === 401) {
          alert('Silakan masuk dengan akun Google terlebih dahulu.');
          window.location.reload();
          return null;
        }
        return r.json();
      })
      .then(res => {
        if (!res) return;
        if (res.status === 'success') {
          if (reviewModal) reviewModal.style.display = 'none';
          if (reviewPrompt) reviewPrompt.style.display = 'none';
          if (reviewComment) reviewComment.value = '';
          alert('Terima kasih! Ulasan Anda berhasil dikirim.');
          openHistoryDrawer();
        } else {
          alert(res.message || 'Gagal mengirim ulasan.');
        }
      })
      .catch(() => {
        alert('Terjadi kesalahan saat mengirim ulasan.');
      });
    });
  }

  // Modal Upload Bukti Pembayaran
  const proofModal = document.getElementById('paymentProofModal');
  const btnOpenProof = document.getElementById('btnOpenUploadProofModal');
  const btnCancelProof = document.getElementById('btnCancelProof');
  const proofForm = document.getElementById('paymentProofSubmitForm');
  const proofOrderId = document.getElementById('proofOrderId');
  const proofFileInput = document.getElementById('proofFileInput');
  const proofImagePreview = document.getElementById('proofImagePreview');
  const proofPreviewContainer = document.getElementById('proofImagePreviewContainer');
  const proofNoteText = document.getElementById('proofNoteText');
  const btnSubmitProof = document.getElementById('btnSubmitProof');

  if (btnOpenProof && proofModal) {
    btnOpenProof.addEventListener('click', function() {
      if (!currentOrderId) {
        alert('Belum ada pesanan aktif untuk lapak ini.');
        return;
      }
      if (proofOrderId) proofOrderId.value = currentOrderId;
      if (proofFileInput) proofFileInput.value = '';
      if (proofNoteText) proofNoteText.value = '';
      if (proofPreviewContainer) proofPreviewContainer.style.display = 'none';
      proofModal.style.display = 'flex';
    });
  }

  if (btnCancelProof && proofModal) {
    btnCancelProof.addEventListener('click', function() {
      proofModal.style.display = 'none';
    });
  }

  // Preview Foto Bukti Transfer
  if (proofFileInput) {
    proofFileInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        if (file.size > 3 * 1024 * 1024) {
          alert('Ukuran foto bukti transfer maksimal 3 MB.');
          this.value = '';
          if (proofPreviewContainer) proofPreviewContainer.style.display = 'none';
          return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
          if (proofImagePreview) proofImagePreview.src = e.target.result;
          if (proofPreviewContainer) proofPreviewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        if (proofPreviewContainer) proofPreviewContainer.style.display = 'none';
      }
    });
  }

  // Submit Bukti Pembayaran
  if (proofForm) {
    proofForm.addEventListener('submit', function(e) {
      e.preventDefault();
      if (!proofFileInput || !proofFileInput.files[0]) {
        alert('Silakan pilih file foto bukti pembayaran terlebih dahulu.');
        return;
      }

      const orderId = proofOrderId ? proofOrderId.value : currentOrderId;
      if (!orderId) {
        alert('ID Pesanan tidak valid.');
        return;
      }

      const formData = new FormData();
      formData.append('_token', '{{ csrf_token() }}');
      formData.append('id_pesanan', orderId);
      formData.append('bukti_foto', proofFileInput.files[0]);
      if (proofNoteText && proofNoteText.value.trim() !== '') {
        formData.append('catatan', proofNoteText.value.trim());
      }

      if (btnSubmitProof) {
        btnSubmitProof.disabled = true;
        btnSubmitProof.textContent = 'Mengunggah...';
      }

      fetch("{{ route('api.orders.upload_bukti') }}", {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
        },
        body: formData
      })
      .then(r => {
        if (r.status === 401) {
          alert('Silakan login dengan akun Google.');
          window.location.reload();
          return null;
        }
        return r.json();
      })
      .then(res => {
        if (btnSubmitProof) {
          btnSubmitProof.disabled = false;
          btnSubmitProof.textContent = 'Kirim Bukti';
        }
        if (!res) return;

        if (res.status === 'success') {
          if (proofModal) proofModal.style.display = 'none';
          alert('Bukti pembayaran berhasil diunggah! Sedang menunggu verifikasi admin.');
          loadOrderHistory();
        } else {
          alert(res.message || 'Gagal mengunggah bukti pembayaran.');
        }
      })
      .catch(() => {
        if (btnSubmitProof) {
          btnSubmitProof.disabled = false;
          btnSubmitProof.textContent = 'Kirim Bukti';
        }
        alert('Terjadi kesalahan koneksi saat mengunggah foto bukti.');
      });
    });
  }

  // Muat Daftar Riwayat Pesanan Pengunjung
  function loadOrderHistory() {
    if (!historyBody) return;
    if (!isLoggedIn) return;

    historyBody.innerHTML = '<div style="text-align: center; color: var(--muted); font-size: .85rem; padding-top: 40px;">Memuat riwayat pesanan...</div>';

    fetch("{{ route('api.orders.history') }}")
      .then(r => {
        if (r.status === 401) {
          window.location.reload();
          return null;
        }
        return r.json();
      })
      .then(res => {
        if (!res) return;
        if (res.status === 'success') {
          const orders = res.data || [];
          if (orders.length === 0) {
            historyBody.innerHTML = '<div style="text-align:center; padding: 40px 16px; color: var(--muted);"><svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 10px; color: #94a3b8;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg><strong style="display:block; color: #1e293b; margin-bottom: 4px;">Belum Ada Riwayat Pesanan</strong><span style="font-size: 0.8rem;">Pilih jajanan favorit Anda di katalog dan lakukan checkout untuk membuat pesanan.</span></div>';
            return;
          }

          historyBody.innerHTML = '';
          orders.forEach(o => {
            const card = document.createElement('div');
            card.className = 'history-order-card';

            const storeName = o.umkm ? o.umkm.nama_usaha : 'Lapak UMKM';
            const storeArea = o.umkm ? o.umkm.area : '';
            const orderIdStr = '#ORD-' + String(o.id_pesanan).padStart(4, '0');
            const dateStr = o.created_at || '-';
            const isSelesai = o.status === 'selesai';

            const payLabels = {
              'belum_bayar': 'Belum Bayar',
              'menunggu_verifikasi': 'Menunggu Verifikasi',
              'lunas': 'Lunas',
              'ditolak': 'Ditolak'
            };
            const payClass = o.status_pembayaran || 'belum_bayar';
            const payText = payLabels[payClass] || payClass;

            let itemsHtml = '';
            if (Array.isArray(o.items_detail) && o.items_detail.length > 0) {
              const list = o.items_detail.map(i => `• ${i.nama_produk} x ${i.qty}`).join('<br>');
              itemsHtml = `<div class="history-items-list">${list}</div>`;
            }

            let rejectionNoteHtml = '';
            if (o.status_pembayaran === 'ditolak' && o.catatan_admin) {
              rejectionNoteHtml = `<div style="background:#fef2f2; border:1px solid #fee2e2; border-radius:6px; padding:6px 10px; font-size:0.75rem; color:#b91c1c; margin-bottom:8px;"><strong>Catatan Admin:</strong> ${o.catatan_admin}</div>`;
            }

            let proofThumbHtml = '';
            if (o.bukti_pembayaran) {
              proofThumbHtml = `<div style="display: flex; align-items: center; gap: 8px; font-size: 0.74rem; color: #64748b; margin-bottom: 8px;"><a href="${o.bukti_pembayaran}" target="_blank" rel="noopener" title="Lihat ukuran penuh"><img src="${o.bukti_pembayaran}" alt="Bukti" style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover; border: 1px solid #e2e8f0;"></a><span>Bukti Pembayaran Diunggah (Klik untuk memperbesar)</span></div>`;
            }

            // Tombol aksi untuk upload/perbarui bukti
            let uploadBtnHtml = '';
            if (o.status_pembayaran === 'belum_bayar' || o.status_pembayaran === 'ditolak') {
              const labelBtn = o.status_pembayaran === 'ditolak' ? 'Perbarui Bukti' : 'Upload Bukti Bayar';
              uploadBtnHtml = `<button type="button" class="btn-history-upload" onclick="window.bukaUploadBuktiDariHistory(${o.id_pesanan})">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                <span>${labelBtn}</span>
              </button>`;
            }

            let reviewBtnHtml = '';
            if (isSelesai && o.status_pembayaran === 'lunas' && !o.sudah_ulasan) {
              reviewBtnHtml = `<button type="button" class="btn-history-review" onclick="window.triggerReviewDariHistory(${o.id_pesanan})">⭐ Beri Penilaian</button>`;
            }

            const supportBtnHtml = `<button type="button" class="btn-history-support" onclick="window.bukaSupportDariPesanan(${o.id_pesanan})">
              <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
                <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
              </svg>
              <span>Bantuan</span>
            </button>`;

            card.innerHTML = `
              <div class="history-card-header">
                <div>
                  <div class="history-store-title">${storeName}</div>
                  <div class="history-order-date">${storeArea ? storeArea + ' • ' : ''}${dateStr}</div>
                </div>
                <span style="font-size: 0.75rem; font-weight: 700; color: #64748b;">${orderIdStr}</span>
              </div>
              <div class="history-card-pills">
                <span class="chat-status-pill ${isSelesai ? 'selesai' : 'diproses'}">${isSelesai ? 'Selesai' : 'Diproses'}</span>
                <span class="chat-payment-pill ${payClass}">${payText}</span>
              </div>
              ${itemsHtml}
              ${rejectionNoteHtml}
              ${proofThumbHtml}
              <div class="history-total-row">
                <span style="font-size: 0.76rem; color: #64748b; font-weight: 600;">Total Pesanan:</span>
                <span style="color: #2E8B3D;">Rp ${Number(o.total_harga || 0).toLocaleString('id-ID')}</span>
              </div>
              <div class="history-actions-row">
                ${uploadBtnHtml}
                ${reviewBtnHtml}
                ${supportBtnHtml}
              </div>
            `;
            historyBody.appendChild(card);
          });
        }
      })
      .catch(() => {
        historyBody.innerHTML = '<div style="text-align:center; color: var(--danger); font-size: 0.85rem; padding-top: 20px;">Gagal memuat riwayat pesanan.</div>';
      });
  }

  window.bukaUploadBuktiDariHistory = function(orderId) {
    if (proofOrderId) proofOrderId.value = orderId;
    if (proofFileInput) proofFileInput.value = '';
    if (proofNoteText) proofNoteText.value = '';
    if (proofPreviewContainer) proofPreviewContainer.style.display = 'none';
    if (proofModal) proofModal.style.display = 'flex';
  };

  window.bukaSupportDariPesanan = function(orderId) {
    closeHistoryDrawer();
    openChatDrawer();
    setTimeout(() => {
      const input = document.getElementById('chatInputText');
      if (input) {
        input.value = 'Halo Customer Support, saya butuh bantuan terkait pesanan #ORD-' + String(orderId).padStart(4, '0') + ': ';
        input.focus();
      }
    }, 250);
  };

  window.triggerReviewDariHistory = function(orderId) {
    if (reviewOrderId) reviewOrderId.value = orderId;
    closeHistoryDrawer();
    if (reviewModal) reviewModal.style.display = 'flex';
  };

  // Buka otomatis jika ada query parameter di URL atau pending chat
  const urlParams = new URLSearchParams(window.location.search);
  const paramChat = urlParams.get('chat');
  const pendingPesan = sessionStorage.getItem('pending_chat_pesan');

  if (paramChat) {
    const tokoId = parseInt(paramChat);
    if (tokoId) {
      window.bukaChatToko(tokoId, pendingPesan || '');
      sessionStorage.removeItem('pending_chat_pesan');
    } else {
      openChatDrawer();
    }
  }
})();
</script>

{{-- Firebase Google Authentication Module untuk Pengunjung di Chat Drawer --}}
<script type="module">
  import { initializeApp } from "https://www.gstatic.com/firebasejs/13.0.0/firebase-app.js";
  import { getAuth, signInWithPopup, GoogleAuthProvider } from "https://www.gstatic.com/firebasejs/13.0.0/firebase-auth.js";

  // Konfigurasi Firebase JajanRia
  const firebaseConfig = {
    apiKey: "AIzaSyDq3JxZo3PHGRoFjrF2coympWeQT-VPIOU",
    authDomain: "jajanria-5caca.firebaseapp.com",
    projectId: "jajanria-5caca",
    storageBucket: "jajanria-5caca.firebasestorage.app",
    messagingSenderId: "563141693431",
    appId: "1:563141693431:web:9221d6082187c13b4de8f2"
  };

  const app = initializeApp(firebaseConfig);
  const auth = getAuth(app);
  const provider = new GoogleAuthProvider();

  const btnChatGoogle = document.getElementById('btnGoogleChatAuth');
  const btnChatGoogleText = document.getElementById('chatGoogleBtnText');

  if (btnChatGoogle) {
    btnChatGoogle.addEventListener('click', async function() {
      try {
        btnChatGoogle.disabled = true;
        if (btnChatGoogleText) btnChatGoogleText.textContent = "Menghubungkan Google...";

        const result = await signInWithPopup(auth, provider);
        const user = result.user;

        if (btnChatGoogleText) btnChatGoogleText.textContent = "Menyiapkan akun...";

        const res = await fetch("{{ route('auth.firebase.google') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            nama: user.displayName || 'Pengunjung Google',
            email: user.email,
            firebase_uid: user.uid,
            foto_profil: user.photoURL
          })
        });

        const data = await res.json();
        if (data.status === 'success') {
          // Muat ulang halaman dan langsung buka chat ke toko yang dipilih
          const pendingUmkm = sessionStorage.getItem('pending_chat_umkm');
          if (pendingUmkm) {
            window.location.href = window.location.pathname + '?chat=' + pendingUmkm;
          } else {
            window.location.reload();
          }
        } else {
          alert(data.message || 'Gagal masuk dengan akun Google.');
          btnChatGoogle.disabled = false;
          if (btnChatGoogleText) btnChatGoogleText.textContent = "Masuk Dengan Google";
        }
      } catch (err) {
        console.error("Firebase auth error in chat:", err);
        btnChatGoogle.disabled = false;
        if (btnChatGoogleText) btnChatGoogleText.textContent = "Masuk Dengan Google";
        if (err.code === 'auth/popup-closed-by-user') {
          return;
        }
        alert('Google Sign-In: ' + (err.message || 'Terjadi kesalahan saat masuk dengan Google.'));
      }
    });
  }
</script>
