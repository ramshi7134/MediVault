<?php

namespace App\Jobs;

use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Services\OCRService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ProcessOCR implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 120;

    public function __construct(
        public readonly MedicalRecord $record,
    ) {}

    public function handle(OCRService $ocrService): void
    {
        $this->record->update(['ocr_status' => 'processing']);

        $text = $ocrService->extractText($this->record->file_path);

        $prescriptionData = $ocrService->parsePrescriptions($text);
        $doctorName = $ocrService->parseDoctorName($text);

        $updates = [
            'extracted_text' => $text,
            'ocr_status'     => 'completed',
        ];

        if ($doctorName && empty($this->record->doctor_name)) {
            $updates['doctor_name'] = $doctorName;
        }

        $this->record->update($updates);

        foreach ($prescriptionData as $data) {
            Prescription::create(array_merge($data, [
                'medical_record_id' => $this->record->id,
            ]));
        }
    }

    public function failed(Throwable $exception): void
    {
        $this->record->update(['ocr_status' => 'failed']);
    }
}
