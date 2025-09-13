<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;

/**
 * @extends Factory<\App\Models\Lead>
 */
class LeadFactory extends Factory
{
    protected $model = Lead::class;

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
