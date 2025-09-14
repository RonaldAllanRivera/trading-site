<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pixel;

class PixelSeeder extends Seeder
{
    public function run(): void
    {
        Pixel::factory()->count(5)->create();
    }
}
