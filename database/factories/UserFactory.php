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
     */
    protected static ?string $password;
    /**
     *
     * @var string
     */
    public function definition(): array
    {
        return [
            'nick' => $this->faker->unique()->userName(),
            'pass' => Hash::make(static::$password ??= Str::random(8)),
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'departamento' => $this->faker->word(),
        ];
    }
    /**
     *
     * @return static
     */
    public function hashedPassword(): static
    {
        return $this->state(fn (array $attributes) => [
            'pass' => Hash::make($attributes['pass']),
        ]);
    }
}
