<?php
// Set headers
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Function untuk response JSON
function sendResponse($success, $message, $redirect = null) {
    $response = ['success' => $success, 'message' => $message];
    if ($redirect) {
        $response['redirect'] = $redirect;
    }
    echo json_encode($response);
    exit;
}

// Check request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Invalid request method');
}

try {
    require_once 'koneksi.php';
    session_start();
    
    // Ambil dan sanitasi input
    $identifier = trim($_POST['identifier'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    // Validasi input kosong
    if (empty($identifier)) {
        sendResponse(false, 'Email/username wajib diisi!');
    }
    
    if (empty($password)) {
        sendResponse(false, 'Password wajib diisi!');
    }
    
    // Validasi panjang minimum password
    if (strlen($password) < 6) {
        sendResponse(false, 'Password minimal 6 karakter!');
    }
    
    // Check admin login
    $adminUsername = 'lf.3!]hSu+^LS@u!Bj4!~^atcjDNIY';
    $adminPassword = 'lf.3!]hSu+^LS@u!Bj4!~^atcjDNIY';
    
    if ($identifier === $adminUsername) {
        if ($password === $adminPassword) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['username'] = $adminUsername;
            $_SESSION['role'] = 'admin';
            sendResponse(true, 'Login admin berhasil', 'admin/login.php');
        } else {
            sendResponse(false, 'Password admin salah!');
        }
    }
    
    // Query user dari database
    $stmt = $pdo->prepare("SELECT id, username, gmail, password FROM users WHERE username = ? OR gmail = ? LIMIT 1");
    $stmt->execute([$identifier, $identifier]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Check user existence
    if (!$user) {
        sendResponse(false, 'Akun tidak ditemukan! Silakan periksa username/email Anda.');
    }
    
    // Verifikasi password
    if ($user['password'] !== $password) {
        sendResponse(false, 'Password yang Anda masukkan salah!');
    }
    
    // Login berhasil - set session
    $_SESSION['user_logged_in'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['gmail'] = $user['gmail'];
    $_SESSION['role'] = 'user';
    
    // PERBAIKAN: Redirect ke brosur/index.php bukan index.php
    sendResponse(true, 'Login berhasil', 'brosur/index.php');
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    sendResponse(false, 'Terjadi kesalahan database.');
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    sendResponse(false, 'Terjadi kesalahan sistem.');
}
?>