<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Tracking | Web GIS Monitoring</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        :root {
            --bg-a: #ecfff6;
            --bg-b: #fff5e3;
            --bg-c: #e1f0ff;
            --card: rgba(255, 255, 255, .9);
            --line: #d2e8dd;
            --ink: #16392b;
            --muted: #5b7669;
            --btn-soft: #e5fff4;
            --btn-blue: #0f7fd4;
            --btn-green: #00a875;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Sora', sans-serif;
            color: var(--ink);
            overflow-x: hidden;
            background:
                radial-gradient(circle at 12% 10%, rgba(15, 127, 212, .2), transparent 34%),
                radial-gradient(circle at 92% 86%, rgba(0, 168, 117, .24), transparent 36%),
                radial-gradient(circle at 88% 14%, rgba(255, 148, 88, .22), transparent 33%),
                linear-gradient(145deg, var(--bg-a), var(--bg-b) 48%, var(--bg-c));
            min-height: 100vh;
        }

        .halo {
            position: fixed;
            width: 40vmax;
            height: 40vmax;
            border-radius: 50%;
            filter: blur(24px);
            opacity: .16;
            pointer-events: none;
            z-index: 0;
        }

        .halo.h1 {
            top: -16vmax;
            left: -14vmax;
            background: #8ad8ff;
        }

        .halo.h2 {
            right: -12vmax;
            bottom: -16vmax;
            background: #8ce3c8;
        }

        .layout {
            position: relative;
            z-index: 1;
            width: min(1240px, 100%);
            margin: 0 auto;
            padding: 18px;
            display: grid;
            gap: 12px;
        }

        .hero {
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, .78);
            border-radius: 20px;
            box-shadow: 0 20px 38px rgba(20, 56, 43, .1);
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .hero strong {
            font-size: 1.1rem;
        }

        .hero .meta {
            font-size: .84rem;
            color: var(--muted);
        }

        .chip {
            border: 1px solid #c8e0d4;
            border-radius: 999px;
            padding: 8px 12px;
            background: linear-gradient(120deg, #edfff7, #e6f4ff);
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .controls {
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, .8);
            border-radius: 18px;
            box-shadow: 0 20px 40px rgba(20, 56, 43, .1);
            padding: 12px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }

        .date-range {
            display: grid;
            grid-template-columns: repeat(2, minmax(150px, 1fr));
            gap: 8px;
            min-width: 340px;
        }

        .date-box {
            border: 1px solid #cae2d6;
            border-radius: 12px;
            background: #fff;
            padding: 6px 9px;
            display: grid;
            gap: 4px;
        }

        .date-box span {
            font-size: .72rem;
            font-weight: 700;
            color: #2c5f4b;
            padding-left: 1px;
        }

        .date-trigger {
            border: none;
            border-radius: 8px;
            padding: 8px 10px;
            background: #f7fffb;
            color: #184f3c;
            text-align: left;
            font: inherit;
            font-size: .83rem;
            font-weight: 700;
            cursor: pointer;
            transition: background .16s ease;
        }

        .date-trigger:hover {
            background: #ecfbf3;
        }

        .date-input-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
            pointer-events: none;
        }

        select,
        .date-input,
        .btn {
            border: 1px solid #cae2d6;
            border-radius: 12px;
            padding: 9px 11px;
            font: inherit;
            font-size: .84rem;
            background: #fff;
            color: var(--ink);
        }

        .date-box .date-input {
            border: none;
            border-radius: 8px;
            padding: 0;
            background: transparent;
        }

        select:focus,
        .date-input:focus {
            outline: none;
            border-color: var(--btn-green);
            box-shadow: 0 0 0 4px rgba(0, 168, 117, .14);
        }

        .btn {
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            transition: transform .16s ease, filter .16s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        #btnExportCsv {
            background: linear-gradient(130deg, var(--btn-blue), #38a2eb);
            border: none;
            color: #fff;
            box-shadow: 0 10px 18px rgba(15, 127, 212, .28);
        }

        #btnDownloadPdf {
            background: linear-gradient(130deg, var(--btn-green), #2fd6a1);
            border: none;
            color: #fff;
            box-shadow: 0 10px 18px rgba(0, 168, 117, .28);
        }

        .btn[href] {
            background: var(--btn-soft);
            color: #15553e;
        }

        .map-shell,
        .table-shell {
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, .82);
            border-radius: 20px;
            box-shadow: 0 22px 42px rgba(20, 56, 43, .1);
            padding: 12px;
        }

        #map {
            height: min(58vh, 520px);
            min-height: 360px;
            border-radius: 14px;
            border: 2px solid #c6ddcf;
        }

        .table-shell h2 {
            margin: 2px 0 10px;
            font-size: 1rem;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            border: 1px solid #deede6;
            border-radius: 12px;
            background: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 620px;
            font-size: .86rem;
        }

        th,
        td {
            border-bottom: 1px solid #edf5f0;
            text-align: left;
            padding: 10px;
        }

        th {
            color: var(--muted);
            font-weight: 700;
            background: #f9fefb;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        td.empty-cell {
            text-align: center;
        }

        .img-preview-btn {
            border: 1px solid #9fd2f0;
            border-radius: 10px;
            background: #e8f6ff;
            color: #0c6bac;
            font: inherit;
            font-size: .78rem;
            font-weight: 700;
            padding: 6px 10px;
            cursor: pointer;
        }

        .img-preview-btn:hover {
            background: #dff2ff;
        }

        .image-modal {
            position: fixed;
            inset: 0;
            background: rgba(8, 29, 21, .58);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 18px;
        }

        .image-modal.is-open {
            display: flex;
        }

        .image-modal-card {
            width: min(760px, 100%);
            background: #fff;
            border-radius: 16px;
            border: 1px solid #d2e7db;
            box-shadow: 0 24px 44px rgba(13, 42, 32, .35);
            overflow: hidden;
        }

        .image-modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 10px 12px;
            border-bottom: 1px solid #e9f2ed;
        }

        .image-modal-head strong {
            font-size: .9rem;
        }

        .image-modal-close {
            border: 1px solid #cae2d6;
            border-radius: 10px;
            background: #f4fff9;
            color: #174d39;
            cursor: pointer;
            font: inherit;
            font-size: .8rem;
            font-weight: 700;
            padding: 6px 10px;
        }

        .image-modal-body {
            padding: 12px;
            background: #f7fcf9;
            display: grid;
            place-items: center;
        }

        .image-modal-body img {
            width: 100%;
            max-height: 72vh;
            object-fit: contain;
            border-radius: 10px;
            border: 1px solid #d4e8dc;
            background: #fff;
        }

        .status {
            margin-top: 8px;
            background: #ecfff5;
            border: 1px solid #caecd9;
            color: #0f7348;
            border-radius: 12px;
            padding: 10px 12px;
            min-height: 40px;
            font-size: .84rem;
        }

        @media (max-width: 860px) {
            .layout {
                padding: 14px;
            }

            .hero,
            .controls,
            .map-shell,
            .table-shell {
                border-radius: 16px;
            }

            .chip {
                width: 100%;
                text-align: center;
            }

            .controls {
                align-items: stretch;
            }

            .date-range {
                width: 100%;
                min-width: 0;
                grid-template-columns: 1fr;
            }

            select,
            .date-input,
            .btn {
                width: 100%;
            }

            #map {
                height: 54vh;
                min-height: 340px;
            }
        }

        @media (max-width: 640px) {
            table {
                min-width: 100%;
                border-collapse: separate;
                border-spacing: 0;
            }

            thead {
                display: none;
            }

            tbody tr {
                display: block;
                border-bottom: 1px solid #edf5f0;
                padding: 10px 0;
            }

            tbody tr:last-child {
                border-bottom: none;
            }

            td {
                display: grid;
                grid-template-columns: 108px 1fr;
                gap: 8px;
                padding: 4px 10px;
                border: none;
                font-size: .81rem;
                word-break: break-word;
            }

            td::before {
                content: attr(data-label);
                font-weight: 700;
                color: #355f4f;
            }

            td.empty-cell {
                display: block;
                padding: 10px;
            }

            td.empty-cell::before {
                content: none;
            }
        }
    </style>
</head>

<body>
    <div class="halo h1" aria-hidden="true"></div>
    <div class="halo h2" aria-hidden="true"></div>

    <div class="layout">
        <section class="hero">
            <div>
                <strong>Riwayat Tracking Petugas</strong>
                <div class="meta">Pantau rute petugas berdasarkan periode waktu dan filter pengguna.</div>
            </div>
            <span class="chip" id="selectedPetugasChip"></span>
        </section>

        <section class="controls">
            <select id="petugasFilter" aria-label="Petugas">
                @foreach ($petugas as $item)
                <option value="{{ $item->id }}" data-email="{{ $item->email }}" data-username="{{ $item->username }}" data-name="{{ $item->name }}" data-kelompok="{{ $item->kelompok?->nama_kelompok ?? '-' }}" data-anggota="{{ $item->anggota_nama ?? '-' }}">{{ $item->name }} - {{ $item->email }}</option>
                @endforeach
            </select>
            <select id="periodFilter" aria-label="Periode waktu">
                <option value="today">Hari ini</option>
                <option value="7d">7 hari</option>
                <option value="30d">30 hari</option>
                <option value="all">Semua</option>
            </select>
            <div class="date-range">
                <div class="date-box">
                    <button type="button" id="startDateTrigger" class="date-trigger" aria-label="Pilih tanggal awal">Dari</button>
                    <input type="date" id="startDate" class="date-input-hidden" aria-label="Tanggal awal">
                </div>
                <div class="date-box">
                    <button type="button" id="endDateTrigger" class="date-trigger" aria-label="Pilih tanggal akhir">Sampai</button>
                    <input type="date" id="endDate" class="date-input-hidden" aria-label="Tanggal akhir">
                </div>
            </div>
            <button type="button" id="btnExportCsv" class="btn">Cetak PDF / Download PDF</button>
            <a href="{{ route('dashboard', [], false) }}" class="btn">Kembali Dashboard</a>
        </section>

        <section class="map-shell">
            <div id="map"></div>
        </section>

        <section class="table-shell">
            <h2>Detail Titik Tracking</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Nama Kelompok</th>
                            <th>Anggota Kelompok</th>
                            <th>Waktu</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Gambar Sebelum Dibersihkan</th>
                            <th>Gambar Sesudah Dibersihkan</th>
                        </tr>
                    </thead>
                    <tbody id="trackingBody">
                        <tr>
                            <td colspan="10" class="empty-cell">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div id="status" class="status">Siap menampilkan riwayat tracking.</div>
        </section>
    </div>

    <div id="imageModal" class="image-modal" aria-hidden="true">
        <div class="image-modal-card" role="dialog" aria-modal="true" aria-labelledby="imageModalTitle">
            <div class="image-modal-head">
                <strong id="imageModalTitle">Preview Gambar</strong>
                <button type="button" id="imageModalClose" class="image-modal-close">Tutup</button>
            </div>
            <div class="image-modal-body">
                <img id="imageModalImg" src="" alt="Preview gambar tracking">
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        const API_TOKEN = @json($apiToken);
        const map = L.map('map').setView([-6.2383, 106.9756], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const polyline = L.polyline([], {
            color: '#1a68c7',
            weight: 4
        }).addTo(map);
        const pointLayer = L.layerGroup().addTo(map);

        const petugasFilterEl = document.getElementById('petugasFilter');
        const periodFilterEl = document.getElementById('periodFilter');
        const startDateEl = document.getElementById('startDate');
        const endDateEl = document.getElementById('endDate');
        const startDateTriggerEl = document.getElementById('startDateTrigger');
        const endDateTriggerEl = document.getElementById('endDateTrigger');
        const exportBtnEl = document.getElementById('btnExportCsv');
        const trackingBodyEl = document.getElementById('trackingBody');
        const statusEl = document.getElementById('status');
        const imageModalEl = document.getElementById('imageModal');
        const imageModalImgEl = document.getElementById('imageModalImg');
        const imageModalTitleEl = document.getElementById('imageModalTitle');
        const imageModalCloseEl = document.getElementById('imageModalClose');

        function authHeaders() {
            return {
                'Accept': 'application/json',
                'Authorization': `Bearer ${API_TOKEN}`
            };
        }

        function setStatus(text, isError = false) {
            statusEl.textContent = text;
            statusEl.style.background = isError ? '#ffe8e8' : '#eaf9f0';
            statusEl.style.borderColor = isError ? '#f0cbcb' : '#c9ecd8';
            statusEl.style.color = isError ? '#8f2323' : '#0c6e42';
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function resolveImageUrl(url) {
            if (!url) {
                return '';
            }

            try {
                const parsed = new URL(url, window.location.origin);
                if (parsed.origin !== window.location.origin) {
                    return `${window.location.origin}${parsed.pathname}${parsed.search}`;
                }
                return parsed.toString();
            } catch (error) {
                return url;
            }
        }

        function openImageModal(url, title) {
            if (!imageModalEl || !imageModalImgEl || !imageModalTitleEl) {
                return;
            }

            const resolvedUrl = resolveImageUrl(url);
            if (!resolvedUrl) {
                return;
            }

            imageModalImgEl.src = resolvedUrl;
            imageModalTitleEl.textContent = title || 'Preview Gambar';
            imageModalEl.classList.add('is-open');
            imageModalEl.setAttribute('aria-hidden', 'false');
        }

        function closeImageModal() {
            if (!imageModalEl || !imageModalImgEl) {
                return;
            }

            imageModalEl.classList.remove('is-open');
            imageModalEl.setAttribute('aria-hidden', 'true');
            imageModalImgEl.src = '';
        }

        function formatDateTrigger(value, fallbackLabel) {
            if (!value) {
                return fallbackLabel;
            }

            const parts = value.split('-');
            if (parts.length !== 3) {
                return fallbackLabel;
            }

            return `${parts[2]}/${parts[1]}/${parts[0]}`;
        }

        function syncDateTriggerLabels() {
            startDateTriggerEl.textContent = formatDateTrigger(startDateEl.value, 'Dari');
            endDateTriggerEl.textContent = formatDateTrigger(endDateEl.value, 'Sampai');
        }

        function openDatePicker(inputEl) {
            if (!inputEl) {
                return;
            }

            if (typeof inputEl.showPicker === 'function') {
                inputEl.showPicker();
                return;
            }

            inputEl.focus();
            inputEl.click();
        }

        function getSelectedPetugasEmail() {
            const selectedOption = petugasFilterEl.options[petugasFilterEl.selectedIndex];
            return selectedOption?.dataset?.email || '-';
        }

        function getSelectedPetugasUsername() {
            const selectedOption = petugasFilterEl.options[petugasFilterEl.selectedIndex];
            return selectedOption?.dataset?.username || '-';
        }

        function getSelectedPetugasName() {
            const selectedOption = petugasFilterEl.options[petugasFilterEl.selectedIndex];
            return selectedOption?.dataset?.name || '-';
        }

        function getSelectedPetugasKelompok() {
            const selectedOption = petugasFilterEl.options[petugasFilterEl.selectedIndex];
            return selectedOption?.dataset?.kelompok || '-';
        }

        function getSelectedPetugasAnggota() {
            const selectedOption = petugasFilterEl.options[petugasFilterEl.selectedIndex];
            return selectedOption?.dataset?.anggota || '-';
        }

        function syncSelectedPetugasChip() {
            const selectedPetugasChip = document.getElementById('selectedPetugasChip');
            if (!selectedPetugasChip) {
                return;
            }

            selectedPetugasChip.textContent = `${getSelectedPetugasName()} - ${getSelectedPetugasKelompok()}`;
        }

        function buildTrackingQuery() {
            const params = new URLSearchParams();
            params.set('user_id', petugasFilterEl.value);

            const startDate = startDateEl.value;
            const endDate = endDateEl.value;

            if (startDate && endDate) {
                params.set('start_date', startDate);
                params.set('end_date', endDate);
            } else {
                params.set('period', periodFilterEl.value);
            }

            return params.toString();
        }

        async function fetchTrackingData() {
            const response = await fetch(`/api/get_tracking?${buildTrackingQuery()}`, {
                method: 'GET',
                headers: authHeaders()
            });

            if (!response.ok) {
                throw new Error('Gagal memuat riwayat tracking petugas.');
            }

            const payload = await response.json();
            return {
                items: payload.data || [],
                meta: payload.meta || {}
            };
        }

        async function fetchTracking() {
            try {
                const result = await fetchTrackingData();
                const items = result.items;
                const meta = result.meta;

                const points = items
                    .map((item) => [Number(item.latitude), Number(item.longitude)])
                    .filter((point) => !Number.isNaN(point[0]) && !Number.isNaN(point[1]));

                polyline.setLatLngs(points);
                pointLayer.clearLayers();

                points.forEach((point) => {
                    L.circleMarker(point, {
                        radius: 4,
                        color: '#0e8c59',
                        fillOpacity: 0.9
                    }).addTo(pointLayer);
                });

                if (points.length > 0) {
                    map.fitBounds(polyline.getBounds(), {
                        padding: [20, 20]
                    });
                }

                if (items.length === 0) {
                    trackingBodyEl.innerHTML = '<tr><td colspan="10" class="empty-cell">Tidak ada data tracking pada periode ini.</td></tr>';
                } else {
                    const selectedEmail = getSelectedPetugasEmail();
                    const selectedUsername = getSelectedPetugasUsername();
                    const selectedName = getSelectedPetugasName();
                    const selectedKelompok = getSelectedPetugasKelompok();
                    const selectedAnggota = getSelectedPetugasAnggota();
                    trackingBodyEl.innerHTML = items
                        .map((item) => `
                            <tr>
                                <td data-label="Email">${selectedEmail}</td>
                                <td data-label="Username">${selectedUsername}</td>
                                <td data-label="Nama">${selectedName}</td>
                                <td data-label="Nama Kelompok">${selectedKelompok}</td>
                                <td data-label="Anggota Kelompok">${selectedAnggota}</td>
                                <td data-label="Waktu">${new Date(item.tracked_at).toLocaleString('id-ID')}</td>
                                <td data-label="Latitude">${Number(item.latitude).toFixed(6)}</td>
                                <td data-label="Longitude">${Number(item.longitude).toFixed(6)}</td>
                                <td data-label="Gambar Sebelum Dibersihkan">
                                    ${item.image_before_url
                                        ? `<button type="button" class="img-preview-btn" data-image-url="${escapeHtml(item.image_before_url)}" data-image-title="Gambar Sebelum Dibersihkan">Lihat Gambar</button>`
                                        : '-'}
                                </td>
                                <td data-label="Gambar Sesudah Dibersihkan">
                                    ${item.image_after_url
                                        ? `<button type="button" class="img-preview-btn" data-image-url="${escapeHtml(item.image_after_url)}" data-image-title="Gambar Sesudah Dibersihkan">Lihat Gambar</button>`
                                        : '-'}
                                </td>
                            </tr>
                        `)
                        .join('');
                }

                const pointsCount = Number(meta.points_count ?? items.length);
                const sessionCount = Number(meta.session_count ?? 0);
                setStatus(`Riwayat: ${sessionCount} kali lokasi dinyalakan, ${pointsCount} titik tracking.`);
            } catch (error) {
                setStatus(error.message || 'Terjadi kesalahan saat memuat data.', true);
            }
        }

        function exportPdf() {
            const params = new URLSearchParams(buildTrackingQuery());
            const url = `/admin/tracking/pdf?${params.toString()}`;
            window.open(url, '_blank');
        }

        petugasFilterEl.addEventListener('change', fetchTracking);
        petugasFilterEl.addEventListener('change', syncSelectedPetugasChip);
        periodFilterEl.addEventListener('change', fetchTracking);
        startDateEl.addEventListener('change', () => {
            syncDateTriggerLabels();
            fetchTracking();
        });
        endDateEl.addEventListener('change', () => {
            syncDateTriggerLabels();
            fetchTracking();
        });
        exportBtnEl.addEventListener('click', exportPdf);
        startDateTriggerEl.addEventListener('click', () => openDatePicker(startDateEl));
        endDateTriggerEl.addEventListener('click', () => openDatePicker(endDateEl));

        trackingBodyEl.addEventListener('click', (event) => {
            const triggerEl = event.target.closest('.img-preview-btn');
            if (!triggerEl) {
                return;
            }

            openImageModal(triggerEl.dataset.imageUrl, triggerEl.dataset.imageTitle);
        });

        imageModalCloseEl?.addEventListener('click', closeImageModal);
        imageModalEl?.addEventListener('click', (event) => {
            if (event.target === imageModalEl) {
                closeImageModal();
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });

        window.addEventListener('resize', () => {
            map.invalidateSize();
        });

        syncDateTriggerLabels();
        syncSelectedPetugasChip();
        fetchTracking();
        window.setTimeout(() => map.invalidateSize(), 250);
    </script>
</body>

</html>