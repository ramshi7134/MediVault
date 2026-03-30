<?php

namespace App\Services;

use App\Jobs\ProcessOCR;
use App\Models\MedicalRecord;
use App\Repositories\MedicalRecordRepository;
use Illuminate\Http\UploadedFile;

class MedicalRecordService
{
    public function __construct(
        private readonly MedicalRecordRepository $repository,
        private readonly FileUploadService $fileUploadService,
    ) {}

    public function store(int $userId, UploadedFile $file, array $data): MedicalRecord
    {
        $fileInfo = $this->fileUploadService->upload($file);

        $record = $this->repository->create(array_merge($data, [
            'user_id'    => $userId,
            'file_path'  => $fileInfo['file_path'],
            'file_mime'  => $fileInfo['file_mime'],
            'file_size'  => $fileInfo['file_size'],
            'ocr_status' => 'pending',
        ]));

        ProcessOCR::dispatch($record);

        return $record;
    }

    public function delete(MedicalRecord $record): bool
    {
        $this->fileUploadService->delete($record->file_path);

        return $this->repository->delete($record);
    }
}
