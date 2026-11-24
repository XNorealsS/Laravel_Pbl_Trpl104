@extends('layouts.katalog')

@section('title', $umkm->nama_usaha . ' - Menu & Ulasan | JajanRia')
@section('description', 'Menu lengkap dan ulasan ' . $umkm->nama_usaha . ' di ' . $umkm->area . '.')

@section('content')
<main class="store-detail-wrap">

  {{-- Navigasi Kembali ke Katalog --}}
  <div class="store-nav-header">
    <a href="{{ route('landing') }}" class="btn-store-back" title="Kembali ke Beranda Katalog">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
      <span>Kembali ke Katalog</span>
    </a>
  </div>

  {{-- ===== Profil Lapak (Modern Hero Card ala GoFood) ===== --}}
  <section class="store-hero-card">
    {{-- Banner Cover: Proporsional, tidak oversize --}}
    <div class="store-banner">
      @if($umkm->foto_url)
        <img src="{{ $umkm->foto_url }}" alt="{{ $umkm->nama_usaha }}" class="store-banner-img" onerror="this.style.display='none'">
      @endif
      <div class="store-banner-overlay"></div>
    </div>

    {{-- Store Profile Body --}}
    <div class="store-profile-wrap">
      {{-- Identity Row: Avatar + Title + Badges --}}
      <div class="store-identity-row">
        <div class="store-avatar">
          <div class="store-avatar-initial">{{ strtoupper(mb_substr($umkm->nama_usaha, 0, 1)) }}</div>
          @if($umkm->foto_url)
            <img src="{{ $umkm->foto_url }}" alt="{{ $umkm->nama_usaha }}" class="store-avatar-img" onerror="this.remove()">
          @endif
        </div>
        <div class="store-title-meta">
          <div class="store-badge-row">
            <span class="store-badge-partner">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
              Mitra UMKM
            </span>
            <span class="store-badge-area">{{ $umkm->area }}</span>
          </div>
          <h1 class="store-name">{{ $umkm->nama_usaha }}</h1>
          @if($umkm->deskripsi)
            <p class="store-desc">{{ $umkm->deskripsi }}</p>
          @endif
        </div>
      </div>

      {{-- Highlights Bar (3 Kolom Ringkas Ala GoFood) --}}
      <div class="store-stats-bar">
        <a href="#ulasan" class="store-stat-item" title="Lihat ulasan pembeli">
          <div class="stat-top">
            <svg class="star-icon" width="15" height="15" viewBox="0 0 24 24" fill="#f59e0b" stroke="#f59e0b"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            <strong class="stat-value">{{ $ulasan->count() > 0 ? number_format($rataRating, 1) : '-' }}</strong>
          </div>
          <div class="stat-sub link-green">{{ $ulasan->count() > 0 ? $ulasan->count() . ' Ulasan' : 'Belum ada ulasan' }}</div>
        </a>

        <div class="store-stat-divider"></div>

        <div class="store-stat-item" title="{{ $umkm->lokasi }}">
          <div class="stat-top">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2E8B3D" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-6.2 7-11a7 7 0 1 0-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
            <span class="stat-value">{{ $umkm->area }}</span>
          </div>
          <div class="stat-sub">{{ Str::limit($umkm->lokasi, 22) }}</div>
        </div>

        <div class="store-stat-divider"></div>

        <div class="store-stat-item">
          <div class="stat-top">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#2E8B3D" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            <span class="stat-value">
              @if($rentangHarga)
                Rp {{ number_format($rentangHarga[0] / 1000, 0) }}rb{{ $rentangHarga[0] != $rentangHarga[1] ? ' - ' . number_format($rentangHarga[1] / 1000, 0) . 'rb' : '' }}
              @else
                -
              @endif
            </span>
          </div>
          <div class="stat-sub">Kisaran menu</div>
        </div>
      </div>

      {{-- Action & Quick Info Bar --}}
      <div class="store-actions-row">
        <button type="button" class="btn-chat-primary" onclick="window.bukaCustomerSupport()">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
          <span>Customer Support</span>
        </button>
        @if($umkm->kontak)
          <a href="tel:{{ preg_replace('/[^0-9+]/', '', $umkm->kontak) }}" class="btn-contact-chip" title="Hubungi Penjual: {{ $umkm->kontak }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            <span>Hubungi: {{ $umkm->kontak }}</span>
          </a>
        @endif
      </div>

      {{-- Note Info Tip --}}
      <div class="store-note-tip">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#2E8B3D" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        <span>Pilih jajanan favorit, lalu selesaikan pembayaran dan unggah bukti transfer secara langsung. Pantau status pesanan kapan saja di menu History Pesanan.</span>
      </div>
    </div>
  </section>

  {{-- ===== Navigasi Kategori Menu (Sticky Bar ala GoFood) ===== --}}
  @if($menuPerKategori->isNotEmpty())
    <nav class="store-cats-bar" aria-label="Kategori menu" id="storeCatsNav">
      <div class="store-cats-scroll">
        @foreach($menuPerKategori as $namaKategori => $items)
          <a href="#kat-{{ $loop->index }}" class="cat-chip-btn {{ $loop->first ? 'active' : '' }}" data-target="kat-{{ $loop->index }}">
            <span>{{ $namaKategori }}</span>
            <span class="cat-chip-count">{{ $items->count() }}</span>
          </a>
        @endforeach
        <a href="#ulasan" class="cat-chip-btn" data-target="ulasan">
          <span>Ulasan</span>
          <span class="cat-chip-count">{{ $ulasan->count() }}</span>
        </a>
      </div>
    </nav>
  @endif

  {{-- ===== Daftar Menu Per Kategori ===== --}}
  @forelse($menuPerKategori as $namaKategori => $items)
    <section class="store-menu-group" id="kat-{{ $loop->index }}">
      <div class="group-header">
        <h2 class="group-title">{{ $namaKategori }}</h2>
        <span class="group-count">{{ $items->count() }} menu</span>
      </div>

      <div class="store-menu-grid">
        @foreach($items as $p)
          <article class="store-item-card {{ $p->tersedia ? '' : 'is-habis' }}">
            <div class="store-item-content">
              <div class="store-item-top">
                <h3 class="store-item-name">{{ $p->nama_produk }}</h3>
                @unless($p->tersedia)
                  <span class="store-item-badge-habis">Tidak tersedia</span>
                @endunless
              </div>
              @if($p->deskripsi)
                <p class="store-item-desc">{{ $p->deskripsi }}</p>
              @endif
              <div class="store-item-bottom">
                <div class="store-item-price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
              </div>
            </div>

            <div class="store-item-visual">
              <div class="store-item-photo">
                <div class="item-placeholder">
                  <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="placeholder-icon"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8zM6 1v3M10 1v3M14 1v3"/></svg>
                  <span class="placeholder-letter">{{ strtoupper(mb_substr($p->nama_produk, 0, 1)) }}</span>
                </div>
                @if($p->foto_url)
                  <img src="{{ $p->foto_url }}" alt="{{ $p->nama_produk }}" loading="lazy" class="item-img" onerror="this.remove()">
                @endif
              </div>

              @if($p->tersedia)
                <div class="cart-item-ctrl" data-id="{{ $p->id_produk }}" data-nama="{{ $p->nama_produk }}" data-harga="{{ $p->harga }}" data-umkm="{{ $umkm->id_umkm }}">
                  <button type="button" class="btn-cart-add" id="btnAdd-{{ $p->id_produk }}" onclick="window.tambahKeKeranjang({{ $p->id_produk }}, '{{ addslashes($p->nama_produk) }}', {{ $p->harga }}, {{ $umkm->id_umkm }})">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Tambah</span>
                  </button>
                  <div class="qty-stepper" id="stepper-{{ $p->id_produk }}" style="display: none;">
                    <button type="button" class="btn-step-minus" onclick="window.ubahQtyItem({{ $p->id_produk }}, -1, {{ $umkm->id_umkm }})" aria-label="Kurangi porsi">−</button>
                    <span class="qty-number" id="qtyVal-{{ $p->id_produk }}">1</span>
                    <button type="button" class="btn-step-plus" onclick="window.ubahQtyItem({{ $p->id_produk }}, 1, {{ $umkm->id_umkm }})" aria-label="Tambah porsi">+</button>
                  </div>
                </div>
              @endif
            </div>
          </article>
        @endforeach
      </div>
    </section>
  @empty
    <div class="empty" style="margin-top: 16px; background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 24px; text-align: center; color: #6b7280;">
      Lapak ini belum menambahkan menu.
    </div>
  @endforelse

  {{-- ===== Ulasan Pembeli ===== --}}
  <section class="store-reviews-section" id="ulasan">
    <h2 class="store-reviews-title">Ulasan Pembeli ({{ $ulasan->count() }})</h2>

    @forelse($ulasan as $r)
      <article class="store-review-card">
        <div class="store-review-head">
          <div class="reviewer-info">
            <div class="reviewer-avatar">
              {{ strtoupper(substr($r->pengunjung->nama ?? 'P', 0, 1)) }}
            </div>
            <div>
              <div class="reviewer-name">{{ $r->pengunjung->nama ?? 'Pengunjung' }}</div>
              <div class="reviewer-date">{{ $r->created_at->translatedFormat('d M Y') }}</div>
            </div>
          </div>
          <div class="review-stars">
            {{ str_repeat('★', $r->rating) }}<span style="color: #d1d5db;">{{ str_repeat('★', 5 - $r->rating) }}</span>
          </div>
        </div>

        @if($r->komentar)
          <p class="store-review-comment">{{ $r->komentar }}</p>
        @endif

        @if($r->balasan_seller)
          <div class="store-review-reply">
            <div class="reply-badge">Balasan penjual:</div>
            <div>{{ $r->balasan_seller }}</div>
          </div>
        @endif
      </article>
    @empty
      <div class="empty" style="margin-top: 10px; background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 20px; text-align: center; color: #6b7280; font-size: 0.88rem;">
        Belum ada ulasan untuk lapak ini.
      </div>
    @endforelse
  </section>

  {{-- Floating Bottom Cart Bar --}}
  <div class="floating-store-cart" id="floatingStoreCart" style="display: none;">
    <div class="cart-bar-content">
      <div class="cart-bar-left">
        <div class="cart-bar-badge" id="cartTotalQty">0 Menu Terpilih</div>
        <div class="cart-bar-total" id="cartTotalPrice">Rp 0</div>
      </div>
      <div class="cart-bar-right">
        <button type="button" class="btn-cart-checkout" id="btnCartCheckout" onclick="window.bukaModalCheckout({{ $umkm->id_umkm }})">
          <span>Checkout & Pembayaran</span>
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </button>
      </div>
    </div>
  </div>

  {{-- Modal Dedicated: Checkout & Upload Bukti Pembayaran (Mandiri tanpa Chat) --}}
  <div class="checkout-modal-backdrop" id="checkoutModalBackdrop" style="display: none;" onclick="window.tutupModalCheckout(event)">
    <div class="checkout-modal-card" onclick="event.stopPropagation()">
      <div class="checkout-modal-header">
        <div class="modal-header-info">
          <h2 class="modal-title">Checkout & Pembayaran</h2>
          <span class="modal-subtitle">{{ $umkm->nama_usaha }} • {{ $umkm->area }}</span>
        </div>
        <button type="button" class="btn-close-modal" onclick="window.tutupModalCheckout()" aria-label="Tutup modal">&times;</button>
      </div>

      <div class="checkout-modal-body">
        {{-- 1. Ringkasan Pesanan --}}
        <div class="checkout-section-box">
          <div class="checkout-section-title">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            <span>Ringkasan Menu Dipesan</span>
          </div>
          <div class="checkout-items-summary" id="checkoutItemsList">
            <!-- Diisi dinamis oleh JavaScript -->
          </div>
          <div class="checkout-total-row">
            <span>Total Pembayaran</span>
            <strong class="checkout-total-val" id="checkoutModalTotal">Rp 0</strong>
          </div>
        </div>

        {{-- 2. Info Rekening / Pembayaran Toko --}}
        <div class="checkout-payment-info-box">
          <div class="pay-info-header">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2E8B3D" stroke-width="2.2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
            <strong>Informasi Pembayaran Lapak</strong>
          </div>
          <div class="pay-info-content">
            <div class="pay-detail-row">
              <span class="pay-label">Nama Lapak:</span>
              <span class="pay-value">{{ $umkm->nama_usaha }}</span>
            </div>
            @if($umkm->kontak)
              <div class="pay-detail-row">
                <span class="pay-label">Kontak / No. Bayar:</span>
                <span class="pay-value font-mono">{{ $umkm->kontak }}</span>
              </div>
            @endif
            <div class="pay-instruction-note">
              Silakan selesaikan pembayaran sebesar total di atas, lalu lampirkan foto struk/screenshot bukti transfer di bawah ini.
            </div>
          </div>
        </div>

        {{-- 3. Upload Bukti Pembayaran --}}
        <div class="checkout-upload-box">
          <div class="checkout-section-title">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
            <span>Upload Bukti Pembayaran</span>
          </div>

          <div class="dropzone-upload-area" id="checkoutDropzone" onclick="document.getElementById('checkoutBuktiFoto').click()">
            <input type="file" id="checkoutBuktiFoto" accept="image/jpeg,image/png,image/jpg" style="display: none;" onchange="window.previewBuktiCheckout(event)">
            <div id="dropzonePlaceholder">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2E8B3D" stroke-width="1.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              <div class="dropzone-text">
                <strong>Klik untuk memilih foto bukti transfer</strong> atau seret ke sini
              </div>
              <div class="dropzone-hint">Format JPG, PNG (Maksimal 3 MB)</div>
            </div>
            <div id="dropzonePreviewWrap" style="display: none;">
              <img id="checkoutPreviewImg" src="" alt="Pratinjau Bukti Bayar" class="checkout-preview-thumb">
              <button type="button" class="btn-remove-preview" onclick="window.hapusPreviewBukti(event)" title="Hapus foto">&times;</button>
            </div>
          </div>
          <div class="dropzone-optional-note">
            *Bukti transfer juga dapat diunggah nanti melalui menu <strong>History Pesanan</strong>.
          </div>
        </div>

        {{-- 4. Catatan Pesanan (Opsional) --}}
        <div class="checkout-notes-box">
          <label for="checkoutCatatan" class="checkout-notes-label">
            Catatan Pesanan (opsional):
          </label>
          <textarea id="checkoutCatatan" class="checkout-notes-input" rows="2" placeholder="Contoh: pedas sedang, kuah dipisah, no meja 4..."></textarea>
        </div>
      </div>

      <div class="checkout-modal-footer">
        <button type="button" class="btn-checkout-cancel" onclick="window.tutupModalCheckout()">Batal</button>
        <button type="button" class="btn-checkout-submit" id="btnSubmitDedicatedCheckout" onclick="window.kirimDedicatedCheckout({{ $umkm->id_umkm }})">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="20 6 9 17 4 12"/></svg>
          <span>Konfirmasi & Kirim Pesanan</span>
        </button>
      </div>
    </div>
  </div>

  {{-- Modal Konfirmasi Sukses Pesanan --}}
  <div class="checkout-modal-backdrop" id="checkoutSuccessBackdrop" style="display: none;">
    <div class="checkout-modal-card success-card" onclick="event.stopPropagation()">
      <div class="success-icon-wrap">
        <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#2E8B3D" stroke-width="2.6"><circle cx="12" cy="12" r="10"/><path d="M8 12l2.5 2.5L16 9"/></svg>
      </div>
      <h2 class="success-title">Pesanan Berhasil Dibuat!</h2>
      <p class="success-desc">
        Pesanan Anda telah dicatat ke sistem. Bukti pembayaran akan diverifikasi oleh Admin. Anda dapat memantau status pesanan kapan saja.
      </p>
      <div class="success-actions-row">
        <button type="button" class="btn-success-history" onclick="window.tutupSuccessBukaHistory()">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <span>Buka History Pesanan</span>
        </button>
        <button type="button" class="btn-success-close" onclick="window.tutupModalSuccess()">
          Selesai
        </button>
      </div>
    </div>
  </div>

</main>

<script>
  (function() {
    const umkmId = {{ $umkm->id_umkm }};
    const cartKey = 'jajanria_cart_' + umkmId;

    function getCart() {
      try {
        const data = localStorage.getItem(cartKey);
        return data ? JSON.parse(data) : { items: {} };
      } catch (e) {
        return { items: {} };
      }
    }

    function saveCart(cart) {
      try {
        localStorage.setItem(cartKey, JSON.stringify(cart));
      } catch (e) {}
    }

    function formatRupiah(num) {
      return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    function updateCartUI() {
      const cart = getCart();
      const items = cart.items || {};
      let totalQty = 0;
      let totalPrice = 0;

      // Update semua tombol / stepper di halaman
      document.querySelectorAll('.cart-item-ctrl[data-umkm="' + umkmId + '"]').forEach(ctrl => {
        const prodId = ctrl.getAttribute('data-id');
        const btnAdd = document.getElementById('btnAdd-' + prodId);
        const stepper = document.getElementById('stepper-' + prodId);
        const qtyVal = document.getElementById('qtyVal-' + prodId);

        const current = items[prodId];
        if (current && current.qty > 0) {
          if (btnAdd) btnAdd.style.display = 'none';
          if (stepper) stepper.style.display = 'inline-flex';
          if (qtyVal) qtyVal.textContent = current.qty;
        } else {
          if (btnAdd) btnAdd.style.display = 'inline-flex';
          if (stepper) stepper.style.display = 'none';
          if (qtyVal) qtyVal.textContent = '0';
        }
      });

      // Hitung total akumulasi
      Object.values(items).forEach(item => {
        totalQty += item.qty;
        totalPrice += (item.qty * item.harga);
      });

      const floatBar = document.getElementById('floatingStoreCart');
      const badge = document.getElementById('cartTotalQty');
      const totalDisplay = document.getElementById('cartTotalPrice');

      if (floatBar) {
        if (totalQty > 0) {
          floatBar.style.display = 'block';
          if (badge) badge.textContent = totalQty + ' Menu Terpilih';
          if (totalDisplay) totalDisplay.textContent = formatRupiah(totalPrice);
        } else {
          floatBar.style.display = 'none';
        }
      }
    }

    window.tambahKeKeranjang = function(id, nama, harga, storeId) {
      if (storeId !== umkmId) return;
      const cart = getCart();
      if (!cart.items) cart.items = {};

      if (!cart.items[id]) {
        cart.items[id] = { id_produk: id, nama_produk: nama, harga: harga, qty: 1 };
      } else {
        cart.items[id].qty += 1;
      }
      saveCart(cart);
      updateCartUI();
    };

    window.ubahQtyItem = function(id, delta, storeId) {
      if (storeId !== umkmId) return;
      const cart = getCart();
      if (!cart.items || !cart.items[id]) return;

      cart.items[id].qty += delta;
      if (cart.items[id].qty <= 0) {
        delete cart.items[id];
      }
      saveCart(cart);
      updateCartUI();
    };

    window.bukaModalCheckout = function(storeId) {
      if (storeId !== umkmId) return;
      const cart = getCart();
      const itemsList = Object.values(cart.items || {});
      if (itemsList.length === 0) return;

      const isLoggedIn = {{ session('user') ? 'true' : 'false' }};
      if (!isLoggedIn) {
        if (typeof window.bukaCustomerSupport === 'function') {
          window.bukaCustomerSupport();
        } else if (typeof window.bukaChatToko === 'function') {
          window.bukaChatToko(storeId);
        }
        return;
      }

      // Render item ringkasan
      const itemsContainer = document.getElementById('checkoutItemsList');
      const totalDisplay = document.getElementById('checkoutModalTotal');
      let totalHarga = 0;

      if (itemsContainer) {
        itemsContainer.innerHTML = '';
        itemsList.forEach(item => {
          const subtotal = item.qty * item.harga;
          totalHarga += subtotal;

          const row = document.createElement('div');
          row.className = 'checkout-item-line';
          const left = document.createElement('div');
          left.className = 'item-line-left';
          const nameSpan = document.createElement('span');
          nameSpan.className = 'item-line-name';
          nameSpan.textContent = item.nama_produk;
          const qtySpan = document.createElement('span');
          qtySpan.className = 'item-line-qty';
          qtySpan.textContent = 'x ' + item.qty;
          left.appendChild(nameSpan);
          left.appendChild(qtySpan);
          const priceSpan = document.createElement('span');
          priceSpan.className = 'item-line-price';
          priceSpan.textContent = formatRupiah(subtotal);
          row.appendChild(left);
          row.appendChild(priceSpan);
          itemsContainer.appendChild(row);
        });
      }

      if (totalDisplay) {
        totalDisplay.textContent = formatRupiah(totalHarga);
      }

      // Reset file input & preview
      window.hapusPreviewBukti();
      const catatanEl = document.getElementById('checkoutCatatan');
      if (catatanEl) catatanEl.value = '';

      const modal = document.getElementById('checkoutModalBackdrop');
      if (modal) modal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    };

    window.tutupModalCheckout = function(e) {
      if (e && e.target && e.target.id !== 'checkoutModalBackdrop' && !e.target.classList.contains('btn-close-modal') && !e.target.classList.contains('btn-checkout-cancel')) {
        return;
      }
      const modal = document.getElementById('checkoutModalBackdrop');
      if (modal) modal.style.display = 'none';
      document.body.style.overflow = '';
    };

    window.previewBuktiCheckout = function(e) {
      const file = e.target.files && e.target.files[0];
      if (!file) return;

      if (file.size > 3 * 1024 * 1024) {
        alert('Ukuran foto bukti transfer maksimal 3 MB.');
        e.target.value = '';
        return;
      }

      const reader = new FileReader();
      reader.onload = function(evt) {
        const previewImg = document.getElementById('checkoutPreviewImg');
        const previewWrap = document.getElementById('dropzonePreviewWrap');
        const placeholder = document.getElementById('dropzonePlaceholder');
        if (previewImg) previewImg.src = evt.target.result;
        if (previewWrap) previewWrap.style.display = 'flex';
        if (placeholder) placeholder.style.display = 'none';
      };
      reader.readAsDataURL(file);
    };

    window.hapusPreviewBukti = function(e) {
      if (e) e.stopPropagation();
      const fileInput = document.getElementById('checkoutBuktiFoto');
      const previewImg = document.getElementById('checkoutPreviewImg');
      const previewWrap = document.getElementById('dropzonePreviewWrap');
      const placeholder = document.getElementById('dropzonePlaceholder');

      if (fileInput) fileInput.value = '';
      if (previewImg) previewImg.src = '';
      if (previewWrap) previewWrap.style.display = 'none';
      if (placeholder) placeholder.style.display = 'flex';
    };

    window.kirimDedicatedCheckout = function(storeId) {
      const cart = getCart();
      const itemsList = Object.values(cart.items || {});
      if (itemsList.length === 0) return;

      const submitBtn = document.getElementById('btnSubmitDedicatedCheckout');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span>Mengirim Pesanan...</span>';
      }

      const formData = new FormData();
      formData.append('id_umkm', storeId);
      formData.append('items', JSON.stringify(itemsList));

      const catatan = document.getElementById('checkoutCatatan');
      if (catatan && catatan.value.trim() !== '') {
        formData.append('catatan', catatan.value.trim());
      }

      const fileInput = document.getElementById('checkoutBuktiFoto');
      if (fileInput && fileInput.files && fileInput.files[0]) {
        formData.append('bukti_foto', fileInput.files[0]);
      }

      fetch("{{ route('api.orders.checkout') }}", {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        },
        body: formData
      })
      .then(r => r.json())
      .then(res => {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="20 6 9 17 4 12"/></svg><span>Konfirmasi & Kirim Pesanan</span>';
        }

        if (res.status === 'success') {
          // Bersihkan keranjang lokal untuk lapak ini
          localStorage.removeItem(cartKey);
          updateCartUI();

          // Tutup modal checkout
          const checkoutModal = document.getElementById('checkoutModalBackdrop');
          if (checkoutModal) checkoutModal.style.display = 'none';

          // Tampilkan modal sukses
          const successModal = document.getElementById('checkoutSuccessBackdrop');
          if (successModal) successModal.style.display = 'flex';
        } else {
          alert(res.message || 'Gagal memproses pesanan.');
        }
      })
      .catch(() => {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="20 6 9 17 4 12"/></svg><span>Konfirmasi & Kirim Pesanan</span>';
        }
        alert('Terjadi kendala koneksi saat mengirim pesanan.');
      });
    };

    window.tutupSuccessBukaHistory = function() {
      const successModal = document.getElementById('checkoutSuccessBackdrop');
      if (successModal) successModal.style.display = 'none';
      document.body.style.overflow = '';
      if (typeof window.bukaHistoryPesanan === 'function') {
        window.bukaHistoryPesanan();
      }
    };

    window.tutupModalSuccess = function() {
      const successModal = document.getElementById('checkoutSuccessBackdrop');
      if (successModal) successModal.style.display = 'none';
      document.body.style.overflow = '';
    };

    // Inisialisasi tampilan keranjang saat halaman siap
    document.addEventListener('DOMContentLoaded', function () {
      updateCartUI();

      const navLinks = document.querySelectorAll('.cat-chip-btn');
      const sections = document.querySelectorAll('.store-menu-group, #ulasan');

      if (!('IntersectionObserver' in window) || sections.length === 0) return;

      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const id = entry.target.id;
            navLinks.forEach(link => {
              if (link.getAttribute('data-target') === id) {
                link.classList.add('active');
                link.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
              } else {
                link.classList.remove('active');
              }
            });
          }
        });
      }, {
        rootMargin: '-80px 0px -60% 0px',
        threshold: 0
      });

      sections.forEach(sec => observer.observe(sec));
    });
  })();
</script>
@endsection

