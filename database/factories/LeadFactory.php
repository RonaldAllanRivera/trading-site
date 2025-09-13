<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function configure(): static
    {
        return $this->afterCreating(function (Lead $lead) {
            $name = trim(($lead->first_name ?? '') . ' ' . ($lead->last_name ?? '')) ?: $lead->email;
            User::firstOrCreate(
                ['email' => $lead->email],
                [
                    'name' => $name,
                    'password' => 'password', // will be hashed by User model cast
                    'is_admin' => false,
                ]
            );
        });
    }

    public function definition(): array
    {
        $first = $this->faker->firstName();
        $last = $this->faker->lastName();
        $email = $this->faker->unique()->safeEmail();
        $countries = ['United States', 'United Kingdom', 'Canada', 'Australia', 'Germany', 'France', 'Spain', 'Italy', 'Netherlands', 'Singapore'];
        $prefixes = ['+1', '+44', '+61', '+49', '+33', '+34', '+39', '+31', '+65'];

        return [
            'first_name' => $first,
            'last_name' => $last,
            'email' => $email,
            'country' => $this->faker->randomElement($countries),
            'phone_prefix' => $this->faker->randomElement($prefixes),
            'phone_number' => $this->faker->numerify('###-###-####'),
            'password_encrypted' => Crypt::encryptString('password'),
            'status' => $this->faker->randomElement(['new', 'contacted', 'converted']),
        ];
    }
}
