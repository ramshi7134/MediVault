<?php

namespace Tests\Feature;

use App\Jobs\ProcessOCR;
use App\Models\MedicalRecord;
use App\Models\User;
use App\Services\OCRService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OCRProcessingTest extends TestCase
{
    use RefreshDatabase;

    public function test_ocr_job_updates_record_with_extracted_text(): void
    {
        $user = User::factory()->create();
        $record = MedicalRecord::factory()->create([
            'user_id'    => $user->id,
            'file_path'  => 'medical-records/test.pdf',
            'ocr_status' => 'pending',
        ]);

        $ocrService = $this->createMock(OCRService::class);
        $ocrService->method('extractText')->willReturn('Tab. Paracetamol 500mg 1-0-1');
        $ocrService->method('parsePrescriptions')->willReturn([
            [
                'medicine_name' => 'Paracetamol',
                'dosage'        => '500mg',
                'frequency'     => '1-0-1',
                'duration'      => '',
            ],
        ]);
        $ocrService->method('parseDoctorName')->willReturn(null);

        $job = new ProcessOCR($record);
        $job->handle($ocrService);

        $record->refresh();

        $this->assertEquals('completed', $record->ocr_status);
        $this->assertNotNull($record->extracted_text);
        $this->assertCount(1, $record->prescriptions);
    }
}
