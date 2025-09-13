<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 256)->nullable();
            $table->string('last_name', 256)->nullable();
            $table->string('email', 256)->nullable()->index();
            $table->string('country', 256)->nullable();
            $table->string('phone_prefix', 64)->nullable();
            $table->string('phone_number', 64)->nullable();
            $table->text('password_encrypted')->nullable();
            $table->string('status', 32)->default('new')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
