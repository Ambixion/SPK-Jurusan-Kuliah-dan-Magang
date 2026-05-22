@extends('layouts.siswa')
@section('title', 'Hasil Rekomendasi PKL')
@section('content')
<h1 class="page-title">Pemilihan Tempat Praktek Kerja Lapangan</h1>

@if(session('success'))
<div class="alert-spk alert-success">{{ session('success') }}</div>
@endif

<div class="card-main">
    <div class="form-group">
        <label class="form-label">Nama Siswa</label>
        <input type="text" class="form-input" value="{{ Auth::user()->nama }}" readonly>
    </div>
    <div class="form-group">
        <label class="form-label">Jurusan</label>
        <input type="text" class="form-input" value="{{ $siswa->jurusan_siswa }}" readonly>
    </div>
    <div class="form-group">
        <label class="form-label">Nilai Rata-rata Rapot</label>
        <input type="text" class="form-input" value="{{ $nilaiRata }}" readonly>
    </div>

    @if(!$sudahMengisi)
    <div style="margin-top:20px;padding:16px 20px;background:rgba(249,115,22,0.15);
         border:1px solid rgba(249,115,22,0.3);border-radius:12px;display:flex;align-items:center;gap:12px;">
        <span style="font-size:20px;">⚠️</span>
        <div style="flex:1;">
            <div style="font-weight:700;color:#fdba74;font-size:13px;">Belum mengisi kuisoner PKL</div>
            <div style="color:rgba(255,255,255,0.6);font-size:12px;margin-top:3px;">
                Isi kuisoner PKL terlebih dahulu untuk mendapatkan rekomendasi tempat PKL.
            </div>
        </div>
        <a href="{{ route('siswa.pkl') }}"
           style="background:#f97316;color:#fff;padding:8px 18px;border-radius:20px;font-size:12px;font-weight:700;text-decoration:none;">
            Isi Sekarang →
        </a>
    </div>

    @else
    <div style="margin-top:24px;border-top:1px solid rgba(255,255,255,0.1);padding-top:20px;">
        <div class="card-title">List Hasil Tempat PKL</div>

        @foreach($hasilMagang as $hasil)
        @php
            // score sudah dalam bentuk persentase (0-100) dari SawController
            $persen     = number_format($hasil->score, 1);
            $rankColor  = match($hasil->rank) {
                1 => '#22c55e', 2 => '#4f6ef7', 3 => '#f59e0b', default => '#6b7280'
            };
        @endphp
        <div style="display:flex;align-items:center;gap:14px;padding:14px 18px;margin-bottom:8px;
                    background:rgba(10,12,30,0.6);border:1px solid rgba(255,255,255,0.08);border-radius:12px;">
            <div style="width:34px;height:34px;border-radius:50%;background:{{ $rankColor }};
                        display:flex;align-items:center;justify-content:center;
                        font-weight:800;font-size:13px;color:#fff;flex-shrink:0;">
                {{ $hasil->rank }}
            </div>
            <div style="flex:1;">
                <div style="font-size:14px;font-weight:700;color:#fff;">
                    {{ $hasil->tempatMagang->nama }}
                </div>
                <div style="font-size:11px;color:rgba(255,255,255,0.45);margin-top:2px;">
                    {{ $hasil->tempatMagang->bidang ?? ($hasil->tempatMagang->deskripsi ? Str::limit($hasil->tempatMagang->deskripsi, 60) : '') }}
                </div>
            </div>
            <div style="font-size:22px;font-weight:800;color:{{ $rankColor }};min-width:60px;text-align:right;">
                {{ $persen }}%
            </div>
            <button onclick="showInfoMagang({{ $hasil->tempatMagang->id }})"
                    style="background:rgba(79,110,247,0.2);color:#a5b4fc;border:1px solid rgba(79,110,247,0.35);
                           padding:7px 18px;border-radius:20px;font-size:12px;font-weight:700;cursor:pointer;">
                Info
            </button>
        </div>
        @endforeach

        <div style="display:flex;justify-content:space-between;gap:10px;margin-top:14px;">
            <a href="{{ route('siswa.pkl') }}"
               style="background:rgba(255,255,255,0.1);color:#fff;padding:9px 20px;border-radius:20px;
                      font-size:12px;font-weight:700;text-decoration:none;border:1px solid rgba(255,255,255,0.2);">
                Kembali
            </a>
            <a href="{{ route('siswa.pkl') }}"
               style="background:rgba(255,255,255,0.1);color:#fff;padding:9px 20px;border-radius:20px;
                      font-size:12px;font-weight:700;text-decoration:none;border:1px solid rgba(255,255,255,0.2);">
                Isi Ulang Kuisoner
            </a>
        </div>
    </div>
    @endif
</div>

{{-- Modal Info Tempat Magang --}}
<div id="modalInfoMagang" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.75);
     z-index:999;align-items:center;justify-content:center;">
    <div style="background:#1e2140;border:1px solid rgba(255,255,255,0.15);border-radius:16px;
                padding:28px;max-width:420px;width:90%;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
            <div id="mMagangTitle" style="font-size:15px;font-weight:800;color:#fff;"></div>
            <button onclick="closeModalMagang()"
                    style="background:none;border:none;color:rgba(255,255,255,0.5);font-size:20px;cursor:pointer;">✕</button>
        </div>
        <div id="mMagangBody" style="color:rgba(255,255,255,0.7);font-size:13px;line-height:1.7;"></div>
    </div>
</div>

@push('scripts')
<script>
    // Data object untuk semua tempat magang
    const mData = {
        @foreach($hasilMagang as $h)
        {{ $h->tempatMagang->id }}: {
            nama:      "{{ addslashes($h->tempatMagang->nama) }}",
            deskripsi: "{{ addslashes($h->tempatMagang->deskripsi ?? '-') }}",
            bidang:    "{{ addslashes($h->tempatMagang->bidang ?? '-') }}",
            kuota:     "{{ $h->tempatMagang->kuota }}",
            kontak:    "{{ addslashes($h->tempatMagang->kontak ?? '-') }}",
            lat:       {{ $h->tempatMagang->latitude ?? 'null' }},
            lng:       {{ $h->tempatMagang->longitude ?? 'null' }},
            skor:      "{{ number_format($h->score, 1) }}%"
        },
        @endforeach
    };

    // Haversine formula untuk menghitung jarak
    function hitungJarakKm(lat1, lng1, lat2, lng2) {
        const R = 6371; // Radius bumi dalam km
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLng / 2) * Math.sin(dLng / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const jarak = R * c;
        return jarak.toFixed(1);
    }

    // Menampilkan modal info tempat magang
    function showInfoMagang(id) {
        const data = mData[id];
        if (!data) return;

        document.getElementById('mMagangTitle').textContent = data.nama;

        let lokasi = 'Lokasi belum diset';
        if (data.lat !== null && data.lng !== null) {
            const jarak = hitungJarakKm(-8.1584, 113.7225, data.lat, data.lng);
            const label = jarak <= 15 ? 'Dalam Kota' : 'Luar Kota';
            lokasi = `${jarak} km (${label})`;
        }

        const body = `
            <div style="margin-bottom:10px;"><strong>Bidang:</strong> ${data.bidang}</div>
            <div style="margin-bottom:10px;"><strong>Kuota:</strong> ${data.kuota}</div>
            <div style="margin-bottom:10px;"><strong>Kontak:</strong> ${data.kontak}</div>
            <div style="margin-bottom:10px;"><strong>Jarak dari Sekolah:</strong> ${lokasi}</div>
            <div style="margin-bottom:10px;"><strong>Skor SAW:</strong> ${data.skor}</div>
            <div style="margin-top:14px;padding-top:10px;border-top:1px solid rgba(255,255,255,0.1);"><strong>Deskripsi:</strong><br>${data.deskripsi}</div>
        `;

        document.getElementById('mMagangBody').innerHTML = body;
        document.getElementById('modalInfoMagang').style.display = 'flex';
    }

    // Menutup modal
    function closeModalMagang() {
        document.getElementById('modalInfoMagang').style.display = 'none';
    }

    // Tutup modal saat klik di luar
    document.getElementById('modalInfoMagang')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModalMagang();
        }
    });
</script>
@endpush

@endsection
