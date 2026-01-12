<?php
// Konfigurasi koneksi database
$host = "localhost"; 
$user = "root";      
$password = "";     
$database = "spmb_alfalah"; 

$conn = new mysqli($host, $user, $password, $database);

// Jika koneksi gagal -> redirect ke 404.php
if ($conn->connect_error) {
    header("Location: log/layout/card/Git/error/404.php");
    exit(); // wajib biar script stop di sini
}

$conn->set_charset("utf8mb4");
?>
