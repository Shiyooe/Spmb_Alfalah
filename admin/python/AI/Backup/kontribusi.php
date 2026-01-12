<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontribusi - SPMB Alfalah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="x-icon" href="../../../img/Alfalah.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 1.5s ease-in-out;
        }

        /* Animasi scroll horizontal kiri ke kanan */
        @keyframes scrollLTR {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(0);
            }
        }

        .scroll-container {
            overflow: hidden;
            position: relative;
            width: 100%;
            padding: 1rem 0;
        }

        .scroll-content-horizontal {
            display: flex;
            align-items: center;
            gap: 1rem;
            width: max-content;
        }

        .scroll-content-horizontal img {
            flex-shrink: 0;
        }

        .scroll-ltr {
            animation: scrollLTR 40s linear infinite;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .scroll-container:hover .scroll-ltr {
            animation-play-state: paused;
        }

        .static-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            padding: 1rem 0;
            flex-wrap: wrap;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="max-w-4xl mx-auto px-4 py-6">
        <!-- Navigasi -->
        <nav class="flex items-center mb-8">
            <a href="javascript:history.back()"
                class="flex items-center text-blue-700 font-medium hover:text-blue-900 transition-all duration-300 hover:-translate-x-1">
                <i class="bi bi-arrow-left text-xl mr-2"></i> Back
            </a>
        </nav>

        <!-- Judul dengan animasi -->
        <div class="text-center mb-10 p-6 bg-gradient-to-br from-blue-700 to-blue-500 rounded-xl shadow-lg">
            <h1 class="text-2xl md:text-3xl font-semibold text-white tracking-wide animate-fade-in">
                Yang Mengerjakan Tugas Web SPMB Alfalah
            </h1>
        </div>

        <!-- Bagian UI/UX -->
        <section class="bg-white rounded-xl p-6 mb-6 shadow-md transition-transform duration-300 hover:-translate-y-1">
            <div class="flex items-center mb-5 pb-2 border-b border-gray-200">
                <i class="bi bi-palette-fill text-2xl text-blue-700 mr-3"></i>
                <h2 class="text-xl font-semibold text-blue-700">UI/UX Design</h2>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                <span class="font-semibold text-blue-700">Rizki Rhamdani</span>
                <span class="text-gray-600 md:text-right mt-1 md:mt-0">Full Desain dan coding frontend khusus tampilan user PC serta HP</span>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                <span class="font-semibold text-blue-700">Regat</span>
                <span class="text-gray-600 md:text-right mt-1 md:mt-0">Desain</span>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                <span class="font-semibold text-blue-700">Muhammad Yusuf Akrom</span>
                <span class="text-gray-600 md:text-right mt-1 md:mt-0">Full pegang bagian Admin</span>
            </div>
        </section>

        <!-- Bagian Backend -->
        <section class="bg-white rounded-xl p-6 mb-6 shadow-md transition-transform duration-300 hover:-translate-y-1">
            <div class="flex items-center mb-5 pb-2 border-b border-gray-200">
                <i class="bi bi-code-slash text-2xl text-blue-700 mr-3"></i>
                <h2 class="text-xl font-semibold text-blue-700">Backend Development</h2>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                <span class="font-semibold text-blue-700">Muhammad Yusuf Akrom</span>
                <span class="text-gray-600 md:text-right mt-1 md:mt-0">Coding backend semua</span>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                <span class="font-semibold text-blue-700">Dimas</span>
                <span class="text-gray-600 md:text-right mt-1 md:mt-0">Ngebackup Login dan Registrasi</span>
            </div>
        </section>

        <!-- Bagian Database -->
        <section class="bg-white rounded-xl p-6 mb-6 shadow-md transition-transform duration-300 hover:-translate-y-1">
            <div class="flex items-center mb-5 pb-2 border-b border-gray-200">
                <i class="bi bi-database-fill text-2xl text-blue-700 mr-3"></i>
                <h2 class="text-xl font-semibold text-blue-700">Database</h2>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                <span class="font-semibold text-blue-700">Muhammad Rival Rhamdani</span>
                <span class="text-gray-600 md:text-right mt-1 md:mt-0">Excel, StarUML, dan SQL</span>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                <span class="font-semibold text-blue-700">Muhammad Sandi</span>
                <span class="text-gray-600 md:text-right mt-1 md:mt-0">Bagian Excel</span>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                <span class="font-semibold text-blue-700">Muhammad Yusuf Akrom</span>
                <span class="text-gray-600 md:text-right mt-1 md:mt-0">Ngebackup SQL</span>
            </div>
        </section>

        <section class="bg-white rounded-xl p-6 mb-6 shadow-md transition-transform duration-300 hover:-translate-y-1">
            <div class="flex items-center mb-5 pb-2 border-b border-gray-200">
                <i class="bi bi-code-square text-2xl text-blue-700 mr-3"></i>
                <h2 class="text-xl font-semibold text-blue-700">Mengcoding</h2>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                <span class="font-semibold text-blue-700">Rizki Rhamdani</span>
                <span class="text-gray-600 md:text-right mt-1 md:mt-0">Coding tampilan</span>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                <span class="font-semibold text-blue-700">Muhammad Yusuf Akrom</span>
                <span class="text-gray-600 md:text-right mt-1 md:mt-0">Coding Backend</span>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between mb-4 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                <span class="font-semibold text-blue-700">Dimas Saputra</span>
                <span class="text-gray-600 md:text-right mt-1 md:mt-0">Coding Tampilan</span>
            </div>
        </section>

        <!-- Section 1: Static - Web Users (TIDAK SCROLL) -->
        <section class="mt-10 mb-8">
            <h2 class="text-center text-xl font-semibold text-blue-700 mb-6">Web Bagian users, siswa dan ortu menggunakan bahasa Pemrograman</h2>
            <div class="static-container">
                <img src="img/html.jpg" alt="HTML" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <img src="img/css.webp" alt="CSS" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <img src="img/javascript.webp" alt="JavaScript" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <img src="img/php.png" alt="PHP" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            </div>
        </section>

        <!-- Section 2: Infinite Scroll - Web Admin (SCROLL KIRI KE KANAN) -->
        <!-- Section 2: Scroll Kiri ke Kanan -->
        <section class="mt-10 mb-8">
            <h2 class="text-center text-xl font-semibold text-blue-700 mb-6">Web Bagian Admin menggunakan bahasa Pemrograman</h2>
            <div class="scroll-container py-4">
                <div class="scroll-content-horizontal scroll-ltr">
                    <!-- Set pertama -->
                    <img src="img/html.jpg" alt="HTML" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/css.webp" alt="CSS" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/javascript.webp" alt="JavaScript" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/php.png" alt="PHP" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/nodejs-logo.png" alt="Node.js" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/boot.avif" alt="Bootstrap" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/react.png" alt="React" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/tailwind.png" alt="Tailwind" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/html.jpg" alt="HTML" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/css.webp" alt="CSS" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/javascript.webp" alt="JavaScript" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/php.png" alt="PHP" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/nodejs-logo.png" alt="Node.js" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/boot.avif" alt="Bootstrap" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/react.png" alt="React" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/tailwind.png" alt="Tailwind" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">


                    <!-- Set duplikat untuk seamless loop -->
                    <img src="img/html.jpg" alt="HTML" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/css.webp" alt="CSS" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/javascript.webp" alt="JavaScript" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/php.png" alt="PHP" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/nodejs-logo.png" alt="Node.js" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/boot.avif" alt="Bootstrap" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/react.png" alt="React" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/tailwind.png" alt="Tailwind" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/html.jpg" alt="HTML" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/css.webp" alt="CSS" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/javascript.webp" alt="JavaScript" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/php.png" alt="PHP" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/nodejs-logo.png" alt="Node.js" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/boot.avif" alt="Bootstrap" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/react.png" alt="React" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                    <img src="img/tailwind.png" alt="Tailwind" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex-shrink-0">
                </div>
            </div>
        </section>

        <!-- Section 3: Static - Lainnya (TIDAK SCROLL) -->
        <section class="mt-10 mb-8">
            <h2 class="text-center text-xl font-semibold text-blue-700 mb-6">Lainnya</h2>
            <div class="static-container">
                <img src="img/laragon.png" alt="Laragon" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <img src="img/api.webp" alt="API" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <img src="img/sql.jpg" alt="SQL" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <img src="img/exce.webp" alt="Excel" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
                <img src="img/staruml.png" alt="StarUML" class="w-24 h-24 object-cover rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300">
            </div>
        </section>

    </div>
</body>

</html>