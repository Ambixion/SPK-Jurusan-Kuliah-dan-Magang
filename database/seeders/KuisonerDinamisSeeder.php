<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\JurusanKuliah;
use App\Models\Kriteria;
use App\Models\Kuisoner;
use App\Models\KuisonerOpsi;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class KuisonerDinamisSeeder extends Seeder
{
    public function run(): void
    {
        KuisonerOpsi::query()->delete();
        Kuisoner::query()->delete();

        $opsi = [
            ['jawaban' => 'Sangat Setuju',      'nilai' => 5],
            ['jawaban' => 'Setuju',              'nilai' => 4],
            ['jawaban' => 'Netral',              'nilai' => 3],
            ['jawaban' => 'Tidak Setuju',        'nilai' => 2],
            ['jawaban' => 'Sangat Tidak Setuju', 'nilai' => 1],
        ];

        $kj_minat = Kriteria::where('jenis', 'jurusan')->where('nama', 'Minat Bidang')->first();
        $kj_mampu = Kriteria::where('jenis', 'jurusan')->where('nama', 'Kemampuan')->first();
        $km_minat = Kriteria::where('jenis', 'magang')->where('nama', 'Minat Magang')->first();
        $km_mampu = Kriteria::where('jenis', 'magang')->where('nama', 'Kemampuan')->first();

        $jTI     = JurusanKuliah::where('nama', 'Teknik Informatika')->first();
        $jDKV    = JurusanKuliah::where('nama', 'Desain Komunikasi Visual')->first();
        $jSI     = JurusanKuliah::where('nama', 'Sistem Informasi')->first();
        $jAgri   = JurusanKuliah::where('nama', 'Agribisnis Tanaman Pangan')->first();
        $jMesin  = JurusanKuliah::where('nama', 'Teknik Mesin')->first();
        $jTernak = JurusanKuliah::where('nama', 'Peternakan')->first();
        $jIkan   = JurusanKuliah::where('nama', 'Akuakultur')->first();
        $jPangan = JurusanKuliah::where('nama', 'Teknologi Pangan')->first();

        $sWebDev    = Skill::where('jenis_skill', 'Web Development')->first();
        $sBackend   = Skill::where('jenis_skill', 'Backend Development')->first();
        $sFrontend  = Skill::where('jenis_skill', 'Frontend Development')->first();
        $sNetwork   = Skill::where('jenis_skill', 'Network Administration')->first();
        $sCyber     = Skill::where('jenis_skill', 'Cybersecurity')->first();
        $sCloud     = Skill::where('jenis_skill', 'Cloud Computing')->first();
        $sDesain    = Skill::where('jenis_skill', 'Desain Grafis')->first();
        $sAnimasi   = Skill::where('jenis_skill', 'Animasi 2D/3D')->first();
        $sVideo     = Skill::where('jenis_skill', 'Pengolahan Audio Video')->first();
        $sTuneUp    = Skill::where('jenis_skill', 'Tune Up')->first();
        $sOverhaul  = Skill::where('jenis_skill', 'Overhaul')->first();
        $sListrik   = Skill::where('jenis_skill', 'Kelistrikan Kendaraan')->first();
        $sAgriMgmt  = Skill::where('jenis_skill', 'Manajemen Agribisnis')->first();
        $sPasarAgri = Skill::where('jenis_skill', 'Pemasaran Produk Pertanian')->first();
        $sKeuAgri   = Skill::where('jenis_skill', 'Analisis Keuangan Usaha')->first();

        // ==== SOAL JURUSAN KULIAH ====
        $soalJurusan = [
            // Teknik Informatika
            ['soal'=>'Saya tertarik mengembangkan aplikasi web atau mobile','jk'=>$jTI?->id,'kr'=>$kj_minat?->id,'u'=>10],
            ['soal'=>'Saya menikmati kegiatan pemrograman komputer','jk'=>$jTI?->id,'kr'=>$kj_minat?->id,'u'=>11],
            ['soal'=>'Saya tertarik dengan kecerdasan buatan dan machine learning','jk'=>$jTI?->id,'kr'=>$kj_minat?->id,'u'=>12],
            ['soal'=>'Saya memahami konsep algoritma dan logika pemrograman','jk'=>$jTI?->id,'kr'=>$kj_mampu?->id,'u'=>13],
            ['soal'=>'Saya mampu menggunakan bahasa pemrograman (PHP/Python/Java)','jk'=>$jTI?->id,'kr'=>$kj_mampu?->id,'u'=>14],

            // Sistem Informasi
            ['soal'=>'Saya tertarik mengelola sistem informasi di sebuah organisasi','jk'=>$jSI?->id,'kr'=>$kj_minat?->id,'u'=>20],
            ['soal'=>'Saya tertarik dengan analisis bisnis dan teknologi informasi','jk'=>$jSI?->id,'kr'=>$kj_minat?->id,'u'=>21],
            ['soal'=>'Saya mampu menganalisis kebutuhan sistem di suatu organisasi','jk'=>$jSI?->id,'kr'=>$kj_mampu?->id,'u'=>22],
            ['soal'=>'Saya memahami dasar-dasar database dan manajemen data','jk'=>$jSI?->id,'kr'=>$kj_mampu?->id,'u'=>23],

            // Desain Komunikasi Visual
            ['soal'=>'Saya tertarik dengan desain grafis dan komunikasi visual','jk'=>$jDKV?->id,'kr'=>$kj_minat?->id,'u'=>30],
            ['soal'=>'Saya ingin berkarir di industri kreatif dan periklanan','jk'=>$jDKV?->id,'kr'=>$kj_minat?->id,'u'=>31],
            ['soal'=>'Saya memiliki kemampuan menggambar atau ilustrasi digital','jk'=>$jDKV?->id,'kr'=>$kj_mampu?->id,'u'=>32],
            ['soal'=>'Saya mampu menggunakan software desain (Photoshop/Illustrator/Figma)','jk'=>$jDKV?->id,'kr'=>$kj_mampu?->id,'u'=>33],

            // Teknik Mesin
            ['soal'=>'Saya tertarik mempelajari cara kerja mesin dan kendaraan','jk'=>$jMesin?->id,'kr'=>$kj_minat?->id,'u'=>40],
            ['soal'=>'Saya tertarik dengan industri manufaktur dan permesinan','jk'=>$jMesin?->id,'kr'=>$kj_minat?->id,'u'=>41],
            ['soal'=>'Saya mampu membaca gambar teknik atau blueprint mesin','jk'=>$jMesin?->id,'kr'=>$kj_mampu?->id,'u'=>42],
            ['soal'=>'Saya terbiasa bekerja dengan peralatan teknis dan mesin','jk'=>$jMesin?->id,'kr'=>$kj_mampu?->id,'u'=>43],

            // Peternakan
            ['soal'=>'Saya tertarik membudidayakan dan merawat hewan ternak','jk'=>$jTernak?->id,'kr'=>$kj_minat?->id,'u'=>50],
            ['soal'=>'Saya ingin berkarir di bidang peternakan dan agribisnis ternak','jk'=>$jTernak?->id,'kr'=>$kj_minat?->id,'u'=>51],
            ['soal'=>'Saya memahami cara merawat dan menjaga kesehatan hewan ternak','jk'=>$jTernak?->id,'kr'=>$kj_mampu?->id,'u'=>52],
            ['soal'=>'Saya mampu mengelola kandang dan pakan hewan ternak','jk'=>$jTernak?->id,'kr'=>$kj_mampu?->id,'u'=>53],

            // Agribisnis Tanaman Pangan
            ['soal'=>'Saya tertarik menanam dan mengembangkan tanaman pangan','jk'=>$jAgri?->id,'kr'=>$kj_minat?->id,'u'=>60],
            ['soal'=>'Saya ingin berwirausaha di bidang pertanian modern','jk'=>$jAgri?->id,'kr'=>$kj_minat?->id,'u'=>61],
            ['soal'=>'Saya memahami teknik bercocok tanam yang baik','jk'=>$jAgri?->id,'kr'=>$kj_mampu?->id,'u'=>62],

            // Teknologi Pangan
            ['soal'=>'Saya tertarik mengolah bahan pangan menjadi produk bernilai tinggi','jk'=>$jPangan?->id,'kr'=>$kj_minat?->id,'u'=>70],
            ['soal'=>'Saya tertarik dengan jaminan kualitas dan keamanan pangan','jk'=>$jPangan?->id,'kr'=>$kj_minat?->id,'u'=>71],
            ['soal'=>'Saya memahami proses pengolahan dan pengawetan makanan','jk'=>$jPangan?->id,'kr'=>$kj_mampu?->id,'u'=>72],

            // Akuakultur
            ['soal'=>'Saya tertarik membudidayakan ikan dan biota air lainnya','jk'=>$jIkan?->id,'kr'=>$kj_minat?->id,'u'=>80],
            ['soal'=>'Saya ingin berkarir di bidang perikanan dan kelautan','jk'=>$jIkan?->id,'kr'=>$kj_minat?->id,'u'=>81],
            ['soal'=>'Saya memahami cara budidaya ikan yang baik dan benar','jk'=>$jIkan?->id,'kr'=>$kj_mampu?->id,'u'=>82],
        ];

        // ==== SOAL MAGANG (PKL) ====
        $soalMagang = [
            // Global - semua siswa
            ['soal'=>'Saya siap bekerja sesuai aturan dan SOP perusahaan','sk'=>null,'kr'=>$km_mampu?->id,'u'=>1],
            ['soal'=>'Saya mampu berkomunikasi dengan baik di lingkungan kerja','sk'=>null,'kr'=>$km_mampu?->id,'u'=>2],
            ['soal'=>'Saya bisa bekerja sama dalam tim dengan baik','sk'=>null,'kr'=>$km_mampu?->id,'u'=>3],
            ['soal'=>'Saya siap bekerja dalam tekanan dan memenuhi deadline','sk'=>null,'kr'=>$km_mampu?->id,'u'=>4],
            ['soal'=>'Saya lebih suka tempat PKL yang dekat dengan rumah','sk'=>null,'kr'=>$km_minat?->id,'u'=>5],

            // RPL: Web Development
            ['soal'=>'Saya tertarik magang di perusahaan software atau startup teknologi','sk'=>$sWebDev?->id,'kr'=>$km_minat?->id,'u'=>20],
            ['soal'=>'Saya ingin PKL di tempat yang menggunakan teknologi web modern','sk'=>$sWebDev?->id,'kr'=>$km_minat?->id,'u'=>21],

            // RPL: Backend
            ['soal'=>'Saya tertarik PKL di bidang pengembangan sistem backend','sk'=>$sBackend?->id,'kr'=>$km_minat?->id,'u'=>30],
            ['soal'=>'Saya mampu menulis kode yang bersih dan terdokumentasi','sk'=>$sBackend?->id,'kr'=>$km_mampu?->id,'u'=>31],

            // RPL: Frontend
            ['soal'=>'Saya tertarik PKL di bidang pengembangan tampilan antarmuka (UI)','sk'=>$sFrontend?->id,'kr'=>$km_minat?->id,'u'=>35],

            // TKJ: Network
            ['soal'=>'Saya tertarik PKL di bidang jaringan komputer dan infrastruktur IT','sk'=>$sNetwork?->id,'kr'=>$km_minat?->id,'u'=>40],
            ['soal'=>'Saya mampu mengkonfigurasi perangkat jaringan (router/switch)','sk'=>$sNetwork?->id,'kr'=>$km_mampu?->id,'u'=>41],

            // TKJ: Cybersecurity
            ['soal'=>'Saya tertarik PKL di bidang keamanan siber dan keamanan jaringan','sk'=>$sCyber?->id,'kr'=>$km_minat?->id,'u'=>45],

            // TKJ: Cloud
            ['soal'=>'Saya tertarik PKL di bidang cloud computing atau server management','sk'=>$sCloud?->id,'kr'=>$km_minat?->id,'u'=>48],

            // Multimedia: Desain Grafis
            ['soal'=>'Saya tertarik PKL di studio desain atau creative agency','sk'=>$sDesain?->id,'kr'=>$km_minat?->id,'u'=>50],
            ['soal'=>'Saya mampu menggunakan software desain grafis secara profesional','sk'=>$sDesain?->id,'kr'=>$km_mampu?->id,'u'=>51],

            // Multimedia: Animasi
            ['soal'=>'Saya tertarik PKL di perusahaan animasi atau game development','sk'=>$sAnimasi?->id,'kr'=>$km_minat?->id,'u'=>55],
            ['soal'=>'Saya mampu membuat animasi 2D atau 3D dengan software khusus','sk'=>$sAnimasi?->id,'kr'=>$km_mampu?->id,'u'=>56],

            // Multimedia: Audio Video
            ['soal'=>'Saya tertarik PKL di rumah produksi video atau stasiun TV','sk'=>$sVideo?->id,'kr'=>$km_minat?->id,'u'=>60],
            ['soal'=>'Saya mampu menggunakan software editing video secara profesional','sk'=>$sVideo?->id,'kr'=>$km_mampu?->id,'u'=>61],

            // TBSM: Tune Up
            ['soal'=>'Saya tertarik PKL di bengkel resmi atau showroom kendaraan','sk'=>$sTuneUp?->id,'kr'=>$km_minat?->id,'u'=>70],
            ['soal'=>'Saya mampu melakukan service dan tune up kendaraan','sk'=>$sTuneUp?->id,'kr'=>$km_mampu?->id,'u'=>71],

            // TBSM: Overhaul
            ['soal'=>'Saya tertarik PKL di industri otomotif dan perawatan mesin','sk'=>$sOverhaul?->id,'kr'=>$km_minat?->id,'u'=>75],
            ['soal'=>'Saya mampu melakukan overhaul (pembongkaran/perakitan) mesin','sk'=>$sOverhaul?->id,'kr'=>$km_mampu?->id,'u'=>76],

            // TBSM: Kelistrikan
            ['soal'=>'Saya tertarik PKL di bidang kelistrikan kendaraan atau elektronika','sk'=>$sListrik?->id,'kr'=>$km_minat?->id,'u'=>80],
            ['soal'=>'Saya mampu mendiagnosis masalah kelistrikan pada kendaraan','sk'=>$sListrik?->id,'kr'=>$km_mampu?->id,'u'=>81],

            // Agribisnis: Manajemen
            ['soal'=>'Saya tertarik PKL di perusahaan agribisnis atau pertanian modern','sk'=>$sAgriMgmt?->id,'kr'=>$km_minat?->id,'u'=>90],
            ['soal'=>'Saya mampu mengelola usaha pertanian secara bisnis','sk'=>$sAgriMgmt?->id,'kr'=>$km_mampu?->id,'u'=>91],

            // Agribisnis: Pemasaran
            ['soal'=>'Saya tertarik PKL di bidang pemasaran produk pertanian','sk'=>$sPasarAgri?->id,'kr'=>$km_minat?->id,'u'=>95],

            // Agribisnis: Keuangan
            ['soal'=>'Saya tertarik PKL di bidang keuangan dan analisis usaha agribisnis','sk'=>$sKeuAgri?->id,'kr'=>$km_minat?->id,'u'=>98],
        ];

        foreach ($soalJurusan as $d) {
            $this->buatSoal(['soal'=>$d['soal'],'type'=>'jurusan',
                'jurusan_kuliah_id'=>$d['jk'],'bidang_id'=>null,'skill_id'=>null,
                'kriteria_id'=>$d['kr'],'urutan'=>$d['u']], $opsi);
        }

        foreach ($soalMagang as $d) {
            $this->buatSoal(['soal'=>$d['soal'],'type'=>'magang',
                'jurusan_kuliah_id'=>null,'bidang_id'=>null,'skill_id'=>$d['sk'],
                'kriteria_id'=>$d['kr'],'urutan'=>$d['u']], $opsi);
        }

        $this->command->info('Soal jurusan: '.Kuisoner::where('type','jurusan')->count());
        $this->command->info('Soal magang : '.Kuisoner::where('type','magang')->count());
    }

    private function buatSoal(array $data, array $opsi): void
    {
        $k = Kuisoner::create($data);
        foreach ($opsi as $o) {
            KuisonerOpsi::create(['kuisoner_id'=>$k->id,'jawaban'=>$o['jawaban'],'nilai'=>$o['nilai']]);
        }
    }
}
