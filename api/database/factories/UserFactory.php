<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'google_id' => (string) fake()->unique()->uuid(),
            'google_access_token' => fake()->sha256(),
            'google_refresh_token' => fake()->sha256(),
            'google_token_expires_at' => now()->addHour(),
            'email' => fake()->unique()->uuid().'@example.com',
            'email_verified_at' => now(),
            'name' => fake()->name(),
            'cpf' => fake()->unique()->numerify('###########'),
            'birth_date' => fake()->date('Y-m-d', '-18 years'),
        ];
    }
}
