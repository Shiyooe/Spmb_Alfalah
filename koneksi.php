<?php

$host = 'localhost';
$dbname = 'spmb_alfalah';
$username = 'root';
$password = '';

try {
    // Create PDO connection with error mode exception
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    // Log error (jangan tampilkan detail error ke user di production)
    error_log("Connection failed: " . $e->getMessage());
    die("Koneksi database gagal. Silakan hubungi administrator.");
}
?>