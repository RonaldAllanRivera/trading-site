<?php

namespace Database\Factories;

use App\Models\Pixel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Pixel>
 */
class PixelFactory extends Factory
{
    protected $model = Pixel::class;

    public function definition(): array
    {
        $provider = $this->faker->randomElement(['facebook', 'google_tag', 'tiktok', 'custom']);
        $location = $this->faker->randomElement(['head', 'body_start', 'body_end']);
        $status = $this->faker->randomElement(['active', 'paused']);

        // Very simple mock snippets for demo purposes
        $snippets = [
            'facebook' => "<!-- Facebook Pixel -->\n<script>console.log('FB Pixel fired');</script>",
            'google_tag' => "<!-- Google Tag -->\n<script>console.log('GTag fired');</script>",
            'tiktok' => "<!-- TikTok Pixel -->\n<script>console.log('TikTok Pixel fired');</script>",
            'custom' => "<!-- Custom Pixel -->\n<script>console.log('Custom Pixel');</script>",
        ];

        return [
            'name' => ucfirst($provider) . ' Pixel',
            'provider' => $provider,
            'code' => $snippets[$provider],
            'location' => $location,
            'status' => $status,
            'notes' => $this->faker->boolean(50) ? $this->faker->sentence() : null,
        ];
    }
}
