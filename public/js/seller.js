/**
 * JajanRia Seller Dashboard Script (UC-05, UC-06, UC-07, UC-08)
 * Vanilla JavaScript (Tab handling, dynamic modals, and responsive sidebar)
 */

document.addEventListener('DOMContentLoaded', () => {
  initSellerNav();
  initSellerModals();
  initMobileSidebar();
});

/**
 * 1. Tab Navigation
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

  navBtns.forEach(b => b.classList.toggle('active', b.getAttribute('data-tab') === tabId));
  tabViews.forEach(v => v.classList.toggle('active', v.id === tabId));

  const titles = {
    'tab-overview': 'Ringkasan Toko UMKM',
    'tab-products': 'Kelola Menu & Katalog Produk (CRUD)',
    'tab-orders': 'Pesan & Status Pemesanan Chat',
    'tab-profile': 'Kelola Profil Lapak UMKM',
    'tab-reviews': 'Rating & Ulasan Pembeli'
  };

  if (pageTitle && titles[tabId]) {
    pageTitle.textContent = titles[tabId];
  }

  // Close mobile sidebar if open
  const sidebar = document.getElementById('panelSidebar');
  if (sidebar) sidebar.classList.remove('open');
}

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
 * 3. Mobile Sidebar Toggle
 */
function initMobileSidebar() {
  const toggleBtn = document.getElementById('panelMobileToggle');
  const sidebar = document.getElementById('panelSidebar');

  if (toggleBtn && sidebar) {
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('open');
    });
  }
}
