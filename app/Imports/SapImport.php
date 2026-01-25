<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\Projects;
use App\Models\MaterialIssues;
use App\Models\MaterialIssuesItems;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class SapImport implements OnEachRow, WithHeadingRow
{
    /**
     * ======================================================
     * MAIN HANDLER
     * ======================================================
     */
   public function onRow(Row $row)
{
    $data = $row->toArray();

    $spk = trim($data['nomor_kontrak'] ?? '');

    if ($spk === '') {
        return;
    }

    $project = Projects::whereRaw(
        'TRIM(spk_number) = ?',
        [$spk]
    )->first();

    if (!$project) {
        return;
    }

    $project->update([
        'contract_end_date'      => $this->parseDate($data['tgl_berakhir_kontrak'] ?? null),
        'contract_value'         => $this->parseNumber($data['saldo_pdp'] ?? null),
        'proggress_percent'      => (int) ($data['progress'] ?? 0),
        'pdp_category'           => $data['kategori'] ?? null,
        'bastp_date'             => $this->parseDate($data['tgl_bast'] ?? null),
        'slo_date'               => $this->parseDate($data['tgl_slo'] ?? null),
        'constraint_note'        => $data['kendala'] ?? null,
        'follow_up_code'         => $data['tindak_lanjut'] ?? null,
        'target_completion_date' => $this->parseDate($data['target_penyelesaian'] ?? null),
    ]);
}


    /**
     * ======================================================
     * HELPER: PARSE DATE (SAP / EXCEL SAFE)
     * ======================================================
     */
    private function parseDate($value)
    {
        if (!$value) {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return $value->format('Y-m-d');
        }

        if (is_numeric($value)) {
            return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
        }

        return date('Y-m-d', strtotime($value));
    }

    /**
     * ======================================================
     * HELPER: EXTRACT YEAR
     * ======================================================
     */
    private function extractYear($value)
    {
        $date = $this->parseDate($value);
        return $date ? (int) date('Y', strtotime($date)) : (int) date('Y');
    }

    /**
     * ======================================================
     * HELPER: PARSE NUMBER (SAP CURRENCY SAFE)
     * ======================================================
     */
    private function parseNumber($value)
    {
        if (!$value) {
            return 0;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }
}
