<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promises', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('project_title')->nullable();
            $table->string('email')->nullable();
            $table->longText('generated_promise')->nullable();
            $table->timestamp('sealed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promises');
    }
};
