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
  /** @var \Tests\TestCase $this */
  $project = Projects::factory()
    ->has(MaterialIssues::factory(), 'materialIssues')
    ->has(ProjectDocuments::factory(), 'documents')
    ->create();

  $project->delete();

  $this->assertDatabaseCount('material_issues', 0);
  $this->assertDatabaseCount('project_documents', 0);
});
