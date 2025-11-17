<?php

session_start();

// Redirect jika sudah login
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header('Location: brosur/index.php');
    exit;
}

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin/index.php');
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>PPDB — Login SMK Al-Falah Bandung Indonesia</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="Tugas PPDB/css/sytle.css" />
  <link rel="icon" type="image/x-icon" href="Tugas PPDB/img/Alfalah.png">
</head>
<body>
  <div class="bg-dekorasi">
    <span class="c1"></span>
    <span class="c2"></span>
    <span class="c3"></span>
  </div>
  <main class="container" role="main">
    <section class="panel-info" aria-labelledby="title">
      <div class="sekolah-title">SMK Al-Falah Bandung Indonesia</div>
      <header>
        <img src="Tugas PPDB/img/Alfalah.png" alt="Logo SMK Al-Falah" class="logo">
        <div>
          <h1>Portal PPDB SMK 2026</h1>
          <div class="small">Penerimaan Peserta Didik Baru — Online</div>
        </div>
      </header>
      <div class="lead" role="note">
        Selamat datang. Silakan masuk untuk melanjutkan pendaftaran. Pastikan data akun Anda benar.
      </div>
    </section>
    
    <section class="card" aria-labelledby="formtitle">
      <h2 id="formtitle" style="margin:0 0 14px 0; color:var(--primary)">Login Akun</h2>
      
      <form id="loginForm" autocomplete="on" novalidate>
        <div>
          <label for="identifier">Email / Username</label>
          <input 
            id="identifier" 
            name="identifier" 
            type="text" 
            inputmode="email" 
            placeholder="contoh@mail.com atau username" 
            autocomplete="username"
            required 
          />
        </div>
        
        <div>
          <label for="password">Kata Sandi</label>
          <div style="display:flex; gap:8px; align-items:center">
            <input 
              id="password" 
              name="password" 
              type="password" 
              placeholder="Masukkan kata sandi" 
              autocomplete="current-password"
              style="flex:1" 
              required 
            />
            <button 
              type="button" 
              class="show-pass" 
              id="togglePass" 
              aria-label="Tampilkan kata sandi"
            >
              Tampilkan
            </button>
          </div>
        </div>
        
        <div class="meta" style="margin-top:4px">
          <label style="display:flex; gap:8px; align-items:center; font-weight:500">
            <input 
              id="remember" 
              name="remember"
              type="checkbox" 
              style="width:16px; height:16px" 
            />
            Ingat saya
          </label>
          <a 
            class="muted-link" 
            href="#" 
            onclick="alert('Fitur lupa sandi belum diaktifkan. Hubungi administrator.'); return false;"
          >
            Lupa kata sandi?
          </a>
        </div>
        
        <div style="display:flex; gap:12px; margin-top:6px; align-items:center">
          <button type="submit" class="btn">Masuk</button>
          <a class="muted-link" href="daftar.php" style="align-self:center">
            Daftar baru
          </a>
        </div>
        
        <div id="msg" class="error" role="alert" style="display:none"></div>
        
        <div class="footer-note">
          Butuh bantuan? Hubungi panitia PPDB atau kontak resmi sekolah.
        </div>
      </form>
    </section>
  </main>

  <script>
    // Get form elements
    const form = document.getElementById("loginForm");
    const msg = document.getElementById("msg");
    const toggle = document.getElementById("togglePass");
    const pass = document.getElementById("password");
    const ident = document.getElementById("identifier");
    
    // Toggle password visibility
    toggle.addEventListener("click", () => {
      const isShown = pass.type === "text";
      pass.type = isShown ? "password" : "text";
      toggle.textContent = isShown ? "Tampilkan" : "Sembunyikan";
      toggle.setAttribute('aria-label', isShown ? 'Tampilkan kata sandi' : 'Sembunyikan kata sandi');
    });
    
    // Form submit handler
    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      
      // Reset error message
      msg.style.display = "none";
      msg.textContent = "";
      msg.classList.remove('error', 'success');
      
      const identifier = ident.value.trim();
      const password = pass.value;
      
      // Client-side validation
      if (!identifier) {
        showMessage("Masukkan email atau username.", "error");
        ident.focus();
        return;
      }
      
      if (!password) {
        showMessage("Masukkan kata sandi.", "error");
        pass.focus();
        return;
      }
      
      if (password.length < 6) {
        showMessage("Password minimal 6 karakter.", "error");
        pass.focus();
        return;
      }
      
      // Button loading state
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn.textContent;
      submitBtn.disabled = true;
      submitBtn.textContent = "Memproses...";
      submitBtn.style.opacity = "0.7";
      
      try {
        // Prepare form data
        const formData = new FormData();
        formData.append('identifier', identifier);
        formData.append('password', password);
        
        // Send request to server
        const response = await fetch('proseslogin.php', {
          method: 'POST',
          body: formData
        });
        
        // Check if response is ok
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        // Parse JSON response
        const data = await response.json();
        
        if (data.success) {
          // Login successful
          showMessage(data.message, "success");
          
          // Redirect after short delay
          setTimeout(() => {
            window.location.href = data.redirect;
          }, 500);
          
        } else {
          // Login failed - show error message
          showMessage(data.message || 'Login gagal. Silakan coba lagi.', "error");
        }
        
      } catch (error) {
        console.error("Login error:", error);
        showMessage("Terjadi kesalahan koneksi. Silakan coba lagi.", "error");
        
      } finally {
        // Restore button state
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
        submitBtn.style.opacity = "1";
      }
    });
    
    // Helper function to show messages
    function showMessage(text, type) {
      msg.textContent = text;
      msg.className = type;
      msg.style.display = "block";
      
      // Auto-hide success messages after 3 seconds
      if (type === "success") {
        setTimeout(() => {
          msg.style.display = "none";
        }, 3000);
      }
    }
    
    // Clear message on input
    ident.addEventListener('input', () => {
      if (msg.style.display === "block") {
        msg.style.display = "none";
      }
    });
    
    pass.addEventListener('input', () => {
      if (msg.style.display === "block") {
        msg.style.display = "none";
      }
    });
  </script>
</body>
</html>