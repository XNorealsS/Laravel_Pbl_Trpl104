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

{{-- Drawer Chat Popup --}}
<div class="floating-chat-drawer hidden" id="chatDrawer" role="dialog" aria-labelledby="chatTargetName">
  {{-- Header Chat Drawer --}}
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
    <button type="button" class="btn-trigger-review" id="btnOpenReviewModal">⭐ Beri Penilaian</button>
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
  const fab = document.getElementById('floatingChatFab');
  const btnToggle = document.getElementById('btnToggleChat');
  const btnClose = document.getElementById('btnCloseChat');
  const drawer = document.getElementById('chatDrawer');
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

  // Buka / Tutup Drawer
  btnToggle.addEventListener('click', function() {
    drawer.classList.toggle('hidden');
    if (!drawer.classList.contains('hidden')) {
      if (!activeUmkmId) loadStores();
      else loadMessages(activeUmkmId);
    }
  });

  btnClose.addEventListener('click', function() {
    drawer.classList.add('hidden');
  });

  // Global helper untuk membuka chat dari tombol "Chat Penjual" di halaman toko
  window.bukaChatToko = function(idUmkm) {
    activeUmkmId = idUmkm;
    drawer.classList.remove('hidden');
    loadStores(idUmkm);
    loadMessages(idUmkm);
  };

  // Muat daftar toko
  function loadStores(selectId = null) {
    fetch("{{ route('api.chat.conversations') }}")
      .then(r => r.json())
      .then(res => {
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

  storeSelect.addEventListener('change', function() {
    activeUmkmId = this.value;
    loadMessages(activeUmkmId);
  });

  // Muat pesan dari server
  function loadMessages(idUmkm) {
    messagesBody.innerHTML = '<div style="text-align: center; color: var(--muted); font-size: .85rem; padding-top: 40px;">Memuat percakapan...</div>';
    fetch("/api/chat/" + idUmkm)
      .then(r => r.json())
      .then(res => {
        if (res.status === 'success') {
          targetName.textContent = res.umkm.nama_usaha;
          targetArea.textContent = res.umkm.area;

          // Status pesanan
          if (res.pesanan) {
            currentOrderId = res.pesanan.id_pesanan;
            statusPill.textContent = res.pesanan.status === 'selesai' ? 'Selesai' : 'Diproses';
            statusPill.className = 'chat-status-pill ' + res.pesanan.status;

            // Trigger ulasan bila status selesai dan belum dinilai
            if (res.pesanan.status === 'selesai' && !res.sudah_ulasan) {
              reviewPrompt.style.display = 'flex';
              reviewOrderId.value = currentOrderId;
            } else {
              reviewPrompt.style.display = 'none';
            }
          } else {
            currentOrderId = null;
            statusPill.textContent = 'Belum Ada';
            statusPill.className = 'chat-status-pill';
            reviewPrompt.style.display = 'none';
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
        messagesBody.innerHTML = '<div style="text-align:center;color:var(--danger);font-size:.85rem;padding-top:20px;">Gagal memuat pesan.</div>';
      });
  }

  // Kirim Pesan
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
    .then(r => r.json())
    .then(res => {
      if (res.status === 'success') {
        loadMessages(activeUmkmId);
      }
    })
    .catch(() => {
      alert('Gagal mengirim pesan.');
    });
  });

  // Modal Ulasan
  btnOpenReview.addEventListener('click', function() {
    reviewModal.style.display = 'flex';
  });

  btnCancelReview.addEventListener('click', function() {
    reviewModal.style.display = 'none';
  });

  // Interaksi Bintang (1 - 5)
  stars.forEach(s => {
    s.addEventListener('click', function() {
      const val = parseInt(this.dataset.rating);
      reviewStarValue.value = val;
      stars.forEach(st => {
        if (parseInt(st.dataset.rating) <= val) st.classList.add('active');
        else st.classList.remove('active');
      });
    });
  });

  // Submit Ulasan
  reviewForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const orderId = reviewOrderId.value;
    const rating = reviewStarValue.value;
    const comment = reviewComment.value.trim();

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
    .then(r => r.json())
    .then(res => {
      if (res.status === 'success') {
        reviewModal.style.display = 'none';
        reviewPrompt.style.display = 'none';
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

  // Periksa apakah ada parameter chat di URL (misal: ?chat=1)
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('chat')) {
    const tokoId = parseInt(urlParams.get('chat'));
    if (tokoId) window.bukaChatToko(tokoId);
    else btnToggle.click();
  }
})();
</script>
