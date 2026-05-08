@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
{{-- BIG STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <a href="{{ route('admin.dashboard', ['detail' => 'jurusan_kuliah']) }}"
           style="text-decoration:none;display:block;">
        <div style="background:linear-gradient(135deg,#5b6af0,#7c3aed);border-radius:16px;padding:24px;cursor:pointer;box-shadow:{{ ($detailKey ?? null) === 'jurusan_kuliah' ? '0 0 0 3px rgba(91,106,240,0.25)' : 'none' }};">
            <div style="color:rgba(255,255,255,0.7);font-size:0.85rem;margin-bottom:8px;">Total Jurusan Kuliah</div>
            <div style="font-size:2.4rem;font-weight:700;color:#fff;line-height:1;">
                {{ $total_jurusan ?? 0 }} <span style="font-size:1rem;font-weight:400;opacity:0.8;">Prodi</span>
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.dashboard', ['detail' => 'jurusan_smk']) }}"
           style="text-decoration:none;display:block;">
        <div style="background:linear-gradient(135deg,#1e40af,#5b6af0);border-radius:16px;padding:24px;cursor:pointer;box-shadow:{{ ($detailKey ?? null) === 'jurusan_smk' ? '0 0 0 3px rgba(91,106,240,0.25)' : 'none' }};">
            <div style="color:rgba(255,255,255,0.7);font-size:0.85rem;margin-bottom:8px;">Total Jurusan SMK</div>
            <div style="font-size:2.4rem;font-weight:700;color:#fff;line-height:1;">
                {{ $total_jurusan_smk ?? 0 }} <span style="font-size:1rem;font-weight:400;opacity:0.8;">Jurusan</span>
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('admin.dashboard', ['detail' => 'tempat_magang']) }}"
           style="text-decoration:none;display:block;">
        <div style="background:linear-gradient(135deg,#7c3aed,#a855f7);border-radius:16px;padding:24px;cursor:pointer;box-shadow:{{ ($detailKey ?? null) === 'tempat_magang' ? '0 0 0 3px rgba(91,106,240,0.25)' : 'none' }};">
            <div style="color:rgba(255,255,255,0.7);font-size:0.85rem;margin-bottom:8px;">Total Tempat Magang</div>
            <div style="font-size:2.4rem;font-weight:700;color:#fff;line-height:1;">
                {{ $total_tempat_magang ?? 0 }} <span style="font-size:1rem;font-weight:400;opacity:0.8;">Tempat</span>
            </div>
        </div>
        </a>
    </div>
</div>

{{-- SMALLER STAT CARDS --}}
<div class="row g-3">
    <div class="col-md-3">
        <a href="{{ route('admin.dashboard', ['detail' => 'users']) }}"
           style="text-decoration:none;display:block;">
        <div class="card-dark d-flex align-items-center gap-3"
             style="cursor:pointer;box-shadow:{{ ($detailKey ?? null) === 'users' ? '0 0 0 3px rgba(91,106,240,0.15)' : 'none' }};">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(139,92,246,0.2);display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">👥</div>
            <div>
                <div style="color:#8892a4;font-size:0.78rem;margin-bottom:2px;">Total User</div>
                <div style="font-size:1.8rem;font-weight:700;color:#fff;line-height:1;">{{ $total_user ?? 0 }}</div>
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.dashboard', ['detail' => 'siswa']) }}"
           style="text-decoration:none;display:block;">
        <div class="card-dark d-flex align-items-center gap-3"
             style="cursor:pointer;box-shadow:{{ ($detailKey ?? null) === 'siswa' ? '0 0 0 3px rgba(91,106,240,0.15)' : 'none' }};">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(34,197,94,0.2);display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">🎓</div>
            <div>
                <div style="color:#8892a4;font-size:0.78rem;margin-bottom:2px;">Total Siswa</div>
                <div style="font-size:1.8rem;font-weight:700;color:#fff;line-height:1;">{{ $total_siswa ?? 0 }}</div>
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.dashboard', ['detail' => 'guru']) }}"
           style="text-decoration:none;display:block;">
        <div class="card-dark d-flex align-items-center gap-3"
             style="cursor:pointer;box-shadow:{{ ($detailKey ?? null) === 'guru' ? '0 0 0 3px rgba(91,106,240,0.15)' : 'none' }};">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(59,130,246,0.2);display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">👨‍🏫</div>
            <div>
                <div style="color:#8892a4;font-size:0.78rem;margin-bottom:2px;">Total Guru</div>
                <div style="font-size:1.8rem;font-weight:700;color:#fff;line-height:1;">{{ $total_guru ?? 0 }}</div>
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('admin.dashboard', ['detail' => 'kriteria']) }}"
           style="text-decoration:none;display:block;">
        <div class="card-dark d-flex align-items-center gap-3"
             style="cursor:pointer;box-shadow:{{ ($detailKey ?? null) === 'kriteria' ? '0 0 0 3px rgba(91,106,240,0.15)' : 'none' }};">
            <div style="width:48px;height:48px;border-radius:12px;background:rgba(245,158,11,0.2);display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">⚙️</div>
            <div>
                <div style="color:#8892a4;font-size:0.78rem;margin-bottom:2px;">Total Kriteria</div>
                <div style="font-size:1.8rem;font-weight:700;color:#fff;line-height:1;">{{ $total_kriteria ?? 0 }}</div>
            </div>
        </div>
        </a>
    </div>
</div>

<div id="dashboard-detail-wrapper">
    @include('admin.partials.dashboard-detail')
</div>

@push('scripts')
<script>
    (function () {
        const wrapper = document.getElementById('dashboard-detail-wrapper');
        if (!wrapper) return;

        function ajaxLoad(url, pushState = true) {
            if (!url) return;
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(function (res) { return res.ok ? res.json() : Promise.reject(); })
                .then(function (data) {
                    if (data && typeof data.html === 'string') {
                        wrapper.innerHTML = data.html;
                        if (pushState && window.history && window.history.pushState) {
                            window.history.pushState({dashboardDetail: true}, '', url);
                        }
                    }
                })
                .catch(function () {
                    window.location.href = url;
                });
        }

        document.addEventListener('click', function (e) {
            const link = e.target.closest('a');
            if (!link) return;
            const href = link.getAttribute('href') || '';
            if (!href.includes('/dashboard') || !href.includes('detail=')) return;

            e.preventDefault();
            ajaxLoad(href);
        });

        document.addEventListener('submit', function (e) {
            const form = e.target;
            if (!form.matches('form[data-dashboard-detail-search]')) return;

            e.preventDefault();
            const params = new URLSearchParams(new FormData(form));
            const url = form.getAttribute('action') + '?' + params.toString();
            ajaxLoad(url);
        });

        window.addEventListener('popstate', function () {
            const currentUrl = window.location.href;
            ajaxLoad(currentUrl, false);
        });
    })();
</script>
@endpush
@endsection
