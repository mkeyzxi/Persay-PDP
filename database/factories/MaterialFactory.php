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
            'material_description' => fake()->words(3, true),
            'category' => fake()->randomElement(['MDU', 'NON-MDU', 'JASA']),
            'uom' => 'PC',
        ];
    }
}