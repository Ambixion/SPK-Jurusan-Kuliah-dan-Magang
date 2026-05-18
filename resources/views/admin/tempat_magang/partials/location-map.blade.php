@php
    $mapLat = old('latitude', $latitude ?? null);
    $mapLng = old('longitude', $longitude ?? null);
    $hasCoords = $mapLat !== null && $mapLat !== '' && $mapLng !== null && $mapLng !== '';
@endphp

<div class="mb-4 location-map-field">
    <label class="form-label-custom">
        Lokasi pada Peta <span style="color:#f87171">*</span>
    </label>
    <p style="color:#8892a4;font-size:0.8rem;margin:0 0 10px;">
        Cari alamat di kotak pencarian, atau klik pada peta untuk menandai lokasi. Geser penanda untuk menyesuaikan posisi.
    </p>

    <div class="location-search-wrap">
        <input type="text" id="location-search-input" class="form-control form-control-dark"
            placeholder="Cari alamat, nama tempat, atau jalan…" autocomplete="off">
        <button type="button" id="location-search-btn" class="btn-primary-custom location-search-btn">
            Cari
        </button>
    </div>
    <div id="location-search-results" class="location-search-results" hidden></div>
    <div id="location-search-status" class="location-search-status" hidden></div>

    <div
        id="location-map"
        class="location-map-canvas"
        data-initial-lat="{{ $hasCoords ? $mapLat : '-8.1700' }}"
        data-initial-lng="{{ $hasCoords ? $mapLng : '113.7000' }}"
        data-has-coords="{{ $hasCoords ? '1' : '0' }}"
    ></div>

    <div class="location-coords-panel">
        <div class="location-coord-item">
            <span class="location-coord-label">Latitude</span>
            <input type="text" name="latitude" id="latitude"
                class="form-control form-control-dark location-coord-input @error('latitude') is-invalid @enderror"
                value="{{ $hasCoords ? $mapLat : '' }}"
                readonly required
                placeholder="Belum dipilih">
        </div>
        <div class="location-coord-item">
            <span class="location-coord-label">Longitude</span>
            <input type="text" name="longitude" id="longitude"
                class="form-control form-control-dark location-coord-input @error('longitude') is-invalid @enderror"
                value="{{ $hasCoords ? $mapLng : '' }}"
                readonly required
                placeholder="Belum dipilih">
        </div>
    </div>

    @error('latitude')
        <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
    @enderror
    @error('longitude')
        <div style="color:#f87171;font-size:0.8rem;margin-top:4px;">{{ $message }}</div>
    @enderror
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
<style>
    .location-search-wrap {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }
    .location-search-wrap input { flex: 1; min-width: 0; }
    .location-search-btn {
        flex-shrink: 0;
        white-space: nowrap;
        padding: 10px 18px !important;
    }
    .location-search-results {
        margin-bottom: 10px;
        border: 1px solid #1e2a42;
        border-radius: 10px;
        overflow: hidden;
        background: #0d1117;
    }
    .location-search-results button {
        display: block;
        width: 100%;
        text-align: left;
        padding: 10px 14px;
        border: none;
        border-bottom: 1px solid #1e2a42;
        background: transparent;
        color: #e2e8f0;
        font-size: 0.85rem;
        cursor: pointer;
        transition: background 0.15s;
    }
    .location-search-results button:last-child { border-bottom: none; }
    .location-search-results button:hover,
    .location-search-results button:focus {
        background: #1e2a42;
        outline: none;
        color: #fff;
    }
    .location-search-results button span {
        display: block;
        color: #8892a4;
        font-size: 0.75rem;
        margin-top: 2px;
    }
    .location-search-status {
        margin-bottom: 10px;
        font-size: 0.8rem;
        color: #8892a4;
    }
    .location-search-status.is-error { color: #f87171; }
    .location-map-canvas {
        height: 320px;
        width: 100%;
        border: 1px solid #1e2a42;
        border-radius: 10px;
        overflow: hidden;
        background: #0d1117;
        margin-top: 0;
    }
    .location-coords-panel {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 12px;
    }
    .location-coord-label {
        display: block;
        color: #8892a4;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }
    .location-coord-input {
        cursor: default;
        background: #0d1117 !important;
        color: #818cf8 !important;
        font-family: ui-monospace, monospace;
        font-size: 0.85rem !important;
    }
    .location-coord-input::placeholder { color: #4a5568 !important; }
    .location-map-marker {
        background: transparent;
        border: none;
    }
    .location-map-marker-pin {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #5b6af0, #7c3aed);
        border: 3px solid #fff;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        box-shadow: 0 4px 12px rgba(91, 106, 240, 0.45);
    }
    .leaflet-container { font-family: inherit; }
    .leaflet-control-zoom a {
        background: #161d2f !important;
        color: #e2e8f0 !important;
        border-color: #1e2a42 !important;
    }
    .leaflet-control-zoom a:hover {
        background: #1e2a42 !important;
        color: #fff !important;
    }
    .leaflet-control-attribution {
        background: rgba(13, 17, 23, 0.85) !important;
        color: #8892a4 !important;
        font-size: 0.65rem !important;
    }
    .leaflet-control-attribution a { color: #818cf8 !important; }
    @media (max-width: 576px) {
        .location-coords-panel { grid-template-columns: 1fr; }
        .location-map-canvas { height: 260px; }
        .location-search-wrap { flex-direction: column; }
        .location-search-btn { width: 100%; justify-content: center; }
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
(function () {
    const mapEl = document.getElementById('location-map');
    if (!mapEl || typeof L === 'undefined') return;

    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const searchInput = document.getElementById('location-search-input');
    const searchBtn = document.getElementById('location-search-btn');
    const searchResults = document.getElementById('location-search-results');
    const searchStatus = document.getElementById('location-search-status');
    if (!latInput || !lngInput) return;

    let lastSearchAt = 0;

    const defaultLat = parseFloat(mapEl.dataset.initialLat) || -8.17;
    const defaultLng = parseFloat(mapEl.dataset.initialLng) || 113.7;
    const hasCoords = mapEl.dataset.hasCoords === '1';

    const markerIcon = L.divIcon({
        className: 'location-map-marker',
        html: '<div class="location-map-marker-pin"></div>',
        iconSize: [28, 28],
        iconAnchor: [14, 28],
    });

    const map = L.map(mapEl, { scrollWheelZoom: true }).setView(
        [defaultLat, defaultLng],
        hasCoords ? 15 : 13
    );

    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 20,
    }).addTo(map);

    let marker = null;

    function setCoords(lat, lng) {
        latInput.value = Number(lat).toFixed(7);
        lngInput.value = Number(lng).toFixed(7);
    }

    function placeMarker(lat, lng, panTo) {
        setCoords(lat, lng);
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng], { draggable: true, icon: markerIcon }).addTo(map);
            marker.on('dragend', function (e) {
                const pos = e.target.getLatLng();
                setCoords(pos.lat, pos.lng);
            });
        }
        if (panTo) {
            map.setView([lat, lng], Math.max(map.getZoom(), 15));
        }
    }

    function setSearchStatus(message, isError) {
        if (!searchStatus) return;
        if (!message) {
            searchStatus.hidden = true;
            searchStatus.textContent = '';
            searchStatus.classList.remove('is-error');
            return;
        }
        searchStatus.hidden = false;
        searchStatus.textContent = message;
        searchStatus.classList.toggle('is-error', !!isError);
    }

    function clearSearchResults() {
        if (!searchResults) return;
        searchResults.innerHTML = '';
        searchResults.hidden = true;
    }

    function runSearch() {
        if (!searchInput) return;
        const query = searchInput.value.trim();
        if (query.length < 3) {
            setSearchStatus('Ketik minimal 3 karakter untuk mencari.', true);
            clearSearchResults();
            return;
        }

        const now = Date.now();
        const wait = Math.max(0, 1100 - (now - lastSearchAt));
        if (searchBtn) {
            searchBtn.disabled = true;
            searchBtn.textContent = 'Mencari…';
        }
        setSearchStatus('Mencari lokasi…', false);
        clearSearchResults();

        setTimeout(function () {
            lastSearchAt = Date.now();
            const url = new URL('https://nominatim.openstreetmap.org/search');
            url.searchParams.set('format', 'json');
            url.searchParams.set('q', query);
            url.searchParams.set('limit', '6');
            url.searchParams.set('countrycodes', 'id');
            url.searchParams.set('addressdetails', '0');

            fetch(url.toString(), {
                headers: { 'Accept': 'application/json' },
            })
                .then(function (res) {
                    if (!res.ok) throw new Error('Gagal memuat hasil pencarian.');
                    return res.json();
                })
                .then(function (items) {
                    if (!items.length) {
                        setSearchStatus('Lokasi tidak ditemukan. Coba kata kunci lain.', true);
                        return;
                    }
                    setSearchStatus('Pilih salah satu hasil di bawah:', false);
                    if (!searchResults) return;
                    searchResults.innerHTML = '';
                    items.forEach(function (item) {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        const title = document.createTextNode(item.display_name.split(',')[0]);
                        const sub = document.createElement('span');
                        sub.textContent = item.display_name;
                        btn.appendChild(title);
                        btn.appendChild(sub);
                        btn.addEventListener('click', function () {
                            const lat = parseFloat(item.lat);
                            const lng = parseFloat(item.lon);
                            placeMarker(lat, lng, true);
                            clearSearchResults();
                            setSearchStatus('Lokasi dipilih. Geser penanda jika perlu disesuaikan.', false);
                        });
                        searchResults.appendChild(btn);
                    });
                    searchResults.hidden = false;
                })
                .catch(function () {
                    setSearchStatus('Pencarian gagal. Periksa koneksi internet lalu coba lagi.', true);
                })
                .finally(function () {
                    if (searchBtn) {
                        searchBtn.disabled = false;
                        searchBtn.textContent = 'Cari';
                    }
                });
        }, wait);
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', runSearch);
    }
    if (searchInput) {
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                runSearch();
            }
        });
    }

    map.on('click', function (e) {
        placeMarker(e.latlng.lat, e.latlng.lng, false);
    });

    if (hasCoords) {
        placeMarker(defaultLat, defaultLng, false);
    }

    setTimeout(function () { map.invalidateSize(); }, 100);
})();
</script>
@endpush
