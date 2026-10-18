{{-- =========================================================================
     Floating Chat Popup (UC-03, UC-04, F006, F008, F009)
     Muncul di sebelah kanan bawah layar untuk Pengunjung (Customer)
     ========================================================================= --}}

<div class="floating-chat-fab" id="floatingChatFab">
  <button type="button" class="fab-chat-btn" id="btnToggleChat" aria-label="Buka Chat Penjual">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
      <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
    </svg>
    <span>Chat Penjual</span>
    <span class="fab-badge" id="chatFabBadge" style="display:none;"></span>
  </button>
</div>

{{-- Backdrop Gelap Saat Chat Terbuka Agar Pengunjung Fokus --}}
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
    {{-- Header Chat Drawer untuk Pengguna yang Sudah Login --}}
    <div class="chat-drawer-head">
      <div class="chat-drawer-head-info">
        <strong id="chatTargetName">Pilih Lapak</strong>
        <span id="chatTargetArea">Sekitar Kampus</span>
      </div>
      <div style="display: flex; align-items: center; gap: 6px;">
        <select id="chatStoreSelect" class="chat-store-select" aria-label="Ganti lapak chat">
          <option value="">Memuat...</option>
        </select>
        <button type="button" class="chat-close-btn" id="btnCloseChat" aria-label="Tutup chat">&times;</button>
      </div>
    </div>

    {{-- Status Pesanan (F007: Seller mengubah status -> Diproses / Selesai) --}}
    <div class="chat-status-bar" id="chatStatusBar">
      <span style="font-weight: 600;">Status Pesanan:</span>
      <span class="chat-status-pill diproses" id="chatStatusPill">Belum Ada</span>
    </div>

    {{-- Pemicu Ulasan Otomatis (F008: Muncul setelah status ditandai "Selesai") --}}
    <div class="chat-review-prompt" id="chatReviewPrompt" style="display:none;">
      <p>Pesanan telah selesai! Yuk beri ulasan untuk lapak ini:</p>
      <button type="button" class="btn-trigger-review" id="btnOpenReviewModal" style="display: inline-flex; align-items: center; gap: 5px;">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        <span>Beri Penilaian</span>
      </button>
    </div>

    {{-- Riwayat Pesan Chat --}}
    <div class="chat-messages-body" id="chatMessagesBody">
      <div style="text-align: center; color: var(--muted); font-size: .85rem; padding-top: 40px;">
        Memuat percakapan...
      </div>
    </div>

    {{-- Formulir Kirim Pesan --}}
    <form class="chat-input-bar" id="chatInputForm">
      @csrf
      <input type="text" id="chatInputText" placeholder="Ketik pesan untuk penjual..." aria-label="Ketik pesan" required>
      <button type="submit" class="chat-send-btn">Kirim</button>
    </form>
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

<script>
(function() {
  const isLoggedIn = {{ session('user') ? 'true' : 'false' }};
  const fab = document.getElementById('floatingChatFab');
  const btnToggle = document.getElementById('btnToggleChat');
  const btnClose = document.getElementById('btnCloseChat');
  const drawer = document.getElementById('chatDrawer');
  const backdrop = document.getElementById('chatBackdrop');
  const storeSelect = document.getElementById('chatStoreSelect');
  const targetName = document.getElementById('chatTargetName');
  const targetArea = document.getElementById('chatTargetArea');
  const statusPill = document.getElementById('chatStatusPill');
  const reviewPrompt = document.getElementById('chatReviewPrompt');
  const messagesBody = document.getElementById('chatMessagesBody');
  const inputForm = document.getElementById('chatInputForm');
  const inputText = document.getElementById('chatInputText');

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

  // Fungsi Buka / Tutup Drawer dengan Backdrop Gelap
  function openChatDrawer() {
    if (drawer) drawer.classList.remove('hidden');
    if (backdrop) backdrop.classList.add('active');
  }

  function closeChatDrawer() {
    if (drawer) drawer.classList.add('hidden');
    if (backdrop) backdrop.classList.remove('active');
  }

  // Buka / Tutup via FAB
  if (btnToggle) {
    btnToggle.addEventListener('click', function() {
      if (!drawer) return;
      if (drawer.classList.contains('hidden')) {
        openChatDrawer();
        if (isLoggedIn) {
          if (!activeUmkmId) loadStores();
          else loadMessages(activeUmkmId);
        }
      } else {
        closeChatDrawer();
      }
    });
  }

  // Tombol Tutup Silang
  if (btnClose) {
    btnClose.addEventListener('click', function() {
      closeChatDrawer();
    });
  }

  // Klik Area Backdrop Gelap untuk Menutup
  if (backdrop) {
    backdrop.addEventListener('click', function() {
      closeChatDrawer();
    });
  }

  // Tekan Tombol Escape pada Keyboard untuk Menutup
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && drawer && !drawer.classList.contains('hidden')) {
      closeChatDrawer();
    }
  });

  // Global helper untuk membuka chat dari tombol "Chat Penjual" di halaman toko
  window.bukaChatToko = function(idUmkm) {
    activeUmkmId = idUmkm;
    openChatDrawer();

    if (!isLoggedIn) {
      sessionStorage.setItem('pending_chat_umkm', idUmkm);
      return;
    }

    sessionStorage.removeItem('pending_chat_umkm');
    loadStores(idUmkm);
    loadMessages(idUmkm);
  };

  // Muat daftar toko
  function loadStores(selectId = null) {
    if (!storeSelect) return;
    fetch("{{ route('api.chat.conversations') }}")
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
          storeSelect.innerHTML = '';
          res.data.forEach(u => {
            const opt = document.createElement('option');
            opt.value = u.id_umkm;
            opt.textContent = u.nama_usaha;
            storeSelect.appendChild(opt);
          });
          if (selectId) {
            storeSelect.value = selectId;
            activeUmkmId = selectId;
          } else if (res.data.length > 0 && !activeUmkmId) {
            activeUmkmId = res.data[0].id_umkm;
            storeSelect.value = activeUmkmId;
            loadMessages(activeUmkmId);
          }
        }
      })
      .catch(() => {});
  }

  if (storeSelect) {
    storeSelect.addEventListener('change', function() {
      activeUmkmId = this.value;
      loadMessages(activeUmkmId);
    });
  }

  // Muat pesan dari server
  function loadMessages(idUmkm) {
    if (!messagesBody) return;
    messagesBody.innerHTML = '<div style="text-align: center; color: var(--muted); font-size: .85rem; padding-top: 40px;">Memuat percakapan...</div>';
    fetch("/api/chat/" + idUmkm)
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
          if (targetName) targetName.textContent = res.umkm.nama_usaha;
          if (targetArea) targetArea.textContent = res.umkm.area;

          // Status pesanan
          if (res.pesanan) {
            currentOrderId = res.pesanan.id_pesanan;
            if (statusPill) {
              statusPill.textContent = res.pesanan.status === 'selesai' ? 'Selesai' : 'Diproses';
              statusPill.className = 'chat-status-pill ' + res.pesanan.status;
            }

            // Trigger ulasan bila status selesai dan belum dinilai
            if (res.pesanan.status === 'selesai' && !res.sudah_ulasan) {
              if (reviewPrompt) reviewPrompt.style.display = 'flex';
              if (reviewOrderId) reviewOrderId.value = currentOrderId;
            } else {
              if (reviewPrompt) reviewPrompt.style.display = 'none';
            }
          } else {
            currentOrderId = null;
            if (statusPill) {
              statusPill.textContent = 'Belum Ada';
              statusPill.className = 'chat-status-pill';
            }
            if (reviewPrompt) reviewPrompt.style.display = 'none';
          }

          // Render percakapan
          messagesBody.innerHTML = '';
          if (res.messages.length === 0) {
            messagesBody.innerHTML = '<div style="text-align:center;color:var(--muted);font-size:.84rem;margin:auto;">Belum ada pesan. Sampaikan pertanyaan atau pesanan Anda kepada penjual.</div>';
          } else {
            res.messages.forEach(m => {
              const b = document.createElement('div');
              b.className = 'chat-bubble ' + (m.pengirim === 'pengunjung' ? 'mine' : 'theirs');
              b.innerHTML = m.isi_pesan + '<span class="chat-time">' + m.waktu + '</span>';
              messagesBody.appendChild(b);
            });
            messagesBody.scrollTop = messagesBody.scrollHeight;
          }
        }
      })
      .catch(() => {
        if (messagesBody) messagesBody.innerHTML = '<div style="text-align:center;color:var(--danger);font-size:.85rem;padding-top:20px;">Gagal memuat pesan.</div>';
      });
  }

  // Kirim Pesan
  if (inputForm) {
    inputForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const text = inputText.value.trim();
      if (!text || !activeUmkmId) return;

      inputText.value = '';
      fetch("{{ route('api.chat.send') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
          id_umkm: activeUmkmId,
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
          loadMessages(activeUmkmId);
        }
      })
      .catch(() => {
        alert('Gagal mengirim pesan.');
      });
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
          alert('Terima kasih! Ulasan Anda berhasil dikirim.');
          loadMessages(activeUmkmId);
        } else {
          alert(res.message || 'Gagal mengirim ulasan.');
        }
      })
      .catch(() => {
        alert('Terjadi kesalahan saat mengirim ulasan.');
      });
    });
  }

  // Bersihkan sisa pending_chat_umkm agar chat TIDAK otomatis terbuka saat muat halaman/refresh
  sessionStorage.removeItem('pending_chat_umkm');

  // Hanya buka otomatis jika ada query parameter eksplisit di URL, misal: ?chat=1
  const urlParams = new URLSearchParams(window.location.search);
  const paramChat = urlParams.get('chat');
  if (paramChat) {
    const tokoId = parseInt(paramChat);
    if (tokoId) window.bukaChatToko(tokoId);
    else openChatDrawer();
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
          // Muat ulang halaman dan langsung buka chat
          window.location.reload();
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
