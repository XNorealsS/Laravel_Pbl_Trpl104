/**
 * JajanRia Seller Dashboard Script (UC-05, UC-06, UC-07, UC-08)
 * Vanilla JavaScript (Tab handling, dynamic modals, live filtering, and responsive sidebar)
 */

document.addEventListener('DOMContentLoaded', () => {
  initSellerNav();
  initSellerModals();
  initMobileSidebar();
  initSellerFilters();
});

/**
 * 1. Tab Navigation & Breadcrumb Sync
 */
function initSellerNav() {
  const navBtns = document.querySelectorAll('.panel-nav-btn[data-tab]');
  navBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const tabId = btn.getAttribute('data-tab');
      switchSellerTab(tabId);
    });
  });

  // Check URL hash or query for deep linking (e.g. #tab-products or ?tab=products)
  const urlParams = new URLSearchParams(window.location.search);
  const tabQuery = urlParams.get('tab');
  const hash = window.location.hash.replace('#', '');
  const activeTab = tabQuery ? `tab-${tabQuery}` : (hash || 'tab-overview');

  if (document.getElementById(activeTab)) {
    switchSellerTab(activeTab);
  }
}

function switchSellerTab(tabId) {
  const navBtns = document.querySelectorAll('.panel-nav-btn[data-tab]');
  const tabViews = document.querySelectorAll('.tab-view');
  const pageTitle = document.getElementById('pageTitleHeading');
  const pageSubtitle = document.getElementById('pageSubtitleHeading');
  const breadcrumb = document.getElementById('breadcrumbCurrent');

  navBtns.forEach(b => b.classList.toggle('active', b.getAttribute('data-tab') === tabId));
  tabViews.forEach(v => v.classList.toggle('active', v.id === tabId));

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

  // Close mobile sidebar if open
  closeMobileSidebar();
}

window.switchSellerTab = switchSellerTab;

/**
 * 2. Modals Management (Tambah Produk, Edit Produk, Balas Ulasan)
 */
function initSellerModals() {
  // Add Product Modal
  const openAddBtn = document.getElementById('btnOpenAddProductModal');
  const addModal = document.getElementById('productModalBackdrop');
  const closeAddBtn = document.getElementById('btnCloseProductModal');
  const cancelAddBtn = document.getElementById('btnCancelProductModal');

  if (openAddBtn && addModal) {
    openAddBtn.addEventListener('click', () => addModal.classList.add('open'));
  }
  if (closeAddBtn && addModal) {
    closeAddBtn.addEventListener('click', () => addModal.classList.remove('open'));
  }
  if (cancelAddBtn && addModal) {
    cancelAddBtn.addEventListener('click', () => addModal.classList.remove('open'));
  }

  // Edit Product Modal
  const editModal = document.getElementById('editProductModalBackdrop');
  const closeEditBtn = document.getElementById('btnCloseEditModal');
  const cancelEditBtn = document.getElementById('btnCancelEditModal');

  if (closeEditBtn && editModal) {
    closeEditBtn.addEventListener('click', () => editModal.classList.remove('open'));
  }
  if (cancelEditBtn && editModal) {
    cancelEditBtn.addEventListener('click', () => editModal.classList.remove('open'));
  }

  // Reply Review Modal
  const replyModal = document.getElementById('replyReviewModalBackdrop');
  const closeReplyBtn = document.getElementById('btnCloseReplyModal');
  const cancelReplyBtn = document.getElementById('btnCancelReplyModal');

  if (closeReplyBtn && replyModal) {
    closeReplyBtn.addEventListener('click', () => replyModal.classList.remove('open'));
  }
  if (cancelReplyBtn && replyModal) {
    cancelReplyBtn.addEventListener('click', () => replyModal.classList.remove('open'));
  }
}

window.openAddProductModalShortcut = function() {
  switchSellerTab('tab-products');
  const addModal = document.getElementById('productModalBackdrop');
  if (addModal) addModal.classList.add('open');
};

/**
 * Global Helper: Buka modal edit produk
 */
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

/**
 * Global Helper: Buka modal tanggapi ulasan
 */
window.openReplyModal = function(idUlasan, namaPengunjung, quoteText) {
  const modal = document.getElementById('replyReviewModalBackdrop');
  const form = document.getElementById('replyReviewForm');
  if (!modal || !form) return;

  form.action = `/seller/reviews/${idUlasan}/reply`;
  document.getElementById('replyReviewUser').textContent = `Ulasan dari: ${namaPengunjung}`;
  document.getElementById('replyReviewQuote').textContent = `"${quoteText}"`;

  modal.classList.add('open');
};

/**
 * 3. Mobile Sidebar Toggle & Backdrop
 */
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

/**
 * 4. Live Filtering for Seller Tables
 */
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

  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    const catCell = (row.children[2]?.textContent || '').toLowerCase();
    const matchesQuery = !q || text.includes(q);
    const matchesCat = cat === 'all' || catCell.includes(cat.toLowerCase());

    row.style.display = (matchesQuery && matchesCat) ? '' : 'none';
  });
};
