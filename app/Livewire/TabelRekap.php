<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Projects; // Pastikan nama Model sesuai (Project atau Projects)

class TabelRekap extends Component
{
    use WithPagination;

    //usepagination]
    public function render()
    {

        $projects = Projects::with('materialIssues.items')
            ->paginate(20);
        $projects->getCollection()->transform(function ($project) {

            $saldoPdp = $project->materialIssues
                ->flatMap(fn($mi) => $mi->items)
                ->sum('val_currency');

            $start = $project->contract_start_date
                ? Carbon::parse($project->contract_start_date)
                : null;

            $now = Carbon::now();
            $umurHari  = $start ? $start->diffInDays($now) : 0;
            $umurBulan = $start ? $start->diffInMonths($now) : 0;

            if ($umurBulan < 3) {
                $klaster = '< 3 Bulan';
            } elseif ($umurBulan <= 6) {
                $klaster = '3 - 6 Bulan';
            } elseif ($umurBulan <= 12) {
                $klaster = '6 - 12 Bulan';
            } else {
                $klaster = '> 1 Tahun';
            }

            return (object) [
                'spk_number' => $project->spk_number,
                'project_name' => $project->project_name,
                'contract_end_date' => $project->contract_end_date,

                'saldo_pdp' => $saldoPdp,
                'umur_hari' => $umurHari,
                'umur_bulan' => $umurBulan,
                'klaster_umur' => $klaster,

                'proggress_percent' => $project->proggress_percent,
                'pdp_category' => $project->pdp_category,
                'ket_kategori' => $this->getKeteranganKategori($project->pdp_category),

                'bastp_date' => $project->bastp_date,
                'slo_date' => $project->slo_date,
                'constraint_note' => $project->constraint_note,

                'follow_up_code' => $project->follow_up_code,
                'ket_tindak_lanjut' => $this->getKeteranganTindakLanjut($project->follow_up_code),

                'target_completion_date' => $project->target_completion_date,
                'status' => $project->status,
            ];
        });
        return view('livewire.tabel-rekap', [
            'projects' => $projects,
        ]);
    }

    // Fungsi Helper untuk Deskripsi Kategori
    private function getKeteranganKategori($code)
    {
        $list = [
            'D1.1' => 'Sudah selesai, sudah operasi, Proses Settlement (BAST sudah terbit)',
            'D1.2' => 'Sudah selesai, sudah operasi, Proses Settlement (BAST belum terbit)',
            'D1.3' => 'Sudah selesai, sudah operasi, Proses Settlement (terkendala dokumen)',
            'D2'   => 'PDP Sudah Selesai dan belum beroperasi',
            'D3.1' => 'Ongoing Progress',
            'D3.2' => 'Ongoing Progress-Terkendala',
            'D3.3' => 'Progress berhenti sementara',
            'D3.4' => 'Progress berhenti Permanen',
            'D4'   => 'Pengadaan Material Only/ Material On Site',
            'D5'   => 'Diluar kategori PDP D1-D4',
        ];

        return $list[$code] ?? '-';
    }
    // Fungsi Helper untuk Deskripsi TindakLanjut
    private function getKeteranganTindakLanjut($code)
    {
        $list = [
            'TL-1' => 'Kordinasi dengan bagian terkait',
            'TL-2' => 'Kordinasi dengan pengawas pekerjaan terkait BASTP & Kalkulasi Akhir',
            'TL-3' => 'Kordinasi dengan MM terkait mutasi material ',
            'TL-4' => 'Memastikan bahwa sudah lengkap dan siap diasetkan',
            'TL-5' => 'Mengecek kembali kesesuaian material dan jasa sesuai kontrak di SAP',
            'TL-6' => 'Mereklas wbs ke wbs dummy',
            'TL-7' => 'Reklas ke ATBM',
        ];

        return $list[$code] ?? '-';
    }
}
