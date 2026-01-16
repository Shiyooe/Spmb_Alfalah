<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: log/mail/login.php");
    exit();
}

$host = "localhost";
$user = "root"; 
$password = ""; 
$database = "spmb_alfalah"; 
$koneksi = new mysqli($host, $user, $password, $database);

if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

$sql = "SELECT
            p.id_pendaftaran, p.nama, p.tgl_daftar, p.tempat_lahir, p.tanggal_lahir, p.anak_ke, p.jenis_kelamin, 
            p.alamat, p.kelurahan, p.kecamatan, p.kode_pos, p.rt, p.rw, p.telepon AS No_Telepon, 
            p.asal_sekolah, p.nisn, p.hobby, p.citacita, p.ukuran_baju, p.no_kk,
            p.nama_ayah, p.pekerjaan_ayah, p.tempat_lahir_ayah, p.tanggal_lahir_ayah, p.ktp_ayah, p.telepon_ayah,
            p.nama_ibu, p.pekerjaan_ibu, p.tempat_lahir_ibu, p.tanggal_lahir_ibu, p.ktp_ibu, p.telepon_ibu,
            j.jurusan1 AS Jurusan_1, j.jurusan2 AS Jurusan_2,
            w.nama_wali, w.pekerjaan_wali AS Pekerjaan_Wali, w.tempat_lahir_wali AS Tempat_Lahir_Wali, w.tanggal_lahir_wali AS Tanggal_Lahir_Wali, w.ktp_wali AS KTP_Wali, w.no_tlp_wali AS Telepon_Wali,
            b.Tanggal_pembayaran, b.jumlah_pembayaran AS Jumlah_Pembayaran, b.status_pembayaran AS Status_pembayaran
        FROM pendaftaran p
        LEFT JOIN jurusan j ON p.id_pendaftaran = j.id_pendaftaran
        LEFT JOIN wali w ON p.id_pendaftaran = w.id_pendaftaran
        LEFT JOIN pembayaran b ON p.id_pendaftaran = b.id_pendaftaran
        ORDER BY p.id_pendaftaran DESC";

$result = $koneksi->query($sql);
$no = 1;

// Get last update time
$query_last_update = "SELECT MAX(tgl_daftar) as last_update FROM pendaftaran";
$result_last_update = $koneksi->query($query_last_update);
$last_update_row = $result_last_update->fetch_assoc();
$last_update = $last_update_row['last_update'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Pendaftaran Siswa - SPMB Alfalah</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/tables.css" rel="stylesheet"/>
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="icon" type="x-icon" href="img/Alfalah.png">

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="index.php">SPMB Alfalah</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Settings</a></li>
                        <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Interface</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="layout-static.php">Static Navigation</a>
                                    <a class="nav-link" href="layout-sidenav-light.php">Light Sidenav</a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Pages
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="log/mail/login.php">Login</a>
                                            <a class="nav-link" href="log/mail/register.php">Register</a>
                                            <a class="nav-link" href="log/mail/password.php">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="log/layout/card/Git/error/401.php">401 Page</a>
                                            <a class="nav-link" href="log/layout/card/Git/error/404.php">404 Page</a>
                                            <a class="nav-link" href="log/layout/card/Git/error/500.php">505 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Addons</div>
                            <a class="nav-link" href="charts.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Charts
                            </a>
                            <a class="nav-link" href="tables.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Tables
                            </a>
                            <a class="nav-link" href="python/AI/Backup/kontribusi.php">
                                <div class="sb-nav-link-icon"><i class="bi bi-brush"></i></div>
                                Who Have Contributed
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo htmlspecialchars($_SESSION['admin_name']); ?>
                    </div>                  
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Pendaftaran Siswa</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>

                        <?php
                        if (isset($_SESSION['success_message'])) {
                            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">' . $_SESSION['success_message'] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                            unset($_SESSION['success_message']);
                        }
                        if (isset($_SESSION['error_message'])) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">' . $_SESSION['error_message'] . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                            unset($_SESSION['error_message']);
                        }
                        ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <i class="fas fa-info-circle text-primary"></i>
                                Data di bawah ini diambil langsung dari database MySQL
                            </div>
                        </div>
                        
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pendaftar Terintegrasi
                                <button class="btn btn-sm btn-success float-end" onclick="manualRefresh()">
                                    <i class="fas fa-sync-alt"></i> Refresh Manual
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="tableContainer">
                                    <table id="datatablesSimple">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Tgl_Daftar</th>
                                                <th>Jurusan_1</th>
                                                <th>Jurusan_2</th>
                                                <th>Tempat_Lahir</th>
                                                <th>Tanggal_Lahir</th>
                                                <th>Anak_Ke</th>
                                                <th>Jenis_Kelamin</th>
                                                <th>Alamat</th>
                                                <th>RT</th>
                                                <th>RW</th>
                                                <th>Kelurahan</th>
                                                <th>Kecamatan</th>
                                                <th>Kode_Pos</th>
                                                <th>Telepon</th>
                                                <th>Asal_Sekolah</th>
                                                <th>NISN</th>
                                                <th>Hobby</th>
                                                <th>Cita_Cita</th>
                                                <th>Ukuran_Baju</th>
                                                <th>|</th>
                                                <th>No_KK</th>
                                                <th>Nama_Ayah</th>
                                                <th>Pekerjaan_Ayah</th>
                                                <th>Tempat_Lahir_Ayah</th>
                                                <th>Tanggal_Lahir_Ayah</th>
                                                <th>KTP_Ayah</th>
                                                <th>Telepon_Ayah</th>
                                                <th>Nama_Ibu</th>
                                                <th>Pekerjaan_Ibu</th>
                                                <th>Tempat_Lahir_Ibu</th>
                                                <th>Tanggal_Lahir_Ibu</th>
                                                <th>KTP_Ibu</th>
                                                <th>Telepon_Ibu</th>
                                                <th>|</th>
                                                <th>Nama_Wali</th>
                                                <th>Pekerjaan_Wali</th>
                                                <th>Tempat_Lahir_Wali</th>
                                                <th>Tanggal_Lahir_Wali</th>
                                                <th>KTP_Wali</th>
                                                <th>Telepon_Wali</th>
                                                <th>|</th>
                                                <th>Tgl_Pembayaran</th>
                                                <th>Jumlah</th>
                                                <th>Status</th>
                                                <th>Aksi</th> </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $jumlah_pembayaran_formatted = $row["Jumlah_Pembayaran"] ? number_format($row["Jumlah_Pembayaran"], 0, ',', '.') : '-';

                                                    echo "<tr>";
                                                    echo "<td>" . htmlspecialchars($no++) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["nama"]) . "</td>";
                                                    echo "<td>" . date('d-m-Y', strtotime($row['tgl_daftar'])) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["Jurusan_1"] ?? '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["Jurusan_2"] ?? '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["tempat_lahir"]) . "</td>";
                                                    echo "<td>" . date('d-m-Y', strtotime($row['tanggal_lahir'])) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["anak_ke"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["jenis_kelamin"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["alamat"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["rt"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["rw"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["kelurahan"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["kecamatan"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["kode_pos"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["No_Telepon"] ?? '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["asal_sekolah"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["nisn"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["hobby"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["citacita"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["ukuran_baju"]) . "</td>";
                                                    echo "<td>|</td>";
                                                    echo "<td>" . htmlspecialchars($row["no_kk"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["nama_ayah"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["pekerjaan_ayah"] ?? '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["tempat_lahir_ayah"]) . "</td>";
                                                    echo "<td>" . ($row["tanggal_lahir_ayah"] != '1000-01-01' ? date('d-m-Y', strtotime($row['tanggal_lahir_ayah'])) : '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["ktp_ayah"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["telepon_ayah"] ?? '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["nama_ibu"] ?? '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["pekerjaan_ibu"] ?? '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["tempat_lahir_ibu"]) . "</td>";
                                                    echo "<td>" . ($row["tanggal_lahir_ibu"] != '1000-01-01' ? date('d-m-Y', strtotime($row['tanggal_lahir_ibu'])) : '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["ktp_ibu"]) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["telepon_ibu"] ?? '-') . "</td>";
                                                    echo "<td>|</td>";
                                                    echo "<td>" . htmlspecialchars($row["nama_wali"] ?? '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["Pekerjaan_Wali"] ?? '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["Tempat_Lahir_Wali"] ?? '-') . "</td>";
                                                    echo "<td>" . (isset($row['Tanggal_Lahir_Wali']) && $row['Tanggal_Lahir_Wali'] != '1000-01-01' ? date('d-m-Y', strtotime($row['Tanggal_Lahir_Wali'])) : '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["KTP_Wali"] ?? '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["Telepon_Wali"] ?? '-') . "</td>";
                                                    echo "<td>|</td>";
                                                    echo "<td>" . (isset($row['Tanggal_pembayaran']) ? date('d-m-Y', strtotime($row['Tanggal_pembayaran'])) : '-') . "</td>";
                                                    echo "<td>" . htmlspecialchars($jumlah_pembayaran_formatted) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row["Status_pembayaran"] ?? '-') . "</td>";
                                                    // ==== TOMBOL EDIT BARU ====
                                                    echo '<td><a href="edit_pendaftaran.php?id=' . $row["id_pendaftaran"] . '" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a></td>';
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='47' class='text-center'>Tidak ada data</td></tr>"; // colspan ditambah jadi 47
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Admin Website 2025/2026</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

        <div id="imageModal" class="image-modal" onclick="closeModal()">
            <span class="close-modal">&times;</span>
            <img class="modal-content-img" id="modalImage">
        </div>

        <div class="refresh-indicator" id="refreshIndicator">
            <i class="fas fa-sync-alt"></i>
            <span>Updating data...</span>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        
        <script src="js/tables.js"></script>
        
        <?php
        $koneksi->close();
        ?>
    </body>
</html>