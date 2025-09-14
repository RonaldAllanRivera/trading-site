<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cloak_rules')) {
            return;
        }

        Schema::create('cloak_rules', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('status', 16)->default('active')->index(); // active, paused
            $table->string('mode', 16)->default('whitelist')->index(); // whitelist, blacklist
            $table->string('match_type', 16)->default('ip')->index(); // ip, country, ua, referrer, param
            $table->text('pattern'); // comma or newline separated patterns
            $table->string('safe_url', 1024)->nullable();
            $table->string('offer_url', 1024)->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('hits_safe')->default(0);
            $table->unsignedBigInteger('hits_offer')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cloak_rules');
    }
};
