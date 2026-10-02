/**
 * JajanRia Dashboard Interaction Script
 * Platform Promosi Digital & Direktori Interaktif (Non-Transaksional)
 * Pure Vanilla JavaScript (Modular, Responsive & Terhubung Langsung ke Chat Internal)
 */

document.addEventListener('DOMContentLoaded', () => {
  initBannerCarousel();
  initCombinedFilters();
  initCardInteractions();
  initReviewModalSystem();
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
    autoSlideTimer = setInterval(nextSlide, 5000);
  }

  function resetAutoSlide() {
    clearInterval(autoSlideTimer);
    startAutoSlide();
  }

  startAutoSlide();
}

/**
 * 2. Filter Terpadu Katalog (Kategori Squircle, Rentang Harga, Area Kampus, & Live Search)
 * Tidak ada tombol duplikat. Satu sistem filter yang saling tersinkronisasi.
 */
function initCombinedFilters() {
  const categoryItems = document.querySelectorAll('.category-item');
  const priceSelect = document.getElementById('filterPriceSelect');
  const locationSelect = document.getElementById('filterLocationSelect');
  const priceChips = document.querySelectorAll('.filter-chip-pill[data-price-val]');
  const locationChips = document.querySelectorAll('.filter-chip-pill[data-loc-val]');
  const btnReset = document.getElementById('btnResetAllFilters');
  const mobileInput = document.getElementById('mobileSearchInput');
  const desktopInput = document.getElementById('desktopSearchInput');
  const filterLiveText = document.getElementById('filterLiveCountText');

  function applyCombinedCatalogFilters() {
    const activeCatBtn = document.querySelector('.category-item.active');
    const selectedCat = activeCatBtn ? (activeCatBtn.getAttribute('data-category-slug') || 'all') : 'all';
    const selectedPrice = priceSelect ? priceSelect.value : 'all';
    const selectedLoc = locationSelect ? locationSelect.value : 'all';
    const searchVal = ((desktopInput && desktopInput.value) || (mobileInput && mobileInput.value) || '').trim().toLowerCase();

    // 1. Filter Kartu Profil UMKM (Kartu Nama Digital Penjual)
    const storeCards = document.querySelectorAll('.store-mini-card');
    let visibleStores = 0;
    storeCards.forEach(card => {
      const cat = (card.getAttribute('data-category') || '').toLowerCase();
      const title = (card.getAttribute('data-title') || '').toLowerCase();
      const loc = (card.getAttribute('data-location') || 'kantin').toLowerCase();

      const matchCat = (selectedCat === 'all' || cat === selectedCat);
      const matchLoc = (selectedLoc === 'all' || loc === selectedLoc);
      const matchSearch = (searchVal === '' || title.includes(searchVal) || cat.includes(searchVal));

      const isVisible = (matchCat && matchLoc && matchSearch);
      card.style.display = isVisible ? 'flex' : 'none';
      if (isVisible) visibleStores++;
    });

    // 2. Filter Kartu Etalase Menu (Katalog Produk Kuliner)
    const menuCards = document.querySelectorAll('.menu-mini-card');
    let visibleMenus = 0;
    menuCards.forEach(card => {
      const cat = (card.getAttribute('data-category') || '').toLowerCase();
      const title = (card.getAttribute('data-title') || '').toLowerCase();
      const seller = (card.getAttribute('data-seller') || '').toLowerCase();
      const priceNum = parseInt(card.getAttribute('data-price-num') || '12000', 10);
      const loc = (card.getAttribute('data-location') || 'kantin').toLowerCase();

      const matchCat = (selectedCat === 'all' || cat === selectedCat);
      let matchPrice = true;
      if (selectedPrice === 'under10') matchPrice = (priceNum < 10000);
      else if (selectedPrice === '10to20') matchPrice = (priceNum >= 10000 && priceNum <= 20000);
      else if (selectedPrice === 'above20') matchPrice = (priceNum > 20000);

      const matchLoc = (selectedLoc === 'all' || loc === selectedLoc);
      const matchSearch = (searchVal === '' || title.includes(searchVal) || seller.includes(searchVal) || cat.includes(searchVal));

      const isVisible = (matchCat && matchPrice && matchLoc && matchSearch);
      card.style.display = isVisible ? 'flex' : 'none';
      if (isVisible) visibleMenus++;
    });

    // 3. Update Dynamic Live Counter Pill
    if (filterLiveText) {
      if (selectedCat === 'all' && selectedPrice === 'all' && selectedLoc === 'all' && searchVal === '') {
        filterLiveText.textContent = `Menampilkan Semua Kuliner (${visibleStores} Lapak, ${visibleMenus} Menu)`;
      } else {
        filterLiveText.textContent = `Ditemukan ${visibleStores} Lapak & ${visibleMenus} Menu`;
      }
    }
  }

  // Klik Kategori Squircle
  categoryItems.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      categoryItems.forEach((b) => b.classList.remove('active'));
      btn.classList.add('active');
      applyCombinedCatalogFilters();
    });
  });

  // Klik Quick Chips Rentang Harga
  priceChips.forEach((chip) => {
    chip.addEventListener('click', () => {
      priceChips.forEach((c) => c.classList.remove('active'));
      chip.classList.add('active');
      const val = chip.getAttribute('data-price-val') || 'all';
      if (priceSelect) priceSelect.value = val;
      applyCombinedCatalogFilters();
    });
  });

  // Klik Quick Chips Lokasi Lapak Kampus
  locationChips.forEach((chip) => {
    chip.addEventListener('click', () => {
      locationChips.forEach((c) => c.classList.remove('active'));
      chip.classList.add('active');
      const val = chip.getAttribute('data-loc-val') || 'all';
      if (locationSelect) locationSelect.value = val;
      applyCombinedCatalogFilters();
    });
  });

  // Sinkronisasi jika select dropdown berubah (opsional)
  if (priceSelect) {
    priceSelect.addEventListener('change', () => {
      const val = priceSelect.value;
      priceChips.forEach((c) => c.classList.toggle('active', c.getAttribute('data-price-val') === val));
      applyCombinedCatalogFilters();
    });
  }

  if (locationSelect) {
    locationSelect.addEventListener('change', () => {
      const val = locationSelect.value;
      locationChips.forEach((c) => c.classList.toggle('active', c.getAttribute('data-loc-val') === val));
      applyCombinedCatalogFilters();
    });
  }

  // Pencarian Kata Kunci Live
  if (desktopInput) {
    desktopInput.addEventListener('input', (e) => {
      if (mobileInput) mobileInput.value = e.target.value;
      applyCombinedCatalogFilters();
    });
  }

  if (mobileInput) {
    mobileInput.addEventListener('input', (e) => {
      if (desktopInput) desktopInput.value = e.target.value;
      applyCombinedCatalogFilters();
    });
  }

  // Tombol Reset Filter
  if (btnReset) {
    btnReset.addEventListener('click', () => {
      categoryItems.forEach((b) => b.classList.remove('active'));
      document.querySelector('.category-item[data-category-slug="all"]')?.classList.add('active');
      
      priceChips.forEach((c) => c.classList.toggle('active', c.getAttribute('data-price-val') === 'all'));
      if (priceSelect) priceSelect.value = 'all';

      locationChips.forEach((c) => c.classList.toggle('active', c.getAttribute('data-loc-val') === 'all'));
      if (locationSelect) locationSelect.value = 'all';

      if (desktopInput) desktopInput.value = '';
      if (mobileInput) mobileInput.value = '';
      applyCombinedCatalogFilters();
      showToast('Semua filter katalog berhasil di-reset');
    });
  }

  // Inisialisasi awal hitung jumlah item
  applyCombinedCatalogFilters();
}

/**
 * 3. Card Click & Modal Detail Interaktif (Terkoneksi ke Chat Internal)
 * Membuka Modal Profil UMKM / Detail Menu dan Memungkinkan Chat Langsung
 */
function initCardInteractions() {
  const modalBackdrop = document.getElementById('quickViewModal');
  const closeBtn = document.getElementById('modalCloseBtn');

  const modalTypeBadge = document.getElementById('modalTypeBadge');
  const modalTitle = document.getElementById('modalTitle');
  const modalSeller = document.getElementById('modalSeller');
  const modalRating = document.getElementById('modalRating');
  const modalPrice = document.getElementById('modalPrice');
  const modalAddress = document.getElementById('modalAddress');
  const modalHours = document.getElementById('modalHours');
  const modalDesc = document.getElementById('modalDesc');
  const modalImg = document.getElementById('modalImg');
  const modalCtaText = document.getElementById('modalCtaText');
  const modalInternalChatBtn = document.getElementById('modalInternalChatBtn');

  if (!modalBackdrop) return;

  function openDetailModal(data) {
    if (modalTypeBadge) {
      modalTypeBadge.textContent = (data.type === 'store') ? 'Profil Lapak UMKM' : 'Detail Menu Kuliner';
    }
    if (modalTitle) modalTitle.textContent = data.title || '-';
    if (modalSeller) modalSeller.textContent = data.seller || '-';
    if (modalRating) modalRating.textContent = data.rating ? `★ ${data.rating}` : '';
    if (modalPrice) modalPrice.textContent = data.price || '-';
    if (modalAddress) modalAddress.textContent = data.address || 'Area Kampus Polibatam';
    if (modalHours) modalHours.textContent = data.hours || 'Buka Hari Ini (08.00 - 17.00 WIB)';
    if (modalDesc) modalDesc.textContent = data.desc || 'Pilihan jajanan lezat dari mitra UMKM lokal sekitar kampus.';
    if (modalImg) {
      modalImg.src = data.image || '';
      modalImg.alt = data.title || 'Foto';
    }

    const sellerTarget = (data.type === 'store') ? data.title : data.seller;
    if (modalCtaText) {
      modalCtaText.textContent = (data.type === 'store') ? `Mulai Chat dengan ${data.title}` : `Tanya Menu via Chat Internal`;
    }

    if (modalInternalChatBtn) {
      modalInternalChatBtn.setAttribute('data-seller', sellerTarget);
      modalInternalChatBtn.onclick = () => {
        closeModal();

        // 1. Pindah ke Tab Chat
        if (typeof switchDashboardTab === 'function') {
          switchDashboardTab('tab-chat');
        } else {
          window.location.hash = 'chat';
        }

        // 2. Aktifkan ruang obrolan dengan seller yang sesuai
        setTimeout(() => {
          let foundConvo = false;
          const convoItems = document.querySelectorAll('.chat-convo-item');
          convoItems.forEach(item => {
            const seller = (item.getAttribute('data-seller') || '').toLowerCase();
            if (!foundConvo && seller.includes(sellerTarget.toLowerCase())) {
              item.click();
              foundConvo = true;
            }
          });

          // 3. Fokus pada input chat
          const inputEl = document.getElementById('activeChatMessageInput');
          if (inputEl) {
            inputEl.placeholder = `Tulis pesan ke ${sellerTarget}...`;
            inputEl.focus();
          }
        }, 150);
      };
    }

    modalBackdrop.classList.add('is-open');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modalBackdrop.classList.remove('is-open');
    document.body.style.overflow = '';
  }

  // Klik pada Kartu Etalase Menu
  const menuCards = document.querySelectorAll('.menu-mini-card');
  menuCards.forEach((card) => {
    card.addEventListener('click', () => {
      const data = {
        type: 'menu',
        title: card.getAttribute('data-title'),
        seller: card.getAttribute('data-seller'),
        price: card.getAttribute('data-price'),
        rating: card.getAttribute('data-rating'),
        desc: card.getAttribute('data-desc'),
        image: card.getAttribute('data-image'),
        address: 'Tersedia di Lapak ' + (card.getAttribute('data-seller') || 'Mitra Kampus'),
        hours: 'Pesan & Konfirmasi Langsung via Chat Internal',
      };
      openDetailModal(data);
    });
  });

  // Klik pada Kartu Profil Lapak UMKM
  const storeCards = document.querySelectorAll('.store-mini-card');
  storeCards.forEach((card) => {
    card.addEventListener('click', () => {
      const name = card.getAttribute('data-title');
      const address = card.getAttribute('data-address') || 'Area Kampus Polibatam';
      const hours = card.getAttribute('data-hours') || '08.00 - 17.00 WIB';
      const status = card.getAttribute('data-status') || 'Buka Sekarang';
      const rating = card.getAttribute('data-rating') || '4.8';
      const reviews = card.getAttribute('data-reviews') || '50';
      const img = card.querySelector('.store-mini-img')?.src || '';

      const data = {
        type: 'store',
        title: name,
        seller: 'Mitra Resmi UMKM Kampus Polibatam',
        price: status,
        rating: `${rating} (${reviews} Ulasan)`,
        address: address,
        hours: `Jam Operasional: ${hours}`,
        desc: `Kunjungi ${name} di ${address}. Mitra kuliner terverifikasi yang menyajikan aneka hidangan lezat dan higienis untuk civitas akademika Polibatam.`,
        image: img,
      };
      openDetailModal(data);
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
 * Helper: Toast Notification Sederhana
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
    <i class='bx bx-check-circle' style="color: #2E8B3D; font-size: 1.25rem;"></i>
    <span>${message}</span>
  `;

  container.appendChild(toast);
  requestAnimationFrame(() => toast.classList.add('show'));

  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
  }, 2800);
}

/**
 * 4. Sistem Modal Penilaian & Ulasan (Standar In-Scope UC-04)
 */
function initReviewModalSystem() {
  const backdrop = document.getElementById('reviewModalBackdrop');
  const closeBtn = document.getElementById('btnReviewClose');
  const skipBtn = document.getElementById('btnReviewSkip');
  const starBtns = document.querySelectorAll('.star-btn');
  const ratingInput = document.getElementById('reviewRatingInput');
  const ratingHint = document.getElementById('starRatingHint');

  const hints = {
    1: '1 dari 5 Bintang (Kurang Memuaskan)',
    2: '2 dari 5 Bintang (Cukup)',
    3: '3 dari 5 Bintang (Lumayan Baik)',
    4: '4 dari 5 Bintang (Enak & Puas)',
    5: '5 dari 5 Bintang (Sangat Enak & Puas)'
  };

  starBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const val = parseInt(btn.getAttribute('data-value'), 10);
      if (ratingInput) ratingInput.value = val;
      if (ratingHint) ratingHint.textContent = hints[val] || '';

      starBtns.forEach(b => {
        const bVal = parseInt(b.getAttribute('data-value'), 10);
        b.classList.toggle('active', bVal <= val);
      });
    });
  });

  if (closeBtn) closeBtn.addEventListener('click', closeReviewModal);
  if (skipBtn) skipBtn.addEventListener('click', closeReviewModal);

  if (backdrop) {
    backdrop.addEventListener('click', (e) => {
      if (e.target === backdrop) closeReviewModal();
    });
  }

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && backdrop && backdrop.classList.contains('open')) {
      closeReviewModal();
    }
  });
}

window.openReviewModal = function(context) {
  const backdrop = document.getElementById('reviewModalBackdrop');
  const sellerSub = document.getElementById('reviewModalSeller');
  
  let targetSeller = 'Warung Bu Nita';
  if (context && context.seller) {
    targetSeller = context.seller;
  } else {
    const activeItem = document.querySelector('.chat-convo-item.active');
    if (activeItem) {
      targetSeller = activeItem.getAttribute('data-seller') || 'Warung Bu Nita';
    }
  }

  if (sellerSub) {
    sellerSub.textContent = targetSeller;
  }

  // Reset star rating to 5
  const ratingInput = document.getElementById('reviewRatingInput');
  const ratingHint = document.getElementById('starRatingHint');
  const starBtns = document.querySelectorAll('.star-btn');
  if (ratingInput) ratingInput.value = 5;
  if (ratingHint) ratingHint.textContent = '5 dari 5 Bintang (Sangat Enak & Puas)';
  starBtns.forEach(b => b.classList.add('active'));

  const textInput = document.getElementById('reviewTextInput');
  if (textInput) textInput.value = '';

  if (backdrop) {
    backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
};

window.closeReviewModal = function() {
  const backdrop = document.getElementById('reviewModalBackdrop');
  if (backdrop) {
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
  }
};
