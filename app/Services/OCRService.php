<?php

namespace App\Services;

use App\Models\MedicalRecord;
use App\Models\Prescription;

class OCRService
{
    /**
     * Extract text from a file using Tesseract OCR (if available) or return empty.
     */
    public function extractText(string $filePath): string
    {
        $absolutePath = storage_path('app/' . $filePath);

        if (! file_exists($absolutePath)) {
            return '';
        }

        $mime = mime_content_type($absolutePath);

        if (str_contains($mime, 'pdf')) {
            return $this->extractFromPdf($absolutePath);
        }

        return $this->extractFromImage($absolutePath);
    }

    private function extractFromImage(string $path): string
    {
        if (! $this->isTesseractAvailable()) {
            return '';
        }

        $output = [];
        $escapedPath = escapeshellarg($path);
        exec("tesseract {$escapedPath} stdout -l eng 2>/dev/null", $output);

        return implode("\n", $output);
    }

    private function extractFromPdf(string $path): string
    {
        if (! $this->isPdfToTextAvailable()) {
            return '';
        }

        $escapedPath = escapeshellarg($path);
        $text = shell_exec("pdftotext {$escapedPath} - 2>/dev/null");

        return $text ?? '';
    }

    /**
     * Parse medicines and dosage from extracted text.
     *
     * @return array<int, array{medicine_name: string, dosage: string, frequency: string, duration: string}>
     */
    public function parsePrescriptions(string $text): array
    {
        $prescriptions = [];

        // Basic regex patterns for common Indian prescription formats
        $patterns = [
            // "Tab. Paracetamol 500mg 1-0-1 x 5 days"
            '/(?:Tab(?:let)?\.?|Cap(?:sule)?\.?|Inj(?:ection)?\.?|Syr(?:up)?\.?)\s+([A-Za-z0-9\s\-]+?)\s+(\d+(?:\.\d+)?(?:mg|ml|mcg|g))\s+([\d\-]+(?:\s+x\s+\d+\s+days?)?)/i',
            // "Amoxicillin 250mg - twice daily - 7 days"
            '/([A-Za-z][A-Za-z0-9\s\-]+?)\s+(\d+(?:\.\d+)?(?:mg|ml|mcg|g))\s*[-–]\s*([a-z\s]+daily|[a-z\s]+hourly)\s*[-–]\s*(\d+\s*days?)/i',
        ];

        foreach ($patterns as $pattern) {
            preg_match_all($pattern, $text, $matches, PREG_SET_ORDER);
            foreach ($matches as $match) {
                $prescriptions[] = [
                    'medicine_name' => trim($match[1]),
                    'dosage'        => $match[2] ?? '',
                    'frequency'     => $match[3] ?? '',
                    'duration'      => $match[4] ?? '',
                ];
            }
        }

        return $prescriptions;
    }

    /**
     * Extract doctor name from text.
     */
    public function parseDoctorName(string $text): ?string
    {
        if (preg_match('/Dr\.?\s+([A-Z][a-zA-Z\s\.]+?)(?:\n|,|$)/m', $text, $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    private function isTesseractAvailable(): bool
    {
        exec('which tesseract 2>/dev/null', $out, $code);

        return $code === 0;
    }

    private function isPdfToTextAvailable(): bool
    {
        exec('which pdftotext 2>/dev/null', $out, $code);

        return $code === 0;
    }
}
