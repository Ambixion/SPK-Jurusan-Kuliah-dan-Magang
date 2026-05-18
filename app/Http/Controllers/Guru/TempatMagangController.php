<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\TempatMagang;

class TempatMagangController extends Controller
{
    public function index()
    {
        $tempatMagang = TempatMagang::latest()->get();

        return view('guru.tempatmagang.index', compact('tempatMagang'));
    }
}
