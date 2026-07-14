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

  expect(fn() => $item->material->delete())
    ->toThrow(\Illuminate\Database\QueryException::class);
});
