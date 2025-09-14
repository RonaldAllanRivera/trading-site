<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Lead;

class LeadSeeder extends Seeder
{
    public function run(): void
    {
        $default = app()->environment('production') ? 5 : 15;
        $count = (int) env('LEAD_COUNT', $default);
        Lead::factory()->count(max(0, $count))->create();
    }
}
