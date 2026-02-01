<?php
require_once '../config/koneksi3.php';

session_start();
$query = "SELECT 
            p.id_pendaftaran,
            p.nama,
            p.nisn,
            pb.id_pembayaran,
            pb.Tanggal_pembayaran,
            pb.jumlah_pembayaran,
            pb.status_pembayaran,
            pb.bukti_pembayaran,
            pb.total_cicilan
          FROM pembayaran pb
          INNER JOIN pendaftaran p ON pb.id_pendaftaran = p.id_pendaftaran
          ORDER BY pb.Tanggal_pembayaran DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Pembayaran - Admin SPMB Al-Falah</title>
    
    <!-- SB Admin CSS -->
    <link href="../admin/css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/Alfalah.png">
    
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/bayar.css">


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
                                        <a class="nav-link" href="log/layout/card/Git/error/500.php">500 Page</a>
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
    
        <!-- Main Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="container-fluid">
                            <h1><i class="bi bi-cash-coin me-2"></i>Data Pembayaran Siswa</h1>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Pembayaran</li>
                            </ol>
                        </div>
                    </div>
                    
                    <!-- Card Statistik -->
                    <div class="row mb-4">
                        <?php
                        // Hitung statistik
                        $total_pembayaran = mysqli_num_rows($result);
                        mysqli_data_seek($result, 0);
                        
                        $lunas = 0;
                        $belum_lunas = 0;
                        $total_uang = 0;
                        
                        while ($stat = mysqli_fetch_assoc($result)) {
                            if ($stat['status_pembayaran'] == 'Lunas') $lunas++;
                            else $belum_lunas++;
                            $total_uang += $stat['jumlah_pembayaran'];
                        }
                        mysqli_data_seek($result, 0);
                        ?>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card primary">
                                <div class="card-body">
                                    <div class="stat-value"><?= $total_pembayaran ?></div>
                                    <div class="stat-label">Total Pembayaran</div>
                                    <i class="fas fa-receipt stat-icon"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card success">
                                <div class="card-body">
                                    <div class="stat-value"><?= $lunas ?></div>
                                    <div class="stat-label">Lunas</div>
                                    <i class="fas fa-check-circle stat-icon"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card warning">
                                <div class="card-body">
                                    <div class="stat-value"><?= $belum_lunas ?></div>
                                    <div class="stat-label">Belum Lunas</div>
                                    <i class="fas fa-clock stat-icon"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card info">
                                <div class="card-body">
                                    <div class="stat-value" style="font-size: 1.5rem;">Rp <?= number_format($total_uang/1000000, 1) ?>Jt</div>
                                    <div class="stat-label">Total Pemasukan</div>
                                    <i class="fas fa-dollar-sign stat-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabel Data -->
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <i class="fas fa-table me-2"></i>
                                    Daftar Pembayaran
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary btn-action" onclick="window.print()">
                                        <i class="fas fa-print me-1"></i> Cetak Laporan
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <?php if (mysqli_num_rows($result) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0" id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>NISN</th>
                                            <th>Tanggal Bayar</th>
                                            <th>Total Bayar</th>
                                            <th>Cicilan</th>
                                            <th>Status</th>
                                            <th class="no-print">Bukti</th>
                                            <th class="no-print">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($result)): 
                                            $tanggal = date('d/m/Y', strtotime($row['Tanggal_pembayaran']));
                                            $jumlah = 'Rp ' . number_format($row['jumlah_pembayaran'], 0, ',', '.');
                                            $statusClass = ($row['status_pembayaran'] == 'Lunas') ? 'status-lunas' : 'status-belum';
                                        ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><strong><?= htmlspecialchars($row['nama']); ?></strong></td>
                                            <td><?= htmlspecialchars($row['nisn']); ?></td>
                                            <td><?= $tanggal; ?></td>
                                            <td><?= $jumlah; ?></td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= $row['total_cicilan'] ?? 1; ?>x
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge <?= $statusClass; ?>">
                                                    <?= htmlspecialchars($row['status_pembayaran']); ?>
                                                </span>
                                            </td>
                                            <td class="no-print">
                                                <?php if (!empty($row['bukti_pembayaran'])): ?>
                                                    <img src="<?= htmlspecialchars($row['bukti_pembayaran']); ?>" 
                                                         alt="Bukti Pembayaran" 
                                                         class="bukti-img"
                                                         data-bs-toggle="modal" 
                                                         data-bs-target="#modalBukti"
                                                         onclick="showImage('<?= htmlspecialchars($row['bukti_pembayaran']); ?>')"
                                                         onerror="this.src='img/no-image.png'">
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="no-print">
                                                <button class="btn btn-primary btn-action" 
                                                        onclick="showRiwayat(<?= $row['id_pembayaran']; ?>, '<?= htmlspecialchars($row['nama']); ?>')">
                                                    <i class="bi bi-eye me-1"></i> Detail
                                                </button>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-info text-center m-4" role="alert">
                                <i class="bi bi-info-circle me-2"></i> Belum ada data pembayaran
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>
            
            <!-- Footer -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; by  Muhammad Yusuf 2025/2026</div>
                        <div>
                            <a href="#" style="color: var(--dark-gray); text-decoration: none;">Privacy Policy</a>
                            &middot;
                            <a href="#" style="color: var(--dark-gray); text-decoration: none;">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Modal untuk menampilkan gambar bukti pembayaran -->
    <div class="modal fade" id="modalBukti" tabindex="-1" aria-labelledby="modalBuktiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBuktiLabel">
                        <i class="bi bi-image me-2"></i> Bukti Pembayaran
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-4">
                    <img id="modalImage" src="" alt="Bukti Pembayaran" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan riwayat pembayaran -->
    <div class="modal fade" id="modalRiwayat" tabindex="-1" aria-labelledby="modalRiwayatLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRiwayatLabel">
                        <i class="bi bi-clock-history me-2"></i> Riwayat Pembayaran - <span id="namaSiswa"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color: #f8f9fa;">
                    <div id="riwayatContent">
                        <div class="text-center py-5">
                            <div class="spinner-border" style="color: var(--accent-color);" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <!-- SB Admin Scripts -->
    <script src="../admin/js/scripts.js"></script>
    
    <script src="js/bayar.js"></script>
</body>
</html>

<?php
mysqli_close($conn);
?>