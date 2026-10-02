/**
 * JajanRia Internal Chat & Review Script (UC-03 & UC-04)
 * Pure Vanilla JavaScript (Client-side interactive state)
 */

document.addEventListener('DOMContentLoaded', () => {
  initInternalChat();
  initReviewModal();
});

let currentOrderStatus = 'pending'; // 'pending' | 'processing' | 'completed'

function initInternalChat() {
  const backdrop = document.getElementById('internalChatBackdrop');
  const closeBtn = document.getElementById('internalChatCloseBtn');
  const form = document.getElementById('chatMessageForm');
  const input = document.getElementById('chatMessageInput');
  const messagesContainer = document.getElementById('chatMessagesContainer');
  const quickChips = document.querySelectorAll('.quick-chip');
  const sendInquiryBtn = document.getElementById('btnSendProductInquiry');
  const statusCycleBtn = document.getElementById('chatSimulateSellerStatusBtn');
  const triggerReviewBtn = document.getElementById('btnTriggerReview');

  if (!backdrop) return;

  // Open Chat from any element with class .btn-open-chat or inside quick-view modal
  document.addEventListener('click', (e) => {
    const trigger = e.target.closest('.btn-open-chat, [data-action="chat"]');
    if (trigger) {
      e.preventDefault();
      const seller = trigger.getAttribute('data-seller') || 'Warung Bu Nita';
      const title = trigger.getAttribute('data-title') || 'Nasi Goreng Spesial';
      const price = trigger.getAttribute('data-price') || 'Rp 12.000';
      const img = trigger.getAttribute('data-image') || 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=200&auto=format&fit=crop&q=80';

      openInternalChat({ seller, title, price, img });
    }
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', closeInternalChat);
  }

  backdrop.addEventListener('click', (e) => {
    if (e.target === backdrop) {
      closeInternalChat();
    }
  });

  // Send message
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const text = input.value.trim();
      if (!text) return;

      appendChatMessage(text, 'sent');
      input.value = '';

      // Simulate seller auto-reply
      simulateSellerReply();
    });
  }

  // Quick reply chips
  quickChips.forEach(chip => {
    chip.addEventListener('click', () => {
      const msg = chip.getAttribute('data-msg');
      if (msg) {
        appendChatMessage(msg, 'sent');
        simulateSellerReply();
      }
    });
  });

  // Send Product Inquiry Context
  if (sendInquiryBtn) {
    sendInquiryBtn.addEventListener('click', () => {
      const title = document.getElementById('chatProductTitle')?.textContent || 'Menu Jajanan';
      const price = document.getElementById('chatProductPrice')?.textContent || '';
      appendChatMessage(`Halo, saya tertarik dengan menu: ${title} (${price}). Apakah siap dipesan sekarang?`, 'sent');
      simulateSellerReply();
    });
  }

  // Status Cycle Simulator (UC-03 / UC-07)
  if (statusCycleBtn) {
    statusCycleBtn.addEventListener('click', () => {
      cycleOrderStatus();
    });
  }

  // Trigger review modal button
  if (triggerReviewBtn) {
    triggerReviewBtn.addEventListener('click', () => {
      openReviewModal();
    });
  }
}

function openInternalChat(context) {
  const backdrop = document.getElementById('internalChatBackdrop');
  const sellerName = document.getElementById('chatSellerName');
  const prodTitle = document.getElementById('chatProductTitle');
  const prodPrice = document.getElementById('chatProductPrice');
  const prodImg = document.getElementById('chatProductImg');
  const messagesContainer = document.getElementById('chatMessagesContainer');

  if (sellerName && context.seller) sellerName.textContent = context.seller;
  if (prodTitle && context.title) prodTitle.textContent = context.title;
  if (prodPrice && context.price) prodPrice.textContent = context.price;
  if (prodImg && context.img) prodImg.src = context.img;

  // Reset status to pending
  setOrderStatus('pending');

  if (backdrop) {
    backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
  }

  // Pre-seed conversation if empty
  if (messagesContainer && messagesContainer.querySelectorAll('.chat-bubble').length === 0) {
    setTimeout(() => {
      appendChatMessage(`Halo kak! Selamat datang di chat lapak ${context.seller || 'kami'}. Ada yang bisa kami siapkan?`, 'received');
    }, 400);
  }
}

function closeInternalChat() {
  const backdrop = document.getElementById('internalChatBackdrop');
  if (backdrop) {
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
  }
}

function appendChatMessage(text, type) {
  const container = document.getElementById('chatMessagesContainer');
  if (!container) return;

  const now = new Date();
  const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

  const bubble = document.createElement('div');
  bubble.className = `chat-bubble ${type}`;
  bubble.innerHTML = `
    <div>${escapeHtml(text)}</div>
    <span class="chat-bubble-time">${timeStr}</span>
  `;

  container.appendChild(bubble);
  container.scrollTop = container.scrollHeight;
}

function simulateSellerReply() {
  setTimeout(() => {
    if (currentOrderStatus === 'pending') {
      appendChatMessage('Baik kak, pesanan dicatat dan segera kami proses ya! Mohon tunggu sebentar.', 'received');
      setOrderStatus('processing');
    } else if (currentOrderStatus === 'processing') {
      appendChatMessage('Pesanan sudah selesai disiapkan dan siap diambil/diantar! Silakan cek dan nikmati ya kak.', 'received');
      setOrderStatus('completed');
    } else {
      appendChatMessage('Sama-sama kak! Terima kasih banyak sudah jajan di lapak kami, ditunggu pesanan selanjutnya!', 'received');
    }
  }, 900);
}

function cycleOrderStatus() {
  if (currentOrderStatus === 'pending') {
    setOrderStatus('processing');
    appendChatMessage('Info Penjual: Status pesanan diubah menjadi "Sedang Diproses" 🍳', 'received');
  } else if (currentOrderStatus === 'processing') {
    setOrderStatus('completed');
    appendChatMessage('Info Penjual: Pesanan telah selesai disiapkan! Silakan beri penilaian ulasan.', 'received');
  } else {
    setOrderStatus('pending');
  }
}

function setOrderStatus(status) {
  currentOrderStatus = status;
  const statusIcon = document.getElementById('statusIcon');
  const statusText = document.getElementById('chatStatusText');
  const triggerReviewBtn = document.getElementById('btnTriggerReview');

  if (!statusText) return;

  if (status === 'processing') {
    statusText.textContent = 'Pesanan Sedang Diproses Penjual';
    statusText.style.color = '#B45309';
    if (statusIcon) statusIcon.className = 'bx bx-loader-alt bx-spin status-icon';
    if (triggerReviewBtn) triggerReviewBtn.style.display = 'none';
  } else if (status === 'completed') {
    statusText.textContent = 'Pesanan Selesai Dilayani';
    statusText.style.color = '#15803D';
    if (statusIcon) statusIcon.className = 'bx bx-check-circle status-icon';
    // Show Beri Penilaian button (UC-04 / F008)
    if (triggerReviewBtn) triggerReviewBtn.style.display = 'inline-flex';
  } else {
    statusText.textContent = 'Menunggu Konfirmasi Seller';
    statusText.style.color = '#14532D';
    if (statusIcon) statusIcon.className = 'bx bx-dish status-icon';
    if (triggerReviewBtn) triggerReviewBtn.style.display = 'none';
  }
}

/**
 * 2. Review Modal Logic (UC-04)
 */
function initReviewModal() {
  const backdrop = document.getElementById('reviewModalBackdrop');
  const closeBtn = document.getElementById('btnReviewClose');
  const skipBtn = document.getElementById('btnReviewSkip');
  const form = document.getElementById('reviewSubmitForm');
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

  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const rating = ratingInput ? ratingInput.value : '5';
      const text = document.getElementById('reviewTextInput')?.value.trim() || 'Jajanan mantap porsi pas!';
      const seller = document.getElementById('chatSellerName')?.textContent || 'Warung Bu Nita';

      // Save to localStorage simulation
      try {
        const reviews = JSON.parse(localStorage.getItem('jajanria_saved_reviews') || '[]');
        reviews.unshift({
          seller,
          rating,
          text,
          user: "Muhammad Rifa'a",
          date: 'Hari ini'
        });
        localStorage.setItem('jajanria_saved_reviews', JSON.stringify(reviews));
      } catch (err) {
        console.warn('Storage failed', err);
      }

      closeReviewModal();

      // Show toast
      if (typeof showToast === 'function') {
        showToast(`Penilaian bintang ${rating} berhasil dikirim! Terima kasih atas ulasannya.`);
      } else {
        alert(`Penilaian bintang ${rating} berhasil dikirim!`);
      }

      // Add feedback to chat
      appendChatMessage(`Penilaian Terkirim: ★ ${rating}/5 - "${text}"`, 'sent');
    });
  }
}

function openReviewModal() {
  const backdrop = document.getElementById('reviewModalBackdrop');
  const sellerSub = document.getElementById('reviewModalSeller');
  const currentSeller = document.getElementById('chatSellerName')?.textContent;

  if (sellerSub && currentSeller) {
    sellerSub.textContent = currentSeller;
  }

  if (backdrop) {
    backdrop.classList.add('open');
  }
}

function closeReviewModal() {
  const backdrop = document.getElementById('reviewModalBackdrop');
  if (backdrop) {
    backdrop.classList.remove('open');
  }
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
