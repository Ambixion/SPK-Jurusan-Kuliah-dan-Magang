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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

//---------- ROOT ROUTE ----------
Route::get('/', function (): RedirectResponse {
    if (Auth::check()) {
        return match (Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'guru' => redirect()->route('guru.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            default => redirect('/login'),
        };
    }
    return redirect('/login');
})->name('root');

//---------- AUTH ROUTES ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
//---------- ADMIN ROUTES ----------
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class);
        Route::resource('jurusan', JurusanController::class);
        Route::resource('tempat_magang', TempatMagangController::class);
        Route::resource('kriteria', KriteriaController::class);
    });
//---------- Guru Routes ----------
Route::middleware(['auth', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(function () {
        Route::get('/dashboard', [GuruDashboard::class, 'index'])->name('dashboard');
        Route::resource('siswa', SiswaController::class);
        Route::resource('nilai', NilaiController::class);
    });
    //---------- Siswa Routes ----------
    Route::middleware(['auth', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {
        Route::get('/dashboard', [SiswaDashboard::class, 'index'])->name('dashboard');
        Route::get('/kuisoner', [KuisonerController::class, 'index'])->name('kuisoner');
        Route::post('/kuisoner', [KuisonerController::class, 'store']);
        Route::get('/hasil', [KuisonerController::class, 'index'])->name('hasil');
    });
