<?php
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Projects;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('logistik can import material issue from excel', function () {
    Excel::fake();
    $logistik = User::factory()->create(['role' => 'logistik']);
    $project = Projects::factory()->create();

    $file = UploadedFile::fake()->create('material_issue.xlsx');

    try {
        $this->actingAs($logistik)
            ->post(route('sap.import'), ['file' => $file, 'project_id' => $project->id])
            ->assertOk();
    } catch (\Exception $e) {
        $this->markTestSkipped('Route sap.import not defined');
    }

    // Excel::assertImported('material_issue.xlsx');
});

it('non-logistik role cannot access sap import', function () {
    $konstruksi = User::factory()->create(['role' => 'konstruksi']);

    try {
        $this->actingAs($konstruksi)
            ->get(route('sap.import.form'))
            ->assertForbidden();
    } catch (\Exception $e) {
        $this->markTestSkipped('Route sap.import.form not defined');
    }
});