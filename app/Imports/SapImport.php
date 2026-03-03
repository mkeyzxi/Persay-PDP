<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\Projects;
use App\Models\MaterialIssues;
use App\Models\MaterialIssuesItems;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class SapImport implements ToCollection, WithHeadingRow
{
    // Statistik hasil import
    public int $projectsBaru = 0;
    public int $projectsExisting = 0;
    public int $materialsBaru = 0;
    public int $materialsExisting = 0;
    public int $issuesBaru = 0;
    public int $issuesExisting = 0;
    public int $itemsBaru = 0;
    public int $rowsSkipped = 0;

    public function collection(Collection $rows)
    {
        // 1. Group semua rows berdasarkan SPK Number (unloading_point)
        $grouped = $rows->groupBy(function ($row) {
            return trim($row['unloading_point'] ?? '');
        });

        // 2. Proses setiap group (= 1 project) secara atomik
        foreach ($grouped as $spkNumber => $projectRows) {
            // Skip group tanpa SPK
            if (empty($spkNumber)) {
                $this->rowsSkipped += $projectRows->count();
                continue;
            }

            DB::transaction(function () use ($spkNumber, $projectRows) {
                $this->processProject($spkNumber, $projectRows);
            });
        }
    }

    /**
     * Proses satu project beserta seluruh material issues & items-nya.
     */
    private function processProject(string $spkNumber, Collection $rows)
    {
        // Ambil data dari row pertama untuk info project
        $firstRow = $rows->first();

        // A. FIND OR CREATE PROJECT
        $projectExisted = Projects::where('spk_number', $spkNumber)->exists();

        $project = Projects::firstOrCreate(
            ['spk_number' => $spkNumber],
            [
                'project_name' => $firstRow['purchase_order_text'] ?? 'Project Baru (Auto Import)',
                'wbs_number'   => $firstRow['wbs_element'] ?? null,
                'vendor_name'  => $firstRow['name'] ?? null,
                'unit_code'    => $firstRow['busa'] ?? null,
                'fiscal_year'  => $firstRow['year'] ?? date('Y'),
                'status'       => 'DRAFT',
            ]
        );

        if ($projectExisted) {
            $this->projectsExisting++;
        } else {
            $this->projectsBaru++;
        }

        // B. Proses setiap row untuk material, issue, dan items
        foreach ($rows as $data) {
            $this->processRow($project, $data);
        }
    }

    /**
     * Proses satu baris Excel: buat material master, material issue, dan item.
     */
    private function processRow(Projects $project, $data)
    {
        // B. FIND OR CREATE MATERIAL (MASTER BARANG)
        $materialCode = trim($data['material'] ?? '');

        if (empty($materialCode)) {
            $this->rowsSkipped++;
            return;
        }

        $materialExisted = Material::where('sap_material_code', $materialCode)->exists();

        $material = Material::firstOrCreate(
            ['sap_material_code' => $materialCode],
            [
                'material_description' => $data['material_description'] ?? 'No Description',
                'uom'      => $data['posted_unit_of_meas'] ?? 'EA',
                'category' => 'NON-MDU',
            ]
        );

        if ($materialExisted) {
            $this->materialsExisting++;
        } else {
            $this->materialsBaru++;
        }

        // C. FIND OR CREATE MATERIAL ISSUE (HEADER TRANSAKSI)
        $docNo = trim($data['documentno'] ?? '');

        $issueExisted = MaterialIssues::where('project_id', $project->id)
            ->where('sap_doc_no', $docNo)
            ->exists();

        $materialIssue = MaterialIssues::firstOrCreate(
            [
                'project_id' => $project->id,
                'sap_doc_no' => $docNo,
            ],
            [
                'posting_date' => $this->parseDate($data['postg_date'] ?? null),
                'header_text'  => $data['document_header_text'] ?? null,
                'created_by'   => Auth::id(),
            ]
        );

        if ($issueExisted) {
            $this->issuesExisting++;
        } else {
            $this->issuesBaru++;
        }

        // D. CREATE ITEM (DETAIL BARANG)
        $valCurrency = $this->parseNumber($data['valcoarea_crcy'] ?? 0);
        $qtySap      = $this->parseNumber($data['quantity'] ?? 0);

        // Sanity Check: skip nilai > 100 Milyar (data sampah)
        if (abs($valCurrency) > 100000000000) {
            Log::warning("Skipped abnormal value for SPK {$project->spk_number}: $valCurrency");
            $this->rowsSkipped++;
            return;
        }

        MaterialIssuesItems::create([
            'material_issue_id' => $materialIssue->id,
            'material_id'       => $material->id,
            'quantity_sap'      => $qtySap,
            'val_currency'      => $valCurrency,
            'wbs_element'       => $data['wbs_element'] ?? null,
        ]);

        $this->itemsBaru++;
    }

    // ==================== HELPER FUNCTIONS ====================

    private function parseDate($value)
    {
        if (!$value) return null;
        try {
            if (is_numeric($value)) {
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            }
            return date('Y-m-d', strtotime($value));
        } catch (\Exception $e) {
            return null;
        }
    }

    private function parseNumber($value)
    {
        if (!$value) return 0;
        if (is_numeric($value)) return (float) $value;

        // menghapus ribuan dan koma
        if (strpos($value, ',') !== false) {
            $value = str_replace('.', '', $value); // Hapus titik ribuan
            $value = str_replace(',', '.', $value); // Koma jadi titik
        }

        return (float) $value;
    }

    /**
     * Mendapatkan ringkasan statistik import.
     */
    public function getSummary(): string
    {
        $parts = [];

        if ($this->projectsBaru > 0) {
            $parts[] = "{$this->projectsBaru} project baru";
        }
        if ($this->projectsExisting > 0) {
            $parts[] = "{$this->projectsExisting} project sudah ada";
        }
        if ($this->issuesBaru > 0) {
            $parts[] = "{$this->issuesBaru} dokumen SAP baru";
        }
        if ($this->materialsBaru > 0) {
            $parts[] = "{$this->materialsBaru} material baru";
        }
        if ($this->itemsBaru > 0) {
            $parts[] = "{$this->itemsBaru} item material";
        }
        if ($this->rowsSkipped > 0) {
            $parts[] = "{$this->rowsSkipped} baris dilewati";
        }

        if (empty($parts)) {
            return 'Tidak ada data yang diimport.';
        }

        return 'Berhasil import: ' . implode(', ', $parts) . '.';
    }
}
