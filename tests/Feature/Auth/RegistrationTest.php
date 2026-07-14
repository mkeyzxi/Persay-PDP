<?php

test('registration screen can be rendered', function () {
  /** @var \Tests\TestCase $this */
  /** @var \App\Models\User $user */
  $user = \App\Models\User::factory()->create(['role' => 'admin']);
  $response = $this->actingAs($user)->get(route('register'));

  if ($response->status() === 302) {
      dump($response->headers->get('Location'));
  }
  $response->assertStatus(200);
});

test('new users can register', function () {
  /** @var \Tests\TestCase $this */
  /** @var \App\Models\User $user */
  $user = \App\Models\User::factory()->create(['role' => 'admin']);
  $response = $this->actingAs($user)->post(route('register.store'), [
    'name' => 'John Doe',
    'email' => 'test@example.com',
    'password' => 'password',
    'password_confirmation' => 'password',
    'role' => 'logistik',
  ]);

  if ($response->status() === 302) {
      dump('Redirecting to: ' . $response->headers->get('Location'));
  }

  $response->assertSessionHasNoErrors()
    ->assertRedirect(route('dashboard', absolute: false));

  $this->assertAuthenticated();
});
