<!-- Internal Chat Website Drawer (UC-03: Chat Internal Pengunjung & Seller) -->
<div class="chat-drawer-backdrop" id="internalChatBackdrop">
  <div class="chat-drawer" id="internalChatDrawer" role="dialog" aria-modal="true" aria-labelledby="chatSellerName">
    <!-- Chat Header -->
    <div class="chat-header">
      <div class="chat-seller-info">
        <div class="chat-avatar-wrap">
          <img id="chatSellerAvatar" src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=100&auto=format&fit=crop&q=80" alt="Avatar Penjual">
          <span class="status-indicator online"></span>
        </div>
        <div>
          <h4 class="chat-seller-name" id="chatSellerName">Warung Bu Nita</h4>
          <p class="chat-seller-meta" id="chatSellerMeta">
            <span class="badge-role"><i class='bx bx-store-alt'></i> Mitra UMKM</span>
            <span class="badge-status">Online</span>
          </p>
        </div>
      </div>
      <div class="chat-header-actions">
        <button type="button" class="btn-chat-icon" id="chatSimulateSellerStatusBtn" title="Simulasi: Seller update status pesanan">
          <i class='bx bx-refresh'></i>
        </button>
        <button type="button" class="btn-chat-icon" id="internalChatCloseBtn" aria-label="Tutup Obrolan">
          <i class='bx bx-x'></i>
        </button>
      </div>
    </div>

    <!-- Product Inquiry Context Card -->
    <div class="chat-product-context" id="chatProductContext">
      <img id="chatProductImg" src="https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=200&auto=format&fit=crop&q=80" alt="Produk">
      <div class="context-details">
        <span class="context-label">Menanyakan Produk:</span>
        <h5 class="context-title" id="chatProductTitle">Nasi Goreng Spesial</h5>
        <span class="context-price" id="chatProductPrice">Rp 12.000</span>
      </div>
      <button type="button" class="btn-send-inquiry" id="btnSendProductInquiry">
        <i class='bx bx-send'></i>
        <span>Kirim Info Menu</span>
      </button>
    </div>

    <!-- Order Status Banner (UC-03 & UC-04) -->
    <div class="chat-order-status-bar" id="chatOrderStatusCard">
      <div class="order-status-indicator">
        <i class='bx bx-dish status-icon' id="statusIcon"></i>
        <div class="status-text-wrap">
          <span class="status-sub">Status Pemesanan Chat:</span>
          <strong class="status-main" id="chatStatusText">Menunggu Konfirmasi Seller</strong>
        </div>
      </div>
      <!-- Rating Trigger Button (Will appear when status is 'Selesai') -->
      <button type="button" class="btn-trigger-review" id="btnTriggerReview" style="display: none;">
        <i class='bx bxs-star'></i>
        <span>Beri Penilaian</span>
      </button>
    </div>

    <!-- Chat Messages Scroll Area -->
    <div class="chat-body" id="chatMessagesContainer">
      <div class="chat-time-divider">
        <span>Hari ini</span>
      </div>

      <!-- Welcome System Message -->
      <div class="chat-system-bubble">
        <i class='bx bx-shield-check'></i>
        <span>Chat internal resmi JajanRia. Jaga kesopanan dan lakukan transaksi aman langsung dengan penjual streetfood kampus.</span>
      </div>

      <!-- Messages dynamically injected by JS -->
    </div>

    <!-- Chat Quick Replies -->
    <div class="chat-quick-replies" id="chatQuickReplies">
      <button type="button" class="quick-chip" data-msg="Halo Bu/Pak, apakah menu ini masih tersedia hari ini?">
        Stok masih ada?
      </button>
      <button type="button" class="quick-chip" data-msg="Saya ingin memesan 1 porsi, berapa lama estimasi siap diambil?">
        Berapa lama siap?
      </button>
      <button type="button" class="quick-chip" data-msg="Bisa minta pedas sedang ya dan tolong bungkus.">
        Pedas sedang
      </button>
    </div>

    <!-- Chat Input Area -->
    <form class="chat-footer" id="chatMessageForm">
      <div class="chat-input-wrapper">
        <input
          type="text"
          id="chatMessageInput"
          class="chat-input-field"
          placeholder="Tulis pesan ke penjual..."
          autocomplete="off"
        >
        <button type="submit" class="btn-chat-send" id="btnChatSend" aria-label="Kirim Pesan">
          <i class='bx bx-paper-plane'></i>
        </button>
      </div>
    </form>
  </div>
</div>
