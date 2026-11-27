// Script dashboard seller: navigasi tab, modal, sidebar mobile, dan filter tabel.

document.addEventListener('DOMContentLoaded', () => {
  initSellerNav();
  initSellerModals();
  initMobileSidebar();
  initSellerFilters();
  initSellerFormTabSync();
});

// --- Navigasi Tab & Sinkronisasi URL ---

function initSellerNav() {
  const navBtns = document.querySelectorAll('.panel-nav-btn[data-tab]');
  navBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      switchSellerTab(btn.getAttribute('data-tab'));
    });
  });

  // Baca tab aktif dari ?tab=... atau hash URL
  const urlParams = new URLSearchParams(window.location.search);
  const tabQuery = urlParams.get('tab');
  const hash = window.location.hash.replace('#', '');
  const activeTab = tabQuery ? `tab-${tabQuery}` : (hash || 'tab-overview');

  if (document.getElementById(activeTab)) {
    switchSellerTab(activeTab);
  }
}

function getActiveSellerTabSlug() {
  const activeSection = document.querySelector('.tab-view.active');
  return activeSection ? activeSection.id.replace(/^tab-/, '') : 'overview';
}

function initSellerFormTabSync() {
  document.addEventListener('submit', (e) => {
    const form = e.target;
    if (!(form instanceof HTMLFormElement) || form.method.toUpperCase() !== 'POST') return;

    let input = form.querySelector('input[name="active_tab"]');
    if (!input) {
      input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'active_tab';
      form.appendChild(input);
    }
    input.value = getActiveSellerTabSlug();
  });
}

function switchSellerTab(tabId) {
  const navBtns = document.querySelectorAll('.panel-nav-btn[data-tab]');
  const tabViews = document.querySelectorAll('.tab-view');
  const pageTitle = document.getElementById('pageTitleHeading');
  const pageSubtitle = document.getElementById('pageSubtitleHeading');
  const breadcrumb = document.getElementById('breadcrumbCurrent');

  navBtns.forEach((b) => b.classList.toggle('active', b.getAttribute('data-tab') === tabId));
  tabViews.forEach((v) => v.classList.toggle('active', v.id === tabId));

  // Simpan tab aktif di ?tab= agar saat reload/redirect tetap berada di tab ini
  if (window.history && window.history.replaceState) {
    const url = new URL(window.location.href);
    const tabSlug = tabId.replace(/^tab-/, '');
    if (tabSlug === 'overview') {
      url.searchParams.delete('tab');
    } else {
      url.searchParams.set('tab', tabSlug);
    }
    url.hash = '';
    window.history.replaceState(null, '', url.toString());
  }

  const tabMeta = {
    'tab-overview': {
      title: 'Ringkasan Toko UMKM',
      subtitle: 'Pantau pesanan chat masuk, kelola menu street food, dan tingkatkan reputasi lapak.',
      breadcrumb: 'Ringkasan Toko'
    },
    'tab-products': {
      title: 'Kelola Menu & Katalog Produk (CRUD)',
      subtitle: 'Tambah menu baru, atur harga jajanan, ubah foto, dan kelola stok tersedia.',
      breadcrumb: 'Kelola Menu'
    },
    'tab-orders': {
      title: 'Pesan & Status Pemesanan Chat',
      subtitle: 'Perbarui status pesanan menjadi Selesai untuk mengaktifkan fitur penilaian ulasan pembeli.',
      breadcrumb: 'Pesan & Pesanan'
    },
    'tab-profile': {
      title: 'Kelola Profil Lapak UMKM',
      subtitle: 'Perbarui nama usaha, nomor WhatsApp, dan lokasi titik mangkal lapak sekitar kampus.',
      breadcrumb: 'Profil UMKM'
    },
    'tab-reviews': {
      title: 'Rating & Ulasan Pembeli',
      subtitle: 'Lihat penilaian kepuasan mahasiswa dan berikan tanggapan penjual yang ramah.',
      breadcrumb: 'Rating & Ulasan'
    }
  };

  if (tabMeta[tabId]) {
    if (pageTitle) pageTitle.textContent = tabMeta[tabId].title;
    if (pageSubtitle) pageSubtitle.textContent = tabMeta[tabId].subtitle;
    if (breadcrumb) breadcrumb.textContent = tabMeta[tabId].breadcrumb;
  }

  closeMobileSidebar();
}

window.switchSellerTab = switchSellerTab;

// --- Modal (Tambah/Edit Produk, Balas Ulasan, Tolak Pembayaran) ---

function bindModalClose(modalId, buttonIds, closeOnBackdrop = false) {
  const modal = document.getElementById(modalId);
  if (!modal) return;

  buttonIds.forEach((btnId) => {
    const btn = document.getElementById(btnId);
    if (btn) {
      btn.addEventListener('click', () => modal.classList.remove('open'));
    }
  });

  if (closeOnBackdrop) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) modal.classList.remove('open');
    });
  }
}

function initSellerModals() {
  const openAddBtn = document.getElementById('btnOpenAddProductModal');
  const addModal = document.getElementById('productModalBackdrop');
  if (openAddBtn && addModal) {
    openAddBtn.addEventListener('click', () => addModal.classList.add('open'));
  }

  bindModalClose('productModalBackdrop', ['btnCloseProductModal', 'btnCancelProductModal']);
  bindModalClose('editProductModalBackdrop', ['btnCloseEditModal', 'btnCancelEditModal']);
  bindModalClose('replyReviewModalBackdrop', ['btnCloseReplyModal', 'btnCancelReplyModal']);
  bindModalClose('sellerRejectPaymentModalBackdrop', ['btnCloseSellerRejectModal', 'btnCancelSellerRejectModal'], true);
}

window.openAddProductModalShortcut = function() {
  switchSellerTab('tab-products');
  const addModal = document.getElementById('productModalBackdrop');
  if (addModal) addModal.classList.add('open');
};

window.openEditProductModal = function(produk) {
  const modal = document.getElementById('editProductModalBackdrop');
  const form = document.getElementById('editProductForm');
  if (!modal || !form) return;

  form.action = `/seller/products/${produk.id_produk}/update`;
  document.getElementById('editProdName').value = produk.nama_produk || '';
  document.getElementById('editProdPrice').value = produk.harga || 0;
  document.getElementById('editProdCategory').value = produk.id_kategori || '';
  document.getElementById('editProdDesc').value = produk.deskripsi || '';

  const availCheckbox = document.getElementById('editProdAvailable');
  if (availCheckbox) availCheckbox.checked = Boolean(produk.tersedia);

  modal.classList.add('open');
};

window.openReplyModal = function(idUlasan, namaPengunjung, quoteText) {
  const modal = document.getElementById('replyReviewModalBackdrop');
  const form = document.getElementById('replyReviewForm');
  if (!modal || !form) return;

  form.action = `/seller/reviews/${idUlasan}/reply`;
  document.getElementById('replyReviewUser').textContent = `Ulasan dari: ${namaPengunjung}`;
  document.getElementById('replyReviewQuote').textContent = `"${quoteText}"`;

  modal.classList.add('open');
};

window.openSellerRejectPaymentModal = function(idPesanan) {
  const modal = document.getElementById('sellerRejectPaymentModalBackdrop');
  const form = document.getElementById('sellerRejectPaymentForm');
  const noteInput = document.getElementById('sellerRejectNote');
  if (!modal || !form) return;

  form.action = `/seller/orders/${idPesanan}/verify-payment`;
  if (noteInput) noteInput.value = '';
  modal.classList.add('open');
};

// --- Sidebar Mobile ---

function initMobileSidebar() {
  const toggleBtn = document.getElementById('panelMobileToggle');
  const sidebar = document.getElementById('panelSidebar');
  const backdrop = document.getElementById('panelSidebarBackdrop');

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('open');
      if (backdrop) backdrop.classList.toggle('active');
    });
  }

  if (backdrop) {
    backdrop.addEventListener('click', closeMobileSidebar);
  }
}

function closeMobileSidebar() {
  const sidebar = document.getElementById('panelSidebar');
  const backdrop = document.getElementById('panelSidebarBackdrop');
  if (sidebar) sidebar.classList.remove('open');
  if (backdrop) backdrop.classList.remove('active');
}

// --- Filter Tabel Produk ---

function initSellerFilters() {
  const prodInput = document.getElementById('productSearchInput');
  if (prodInput) {
    prodInput.addEventListener('keyup', (e) => {
      if (e.key === 'Enter') filterSellerProductTable();
    });
  }
}

window.filterSellerProductTable = function() {
  const q = (document.getElementById('productSearchInput')?.value || '').toLowerCase().trim();
  const cat = document.getElementById('productCategoryFilterSelect')?.value || 'all';
  const rows = document.querySelectorAll('#sellerProductTable tbody tr');

  rows.forEach((row) => {
    const text = row.textContent.toLowerCase();
    const catCell = (row.children[2]?.textContent || '').toLowerCase();
    const matchesQuery = !q || text.includes(q);
    const matchesCat = cat === 'all' || catCell.includes(cat.toLowerCase());

    row.style.display = (matchesQuery && matchesCat) ? '' : 'none';
  });
};
