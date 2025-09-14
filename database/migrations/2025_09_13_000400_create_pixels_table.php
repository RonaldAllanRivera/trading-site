<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pixels')) {
            return;
        }

        Schema::create('pixels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('provider', 64)->index(); // facebook, google_tag, tiktok, custom, etc
            $table->text('code'); // raw script/snippet
            $table->string('location', 32)->default('head')->index(); // head, body_start, body_end
            $table->string('status', 16)->default('active')->index(); // active, paused
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pixels');
    }
};
