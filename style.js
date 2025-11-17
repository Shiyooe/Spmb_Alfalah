    const form = document.getElementById("loginForm");
    const msg = document.getElementById("msg");
    const toggle = document.getElementById("togglePass");
    const pass = document.getElementById("password");
    const ident = document.getElementById("identifier");

    // Toggle password visibility
    toggle.addEventListener("click", () => {
      const shown = pass.type === "text";
      pass.type = shown ? "password" : "text";
      toggle.textContent = shown ? "Tampilkan" : "Sembunyikan";
    });

    // Form submit handler
    form.addEventListener("submit", async (e) => {
      e.preventDefault();
      
      // Reset error message
      msg.style.display = "none";
      msg.textContent = "";

      const identifier = ident.value.trim();
      const password = pass.value;

      // Client-side validation
      if (!identifier) {
        msg.textContent = "Masukkan email atau username.";
        msg.style.display = "block";
        ident.focus();
        return;
      }
      if (!password) {
        msg.textContent = "Masukkan kata sandi.";
        msg.style.display = "block";
        pass.focus();
        return;
      }

      // Button loading state
      const submitBtn = form.querySelector('button[type="submit"]');
      const originalBtnText = submitBtn.textContent;
      submitBtn.disabled = true;
      submitBtn.textContent = "Memproses...";

      try {
        // Prepare form data
        const formData = new FormData();
        formData.append('identifier', identifier);
        formData.append('password', password);

        // Send request to server
        const response = await fetch('../proseslogin.php', {
          method: 'POST',
          body: formData
        });

        // Parse response
        const data = await response.json();

        if (data.success) {
          // Login successful - redirect
          window.location.href = data.redirect;
        } else {
          // Login failed - show error message
          msg.textContent = data.message || 'Login gagal. Silakan coba lagi.';
          msg.style.display = "block";
        }
      } catch (error) {
        console.error("Error:", error);
        msg.textContent = "Terjadi kesalahan koneksi. Silakan coba lagi.";
        msg.style.display = "block";
      } finally {
        // Restore button state
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
      }
    });