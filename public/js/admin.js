/**
 * JajanRia Admin Panel Script (UC-09, UC-10, UC-11)
 * Pure Vanilla JavaScript (Tab navigation, modals, and responsive controls)
 */

document.addEventListener('DOMContentLoaded', () => {
  initAdminNav();
  initAdminModals();
  initMobileSidebar();
});

/**
 * 1. Admin Tab Navigation
 */
function initAdminNav() {
  const navBtns = document.querySelectorAll('.panel-nav-btn[data-tab]');
  navBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const tabId = btn.getAttribute('data-tab');
      switchAdminTab(tabId);
    });
  });

  // Check URL hash or query for deep linking (e.g. #tab-verification or ?tab=verification)
  const urlParams = new URLSearchParams(window.location.search);
  const tabQuery = urlParams.get('tab');
  const hash = window.location.hash.replace('#', '');
  const activeTab = tabQuery ? `tab-${tabQuery}` : (hash || 'tab-monitoring');

  if (document.getElementById(activeTab)) {
    switchAdminTab(activeTab);
  }
}

function switchAdminTab(tabId) {
  const navBtns = document.querySelectorAll('.panel-nav-btn[data-tab]');
  const tabViews = document.querySelectorAll('.tab-view');
  const pageTitle = document.getElementById('adminPageTitle');

  navBtns.forEach(b => b.classList.toggle('active', b.getAttribute('data-tab') === tabId));
  tabViews.forEach(v => v.classList.toggle('active', v.id === tabId));

  const titles = {
    'tab-monitoring': 'Monitoring & Statistik Sistem (UC-11)',
    'tab-verification': 'Verifikasi Seller Baru (UC-09)',
    'tab-umkm': 'Kelola Mitra UMKM & Pengguna (UC-10)',
    'tab-categories': 'Kelola Kategori Street Food (UC-10)',
    'tab-moderation': 'Moderasi Ulasan & Testimoni (UC-11)'
  };

  if (pageTitle && titles[tabId]) {
    pageTitle.textContent = titles[tabId];
  }

  // Close mobile sidebar if open
  const sidebar = document.getElementById('panelSidebar');
  if (sidebar) sidebar.classList.remove('open');
}

/**
 * 2. Admin Modals Management (Tambah Kategori)
 */
function initAdminModals() {
  const openCatBtn = document.getElementById('btnOpenAddCategoryModal');
  const catModal = document.getElementById('categoryModalBackdrop');
  const closeCatBtn = document.getElementById('btnCloseCatModal');
  const cancelCatBtn = document.getElementById('btnCancelCatModal');

  if (openCatBtn && catModal) {
    openCatBtn.addEventListener('click', () => catModal.classList.add('open'));
  }
  if (closeCatBtn && catModal) {
    closeCatBtn.addEventListener('click', () => catModal.classList.remove('open'));
  }
  if (cancelCatBtn && catModal) {
    cancelCatBtn.addEventListener('click', () => catModal.classList.remove('open'));
  }
}

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
