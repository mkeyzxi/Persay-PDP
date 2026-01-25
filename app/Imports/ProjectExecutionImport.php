<?php

namespace App\Imports;

use App\Models\Projects;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ProjectExecutionImport implements OnEachRow, WithHeadingRow
{
    /**
     * Penanda apakah minimal satu project ditemukan
     */
    private bool $projectFound = false;

    public function projectFound(): bool
    {
        return $this->projectFound;
    }

    /**
     * Dipanggil untuk setiap baris Excel
     */
    public function onRow(Row $row)
    {
        $data = $row->toArray();

        // DEBUG: Log semua key dari Excel untuk melihat format header yang sebenarnya
        Log::info('Excel Row Keys:', array_keys($data));
        Log::info('Excel Row Data:', $data);

        /**
         * ===============================
         * 1. VALIDASI KOLOM KUNCI
         * ===============================
         * Laporan Rekap WAJIB punya Nomor Kontrak
         */
        if (empty($data['nomor_kontrak'])) {
            Log::warning('Nomor kontrak kosong atau key tidak ditemukan');
            return;
        }

        $contractNumber = trim($data['nomor_kontrak']);

        Log::info('Mencari contract_number: ' . $contractNumber);

        /**
         * ===============================
         * 2. CARI PROJECT BERDASARKAN CONTRACT NUMBER
         * ===============================
         */
        $project = Projects::where('contract_number', $contractNumber)->first();

        /**
         * Jika tidak ketemu → skip
         */
        if (!$project) {
            Log::warning('Project tidak ditemukan untuk contract_number: ' . $contractNumber);
            return;
        }

        $this->projectFound = true;

        /**
         * ===============================
         * 3. UPDATE DATA EXECUTION / AKUNTANSI
         * ===============================
         */

        $project->update([
            'contract_end_date' => $this->parseDate(
                $data['tgl_berakhir_kontrak'] ?? null
            ),

            'proggress_percent' => $this->parseProgress(
                $data['progress']
                    ?? $data['progress_']
                    ?? $data['progress_percent']
                    ?? 0
            ),

            'pdp_category' => $data['kategori'] ?? null,

            'bastp_date' => $this->parseDate(
                $data['tgl_bast'] ?? null
            ),

            'slo_date' => $this->parseDate(
                $data['tgl_slo'] ?? null
            ),

            'follow_up_code' => $data['tindak_lanjut'] ?? null,

            'target_completion_date' => $this->parseDate(
                $data['target_penyelesaian'] ?? null
            ),

            'constraint_note' => $data['kendala']
                ?? $data['remark']
                ?? null,
        ]);
    }

    /**
     * Helper: Parse Date
     * Mendukung format:
     * - Excel numeric serial date
     * - DD/MM/YYYY (format Indonesia)
     * - DD-MM-YYYY (format Indonesia)
     * - YYYY-MM-DD (format ISO)
     */
    private function parseDate($value): ?string
    {
        if (!$value) {
            return null;
        }

        // Jika numeric (Excel serial date)
        if (is_numeric($value)) {
            return ExcelDate::excelToDateTimeObject($value)
                ->format('Y-m-d');
        }

        $value = trim($value);

        // Coba parse format DD/MM/YYYY atau DD-MM-YYYY (format Indonesia)
        if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $value, $matches)) {
            $day = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
            $year = $matches[3];

            // Validasi tanggal
            if (checkdate((int) $month, (int) $day, (int) $year)) {
                return "{$year}-{$month}-{$day}";
            }
        }

        // Coba parse format YYYY-MM-DD atau YYYY/MM/DD
        if (preg_match('/^(\d{4})[\/\-](\d{1,2})[\/\-](\d{1,2})$/', $value, $matches)) {
            $year = $matches[1];
            $month = str_pad($matches[2], 2, '0', STR_PAD_LEFT);
            $day = str_pad($matches[3], 2, '0', STR_PAD_LEFT);

            if (checkdate((int) $month, (int) $day, (int) $year)) {
                return "{$year}-{$month}-{$day}";
            }
        }

        // Fallback: coba parse dengan DateTime
        try {
            $date = new \DateTime($value);
            return $date->format('Y-m-d');
        } catch (\Exception $e) {
            Log::warning("Gagal parse tanggal: {$value}");
            return null;
        }
    }

    /**
     * Helper: Parse Progress Percentage
     * Mendukung format:
     * - Integer: 50
     * - Dengan persen: 50%, 50 %
     * - Desimal: 50.5, 50,5
     */
    private function parseProgress($value): int
    {
        if (!$value) {
            return 0;
        }

        // Konversi ke string untuk processing
        $value = (string) $value;

        // Hapus karakter % dan spasi
        $value = str_replace(['%', ' '], '', $value);

        // Ganti koma dengan titik untuk desimal
        $value = str_replace(',', '.', $value);

        // Konversi ke integer (membulatkan jika desimal)
        return (int) round((float) $value);
    }
}
