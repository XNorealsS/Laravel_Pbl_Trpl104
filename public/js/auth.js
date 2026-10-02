/**
 * JajanRia Authentication Script (Pure Frontend / No Backend Required)
 * UC-01: Autentikasi Pengunjung (Google Firebase), Seller & Admin (Email/Password)
 * Zero emojis, 100% Boxicons, clean & maintainable
 */

document.addEventListener('DOMContentLoaded', () => {
  initURLParams();
  initRoleSwitcher();
  initModeTabs();
  initPasswordToggles();
  initQuickDemoButtons();
  initAuthFormSubmit();
  initGoogleLogin();
  initForgotPasswordModal();
});

// Current State: 'mahasiswa' | 'mitra' | 'admin'
let currentRole = 'mahasiswa';
let currentMode = 'login';     // 'login' | 'register'

/**
 * 1. Read URL Parameters for auto-configuration
 */
function initURLParams() {
  const params = new URLSearchParams(window.location.search);
  const hash = window.location.hash;

  if (params.get('role') === 'mitra') {
    selectRole('mitra');
  } else if (params.get('role') === 'admin') {
    selectRole('admin');
  }

  if (params.get('tab') === 'register' || hash === '#register') {
    switchMode('register');
  }

  if (params.get('demo') === 'true') {
    setTimeout(() => {
      quickFillMahasiswa();
    }, 400);
  }
}

/**
 * 2. Role Switcher (Pengunjung vs Seller UMKM vs Admin)
 */
function initRoleSwitcher() {
  const roleBtns = document.querySelectorAll('.role-tab-btn');
  roleBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const role = btn.getAttribute('data-role');
      selectRole(role);
    });
  });
}

function selectRole(role) {
  currentRole = role;
  const roleBtns = document.querySelectorAll('.role-tab-btn');
  roleBtns.forEach(btn => {
    btn.classList.toggle('active', btn.getAttribute('data-role') === role);
  });

  const emailLabel = document.getElementById('emailLabel');
  const emailInput = document.getElementById('authEmail');
  const demoTitle = document.getElementById('demoBoxTitle');
  const demoSub = document.getElementById('demoBoxSub');
  const demoFillBtn = document.getElementById('btnQuickFill');
  const googleBtn = document.getElementById('googleLoginBtn');
  const authDivider = document.getElementById('authDivider');
  const tabRegister = document.getElementById('tabRegisterBtn');

  if (role === 'mitra') {
    if (emailLabel) emailLabel.textContent = 'Email Usaha / No. WhatsApp Mitra';
    if (emailInput) emailInput.placeholder = 'contoh: mitra.bunita@jajanria.com';
    if (demoTitle) demoTitle.textContent = 'Akun Demo Seller UMKM';
    if (demoSub) demoSub.textContent = 'Warung Bu Nita (Mitra Terverifikasi)';
    if (demoFillBtn) demoFillBtn.setAttribute('data-target-role', 'mitra');
    if (googleBtn) googleBtn.style.display = 'none';
    if (authDivider) authDivider.style.display = 'none';
    if (tabRegister) tabRegister.style.display = 'block';
  } else if (role === 'admin') {
    if (emailLabel) emailLabel.textContent = 'Email Administrator JajanRia';
    if (emailInput) emailInput.placeholder = 'contoh: admin@jajanria.polibatam.ac.id';
    if (demoTitle) demoTitle.textContent = 'Akun Demo Administrator';
    if (demoSub) demoSub.textContent = 'Pengelola Utama Platform JajanRia';
    if (demoFillBtn) demoFillBtn.setAttribute('data-target-role', 'admin');
    if (googleBtn) googleBtn.style.display = 'none';
    if (authDivider) authDivider.style.display = 'none';
    if (tabRegister) tabRegister.style.display = 'none'; // Admin akun khusus
    switchMode('login');
  } else {
    // Pengunjung
    if (emailLabel) emailLabel.textContent = 'Email Mahasiswa / NIM';
    if (emailInput) emailInput.placeholder = 'contoh: rifaa@student.polibatam.ac.id';
    if (demoTitle) demoTitle.textContent = 'Akun Demo Pengunjung';
    if (demoSub) demoSub.textContent = "Muhammad Rifa'a (Mahasiswa TRPL)";
    if (demoFillBtn) demoFillBtn.setAttribute('data-target-role', 'mahasiswa');
    if (googleBtn) googleBtn.style.display = 'flex';
    if (authDivider) authDivider.style.display = 'flex';
    if (tabRegister) tabRegister.style.display = 'block';
  }

  clearErrors();
}

/**
 * 3. Mode Switcher (Login vs Register)
 */
function initModeTabs() {
  const modeTabs = document.querySelectorAll('.auth-mode-tab');
  modeTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const mode = tab.getAttribute('data-mode');
      switchMode(mode);
    });
  });

  // Prompt link switch
  const switchPromptLink = document.getElementById('switchPromptLink');
  if (switchPromptLink) {
    switchPromptLink.addEventListener('click', (e) => {
      e.preventDefault();
      switchMode(currentMode === 'login' ? 'register' : 'login');
    });
  }
}

function switchMode(mode) {
  currentMode = mode;
  const modeTabs = document.querySelectorAll('.auth-mode-tab');
  modeTabs.forEach(tab => {
    tab.classList.toggle('active', tab.getAttribute('data-mode') === mode);
  });

  const title = document.getElementById('authHeaderTitle');
  const subtitle = document.getElementById('authHeaderSub');
  const submitText = document.getElementById('submitBtnText');
  const registerFields = document.getElementById('registerFieldsGroup');
  const registerConfirm = document.getElementById('registerConfirmGroup');
  const loginHelperRow = document.getElementById('loginHelperRow');
  const demoBox = document.getElementById('quickDemoBox');
  const googleBtn = document.getElementById('googleLoginBtn');
  const authDivider = document.getElementById('authDivider');
  const switchText = document.getElementById('switchPromptText');
  const switchLink = document.getElementById('switchPromptLink');

  if (mode === 'register') {
    if (title) title.textContent = 'Daftar Akun Baru';
    if (subtitle) subtitle.textContent = 'Bergabunglah untuk memesan jajanan hemat dan terdekat.';
    if (submitText) submitText.textContent = 'Daftar Sekarang';
    if (registerFields) registerFields.style.display = 'block';
    if (registerConfirm) registerConfirm.style.display = 'block';
    if (loginHelperRow) loginHelperRow.style.display = 'none';
    if (demoBox) demoBox.style.display = 'none';
    if (googleBtn) googleBtn.style.display = 'none';
    if (authDivider) authDivider.style.display = 'none';
    if (switchText) switchText.textContent = 'Sudah memiliki akun JajanRia?';
    if (switchLink) switchLink.textContent = 'Masuk Sekarang';
  } else {
    if (title) title.textContent = 'Selamat Datang Kembali';
    if (subtitle) subtitle.textContent = 'Masuk untuk menikmati aneka jajanan favoritmu.';
    if (submitText) submitText.textContent = 'Masuk ke Dashboard';
    if (registerFields) registerFields.style.display = 'none';
    if (registerConfirm) registerConfirm.style.display = 'none';
    if (loginHelperRow) loginHelperRow.style.display = 'flex';
    if (demoBox) demoBox.style.display = 'flex';
    if (currentRole === 'mahasiswa') {
      if (googleBtn) googleBtn.style.display = 'flex';
      if (authDivider) authDivider.style.display = 'flex';
    }
    if (switchText) switchText.textContent = 'Belum punya akun JajanRia?';
    if (switchLink) switchLink.textContent = 'Daftar Gratis';
  }

  clearErrors();
}

/**
 * 4. Password Visibility Toggles
 */
function initPasswordToggles() {
  const toggleBtns = document.querySelectorAll('.input-toggle-pwd');
  toggleBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.getAttribute('data-target');
      const input = document.getElementById(targetId);
      if (!input) return;

      const isPassword = input.type === 'password';
      input.type = isPassword ? 'text' : 'password';

      // Switch Boxicon
      btn.innerHTML = isPassword
        ? `<i class='bx bx-hide'></i>`
        : `<i class='bx bx-show'></i>`;
    });
  });
}

/**
 * 5. Quick Demo Login Autofill
 */
function initQuickDemoButtons() {
  const demoFillBtn = document.getElementById('btnQuickFill');
  if (demoFillBtn) {
    demoFillBtn.addEventListener('click', () => {
      const target = demoFillBtn.getAttribute('data-target-role') || currentRole;
      if (target === 'admin') {
        quickFillAdmin();
      } else if (target === 'mitra') {
        quickFillMitra();
      } else {
        quickFillMahasiswa();
      }
    });
  }
}

function quickFillMahasiswa() {
  const emailInput = document.getElementById('authEmail');
  const passInput = document.getElementById('authPassword');
  if (emailInput) emailInput.value = 'rifaa@student.polibatam.ac.id';
  if (passInput) passInput.value = 'demo12345';

  clearErrors();
  showAuthToast('Akun demo Mahasiswa terisi otomatis. Mengalihkan ke Dashboard Katalog...');
  executeLoginSimulation("Muhammad Rifa'a", '/dashboard');
}

function quickFillMitra() {
  const emailInput = document.getElementById('authEmail');
  const passInput = document.getElementById('authPassword');
  if (emailInput) emailInput.value = 'mitra.bunita@jajanria.com';
  if (passInput) passInput.value = 'mitra12345';

  clearErrors();
  showAuthToast('Akun demo Seller terisi otomatis. Mengalihkan ke Dashboard Seller...');
  executeLoginSimulation('Warung Bu Nita (Seller)', '/seller');
}

function quickFillAdmin() {
  const emailInput = document.getElementById('authEmail');
  const passInput = document.getElementById('authPassword');
  if (emailInput) emailInput.value = 'admin@jajanria.polibatam.ac.id';
  if (passInput) passInput.value = 'admin12345';

  clearErrors();
  showAuthToast('Akun demo Admin terisi otomatis. Mengalihkan ke Panel Admin...');
  executeLoginSimulation('Administrator JajanRia', '/admin');
}

/**
 * 6. Auth Form Submission (Login & Register)
 */
function initAuthFormSubmit() {
  const form = document.getElementById('authMainForm');
  if (!form) return;

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    clearErrors();

    if (currentMode === 'login') {
      handleLoginSubmit();
    } else {
      handleRegisterSubmit();
    }
  });
}

function handleLoginSubmit() {
  const emailInput = document.getElementById('authEmail');
  const passInput = document.getElementById('authPassword');

  let hasError = false;

  if (!emailInput.value.trim()) {
    showFieldError('authEmail', 'Harap masukkan Email atau NIM Anda.');
    hasError = true;
  }

  if (!passInput.value.trim()) {
    showFieldError('authPassword', 'Harap masukkan kata sandi Anda.');
    hasError = true;
  } else if (passInput.value.length < 5) {
    showFieldError('authPassword', 'Kata sandi minimal 5 karakter.');
    hasError = true;
  }

  if (hasError) return;

  const displayName = emailInput.value.includes('@')
    ? emailInput.value.split('@')[0]
    : emailInput.value;

  const redirectUrl = currentRole === 'admin' ? '/admin' : (currentRole === 'mitra' ? '/seller' : '/dashboard');
  executeLoginSimulation(displayName, redirectUrl);
}

function handleRegisterSubmit() {
  const nameInput = document.getElementById('registerName');
  const emailInput = document.getElementById('authEmail');
  const passInput = document.getElementById('authPassword');
  const passConfirmInput = document.getElementById('registerPasswordConfirm');

  let hasError = false;

  if (!nameInput.value.trim()) {
    showFieldError('registerName', 'Nama lengkap wajib diisi.');
    hasError = true;
  }

  if (!emailInput.value.trim()) {
    showFieldError('authEmail', 'Email kampus / No. WhatsApp wajib diisi.');
    hasError = true;
  }

  if (!passInput.value.trim()) {
    showFieldError('authPassword', 'Kata sandi wajib diisi.');
    hasError = true;
  } else if (passInput.value.length < 6) {
    showFieldError('authPassword', 'Kata sandi minimal 6 karakter.');
    hasError = true;
  }

  if (passConfirmInput && passInput.value !== passConfirmInput.value) {
    showFieldError('registerPasswordConfirm', 'Konfirmasi kata sandi tidak cocok.');
    hasError = true;
  }

  if (hasError) return;

  const submitBtn = document.getElementById('authSubmitBtn');
  const spinner = document.getElementById('btnSpinner');
  const btnText = document.getElementById('submitBtnText');

  submitBtn.disabled = true;
  spinner.style.display = 'inline-block';
  btnText.textContent = 'Mendaftarkan Akun...';

  setTimeout(() => {
    submitBtn.disabled = false;
    spinner.style.display = 'none';
    btnText.textContent = 'Daftar Sekarang';

    showAuthToast('Pendaftaran akun baru berhasil! Silakan masuk.');
    switchMode('login');

    const loginEmailInput = document.getElementById('authEmail');
    if (loginEmailInput) loginEmailInput.value = emailInput.value;
  }, 800);
}

function executeLoginSimulation(userName, targetUrl) {
  const submitBtn = document.getElementById('authSubmitBtn');
  const spinner = document.getElementById('btnSpinner');
  const btnText = document.getElementById('submitBtnText');

  submitBtn.disabled = true;
  spinner.style.display = 'inline-block';
  btnText.textContent = 'Memverifikasi...';

  const destination = targetUrl || (currentRole === 'admin' ? '/admin' : (currentRole === 'mitra' ? '/seller' : '/dashboard'));

  // Save session profile locally (simulated auth)
  try {
    localStorage.setItem('jajanria_auth_user', JSON.stringify({
      name: userName,
      role: currentRole,
      email: document.getElementById('authEmail').value,
      isLoggedIn: true,
      loginAt: new Date().toISOString()
    }));
  } catch (err) {
    console.warn('Storage unavailable', err);
  }

  setTimeout(() => {
    btnText.textContent = 'Berhasil Masuk!';
    showAuthToast(`Selamat datang kembali, ${userName}! Mengalihkan...`);

    setTimeout(() => {
      window.location.href = destination;
    }, 700);
  }, 650);
}

/**
 * 7. Google OAuth Simulation (Firebase Auth for Customer / UC-01)
 */
function initGoogleLogin() {
  const googleBtn = document.getElementById('googleLoginBtn');
  if (!googleBtn) return;

  googleBtn.addEventListener('click', () => {
    googleBtn.disabled = true;
    googleBtn.innerHTML = `
      <i class='bx bx-loader-alt bx-spin' style='font-size: 1.2rem; color: #4285F4;'></i>
      <span>Menghubungkan Firebase Authentication...</span>
    `;

    setTimeout(() => {
      showAuthToast('Berhasil terotentikasi via Google Firebase Sign-In!');
      executeLoginSimulation("Muhammad Rifa'a (Google)", '/dashboard');
    }, 850);
  });
}

/**
 * 8. Forgot Password Modal
 */
function initForgotPasswordModal() {
  const openLink = document.getElementById('forgotPwdLink');
  const modal = document.getElementById('forgotPwdModal');
  const cancelBtn = document.getElementById('btnCancelForgot');
  const confirmBtn = document.getElementById('btnConfirmForgot');
  const inputEmail = document.getElementById('forgotEmailInput');

  if (!openLink || !modal) return;

  openLink.addEventListener('click', (e) => {
    e.preventDefault();
    modal.classList.add('open');
    if (inputEmail) inputEmail.focus();
  });

  if (cancelBtn) {
    cancelBtn.addEventListener('click', () => {
      modal.classList.remove('open');
    });
  }

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.remove('open');
    }
  });

  if (confirmBtn) {
    confirmBtn.addEventListener('click', () => {
      const email = inputEmail ? inputEmail.value.trim() : '';
      if (!email) {
        alert('Harap masukkan alamat email akun Anda.');
        return;
      }

      modal.classList.remove('open');
      showAuthToast(`Instruksi reset kata sandi telah dikirim ke: ${email}`);
    });
  }
}

/**
 * Field Error Helpers
 */
function showFieldError(inputId, message) {
  const input = document.getElementById(inputId);
  if (!input) return;

  input.classList.add('has-error');
  const errorMsg = document.getElementById(`${inputId}Error`);
  if (errorMsg) {
    errorMsg.textContent = message;
    errorMsg.style.display = 'block';
  }
}

function clearErrors() {
  const inputs = document.querySelectorAll('.form-input');
  inputs.forEach(input => input.classList.remove('has-error'));

  const errorMsgs = document.querySelectorAll('.field-error-msg');
  errorMsgs.forEach(msg => {
    msg.style.display = 'none';
    msg.textContent = '';
  });
}

/**
 * Global Toast Helper
 */
function showAuthToast(message) {
  let container = document.getElementById('authToastContainer');
  if (!container) {
    container = document.createElement('div');
    container.id = 'authToastContainer';
    container.style.cssText = `
      position: fixed;
      top: 24px;
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
    border-radius: var(--radius-full, 9999px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    font-size: 0.9rem;
    font-weight: 600;
    font-family: 'Plus Jakarta Sans', sans-serif;
    display: flex;
    align-items: center;
    gap: 10px;
    opacity: 0;
    transform: translateY(-15px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(46, 139, 61, 0.5);
    pointer-events: auto;
  `;
  toast.innerHTML = `
    <i class='bx bx-check-circle' style='color: #4CAF50; font-size: 1.2rem;'></i>
    <span>${message}</span>
  `;

  container.appendChild(toast);

  requestAnimationFrame(() => {
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';
  });

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(-15px)';
    setTimeout(() => toast.remove(), 350);
  }, 4000);
}
