<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloakRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',        // active | paused
        'mode',          // whitelist | blacklist
        'match_type',    // ip | country | ua | referrer | param
        'pattern',       // newline or comma-separated patterns
        'safe_url',
        'offer_url',
        'notes',
        'hits_safe',
        'hits_offer',
    ];
}
