<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectDocumentsFactory extends Factory
{
  protected $model = \App\Models\ProjectDocuments::class;
  public function definition(): array
  {
    return [
      'project_id' => \App\Models\Projects::factory(),
      'document_type' => fake()->randomElement(['BASTP', 'KALKIR', 'TUG9', 'TUG10', 'LAINNYA']),
      'original_filename' => fake()->word() . '.pdf',
      'file_path' => fake()->filePath(),
    ];
  }
}
