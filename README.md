# Sistem Pendukung Keputusan Pemilihan Jurusan Kuliah dan Tempat Magang

Sistem Pendukung Keputusan Pemilihan Jurusan Kuliah dan Tempat Magang merupakan aplikasi berbasis web yang dikembangkan untuk membantu proses pengambilan keputusan dalam menentukan jurusan kuliah dan tempat magang terbaik berdasarkan beberapa kriteria penilaian.

Sistem ini menggunakan metode Simple Additive Weighting (SAW) sebagai metode utama dalam proses perhitungan dan perangkingan alternatif sehingga hasil rekomendasi dapat lebih objektif, terstruktur, dan mudah dipahami.

---

# Tentang Project

Pemilihan jurusan kuliah dan tempat magang sering menjadi tantangan bagi siswa karena banyaknya pilihan yang tersedia. Tidak sedikit pengguna mengalami kesulitan dalam menentukan pilihan yang sesuai dengan kemampuan, minat, maupun kebutuhan mereka.

Melalui project ini, sistem dibangun untuk membantu pengguna mendapatkan rekomendasi terbaik berdasarkan kriteria tertentu menggunakan pendekatan Sistem Pendukung Keputusan (SPK).

---

# Metode yang Digunakan

Project ini menggunakan metode Simple Additive Weighting (SAW).

Simple Additive Weighting merupakan metode pengambilan keputusan multikriteria yang bekerja dengan cara:

* Menentukan kriteria penilaian
* Memberikan bobot pada setiap kriteria
* Melakukan normalisasi data
* Menghitung nilai preferensi
* Menentukan ranking alternatif terbaik

Metode SAW dipilih karena:

* Mudah diimplementasikan
* Perhitungan lebih cepat
* Cocok untuk proses ranking
* Hasil mudah dipahami pengguna

---

# Fitur Utama

## Dashboard Admin

* Menampilkan total data jurusan kuliah
* Menampilkan total data tempat magang
* Menampilkan total program studi
* Card interaktif untuk melihat detail data
* Statistik data sistem

## Manajemen Jurusan Kuliah

* Tambah data jurusan
* Edit data jurusan
* Hapus data jurusan
* Detail informasi jurusan
* Validasi data

## Manajemen Tempat Magang

* Tambah data tempat magang
* Edit data tempat magang
* Hapus data tempat magang
* Informasi perusahaan/tempat magang

## Manajemen Program Studi

* CRUD program studi
* Pengelompokan bidang studi
* Deskripsi program studi

## Sistem Pendukung Keputusan (SPK)

* Penentuan kriteria
* Penentuan bobot
* Normalisasi matriks
* Perhitungan metode SAW
* Perangkingan alternatif
* Hasil rekomendasi jurusan
* Hasil rekomendasi tempat magang

## Authentication

* Login admin
* Login guru
* Login siswa
* Session management
* Middleware authentication

---

# Teknologi yang Digunakan

## Backend

* PHP
* Laravel Framework

## Frontend

* Blade Template Engine
* Bootstrap
* JavaScript
* AJAX / Fetch API

## Database

* MySQL

## Tools

* Composer
* Git
* GitHub

---

# Struktur Menu Sistem

```bash id="v5s7mi"
├── Dashboard
├── Data Jurusan Kuliah
├── Data Tempat Magang
├── Data Program Studi
├── Data Kriteria
├── Data Bobot
├── Perhitungan SAW
├── Hasil Ranking
└── Authentication
```

---

# Alur Metode SAW

```text id="g6b3g1"
1. Menentukan alternatif
2. Menentukan kriteria
3. Memberikan bobot pada setiap kriteria
4. Membuat matriks keputusan
5. Melakukan normalisasi matriks
6. Menghitung nilai preferensi
7. Melakukan proses ranking
8. Menampilkan hasil rekomendasi terbaik
```

---


# Contoh Kriteria Penilaian

## Jurusan Kuliah

* Minat
* Nilai akademik
* Prospek kerja
* Biaya kuliah
* Kemampuan dasar

## Tempat Magang

* Lokasi
* Fasilitas
* Relevansi bidang
* Jam kerja
* Reputasi perusahaan

---

# Keunggulan Sistem

* Interface sederhana dan mudah digunakan
* Sistem perhitungan otomatis
* Proses ranking cepat
* Data terorganisir
* Mudah dikembangkan kembali
* Cocok untuk penelitian maupun pembelajaran

---

# Pengembangan Selanjutnya

Beberapa pengembangan yang dapat dilakukan:

* Export PDF dan Excel
* Grafik visualisasi data
* Sistem rekomendasi berbasis AI
* Multi role user
* REST API
* Responsive mobile interface
* Notifikasi sistem
* Riwayat hasil perhitungan

---

# Kontributor

Developer:

* Dagi
* Ali
* Bintang
* Ariel
* Nayla

GitHub:

* https://github.com/dugdugies

---

# License

Project ini dibuat untuk kebutuhan:

* Pembelajaran
* Penelitian
* Pengembangan sistem pendukung keputusan

Silakan gunakan dan kembangkan project ini sesuai kebutuhan.

