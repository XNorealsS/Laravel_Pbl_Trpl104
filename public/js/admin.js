// Script dashboard admin: navigasi tab, modal, sidebar mobile, dan filter tabel.

document.addEventListener('DOMContentLoaded', () => {
  initAdminNav();
  initAdminModals();
  initMobileSidebar();
  initAdminFilters();
  initAdminFormTabSync();
});

// --- Navigasi Tab & Sinkronisasi URL ---

function initAdminNav() {
  const navBtns = document.querySelectorAll('.panel-nav-btn[data-tab]');
  navBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      switchAdminTab(btn.getAttribute('data-tab'));
    });
  });

  // Baca tab aktif dari ?tab=... atau hash URL
  const urlParams = new URLSearchParams(window.location.search);
  const tabQuery = urlParams.get('tab');
  const hash = window.location.hash.replace('#', '');
  const activeTab = tabQuery ? `tab-${tabQuery}` : (hash || 'tab-monitoring');

  if (document.getElementById(activeTab)) {
    switchAdminTab(activeTab);
  }
}

function getActiveAdminTabSlug() {
  const activeSection = document.querySelector('.tab-view.active');
  return activeSection ? activeSection.id.replace(/^tab-/, '') : 'monitoring';
}

function initAdminFormTabSync() {
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
    input.value = getActiveAdminTabSlug();
  });
}

function switchAdminTab(tabId) {
  const navBtns = document.querySelectorAll('.panel-nav-btn[data-tab]');
  const tabViews = document.querySelectorAll('.tab-view');
  const pageTitle = document.getElementById('adminPageTitle');
  const pageSubtitle = document.getElementById('adminPageSubtitle');
  const breadcrumb = document.getElementById('breadcrumbCurrent');

  navBtns.forEach((b) => b.classList.toggle('active', b.getAttribute('data-tab') === tabId));
  tabViews.forEach((v) => v.classList.toggle('active', v.id === tabId));

  // Simpan tab aktif di ?tab= agar saat reload/redirect tetap berada di tab ini
  if (window.history && window.history.replaceState) {
    const url = new URL(window.location.href);
    const tabSlug = tabId.replace(/^tab-/, '');
    if (tabSlug === 'monitoring') {
      url.searchParams.delete('tab');
    } else {
      url.searchParams.set('tab', tabSlug);
    }
    url.hash = '';
    window.history.replaceState(null, '', url.toString());
  }

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
    'tab-payments': {
      title: 'Verifikasi Pembayaran Pesanan',
      subtitle: 'Audit bukti transfer atau struk pembayaran dari pelanggan sebelum pesanan diselesaikan.',
      breadcrumb: 'Verifikasi Pembayaran'
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
    },
    'tab-support': {
      title: 'Customer Support & Pusat Bantuan',
      subtitle: 'Respon cepat keluhan, pertanyaan, dan konfirmasi bukti bayar pengguna.',
      breadcrumb: 'Customer Support'
    },
    'tab-users': {
      title: 'Manajemen User & Activity Log (UC-09, UC-11)',
      subtitle: 'Kelola seluruh akun pengguna serta pantau ringkasan log aktivitas sistem.',
      breadcrumb: 'Manajemen User'
    }
  };

  if (tabMeta[tabId]) {
    if (pageTitle) pageTitle.textContent = tabMeta[tabId].title;
    if (pageSubtitle) pageSubtitle.textContent = tabMeta[tabId].subtitle;
    if (breadcrumb) breadcrumb.textContent = tabMeta[tabId].breadcrumb;
  }

  closeMobileSidebar();
}

window.switchAdminTab = switchAdminTab;

// --- Modal Tambah Kategori ---

function initAdminModals() {
  const openCatBtn = document.getElementById('btnOpenAddCategoryModal');
  const catModal = document.getElementById('categoryModalBackdrop');
  const closeCatBtn = document.getElementById('btnCloseCatModal');
  const cancelCatBtn = document.getElementById('btnCancelCatModal');

  if (!catModal) return;

  if (openCatBtn) {
    openCatBtn.addEventListener('click', () => catModal.classList.add('open'));
  }
  if (closeCatBtn) {
    closeCatBtn.addEventListener('click', () => catModal.classList.remove('open'));
  }
  if (cancelCatBtn) {
    cancelCatBtn.addEventListener('click', () => catModal.classList.remove('open'));
  }
}

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

// --- Filter & Pencarian Tabel ---

function bindEnterSearch(inputId, handler) {
  const input = document.getElementById(inputId);
  if (!input) return;

  input.addEventListener('keyup', (e) => {
    if (e.key === 'Enter') handler();
  });
}

function initAdminFilters() {
  bindEnterSearch('monitoringSearchInput', filterMonitoringTable);
  bindEnterSearch('verifySearchInput', filterVerifyTable);
  bindEnterSearch('umkmSearchInput', filterUmkmTable);
  bindEnterSearch('usersSearchInput', filterUsersTable);
}

window.filterMonitoringTable = function() {
  const q = (document.getElementById('monitoringSearchInput')?.value || '').toLowerCase().trim();
  const ratingFilter = document.getElementById('monitoringRatingSelect')?.value || 'all';
  const rows = document.querySelectorAll('#monitoringTable tbody tr');

  rows.forEach((row) => {
    const text = row.textContent.toLowerCase();
    const matchesQuery = !q || text.includes(q);
    let matchesRating = true;

    if (ratingFilter !== 'all') {
      const ratingCell = row.children[4]?.textContent || '';
      if (ratingFilter === '5') {
        matchesRating = ratingCell.includes('5/5');
      } else if (ratingFilter === '4') {
        matchesRating = ratingCell.includes('4/5');
      } else if (ratingFilter === '3') {
        matchesRating = ratingCell.includes('1/5') || ratingCell.includes('2/5') || ratingCell.includes('3/5');
      }
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

  rows.forEach((row) => {
    const text = row.textContent.toLowerCase();
    row.style.display = (!q || text.includes(q)) ? '' : 'none';
  });
};

window.filterUmkmTable = function() {
  const q = (document.getElementById('umkmSearchInput')?.value || '').toLowerCase().trim();
  const area = document.getElementById('umkmAreaSelect')?.value || 'all';
  const rows = document.querySelectorAll('#umkmTable tbody tr');

  rows.forEach((row) => {
    const text = row.textContent.toLowerCase();
    const areaCell = (row.children[3]?.textContent || '').toLowerCase();
    const matchesQuery = !q || text.includes(q);
    const matchesArea = area === 'all' || areaCell.includes(area.toLowerCase());

    row.style.display = (matchesQuery && matchesArea) ? '' : 'none';
  });
};

window.filterUsersTable = function() {
  const q = (document.getElementById('usersSearchInput')?.value || '').toLowerCase().trim();
  const role = (document.getElementById('usersRoleSelect')?.value || 'all').toLowerCase();
  const status = (document.getElementById('usersStatusSelect')?.value || 'all').toLowerCase();
  const loginType = (document.getElementById('usersLoginSelect')?.value || 'all').toLowerCase();
  const rows = document.querySelectorAll('#usersTable tbody tr');

  rows.forEach((row) => {
    const text = row.textContent.toLowerCase();
    const rowRole = row.getAttribute('data-role') || '';
    const rowStatus = row.getAttribute('data-status') || '';
    const rowLogin = row.getAttribute('data-login') || '';

    const matchesQuery = !q || text.includes(q);
    const matchesRole = role === 'all' || rowRole === role;
    const matchesStatus = status === 'all' || rowStatus === status;
    const matchesLogin = loginType === 'all' || rowLogin === loginType;

    row.style.display = (matchesQuery && matchesRole && matchesStatus && matchesLogin) ? '' : 'none';
  });
};

window.resetUsersFilter = function() {
  const input = document.getElementById('usersSearchInput');
  const roleSelect = document.getElementById('usersRoleSelect');
  const statusSelect = document.getElementById('usersStatusSelect');
  const loginSelect = document.getElementById('usersLoginSelect');

  if (input) input.value = '';
  if (roleSelect) roleSelect.value = 'all';
  if (statusSelect) statusSelect.value = 'all';
  if (loginSelect) loginSelect.value = 'all';

  document.querySelectorAll('.filter-user-pill').forEach((p) => p.classList.remove('active'));
  document.getElementById('pillUserAll')?.classList.add('active');

  filterUsersTable();
};

window.filterUserByPill = function(roleVal, pillEl) {
  document.querySelectorAll('.filter-user-pill').forEach((p) => p.classList.remove('active'));
  if (pillEl) pillEl.classList.add('active');

  const roleSelect = document.getElementById('usersRoleSelect');
  if (roleSelect) roleSelect.value = roleVal;

  filterUsersTable();
};
