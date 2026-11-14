<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard | Web GIS Monitoring</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        :root {
            --bg-a: #e7fff6;
            --bg-b: #fff5e2;
            --bg-c: #dff1ff;
            --ink: #12372a;
            --muted: #4e6d60;
            --card: rgba(255, 255, 255, .9);
            --line: #d1e7dc;
            --accent-main: #ff7a3d;
            --accent-main-2: #ff9f52;
            --accent-alt: #00a978;
            --accent-blue: #0d7bcf;
            --danger-bg: #ffe3e3;
            --danger-ink: #a01e1e;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Sora', sans-serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 8% 16%, rgba(255, 137, 74, .24), transparent 36%),
                radial-gradient(circle at 92% 12%, rgba(13, 123, 207, .18), transparent 34%),
                radial-gradient(circle at 85% 86%, rgba(0, 169, 120, .24), transparent 36%),
                linear-gradient(145deg, var(--bg-a), var(--bg-b) 50%, var(--bg-c));
            min-height: 100vh;
        }

        .page-orb {
            position: fixed;
            width: 42vmax;
            height: 42vmax;
            border-radius: 50%;
            filter: blur(24px);
            opacity: .2;
            z-index: 0;
            pointer-events: none;
        }

        .page-orb.o1 {
            background: #ffbd80;
            top: -18vmax;
            left: -16vmax;
        }

        .page-orb.o2 {
            background: #88dcc5;
            bottom: -18vmax;
            right: -14vmax;
        }

        .layout {
            position: relative;
            z-index: 1;
            width: min(1220px, 100%);
            margin: 0 auto;
            padding: 18px;
            display: grid;
            gap: 12px;
        }

        .hero {
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, .7);
            border-radius: 22px;
            box-shadow: 0 22px 42px rgba(18, 55, 42, .12);
            padding: 20px;
            backdrop-filter: blur(7px);
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .hero-title {
            margin: 0;
            font-size: clamp(1.05rem, 2vw, 1.5rem);
            line-height: 1.35;
        }

        .hero-subtitle {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: .86rem;
        }

        .user-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            padding: 8px 12px;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .03em;
            text-transform: uppercase;
            background: linear-gradient(120deg, #e8fff5, #e9f6ff);
            border: 1px solid #cde8dc;
            color: #1d6249;
        }

        .controls {
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, .78);
            border-radius: 20px;
            box-shadow: 0 20px 38px rgba(18, 55, 42, .1);
            padding: 14px;
            display: grid;
            gap: 10px;
        }

        .control-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }

        .photo-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 10px;
        }

        .photo-field {
            border: 1px solid #cae5d8;
            border-radius: 12px;
            padding: 8px 10px;
            background: #ffffff;
            display: grid;
            gap: 6px;
        }

        .photo-field label {
            font-size: .78rem;
            font-weight: 700;
            color: #2b5d4a;
        }

        .photo-field input[type="file"] {
            font: inherit;
            font-size: .8rem;
            color: #1f4d3d;
        }

        .tugas-row {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 10px;
            margin-top: 10px;
        }

        .tugas-field {
            border: 1px solid #cae5d8;
            border-radius: 12px;
            padding: 8px 10px;
            background: #ffffff;
            display: grid;
            gap: 6px;
        }

        .tugas-field label {
            font-size: .78rem;
            font-weight: 700;
            color: #2b5d4a;
        }

        .tugas-input {
            border: 1px solid #d2e7db;
            border-radius: 8px;
            padding: 8px 10px;
            font: inherit;
            font-size: .8rem;
            color: #1f4d3d;
            background: #f9fffc;
        }

        .tugas-input:focus {
            outline: none;
            border-color: #00a875;
            background: #ffffff;
        }

        .tugas-input::placeholder {
            color: #7a9b8c;
        }

        .file-upload {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #d2e7db;
            border-radius: 10px;
            padding: 6px;
            background: #f9fffc;
            min-height: 42px;
        }

        .file-input {
            display: none;
        }

        .file-trigger {
            border: none;
            border-radius: 8px;
            padding: 8px 12px;
            font: inherit;
            font-size: .78rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(130deg, #0f7fd4, #33a4ec);
            box-shadow: 0 8px 16px rgba(15, 127, 212, .24);
            cursor: pointer;
            transition: transform .16s ease, filter .16s ease;
            white-space: nowrap;
        }

        .file-trigger:hover {
            transform: translateY(-1px);
            filter: saturate(1.06);
        }

        .file-name {
            font-size: .78rem;
            color: #315b4b;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .photo-status {
            border: 1px solid #f0d0b0;
            background: #fff7ef;
            color: #93511c;
            border-radius: 10px;
            padding: 9px 11px;
            font-size: .8rem;
            font-weight: 700;
        }

        .photo-status.is-ready {
            border-color: #b9e9d0;
            background: #ebfff3;
            color: #12784c;
        }

        button,
        .btn {
            border: none;
            border-radius: 12px;
            padding: 10px 12px;
            font: inherit;
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform .16s ease, filter .16s ease;
        }

        .btn-primary {
            color: #fff;
            background: linear-gradient(130deg, var(--accent-main), var(--accent-main-2));
            box-shadow: 0 10px 18px rgba(255, 122, 61, .28);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            filter: saturate(1.06);
        }

        .btn-ghost {
            background: linear-gradient(140deg, #e5fff6, #e6f4ff);
            border: 1px solid #cde8dc;
            color: #1a5f46;
        }

        .btn-danger {
            background: var(--danger-bg);
            border: 1px solid #efc5c5;
            color: var(--danger-ink);
        }

        .tracking-badge {
            display: none;
            border-radius: 999px;
            padding: 8px 11px;
            font-size: .75rem;
            font-weight: 800;
            letter-spacing: .04em;
            text-transform: uppercase;
            background: #ffdcdc;
            border: 1px solid #f1b8b8;
            color: #991f1f;
            animation: pulse 1.4s ease infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(153, 31, 31, .16);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(153, 31, 31, 0);
            }
        }

        .tracking-badge.is-visible {
            display: inline-flex;
            align-items: center;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .stat {
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, .75);
            border-radius: 16px;
            padding: 14px;
            box-shadow: 0 16px 30px rgba(18, 55, 42, .09);
        }

        .stat small {
            color: var(--muted);
            font-size: .78rem;
        }

        .stat strong {
            display: block;
            margin-top: 6px;
            font-size: 1.45rem;
            line-height: 1;
            color: #114233;
        }

        .map-shell {
            background: var(--card);
            border: 1px solid rgba(255, 255, 255, .8);
            border-radius: 20px;
            box-shadow: 0 22px 42px rgba(18, 55, 42, .11);
            padding: 12px;
        }

        .map-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 6px 6px 12px;
            color: #2c5d4b;
            font-size: .85rem;
        }

        #map {
            width: 100%;
            height: min(66vh, 620px);
            min-height: 420px;
            border-radius: 14px;
            border: 2px solid #c5ddcf;
            overflow: hidden;
        }

        .status {
            margin-top: 8px;
            border-radius: 12px;
            border: 1px solid #caecd8;
            background: #ecfff5;
            color: #0f7348;
            padding: 10px 12px;
            font-size: .84rem;
            min-height: 40px;
        }

        .popup-stack {
            position: fixed;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1500;
            pointer-events: none;
            padding: 14px;
        }

        .popup-stack.is-active {
            pointer-events: auto;
        }

        .popup-stack.is-active::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(10, 35, 26, .34);
            backdrop-filter: blur(1.5px);
        }

        .popup-item {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 12px;
            align-items: start;
            width: min(460px, calc(100vw - 30px));
            border-radius: 18px;
            padding: 14px 16px;
            border: 1px solid #c8ead9;
            background: rgba(240, 255, 248, .98);
            color: #14583f;
            box-shadow: 0 24px 44px rgba(18, 55, 42, .28);
            animation: popupIn .22s ease;
        }

        .popup-item.is-error {
            border-color: #f0c2c2;
            background: rgba(255, 237, 237, .98);
            color: #8f2323;
        }

        .popup-item.is-info {
            border-color: #bfdcf5;
            background: rgba(235, 246, 255, .98);
            color: #135d99;
        }

        .popup-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #0fa96f;
            color: #fff;
        }

        .popup-item.is-error .popup-icon {
            background: #cc3f3f;
        }

        .popup-item.is-info .popup-icon {
            background: #2a85cf;
        }

        .popup-icon svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        .popup-content strong {
            display: block;
            margin-bottom: 3px;
            font-size: .95rem;
        }

        .popup-content p {
            margin: 0;
            font-size: .86rem;
            line-height: 1.35;
        }

        .popup-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
            margin-top: 2px;
        }

        .popup-ok {
            min-width: 124px;
            border: none;
            border-radius: 11px;
            padding: 10px 18px;
            font: inherit;
            font-weight: 800;
            font-size: .84rem;
            cursor: pointer;
            color: #fff;
            background: linear-gradient(130deg, #0ea66f, #25c58f);
            box-shadow: 0 10px 20px rgba(14, 166, 111, .24);
        }

        .popup-item.is-error .popup-ok {
            background: linear-gradient(130deg, #cd3f3f, #ea6363);
            box-shadow: 0 10px 20px rgba(205, 63, 63, .24);
        }

        .popup-item.is-info .popup-ok {
            background: linear-gradient(130deg, #2079c8, #48a7ef);
            box-shadow: 0 10px 20px rgba(32, 121, 200, .24);
        }

        .popup-ok:focus-visible {
            outline: 3px solid rgba(18, 89, 153, .35);
            outline-offset: 2px;
        }

        @keyframes popupIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media (max-width: 1024px) {
            .stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .control-row {
                align-items: stretch;
            }

            .photo-row {
                grid-template-columns: 1fr;
            }

            .tugas-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 760px) {
            .layout {
                padding: 14px;
            }

            .hero,
            .controls,
            .map-shell {
                border-radius: 16px;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            button,
            .btn {
                width: 100%;
            }

            #map {
                height: 56vh;
                min-height: 360px;
            }
        }
    </style>
</head>

<body>
    <div class="page-orb o1" aria-hidden="true"></div>
    <div class="page-orb o2" aria-hidden="true"></div>

    <div class="layout">
        <section class="hero">
            <div>
                <h1 class="hero-title">Dashboard Monitoring Sampah Kota Bekasi</h1>
                <p class="hero-subtitle">Pusat peta aktif untuk input lokasi sampah, tracking petugas, dan visual heatmap real-time.</p>
            </div>
            <span class="user-pill">{{ $user->name }} - {{ $user->kelompok?->nama_kelompok ?? '-' }}</span>
        </section>

        <section class="controls">
            <div class="control-row">
                <button type="button" id="btnTracking" class="btn-ghost">Mulai Tracking</button>
                <button type="button" id="btnSampah" class="btn-primary">Input Lokasi Sampah</button>
                <span id="trackingBadge" class="tracking-badge" aria-live="polite">Auto Stopped</span>
                @if ($user->role === 'admin')
                <a href="{{ route('admin.users', [], false) }}" class="btn btn-ghost">Pendaftaran User</a>
                <a href="{{ route('admin.tracking', [], false) }}" class="btn btn-ghost">Riwayat Petugas</a>
                @elseif ($user->role === 'petugas')
                <a href="{{ route('petugas.tracking', [], false) }}" class="btn btn-ghost">Riwayat Tracking Saya</a>
                @endif
                <form method="post" action="{{ route('logout', [], false) }}">
                    @csrf
                    <button type="submit" class="btn-danger">Logout</button>
                </form>
            </div>
            <div class="photo-row">
                <div class="photo-field">
                    <label for="photoBefore">Foto Sebelum Dibersihkan</label>
                    <div class="file-upload">
                        <input type="file" id="photoBefore" class="file-input" accept="image/*">
                        <button type="button" class="file-trigger" data-file-target="photoBefore">Pilih Foto</button>
                        <span id="photoBeforeName" class="file-name">Belum ada file dipilih</span>
                    </div>
                </div>
                <div class="photo-field">
                    <label for="photoAfter">Foto Sesudah Dibersihkan</label>
                    <div class="file-upload">
                        <input type="file" id="photoAfter" class="file-input" accept="image/*">
                        <button type="button" class="file-trigger" data-file-target="photoAfter">Pilih Foto</button>
                        <span id="photoAfterName" class="file-name">Belum ada file dipilih</span>
                    </div>
                </div>
            </div>
            <div class="tugas-row">
                <div class="tugas-field">
                    <label for="jenisSampah">Jenis Sampah</label>
                    <select id="jenisSampah" class="tugas-input">
                        <option value="">-- Pilih Jenis Sampah --</option>
                        <option value="Organik">Organik</option>
                        <option value="Anorganik">Anorganik</option>
                        <option value="Kertas">Kertas</option>
                        <option value="B3">B3 (Bahan Berbahaya dan Beracun)</option>
                        <option value="Residu">Residu</option>
                    </select>
                </div>
                <div class="tugas-field">
                    <label for="tanggalTugas">Tanggal Tugas</label>
                    <input type="date" id="tanggalTugas" class="tugas-input">
                </div>
            </div>
            <div class="tugas-row">
                <div class="tugas-field">
                    <label for="waktuMulai">Waktu Mulai</label>
                    <input type="time" id="waktuMulai" class="tugas-input">
                </div>
                <div class="tugas-field">
                    <label for="waktuSelesai">Waktu Selesai</label>
                    <input type="time" id="waktuSelesai" class="tugas-input">
                </div>
            </div>
            <div class="tugas-row">
                <div class="tugas-field">
                    <label for="lokasiTugas">Lokasi Tugas</label>
                    <input type="text" id="lokasiTugas" class="tugas-input" placeholder="Masukkan lokasi tugas">
                </div>
                <div class="tugas-field">
                    <label for="catatanTugas">Catatan</label>
                    <input type="text" id="catatanTugas" class="tugas-input" placeholder="Catatan tambahan (opsional)">
                </div>
            </div>
            <div class="photo-actions">
                <button type="button" id="btnUploadFoto" class="btn-primary">Upload Foto</button>
            </div>
            <div id="photoStatus" class="photo-status" aria-live="polite">Foto belum lengkap: pilih foto sebelum dan sesudah dibersihkan.</div>
        </section>

        <section class="stats">
            <article class="stat">
                <small>Total Lokasi Sampah</small>
                <strong id="totalSampah">0</strong>
            </article>
            <article class="stat">
                <small>Titik Tracking Hari Ini</small>
                <strong id="totalTracking">0</strong>
            </article>
            <article class="stat">
                <small>Pusat Koordinat</small>
                <strong>-6.2383, 106.9756</strong>
            </article>
        </section>

        <section class="map-shell">
            <div class="map-head">
                <strong>Peta Interaktif</strong>
                <span>Marker · Heatmap · Polyline Tracking</span>
            </div>
            <div id="map"></div>
            <div id="status" class="status">Dashboard siap.</div>
        </section>
    </div>

    <div id="popupStack" class="popup-stack" aria-live="polite" aria-atomic="true"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.heat/dist/leaflet-heat.js"></script>
    <script src="https://unpkg.com/heic2any/dist/heic2any.min.js"></script>
    <script>
        const API_TOKEN = @json($apiToken);
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        const map = L.map('map').setView([-6.2383, 106.9756], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let sampahLayer = L.layerGroup().addTo(map);
        let heatLayer = null;
        let trackingPolyline = L.polyline([], {
            color: '#1f7ae5',
            weight: 4
        }).addTo(map);
        let trackingPoints = [];
        let trackingInterval = null;
        let activeTrackingSessionId = null;
        let isTrackingStepRunning = false;
        let pendingPhotoPayload = null;

        const statusEl = document.getElementById('status');
        const totalSampahEl = document.getElementById('totalSampah');
        const totalTrackingEl = document.getElementById('totalTracking');
        const btnSampahEl = document.getElementById('btnSampah');
        const btnUploadFotoEl = document.getElementById('btnUploadFoto');
        const photoBeforeEl = document.getElementById('photoBefore');
        const photoAfterEl = document.getElementById('photoAfter');
        const photoBeforeNameEl = document.getElementById('photoBeforeName');
        const photoAfterNameEl = document.getElementById('photoAfterName');
        const photoStatusEl = document.getElementById('photoStatus');
        const trackingBadgeEl = document.getElementById('trackingBadge');
        const popupStackEl = document.getElementById('popupStack');
        const DASHBOARD_PERIOD = 'today';
        let activePopupDismiss = null;
        let activePopupKeyHandler = null;

        function isHeicFile(file) {
            if (!file) {
                return false;
            }

            const type = (file.type || '').toLowerCase();
            if (type === 'image/heic' || type === 'image/heif') {
                return true;
            }

            return /\.(heic|heif)$/i.test(file.name || '');
        }

        async function normalizePhotoFile(file, label) {
            if (!file) {
                return null;
            }

            if (!isHeicFile(file)) {
                return file;
            }

            if (typeof window.heic2any !== 'function') {
                throw new Error('File HEIC terdeteksi, tetapi konverter belum siap. Coba reload halaman.');
            }

            setStatus(`Mengonversi ${label} (HEIC) ke JPG...`);
            const converted = await window.heic2any({
                blob: file,
                toType: 'image/jpeg',
                quality: 0.9
            });
            const blob = Array.isArray(converted) ? converted[0] : converted;
            const baseName = (file.name || 'foto').replace(/\.(heic|heif)$/i, '');
            return new File([blob], `${baseName}.jpg`, { type: 'image/jpeg' });
        }

        function authHeaders() {
            return {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${API_TOKEN}`,
                'X-CSRF-TOKEN': CSRF_TOKEN
            };
        }

        function authUploadHeaders() {
            return {
                'Accept': 'application/json',
                'Authorization': `Bearer ${API_TOKEN}`,
                'X-CSRF-TOKEN': CSRF_TOKEN
            };
        }

        function setStatus(text, isError = false) {
            statusEl.textContent = text;
            statusEl.style.background = isError ? '#ffeaea' : '#ebfff3';
            statusEl.style.borderColor = isError ? '#f1c6c6' : '#c7f1d6';
            statusEl.style.color = isError ? '#962525' : '#127a4d';
        }

        function showPopup(message, type = 'success', title = 'Berhasil') {
            if (!popupStackEl) {
                return;
            }

            if (typeof activePopupDismiss === 'function') {
                activePopupDismiss();
            }

            popupStackEl.innerHTML = '';

            const popupEl = document.createElement('div');
            let popupClassName = 'popup-item';
            if (type === 'error') {
                popupClassName += ' is-error';
            } else if (type === 'info') {
                popupClassName += ' is-info';
            }
            popupEl.className = popupClassName;
            popupEl.setAttribute('role', 'dialog');
            popupEl.setAttribute('aria-modal', 'true');

            let iconSvg = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm-1 14.2L6.8 12l1.6-1.6 2.6 2.6 4.6-4.6 1.6 1.6Z"/></svg>';
            if (type === 'error') {
                iconSvg = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm0 14.2a1.2 1.2 0 1 1 1.2-1.2 1.2 1.2 0 0 1-1.2 1.2Zm1.1-4.7h-2.2V6.8h2.2Z"/></svg>';
            } else if (type === 'info') {
                iconSvg = '<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2Zm1.1 15h-2.2v-6h2.2Zm0-8h-2.2V6.8h2.2Z"/></svg>';
            }

            popupEl.innerHTML = `
                <span class="popup-icon">${iconSvg}</span>
                <div class="popup-content">
                    <strong>${title}</strong>
                    <p>${message}</p>
                </div>
                <div class="popup-actions">
                    <button type="button" class="popup-ok" aria-label="Tutup notifikasi">OK</button>
                </div>
            `;

            const okBtn = popupEl.querySelector('.popup-ok');
            let popupRemoved = false;
            const removePopup = () => {
                if (popupRemoved) {
                    return;
                }

                popupRemoved = true;
                popupEl.remove();
                popupStackEl.classList.remove('is-active');

                if (activePopupKeyHandler) {
                    document.removeEventListener('keydown', activePopupKeyHandler);
                    activePopupKeyHandler = null;
                }

                if (activePopupDismiss === removePopup) {
                    activePopupDismiss = null;
                }
            };

            okBtn?.addEventListener('click', () => {
                removePopup();
            });

            popupStackEl.appendChild(popupEl);
            popupStackEl.classList.add('is-active');
            activePopupDismiss = removePopup;

            activePopupKeyHandler = (event) => {
                if (event.key === 'Escape' || event.key === 'Enter') {
                    event.preventDefault();
                    removePopup();
                }
            };
            document.addEventListener('keydown', activePopupKeyHandler);

            okBtn?.focus();
        }

        function setSampahButtonEnabled(enabled) {
            btnSampahEl.disabled = !enabled;
            btnSampahEl.style.opacity = enabled ? '1' : '0.6';
            btnSampahEl.style.cursor = enabled ? 'pointer' : 'not-allowed';
        }

        function setUploadFotoButtonEnabled(enabled) {
            if (!btnUploadFotoEl) {
                return;
            }

            btnUploadFotoEl.disabled = !enabled;
            btnUploadFotoEl.style.opacity = enabled ? '1' : '0.6';
            btnUploadFotoEl.style.cursor = enabled ? 'pointer' : 'not-allowed';
        }

        function setTrackingBadgeVisible(visible) {
            trackingBadgeEl.classList.toggle('is-visible', visible);
        }

        function updateFileLabel(inputEl, labelEl) {
            if (!inputEl || !labelEl) {
                return;
            }

            labelEl.textContent = inputEl.files && inputEl.files[0]
                ? inputEl.files[0].name
                : 'Belum ada file dipilih';
        }

        function bindFilePicker(inputEl, labelEl, targetId) {
            if (!inputEl) {
                return;
            }

            const triggerEl = document.querySelector(`[data-file-target="${targetId}"]`);
            triggerEl?.addEventListener('click', () => inputEl.click());
            inputEl.addEventListener('change', () => {
                updateFileLabel(inputEl, labelEl);
                updatePhotoStatus();
            });
        }

        function setPhotoInputsEnabled(enabled) {
            if (photoBeforeEl) {
                photoBeforeEl.disabled = !enabled;
            }

            if (photoAfterEl) {
                photoAfterEl.disabled = !enabled;
            }

            const triggerButtons = document.querySelectorAll('.file-trigger');
            triggerButtons.forEach((button) => {
                button.disabled = !enabled;
                button.style.opacity = enabled ? '1' : '0.55';
                button.style.cursor = enabled ? 'pointer' : 'not-allowed';
            });
        }

        function hasRequiredSampahPhotos() {
            return Boolean(photoBeforeEl?.files?.[0]) && Boolean(photoAfterEl?.files?.[0]);
        }

        function updatePhotoStatus() {
            if (!photoStatusEl) {
                return;
            }

            if (!pendingPhotoPayload) {
                photoStatusEl.classList.remove('is-ready');
                photoStatusEl.textContent = 'Langkah 1: klik Input Lokasi Sampah dulu, lalu pilih 2 foto.';
                return;
            }

            if (hasRequiredSampahPhotos()) {
                photoStatusEl.classList.add('is-ready');
                photoStatusEl.textContent = 'Foto lengkap: siap klik Upload Foto.';
                return;
            }

            photoStatusEl.classList.remove('is-ready');
            photoStatusEl.textContent = 'Langkah 2: pilih foto sebelum dan sesudah dibersihkan.';
        }

        function resetSampahPhotoInputs() {
            if (photoBeforeEl) {
                photoBeforeEl.value = '';
            }
            if (photoAfterEl) {
                photoAfterEl.value = '';
            }

            updateFileLabel(photoBeforeEl, photoBeforeNameEl);
            updateFileLabel(photoAfterEl, photoAfterNameEl);
            updatePhotoStatus();
        }

        function createTrackingSessionId() {
            if (window.crypto && typeof window.crypto.randomUUID === 'function') {
                return window.crypto.randomUUID();
            }

            return `session-${Date.now()}-${Math.random().toString(36).slice(2, 12)}`;
        }

        async function fetchSampah() {
            try {
                const response = await fetch(`/api/get_sampah?period=${encodeURIComponent(DASHBOARD_PERIOD)}`, {
                    method: 'GET',
                    headers: authHeaders()
                });

                if (!response.ok) {
                    throw new Error('Gagal memuat data sampah.');
                }

                const payload = await response.json();
                const items = payload.data || [];

                sampahLayer.clearLayers();
                const heatData = [];

                items.forEach((item) => {
                    const lat = Number(item.latitude);
                    const lng = Number(item.longitude);
                    if (Number.isNaN(lat) || Number.isNaN(lng)) {
                        return;
                    }

                    L.marker([lat, lng])
                        .addTo(sampahLayer)
                        .bindPopup('Lokasi Sampah');

                    heatData.push([lat, lng, 0.7]);
                });

                if (heatLayer) {
                    map.removeLayer(heatLayer);
                }

                heatLayer = L.heatLayer(heatData, {
                    radius: 25,
                    blur: 18,
                    maxZoom: 17
                }).addTo(map);

                totalSampahEl.textContent = String(items.length);
                setStatus('Data sampah berhasil dimuat.');
            } catch (error) {
                setStatus(error.message || 'Terjadi kesalahan saat mengambil data.', true);
            }
        }

        async function fetchTrackingHistory() {
            try {
                const response = await fetch(`/api/get_tracking?period=${encodeURIComponent(DASHBOARD_PERIOD)}`, {
                    method: 'GET',
                    headers: authHeaders()
                });

                if (!response.ok) {
                    throw new Error('Gagal memuat data tracking.');
                }

                const payload = await response.json();
                const items = payload.data || [];
                const meta = payload.meta || {};

                trackingPoints = items
                    .map((item) => [Number(item.latitude), Number(item.longitude)])
                    .filter((point) => !Number.isNaN(point[0]) && !Number.isNaN(point[1]));

                trackingPolyline.setLatLngs(trackingPoints);
                totalTrackingEl.textContent = String(meta.points_count ?? trackingPoints.length);
            } catch (error) {
                setStatus(error.message || 'Terjadi kesalahan saat mengambil tracking.', true);
            }
        }

        async function reloadMapData() {
            await fetchSampah();
            await fetchTrackingHistory();
        }

        async function saveSampah(lat, lng) {
            const response = await fetch('/api/save_sampah', {
                method: 'POST',
                headers: authHeaders(),
                body: JSON.stringify({
                    latitude: lat,
                    longitude: lng,
                    keterangan: 'Laporan titik sampah'
                })
            });

            if (!response.ok) {
                throw new Error('Gagal menyimpan lokasi sampah.');
            }

            await fetchSampah();
            setStatus('Lokasi sampah berhasil ditambahkan.');
            showPopup('Titik sampah berhasil disimpan ke peta.', 'success', 'Lokasi Sampah Tersimpan');
        }

        async function saveTracking(lat, lng, sessionId, uploadSessionPhotos = false) {
            const body = new FormData();
            body.append('latitude', String(lat));
            body.append('longitude', String(lng));
            body.append('session_id', sessionId);
            body.append('tracked_at', new Date().toISOString());

            if (uploadSessionPhotos) {
                if (photoBeforeEl?.files?.[0]) {
                    const normalizedBefore = await normalizePhotoFile(photoBeforeEl.files[0], 'foto sebelum');
                    if (normalizedBefore) {
                        body.append('image_before', normalizedBefore);
                    }
                }
                if (photoAfterEl?.files?.[0]) {
                    const normalizedAfter = await normalizePhotoFile(photoAfterEl.files[0], 'foto sesudah');
                    if (normalizedAfter) {
                        body.append('image_after', normalizedAfter);
                    }
                }
                
                // Tambahkan data tugas
                const jenisSampah = document.getElementById('jenisSampah')?.value;
                const tanggalTugas = document.getElementById('tanggalTugas')?.value;
                const waktuMulai = document.getElementById('waktuMulai')?.value;
                const waktuSelesai = document.getElementById('waktuSelesai')?.value;
                const lokasiTugas = document.getElementById('lokasiTugas')?.value;
                const catatanTugas = document.getElementById('catatanTugas')?.value;

                if (jenisSampah) body.append('jenis_sampah', jenisSampah);
                if (tanggalTugas) body.append('tanggal_tugas', tanggalTugas);
                if (waktuMulai) body.append('waktu_mulai', waktuMulai);
                if (waktuSelesai) body.append('waktu_selesai', waktuSelesai);
                if (lokasiTugas) body.append('lokasi_tugas', lokasiTugas);
                if (catatanTugas) body.append('catatan', catatanTugas);
            }

            const response = await fetch('/api/save_tracking', {
                method: 'POST',
                headers: authUploadHeaders(),
                body
            });

            if (!response.ok) {
                let message = 'Gagal menyimpan tracking.';

                try {
                    const responseText = await response.text();
                    if (responseText) {
                        try {
                            const payload = JSON.parse(responseText);
                            message = payload?.message || message;
                        } catch (parseError) {
                            message = responseText;
                        }
                    }
                } catch (error) {
                }

                throw new Error(`${message} (HTTP ${response.status})`);
            }
        }

        function getLocation() {
            return new Promise((resolve, reject) => {
                if (!navigator.geolocation) {
                    reject({
                        code: 'UNSUPPORTED',
                        message: 'Browser tidak mendukung geolocation.'
                    });
                    return;
                }

                // Beberapa mobile browser/webview melaporkan isSecureContext=false walau sudah HTTPS.
                // Gunakan deteksi protokol agar geolocation tetap dicoba pada URL https.
                const isHttps = location.protocol === 'https:';
                if (!isHttps && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
                    reject({
                        code: 'INSECURE_CONTEXT',
                        message: 'Geolocation di mobile butuh HTTPS. Gunakan HTTPS/tunnel atau akses via localhost.'
                    });
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        resolve({
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        });
                    },
                    (error) => {
                        const codeMap = {
                            1: 'PERMISSION_DENIED',
                            2: 'POSITION_UNAVAILABLE',
                            3: 'TIMEOUT'
                        };

                        const messageMap = {
                            1: 'Izin lokasi ditolak. Izinkan akses lokasi untuk browser ini.',
                            2: 'Lokasi belum bisa didapatkan. Pastikan GPS aktif dan sinyal cukup.',
                            3: 'Pengambilan lokasi timeout. Coba lagi atau pindah ke area sinyal lebih baik.'
                        };

                        reject({
                            code: codeMap[error.code] || 'UNKNOWN',
                            message: messageMap[error.code] || 'Terjadi kendala saat mengambil geolocation.'
                        });
                    }, {
                        enableHighAccuracy: true,
                        timeout: 12000,
                        maximumAge: 0
                    }
                );
            });
        }

        async function runTrackingStep() {
            if (isTrackingStepRunning) {
                return true;
            }

            isTrackingStepRunning = true;

            try {
                const point = await getLocation();
                if (!activeTrackingSessionId) {
                    activeTrackingSessionId = createTrackingSessionId();
                }

                await saveTracking(point.lat, point.lng, activeTrackingSessionId, false);

                await fetchTrackingHistory();
                setSampahButtonEnabled(true);
                setStatus('Tracking aktif. Titik terakhir tersimpan.');
                return true;
            } catch (error) {
                const errorCode = error && error.code ? error.code : 'UNKNOWN';
                const errorMessage = error && error.message ? error.message : 'Gagal mengambil lokasi tracking.';

                if (errorCode === 'PERMISSION_DENIED') {
                    stopTracking(true);
                    setTrackingBadgeVisible(true);
                    setStatus('Lokasi dimatikan/ditolak. Tracking otomatis dihentikan.', true);
                    return false;
                }

                if (errorCode === 'INSECURE_CONTEXT') {
                    stopTracking(true);
                    setTrackingBadgeVisible(true);
                    setStatus('Tracking butuh HTTPS di HP. Buka aplikasi lewat URL HTTPS (tunnel) agar lokasi bisa dibaca.', true);
                    return false;
                }

                if (errorCode === 'POSITION_UNAVAILABLE' || errorCode === 'TIMEOUT') {
                    setStatus('Sinyal GPS belum stabil. Tracking tetap aktif dan akan mencoba lagi otomatis.', true);
                    return true;
                }

                setStatus(errorMessage, true);
                return false;
            } finally {
                isTrackingStepRunning = false;
            }
        }

        async function startTracking() {
            if (trackingInterval) {
                setStatus('Tracking sudah berjalan.');
                return;
            }

            const firstTrackingSuccess = await runTrackingStep();
            if (!firstTrackingSuccess) {
                return;
            }

            setTrackingBadgeVisible(false);
            trackingInterval = setInterval(runTrackingStep, 5000);
            document.getElementById('btnTracking').textContent = 'Stop Tracking';
            showPopup('Tracking berhasil dimulai dan titik lokasi akan dikirim tiap 5 detik.', 'success', 'Tracking Aktif');
        }

        function stopTracking(autoStopped = false) {
            if (!trackingInterval) {
                return;
            }

            clearInterval(trackingInterval);
            trackingInterval = null;
            activeTrackingSessionId = null;
            document.getElementById('btnTracking').textContent = 'Mulai Tracking';

            if (!autoStopped) {
                setTrackingBadgeVisible(false);
            }

            if (!autoStopped) {
                setStatus('Tracking dihentikan.');
                showPopup('Tracking berhasil dihentikan.', 'info', 'Tracking Berhenti');
            }
        }

        async function toggleTracking() {
            if (trackingInterval) {
                stopTracking();
                return;
            }

            await startTracking();
        }

        document.getElementById('btnSampah').addEventListener('click', async () => {
            try {
                const point = await getLocation();
                await saveSampah(point.lat, point.lng);

                pendingPhotoPayload = {
                    latitude: point.lat,
                    longitude: point.lng,
                    sessionId: createTrackingSessionId(),
                };

                resetSampahPhotoInputs();
                setPhotoInputsEnabled(true);
                setUploadFotoButtonEnabled(true);
                updatePhotoStatus();
                map.setView([point.lat, point.lng], 15);
                setStatus('Lokasi sampah tersimpan. Lanjut pilih 2 foto lalu klik Upload Foto.');
                showPopup('Lokasi sampah sudah tersimpan. Sekarang pilih foto sebelum/sesudah, lalu klik tombol Upload Foto.', 'info', 'Lanjut Upload Foto');
            } catch (error) {
                setStatus((error && error.message) || 'Tidak dapat mengirim lokasi sampah.', true);
            }
        });

        btnUploadFotoEl.addEventListener('click', async () => {
            try {
                if (!pendingPhotoPayload) {
                    setStatus('Input lokasi sampah dulu sebelum upload foto.', true);
                    showPopup('Silakan klik Input Lokasi Sampah terlebih dahulu, baru upload foto.', 'info', 'Langkah Belum Lengkap');
                    return;
                }

                if (!hasRequiredSampahPhotos()) {
                    setStatus('Pilih 2 foto terlebih dahulu: sebelum dan sesudah dibersihkan.', true);
                    showPopup('Foto belum lengkap. Pilih foto sebelum dan sesudah dibersihkan.', 'info', 'Foto Belum Lengkap');
                    return;
                }

                await saveTracking(
                    pendingPhotoPayload.latitude,
                    pendingPhotoPayload.longitude,
                    pendingPhotoPayload.sessionId,
                    true
                );

                await fetchTrackingHistory();
                resetSampahPhotoInputs();
                pendingPhotoPayload = null;
                setPhotoInputsEnabled(false);
                setUploadFotoButtonEnabled(false);
                updatePhotoStatus();

                setStatus('Foto sebelum/sesudah berhasil diunggah dan masuk ke riwayat tracking.');
                showPopup('Upload foto berhasil. Data sudah masuk ke Riwayat Tracking Saya.', 'success', 'Upload Foto Berhasil');
            } catch (error) {
                const message = (error && error.message) || 'Gagal upload foto.';
                setStatus(message, true);
                showPopup(message, 'error', 'Upload Foto Gagal');
            }
        });

        document.getElementById('btnTracking').addEventListener('click', toggleTracking);

        bindFilePicker(photoBeforeEl, photoBeforeNameEl, 'photoBefore');
        bindFilePicker(photoAfterEl, photoAfterNameEl, 'photoAfter');
        updatePhotoStatus();
        setPhotoInputsEnabled(false);
        setUploadFotoButtonEnabled(false);

        setTrackingBadgeVisible(false);
        setSampahButtonEnabled(true);
        reloadMapData();
    </script>
</body>

</html>