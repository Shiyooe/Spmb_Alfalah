<?php
session_start();

// Cek login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: log/mail/login.php");
    exit();
}

// Cek POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $host = "localhost";
    $user = "root"; 
    $password = ""; 
    $database = "spmb_alfalah"; 
    $koneksi = new mysqli($host, $user, $password, $database);

    if ($koneksi->connect_error) {
        die("Koneksi ke database gagal: " . $koneksi->connect_error);
    }

    // Ambil ID Pendaftaran dan pastikan integer
    $id_pendaftaran = (int)$_POST['id_pendaftaran'];

    // Mulai Transaksi
    $koneksi->begin_transaction();

    try {
        // 1. UPDATE Tabel `pendaftaran`
        $sql_p = "UPDATE pendaftaran SET 
                    tgl_daftar = ?, nama = ?, tempat_lahir = ?, tanggal_lahir = ?, anak_ke = ?, jenis_kelamin = ?, 
                    alamat = ?, kelurahan = ?, kecamatan = ?, telepon = ?, asal_sekolah = ?, kode_pos = ?, 
                    rt = ?, rw = ?, nisn = ?, hobby = ?, citacita = ?, ukuran_baju = ?, no_kk = ?, 
                    nama_ayah = ?, pekerjaan_ayah = ?, tempat_lahir_ayah = ?, tanggal_lahir_ayah = ?, ktp_ayah = ?, telepon_ayah = ?, 
                    nama_ibu = ?, pekerjaan_ibu = ?, tempat_lahir_ibu = ?, tanggal_lahir_ibu = ?, ktp_ibu = ?, telepon_ibu = ?
                  WHERE id_pendaftaran = ?";
        
        $stmt_p = $koneksi->prepare($sql_p);
        
        $stmt_p->bind_param("ssssissssssiiisssssssssssssssssi", 
            $_POST['tgl_daftar'], $_POST['nama'], $_POST['tempat_lahir'], $_POST['tanggal_lahir'], $_POST['anak_ke'], $_POST['jenis_kelamin'],
            $_POST['alamat'], $_POST['kelurahan'], $_POST['kecamatan'], $_POST['telepon'], $_POST['asal_sekolah'], $_POST['kode_pos'],
            $_POST['rt'], $_POST['rw'], $_POST['nisn'], $_POST['hobby'], $_POST['citacita'], $_POST['ukuran_baju'], $_POST['no_kk'],
            $_POST['nama_ayah'], $_POST['pekerjaan_ayah'], $_POST['tempat_lahir_ayah'], $_POST['tanggal_lahir_ayah'], $_POST['ktp_ayah'], $_POST['telepon_ayah'],
            $_POST['nama_ibu'], $_POST['pekerjaan_ibu'], $_POST['tempat_lahir_ibu'], $_POST['tanggal_lahir_ibu'], $_POST['ktp_ibu'], $_POST['telepon_ibu'],
            $id_pendaftaran // Parameter WHERE
        );
        $stmt_p->execute();
        $stmt_p->close();

        // 2. UPDATE Tabel `jurusan`
        $sql_j = "UPDATE jurusan SET jurusan1 = ?, jurusan2 = ? WHERE id_pendaftaran = ?";
        $stmt_j = $koneksi->prepare($sql_j);
        $stmt_j->bind_param("ssi", $_POST['jurusan1'], $_POST['jurusan2'], $id_pendaftaran);
        $stmt_j->execute();
        $stmt_j->close();

        // 3. UPDATE/INSERT Tabel `wali` (Logika UPSERT)
        $stmt_check_w = $koneksi->prepare("SELECT id_wali FROM wali WHERE id_pendaftaran = ?");
        $stmt_check_w->bind_param("i", $id_pendaftaran);
        $stmt_check_w->execute();
        $result_w = $stmt_check_w->get_result();
        $stmt_check_w->close();

        if ($result_w->num_rows > 0) {
            // Data ada -> UPDATE
            $sql_w = "UPDATE wali SET nama_wali = ?, tempat_lahir_wali = ?, tanggal_lahir_wali = ?, ktp_wali = ?, no_tlp_wali = ?, pekerjaan_wali = ?
                      WHERE id_pendaftaran = ?";
            $stmt_w = $koneksi->prepare($sql_w);
            $stmt_w->bind_param("ssssssi", 
                $_POST['nama_wali'], $_POST['tempat_lahir_wali'], $_POST['tanggal_lahir_wali'], $_POST['ktp_wali'], $_POST['no_tlp_wali'], $_POST['pekerjaan_wali'],
                $id_pendaftaran
            );
        } else if (!empty($_POST['nama_wali'])) {
            // Data tidak ada TAPI form diisi -> INSERT
            $sql_w = "INSERT INTO wali (id_pendaftaran, nama_wali, tempat_lahir_wali, tanggal_lahir_wali, ktp_wali, no_tlp_wali, pekerjaan_wali)
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_w = $koneksi->prepare($sql_w);
            $stmt_w->bind_param("issssss", 
                $id_pendaftaran,
                $_POST['nama_wali'], $_POST['tempat_lahir_wali'], $_POST['tanggal_lahir_wali'], $_POST['ktp_wali'], $_POST['no_tlp_wali'], $_POST['pekerjaan_wali']
            );
        }
        // Jika $stmt_w disiapkan, eksekusi
        if (isset($stmt_w)) {
            $stmt_w->execute();
            $stmt_w->close();
        }

        // 4. UPDATE Tabel `pembayaran`
        $sql_b = "UPDATE pembayaran SET Tanggal_pembayaran = ?, jumlah_pembayaran = ?, status_pembayaran = ? WHERE id_pendaftaran = ?";
        $stmt_b = $koneksi->prepare($sql_b);
        // Diasumsikan jumlah_pembayaran adalah double/float (d)
        $stmt_b->bind_param("sdsi", $_POST['Tanggal_pembayaran'], $_POST['jumlah_pembayaran'], $_POST['status_pembayaran'], $id_pendaftaran);
        $stmt_b->execute();
        $stmt_b->close();


        // Jika semua berhasil, COMMIT
        $koneksi->commit();
        $_SESSION['success_message'] = "Data pendaftaran (ID: $id_pendaftaran) berhasil diperbarui.";

    } catch (mysqli_sql_exception $exception) {
        // Jika ada error, ROLLBACK
        $koneksi->rollback();
        // Log error untuk debug
        error_log("Gagal memperbarui data: " . $exception->getMessage() . " di " . $exception->getFile() . " baris " . $exception->getLine());
        $_SESSION['error_message'] = "Gagal memperbarui data: " . $exception->getMessage();
        // Redirect kembali ke halaman edit
        header("Location: edit_pendaftaran.php?id=" . $id_pendaftaran);
        exit();
    }

    $koneksi->close();
    // Redirect kembali ke halaman tabel
    header("Location: tables.php");
    exit();
} else {
    // Jika bukan POST, tendang
    $_SESSION['error_message'] = "Akses tidak valid.";
    header("Location: tables.php");
    exit();
}
?>