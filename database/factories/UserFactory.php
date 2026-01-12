<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Password statis biar hemat hashing 😄
     */
    protected static ?string $password;

    /**
     * Default state
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('12345678'),
            'role' => 'user', // default
            'remember_token' => Str::random(10),

            // Fortify / Jetstream safe
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ];
    }

    /**
     * Email belum diverifikasi
     */
    public function unverified(): static
    {
        return $this->state(fn() => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Role states 🌱
     */
    public function admin(): static
    {
        return $this->state(fn() => [
            'role' => 'admin',
        ]);
    }

    public function logistik(): static
    {
        return $this->state(fn() => [
            'role' => 'logistik',
        ]);
    }

    public function akuntansi(): static
    {
        return $this->state(fn() => [
            'role' => 'akuntansi',
        ]);
    }

    public function konstruksi(): static
    {
        return $this->state(fn() => [
            'role' => 'konstruksi',
        ]);
    }

    /**
     * Two Factor Auth
     */
    public function withTwoFactor(): static
    {
        return $this->state(fn() => [
            'two_factor_secret' => encrypt('secret'),
            'two_factor_recovery_codes' => encrypt(json_encode(['recovery-code-1'])),
            'two_factor_confirmed_at' => now(),
        ]);
    }
}
