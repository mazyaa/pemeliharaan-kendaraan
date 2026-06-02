<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function upload(UploadedFile $file, string $directory, array $allowedTypes = null, int $maxSize = 5120): ?string
    {
        if ($allowedTypes && !in_array($file->getMimeType(), $allowedTypes)) {
            return null;
        }

        if ($file->getSize() > $maxSize * 1024) {
            return null;
        }

        return $file->store($directory, 'public');
    }

    public function delete(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }

    public function getUrl(string $path): ?string
    {
        return Storage::disk('public')->url($path);
    }

    public function validateFile(UploadedFile $file, array $allowedTypes = null, int $maxSize = 5120): array
    {
        $errors = [];

        $allowedTypes = $allowedTypes ?? [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'application/pdf',
        ];

        if (!in_array($file->getMimeType(), $allowedTypes)) {
            $errors[] = 'Tipe file tidak diizinkan. Hanya ' . implode(', ', $allowedTypes) . ' yang diperbolehkan.';
        }

        if ($file->getSize() > $maxSize * 1024) {
            $errors[] = "Ukuran file maksimal {$maxSize} KB.";
        }

        return $errors;
    }
}
