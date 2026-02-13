<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\Projects;
use App\Models\MaterialIssues;
use App\Models\MaterialIssuesItems;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class SapImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $data = $row->toArray();

        // Sesuaikan 'unloading_point' dengan header di Excel SAP Anda
        $spkNumber = trim($data['unloading_point'] ?? '');

        if (empty($spkNumber)) {
            return; // Skip baris kosong
        }

        // A. FIND OR CREATE PROJECT
        $project = Projects::firstOrCreate(
            ['spk_number' => $spkNumber],
            [
                // Data default saat proyek baru dibuat otomatis
                'project_name' => $data['purchase_order_text'] ?? 'Project Baru (Auto Import)',
                'wbs_number'   => $data['wbs_element'] ?? null,
                'vendor_name'  => $data['name'] ?? null, // Asumsi kolom Name = Vendor
                'unit_code'    => $data['busa'] ?? null,
                'fiscal_year'  => $data['year'] ?? date('Y'),
                'status'       => 'DRAFT'
            ]
        );

        // B. FIND OR CREATE MATERIAL (MASTER BARANG)
        $materialCode = trim($data['material'] ?? '');

        if (!empty($materialCode)) {
            $material = Material::firstOrCreate(
                ['sap_material_code' => $materialCode],
                [
                    'material_description' => $data['material_description'] ?? 'No Description',
                    'uom'      => $data['posted_unit_of_meas'] ?? 'EA',
                    'category' => 'NON-MDU' // Default, nanti diedit orang logistik
                ]
            );
        } else {
            return; // Skip jika tidak ada kode material
        }

        // C. FIND OR CREATE MATERIAL ISSUE (HEADER TRANSAKSI)
        $docNo = trim($data['documentno'] ?? '');

        $materialIssue = MaterialIssues::firstOrCreate(
            [
                'project_id' => $project->id,
                'sap_doc_no' => $docNo
            ],
            [
                'posting_date' => $this->parseDate($data['postg_date'] ?? null),
                'header_text'  => $data['document_header_text'] ?? null,
                'created_by'   => auth()->id() ?? null,
            ]
        );

        // D. CREATE ITEM (DETAIL BARANG)

        // Bersihkan angka (Rp)
        $valCurrency = $this->parseNumber($data['valcoarea_crcy'] ?? 0);
        $qtySap      = $this->parseNumber($data['quantity'] ?? 0);

        // Sanity Check untuMencegah angka Triliunan (Data Sampah)
        // Jika nilai > 100 Milyar per item, anggap error dan skip
        if (abs($valCurrency) > 100000000000) {
            Log::warning("Skipped abnormal value for SPK $spkNumber: $valCurrency");
            return;
        }

        MaterialIssuesItems::create([
            'material_issue_id' => $materialIssue->id,
            'material_id'       => $material->id,
            'quantity_sap'      => $qtySap,
            'val_currency'      => $valCurrency,
            'wbs_element'       => $data['wbs_element'] ?? null,
            // quantity_installed & asset_number dibiarkan null (tugas konstruksi/akuntansi)
        ]);
    }

    // HELPER FUNCTIONS

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
}
