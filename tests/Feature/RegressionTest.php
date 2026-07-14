<?php
use App\Models\Projects;
use App\Models\MaterialIssues;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// [R1] Unique constraint project_id + sap_doc_no
it('prevents duplicate sap_doc_no within the same project', function () {
    $project = Projects::factory()->create();
    MaterialIssues::factory()->for($project, 'project')->create(['sap_doc_no' => 'DOC-001']);

    expect(fn () => MaterialIssues::factory()->for($project, 'project')->create(['sap_doc_no' => 'DOC-001']))
        ->toThrow(\Illuminate\Database\QueryException::class);
})->skip('Aktifkan setelah migration unique(project_id, sap_doc_no) diterapkan (R1)');

// [R10] proggress_percent harus 0-100
it('rejects proggress_percent outside 0-100 range', function () {
    expect(fn () => Projects::factory()->create(['proggress_percent' => 150]))
        ->toThrow(\Illuminate\Database\QueryException::class);
})->skip('Aktifkan setelah CHECK constraint / validasi 0-100 diterapkan (R10)');

// [R10] contract_end_date >= contract_start_date
it('rejects contract_end_date earlier than contract_start_date', function () {
    expect(fn () => Projects::factory()->create([
        'contract_start_date' => '2026-06-01',
        'contract_end_date' => '2026-01-01',
    ]))->toThrow(\Illuminate\Database\QueryException::class);
})->skip('Aktifkan setelah validasi tanggal diterapkan (R10)');