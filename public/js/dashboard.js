/**
 * JajanRia Dashboard Interaction Script
 * Pure Vanilla JavaScript (Modular, Responsive & Interactive)
 */

document.addEventListener('DOMContentLoaded', () => {
  initBannerCarousel();
  initCategoryFilter();
  initSearch();
  initCardInteractions();
  initBottomNav();
});

/**
 * 1. Dynamic Image Banner Carousel
 * Mendukung auto-slide, dot indicators, dan touch swipe di mobile
 */
function initBannerCarousel() {
  const track = document.getElementById('bannerTrack');
  const dots = document.querySelectorAll('.banner-dot');
  const carousel = document.getElementById('dynamicBannerCarousel');

  if (!track || dots.length === 0) return;

  const totalSlides = dots.length;
  let currentIndex = 0;
  let autoSlideTimer = null;
  let touchStartX = 0;
  let touchEndX = 0;

  function goToSlide(index) {
    if (index < 0) index = totalSlides - 1;
    if (index >= totalSlides) index = 0;

    currentIndex = index;
    track.style.transform = `translateX(-${currentIndex * 100}%)`;

    dots.forEach((dot, i) => {
      dot.classList.toggle('active', i === currentIndex);
    });
  }

  function nextSlide() {
    goToSlide(currentIndex + 1);
  }

  function prevSlide() {
    goToSlide(currentIndex - 1);
  }

  // Dot navigation click
  dots.forEach((dot) => {
    dot.addEventListener('click', (e) => {
      const targetIndex = parseInt(e.target.getAttribute('data-slide-target'), 10);
      if (!isNaN(targetIndex)) {
        goToSlide(targetIndex);
        resetAutoSlide();
      }
    });
  });

  // Touch Swipe for Mobile
  if (carousel) {
    carousel.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
      clearInterval(autoSlideTimer);
    }, { passive: true });

    carousel.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
      startAutoSlide();
    }, { passive: true });

    carousel.addEventListener('mouseenter', () => clearInterval(autoSlideTimer));
    carousel.addEventListener('mouseleave', () => startAutoSlide());
  }

  function handleSwipe() {
    const diff = touchEndX - touchStartX;
    if (Math.abs(diff) > 45) {
      if (diff < 0) {
        nextSlide();
      } else {
        prevSlide();
      }
    }
  }

  function startAutoSlide() {
    clearInterval(autoSlideTimer);
    autoSlideTimer = setInterval(nextSlide, 4500);
  }

  function resetAutoSlide() {
    clearInterval(autoSlideTimer);
    startAutoSlide();
  }

  // Start auto slide
  startAutoSlide();
}

/**
 * 2. Category Live Filtering
 */
function initCategoryFilter() {
  const categoryItems = document.querySelectorAll('.category-item');
  const storeCards = document.querySelectorAll('.store-mini-card');
  const menuCards = document.querySelectorAll('.menu-mini-card');

  categoryItems.forEach((btn) => {
    btn.addEventListener('click', () => {
      categoryItems.forEach((b) => b.classList.remove('active'));
      btn.classList.add('active');

      const slug = btn.getAttribute('data-category-slug') || 'all';

      // Filter stores
      storeCards.forEach((card) => {
        const cat = card.getAttribute('data-category');
        if (slug === 'all' || cat === slug) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });

      // Filter menus
      menuCards.forEach((card) => {
        const cat = card.getAttribute('data-category');
        if (slug === 'all' || cat === slug) {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    });
  });
}

/**
 * 3. Search Bar Live Filtering (Mobile & Desktop)
 */
function initSearch() {
  const mobileInput = document.getElementById('mobileSearchInput');
  const desktopInput = document.getElementById('desktopSearchInput');

  function handleSearch(query) {
    const term = query.trim().toLowerCase();
    const storeCards = document.querySelectorAll('.store-mini-card');
    const menuCards = document.querySelectorAll('.menu-mini-card');

    storeCards.forEach((card) => {
      const title = (card.getAttribute('data-title') || '').toLowerCase();
      const cat = (card.getAttribute('data-category') || '').toLowerCase();
      if (term === '' || title.includes(term) || cat.includes(term)) {
        card.style.display = 'flex';
      } else {
        card.style.display = 'none';
      }
    });

    menuCards.forEach((card) => {
      const title = (card.getAttribute('data-title') || '').toLowerCase();
      const seller = (card.getAttribute('data-seller') || '').toLowerCase();
      const cat = (card.getAttribute('data-category') || '').toLowerCase();
      if (term === '' || title.includes(term) || seller.includes(term) || cat.includes(term)) {
        card.style.display = 'flex';
      } else {
        card.style.display = 'none';
      }
    });
  }

  if (mobileInput) {
    mobileInput.addEventListener('input', (e) => handleSearch(e.target.value));
  }

  if (desktopInput) {
    desktopInput.addEventListener('input', (e) => handleSearch(e.target.value));
  }
}

/**
 * 4. Card Click & Quick View Modal
 */
function initCardInteractions() {
  const modalBackdrop = document.getElementById('quickViewModal');
  const closeBtn = document.getElementById('modalCloseBtn');

  const modalImg = document.getElementById('modalImg');
  const modalTitle = document.getElementById('modalTitle');
  const modalPrice = document.getElementById('modalPrice');
  const modalSeller = document.getElementById('modalSeller');
  const modalRating = document.getElementById('modalRating');
  const modalDesc = document.getElementById('modalDesc');
  const modalOrderBtn = document.getElementById('modalOrderBtn');

  if (!modalBackdrop) return;

  function openModal(data) {
    if (modalImg) modalImg.src = data.image || '';
    if (modalImg) modalImg.alt = data.title || 'Foto Menu';
    if (modalTitle) modalTitle.textContent = data.title || '';
    if (modalPrice) modalPrice.textContent = data.price || '';
    if (modalSeller) modalSeller.textContent = data.seller || '';
    if (modalRating) modalRating.textContent = data.rating ? `★ ${data.rating}` : '';
    if (modalDesc) modalDesc.textContent = data.desc || 'Menu pilihan lezat dan higienis dari pelaku UMKM lokal sekitar kampus.';

    if (modalOrderBtn) {
      modalOrderBtn.onclick = () => {
        orderViaWhatsApp(data.whatsapp, data.title, data.seller);
      };
    }

    modalBackdrop.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modalBackdrop.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  // Click on Menu Mini Cards
  const menuCards = document.querySelectorAll('.menu-mini-card');
  menuCards.forEach((card) => {
    card.addEventListener('click', () => {
      const data = {
        title: card.getAttribute('data-title'),
        seller: card.getAttribute('data-seller'),
        price: card.getAttribute('data-price'),
        rating: card.getAttribute('data-rating'),
        desc: card.getAttribute('data-desc'),
        image: card.getAttribute('data-image'),
        whatsapp: card.getAttribute('data-whatsapp'),
      };
      openModal(data);
    });
  });

  // Click on Store Mini Cards
  const storeCards = document.querySelectorAll('.store-mini-card');
  storeCards.forEach((card) => {
    card.addEventListener('click', () => {
      const name = card.getAttribute('data-title');
      const dist = card.getAttribute('data-distance');
      const rating = card.getAttribute('data-rating');
      const whatsapp = card.getAttribute('data-whatsapp');
      const img = card.querySelector('.store-mini-img')?.src || '';

      const data = {
        title: name,
        seller: `Lapak UMKM (${dist} km dari kampus)`,
        price: 'Buka Sekarang',
        rating: rating,
        desc: `Kunjungi ${name} untuk menikmati aneka hidangan jajanan enak, dekat, dan harga mahasiswa.`,
        image: img,
        whatsapp: whatsapp,
      };
      openModal(data);
    });
  });

  if (closeBtn) closeBtn.addEventListener('click', closeModal);

  modalBackdrop.addEventListener('click', (e) => {
    if (e.target === modalBackdrop) closeModal();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modalBackdrop.classList.contains('is-open')) {
      closeModal();
    }
  });
}

/**
 * 5. Bottom Navigation Bar Interaction
 */
function initBottomNav() {
  const items = document.querySelectorAll('.bottom-nav-item');
  items.forEach((item) => {
    item.addEventListener('click', (e) => {
      items.forEach((i) => i.classList.remove('active'));
      item.classList.add('active');

      const label = item.querySelector('.bottom-nav-label')?.textContent || '';
      if (label === 'Favorit') {
        showToast('❤️ Menampilkan Menu Favorit Kamu');
      } else if (label === 'Pesanan') {
        showToast('📋 Menampilkan Riwayat Pesanan');
      } else if (label === 'Jelajahi') {
        document.getElementById('mobileSearchInput')?.focus();
      }
    });
  });
}

/**
 * Helper: Pesan via WhatsApp
 */
function orderViaWhatsApp(phone, menuTitle, sellerName) {
  const cleanPhone = (phone || '6281234567890').replace(/\D/g, '');
  const message = encodeURIComponent(`Halo ${sellerName || 'Penjual'}, saya ingin memesan "${menuTitle}" melalui JajanRia. Apakah masih tersedia?`);
  const waUrl = `https://wa.me/${cleanPhone}?text=${message}`;

  showToast(`📲 Membuka WhatsApp untuk memesan "${menuTitle}"...`);

  setTimeout(() => {
    window.open(waUrl, '_blank');
  }, 500);
}

/**
 * Helper: Toast Notification
 */
function showToast(message) {
  let container = document.getElementById('toastContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toastContainer';
    container.className = 'toast-container';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = 'toast-item';
  toast.innerHTML = `
    <svg class="toast-icon" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span>${message}</span>
  `;

  container.appendChild(toast);

  requestAnimationFrame(() => toast.classList.add('show'));

  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}
