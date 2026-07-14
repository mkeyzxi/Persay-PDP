<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
class MaterialIssuesFactory extends Factory
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