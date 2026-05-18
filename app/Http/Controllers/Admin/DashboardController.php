<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JurusanKuliah;
use App\Models\JurusanSmk;
use App\Models\Kriteria;
use App\Models\Siswa;
use App\Models\TempatMagang;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $total_siswa = Siswa::count();
        $total_guru = User::where('role', 'guru')->count();
        $total_jurusan = JurusanKuliah::count();
        $total_jurusan_smk = JurusanSmk::count();
        $total_tempat_magang = TempatMagang::count();
        $total_kriteria = Kriteria::count();
        $total_user = User::count();

        $detailKey = $request->query('detail');
        $detailTitle = null;
        $detailItems = null;
        $q = trim((string) $request->query('q', ''));

        if ($detailKey) {
            $limit = 10;
            switch ($detailKey) {
                case 'kriteria':
                    $detailTitle = 'Detail Kriteria (10 terbaru)';
                    $detailItems = Kriteria::query()
                        ->when($q !== '', function ($query) use ($q) {
                            $query->where(function ($sub) use ($q) {
                                $sub->where('nama', 'like', "%{$q}%")
                                    ->orWhere('type', 'like', "%{$q}%")
                                    ->orWhere('jenis', 'like', "%{$q}%");
                            });
                        })
                        ->orderByDesc('id')
                        ->limit($limit)
                        ->get();
                    break;
                case 'jurusan_kuliah':
                    $detailTitle = 'Detail Jurusan Kuliah (10 terbaru)';
                    $detailItems = JurusanKuliah::query()
                        ->when($q !== '', function ($query) use ($q) {
                            $query->where(function ($sub) use ($q) {
                                $sub->where('nama', 'like', "%{$q}%")
                                    ->orWhere('bidang_studi', 'like', "%{$q}%")
                                    ->orWhere('deskripsi', 'like', "%{$q}%");
                            });
                        })
                        ->orderByDesc('id')
                        ->limit($limit)
                        ->get();
                    break;
                case 'jurusan_smk':
                    $detailTitle = 'Detail Jurusan SMK (10 terbaru)';
                    $detailItems = JurusanSmk::query()
                        ->with('skills')
                        ->when($q !== '', function ($query) use ($q) {
                            $query->where('nama_jurusan', 'like', "%{$q}%")
                                ->orWhereHas('skills', function ($skillQuery) use ($q) {
                                    $skillQuery->where('jenis_skill', 'like', "%{$q}%");
                                });
                        })
                        ->orderByDesc('id')
                        ->limit($limit)
                        ->get();
                    break;
                case 'tempat_magang':
                    $detailTitle = 'Detail Tempat Magang (10 terbaru)';
                    $detailItems = TempatMagang::query()
                        ->with('skills')
                        ->when($q !== '', function ($query) use ($q) {
                            $query->where(function ($sub) use ($q) {
                                $sub->where('nama', 'like', "%{$q}%")
                                    ->orWhere('bidang', 'like', "%{$q}%")
                                    ->orWhere('kontak', 'like', "%{$q}%");
                            })->orWhereHas('skills', function ($skillQuery) use ($q) {
                                $skillQuery->where('jenis_skill', 'like', "%{$q}%");
                            });
                        })
                        ->orderByDesc('id')
                        ->limit($limit)
                        ->get();
                    break;
                case 'users':
                    $detailTitle = 'Detail User (10 terbaru)';
                    $detailItems = User::query()
                        ->when($q !== '', function ($query) use ($q) {
                            $query->where(function ($sub) use ($q) {
                                $sub->where('nama', 'like', "%{$q}%")
                                    ->orWhere('email', 'like', "%{$q}%")
                                    ->orWhere('role', 'like', "%{$q}%");
                            });
                        })
                        ->orderByDesc('id')
                        ->limit($limit)
                        ->get();
                    break;
                case 'siswa':
                    $detailTitle = 'Detail Siswa (10 terbaru)';
                    $detailItems = Siswa::query()
                        ->with(['user', 'jurusanSmk'])
                        ->when($q !== '', function ($query) use ($q) {
                            $query->whereHas('user', function ($userQuery) use ($q) {
                                $userQuery->where('nama', 'like', "%{$q}%")
                                    ->orWhere('email', 'like', "%{$q}%");
                            })->orWhereHas('jurusanSmk', function ($jurusanQuery) use ($q) {
                                $jurusanQuery->where('nama_jurusan', 'like', "%{$q}%");
                            });
                        })
                        ->orderByDesc('id')
                        ->limit($limit)
                        ->get();
                    break;
                case 'guru':
                    $detailTitle = 'Detail Guru (10 terbaru)';
                    $detailItems = User::query()
                        ->where('role', 'guru')
                        ->when($q !== '', function ($query) use ($q) {
                            $query->where(function ($sub) use ($q) {
                                $sub->where('nama', 'like', "%{$q}%")
                                    ->orWhere('email', 'like', "%{$q}%");
                            });
                        })
                        ->orderByDesc('id')
                        ->limit($limit)
                        ->get();
                    break;
                default:
                    $detailKey = null;
                    break;
            }
        }

        if ($request->ajax()) {
            $html = view('admin.partials.dashboard-detail', compact(
                'detailKey',
                'detailTitle',
                'detailItems',
                'q'
            ))->render();

            return response()->json(['html' => $html]);
        }

        return view('admin.dashboard', compact(
            'total_siswa',
            'total_jurusan_smk',
            'total_guru',
            'total_jurusan',
            'total_tempat_magang',
            'total_kriteria',
            'total_user',
            'detailKey',
            'detailTitle',
            'detailItems',
            'q'
        ));
    }
}
