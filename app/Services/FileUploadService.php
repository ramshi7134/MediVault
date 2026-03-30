<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    public function upload(UploadedFile $file, string $directory = 'medical-records'): array
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'local');

        return [
            'file_path' => $path,
            'file_mime' => $file->getMimeType(),
            'file_size' => $file->getSize(),
        ];
    }

    public function delete(string $filePath): bool
    {
        if (Storage::disk('local')->exists($filePath)) {
            return Storage::disk('local')->delete($filePath);
        }

        return true;
    }
}
