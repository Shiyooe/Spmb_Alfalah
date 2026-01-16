<?php
session_start();

// Hapus semua session variables
session_unset();

// Hancurkan session
session_destroy();

// Hapus cookie session jika ada
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - SPMB Alfalah</title>
    <link rel="stylesheet" href="css/logout.css">
</head>
<body>
    <div class="container">
        <div class="glass-card">
            <div class="icon-container">
                <svg viewBox="0 0 52 52">
                    <path class="checkmark-path" d="M14 27l7 7 16-16"/>
                </svg>
            </div>
            
            <h1>Logout Berhasil!</h1>
            <p>Anda telah keluar dari sistem SPMB Alfalah.<br>Terima kasih telah menggunakan layanan kami.</p>
            
            <div class="countdown">
                Redirect dalam <span id="timer">3</span> detik...
            </div>
            
            <a href="log/mail/login.php" class="btn">Login Kembali</a>
        </div>
    </div>

    <script>
        // Countdown timer
        let seconds = 3;
        const timerElement = document.getElementById('timer');
        
        const countdown = setInterval(() => {
            seconds--;
            timerElement.textContent = seconds;
            
            if (seconds <= 0) {
                clearInterval(countdown);
                window.location.href = '../index.php';
            }
        }, 1000);
    </script>
</body>
</html>