<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Password Reset Page">
    <meta name="author" content="">
    <title>Password Reset - SB Admin</title>
    
    <!-- Stylesheets -->
    <link href="../../css/styles.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="../../img/Alfalah.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        /* ========== GLOBAL STYLES ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #fff;
            background-image: url('../../img/blyat.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ========== LAYOUT ========== */
        #layoutAuthentication {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #layoutAuthentication_content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* ========== CARD GLASSMORPHISM ========== */
        .card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            color: #fff;
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1.5rem;
        }

        .card-header h3 {
            font-weight: 400;
            margin: 0;
            color: #000;
        }

        .card-body {
            padding: 2rem;
        }

        .card-footer {
            background-color: transparent;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem;
            text-align: center;
        }

        /* ========== FORM STYLES ========== */
        .form-floating {
            position: relative;
            margin-bottom: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 1rem 0.75rem;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 0.5rem;
            color: #000;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            color: #000;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.1);
        }

        .form-control::placeholder {
            color: rgba(0, 0, 0, 0.5);
        }

        .form-floating > label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 1rem 0.75rem;
            pointer-events: none;
            color: #000;
            transition: all 0.3s ease;
        }

        .form-control:focus ~ label,
        .form-control:not(:placeholder-shown) ~ label {
            top: -0.5rem;
            left: 0.5rem;
            font-size: 0.75rem;
            background: rgba(255, 255, 255, 0.8);
            padding: 0.2rem 0.5rem;
            border-radius: 0.25rem;
        }

        /* ========== TEXT STYLES ========== */
        .small {
            font-size: 0.875rem;
        }

        .text-muted {
            color: #000 !important;
            opacity: 0.7;
        }

        /* ========== BUTTON STYLES ========== */
        .btn {
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background-color: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #000;
        }

        .btn-primary:hover {
            background-color: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* ========== LINK STYLES ========== */
        a {
            color: #000;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        a:hover {
            color: #333;
            text-decoration: underline;
        }

        /* ========== UTILITY CLASSES ========== */
        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .py-3 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        /* ========== FOOTER STYLES ========== */
        #layoutAuthentication_footer {
            margin-top: auto;
        }

        footer {
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            color: #eee;
            padding: 1.5rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        footer .container-fluid {
            padding: 0 1.5rem;
        }

        footer .text-muted {
            color: #ccc !important;
        }

        footer a {
            color: #fff;
        }

        footer a:hover {
            color: #ddd;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            .d-flex {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div id="layoutAuthentication">
        <!-- Main Content -->
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="card">
                        <!-- Card Header -->
                        <div class="card-header">
                            <h3 class="text-center">Password Recovery</h3>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="small mb-3 text-muted">
                                Enter your email address and we will send you a link to reset your password.
                            </div>

                            <form>
                                <!-- Email Input -->
                                <div class="form-floating mb-3">
                                    <input 
                                        class="form-control" 
                                        id="inputEmail" 
                                        type="email" 
                                        placeholder="name@example.com"
                                        required
                                    >
                                    <label for="inputEmail">Email address</label>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a class="small" href="login.php">Return to login</a>
                                    <a class="btn btn-primary" href="login.php">Reset Password</a>
                                </div>
                            </form>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer py-3">
                            <div class="small">
                                <a href="register.php">Need an account? Sign up!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Footer -->
        <div id="layoutAuthentication_footer">
            <footer>
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>