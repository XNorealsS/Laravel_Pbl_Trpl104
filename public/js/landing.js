/**
 * JajanRia Landing Page Interaction Script
 * Pure Vanilla JavaScript (Client-side interactive state, zero backend dependencies)
 */

document.addEventListener('DOMContentLoaded', () => {
  initNavbarScroll();
  initMobileDrawer();
  initSearchAndFilter();
  initOrderButtons();
  initMitraAction();
  initBackToTop();
});

/**
 * 1. Navbar Scroll Effect
 */
function initNavbarScroll() {
  const navbar = document.getElementById('landingNavbar');
  if (!navbar) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  }, { passive: true });
}

/**
 * 2. Mobile Drawer Navigation
 */
function initMobileDrawer() {
  const openBtn = document.getElementById('mobileMenuBtn');
  const closeBtn = document.getElementById('drawerCloseBtn');
  const drawer = document.getElementById('mobileDrawer');
  const backdrop = document.getElementById('drawerBackdrop');
  const drawerLinks = document.querySelectorAll('.drawer-link');

  if (!openBtn || !drawer || !backdrop) return;

  function openMenu() {
    drawer.classList.add('open');
    backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  function closeMenu() {
    drawer.classList.remove('open');
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
  }

  openBtn.addEventListener('click', openMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);
  backdrop.addEventListener('click', closeMenu);

  drawerLinks.forEach(link => {
    link.addEventListener('click', closeMenu);
  });
}

/**
 * 3. Gojek-Style Search Bar & Live Category Filter
 */
function initSearchAndFilter() {
  const searchInput = document.getElementById('landingSearchInput');
  const searchBtn = document.getElementById('landingSearchBtn');
  const searchClear = document.getElementById('landingSearchClear');
  const categoryPills = document.querySelectorAll('.cat-pill');
  const popularChips = document.querySelectorAll('.search-chip');
  const menuCards = document.querySelectorAll('.menu-card');
  const resultText = document.getElementById('searchResultText');
  const emptyState = document.getElementById('emptySearchState');
  const btnResetFilter = document.getElementById('btnResetFilter');
  const btnEmptyReset = document.getElementById('btnEmptyReset');

  let activeCategory = 'all';

  function applyFilter(scrollAfter = false) {
    const query = (searchInput ? searchInput.value : '').trim().toLowerCase();

    // Toggle clear button
    if (searchClear) {
      searchClear.style.display = query.length > 0 ? 'flex' : 'none';
    }

    let matchCount = 0;

    menuCards.forEach(card => {
      const cardCat = card.getAttribute('data-category') || '';
      const cardKeywords = (card.getAttribute('data-keywords') || '').toLowerCase();
      const cardTitle = (card.querySelector('.menu-name')?.textContent || '').toLowerCase();
      const cardSeller = (card.querySelector('.store-name')?.textContent || '').toLowerCase();

      // Check category match
      const categoryMatches = (activeCategory === 'all') || (cardCat === activeCategory);

      // Check query match
      let queryMatches = true;
      if (query.length > 0) {
        queryMatches = cardKeywords.includes(query) || cardTitle.includes(query) || cardSeller.includes(query);
      }

      if (categoryMatches && queryMatches) {
        card.style.display = 'flex';
        matchCount++;
      } else {
        card.style.display = 'none';
      }
    });

    // Update Result Text & Empty State
    if (resultText) {
      if (query.length > 0 && activeCategory !== 'all') {
        resultText.textContent = `Ditemukan ${matchCount} menu untuk "${query}" pada kategori terpilih`;
      } else if (query.length > 0) {
        resultText.textContent = `Ditemukan ${matchCount} menu dengan kata kunci "${query}"`;
      } else if (activeCategory !== 'all') {
        resultText.textContent = `Menampilkan ${matchCount} menu pada kategori terpilih`;
      } else {
        resultText.textContent = `Menampilkan ${matchCount} jajanan pilihan di sekitar kampus Polibatam`;
      }
    }

    // Toggle Reset Filter Button
    const isFiltered = query.length > 0 || activeCategory !== 'all';
    if (btnResetFilter) {
      btnResetFilter.style.display = isFiltered ? 'inline-flex' : 'none';
    }

    // Toggle Empty State
    if (emptyState) {
      emptyState.style.display = matchCount === 0 ? 'block' : 'none';
    }

    if (scrollAfter) {
      const katalogSec = document.getElementById('katalog');
      if (katalogSec) {
        katalogSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    }
  }

  // 1. Search Input Listeners
  if (searchInput) {
    searchInput.addEventListener('input', () => {
      applyFilter(false);
    });

    searchInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        applyFilter(true);
      }
    });
  }

  // 2. Search Submit Button
  if (searchBtn) {
    searchBtn.addEventListener('click', (e) => {
      e.preventDefault();
      applyFilter(true);
    });
  }

  // 3. Clear Search Button
  if (searchClear) {
    searchClear.addEventListener('click', () => {
      if (searchInput) {
        searchInput.value = '';
        searchInput.focus();
      }
      applyFilter(false);
    });
  }

  // 4. Popular Keyword Chips (Ala Gojek)
  popularChips.forEach(chip => {
    chip.addEventListener('click', () => {
      const keyword = chip.getAttribute('data-keyword') || chip.textContent.trim();
      if (searchInput) {
        searchInput.value = keyword;
      }
      // Reset category to all for full search
      activeCategory = 'all';
      categoryPills.forEach(p => p.classList.toggle('active', p.getAttribute('data-category') === 'all'));
      applyFilter(true);
    });
  });

  // 5. Category Pills Filter
  categoryPills.forEach(pill => {
    pill.addEventListener('click', () => {
      categoryPills.forEach(p => p.classList.remove('active'));
      pill.classList.add('active');
      activeCategory = pill.getAttribute('data-category') || 'all';
      applyFilter(false);
    });
  });

  // 6. Reset Filter Action
  function resetAllFilters() {
    if (searchInput) searchInput.value = '';
    activeCategory = 'all';
    categoryPills.forEach(p => p.classList.toggle('active', p.getAttribute('data-category') === 'all'));
    applyFilter(false);
  }

  if (btnResetFilter) btnResetFilter.addEventListener('click', resetAllFilters);
  if (btnEmptyReset) btnEmptyReset.addEventListener('click', resetAllFilters);
}

/**
 * 4. WhatsApp Order Simulation (UC-03 & SRS Flow)
 */
function initOrderButtons() {
  const orderButtons = document.querySelectorAll('.btn-pesan-wa');

  orderButtons.forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const menuTitle = btn.getAttribute('data-title') || 'Menu Pilihan';
      const seller = btn.getAttribute('data-seller') || 'Mitra UMKM';
      const phone = btn.getAttribute('data-phone') || '6281234567890';

      const cleanPhone = phone.replace(/\D/g, '');
      const message = encodeURIComponent(`Halo ${seller}, saya ingin memesan "${menuTitle}" yang saya lihat di JajanRia Polibatam. Apakah stok masih tersedia?`);
      const waUrl = `https://wa.me/${cleanPhone}?text=${message}`;

      showLandingToast(`Menghubungkan pesanan "${menuTitle}" ke WhatsApp ${seller}...`);

      setTimeout(() => {
        window.open(waUrl, '_blank');
      }, 600);
    });
  });
}

/**
 * 5. Mitra Registration Action
 */
function initMitraAction() {
  const mitraBtn = document.getElementById('btnDaftarMitra');
  if (!mitraBtn) return;

  mitraBtn.addEventListener('click', (e) => {
    e.preventDefault();
    const phone = '6281234567890';
    const message = encodeURIComponent('Halo Admin JajanRia Polibatam, saya pemilik usaha kuliner di sekitar kampus dan tertarik mendaftarkan warung saya sebagai Mitra UMKM.');
    const waUrl = `https://wa.me/${phone}?text=${message}`;

    showLandingToast('Membuka pendaftaran Mitra UMKM via WhatsApp Admin Polibatam...');

    setTimeout(() => {
      window.open(waUrl, '_blank');
    }, 600);
  });
}

/**
 * 6. Back to Top Button
 */
function initBackToTop() {
  const backToTopBtn = document.getElementById('backToTopBtn');
  if (!backToTopBtn) return;

  backToTopBtn.addEventListener('click', () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

/**
 * Helper: Notification Toast
 */
function showLandingToast(message) {
  let container = document.getElementById('landingToastContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'landingToastContainer';
    container.style.cssText = `
      position: fixed;
      bottom: 24px;
      right: 24px;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 10px;
      pointer-events: none;
    `;
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.style.cssText = `
    background: #111827;
    color: #FFFFFF;
    padding: 12px 20px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    font-size: 0.875rem;
    font-weight: 600;
    font-family: 'Plus Jakarta Sans', sans-serif;
    display: flex;
    align-items: center;
    gap: 10px;
    opacity: 0;
    transform: translateY(16px);
    transition: all 0.25s ease;
    border: 1px solid rgba(46, 139, 61, 0.4);
    pointer-events: auto;
  `;
  toast.innerHTML = `
    <i class='bx bx-check-circle' style='color: #4CAF50; font-size: 1.25rem;'></i>
    <span>${message}</span>
  `;

  container.appendChild(toast);

  requestAnimationFrame(() => {
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';
  });

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(10px)';
    setTimeout(() => toast.remove(), 250);
  }, 3200);
}
