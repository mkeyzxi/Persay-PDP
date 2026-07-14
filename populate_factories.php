<?php
$factories = [
    'UserFactory' => <<<'EOT'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class UserFactory extends Factory
{
    protected static ?string $password;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement(['admin', 'logistik', 'konstruksi', 'akuntansi']),
            'status' => 'active',
        ];
    }
}
EOT,

    'ProjectFactory' => <<<'EOT'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
class ProjectFactory extends Factory
{
    protected $model = \App\Models\Projects::class;
    public function definition(): array
    {
        return [
            'spk_number' => 'SPK-' . fake()->unique()->numerify('####/####'),
            'wbs_number' => fake()->bothify('WBS-####'),
            'project_name' => fake()->sentence(3),
            'vendor_name' => fake()->company(),
            'fiscal_year' => now()->year,
            'contract_value' => fake()->randomFloat(2, 10000000, 500000000),
            'contract_start_date' => fake()->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'contract_end_date' => fake()->dateTimeBetween('now', '+1 years')->format('Y-m-d'),
            'proggress_percent' => fake()->numberBetween(0, 100),
            'status' => 'OPEN',
            'created_by' => User::factory(),
        ];
    }
}
EOT,

    'MaterialFactory' => <<<'EOT'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class MaterialFactory extends Factory
{
    protected $model = \App\Models\Material::class;
    public function definition(): array
    {
        return [
            'sap_material_code' => fake()->unique()->numerify('MAT-####'),
            'description' => fake()->words(3, true),
            'category' => fake()->randomElement(['MDU', 'NON-MDU', 'JASA']),
            'base_uom' => 'PC',
        ];
    }
}
EOT,

    'MaterialIssueFactory' => <<<'EOT'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class MaterialIssueFactory extends Factory
{
    protected $model = \App\Models\MaterialIssues::class;
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Projects::factory(),
            'sap_doc_no' => fake()->unique()->numerify('DOC-######'),
            'posting_date' => fake()->date(),
        ];
    }
}
EOT,

    'MaterialIssuesItemFactory' => <<<'EOT'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class MaterialIssuesItemFactory extends Factory
{
    protected $model = \App\Models\MaterialIssuesItems::class;
    public function definition(): array
    {
        return [
            'material_issue_id' => \App\Models\MaterialIssues::factory(),
            'material_id' => \App\Models\Material::factory(),
            'quantity_sap' => fake()->randomFloat(2, 10, 100),
            'quantity_installed' => null,
            'val_currency' => fake()->randomFloat(2, 10000, 1000000),
            'asset_number' => null,
        ];
    }
}
EOT,

    'ProjectDocumentFactory' => <<<'EOT'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class ProjectDocumentFactory extends Factory
{
    protected $model = \App\Models\ProjectDocuments::class;
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Projects::factory(),
            'document_type' => fake()->randomElement(['BAST', 'INVOICE', 'SPK']),
            'file_path' => fake()->filePath(),
        ];
    }
}
EOT,

    'ProjectWbsLogFactory' => <<<'EOT'
<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class ProjectWbsLogFactory extends Factory
{
    protected $model = \App\Models\ProjectWbsLog::class;
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Projects::factory(),
            'wbs_number' => fake()->bothify('WBS-####'),
            'set_by' => \App\Models\User::factory(),
        ];
    }
}
EOT,
];

foreach ($factories as $name => $content) {
    file_put_contents("c:/Users/muhma/Herd/prisay-pdp/database/factories/{$name}.php", $content);
    echo "Written {$name}.php\n";
}
