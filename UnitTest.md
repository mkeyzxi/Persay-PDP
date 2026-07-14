# Rencana & Panduan Unit Testing — PRISAY-PDP

Dokumen ini adalah panduan pengujian untuk sistem **PRISAY-PDP** (Laravel 12 + Livewire Volt/Flux), disusun berdasarkan struktur database dan alur bisnis yang sudah didokumentasikan di `DOKUMENTASI_DATABASE.txt`, `DOKUMENTASI_SISTEM.txt`, dan `REKAP-DASHBOARD-DOCS.md`.

Framework testing yang direkomendasikan: **Pest** (default Laravel 12 skeleton), dengan alternatif sintaks PHPUnit di beberapa contoh.

---

## 1. Setup Environment Testing

### 1.1 Install Pest (jika belum ada)

```bash
composer require pestphp/pest --dev --with-all-dependencies
composer require pestphp/pest-plugin-laravel --dev
php artisan pest:install
```

### 1.2 Konfigurasi Database Testing

Gunakan SQLite in-memory agar test cepat dan tidak menyentuh database development.

`.env.testing`:

```env
APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

`phpunit.xml` (pastikan baris berikut ada / tidak dikomentari):

```xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
</php>
```

### 1.3 Trait Wajib

Setiap test yang menyentuh database harus pakai `RefreshDatabase`:

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
```

---

## 2. Struktur Folder Test

```
tests/
├── Unit/
│   ├── Models/
│   │   ├── ProjectTest.php
│   │   ├── MaterialTest.php
│   │   ├── MaterialIssueTest.php
│   │   ├── MaterialIssuesItemTest.php
│   │   └── UserTest.php
│   └── Services/
│       └── RekapDashboardCalculationTest.php
└── Feature/
    ├── Auth/
    │   └── RoleAccessTest.php
    ├── Project/
    │   ├── ProjectCreationTest.php
    │   ├── ProjectClosingTest.php
    │   └── ProjectWbsLogTest.php
    ├── SapImport/
    │   └── MaterialIssueImportTest.php
    ├── MyTakeList/
    │   ├── KonstruksiInputTest.php
    │   └── AkuntansiAssetNumberTest.php
    └── Dashboard/
        └── RekapDashboardTest.php
```

---

## 3. Factory yang Dibutuhkan

Pastikan setiap model punya factory (`php artisan make:factory <Nama>Factory`).

| Model                       | Field penting yang wajib di-factory                                                                                            |
| --------------------------- | ------------------------------------------------------------------------------------------------------------------------------ |
| `UserFactory`               | `role` (admin/logistik/konstruksi/akuntansi), `status`                                                                         |
| `ProjectFactory`            | `spk_number` (unique), `fiscal_year`, `status` (default DRAFT), `contract_start_date`                                          |
| `MaterialFactory`           | `sap_material_code` (unique), `category` (MDU/NON-MDU/JASA)                                                                    |
| `MaterialIssueFactory`      | `project_id`, `sap_doc_no`, `posting_date`                                                                                     |
| `MaterialIssuesItemFactory` | `material_issue_id`, `material_id`, `quantity_sap`, `quantity_installed` (nullable), `val_currency`, `asset_number` (nullable) |
| `ProjectDocumentFactory`    | `project_id`, `document_type`                                                                                                  |
| `ProjectWbsLogFactory`      | `project_id`, `wbs_number`, `set_by`                                                                                           |

Contoh `ProjectFactory`:

```php
public function definition(): array
{
    return [
        'spk_number' => 'SPK-' . fake()->unique()->numerify('####/####'),
        'wbs_number' => fake()->bothify('WBS-####'),
        'project_name' => fake()->sentence(3),
        'vendor_name' => fake()->company(),
        'fiscal_year' => now()->year,
        'contract_value' => fake()->randomFloat(2, 10_000_000, 500_000_000),
        'contract_start_date' => fake()->dateTimeBetween('-3 years', 'now'),
        'proggress_percent' => fake()->numberBetween(0, 100),
        'status' => 'OPEN',
        'created_by' => User::factory(),
    ];
}
```

---

## 4. Unit Test — Model & Relasi

Uji setiap relasi Eloquent yang tercantum di `DOKUMENTASI_DATABASE.txt` bagian 4.

```php
// tests/Unit/Models/ProjectTest.php
use App\Models\Project;
use App\Models\MaterialIssue;
use App\Models\ProjectDocument;
use App\Models\ProjectWbsLog;
use App\Models\User;

it('project belongs to creator', function () {
    $user = User::factory()->create();
    $project = Project::factory()->for($user, 'creator')->create();

    expect($project->creator)->toBeInstanceOf(User::class);
});

it('project has many material issues', function () {
    $project = Project::factory()
        ->has(MaterialIssue::factory()->count(3), 'materialIssues')
        ->create();

    expect($project->materialIssues)->toHaveCount(3);
});

it('project has many documents', function () {
    $project = Project::factory()
        ->has(ProjectDocument::factory()->count(2), 'documents')
        ->create();

    expect($project->documents)->toHaveCount(2);
});

it('deleting a project cascades to material issues and documents', function () {
    $project = Project::factory()
        ->has(MaterialIssue::factory())
        ->has(ProjectDocument::factory())
        ->create();

    $project->delete();

    $this->assertDatabaseCount('material_issues', 0);
    $this->assertDatabaseCount('project_documents', 0);
});
```

```php
// tests/Unit/Models/MaterialIssuesItemTest.php
it('item belongs to material issue and material', function () {
    $item = MaterialIssuesItem::factory()->create();

    expect($item->materialIssue)->not->toBeNull()
        ->and($item->material)->not->toBeNull();
});

it('deleting a material with existing items is restricted', function () {
    $item = MaterialIssuesItem::factory()->create();

    expect(fn () => $item->material->delete())
        ->toThrow(\Illuminate\Database\QueryException::class);
});
```

> ⚠️ Catatan: Model `MaterialIssuesItem` diketahui punya dua method relasi duplikat (`materialIssue()` dan `issue()`, lihat MASALAH #6). Tambahkan test yang menegaskan **keduanya mengembalikan hasil sama** selama refactor belum dilakukan, supaya tidak ada regresi saat salah satunya dihapus.

---

## 5. Unit Test — Logika Bisnis (Rekap Dashboard)

Berdasarkan rumus di `REKAP-DASHBOARD-DOCS.md`, ini bagian paling kritikal untuk diuji karena murni kalkulasi angka.

### 5.1 Nilai SAP (`total_val_sap`)

```php
it('sums val_currency correctly for total_val_sap', function () {
    $issue = MaterialIssue::factory()->create();
    MaterialIssuesItem::factory()->for($issue, 'materialIssue')->create(['val_currency' => 1_000_000]);
    MaterialIssuesItem::factory()->for($issue, 'materialIssue')->create(['val_currency' => 2_500_000]);

    $total = MaterialIssuesItem::whereHas(
        'materialIssue', fn ($q) => $q->where('id', $issue->id)
    )->sum('val_currency');

    expect($total)->toBe(3_500_000.0);
});
```

### 5.2 Total Selisih

```php
it('calculates selisih as quantity_sap minus quantity_installed', function () {
    $item = MaterialIssuesItem::factory()->create([
        'quantity_sap' => 100,
        'quantity_installed' => 60,
    ]);

    expect($item->quantity_sap - $item->quantity_installed)->toBe(40.0);
});

it('treats null quantity_installed as zero when computing selisih', function () {
    $item = MaterialIssuesItem::factory()->create([
        'quantity_sap' => 50,
        'quantity_installed' => null,
    ]);

    $selisih = $item->quantity_sap - ($item->quantity_installed ?? 0);

    expect($selisih)->toBe(50.0);
});

it('selisih zero is treated as fully installed (hijau)', function () {
    $item = MaterialIssuesItem::factory()->create([
        'quantity_sap' => 30,
        'quantity_installed' => 30,
    ]);

    expect($item->quantity_sap - $item->quantity_installed)->toBe(0.0);
});
```

### 5.3 Klaster Umur Project

Uji setiap batas klaster (edge case tanggal sangat penting di sini):

```php
dataset('umur_klaster', [
    'kurang dari 1 tahun' => [now()->subMonths(6), '< 1 Tahun'],
    'tepat 1 tahun'       => [now()->subYear(), '1 Tahun'],
    'tepat 2 tahun'       => [now()->subYears(2), '2 Tahun'],
    'tepat 3 tahun'       => [now()->subYears(3), '3 Tahun'],
    'tepat 4 tahun'       => [now()->subYears(4), '4 Tahun'],
    'lebih dari 5 tahun'  => [now()->subYears(6), '5+ Tahun'],
]);

it('mengelompokkan umur project ke klaster yang benar', function (\Carbon\Carbon $startDate, string $expectedCluster) {
    $project = Project::factory()->create(['contract_start_date' => $startDate]);

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
```

### 5.4 Filter Tahun & Bulan

```php
it('filters rekap dashboard data by posting_date year and month', function () {
    $issueJan = MaterialIssue::factory()->create(['posting_date' => '2026-01-15']);
    $issueFeb = MaterialIssue::factory()->create(['posting_date' => '2026-02-15']);

    MaterialIssuesItem::factory()->for($issueJan, 'materialIssue')->create(['val_currency' => 100]);
    MaterialIssuesItem::factory()->for($issueFeb, 'materialIssue')->create(['val_currency' => 200]);

    $totalJan = MaterialIssuesItem::whereHas(
        'materialIssue',
        fn ($q) => $q->whereYear('posting_date', 2026)->whereMonth('posting_date', 1)
    )->sum('val_currency');

    expect($totalJan)->toBe(100.0);
});
```

---

## 6. Feature Test — Alur Bisnis Utama

### 6.1 Penutupan Proyek (Closing) — Validasi Kelengkapan Asset Number

Ini fitur paling kritis (Tahap 5–6 di alur kerja), wajib punya test negatif dan positif.

```php
it('cannot close project when there are items without asset_number', function () {
    $akuntansi = User::factory()->create(['role' => 'akuntansi']);
    $project = Project::factory()->create(['status' => 'OPEN']);
    $issue = MaterialIssue::factory()->for($project)->create();
    MaterialIssuesItem::factory()->for($issue, 'materialIssue')->create(['asset_number' => null]);

    $response = $this->actingAs($akuntansi)
        ->post(route('projects.close', $project));

    $response->assertSessionHasErrors();
    expect($project->fresh()->status)->toBe('OPEN');
});

it('can close project when all items have asset_number', function () {
    $akuntansi = User::factory()->create(['role' => 'akuntansi']);
    $project = Project::factory()->create(['status' => 'OPEN']);
    $issue = MaterialIssue::factory()->for($project)->create();
    MaterialIssuesItem::factory()->for($issue, 'materialIssue')->create(['asset_number' => 'AST-001']);

    $response = $this->actingAs($akuntansi)
        ->post(route('projects.close', $project));

    expect($project->fresh()->status)->toBe('CLOSED');
});

it('non-akuntansi role cannot close a project', function () {
    $konstruksi = User::factory()->create(['role' => 'konstruksi']);
    $project = Project::factory()->create(['status' => 'OPEN']);

    $this->actingAs($konstruksi)
        ->post(route('projects.close', $project))
        ->assertForbidden();
});
```

> Sesuaikan nama route/method dengan implementasi aktual di controller/Livewire component-mu.

### 6.2 Upload Data SAP (Excel Import)

```php
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

it('logistik can import material issue from excel', function () {
    Excel::fake();
    $logistik = User::factory()->create(['role' => 'logistik']);
    $project = Project::factory()->create();

    $file = UploadedFile::fake()->create('material_issue.xlsx');

    $this->actingAs($logistik)
        ->post(route('sap.import'), ['file' => $file, 'project_id' => $project->id])
        ->assertOk();

    Excel::assertImported('material_issue.xlsx');
});

it('non-logistik role cannot access sap import', function () {
    $konstruksi = User::factory()->create(['role' => 'konstruksi']);

    $this->actingAs($konstruksi)
        ->get(route('sap.import.form'))
        ->assertForbidden();
});
```

### 6.3 My Take List — Konstruksi (input fisik terpasang)

```php
it('konstruksi can update quantity_installed', function () {
    $konstruksi = User::factory()->create(['role' => 'konstruksi']);
    $item = MaterialIssuesItem::factory()->create(['quantity_installed' => null]);

    $this->actingAs($konstruksi)
        ->put(route('material-issues-items.update', $item), [
            'quantity_installed' => 25,
        ])
        ->assertOk();

    expect($item->fresh()->quantity_installed)->toBe(25.0);
});

it('quantity_installed cannot exceed quantity_sap', function () {
    $konstruksi = User::factory()->create(['role' => 'konstruksi']);
    $item = MaterialIssuesItem::factory()->create(['quantity_sap' => 10]);

    $this->actingAs($konstruksi)
        ->put(route('material-issues-items.update', $item), [
            'quantity_installed' => 15,
        ])
        ->assertSessionHasErrors('quantity_installed');
});
```

### 6.4 My Take List — Akuntansi (input asset number)

```php
it('akuntansi can set asset_number and asset_number_date', function () {
    $akuntansi = User::factory()->create(['role' => 'akuntansi']);
    $item = MaterialIssuesItem::factory()->create(['asset_number' => null]);

    $this->actingAs($akuntansi)
        ->put(route('material-issues-items.set-asset', $item), [
            'asset_number' => 'AST-2026-001',
        ])
        ->assertOk();

    expect($item->fresh())
        ->asset_number->toBe('AST-2026-001')
        ->asset_number_date->not->toBeNull();
});
```

### 6.5 WBS Log (audit trail)

```php
it('changing wbs_number creates a wbs log entry', function () {
    $user = User::factory()->create(['role' => 'logistik']);
    $project = Project::factory()->create(['wbs_number' => 'WBS-OLD']);

    $this->actingAs($user)
        ->put(route('projects.update-wbs', $project), ['wbs_number' => 'WBS-NEW']);

    $this->assertDatabaseHas('project_wbs_logs', [
        'project_id' => $project->id,
        'wbs_number' => 'WBS-NEW',
        'set_by' => $user->id,
    ]);
});
```

---

## 7. Feature Test — Role-Based Access Control (RBAC)

Buat test matrix per role x menu, karena ini fondasi keamanan seluruh sistem.

```php
dataset('role_access_matrix', [
    ['admin', '/dashboard', 200],
    ['admin', '/users', 200],
    ['logistik', '/users', 403],
    ['logistik', '/sap-import', 200],
    ['konstruksi', '/sap-import', 403],
    ['konstruksi', '/my-take-list/konstruksi', 200],
    ['akuntansi', '/my-take-list/konstruksi', 403],
    ['akuntansi', '/my-take-list/akuntansi', 200],
]);

it('enforces role-based route access', function (string $role, string $url, int $expectedStatus) {
    $user = User::factory()->create(['role' => $role]);

    $this->actingAs($user)->get($url)->assertStatus($expectedStatus);
})->with('role_access_matrix');
```

---

## 8. Test Regresi untuk Masalah yang Sudah Teridentifikasi

Ambil langsung dari `DOKUMENTASI_DATABASE.txt` bagian 6.2 — tulis test yang **gagal sekarang** (menandakan bug belum diperbaiki) supaya jadi checklist otomatis saat perbaikan dilakukan.

```php
// [R1] Unique constraint project_id + sap_doc_no
it('prevents duplicate sap_doc_no within the same project', function () {
    $project = Project::factory()->create();
    MaterialIssue::factory()->for($project)->create(['sap_doc_no' => 'DOC-001']);

    expect(fn () => MaterialIssue::factory()->for($project)->create(['sap_doc_no' => 'DOC-001']))
        ->toThrow(\Illuminate\Database\QueryException::class);
})->skip('Aktifkan setelah migration unique(project_id, sap_doc_no) diterapkan (R1)');

// [R10] proggress_percent harus 0-100
it('rejects proggress_percent outside 0-100 range', function () {
    expect(fn () => Project::factory()->create(['proggress_percent' => 150]))
        ->toThrow(\Illuminate\Database\QueryException::class);
})->skip('Aktifkan setelah CHECK constraint / validasi 0-100 diterapkan (R10)');

// [R10] contract_end_date >= contract_start_date
it('rejects contract_end_date earlier than contract_start_date', function () {
    expect(fn () => Project::factory()->create([
        'contract_start_date' => '2026-06-01',
        'contract_end_date' => '2026-01-01',
    ]))->toThrow(\Illuminate\Database\QueryException::class);
})->skip('Aktifkan setelah validasi tanggal diterapkan (R10)');
```

> Hapus `->skip(...)` satu per satu begitu perbaikan terkait sudah dikerjakan — ini membuat test suite berfungsi sebagai checklist perbaikan.

---

## 9. Checklist Ringkas

- [ ] Semua relasi Eloquent (`belongsTo`, `hasMany`, cascade delete) punya test
- [ ] Rumus `total_val_sap`, `total_selisih`, dan klaster umur teruji dengan edge case (null, batas klaster)
- [ ] Validasi penutupan proyek (tidak bisa close jika ada `asset_number` kosong)
- [ ] RBAC teruji untuk 4 role: admin, logistik, konstruksi, akuntansi
- [ ] Import Excel SAP teruji (happy path + file invalid)
- [ ] Audit trail `project_wbs_logs` tercatat saat WBS berubah
- [ ] Test regresi untuk 7 masalah di `DOKUMENTASI_DATABASE.txt` bagian 6.2

---

## 10. Menjalankan Test

```bash
# semua test
php artisan test

# hanya unit test
php artisan test --testsuite=Unit

# hanya feature test
php artisan test --testsuite=Feature

# dengan coverage (butuh Xdebug/PCOV)
php artisan test --coverage --min=70

# filter nama test tertentu
php artisan test --filter="closing"
```
