<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promises', function (Blueprint $table) {
            $table->timestamp('remind_at')->nullable()->after('sealed_at');
        });
    }

    public function down(): void
    {
        Schema::table('promises', function (Blueprint $table) {
            $table->dropColumn('remind_at');
        });
    }
};
