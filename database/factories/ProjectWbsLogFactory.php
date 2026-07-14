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