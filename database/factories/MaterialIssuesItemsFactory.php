<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class MaterialIssuesItemsFactory extends Factory
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