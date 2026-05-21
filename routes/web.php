<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\JurusanSmkController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\KuisonerController as AdminKuisonerController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TempatMagangController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\SiswaController;
use App\Http\Controllers\Guru\TempatMagangController as GuruTempatMagangController;
use App\Http\Controllers\Guru\JurusanKuliahController as GuruJurusanKuliahController;
use App\Http\Controllers\SawController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\HasilJurusanController;
use App\Http\Controllers\Siswa\HasilPklController;
use App\Http\Controllers\Siswa\KuisonerJurusanController;
use App\Http\Controllers\Siswa\KuisonerPklController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ---------- ROOT ----------
Route::get('/', function () {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru'  => redirect()->route('guru.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => redirect()->route('login'),
        };
    }
    return view('welcome');
})->name('root');

// ── AUTH ──────────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── ADMIN ─────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // User management
        Route::resource('users', UserController::class);

        // Jurusan Kuliah + Jurusan SMK (satu halaman dengan tab)
        Route::get('/jurusan_kuliah',          [JurusanController::class, 'index'])->name('jurusan_kuliah.index');
        Route::get('/jurusan_kuliah/create',   [JurusanController::class, 'create'])->name('jurusan_kuliah.create');
        Route::post('/jurusan_kuliah',         [JurusanController::class, 'store'])->name('jurusan_kuliah.store');
        Route::get('/jurusan_kuliah/{id}/edit',[JurusanController::class, 'edit'])->name('jurusan_kuliah.edit');
        Route::put('/jurusan_kuliah/{id}',     [JurusanController::class, 'update'])->name('jurusan_kuliah.update');
        Route::delete('/jurusan_kuliah/{id}',  [JurusanController::class, 'destroy'])->name('jurusan_kuliah.destroy');

        Route::get('/jurusan_smk',             [JurusanSmkController::class, 'index'])->name('jurusan_smk.index');
        Route::get('/jurusan_smk/create',      [JurusanSmkController::class, 'create'])->name('jurusan_smk.create');
        Route::post('/jurusan_smk',            [JurusanSmkController::class, 'store'])->name('jurusan_smk.store');
        Route::get('/jurusan_smk/{id}/edit',   [JurusanSmkController::class, 'edit'])->name('jurusan_smk.edit');
        Route::put('/jurusan_smk/{id}',        [JurusanSmkController::class, 'update'])->name('jurusan_smk.update');
        Route::delete('/jurusan_smk/{id}',     [JurusanSmkController::class, 'destroy'])->name('jurusan_smk.destroy');

        // Skill
        Route::resource('skill', SkillController::class);

        // Bidang
        Route::resource('bidang', BidangController::class);

        // Tempat Magang
        Route::resource('tempat_magang', TempatMagangController::class);

        // Kriteria SAW
        Route::resource('kriteria', KriteriaController::class);

        // Kuisoner (soal + opsi jawaban)
        Route::resource('kuisoner', AdminKuisonerController::class);

        // SAW: hitung ulang semua siswa
        Route::post('/saw/hitung-ulang', [SawController::class, 'hitungUlangSemua'])->name('saw.hitung-ulang');
    });

// ── GURU ──────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
         Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');
        Route::resource('siswa', SiswaController::class);
        Route::resource('nilai', NilaiController::class);
        Route::get('/tempat-magang', [GuruTempatMagangController::class, 'index'])
            ->name('tempat_magang');
        Route::get('/jurusan-kuliah', [GuruJurusanKuliahController::class, 'index'])
            ->name('jurusan_kuliah');
    });

// ── SISWA ─────────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');

        // ── PKL (Pemilihan Tempat Magang) ─────────────────────────────────────
        // Landing: auto-detect jurusan SMK siswa → tampilkan skill dari DB
        Route::get('/pkl',              [KuisonerPklController::class, 'landing'])->name('pkl');

        // Kuisoner PKL: soal difilter berdasarkan skill_ids dari query string
        Route::get('/pkl/kuisoner',     [KuisonerPklController::class, 'index'])->name('pkl.kuisoner');
        Route::post('/pkl/kuisoner',    [KuisonerPklController::class, 'store'])->name('pkl.store');

        // Preferensi lokasi siswa untuk PKL
        Route::post('/pkl/preferensi',  [KuisonerPklController::class, 'updatePreferensi'])->name('pkl.preferensi');
        Route::post('/pkl/skill',       [KuisonerPklController::class, 'updateSkillTambahan'])->name('pkl.skill.update');

        // Hasil PKL
        Route::get('/pkl/hasil',        [HasilPklController::class, 'index'])->name('pkl.hasil');

        // ── JURUSAN KULIAH ────────────────────────────────────────────────────
        // Landing: pilih jurusan kuliah + bidang → filter soal
        Route::get('/jurusan',          [KuisonerJurusanController::class, 'landing'])->name('jurusan');

        // Kuisoner Jurusan: soal difilter per jurusan_kuliah_id + bidang_ids
        Route::get('/jurusan/kuisoner', [KuisonerJurusanController::class, 'index'])->name('jurusan.kuisoner');
        Route::post('/jurusan/kuisoner',[KuisonerJurusanController::class, 'store'])->name('jurusan.store');

        // Hasil Jurusan
        Route::get('/jurusan/hasil',    [HasilJurusanController::class, 'index'])->name('jurusan.hasil');
    });
