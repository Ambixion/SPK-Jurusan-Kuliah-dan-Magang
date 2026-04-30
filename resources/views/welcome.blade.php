<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK SMK Negeri 5 Jember</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
 body {
    font-family: 'Inter', sans-serif;
    margin: 0;
    /* Gradasi linear dari atas ke bawah sesuai data Figma */
    background: linear-gradient(
        180deg, 
        #242562 0%, 
        #323388 23%, 
        #5859B8 59%, 
        #494BC8 100%
    );
    background-attachment: fixed; /* Membuat gradasi tetap saat di-scroll */
    min-height: 100vh;
}

.hero-wrapper {
    position: relative;
    width: 100%;
}
    </style>
</head>
<body class="bg-gradient-custom text-white selection:bg-purple-500">

    <div class="grid-pattern">
     <!-- Navbar -->
<nav class="fixed top-0 left-0 right-0 z-50 flex items-center justify-between px-10 py-4 transition-all duration-300" style="background-color: #242562;">
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/logo.png') }}" alt="Logo SMK Negeri 5 Jember" class="w-12 h-12 object-contain">
        <span class="font-bold tracking-wider text-sm uppercase leading-tight text-white">
            SMK NEGERI 5<br>JEMBER
        </span>
    </div>

    <div class="hidden md:flex gap-8 text-sm font-medium">
        <a href="#" class="text-white hover:text-yellow-400 transition">Home</a>
        <a href="#about" class="text-white hover:text-yellow-400 transition">About Us</a>
        <a href="#features" class="text-white hover:text-yellow-400 transition">Feature</a>
        <a href="#contact" class="text-white hover:text-yellow-400 transition">Contact</a>
    </div>

    <a href="/login" class="px-8 py-2 rounded-full text-sm font-semibold transition shadow-md" style="background-color: #393A97; color: white;">
        Login
    </a>
</nav>

<!-- Hero Wrapper Utama -->
<div class="relative w-full overflow-hidden">
    
    <!-- Layer 1: Background Dasar (bg1.jpeg) -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('images/bg1.jpeg') }}');"></div>

    <!-- Layer 2: Overlay Gradient (Rectangle 72.png) -->
    <!-- Menimpa bg1 untuk transisi ke section bawahnya -->
    <div class="absolute inset-0 bg-cover bg-bottom bg-no-repeat z-[1]" 
         style="background-image: url('{{ asset('images/Rectangle 72.png') }}');"></div>

    <!-- Spacer agar konten tidak tertutup navbar fixed -->
    <div class="h-24 relative z-10"></div>

    <!-- Hero Content -->
    <header class="relative z-10 container mx-auto px-4 py-16">
        <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-12 text-white">
            
            <!-- Sisi Kiri: Teks -->
            <div class="flex-1 text-left">
                <h1 class="text-3xl font-bold leading-tight mb-6 uppercase tracking-wide">
                    Sistem Pendukung Keputusan<br>SMK Negeri 5 Jember
                </h1>
                <p class="text-gray-100 leading-relaxed text-sm md:text-base">
                    Sistem Pendukung Keputusan Jurusan Kuliah dan Magang SMK 5 Jember adalah platform berbasis web yang membantu siswa menentukan pilihan secara objektif berdasarkan minat dan kriteria tertentu. Dengan metode SAW, sistem menghitung dan menampilkan rekomendasi terbaik secara otomatis, sementara guru dapat memantau hasil dan admin mengelola data secara terpusat.
                </p>
            </div>

            <!-- Sisi Kanan: Gambar Sekolah -->
            <div class="flex-1 flex justify-end">
                <img src="{{ asset('images/sekolah.png') }}" 
                     alt="Gedung SMK Negeri 5 Jember" 
                     class="w-full max-w-sm drop-shadow-2xl"> 
            </div>
        </div>

        <!-- Bagian Bawah: Kartu Pilihan -->
        <div class="max-w-5xl mx-auto mt-16 grid grid-cols-1 md:grid-cols-2 gap-8 text-white">
            <div class="glass-card p-8 flex flex-col items-center justify-center gap-4 group hover:bg-white/20 transition border border-white/10 shadow-xl">
                <div class="w-20 h-20 bg-blue-500/30 rounded-2xl flex items-center justify-center text-4xl">
                    🏢
                </div>
                <h3 class="font-bold text-lg uppercase tracking-wider text-center leading-tight">
                    SPK Pemilihan<br>Tempat Praktek Kerja Lapangan
                </h3>
            </div>

            <div class="glass-card p-8 flex flex-col items-center justify-center gap-4 group hover:bg-white/20 transition border border-white/10 shadow-xl">
                <div class="w-20 h-20 bg-purple-500/30 rounded-2xl flex items-center justify-center text-4xl">
                    🎓
                </div>
                <h3 class="font-bold text-lg uppercase tracking-wider text-center leading-tight">
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
                <div class="flex-1 flex justify-center">
                    <img src="https://illustrations.popsy.co/white/location.svg" alt="About" class="w-64">
                </div>
                <div class="flex-1 text-left">
                    <p class="text-gray-300 leading-relaxed">
                        Sistem Pendukung Keputusan Jurusan Kuliah dan Magang SMK 5 Jember adalah platform berbasis web yang membantu siswa menentukan pilihan jurusan kuliah dan tempat magang secara lebih tepat dan objektif. Sistem ini mengolah data minat, preferensi, dan kriteria penilaian untuk menghasilkan rekomendasi terbaik yang sesuai dengan potensi masing-masing siswa.
                    </p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row-reverse items-center gap-16">
                <div class="flex-1 flex justify-center">
                    <img src="https://illustrations.popsy.co/white/balance-scale.svg" alt="Scale" class="w-64">
                </div>
                <div class="flex-1 text-left">
                    <p class="text-gray-300 leading-relaxed">
                        Dengan menggunakan metode Simple Additive Weighting (SAW), sistem ini mampu melakukan perhitungan dan perangkingan secara otomatis, sehingga siswa tidak lagi bergantung pada perkiraan atau keputusan subjektif. Guru dapat memantau perkembangan siswa, sementara admin mengelola seluruh data secara terpusat dalam satu sistem yang terintegrasi.
                    </p>
                </div>
            </div>
        </section>

        <!-- Features -->
        <section id="features" class="container mx-auto px-10 py-24">
            <h2 class="text-3xl font-bold uppercase text-center mb-16 tracking-widest">Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- PKL -->
                <div class="glass-card p-8 flex gap-6">
                    <div class="text-4xl">🏭</div>
                    <div>
                        <h4 class="font-bold uppercase mb-2">SPK Pemilihan Tempat Praktek Kerja Lapangan</h4>
                        <p class="text-xs text-gray-400">Sistem membantu siswa menentukan tempat PKL terbaik berdasarkan kriteria seperti minat, kemampuan, dan preferensi lalu menghasilkan rekomendasi melalui perhitungan metode SAW secara otomatis.</p>
                    </div>
                </div>
                <!-- Jurusan -->
                <div class="glass-card p-8 flex gap-6">
                    <div class="text-4xl">👨‍🎓</div>
                    <div>
                        <h4 class="font-bold uppercase mb-2">SPK Pemilihan Jurusan Kuliah</h4>
                        <p class="text-xs text-gray-400">Sistem memberikan rekomendasi jurusan kuliah yang paling sesuai dengan potensi siswa melalui analisis data kuesioner dan perankingan berbasis metode SAW.</p>
                    </div>
                </div>
                <!-- Guru -->
                <div class="glass-card p-8 flex gap-6">
                    <div class="text-4xl">👨‍🏫</div>
                    <div>
                        <h4 class="font-bold uppercase mb-2">Dashboard Guru</h4>
                        <p class="text-xs text-gray-400">Guru dapat memantau data siswa, melihat hasil rekomendasi, serta mengevaluasi kecocokan pilihan siswa secara terpusat dalam satu tampilan.</p>
                    </div>
                </div>
                <!-- Admin -->
                <div class="glass-card p-8 flex gap-6">
                    <div class="text-4xl">⚙️</div>
                    <div>
                        <h4 class="font-bold uppercase mb-2">Dashboard Admin</h4>
                        <p class="text-xs text-gray-400">Admin mengelola seluruh data sistem, termasuk data kriteria, jurusan, dan tempat PKL, serta memastikan sistem berjalan dengan baik melalui fitur CRUD yang tersedia.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="container mx-auto px-10 py-24 text-center">
            <h2 class="text-3xl font-bold uppercase mb-10 tracking-widest">Contact</h2>
        </section>
    </div>

    <!-- Footer -->
    <footer class="bg-green-600 text-white py-12">
        <div class="container mx-auto px-10 grid grid-cols-1 md:grid-cols-3 gap-10">
            <div>
                <h5 class="font-bold mb-4 border-b border-white/20 pb-2 inline-block">Lokasi</h5>
                <div class="w-full h-40 bg-gray-200 rounded-lg overflow-hidden mt-4">
                    <!-- Placeholder Map -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.3361184347784!2d113.7196024!3d-8.1688537!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd69596489a244d%3A0x6b864117b4430e3!2sSMK%20Negeri%205%20Jember!5e0!3m2!1sid!2sid!4v1714480000000" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                <p class="text-xs mt-2">SMK Negeri 5 Jember</p>
            </div>
            <div>
                <h5 class="font-bold mb-4 border-b border-white/20 pb-2 inline-block">Kontak Resmi SMK N 5 Jember</h5>
                <div class="flex items-start gap-4 mt-4">
                    <div class="bg-white p-1 rounded"><img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=SMKN5JEMBER" alt="QR" class="w-20"></div>
                    <div class="text-xs space-y-2">
                        <p>Alamat: JL. BRAWIJAYA NO. 55 JEMBER</p>
                        <p>Email: smkn5jember@gmail.com</p>
                        <p>WhatsApp: +62 8XX XXXX XXXX</p>
                    </div>
                </div>
            </div>
            <div>
                <h5 class="font-bold mb-4 border-b border-white/20 pb-2 inline-block">Link Terkait</h5>
                <ul class="text-xs space-y-2">
                    <li><a href="#" class="hover:underline">› Profil Sekolah</a></li>
                    <li><a href="#" class="hover:underline">› Data Lulusan (SISKOTIK)</a></li>
                    <li><a href="#" class="hover:underline">› E-Learning</a></li>
                    <li><a href="#" class="hover:underline">› SMK PK Th 2022-2023</a></li>
                </ul>
            </div>
        </div>
    </footer>

</body>
</html>