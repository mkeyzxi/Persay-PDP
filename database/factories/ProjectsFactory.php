<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
class ProjectsFactory extends Factory
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