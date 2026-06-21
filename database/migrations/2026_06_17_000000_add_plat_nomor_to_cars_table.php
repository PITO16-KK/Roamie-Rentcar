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
        if (!Schema::hasColumn('cars', 'plat_nomor')) {
            Schema::table('cars', function (Blueprint $table) {
                $table->string('plat_nomor')->nullable()->after('name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('cars', 'plat_nomor')) {
            Schema::table('cars', function (Blueprint $table) {
                $table->dropColumn('plat_nomor');
            });
        }
    }
};
