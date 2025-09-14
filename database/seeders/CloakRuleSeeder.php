<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CloakRule;

class CloakRuleSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Bots to SAFE: blacklist Google reviewers by UA (rename old record if present)
        CloakRule::where('name', 'Whitelist Google Reviewers')->update(['name' => 'Blacklist Google Reviewers']);
        CloakRule::updateOrCreate(
            ['name' => 'Blacklist Google Reviewers'],
            [
                'status' => 'active',
                'mode' => 'blacklist',
                'match_type' => 'ua',
                'pattern' => "Googlebot\nAdsBot-Google",
                'safe_url' => url('/safe'),
                'offer_url' => url('/'),
                'notes' => 'Send Google review bots to safe page; real users go to offer.',
                'hits_safe' => 0,
                'hits_offer' => 0,
            ]
        );

        // 2) Blacklist: block FB review UAs (send them to SAFE)
        CloakRule::updateOrCreate(
            ['name' => 'Blacklist Facebook Reviewers'],
            [
                'status' => 'active',
                'mode' => 'blacklist',
                'match_type' => 'ua',
                'pattern' => "facebookexternalhit\nFacebot",
                'safe_url' => url('/safe'),
                'offer_url' => url('/'),
                'notes' => 'Send FB reviewers to safe page; real users see offer.',
                'hits_safe' => 0,
                'hits_offer' => 0,
            ]
        );

        // 3) Country-based whitelist: allow SG and US to offer, others to safe
        CloakRule::updateOrCreate(
            ['name' => 'Whitelist Countries SG/US'],
            [
                'status' => 'active',
                'mode' => 'whitelist',
                'match_type' => 'country',
                'pattern' => "SG\nUS",
                'safe_url' => url('/safe'),
                'offer_url' => url('/'),
                'notes' => 'Allowed countries go to offer; others are shown safe content.',
                'hits_safe' => 0,
                'hits_offer' => 0,
            ]
        );
    }
}
