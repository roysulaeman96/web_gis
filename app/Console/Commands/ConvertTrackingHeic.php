<?php

namespace App\Console\Commands;

use App\Models\Tracking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ConvertTrackingHeic extends Command
{
    protected $signature = 'tracking:convert-heic
        {--delete-original : Hapus file HEIC/HEIF setelah sukses dikonversi}
        {--limit= : Batasi jumlah record yang diproses}
        {--dry-run : Tampilkan rencana tanpa melakukan perubahan}';

    protected $description = 'Konversi foto tracking HEIC/HEIF ke JPG dan update path di database.';

    public function handle(): int
    {
        if (! class_exists(\Imagick::class)) {
            $this->error('Imagick belum terpasang. Install extension Imagick dengan dukungan HEIC/HEIF.');
            return self::FAILURE;
        }

        $supportsHeic = ! empty(\Imagick::queryFormats('HEIC')) || ! empty(\Imagick::queryFormats('HEIF'));
        if (! $supportsHeic) {
            $this->error('Imagick tidak mendukung HEIC/HEIF. Pastikan ImageMagick + libheif sudah terpasang.');
            return self::FAILURE;
        }

        $limit = $this->option('limit');
        $disk = Storage::disk('public');

        $query = Tracking::query()->where(function ($query) {
            $query->where('image_before_path', 'like', '%.heic')
                ->orWhere('image_before_path', 'like', '%.heif')
                ->orWhere('image_after_path', 'like', '%.heic')
                ->orWhere('image_after_path', 'like', '%.heif');
        });

        if ($limit) {
            $query->limit((int) $limit);
        }

        $records = $query->get();
        if ($records->isEmpty()) {
            $this->info('Tidak ada file HEIC/HEIF yang perlu dikonversi.');
            return self::SUCCESS;
        }

        $converted = 0;
        $skipped = 0;
        $deleted = 0;
        $dryRun = (bool) $this->option('dry-run');
        $deleteOriginal = (bool) $this->option('delete-original');

        foreach ($records as $record) {
            $updated = false;

            foreach (['image_before_path', 'image_after_path'] as $field) {
                $path = $record->{$field};
                if (! $this->isHeicPath($path)) {
                    continue;
                }

                if (! $disk->exists($path)) {
                    $this->warn("File tidak ditemukan: {$path}");
                    $skipped++;
                    continue;
                }

                $targetPath = preg_replace('/\.(heic|heif)$/i', '.jpg', $path);
                if (! $targetPath) {
                    $skipped++;
                    continue;
                }

                $sourceFile = $disk->path($path);
                $targetFile = $disk->path($targetPath);

                if ($dryRun) {
                    $this->line("[DRY RUN] {$path} -> {$targetPath}");
                    $record->{$field} = $targetPath;
                    $updated = true;
                    continue;
                }

                if (! $disk->exists($targetPath)) {
                    try {
                        $image = new \Imagick($sourceFile);
                        $image->setImageFormat('jpeg');
                        $image->setImageCompressionQuality(90);
                        $image->writeImage($targetFile);
                        $image->clear();
                        $image->destroy();
                    } catch (\Throwable $error) {
                        $this->warn("Gagal konversi {$path}: {$error->getMessage()}");
                        $skipped++;
                        continue;
                    }
                }

                $record->{$field} = $targetPath;
                $updated = true;
                $converted++;

                if ($deleteOriginal) {
                    $disk->delete($path);
                    $deleted++;
                }
            }

            if ($updated && ! $dryRun) {
                $record->save();
            }
        }

        $this->info("Selesai. Converted: {$converted}, Skipped: {$skipped}, Deleted: {$deleted}.");
        return self::SUCCESS;
    }

    private function isHeicPath(?string $path): bool
    {
        if (! $path) {
            return false;
        }

        return (bool) preg_match('/\.(heic|heif)$/i', $path);
    }
}
