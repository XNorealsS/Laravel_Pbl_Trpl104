/**
 * JajanRia Admin Panel Script (UC-09, UC-10, UC-11)
 * Pure Vanilla JavaScript (Tab navigation, breadcrumbs, search filters, modals, and responsive controls)
 */

document.addEventListener('DOMContentLoaded', () => {
  initAdminNav();
  initAdminModals();
  initMobileSidebar();
  initAdminFilters();
});

/**
 * 1. Admin Tab Navigation & Breadcrumb Sync
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
  const pageSubtitle = document.getElementById('adminPageSubtitle');
  const breadcrumb = document.getElementById('breadcrumbCurrent');

  navBtns.forEach(b => b.classList.toggle('active', b.getAttribute('data-tab') === tabId));
  tabViews.forEach(v => v.classList.toggle('active', v.id === tabId));

  const tabMeta = {
    'tab-monitoring': {
      title: 'Monitoring Aktivitas Sistem (UC-11)',
      subtitle: 'Pengawasan lalu lintas transaksi chat, penilaian, dan verifikasi mitra.',
      breadcrumb: 'Monitoring & Statistik'
    },
    'tab-verification': {
      title: 'Verifikasi Calon Seller Baru (UC-09)',
      subtitle: 'Periksa keabsahan dan data lapak UMKM sebelum dipublikasikan.',
      breadcrumb: 'Verifikasi Seller'
    },
    'tab-umkm': {
      title: 'Kelola Mitra UMKM & Pengguna (UC-10)',
      subtitle: 'Kelola akses operasional lapak pedagang dan integritas akun.',
      breadcrumb: 'Kelola Mitra UMKM'
    },
    'tab-categories': {
      title: 'Kelola Kategori Street Food (UC-10)',
      subtitle: 'Pengelompokan menu jajanan untuk mempermudah pencarian mahasiswa.',
      breadcrumb: 'Kelola Kategori Menu'
    },
    'tab-moderation': {
      title: 'Moderasi Ulasan & Testimoni (UC-11)',
      subtitle: 'Sembunyikan atau pulihkan komentar publik demi menjaga etika platform.',
      breadcrumb: 'Moderasi Ulasan'
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

window.switchAdminTab = switchAdminTab;

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
 * 4. Client-side Table Search & Filter Handlers
 */
function initAdminFilters() {
  const monInput = document.getElementById('monitoringSearchInput');
  if (monInput) {
    monInput.addEventListener('keyup', (e) => {
      if (e.key === 'Enter') filterMonitoringTable();
    });
  }

  const verInput = document.getElementById('verifySearchInput');
  if (verInput) {
    verInput.addEventListener('keyup', (e) => {
      if (e.key === 'Enter') filterVerifyTable();
    });
  }

  const umkmInput = document.getElementById('umkmSearchInput');
  if (umkmInput) {
    umkmInput.addEventListener('keyup', (e) => {
      if (e.key === 'Enter') filterUmkmTable();
    });
  }
}

window.filterMonitoringTable = function() {
  const q = (document.getElementById('monitoringSearchInput')?.value || '').toLowerCase().trim();
  const ratingFilter = document.getElementById('monitoringRatingSelect')?.value || 'all';
  const rows = document.querySelectorAll('#monitoringTable tbody tr');

  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    const matchesQuery = !q || text.includes(q);
    let matchesRating = true;

    if (ratingFilter !== 'all') {
      const ratingCell = row.children[4]?.textContent || '';
      if (ratingFilter === '5') matchesRating = ratingCell.includes('5/5');
      else if (ratingFilter === '4') matchesRating = ratingCell.includes('4/5');
      else if (ratingFilter === '3') matchesRating = ratingCell.includes('1/5') || ratingCell.includes('2/5') || ratingCell.includes('3/5');
    }

    row.style.display = (matchesQuery && matchesRating) ? '' : 'none';
  });
};

window.resetMonitoringFilter = function() {
  const input = document.getElementById('monitoringSearchInput');
  const select = document.getElementById('monitoringRatingSelect');
  if (input) input.value = '';
  if (select) select.value = 'all';
  filterMonitoringTable();
};

window.filterVerifyTable = function() {
  const q = (document.getElementById('verifySearchInput')?.value || '').toLowerCase().trim();
  const rows = document.querySelectorAll('#verifyTable tbody tr');

  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    row.style.display = (!q || text.includes(q)) ? '' : 'none';
  });
};

window.filterUmkmTable = function() {
  const q = (document.getElementById('umkmSearchInput')?.value || '').toLowerCase().trim();
  const area = document.getElementById('umkmAreaSelect')?.value || 'all';
  const rows = document.querySelectorAll('#umkmTable tbody tr');

  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    const areaCell = (row.children[3]?.textContent || '').toLowerCase();
    const matchesQuery = !q || text.includes(q);
    const matchesArea = area === 'all' || areaCell.includes(area.toLowerCase());

    row.style.display = (matchesQuery && matchesArea) ? '' : 'none';
  });
};
