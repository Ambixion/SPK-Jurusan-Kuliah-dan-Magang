# 🎓 SPK Pemilihan Jurusan Kuliah & Tempat Magang

Sistem Pendukung Keputusan (SPK) berbasis web untuk membantu siswa dalam menentukan **jurusan kuliah** dan **tempat magang** yang paling sesuai berdasarkan kriteria tertentu menggunakan metode **Simple Additive Weighting (SAW)**.

---

## 📌 Latar Belakang

Banyak siswa mengalami kebingungan dalam menentukan jurusan kuliah maupun tempat magang karena harus mempertimbangkan berbagai faktor seperti minat, nilai akademik, dan jarak.

Oleh karena itu, sistem ini dibuat untuk membantu proses pengambilan keputusan secara **objektif, terstruktur, dan berbasis data**.

---

## 🎯 Tujuan

* Membantu siswa menentukan jurusan kuliah yang sesuai
* Memberikan rekomendasi tempat magang terbaik
* Mengimplementasikan metode **SAW** dalam sistem nyata
* Menerapkan konsep **DevOps menggunakan Docker**

---

## 🧠 Metode yang Digunakan

### 🔹 Simple Additive Weighting (SAW)

Metode SAW digunakan untuk melakukan perankingan alternatif berdasarkan beberapa kriteria.

**Tahapan:**

1. Menentukan kriteria dan bobot
2. Normalisasi nilai
3. Perhitungan nilai preferensi
4. Perankingan hasil

---

## 🗂️ Fitur Sistem

* 👤 **Admin**

  * CRUD data (kriteria, jurusan, tempat magang, user)

* 👨‍🏫 **Guru**

  * Monitoring data siswa
  * Input data yang dibutuhkan

* 👨‍🎓 **Siswa**

  * Mengisi kuisioner minat
  * Melihat hasil rekomendasi

* ⚙️ **Sistem SPK**

  * Perhitungan otomatis menggunakan metode SAW
  * Menampilkan ranking jurusan & tempat magang

---

## 🧱 Struktur Database (Singkat)

Beberapa tabel utama:

* `users`
* `siswa`
* `kriteria`
* `jurusan_kuliah`
* `tempat_magang`
* `skor_siswa`
* `skor_jurusan`
* `hasil_jurusan`
* `hasil_magang`

---

## ⚙️ Teknologi yang Digunakan

* Laravel (Backend)
* MySQL (Database)
* Docker (DevOps)
* PHP

---

## 🚀 Cara Menjalankan Project

### 🔹 Tanpa Docker

```bash
git clone <repository>
cd project

composer install
cp .env.example .env
php artisan key:generate

php artisan migrate
php artisan db:seed

php artisan serve
```

---

### 🔹 Menggunakan Docker

```bash
docker-compose up --build
```

---

## 📊 Contoh Hasil

Sistem akan menghasilkan ranking seperti:

1. Teknik Informatika → 0.97
2. Sistem Informasi → 0.88
3. DKV → 0.80

---

## 📈 Pengembangan Selanjutnya

* Implementasi metode **AHP** untuk penentuan bobot
* Integrasi data real siswa
* UI/UX yang lebih interaktif
* Deployment ke server

---

## 👨‍💻 Developer

Dibuat oleh mahasiswa sebagai bagian dari **Project Based Learning (PBL)**.

---

## 📌 Catatan

Project ini masih dalam tahap pengembangan dan dapat mengalami perubahan sesuai kebutuhan.

---
