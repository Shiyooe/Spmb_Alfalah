<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: log/mail/login.php");
    exit();
}

// Koneksi database
require_once 'koneksi.php';

$id_admin = $_SESSION['admin_id'];
$success_message = '';
$error_message = '';

// Ambil data admin
$query = "SELECT * FROM admin WHERE id_admin = '$id_admin'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Handle update profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update_profile'])) {
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
        $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
        
        // Handle upload foto
        $foto_profil = $admin['foto_profil'];
        if (isset($_FILES['foto_profil']) && $_FILES['foto_profil']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['foto_profil']['name'];
            $filetype = pathinfo($filename, PATHINFO_EXTENSION);
            
            if (in_array(strtolower($filetype), $allowed)) {
                $upload_dir = 'uploads/admin_profiles/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $new_filename = 'admin_' . $id_admin . '_' . time() . '.' . $filetype;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $upload_path)) {
                    // Hapus foto lama jika bukan default
                    if ($admin['foto_profil'] && $admin['foto_profil'] != 'default-avatar.png' && file_exists($upload_dir . $admin['foto_profil'])) {
                        unlink($upload_dir . $admin['foto_profil']);
                    }
                    $foto_profil = $new_filename;
                } else {
                    $error_message = "Gagal mengupload foto profil!";
                }
            } else {
                $error_message = "Format file tidak diizinkan. Hanya JPG, JPEG, PNG, dan GIF.";
            }
        }
        
        if (empty($error_message)) {
            $query_update = "UPDATE admin SET 
                first_name = '$first_name',
                last_name = '$last_name',
                email = '$email',
                telepon = '$telepon',
                alamat = '$alamat',
                foto_profil = '$foto_profil'
                WHERE id_admin = '$id_admin'";
            
            if (mysqli_query($conn, $query_update)) {
                $_SESSION['admin_name'] = $first_name . ' ' . $last_name;
                $success_message = "Profile berhasil diperbarui!";
                // Refresh data admin
                $result = mysqli_query($conn, "SELECT * FROM admin WHERE id_admin = '$id_admin'");
                $admin = mysqli_fetch_assoc($result);
            } else {
                $error_message = "Gagal memperbarui profile: " . mysqli_error($conn);
            }
        }
    }
    
    // Handle update password
    if (isset($_POST['update_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        if ($current_password != $admin['password']) {
            $error_message = "Password lama tidak sesuai!";
        } elseif ($new_password != $confirm_password) {
            $error_message = "Password baru dan konfirmasi tidak cocok!";
        } elseif (strlen($new_password) < 6) {
            $error_message = "Password minimal 6 karakter!";
        } else {
            $query_update = "UPDATE admin SET password = '$new_password' WHERE id_admin = '$id_admin'";
            
            if (mysqli_query($conn, $query_update)) {
                $success_message = "Password berhasil diubah!";
                $admin['password'] = $new_password;
            } else {
                $error_message = "Gagal mengubah password: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Settings - SPMB Alfalah</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="icon" type="x-icon" href="img/Alfalah.png">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .profile-image-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
        }
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #0d6efd;
        }
        .change-photo-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid white;
        }
        .change-photo-btn:hover {
            background: #0b5ed7;
        }
        #foto_profil {
            display: none;
        }
        .card-settings {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
            border-radius: 0.35rem;
        }
        .form-label {
            font-weight: 600;
            color: #5a5c69;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">SPMB Alfalah</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." />
                <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="uploads/admin_profiles/<?php echo $admin['foto_profil'] ?: 'default-avatar.png'; ?>" 
                         alt="Profile" 
                         style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                    <li><a class="dropdown-item" href="#!"><i class="fas fa-list me-2"></i>Activity Log</a></li>
                    <li><hr class="dropdown-divider" /></li>
                    <li><a class="dropdown-item" href="#" onclick="confirmLogout(event)"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
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
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false">
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
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false">
                            <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                            Pages
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false">
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
                                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false">
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
        
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Settings</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>

                    <?php if ($success_message): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if ($error_message): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <!-- Profile Section -->
                        <div class="col-xl-8">
                            <div class="card card-settings mb-4">
                                <div class="card-header">
                                    <i class="fas fa-user me-1"></i>
                                    Edit Profile
                                </div>
                                <div class="card-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="profile-image-container">
                                            <img src="uploads/admin_profiles/<?php echo $admin['foto_profil'] ?: 'default-avatar.png'; ?>" 
                                                 alt="Profile" 
                                                 class="profile-image" 
                                                 id="preview-image">
                                            <label for="foto_profil" class="change-photo-btn" title="Ubah Foto">
                                                <i class="fas fa-camera"></i>
                                            </label>
                                            <input type="file" name="foto_profil" id="foto_profil" accept="image/*" onchange="previewImage(event)">
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="first_name" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                                       value="<?php echo htmlspecialchars($admin['first_name']); ?>" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="last_name" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                                       value="<?php echo htmlspecialchars($admin['last_name']); ?>" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?php echo htmlspecialchars($admin['email']); ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="telepon" class="form-label">Telepon</label>
                                            <input type="text" class="form-control" id="telepon" name="telepon" 
                                                   value="<?php echo htmlspecialchars($admin['telepon'] ?? ''); ?>" 
                                                   placeholder="+62 812-3456-7890">
                                        </div>

                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="3" 
                                                      placeholder="Masukkan alamat lengkap"><?php echo htmlspecialchars($admin['alamat'] ?? ''); ?></textarea>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" name="update_profile" class="btn btn-primary">
                                                <i class="fas fa-save me-2"></i>Update Profile
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password Section -->
                        <div class="col-xl-4">
                            <div class="card card-settings mb-4">
                                <div class="card-header">
                                    <i class="fas fa-lock me-1"></i>
                                    Change Password
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Password Lama</label>
                                            <input type="password" class="form-control" id="current_password" 
                                                   name="current_password" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">Password Baru</label>
                                            <input type="password" class="form-control" id="new_password" 
                                                   name="new_password" required minlength="6">
                                            <small class="form-text text-muted">Minimal 6 karakter</small>
                                        </div>

                                        <div class="mb-3">
                                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="confirm_password" 
                                                   name="confirm_password" required minlength="6">
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="submit" name="update_password" class="btn btn-warning">
                                                <i class="fas fa-key me-2"></i>Change Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Account Info -->
                            <div class="card card-settings mb-4">
                                <div class="card-header">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Account Information
                                </div>
                                <div class="card-body">
                                    <p class="mb-2"><strong>Account ID:</strong> <?php echo $admin['id_admin']; ?></p>
                                    <p class="mb-2"><strong>Created:</strong> 
                                        <?php echo isset($admin['created_at']) ? date('d/m/Y H:i', strtotime($admin['created_at'])) : '-'; ?>
                                    </p>
                                    <p class="mb-0"><strong>Last Updated:</strong> 
                                        <?php echo isset($admin['updated_at']) ? date('d/m/Y H:i', strtotime($admin['updated_at'])) : '-'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; by Muhammad Yusuf 2025/2026</div>
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

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-sign-out-alt me-2"></i>Konfirmasi Logout
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Apakah Anda yakin ingin keluar dari sistem?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <a href="logout.php" class="btn btn-danger">
                        <i class="fas fa-sign-out-alt me-1"></i>Ya, Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview-image');
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        function confirmLogout(event) {
            event.preventDefault();
            var logoutModal = new bootstrap.Modal(document.getElementById('logoutModal'));
            logoutModal.show();
        }

        // Validasi password match
        document.getElementById('confirm_password').addEventListener('input', function() {
            const newPassword = document.getElementById('new_password').value;
            const confirmPassword = this.value;
            
            if (newPassword !== confirmPassword) {
                this.setCustomValidity('Password tidak cocok');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>