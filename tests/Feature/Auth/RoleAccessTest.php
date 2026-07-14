<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

dataset('role_access_matrix', [
  ['admin', '/dashboard', 200],
  ['admin', '/admin/management-users', 200],
  ['logistik', '/admin/management-users', 404],
  ['logistik', '/logistik/upload-sap', 200],
  ['konstruksi', '/logistik/upload-sap', 403],
  ['konstruksi', '/konstruksi/my-take-list', 200],
  ['akuntansi', '/konstruksi/my-take-list', 403],
  ['akuntansi', '/akuntansi/my-take-list', 200],
]);

it('enforces role-based route access', function (string $role, string $url, int $expectedStatus) {
  /** @var \Tests\TestCase $this */
  /** @var \App\Models\User $user */
  $user = User::factory()->create(['role' => $role]);

  $this->actingAs($user)->get($url)->assertStatus($expectedStatus);
})->with('role_access_matrix');
