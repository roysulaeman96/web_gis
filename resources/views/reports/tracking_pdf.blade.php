<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        body { 
            font-family: Arial, sans-serif; 
            color: #1f1f1f; 
            font-size: 10px;
            margin: 10px;
        }
        h2 { 
            margin: 0 0 6px 0; 
            font-size: 16px;
            text-align: center;
        }
        .meta { 
            margin-bottom: 10px; 
            font-size: 9px;
            text-align: center;
            color: #555;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 9px;
        }
        th, td { 
            border: 1px solid #333; 
            padding: 4px; 
            vertical-align: top;
            word-wrap: break-word;
        }
        th { 
            background: #e0e0e0; 
            font-weight: bold;
            text-align: center;
        }
        td {
            text-align: left;
        }
        img { 
            width: 80px; 
            height: auto; 
            display: block;
            margin: 0 auto;
        }
        .no-data { 
            text-align: center; 
            color: #999; 
            font-style: italic; 
        }
        .status-badge {
            padding: 2px 4px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
        }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-in_progress { background: #cce5ff; color: #004085; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <div class="meta">
        Petugas: {{ $user->name ?? '-' }} | Email: {{ $user->email ?? '-' }} | Username: {{ $user->username ?? '-' }}
        | Periode: {{ $filter_label }} | Dicetak: {{ $generated_at->format('d/m/Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 6%;">No</th>
                <th style="width: 10%;">Nama</th>
                <th style="width: 8%;">Waktu Tracking</th>
                <th style="width: 6%;">Latitude</th>
                <th style="width: 6%;">Longitude</th>
                <th style="width: 10%;">Nama Kelompok</th>
                <th style="width: 10%;">Foto Sebelum</th>
                <th style="width: 10%;">Foto Sesudah</th>
                <th style="width: 9%;">Jenis Sampah</th>
                <th style="width: 7%;">Tanggal Tugas</th>
                <th style="width: 7%;">Waktu Tugas</th>
                <th style="width: 8%;">Lokasi</th>
                <th style="width: 8%;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($combined_data as $index => $row)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $row['nama'] ?? '-' }}</td>
                    
                    <!-- Tracking Data -->
                    <td>{{ $row['waktu_tracking'] ?? '-' }}</td>
                    <td style="text-align: center;">{{ $row['latitude'] ?? '-' }}</td>
                    <td style="text-align: center;">{{ $row['longitude'] ?? '-' }}</td>
                    <td>{{ $row['nama_kelompok'] ?? '-' }}</td>
                    <td style="text-align: center;">
                        @if (!empty($row['foto_sebelum']))
                            <img src="{{ $row['foto_sebelum'] }}" alt="Sebelum">
                        @else
                            -
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if (!empty($row['foto_sesudah']))
                            <img src="{{ $row['foto_sesudah'] }}" alt="Sesudah">
                        @else
                            -
                        @endif
                    </td>
                    
                    <!-- Kelompok Data -->
                    <!-- Tugas Data -->
                    <td>{{ $row['jenis_sampah'] ?? '-' }}</td>
                    <td>{{ $row['tanggal_tugas'] ?? '-' }}</td>
                    <td>{{ $row['waktu_tugas'] ?? '-' }}</td>
                    <td>{{ $row['lokasi'] ?? '-' }}</td>
                    <td>{{ $row['catatan'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="13" class="no-data">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

<script>
    window.addEventListener('load', () => {
        const images = Array.from(document.images);
        if (images.length === 0) {
            window.print();
            return;
        }

        let pending = images.length;
        const done = () => {
            pending -= 1;
            if (pending <= 0) {
                window.print();
            }
        };

        images.forEach((img) => {
            if (img.complete) {
                done();
                return;
            }
            img.onload = done;
            img.onerror = done;
        });
    });
</script>
</body>
</html>
