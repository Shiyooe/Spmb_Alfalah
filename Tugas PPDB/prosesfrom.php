<?php
// Konfigurasi Koneksi Database
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "spmb_alfalah";

$conn = new mysqli($servername, $username, $password, $dbname);

header('Content-Type: application/json');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database gagal: ' . $conn->connect_error]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak diizinkan.']);
    $conn->close();
    exit();
}

// ----------------------------------------------------
// 1. Ambil dan Decode Data JSON dari Body Request
// ----------------------------------------------------
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

if (json_last_error() !== JSON_ERROR_NONE || empty($data)) {
    echo json_encode(['success' => false, 'message' => 'Data JSON tidak valid atau kosong.']);
    $conn->close();
    exit();
}

// ----------------------------------------------------
// 2. Mapping dan Sanitasi Data
// ----------------------------------------------------

function format_tgl_daftar($tgl_str) {
    // Contoh: "Senin, 03 November 2025"
    $parts = explode(' ', str_replace(',', '', $tgl_str));
    if (count($parts) < 4) return date("Y-m-d"); 
    
    $hari = $parts[1];
    $bulan_str = $parts[2];
    $tahun = $parts[3];
    
    $bulan_map = [
        "Januari" => 1, "Februari" => 2, "Maret" => 3, "April" => 4, "Mei" => 5, "Juni" => 6,
        "Juli" => 7, "Agustus" => 8, "September" => 9, "Oktober" => 10, "November" => 11, "Desember" => 12
    ];
    $bulan_num = $bulan_map[$bulan_str] ?? date("m");
    
    // Format tanggal untuk database: YYYY-MM-DD
    return sprintf('%s-%02d-%02d', $tahun, $bulan_num, $hari);
}

function format_telepon($nomor_telepon) {
    $nomor_telepon = trim($nomor_telepon);
    $nomor_telepon = preg_replace('/[^0-9+\s-]/', '', $nomor_telepon);
    $nomor_telepon = preg_replace('/\s+/', ' ', $nomor_telepon);
    return $nomor_telepon;
}

$tgl_daftar_raw = $data['tgl_daftar'] ?? date("Y-m-d");
$tgl_daftar = format_tgl_daftar($tgl_daftar_raw);

// Data si Calon Siswa
$nama = $conn->real_escape_string($data['nama'] ?? '');
$tempat_lahir = $conn->real_escape_string($data['tempat_lahir'] ?? '');
$tanggal_lahir = $conn->real_escape_string($data['tanggal_lahir'] ?? '');
$anak_ke = (int)($data['anak_ke'] ?? 0);
$jenis_kelamin = $conn->real_escape_string($data['jk'] ?? '');
$alamat = $conn->real_escape_string($data['alamat'] ?? '');
$kelurahan = $conn->real_escape_string($data['kelurahan'] ?? '');
$kecamatan = $conn->real_escape_string($data['kecamatan'] ?? '');
$kode_pos = (int)($data['kode_pos'] ?? 0);
$rt = (int)($data['rt'] ?? 0);
$rw = (int)($data['rw'] ?? 0);
$telepon = format_telepon($data['telepon'] ?? '');
$asal_sekolah = $conn->real_escape_string($data['asal_sekolah'] ?? '');
$nisn = $conn->real_escape_string($data['nisn'] ?? '');
$hobby = $conn->real_escape_string($data['hobby'] ?? '');
$citacita = $conn->real_escape_string($data['citacita'] ?? '');
$ukuran_baju = $conn->real_escape_string($data['ukuran_baju'] ?? '');

// Data Jurusan 1 dan 2 
$jurusan1 = $conn->real_escape_string($data['jurusan1'] ?? '');
$jurusan2 = $conn->real_escape_string($data['jurusan2'] ?? ''); 

// Tipe Pengisi
$tipe_pengisi = $conn->real_escape_string($data['tipe_pengisi'] ?? '');

// Data Ortu (Default NULL / Dummy untuk NOT NULL jika Wali yang mengisi)
$no_kk = NULL;
$nama_ayah = NULL;
$pekerjaan_ayah = NULL;
$tempat_lahir_ayah = NULL;
$tanggal_lahir_ayah = NULL;
$ktp_ayah = NULL;
$telepon_ayah = NULL;
$nama_ibu = NULL;
$pekerjaan_ibu = NULL;
$tempat_lahir_ibu = NULL;
$tanggal_lahir_ibu = NULL;
$ktp_ibu = NULL;
$telepon_ibu = NULL;

// Data Wali (Hanya diambil jika tipe_pengisi adalah 'wali')
$nama_wali = NULL;
$tempat_lahir_wali = NULL;
$tanggal_lahir_wali = NULL;
$ktp_wali = NULL;
$no_tlp_wali = NULL;
$pekerjaan_wali = NULL;

if ($tipe_pengisi === 'ortu') {
    $no_kk = $conn->real_escape_string($data['no_kk'] ?? '');
    $nama_ayah = $conn->real_escape_string($data['nama_ayah'] ?? '');
    $pekerjaan_ayah = $conn->real_escape_string($data['pekerjaan_ayah'] ?? '');
    $tempat_lahir_ayah = $conn->real_escape_string($data['tempat_lahir_ayah'] ?? '');
    $tanggal_lahir_ayah = $conn->real_escape_string($data['tanggal_lahir_ayah'] ?? '');
    $ktp_ayah = $conn->real_escape_string($data['ktp_ayah'] ?? '');
    $telepon_ayah = format_telepon($data['telepon_ayah'] ?? '');
    $nama_ibu = $conn->real_escape_string($data['nama_ibu'] ?? '');
    $pekerjaan_ibu = $conn->real_escape_string($data['pekerjaan_ibu'] ?? ''); 
    $tempat_lahir_ibu = $conn->real_escape_string($data['tempat_lahir_ibu'] ?? '');
    $tanggal_lahir_ibu = $conn->real_escape_string($data['tanggal_lahir_ibu'] ?? '');
    $ktp_ibu = $conn->real_escape_string($data['ktp_ibu'] ?? '');
    $telepon_ibu = format_telepon($data['telepon_ibu'] ?? '');
} elseif ($tipe_pengisi === 'wali') {
    $nama_wali = $conn->real_escape_string($data['nama_wali'] ?? '');
    $tempat_lahir_wali = $conn->real_escape_string($data['tempat_lahir_wali'] ?? '');
    $tanggal_lahir_wali = $conn->real_escape_string($data['tanggal_lahir_wali'] ?? '');
    $ktp_wali = $conn->real_escape_string($data['ktp_wali'] ?? '');
    $no_tlp_wali = format_telepon($data['no_tlp_wali'] ?? '');
    $pekerjaan_wali = $conn->real_escape_string($data['pekerjaan_wali'] ?? '');
    
    // Set dummy data untuk ortu
    $no_kk = 0;
    $nama_ayah = 'N/A';
    $pekerjaan_ayah = 'N/A';
    $tempat_lahir_ayah = 'N/A';
    $tanggal_lahir_ayah = '1000-01-01';
    $ktp_ayah = 0;
    $telepon_ayah = '';
    $nama_ibu = 'N/A';
    $pekerjaan_ibu = 'N/A';
    $tempat_lahir_ibu = 'N/A';
    $tanggal_lahir_ibu = '1000-01-01';
    $ktp_ibu = 0;
    $telepon_ibu = '';
} else {
    echo json_encode(['success' => false, 'message' => 'Tipe pengisi data (Orang Tua/Wali) harus dipilih.']);
    $conn->close();
    exit();
}

$conn->begin_transaction();

try {
    // ----------------------------------------------------
    // 3. Insert Data ke Tabel `pendaftaran`
    // ----------------------------------------------------
    $sql_pendaftaran = "INSERT INTO `pendaftaran` (
        tgl_daftar, nama, tempat_lahir, tanggal_lahir, anak_ke, jenis_kelamin, 
        alamat, kelurahan, kecamatan, kode_pos, rt, rw, telepon, 
        asal_sekolah, nisn, hobby, citacita, ukuran_baju, 
        no_kk, nama_ayah, pekerjaan_ayah, tempat_lahir_ayah, tanggal_lahir_ayah, ktp_ayah, telepon_ayah, 
        nama_ibu, pekerjaan_ibu, tempat_lahir_ibu, tanggal_lahir_ibu, ktp_ibu, telepon_ibu
    ) VALUES (
        ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?, ?, 
        ?, ?, ?, ?, ?, ?
    )";

    $stmt_pendaftaran = $conn->prepare($sql_pendaftaran);
    
    $stmt_pendaftaran->bind_param(
        "ssssissssiissssssssssssssssssss",
        $tgl_daftar,        // 1 - s
        $nama,              // 2 - s
        $tempat_lahir,      // 3 - s
        $tanggal_lahir,     // 4 - s
        $anak_ke,           // 5 - i
        $jenis_kelamin,     // 6 - s
        $alamat,            // 7 - s
        $kelurahan,         // 8 - s
        $kecamatan,         // 9 - s
        $kode_pos,          // 10 - i
        $rt,                // 11 - i
        $rw,                // 12 - i
        $telepon,           // 13 - s
        $asal_sekolah,      // 14 - s
        $nisn,              // 15 - s
        $hobby,             // 16 - s
        $citacita,          // 17 - s
        $ukuran_baju,       // 18 - s
        $no_kk,             // 19 - s
        $nama_ayah,         // 20 - s
        $pekerjaan_ayah,    // 21 - s
        $tempat_lahir_ayah, // 22 - s
        $tanggal_lahir_ayah,// 23 - s
        $ktp_ayah,          // 24 - s
        $telepon_ayah,      // 25 - s
        $nama_ibu,          // 26 - s
        $pekerjaan_ibu,     // 27 - s
        $tempat_lahir_ibu,  // 28 - s
        $tanggal_lahir_ibu, // 29 - s
        $ktp_ibu,           // 30 - s
        $telepon_ibu        // 31 - s
    );

    if (!$stmt_pendaftaran->execute()) {
        throw new Exception("Gagal menyimpan data pendaftaran: " . $stmt_pendaftaran->error);
    }
    
    $id_pendaftaran = $conn->insert_id;
    $stmt_pendaftaran->close();

    // ----------------------------------------------------
    // 4. Insert Data ke Tabel `jurusan`
    // ----------------------------------------------------
    $sql_jurusan = "INSERT INTO `jurusan` (id_pendaftaran, jurusan1, jurusan2) VALUES (?, ?, ?)";
    $stmt_jurusan = $conn->prepare($sql_jurusan);
    $stmt_jurusan->bind_param("iss", $id_pendaftaran, $jurusan1, $jurusan2);
    
    if (!$stmt_jurusan->execute()) {
        throw new Exception("Gagal menyimpan data jurusan: " . $stmt_jurusan->error);
    }
    $stmt_jurusan->close();

    // ----------------------------------------------------
    // 5. Insert Data ke Tabel `wali` (Jika `tipe_pengisi` adalah 'wali')
    // ----------------------------------------------------
    if ($tipe_pengisi === 'wali') {
        $sql_wali = "INSERT INTO `wali` (id_pendaftaran, nama_wali, tempat_lahir_wali, tanggal_lahir_wali, ktp_wali, no_tlp_wali, pekerjaan_wali) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_wali = $conn->prepare($sql_wali);
        
        $stmt_wali->bind_param(
            "issssss", 
            $id_pendaftaran, 
            $nama_wali, 
            $tempat_lahir_wali, 
            $tanggal_lahir_wali, 
            $ktp_wali, 
            $no_tlp_wali, 
            $pekerjaan_wali
        );

        if (!$stmt_wali->execute()) {
            throw new Exception("Gagal menyimpan data wali: " . $stmt_wali->error);
        }
        $stmt_wali->close();
    }
    
    $conn->commit();

    echo json_encode(['success' => true, 'id_pendaftaran' => $id_pendaftaran, 'message' => 'Pendaftaran berhasil.']);

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Pendaftaran Gagal: ' . $e->getMessage()]);
}

// Tutup koneksi
$conn->close();
?>