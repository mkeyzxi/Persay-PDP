<?php

$files = [
    'tests/Unit/Models/ProjectTest.php' => <<<'EOT'
<?php
use App\Models\Projects;
use App\Models\MaterialIssues;
use App\Models\ProjectDocuments;
use App\Models\ProjectWbsLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('project belongs to creator', function () {
    $user = User::factory()->create();
    $project = Projects::factory()->for($user, 'createdBy')->create();

    expect($project->createdBy)->toBeInstanceOf(User::class);
});

it('project has many material issues', function () {
    $project = Projects::factory()
        ->has(MaterialIssues::factory()->count(3), 'materialIssues')
        ->create();

    expect($project->materialIssues)->toHaveCount(3);
});

it('project has many documents', function () {
    $project = Projects::factory()
        ->has(ProjectDocuments::factory()->count(2), 'documents')
        ->create();

    expect($project->documents)->toHaveCount(2);
});

it('deleting a project cascades to material issues and documents', function () {
    $project = Projects::factory()
        ->has(MaterialIssues::factory(), 'materialIssues')
        ->has(ProjectDocuments::factory(), 'documents')
        ->create();

    $project->delete();

    $this->assertDatabaseCount('material_issues', 0);
    $this->assertDatabaseCount('project_documents', 0);
});
EOT,

    'tests/Unit/Models/MaterialIssuesItemTest.php' => <<<'EOT'
<?php
use App\Models\MaterialIssuesItems;
use App\Models\MaterialIssues;
use App\Models\Material;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('item belongs to material issue and material', function () {
    $item = MaterialIssuesItems::factory()->create();

    expect($item->materialIssue)->not->toBeNull()
        ->and($item->material)->not->toBeNull();
});

it('deleting a material with existing items is restricted', function () {
    $item = MaterialIssuesItems::factory()->create();

    expect(fn () => $item->material->delete())
        ->toThrow(\Illuminate\Database\QueryException::class);
});
EOT,

    'tests/Unit/Services/RekapDashboardCalculationTest.php' => <<<'EOT'
<?php
use App\Models\MaterialIssuesItems;
use App\Models\MaterialIssues;
use App\Models\Projects;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('sums val_currency correctly for total_val_sap', function () {
    $issue = MaterialIssues::factory()->create();
    MaterialIssuesItems::factory()->for($issue, 'materialIssue')->create(['val_currency' => 1000000]);
    MaterialIssuesItems::factory()->for($issue, 'materialIssue')->create(['val_currency' => 2500000]);

    $total = MaterialIssuesItems::whereHas(
        'materialIssue', fn ($q) => $q->where('id', $issue->id)
    )->sum('val_currency');

    expect($total)->toBe(3500000.0);
});

it('calculates selisih as quantity_sap minus quantity_installed', function () {
    $item = MaterialIssuesItems::factory()->create([
        'quantity_sap' => 100,
        'quantity_installed' => 60,
    ]);

    expect($item->quantity_sap - $item->quantity_installed)->toBe(40.0);
});

it('treats null quantity_installed as zero when computing selisih', function () {
    $item = MaterialIssuesItems::factory()->create([
        'quantity_sap' => 50,
        'quantity_installed' => null,
    ]);

    $selisih = $item->quantity_sap - ($item->quantity_installed ?? 0);

    expect($selisih)->toBe(50.0);
});

it('selisih zero is treated as fully installed (hijau)', function () {
    $item = MaterialIssuesItems::factory()->create([
        'quantity_sap' => 30,
        'quantity_installed' => 30,
    ]);

    expect($item->quantity_sap - $item->quantity_installed)->toBe(0.0);
});

dataset('umur_klaster', [
    'kurang dari 1 tahun' => [\Carbon\Carbon::now()->subMonths(6), '< 1 Tahun'],
    'tepat 1 tahun'       => [\Carbon\Carbon::now()->subYear(), '1 Tahun'],
    'tepat 2 tahun'       => [\Carbon\Carbon::now()->subYears(2), '2 Tahun'],
    'tepat 3 tahun'       => [\Carbon\Carbon::now()->subYears(3), '3 Tahun'],
    'tepat 4 tahun'       => [\Carbon\Carbon::now()->subYears(4), '4 Tahun'],
    'lebih dari 5 tahun'  => [\Carbon\Carbon::now()->subYears(6), '5+ Tahun'],
]);

it('mengelompokkan umur project ke klaster yang benar', function (\Carbon\Carbon $startDate, string $expectedCluster) {
    $project = Projects::factory()->create(['contract_start_date' => $startDate]);

    $umurTahun = $project->contract_start_date->diffInYears(now());
    $cluster = match (true) {
        $umurTahun < 1 => '< 1 Tahun',
        $umurTahun < 2 => '1 Tahun',
        $umurTahun < 3 => '2 Tahun',
        $umurTahun < 4 => '3 Tahun',
        $umurTahun < 5 => '4 Tahun',
        default => '5+ Tahun',
    };

    expect($cluster)->toBe($expectedCluster);
})->with('umur_klaster');

it('filters rekap dashboard data by posting_date year and month', function () {
    $issueJan = MaterialIssues::factory()->create(['posting_date' => '2026-01-15']);
    $issueFeb = MaterialIssues::factory()->create(['posting_date' => '2026-02-15']);

    MaterialIssuesItems::factory()->for($issueJan, 'materialIssue')->create(['val_currency' => 100]);
    MaterialIssuesItems::factory()->for($issueFeb, 'materialIssue')->create(['val_currency' => 200]);

    $totalJan = MaterialIssuesItems::whereHas(
        'materialIssue',
        fn ($q) => $q->whereYear('posting_date', 2026)->whereMonth('posting_date', 1)
    )->sum('val_currency');

    expect($totalJan)->toBe(100.0);
});
EOT,
];

foreach($files as $file => $content) {
    $dir = dirname("c:/Users/muhma/Herd/prisay-pdp/" . $file);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    file_put_contents("c:/Users/muhma/Herd/prisay-pdp/" . $file, $content);
    echo "Created $file\n";
}
