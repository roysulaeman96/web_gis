<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function adminTrackingPdf(Request $request)
    {
        return $this->renderTrackingReport($request, true);
    }

    public function petugasTrackingPdf(Request $request)
    {
        return $this->renderTrackingReport($request, false);
    }

    public function adminTrackingPdfDownload(Request $request)
    {
        return $this->downloadTrackingReport($request, true);
    }

    public function petugasTrackingPdfDownload(Request $request)
    {
        return $this->downloadTrackingReport($request, false);
    }

    private function renderTrackingReport(Request $request, bool $isAdmin)
    {
        $data = $this->buildTrackingData($request, $isAdmin);
        return view('reports.tracking_pdf', $data);
    }

    private function downloadTrackingReport(Request $request, bool $isAdmin)
    {
        if (! class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            abort(500, 'DomPDF belum terpasang. Jalankan composer require barryvdh/laravel-dompdf.');
        }

        $data = $this->buildTrackingData($request, $isAdmin);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.tracking_pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download($data['file_name']);
    }

    private function buildTrackingData(Request $request, bool $isAdmin): array
    {
        $validated = $request->validate([
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'period' => ['nullable', 'in:today,7d,30d,all'],
            'start_date' => ['nullable', 'date', 'required_with:end_date'],
            'end_date' => ['nullable', 'date', 'required_with:start_date', 'after_or_equal:start_date'],
        ]);

        $authUser = $request->user();
        $targetUserId = $authUser->id;

        if ($isAdmin && isset($validated['user_id'])) {
            $targetUserId = (int) $validated['user_id'];
        }

        $period = $validated['period'] ?? 'today';
        $startDate = $validated['start_date'] ?? null;
        $endDate = $validated['end_date'] ?? null;

        $tracking = Tracking::query()
            ->with(['user.kelompok'])
            ->select([
                'id',
                'user_id',
                'latitude',
                'longitude',
                'image_before_path',
                'image_after_path',
                'session_id',
                'tracked_at',
                'jenis_sampah',
                'tanggal_tugas',
                'waktu_mulai',
                'waktu_selesai',
                'lokasi_tugas',
                'catatan',
            ])
            ->where('user_id', $targetUserId)
            ->when(true, function (Builder $query) use ($validated): void {
                $this->applyPeriodFilter(
                    $query,
                    $validated['period'] ?? 'today',
                    $validated['start_date'] ?? null,
                    $validated['end_date'] ?? null,
                    'tracked_at'
                );
            })
            ->orderBy('tracked_at')
            ->get();

        $user = $tracking->first()?->user ?? $authUser;
        $user?->loadMissing(['kelompok']);

        $combinedData = [];

        if ($tracking->count() > 0) {
            $namaKelompok = $user?->kelompok?->nama_kelompok ?? '-';
            $anggotaKelompok = $user?->anggota_nama ?? '-';

            foreach ($tracking as $trackingItem) {
                $combinedData[] = [
                    'nama' => $trackingItem->user?->name ?? $user?->name ?? '-',
                    'waktu_tracking' => $trackingItem->tracked_at->format('d/m/Y H:i'),
                    'latitude' => number_format($trackingItem->latitude, 6),
                    'longitude' => number_format($trackingItem->longitude, 6),
                    'foto_sebelum' => $this->imageDataUri($trackingItem->image_before_path) ?? $this->imageUrl($trackingItem->image_before_path),
                    'foto_sesudah' => $this->imageDataUri($trackingItem->image_after_path) ?? $this->imageUrl($trackingItem->image_after_path),
                    'nama_kelompok' => $namaKelompok,
                    'anggota_kelompok' => $anggotaKelompok,
                    'jenis_sampah' => $trackingItem->jenis_sampah ?? '-',
                    'tanggal_tugas' => $trackingItem->tanggal_tugas ? $trackingItem->tanggal_tugas->format('d/m/Y') : '-',
                    'waktu_tugas' => $trackingItem->waktu_mulai && $trackingItem->waktu_selesai 
                        ? substr($trackingItem->waktu_mulai, 0, 5) . ' - ' . substr($trackingItem->waktu_selesai, 0, 5)
                        : ($trackingItem->waktu_mulai ? substr($trackingItem->waktu_mulai, 0, 5) : '-'),
                    'lokasi' => $trackingItem->lokasi_tugas ?? '-',
                    'status' => null,
                    'catatan' => $trackingItem->catatan ?? '-',
                ];
            }
        }

        $data = [
            'title' => $isAdmin ? 'Laporan Riwayat Tracking dan Pengelolaan Sampah' : 'Riwayat Tracking Saya',
            'user' => $user,
            'combined_data' => $combinedData,
            'generated_at' => Carbon::now(),
            'filter_label' => $this->formatFilterLabel($period, $startDate, $endDate),
        ];

        $data['file_name'] = sprintf(
            'laporan_%s_%s.pdf',
            $user->username ?? $user->email ?? 'petugas',
            Carbon::now()->format('Y-m-d')
        );

        return $data;
    }

    private function imageUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $disk = Storage::disk('public');
        if (! $disk->exists($path)) {
            return null;
        }

        $mime = $disk->mimeType($path);
        if (! $mime || ! str_starts_with($mime, 'image/')) {
            return null;
        }

        if (in_array($mime, ['image/heic', 'image/heif'], true)) {
            return null;
        }

        return $disk->url($path);
    }

    private function imageDataUri(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $disk = Storage::disk('public');
        if (! $disk->exists($path)) {
            return null;
        }

        $mime = $disk->mimeType($path);
        if (! $mime || ! str_starts_with($mime, 'image/')) {
            return null;
        }

        if (in_array($mime, ['image/heic', 'image/heif'], true)) {
            return null;
        }

        $contents = $disk->get($path);
        $encoded = base64_encode($contents);
        return "data:{$mime};base64,{$encoded}";
    }

    private function formatFilterLabel(string $period, ?string $startDate, ?string $endDate): string
    {
        if ($startDate && $endDate) {
            return sprintf(
                'Tanggal %s - %s',
                Carbon::parse($startDate)->format('d/m/Y'),
                Carbon::parse($endDate)->format('d/m/Y')
            );
        }

        return match ($period) {
            'today' => 'Hari ini',
            '7d' => '7 hari',
            '30d' => '30 hari',
            'all' => 'Semua',
            default => 'Semua',
        };
    }

    private function applyPeriodFilter(
        Builder $query,
        string $period,
        ?string $startDate,
        ?string $endDate,
        string $column
    ): void {
        if ($startDate && $endDate) {
            $query->whereBetween($column, [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
            return;
        }

        if ($period === 'today') {
            $query->whereDate($column, Carbon::today());
            return;
        }

        if ($period === '7d') {
            $query->where($column, '>=', Carbon::now()->subDays(7));
            return;
        }

        if ($period === '30d') {
            $query->where($column, '>=', Carbon::now()->subDays(30));
        }
    }
}
