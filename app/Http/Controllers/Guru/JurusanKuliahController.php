<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JurusanKuliah;

class JurusanKuliahController extends Controller
{
    public function index()
    {
        $jurusanKuliah = JurusanKuliah::latest()->get();

        return view('guru.jurusankuliah.index', compact('jurusanKuliah'));
    }
}