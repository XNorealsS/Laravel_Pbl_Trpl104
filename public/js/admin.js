/**
 * JajanRia Admin Panel Script (UC-08, UC-09, UC-10, UC-11)
 * Pure Vanilla JavaScript (Client-side interactive management)
 */

document.addEventListener('DOMContentLoaded', () => {
  initAdminNav();
  initAdminVerification();
  initAdminStores();
  initAdminCategories();
  initAdminModeration();
  initAdminLogs();
  initMobileSidebar();
});

// Mock Data for Pending Seller Verification (UC-09)
let pendingSellers = [
  {
    id: 1,
    owner: 'Pak Joko Sutrisno',
    storeName: 'Bakso Malang Cak Joko',
    location: 'Depan Asrama Polibatam (0.2 km)',
    phone: '6281234567895',
    menu: 'Bakso Urat, Bakso Halus, Pangsit Goreng',
    date: 'Hari ini 08:30 WIB'
  },
  {
    id: 2,
    owner: 'Mbak Dewi Lestari',
    storeName: 'Dapur Cemilan Mahasiswa',
    location: 'Ruko Imperium Blok B No. 4 (0.4 km)',
    phone: '6281234567897',
    menu: 'Cireng Isi Ayam Suwir Pedas, Cilok Kuah',
    date: 'Kemarin 16:15 WIB'
  }
];

// Mock Data for Registered Stores (UC-10)
let registeredStores = [
  { id: 1, name: 'Warung Bu Nita', category: 'Makanan Berat', distance: '0.3 km', rating: 4.8, active: true },
  { id: 2, name: 'Kedai Kopi Sudut', category: 'Minuman & Kopi', distance: '0.7 km', rating: 4.6, active: true },
  { id: 3, name: 'Pisang Goreng Madu', category: 'Cemilan', distance: '0.5 km', rating: 4.7, active: true },
  { id: 4, name: 'Seblak Teh Rani', category: 'Cemilan', distance: '0.4 km', rating: 4.7, active: true },
  { id: 5, name: 'Warung Lestari', category: 'Makanan Berat', distance: '0.6 km', rating: 4.5, active: true },
  { id: 6, name: 'Es Teh Manis Pakde', category: 'Minuman', distance: '0.2 km', rating: 4.6, active: true },
  { id: 7, name: 'Mie Ayam Mas Bro', category: 'Makanan Berat', distance: '0.5 km', rating: 4.8, active: true },
  { id: 8, name: 'Snack Corner Kampus', category: 'Cemilan', distance: '0.2 km', rating: 4.6, active: true }
];

// Mock Data for Categories (UC-10)
let productCategories = [
  { id: 1, name: 'Makanan Berat', slug: 'makanan-berat', icon: 'bx-bowl-rice', count: 18 },
  { id: 2, name: 'Cemilan Nugas', slug: 'cemilan', icon: 'bx-cookie', count: 14 },
  { id: 3, name: 'Minuman Dingin & Kopi', slug: 'minuman', icon: 'bx-coffee-togo', count: 9 },
  { id: 4, name: 'Tradisional & Kue Basah', slug: 'tradisional', icon: 'bx-dish', count: 5 }
];

// Mock Data for Review Moderation (UC-08 / F017)
let moderationReviews = [
  {
    id: 1,
    user: 'Fikri_Hidayat',
    store: 'Seblak Teh Rani',
    rating: 1,
    text: 'Pelayanan sangat lama dan pedasnya ga wajar bikin sakit perut!!',
    hidden: false
  },
  {
    id: 2,
    user: 'User_Anonim_99',
    store: 'Warung Lestari',
    rating: 1,
    text: 'Spam iklan obat penggemuk badan kunjungi web xxx...',
    hidden: true
  },
  {
    id: 3,
    user: 'Rian_TRPL',
    store: 'Kedai Kopi Sudut',
    rating: 5,
    text: 'Tempat cozy buat nugas bareng tim PBL. WiFi stabil dan kopi enak.',
    hidden: false
  }
];

// Mock Activity Logs (UC-11)
let systemLogs = [
  { time: '10:24 WIB', actor: 'Pengunjung (Rifa)', activity: 'Kirim Chat', desc: 'Menghubungi Warung Bu Nita untuk pesanan Nasi Goreng', status: 'Sukses' },
  { time: '10:20 WIB', actor: 'Seller (Bu Nita)', activity: 'Ubah Status', desc: 'Pesanan ORD-901 diubah status ke "Sedang Diproses"', status: 'Sukses' },
  { time: '10:05 WIB', actor: 'Pengunjung (Siti)', activity: 'Beri Penilaian', desc: 'Memberi rating 5 bintang pada Warung Bu Nita', status: 'Tersimpan' },
  { time: '09:45 WIB', actor: 'Seller (Cak Joko)', activity: 'Registrasi Baru', desc: 'Pendaftaran mitra baru "Bakso Malang Cak Joko"', status: 'Menunggu' },
  { time: '09:12 WIB', actor: 'Admin', activity: 'Moderasi Ulasan', desc: 'Menyembunyikan ulasan spam ID #2', status: 'Termoderasi' }
];

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
}

function switchAdminTab(tabId) {
  const navBtns = document.querySelectorAll('.panel-nav-btn[data-tab]');
  const tabViews = document.querySelectorAll('.tab-view');
  const pageTitle = document.getElementById('adminPageTitle');

  navBtns.forEach(b => b.classList.toggle('active', b.getAttribute('data-tab') === tabId));
  tabViews.forEach(v => v.classList.toggle('active', v.id === tabId));

  const titles = {
    'tab-monitoring': 'Monitoring Aktivitas Sistem (UC-11)',
    'tab-verification': 'Verifikasi Seller Baru (UC-09)',
    'tab-umkm': 'Kelola Mitra UMKM Terdaftar (UC-10)',
    'tab-categories': 'Kelola Kategori Street Food (UC-10)',
    'tab-moderation': 'Moderasi Ulasan & Testimoni (UC-08)'
  };

  if (pageTitle && titles[tabId]) {
    pageTitle.textContent = titles[tabId];
  }

  // Close mobile sidebar if open
  const sidebar = document.getElementById('panelSidebar');
  if (sidebar) sidebar.classList.remove('open');
}

/**
 * 2. Seller Verification (UC-09)
 */
function initAdminVerification() {
  renderVerificationTable();

  const rejectModal = document.getElementById('rejectModalBackdrop');
  const closeRejectBtn = document.getElementById('btnCloseRejectModal');
  const cancelRejectBtn = document.getElementById('btnCancelRejectModal');
  const rejectForm = document.getElementById('rejectForm');

  function closeReject() {
    if (rejectModal) rejectModal.classList.remove('open');
  }

  if (closeRejectBtn) closeRejectBtn.addEventListener('click', closeReject);
  if (cancelRejectBtn) cancelRejectBtn.addEventListener('click', closeReject);

  if (rejectForm) {
    rejectForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const sellerId = document.getElementById('rejectSellerId').value;
      const reason = document.getElementById('rejectReasonInput').value.trim();

      const seller = pendingSellers.find(s => s.id == sellerId);
      if (seller) {
        pendingSellers = pendingSellers.filter(s => s.id != sellerId);
        renderVerificationTable();
        closeReject();
        showAdminToast(`Pendaftaran "${seller.storeName}" ditolak dengan alasan: "${reason}".`);
      }
    });
  }
}

function renderVerificationTable() {
  const tbody = document.getElementById('verifyTableBody');
  const badge = document.getElementById('pendingVerifyBadge');

  if (badge) badge.textContent = pendingSellers.length;
  if (!tbody) return;

  if (pendingSellers.length === 0) {
    tbody.innerHTML = `
      <tr>
        <td colspan="5" style="text-align: center; padding: 30px; color: #6B7280;">
          Tidak ada pengajuan verifikasi seller baru yang tertunda. Semua telah diproses.
        </td>
      </tr>
    `;
    return;
  }

  tbody.innerHTML = pendingSellers.map(s => `
    <tr>
      <td>
        <strong style="color:#111827;">${escapeHtml(s.storeName)}</strong>
        <div style="font-size:0.75rem; color:#6B7280;">Pemilik: ${escapeHtml(s.owner)} (${s.date})</div>
      </td>
      <td>
        <span style="font-size:0.85rem; color:#374151;">${escapeHtml(s.location)}</span>
      </td>
      <td>
        <span style="font-size:0.85rem; color:#059669; font-weight:700;">${s.phone}</span>
      </td>
      <td>
        <span style="font-size:0.82rem; color:#4B5563;">${escapeHtml(s.menu)}</span>
      </td>
      <td>
        <div class="table-action-btns">
          <button type="button" class="btn-primary-action" style="padding: 6px 14px; font-size: 0.78rem;" onclick="approveSeller(${s.id})">
            <i class='bx bx-check'></i>
            <span>Setuju</span>
          </button>
          <button type="button" class="btn-table-icon btn-danger" title="Tolak Pengajuan" onclick="openRejectModal(${s.id})">
            <i class='bx bx-x'></i>
          </button>
        </div>
      </td>
    </tr>
  `).join('');
}

function approveSeller(id) {
  const seller = pendingSellers.find(s => s.id == id);
  if (!seller) return;

  // Add to registered stores
  registeredStores.push({
    id: Date.now(),
    name: seller.storeName,
    category: 'Makanan Berat',
    distance: '0.3 km',
    rating: 5.0,
    active: true
  });

  pendingSellers = pendingSellers.filter(s => s.id != id);
  renderVerificationTable();
  renderStoresTable();

  showAdminToast(`Pendaftaran mitra "${seller.storeName}" disetujui! Status berubah menjadi Terverifikasi.`);
}

function openRejectModal(id) {
  const seller = pendingSellers.find(s => s.id == id);
  if (!seller) return;

  document.getElementById('rejectSellerId').value = seller.id;
  document.getElementById('rejectStoreName').textContent = `${seller.storeName} (${seller.owner})`;
  document.getElementById('rejectReasonInput').value = '';

  document.getElementById('rejectModalBackdrop').classList.add('open');
}

/**
 * 3. Registered Stores (UC-10)
 */
function initAdminStores() {
  renderStoresTable();
}

function renderStoresTable() {
  const tbody = document.getElementById('storesTableBody');
  const countDisplay = document.getElementById('totalStoresCount');

  if (countDisplay) countDisplay.textContent = registeredStores.length;
  if (!tbody) return;

  tbody.innerHTML = registeredStores.map(store => {
    const statusPill = store.active
      ? `<span class="badge-status-pill badge-green"><i class='bx bx-check-circle'></i> Aktif</span>`
      : `<span class="badge-status-pill badge-red"><i class='bx bx-pause-circle'></i> Nonaktif</span>`;

    return `
      <tr>
        <td>
          <strong style="color: #111827;">${escapeHtml(store.name)}</strong>
        </td>
        <td>
          <span style="font-size:0.85rem; color:#4B5563;">${escapeHtml(store.category)}</span>
        </td>
        <td>
          <span style="font-size:0.85rem; color:#6B7280;">${store.distance}</span>
        </td>
        <td>
          <span style="font-weight:700; color:#F59E0B;"><i class='bx bxs-star'></i> ${store.rating}</span>
        </td>
        <td>${statusPill}</td>
        <td>
          <button type="button" class="btn-table-icon ${store.active ? 'btn-danger' : 'btn-success'}" title="${store.active ? 'Nonaktifkan Toko' : 'Aktifkan Toko'}" onclick="toggleStoreStatus(${store.id})">
            <i class='bx ${store.active ? 'bx-block' : 'bx-check'}'></i>
          </button>
        </td>
      </tr>
    `;
  }).join('');
}

function toggleStoreStatus(id) {
  const store = registeredStores.find(s => s.id == id);
  if (!store) return;

  store.active = !store.active;
  renderStoresTable();
  showAdminToast(`Status toko "${store.name}" diubah menjadi: ${store.active ? 'AKTIF' : 'NONAKTIF'}.`);
}

/**
 * 4. Categories Management (UC-10)
 */
function initAdminCategories() {
  renderCategoriesTable();

  const modal = document.getElementById('categoryModalBackdrop');
  const openBtn = document.getElementById('btnOpenAddCategoryModal');
  const closeBtn = document.getElementById('btnCloseCatModal');
  const cancelBtn = document.getElementById('btnCancelCatModal');
  const form = document.getElementById('categoryForm');

  if (openBtn) {
    openBtn.addEventListener('click', () => {
      document.getElementById('catNameInput').value = '';
      document.getElementById('catSlugInput').value = '';
      if (modal) modal.classList.add('open');
    });
  }

  function closeCatModal() {
    if (modal) modal.classList.remove('open');
  }

  if (closeBtn) closeBtn.addEventListener('click', closeCatModal);
  if (cancelBtn) cancelBtn.addEventListener('click', closeCatModal);

  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const name = document.getElementById('catNameInput').value.trim();
      const slug = document.getElementById('catSlugInput').value.trim();
      const icon = document.getElementById('catIconInput').value;

      if (!name || !slug) return;

      productCategories.push({
        id: Date.now(),
        name,
        slug,
        icon,
        count: 0
      });

      renderCategoriesTable();
      closeCatModal();
      showAdminToast(`Kategori "${name}" berhasil ditambahkan ke basis data.`);
    });
  }
}

function renderCategoriesTable() {
  const tbody = document.getElementById('categoriesTableBody');
  if (!tbody) return;

  tbody.innerHTML = productCategories.map(cat => `
    <tr>
      <td>
        <strong style="color:#111827;">${escapeHtml(cat.name)}</strong>
      </td>
      <td>
        <code style="background:#F3F4F6; padding:2px 8px; border-radius:4px; font-size:0.8rem;">${escapeHtml(cat.slug)}</code>
      </td>
      <td>
        <i class='bx ${cat.icon}' style="font-size:1.3rem; color:var(--color-primary); vertical-align:middle;"></i>
        <span style="font-size:0.8rem; color:#6B7280; margin-left:6px;">${cat.icon}</span>
      </td>
      <td>
        <span style="font-weight:700; color:#374151;">${cat.count} Menu</span>
      </td>
      <td>
        <button type="button" class="btn-table-icon btn-danger" title="Hapus Kategori" onclick="deleteCategory(${cat.id})">
          <i class='bx bx-trash'></i>
        </button>
      </td>
    </tr>
  `).join('');
}

function deleteCategory(id) {
  const cat = productCategories.find(c => c.id == id);
  if (!cat) return;

  if (cat.count > 0) {
    alert(`Peringatan UC-10: Kategori "${cat.name}" masih memiliki ${cat.count} produk aktif! Harap pindahkan produk terlebih dahulu sebelum menghapus kategori.`);
    return;
  }

  if (confirm(`Yakin ingin menghapus kategori "${cat.name}"?`)) {
    productCategories = productCategories.filter(c => c.id != id);
    renderCategoriesTable();
    showAdminToast(`Kategori "${cat.name}" berhasil dihapus.`);
  }
}

/**
 * 5. Review Moderation (UC-08)
 */
function initAdminModeration() {
  renderModerationTable();
}

function renderModerationTable() {
  const tbody = document.getElementById('moderationTableBody');
  if (!tbody) return;

  tbody.innerHTML = moderationReviews.map(r => {
    const stars = Array(r.rating).fill("<i class='bx bxs-star' style='color:#F59E0B;'></i>").join('');
    const statusPill = r.hidden
      ? `<span class="badge-status-pill badge-red"><i class='bx bx-hide'></i> Disembunyikan</span>`
      : `<span class="badge-status-pill badge-green"><i class='bx bx-show'></i> Tampil Publik</span>`;

    return `
      <tr>
        <td>
          <strong style="color:#111827;">${escapeHtml(r.user)}</strong>
        </td>
        <td>
          <span style="font-size:0.85rem; color:#4B5563;">${escapeHtml(r.store)}</span>
        </td>
        <td>
          <div style="display:flex; gap:2px;">${stars}</div>
        </td>
        <td>
          <p style="font-size:0.85rem; color:#374151;">"${escapeHtml(r.text)}"</p>
        </td>
        <td>${statusPill}</td>
        <td>
          <div class="table-action-btns">
            <button type="button" class="btn-table-icon ${r.hidden ? 'btn-success' : 'btn-danger'}" title="${r.hidden ? 'Tampilkan Kembali' : 'Sembunyikan Ulasan'}" onclick="toggleReviewVisibility(${r.id})">
              <i class='bx ${r.hidden ? 'bx-show' : 'bx-hide'}'></i>
            </button>
            <button type="button" class="btn-table-icon btn-danger" title="Hapus Permanen" onclick="deleteReviewPermanently(${r.id})">
              <i class='bx bx-trash'></i>
            </button>
          </div>
        </td>
      </tr>
    `;
  }).join('');
}

function toggleReviewVisibility(id) {
  const r = moderationReviews.find(rev => rev.id == id);
  if (!r) return;

  r.hidden = !r.hidden;
  renderModerationTable();
  showAdminToast(`Ulasan dari ${r.user} berhasil ${r.hidden ? 'disembunyikan dari publik' : 'ditampilkan kembali'}.`);
}

function deleteReviewPermanently(id) {
  const r = moderationReviews.find(rev => rev.id == id);
  if (!r) return;

  if (confirm(`Yakin ingin menghapus permanen ulasan dari "${r.user}"?`)) {
    moderationReviews = moderationReviews.filter(rev => rev.id != id);
    renderModerationTable();
    showAdminToast(`Ulasan dari ${r.user} berhasil dihapus permanen.`);
  }
}

/**
 * 6. System Activity Logs (UC-11)
 */
function initAdminLogs() {
  const tbody = document.getElementById('adminLogsTableBody');
  if (!tbody) return;

  tbody.innerHTML = systemLogs.map(log => `
    <tr>
      <td>
        <span style="font-size:0.8rem; color:#6B7280; font-weight:600;">${log.time}</span>
      </td>
      <td>
        <strong style="color:#111827;">${escapeHtml(log.actor)}</strong>
      </td>
      <td>
        <span class="badge-status-pill badge-green" style="background:#EFF6FF; color:#1E40AF;">${escapeHtml(log.activity)}</span>
      </td>
      <td>
        <span style="font-size:0.85rem; color:#374151;">${escapeHtml(log.desc)}</span>
      </td>
      <td>
        <span style="font-size:0.75rem; color:#059669; font-weight:700;"><i class='bx bx-check'></i> ${log.status}</span>
      </td>
    </tr>
  `).join('');
}

/**
 * Mobile Sidebar Drawer Toggle
 */
function initMobileSidebar() {
  const toggle = document.getElementById('panelMobileToggle');
  const sidebar = document.getElementById('panelSidebar');
  if (toggle && sidebar) {
    toggle.addEventListener('click', () => {
      sidebar.classList.toggle('open');
    });
  }
}

/**
 * Toast Helper
 */
function showAdminToast(message) {
  let container = document.getElementById('toastContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toastContainer';
    container.className = 'toast-container';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = 'toast-item';
  toast.style.cssText = `
    background: #111827;
    color: #FFFFFF;
    padding: 12px 18px;
    border-radius: 9999px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    font-size: 0.88rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    border: 1px solid rgba(46, 139, 61, 0.4);
  `;
  toast.innerHTML = `
    <i class='bx bx-check-circle' style='color:#4CAF50; font-size:1.2rem;'></i>
    <span>${message}</span>
  `;

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.3s ease';
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

function escapeHtml(string) {
  const entityMap = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#39;'
  };
  return String(string).replace(/[&<>"']/g, s => entityMap[s]);
}
