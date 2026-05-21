<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK SMK Negeri 5 Jember</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        html {
            scroll-behavior: smooth;
        }

        html,
body {
    overflow-x: hidden;
    max-width: 100%;
}

* {
    box-sizing: border-box;
}

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            /* Gradasi linear dari atas ke bawah sesuai data Figma */
            background: linear-gradient(180deg,
                    #242562 0%,
                    #242562 23%,
                    #242562 59%,
                    #242562 100%);
            background-attachment: fixed;
            /* Membuat gradasi tetap saat di-scroll */
            min-height: 100vh;
        }


        .glass-card {
            background-image: url('{{ asset('images/landing page/Rectangle 74.png') }}');
            background-size: cover;
            background-position: center;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            cursor: pointer;

            transition:
                transform 0.35s ease,
                box-shadow 0.35s ease,
                border 0.35s ease;
        }

        .glass-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.35);

        }

        .glass-card img {
            transition: transform 0.35s ease;
        }

        .glass-card:hover img {
            transform: translateY(-6px) scale(1.08);
        }

        #navbar {
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>

<body class="bg-gradient-custom text-white selection:bg-purple-500 overflow-x-hidden">

    <div class="grid-pattern">
        <!-- Navbar -->
        <nav id="navbar"
            class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-5 md:px-10 py-3 md:py-4 transition-all duration-300 overflow-hidden"
            style="background-color: #242562;">
            <div class="flex items-center gap-2 min-w-0">
                <img src="{{ asset('images/landing page/logo.png') }}" alt="Logo SMK Negeri 5 Jember"
                     class="w-9 h-9 md:w-12 md:h-12 object-contain flex-shrink-0">
                <span class="font-bold tracking-wider text-sm uppercase leading-tight text-white truncate">
                    SMK NEGERI 5<br>JEMBER
                </span>
            </div>

            <div class="hidden md:flex gap-8 text-sm font-medium">
                <a href="#" class="text-white hover:text-yellow-400 transition">Home</a>
                <a href="#about" class="text-white hover:text-yellow-400 transition">About Us</a>
                <a href="#features" class="text-white hover:text-yellow-400 transition">Feature</a>
                <a href="#contact" class="text-white hover:text-yellow-400 transition">Contact</a>
            </div>

            <div class="flex items-center gap-2 flex-shrink-0">

    <a href="{{ route('login') }}"
        class="px-4 md:px-8 py-2 rounded-full text-xs md:text-sm font-semibold transition shadow-md"
        style="background-color: #393A97; color: white;">
        Login
    </a>

    <button id="hamburger" class="md:hidden text-white text-2xl leading-none">
        ☰
    </button>

</div>

        </nav>

        <div id="mobileMenu"
            class="hidden md:hidden fixed top-0 right-0 z-40 w-[80vw] w-64 h-screen text-white px-6 py-28 shadow-2xl"
            style="background-color: #242562;">
            <div class="flex flex-col gap-5 text-base font-medium">
                <a href="#" class="hover:text-yellow-400 transition">Home</a>
                <a href="#about" class="hover:text-yellow-400 transition">About Us</a>
                <a href="#features" class="hover:text-yellow-400 transition">Feature</a>
                <a href="#contact" class="hover:text-yellow-400 transition">Contact</a>
            </div>
        </div>

        <div id="overlay" class="hidden fixed inset-0 bg-black/40 z-30"></div>

        <!-- Hero Wrapper Utama -->
        <div class="relative w-full overflow-hidden">

            <!-- Layer 1: Background Dasar (bg1.jpeg) -->
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
                style="background-image: url('{{ asset('images/landing page/bg1.jpeg') }}');"></div>

            <!-- Layer 2: Overlay Gradient (Rectangle 72.png) -->
            <!-- Menimpa bg1 untuk transisi ke section bawahnya -->
            <div class="absolute inset-0 bg-cover bg-bottom bg-no-repeat z-[1]"
                style="background-image: url('{{ asset('images/landing page/Rectangle 72.png') }}');"></div>

            <!-- Spacer agar konten tidak tertutup navbar fixed -->
            <div class="h-24 relative z-10"></div>

            <!-- Hero Content -->
            <header class="relative z-10 container mx-auto px-4 py-16">
                <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-12 text-white">

                    <!-- Sisi Kiri: Teks -->
                    <div class="flex-1 text-left" data-aos="fade-right">
                        <h1 class="text-3xl font-bold leading-tight mb-6 uppercase tracking-wide">
                            Sistem Pendukung Keputusan<br>SMK Negeri 5 Jember
                        </h1>
                        <p class="text-gray-100 leading-relaxed text-sm md:text-base">
                            Sistem Pendukung Keputusan Jurusan Kuliah dan Magang SMK 5 Jember adalah platform berbasis
                            web yang membantu siswa menentukan pilihan secara objektif berdasarkan minat dan kriteria
                            tertentu. Dengan metode SAW, sistem menghitung dan menampilkan rekomendasi terbaik secara
                            otomatis, sementara guru dapat memantau hasil dan admin mengelola data secara terpusat.
                        </p>
                    </div>

                    <!-- Sisi Kanan: Gambar Sekolah -->
                    <div class="flex-1 flex justify-end" data-aos="fade-left">
                        <img src="{{ asset('images/landing page/sekolah.png') }}" alt="Gedung SMK Negeri 5 Jember"
                            class="w-full max-w-sm drop-shadow-2xl">
                    </div>
                </div>

                <!-- Bagian Bawah: Kartu Pilihan -->
                <div class="max-w-5xl mx-auto mt-16 grid grid-cols-1 md:grid-cols-2 gap-8 text-white">

                    <div class="glass-card p-8 flex items-center justify-start gap-6" data-aos="fade-up">
                        <img src="{{ asset('images/landing page/image 11.png') }}" alt="SPK PKL"
                            class="w-20 h-20 object-contain">

                        <h3 class="font-bold text-lg uppercase tracking-wider text-left leading-tight">
                            SPK Pemilihan<br>Tempat Praktek Kerja Lapangan
                        </h3>
                    </div>

                    <div class="glass-card p-8 flex items-center justify-start gap-6" data-aos="fade-up">
                        <img src="{{ asset('images/landing page/image 10.png') }}" alt="SPK Program Studi"
                            class="w-20 h-20 object-contain">

                        <h3 class="font-bold text-lg uppercase tracking-wider text-left leading-tight">
                            SPK Pemilihan<br>Program Studi Kuliah
                        </h3>
                    </div>

                </div>
            </header>
        </div>

        <!-- About Us -->
        <section id="about" class="container mx-auto px-10 py-24 text-center">
            <h2 class="text-3xl font-bold uppercase mb-16 tracking-widest">About Us</h2>

            <div class="flex flex-col md:flex-row items-center gap-16 mb-20">
                <div class="flex-1 flex justify-center" data-aos="fade-right">
                    <img src="{{ asset('images/landing page/image 12.png') }}" alt="About" class="w-64">
                </div>
                <div class="flex-1 text-left" data-aos="fade-left">
                    <p class="text-gray-300 leading-relaxed">
                        Sistem Pendukung Keputusan Jurusan Kuliah dan Magang SMK 5 Jember adalah platform berbasis web
                        yang membantu siswa menentukan pilihan jurusan kuliah dan tempat magang secara lebih tepat dan
                        objektif. Sistem ini mengolah data minat, preferensi, dan kriteria penilaian untuk menghasilkan
                        rekomendasi terbaik yang sesuai dengan potensi masing-masing siswa.
                    </p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row-reverse items-center gap-16">
                <div class="flex-1 flex justify-center" data-aos="fade-left">
                    <img src="{{ asset('images/landing page/image 13.png') }}" alt="Scale" class="w-64">
                </div>
                <div class="flex-1 text-left" data-aos="fade-right">
                    <p class="text-gray-300 leading-relaxed">
                        Dengan menggunakan metode Simple Additive Weighting (SAW), sistem ini mampu melakukan
                        perhitungan dan perangkingan secara otomatis, sehingga siswa tidak lagi bergantung pada
                        perkiraan atau keputusan subjektif. Guru dapat memantau perkembangan siswa, sementara admin
                        mengelola seluruh data secara terpusat dalam satu sistem yang terintegrasi.
                    </p>
                </div>
            </div>
        </section>

        <!-- Features -->
        <div class="relative w-full overflow-hidden">

            <!-- Layer 1: Background utama -->
            <div class="absolute inset-0 bg-cover bg-center bg-no-repeat z-0"
                style="background-image: url('{{ asset('images/landing page/bg1.jpeg') }}');">
            </div>

            <!-- Layer 2: Overlay ATAS (Rectangle 72) -->
            <div class="absolute inset-0 bg-cover bg-top bg-no-repeat z-[1]"
                style="background-image: url('{{ asset('images/landing page/Rectangle 72.png') }}');">
            </div>

            <!-- Layer 3: Overlay BAWAH (Rectangle 73) -->
            <div class="absolute inset-0 bg-cover bg-bottom bg-no-repeat z-[1]"
                style="background-image: url('{{ asset('images/landing page/Rectangle 73.png') }}');">
            </div>

            <!-- Content -->
            <section id="features" class="relative z-10 container mx-auto px-10 py-24">

                <h2 class="text-3xl font-bold uppercase text-center mb-16 tracking-widest">
                    FEATURES
                </h2>

                <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- SPK PKL -->
                    <div class="glass-card px-6 py-6 flex flex-col md:flex-row items-center md:items-center gap-4 md:gap-6 text-center md:text-left" data-aos="fade-right">
                        <img src="{{ asset('images/landing page/image 15.png') }}"
                            alt="SPK Pemilihan Tempat Praktek Kerja Lapangan" class="w-24 h-24 md:w-28 md:h-28 object-contain">

                        <div class="w-full">
                            <h4 class="font-bold uppercase mb-2 text-base leading-tight">
                                SPK Pemilihan Tempat<br>
                                Praktek Kerja Lapangan
                            </h4>
                            <p class="text-xs text-white leading-relaxed">
                                Sistem membantu siswa menentukan tempat PKL terbaik berdasarkan kriteria seperti minat,
                                kemampuan, dan preferensi lalu menghasilkan rekomendasi melalui perhitungan metode SAW
                                secara otomatis.
                            </p>
                        </div>
                    </div>

                    <!-- SPK Jurusan Kuliah -->
                    <div class="glass-card px-6 py-6 flex flex-col md:flex-row items-center md:items-center gap-4 md:gap-6 text-center md:text-left" data-aos="fade-left">
                        <img src="{{ asset('images/landing page/image 14.png') }}" alt="SPK Pemilihan Jurusan Kuliah"
                            class="w-24 h-24 md:w-28 md:h-28 object-contain">

                        <div class="w-full">
                            <h4 class="font-bold uppercase mb-2 text-base leading-tight">
                                SPK Pemilihan Jurusan<br>
                                Kuliah
                            </h4>
                            <p class="text-xs text-white leading-relaxed">
                                Sistem memberikan rekomendasi jurusan kuliah yang paling sesuai dengan potensi siswa
                                melalui analisis data kuesioner dan perankingan berbasis metode SAW.
                            </p>
                        </div>
                    </div>

                    <!-- Dashboard Guru -->
                    <div class="glass-card px-6 py-6 flex flex-col md:flex-row items-center md:items-center gap-4 md:gap-6 text-center md:text-left" data-aos="fade-right">
                        <img src="{{ asset('images/landing page/image 17.png') }}" alt="Dashboard Guru"
                            class="w-24 h-24 md:w-28 md:h-28 object-contain">

                        <div class="w-full">
                            <h4 class="font-bold uppercase mb-2 text-base leading-tight">
                                Dashboard<br>
                                Guru
                            </h4>
                            <p class="text-xs text-white leading-relaxed">
                                Guru dapat memantau data siswa, melihat hasil rekomendasi, serta mengevaluasi kecocokan
                                pilihan siswa secara terpusat dalam satu tampilan.
                            </p>
                        </div>
                    </div>

                    <!-- Dashboard Admin -->
                    <div class="glass-card px-6 py-6 flex flex-col md:flex-row items-center md:items-center gap-4 md:gap-6 text-center md:text-left" data-aos="fade-right">
                        <img src="{{ asset('images/landing page/image 18.png') }}" alt="Dashboard Admin"
                            class="w-28 h-28 object-contain">

                        <div>
                            <h4 class="font-bold uppercase mb-2 text-base leading-tight">
                                Dashboard<br>
                                Admin
                            </h4>
                            <p class="text-xs text-white leading-relaxed">
                                Admin mengelola seluruh data sistem, termasuk data kriteria, jurusan, dan tempat PKL,
                                serta memastikan sistem berjalan dengan baik melalui fitur CRUD yang tersedia.
                            </p>
                        </div>
                    </div>

                </div>
            </section>
        </div>
        <!-- Contact Section -->
        <section id="contact" class="bg-[#242562] px-10 py-24 text-center">

        </section>
    </div>

    <!-- Footer -->
    <footer class="bg-[#323388] text-white py-16">
        <div class="container mx-auto px-10 grid grid-cols-1 md:grid-cols-3 gap-14">

            <!-- Lokasi -->
            <div>
                <h5 class="font-bold text-2xl mb-5 border-b border-white/20 pb-3 inline-block">
                    Lokasi
                </h5>

                <div class="w-full h-48 bg-gray-200 rounded-xl overflow-hidden mt-6 shadow-lg">
                    <iframe
                        src="https://www.google.com/maps?q=SMK%20Negeri%205%20Jember%2C%20Jl.%20Brawijaya%20No.55%2C%20Darungan%2C%20Jubung%2C%20Kec.%20Sukorambi%2C%20Kabupaten%20Jember%2C%20Jawa%20Timur%2068151&output=embed"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <p class="text-base font-semibold mt-4">
                    SMK Negeri 5 Jember
                </p>
            </div>

            <!-- Kontak -->
            <div>
                <h5 class="font-bold text-2xl mb-5 border-b border-white/20 pb-3 inline-block">
                    Kontak Resmi SMKN 5 Jember
                </h5>

                <div class="mt-6 space-y-5 text-base leading-relaxed">
                    <div>
                        <p class="font-bold mb-1">Alamat:</p>
                        <p class="text-white/90">
                            Jl. Brawijaya No.55, Darungan, Jubung, Kec. Sukorambi,
                            Kabupaten Jember, Jawa Timur 68151, Indonesia
                        </p>
                    </div>

                    <div>
                        <p class="font-bold mb-1">Email:</p>
                        <p class="text-white/90">
                            smkn5jember@gmail.com
                        </p>
                    </div>
                </div>
            </div>

            <!-- Link Terkait -->
            <div>
                <h5 class="font-bold text-2xl mb-5 border-b border-white/20 pb-3 inline-block">
                    Link Terkait
                </h5>

                <ul class="mt-6 text-base space-y-4 font-medium">
                    <li>
                        <a href="#" class="hover:underline hover:text-yellow-300 transition">
                            › Profil Sekolah
                        </a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline hover:text-yellow-300 transition">
                            › Data Lulusan (SISKOTIK)
                        </a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline hover:text-yellow-300 transition">
                            › E-Learning
                        </a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline hover:text-yellow-300 transition">
                            › SMK PK Th 2022-2023
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </footer>

    <script>
        const navbar = document.getElementById('navbar');
        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobileMenu');
        const overlay = document.getElementById('overlay');

        let lastScrollY = window.scrollY;

        hamburger.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            overlay.classList.toggle('hidden');
        });

        overlay.addEventListener('click', function() {
            mobileMenu.classList.add('hidden');
            overlay.classList.add('hidden');
        });

        window.addEventListener('scroll', function() {
            if (window.scrollY > lastScrollY) {
                navbar.style.transform = 'translateY(-100%)';
                mobileMenu.classList.add('hidden');
                overlay.classList.add('hidden');
            } else {
                navbar.style.transform = 'translateY(0)';
            }

            lastScrollY = window.scrollY;
        });
    </script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 900,
            once: true,
            offset: 120
        });
    </script>

</body>

</html>
