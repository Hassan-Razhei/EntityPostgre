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
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'role' => \App\Enums\UserRole::RESEARCHER->value,
            'is_active' => true,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * تحديد رتبة المستخدم
     */
    public function withRole(\App\Enums\UserRole|string $role): static
    {
        return $this->state(fn () => [
            'role' => $role instanceof \App\Enums\UserRole ? $role->value : $role,
        ]);
    }

    /**
     * مستخدم بحساب مدير عام
     */
    public function superAdmin(): static
    {
        return $this->withRole(\App\Enums\UserRole::SUPER_ADMIN);
    }

    /**
     * مستخدم بحساب مجمد
     */
    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
