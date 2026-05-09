<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\TempatMagangController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\SiswaController;
use App\Http\Controllers\Siswa\KuisonerController;
use App\Http\Controllers\Siswa\KuisonerPklController;
use App\Http\Controllers\Siswa\KuisonerJurusanController;
use App\Http\Controllers\Siswa\HasilController;
use App\Http\Controllers\Siswa\HasilPklController;
use App\Http\Controllers\Siswa\HasilJurusanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return redirect()->route('login');
})->name('root');

Route::get("/", function () {
    return view('welcome');
});

// ---------- AUTH ----------
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ---------- ADMIN ----------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('users',         UserController::class);
        Route::resource('jurusan',       JurusanController::class);
        Route::resource('tempat_magang', TempatMagangController::class);
        Route::resource('kriteria',      KriteriaController::class);
    });

// ---------- GURU ----------
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');
        Route::resource('siswa', SiswaController::class);
        Route::resource('nilai', NilaiController::class);
    });

// ---------- SISWA ----------
Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');

        // ── PKL (Pemilihan Tempat Magang) ────────────────────────────────────
        Route::get( '/pkl',          [KuisonerPklController::class, 'landing'])->name('pkl');
        Route::get( '/pkl/kuisoner', [KuisonerPklController::class, 'index'])  ->name('pkl.kuisoner');
        Route::post('/pkl/kuisoner', [KuisonerPklController::class, 'store'])  ->name('pkl.store');
        Route::get( '/pkl/step2',    [KuisonerPklController::class, 'step2'])  ->name('pkl.step2');
        Route::get( '/pkl/step3',    [KuisonerPklController::class, 'step3'])  ->name('pkl.step3');
        Route::get( '/pkl/hasil',    [HasilPklController::class,    'index'])  ->name('pkl.hasil');

        // ── JURUSAN KULIAH ────────────────────────────────────────────────────
        Route::get( '/jurusan',          [KuisonerJurusanController::class, 'landing'])->name('jurusan');
        Route::get( '/jurusan/kuisoner', [KuisonerJurusanController::class, 'index'])  ->name('jurusan.kuisoner');
        Route::post('/jurusan/kuisoner', [KuisonerJurusanController::class, 'store'])  ->name('jurusan.store');
        Route::get( '/jurusan/hasil',    [HasilJurusanController::class,    'index'])  ->name('jurusan.hasil');

        // ── HASIL LEGACY (jika masih dipakai di view lain) ───────────────────
        Route::get('/hasil', [HasilController::class, 'index'])->name('hasil');
    });
