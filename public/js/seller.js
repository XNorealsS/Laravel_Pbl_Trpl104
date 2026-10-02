/**
 * JajanRia Seller Dashboard Script (UC-05, UC-06, UC-07, F011)
 * Pure Vanilla JavaScript (Client-side interactive CRUD & Order management)
 */

document.addEventListener('DOMContentLoaded', () => {
  initSellerNav();
  initSellerProducts();
  initSellerOrders();
  initSellerProfile();
  initSellerReviews();
  initMobileSidebar();
});

// Default Mock Data for Seller Products
let sellerProducts = [
  {
    id: 101,
    name: 'Nasi Goreng Spesial',
    price: 12000,
    category: 'makanan-berat',
    desc: 'Nasi goreng racikan bumbu khas dengan telur ceplok, suwiran ayam, acar segar, dan kerupuk renyah.',
    image: 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=500&auto=format&fit=crop&q=80',
    stock: 'tersedia'
  },
  {
    id: 102,
    name: 'Paket Ayam Geprek Sambal Matah',
    price: 15000,
    category: 'makanan-berat',
    desc: 'Ayam goreng crispy dengan sambal matah segar khas Bali + nasi pulen hangat + es teh manis.',
    image: 'https://images.unsplash.com/photo-1562967914-608f82629710?w=500&auto=format&fit=crop&q=80',
    stock: 'tersedia'
  },
  {
    id: 103,
    name: 'Ayam Bakar Madu',
    price: 16000,
    category: 'makanan-berat',
    desc: 'Ayam bakar dengan bumbu olesan madu manis legit dan lalapan.',
    image: 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=500&auto=format&fit=crop&q=80',
    stock: 'tersedia'
  },
  {
    id: 104,
    name: 'Tahu & Tempe Crispy',
    price: 8000,
    category: 'cemilan',
    desc: 'Tahu dan tempe goreng renyah bumbu bawang dengan sambal kecap pedas.',
    image: 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=80',
    stock: 'tersedia'
  },
  {
    id: 105,
    name: 'Es Jeruk Peras Segar',
    price: 6000,
    category: 'minuman',
    desc: 'Jeruk peras asli manis alami dan menyegarkan dahaga.',
    image: 'https://images.unsplash.com/photo-1613478223719-2ab802602423?w=500&auto=format&fit=crop&q=80',
    stock: 'habis'
  }
];

// Default Mock Data for Seller Orders
let sellerOrders = [
  {
    id: 'ORD-901',
    customer: "Muhammad Rifa'a",
    menu: 'Paket Ayam Geprek Sambal Matah',
    lastMessage: 'Halo Bu Nita, saya pesan 1 porsi pedas sedang ya.',
    time: '10:15 WIB',
    status: 'pending' // pending | processing | completed
  },
  {
    id: 'ORD-902',
    customer: 'Siti Rahmawati',
    menu: 'Nasi Goreng Spesial',
    lastMessage: 'Sudah saya ambil tadi bu, terima kasih banyak!',
    time: '09:40 WIB',
    status: 'completed'
  },
  {
    id: 'ORD-903',
    customer: 'Fauzan Ramadhan',
    menu: 'Ayam Bakar Madu + Es Jeruk',
    lastMessage: 'Sedang otw ke warung untuk ambil ya bu.',
    time: '09:15 WIB',
    status: 'processing'
  }
];

// Default Mock Data for Seller Reviews
let sellerReviews = [
  {
    id: 1,
    user: "Muhammad Rifa'a",
    rating: 5,
    text: 'Ayam gepreknya juara banget! Sambal matahnya melimpah dan nasi pulen hangat.',
    date: 'Hari ini',
    reply: 'Terima kasih banyak Mas Rifa! Ditunggu pesanan berikutnya ya.'
  },
  {
    id: 2,
    user: 'Karin Azrika',
    rating: 5,
    text: 'Porsi mahasiswa mantap, harga pas di kantong akhir bulan.',
    date: 'Kemarin',
    reply: 'Alhamdulillah, terima kasih Mbak Karin atas ulasannya!'
  },
  {
    id: 3,
    user: 'Geovany Silitonga',
    rating: 4,
    text: 'Rasa enak, kalau pas jam makan siang antreannya agak ramai.',
    date: '2 hari lalu',
    reply: ''
  }
];

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
}

function switchSellerTab(tabId) {
  const navBtns = document.querySelectorAll('.panel-nav-btn[data-tab]');
  const tabViews = document.querySelectorAll('.tab-view');
  const pageTitle = document.getElementById('pageTitleHeading');

  navBtns.forEach(b => b.classList.toggle('active', b.getAttribute('data-tab') === tabId));
  tabViews.forEach(v => v.classList.toggle('active', v.id === tabId));

  const titles = {
    'tab-overview': 'Ringkasan Toko UMKM',
    'tab-products': 'Kelola Etalase Produk (CRUD)',
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
 * 2. Product Management (CRUD) - UC-06
 */
function initSellerProducts() {
  // Load from localStorage if present
  try {
    const saved = localStorage.getItem('jajanria_seller_products');
    if (saved) sellerProducts = JSON.parse(saved);
  } catch (err) {
    console.warn(err);
  }

  renderSellerProducts();

  // Modal open / close
  const openModalBtn = document.getElementById('btnOpenAddProductModal');
  const modalBackdrop = document.getElementById('productModalBackdrop');
  const closeModalBtn = document.getElementById('btnCloseProductModal');
  const cancelModalBtn = document.getElementById('btnCancelProductModal');
  const form = document.getElementById('productForm');

  if (openModalBtn) {
    openModalBtn.addEventListener('click', () => {
      resetProductForm();
      document.getElementById('productModalTitle').textContent = 'Tambah Produk Baru';
      modalBackdrop.classList.add('open');
    });
  }

  function closeProdModal() {
    if (modalBackdrop) modalBackdrop.classList.remove('open');
  }

  if (closeModalBtn) closeModalBtn.addEventListener('click', closeProdModal);
  if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeProdModal);

  // Form submit (Add / Edit)
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const idInput = document.getElementById('productIdInput').value;
      const name = document.getElementById('prodNameInput').value.trim();
      const price = parseInt(document.getElementById('prodPriceInput').value, 10) || 0;
      const category = document.getElementById('prodCategoryInput').value;
      const desc = document.getElementById('prodDescInput').value.trim();
      const image = document.getElementById('prodImgInput').value.trim() || 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=80';
      const stock = document.getElementById('prodStockInput').value;

      if (!name || !price) return;

      if (idInput) {
        // Edit existing
        const idx = sellerProducts.findIndex(p => p.id == idInput);
        if (idx !== -1) {
          sellerProducts[idx] = { ...sellerProducts[idx], name, price, category, desc, image, stock };
          showSellerToast(`Produk "${name}" berhasil diperbarui.`);
        }
      } else {
        // Create new
        const newProduct = {
          id: Date.now(),
          name,
          price,
          category,
          desc,
          image,
          stock
        };
        sellerProducts.unshift(newProduct);
        showSellerToast(`Produk baru "${name}" berhasil ditambahkan.`);
      }

      saveSellerProducts();
      renderSellerProducts();
      closeProdModal();
    });
  }
}

function renderSellerProducts() {
  const tableBody = document.getElementById('sellerProductTableBody');
  const sidebarCount = document.getElementById('sidebarProdCount');
  const overviewCount = document.getElementById('overviewProdCount');

  if (sidebarCount) sidebarCount.textContent = sellerProducts.length;
  if (overviewCount) overviewCount.textContent = sellerProducts.length;

  if (!tableBody) return;

  if (sellerProducts.length === 0) {
    tableBody.innerHTML = `
      <tr>
        <td colspan="5" style="text-align: center; padding: 30px; color: #6B7280;">
          Belum ada produk terdaftar. Klik tombol "Tambah Produk Baru" untuk menambahkan menu pertama Anda.
        </td>
      </tr>
    `;
    return;
  }

  tableBody.innerHTML = sellerProducts.map(prod => {
    const isReady = prod.stock === 'tersedia';
    const statusBadge = isReady
      ? `<span class="badge-status-pill badge-green"><i class='bx bx-check-circle'></i> Tersedia</span>`
      : `<span class="badge-status-pill badge-red"><i class='bx bx-x-circle'></i> Habis</span>`;

    const categoryNames = {
      'makanan-berat': 'Makanan Berat',
      'cemilan': 'Cemilan',
      'minuman': 'Minuman',
      'tradisional': 'Tradisional'
    };

    return `
      <tr>
        <td>
          <div class="table-prod-info">
            <img src="${prod.image}" alt="${escapeHtml(prod.name)}" class="table-prod-img">
            <div>
              <h5 class="table-prod-title">${escapeHtml(prod.name)}</h5>
              <span class="table-prod-cat">${escapeHtml(prod.desc ? prod.desc.substring(0, 45) + '...' : '')}</span>
            </div>
          </div>
        </td>
        <td>
          <span style="font-weight: 600; color: #4B5563;">${categoryNames[prod.category] || prod.category}</span>
        </td>
        <td>
          <strong style="color: var(--color-primary-dark);">Rp ${prod.price.toLocaleString('id-ID')}</strong>
        </td>
        <td>
          <button type="button" class="btn-toggle-stock" onclick="toggleProductStock(${prod.id})" style="background: none; border: none; cursor: pointer;">
            ${statusBadge}
          </button>
        </td>
        <td>
          <div class="table-action-btns">
            <button type="button" class="btn-table-icon" title="Edit Produk" onclick="editProduct(${prod.id})">
              <i class='bx bx-edit'></i>
            </button>
            <button type="button" class="btn-table-icon btn-danger" title="Hapus Produk" onclick="deleteProduct(${prod.id})">
              <i class='bx bx-trash'></i>
            </button>
          </div>
        </td>
      </tr>
    `;
  }).join('');
}

function resetProductForm() {
  document.getElementById('productIdInput').value = '';
  document.getElementById('prodNameInput').value = '';
  document.getElementById('prodPriceInput').value = '';
  document.getElementById('prodCategoryInput').value = 'makanan-berat';
  document.getElementById('prodDescInput').value = '';
  document.getElementById('prodImgInput').value = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&auto=format&fit=crop&q=80';
  document.getElementById('prodStockInput').value = 'tersedia';
}

function editProduct(id) {
  const prod = sellerProducts.find(p => p.id == id);
  if (!prod) return;

  document.getElementById('productIdInput').value = prod.id;
  document.getElementById('prodNameInput').value = prod.name;
  document.getElementById('prodPriceInput').value = prod.price;
  document.getElementById('prodCategoryInput').value = prod.category;
  document.getElementById('prodDescInput').value = prod.desc || '';
  document.getElementById('prodImgInput').value = prod.image || '';
  document.getElementById('prodStockInput').value = prod.stock || 'tersedia';

  document.getElementById('productModalTitle').textContent = 'Edit Menu Produk';
  document.getElementById('productModalBackdrop').classList.add('open');
}

function deleteProduct(id) {
  const prod = sellerProducts.find(p => p.id == id);
  if (!prod) return;

  if (confirm(`Apakah Anda yakin ingin menghapus menu "${prod.name}" dari etalase?`)) {
    sellerProducts = sellerProducts.filter(p => p.id != id);
    saveSellerProducts();
    renderSellerProducts();
    showSellerToast(`Menu "${prod.name}" berhasil dihapus.`);
  }
}

function toggleProductStock(id) {
  const prod = sellerProducts.find(p => p.id == id);
  if (!prod) return;

  prod.stock = prod.stock === 'tersedia' ? 'habis' : 'tersedia';
  saveSellerProducts();
  renderSellerProducts();
  showSellerToast(`Ketersediaan menu "${prod.name}" diubah menjadi: ${prod.stock.toUpperCase()}.`);
}

function saveSellerProducts() {
  try {
    localStorage.setItem('jajanria_seller_products', JSON.stringify(sellerProducts));
  } catch (err) {
    console.warn(err);
  }
}

/**
 * 3. Orders & Chat Management (UC-07)
 */
function initSellerOrders() {
  renderSellerOrders();
}

function renderSellerOrders() {
  const overviewBody = document.getElementById('overviewOrdersTableBody');
  const fullBody = document.getElementById('sellerOrdersFullTableBody');
  const orderCountBadge = document.getElementById('sidebarOrderCount');

  const pendingCount = sellerOrders.filter(o => o.status !== 'completed').length;
  if (orderCountBadge) orderCountBadge.textContent = pendingCount;

  const renderRows = (limit = null) => {
    const list = limit ? sellerOrders.slice(0, limit) : sellerOrders;
    return list.map(order => {
      let statusHtml = '';
      if (order.status === 'pending') {
        statusHtml = `<span class="badge-status-pill badge-amber"><i class='bx bx-time'></i> Menunggu Konfirmasi</span>`;
      } else if (order.status === 'processing') {
        statusHtml = `<span class="badge-status-pill badge-blue" style="background:#DBEAFE; color:#1E40AF;"><i class='bx bx-loader-alt bx-spin'></i> Sedang Diproses</span>`;
      } else {
        statusHtml = `<span class="badge-status-pill badge-green"><i class='bx bx-check-circle'></i> Selesai</span>`;
      }

      return `
        <tr>
          <td>
            <strong>${escapeHtml(order.customer)}</strong>
            <div style="font-size:0.75rem; color:#6B7280;">${order.id}</div>
          </td>
          <td>
            <span style="font-weight: 700; color:#111827;">${escapeHtml(order.menu)}</span>
          </td>
          <td>
            <span style="font-size:0.82rem; color:#4B5563;">"${escapeHtml(order.lastMessage)}"</span>
            <div style="font-size:0.72rem; color:#9CA3AF;">${order.time}</div>
          </td>
          <td>${statusHtml}</td>
          <td>
            <div class="table-action-btns">
              ${order.status === 'pending' ? `
                <button type="button" class="btn-primary-action" style="padding: 5px 12px; font-size: 0.75rem;" onclick="updateOrderStatus('${order.id}', 'processing')">
                  <i class='bx bx-play'></i>
                  <span>Proses</span>
                </button>
              ` : ''}
              ${order.status === 'processing' ? `
                <button type="button" class="btn-primary-action" style="padding: 5px 12px; font-size: 0.75rem; background: #059669;" onclick="updateOrderStatus('${order.id}', 'completed')">
                  <i class='bx bx-check'></i>
                  <span>Tandai Selesai</span>
                </button>
              ` : ''}
              ${order.status === 'completed' ? `
                <span style="font-size:0.75rem; color:#059669; font-weight:700;">Pesanan Tuntas</span>
              ` : ''}
            </div>
          </td>
        </tr>
      `;
    }).join('');
  };

  if (overviewBody) overviewBody.innerHTML = renderRows(3);
  if (fullBody) fullBody.innerHTML = renderRows();
}

function updateOrderStatus(orderId, newStatus) {
  const order = sellerOrders.find(o => o.id === orderId);
  if (!order) return;

  order.status = newStatus;
  renderSellerOrders();

  const labels = {
    'processing': 'Sedang Diproses (Memasak)',
    'completed': 'Pesanan Selesai (Beri Penilaian Dipicu)'
  };

  showSellerToast(`Pesanan ${order.id} diubah ke: ${labels[newStatus] || newStatus}`);
}

/**
 * 4. Seller Profile Form (UC-05)
 */
function initSellerProfile() {
  const form = document.getElementById('sellerProfileForm');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const name = document.getElementById('storeNameInput').value.trim();
    const phone = document.getElementById('storePhoneInput').value.trim();
    const address = document.getElementById('storeAddressInput').value.trim();
    const desc = document.getElementById('storeDescInput').value.trim();

    const nameDisplay = document.getElementById('sellerStoreName');
    if (nameDisplay && name) nameDisplay.textContent = name;

    showSellerToast(`Profil UMKM "${name}" berhasil disimpan.`);
  });
}

/**
 * 5. Reviews and Replies (F011)
 */
function initSellerReviews() {
  renderSellerReviews();

  const modal = document.getElementById('replyReviewModalBackdrop');
  const closeBtn = document.getElementById('btnCloseReplyModal');
  const cancelBtn = document.getElementById('btnCancelReplyModal');
  const form = document.getElementById('replyReviewForm');

  function closeReplyModal() {
    if (modal) modal.classList.remove('open');
  }

  if (closeBtn) closeBtn.addEventListener('click', closeReplyModal);
  if (cancelBtn) cancelBtn.addEventListener('click', closeReplyModal);

  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const reviewId = document.getElementById('replyReviewId').value;
      const text = document.getElementById('replyReviewText').value.trim();

      const review = sellerReviews.find(r => r.id == reviewId);
      if (review) {
        review.reply = text;
        renderSellerReviews();
        closeReplyModal();
        showSellerToast(`Tanggapan berhasil dikirim ke ulasan ${review.user}!`);
      }
    });
  }
}

function renderSellerReviews() {
  const tableBody = document.getElementById('sellerReviewsTableBody');
  if (!tableBody) return;

  tableBody.innerHTML = sellerReviews.map(r => {
    const stars = Array(r.rating).fill("<i class='bx bxs-star' style='color:#F59E0B;'></i>").join('');
    const replyContent = r.reply
      ? `<div style="background:#F0FDF4; padding:6px 10px; border-radius:6px; font-size:0.8rem; color:#166534; border-left:2px solid #2E8B3D;">
           <strong>Tanggapan Seller:</strong> "${escapeHtml(r.reply)}"
         </div>`
      : `<span style="font-size:0.75rem; color:#9CA3AF; font-style:italic;">Belum ditanggapi</span>`;

    return `
      <tr>
        <td>
          <strong>${escapeHtml(r.user)}</strong>
          <div style="font-size:0.72rem; color:#9CA3AF;">${r.date}</div>
        </td>
        <td>
          <div style="display:flex; gap:2px;">${stars}</div>
        </td>
        <td>
          <p style="font-size:0.85rem; color:#374151; margin-bottom:4px;">"${escapeHtml(r.text)}"</p>
        </td>
        <td>
          ${replyContent}
        </td>
        <td>
          <button type="button" class="btn-table-icon btn-success" title="Tanggapi Ulasan" onclick="openReplyModal(${r.id})">
            <i class='bx bx-reply'></i>
          </button>
        </td>
      </tr>
    `;
  }).join('');
}

function openReplyModal(id) {
  const review = sellerReviews.find(r => r.id == id);
  if (!review) return;

  document.getElementById('replyReviewId').value = review.id;
  document.getElementById('replyReviewUser').textContent = `Ulasan dari ${review.user} (${review.date})`;
  document.getElementById('replyReviewQuote').textContent = `"${review.text}"`;
  document.getElementById('replyReviewText').value = review.reply || '';

  document.getElementById('replyReviewModalBackdrop').classList.add('open');
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
function showSellerToast(message) {
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
