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
        Schema::table('cars', function (Blueprint $table) {
            if (!Schema::hasColumn('cars', 'image')) {
                $table->string('image')->nullable()->after('status');
            }
            if (!Schema::hasColumn('cars', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('cars', 'gearbox')) {
                $table->string('gearbox')->nullable();
            }
            if (!Schema::hasColumn('cars', 'seats')) {
                $table->integer('seats')->nullable();
            }
            if (!Schema::hasColumn('cars', 'engine')) {
                $table->string('engine')->nullable();
            }
            if (!Schema::hasColumn('cars', 'year')) {
                $table->year('year')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['image', 'description', 'gearbox', 'seats', 'engine', 'year']);
        });
    }
};
?>
