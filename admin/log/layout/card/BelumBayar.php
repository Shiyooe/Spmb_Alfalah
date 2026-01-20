<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../../mail/login.php");
    exit();
}

// Koneksi database
require_once '../koneksi.php';

// Handle hapus data
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id_pendaftaran = mysqli_real_escape_string($conn, $_GET['id']);

    // Hapus data (cascade akan otomatis menghapus data di tabel jurusan, pembayaran, dan wali)
    $query_delete = "DELETE FROM pendaftaran WHERE id_pendaftaran = '$id_pendaftaran'";

    if (mysqli_query($conn, $query_delete)) {
        $_SESSION['success_message'] = "Data pendaftaran berhasil dihapus!";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus data: " . mysqli_error($conn);
    }

    header("Location: BelumBayar.php");
    exit();
}

// Query untuk mendapatkan data siswa yang belum bayar
$query_belum_bayar = "SELECT 
    p.id_pendaftaran,
    p.nama, 
    p.nisn, 
    p.jenis_kelamin, 
    p.tgl_daftar,
    p.asal_sekolah,
    TIMESTAMPDIFF(YEAR, p.tanggal_lahir, CURDATE()) as umur
FROM pendaftaran p
LEFT JOIN pembayaran pb ON p.id_pendaftaran = pb.id_pendaftaran
WHERE pb.id_pembayaran IS NULL
ORDER BY p.tgl_daftar DESC";

$result_belum_bayar = mysqli_query($conn, $query_belum_bayar);
$total_belum_bayar = mysqli_num_rows($result_belum_bayar);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Data Belum Bayar - SPMB Alfalah</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../../../css/styles.css" rel="stylesheet" />
    <link rel="icon" type="x-icon" href="img/Alfalah.png">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .btn-delete {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-belum-bayar {
            background-color: #dc3545;
            color: white;
        }

        .card-header {
            background-color: #dc3545;
            color: white;
        }

        .card-header i {
            margin-right: 8px;
        }

        .alert-info-custom {
            background-color: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="../../../index.php">SPMB Alfalah</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#" onclick="confirmLogout(event)">Logout</a></li>
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
                        <a class="nav-link" href="../../../index.php">
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
                                <a class="nav-link" href="../../../layout-static.php">Static Navigation</a>
                                <a class="nav-link" href="../../../layout-sidenav-light.php">Light Sidenav</a>
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
                                        <a class="nav-link" href="../../../login.php">Login</a>
                                        <a class="nav-link" href="../../../register.php">Register</a>
                                        <a class="nav-link" href="../../../password.php">Forgot Password</a>
                                    </nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                    Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="../../../log/401.php">401 Page</a>
                                        <a class="nav-link" href="../../../log/404.php">404 Page</a>
                                        <a class="nav-link" href="../../../log/500.php">500 Page</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="../../../charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a>
                        <a class="nav-link" href="../../../tables.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Tables
                        </a>
                        <a class="nav-link" href="../../../python/AI/Backup/kontribusi.php">
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
                    <h1 class="mt-4">Data Siswa Belum Bayar</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="../../../index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Belum Bayar</li>
                    </ol>

                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> <?php echo $_SESSION['success_message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php unset($_SESSION['success_message']);
                    endif; ?>

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $_SESSION['error_message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php unset($_SESSION['error_message']);
                    endif; ?>

                    <!-- Info Card -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card mb-4 border-danger">
                                <div class="card-body alert-info-custom">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Total Siswa Belum Bayar: <?php echo $total_belum_bayar; ?> orang</strong>
                                    <p class="mb-0 mt-2">Data di bawah ini menampilkan siswa yang telah mendaftar namun belum melakukan pembayaran.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Data Belum Bayar -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table"></i>
                            Daftar Siswa Belum Bayar
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>NISN</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <th>Asal Sekolah</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($result_belum_bayar)): 
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                            <td><?php echo htmlspecialchars($row['nisn']); ?></td>
                                            <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                                            <td><?php echo htmlspecialchars($row['umur']); ?> tahun</td>
                                            <td><?php echo htmlspecialchars($row['asal_sekolah']); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($row['tgl_daftar'])); ?></td>
                                            <td>
                                                <span class="status-badge status-belum-bayar">Belum Bayar</span>
                                            </td>
                                            <td>
                                                <button class="btn btn-danger btn-delete btn-sm" onclick="confirmDelete(<?php echo $row['id_pendaftaran']; ?>, '<?php echo htmlspecialchars($row['nama'], ENT_QUOTES); ?>')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>NISN</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Umur</th>
                                        <th>Asal Sekolah</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
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

    <!-- Modal Konfirmasi Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-sign-out-alt me-2"></i>Konfirmasi Logout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Apakah Anda yakin ingin keluar dari sistem?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <a href="../../../logout.php" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt me-1"></i>Ya, Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../../../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script>
        // Initialize DataTable
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });

        // Fungsi konfirmasi hapus
        function confirmDelete(id, nama) {
            if (confirm('Apakah Anda yakin ingin menghapus pendaftaran atas nama "' + nama + '"?\n\nData ini akan dihapus permanen dari database!')) {
                window.location.href = 'BelumBayar.php?action=delete&id=' + id;
            }
        }

        // Fungsi konfirmasi logout
        function confirmLogout(event) {
            event.preventDefault();
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        }
    </script>
</body>

</html>