<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
  protected static ?string $password;
  public function definition(): array
  {
    return [
      'name' => fake()->name(),
      'email' => fake()->unique()->safeEmail(),
      'email_verified_at' => now(),
      'password' => static::$password ??= Hash::make('password'),
      'remember_token' => Str::random(10),
      'role' => fake()->randomElement(['admin', 'logistik', 'konstruksi', 'akuntansi']),
      'status' => 'active',
    ];
  }

  public function unverified(): static
  {
    return $this->state(fn (array $attributes) => [
      'email_verified_at' => null,
    ]);
  }

  public function withTwoFactor(): static
  {
    return $this->state(fn (array $attributes) => [
      'two_factor_secret' => 'secret',
      'two_factor_recovery_codes' => 'codes',
      'two_factor_confirmed_at' => now(),
    ]);
  }
}
