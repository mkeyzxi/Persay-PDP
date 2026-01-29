<?php

namespace App\Exports;

use App\Models\Projects;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $statuses;

    public function __construct($statuses = ['SEMUA'])
    {
        if ('SEMUA' === $statuses) {
            $this->statuses = ['OPEN', 'CLOSED', 'DRAFT'];
        } else {
            $this->statuses = [$statuses];
        }
    }

    /**
     * Query Utama: Filter hanya OPEN dan CLOSED
     */
    public function query()
    {
        // Kita eager load materialItems untuk performa (N+1 Problem solver)
        // Pastikan relasi 'materialItems' sudah dibuat di Model Project seperti diskusi sebelumnya
        return Projects::query()
            ->whereIn('status', $this->statuses)
            ->with(['materialItems'])
            ->orderBy('status', 'asc') // Grouping by status biar rapi
            ->orderBy('contract_end_date', 'desc');
    }

    /**
     * Mapping: Mengubah Data Database jadi Data Laporan
     * Di sinilah "Magic" terjadi. Jangan dump raw data.
     */
    public function map($project): array
    {
        // 1. Hitung Total Pengeluaran (Realisasi)
        // Pastikan relasi materialItems mengarah ke MaterialIssuesItems via MaterialIssues
        $totalExpense = $project->materialItems->sum('val_currency');

        // 2. Hitung Sisa Saldo
        $contractValue = $project->contract_value ?? 0;
        $remainingBalance = $contractValue - $totalExpense;

        return [
            // --- IDENTITAS ---
            $project->spk_number,
            $project->wbs_number,
            $project->project_name,
            $project->vendor_name,
            $project->unit_code,
            $project->status,

            // --- FINANSIAL (Format Angka Mentah, Biar Excel yang format) ---
            $contractValue,
            $totalExpense,     // Computed
            $remainingBalance, // Computed (CRITICAL VALUE)
            $project->proggress_percent . '%',

            // --- TIMELINE ---
            $project->contract_start_date ? $project->contract_start_date->format('d-m-Y') : '-',
            $project->contract_end_date ? $project->contract_end_date->format('d-m-Y') : '-',
            $project->bastp_date ? $project->bastp_date->format('d-m-Y') : '-',

            // --- KETERANGAN ---
            $project->constraint_note,
        ];
    }

    public function headings(): array
    {
        return [
            'No SPK',
            'WBS Element',
            'Nama Proyek',
            'Vendor',
            'Unit',
            'Status',
            'Nilai Kontrak (Pagu)',
            'Total Realisasi Material',
            'Sisa Saldo (Margin)',
            'Progress Fisik',
            'Tgl Mulai',
            'Tgl Akhir Kontrak',
            'Tgl BAST',
            'Kendala / Catatan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style Header Bold
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
