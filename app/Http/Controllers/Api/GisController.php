<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sampah;
use App\Models\Tracking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class GisController extends Controller
{
    public function saveSampah(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $sampah = Sampah::create([
            'user_id' => $request->user()->id,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'keterangan' => isset($validated['keterangan'])
                ? strip_tags(trim($validated['keterangan']))
                : null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Lokasi sampah tersimpan.',
            'data' => $sampah,
        ], 201);
    }

    public function getSampah(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'period' => ['nullable', 'in:today,7d,30d,all'],
            'start_date' => ['nullable', 'date', 'required_with:end_date'],
            'end_date' => ['nullable', 'date', 'required_with:start_date', 'after_or_equal:start_date'],
        ]);

        $sampah = Sampah::query()
            ->select(['id', 'user_id', 'latitude', 'longitude', 'keterangan', 'created_at'])
            ->when(true, function (Builder $query) use ($validated): void {
                $this->applyPeriodFilter(
                    $query,
                    $validated['period'] ?? 'all',
                    $validated['start_date'] ?? null,
                    $validated['end_date'] ?? null,
                    'created_at'
                );
            })
            ->latest('id')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $sampah,
        ]);
    }

    public function saveTracking(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'session_id' => ['nullable', 'string', 'max:64'],
            'tracked_at' => ['nullable', 'date'],
            'image_before' => ['nullable', 'file', 'mimetypes:image/*,image/heic,image/heif', 'max:5120'],
            'image_after' => ['nullable', 'file', 'mimetypes:image/*,image/heic,image/heif', 'max:5120'],
            'jenis_sampah' => ['nullable', 'string', 'max:100'],
            'tanggal_tugas' => ['nullable', 'date'],
            'waktu_mulai' => ['nullable', 'date_format:H:i'],
            'waktu_selesai' => ['nullable', 'date_format:H:i'],
            'lokasi_tugas' => ['nullable', 'string', 'max:255'],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        $imageBeforePath = $request->hasFile('image_before')
            ? $request->file('image_before')->store('tracking_photos/before', 'public')
            : null;
        $imageAfterPath = $request->hasFile('image_after')
            ? $request->file('image_after')->store('tracking_photos/after', 'public')
            : null;

        $tracking = Tracking::create([
            'user_id' => $request->user()->id,
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'image_before_path' => $imageBeforePath,
            'image_after_path' => $imageAfterPath,
            'session_id' => $validated['session_id'] ?? null,
            'tracked_at' => $validated['tracked_at'] ?? Carbon::now()->toDateTimeString(),
            'jenis_sampah' => $validated['jenis_sampah'] ?? null,
            'tanggal_tugas' => $validated['tanggal_tugas'] ?? null,
            'waktu_mulai' => $validated['waktu_mulai'] ?? null,
            'waktu_selesai' => $validated['waktu_selesai'] ?? null,
            'lokasi_tugas' => $validated['lokasi_tugas'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Tracking tersimpan.',
            'data' => $tracking,
        ], 201);
    }

    public function getTracking(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'period' => ['nullable', 'in:today,7d,30d,all'],
            'start_date' => ['nullable', 'date', 'required_with:end_date'],
            'end_date' => ['nullable', 'date', 'required_with:start_date', 'after_or_equal:start_date'],
        ]);

        $authUser = $request->user();
        $targetUserId = $authUser->id;

        if ($authUser->role === 'admin' && isset($validated['user_id'])) {
            $targetUserId = (int) $validated['user_id'];
        }

        $tracking = Tracking::query()
            ->select(['id', 'user_id', 'latitude', 'longitude', 'image_before_path', 'image_after_path', 'session_id', 'tracked_at'])
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

        $trackingData = $tracking->map(function (Tracking $item): array {
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'latitude' => $item->latitude,
                'longitude' => $item->longitude,
                'image_before_path' => $item->image_before_path,
                'image_after_path' => $item->image_after_path,
                'image_before_url' => $item->image_before_path
                    ? '/storage/' . $item->image_before_path
                    : null,
                'image_after_url' => $item->image_after_path
                    ? '/storage/' . $item->image_after_path
                    : null,
                'session_id' => $item->session_id,
                'tracked_at' => $item->tracked_at,
            ];
        });

        $sessionCount = $tracking
            ->pluck('session_id')
            ->filter(fn(?string $sessionId) => ! empty($sessionId))
            ->unique()
            ->count();

        return response()->json([
            'status' => true,
            'data' => $trackingData,
            'meta' => [
                'points_count' => $trackingData->count(),
                'session_count' => $sessionCount,
            ],
        ]);
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
