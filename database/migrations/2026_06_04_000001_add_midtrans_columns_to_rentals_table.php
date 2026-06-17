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
        Schema::table('rentals', function (Blueprint $table) {
            // Kolom untuk Midtrans
            $table->string('order_id')->nullable()->unique()->after('payment_method');
            $table->string('snap_token')->nullable()->after('order_id');
            $table->bigInteger('total_price')->default(0)->after('snap_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['order_id', 'snap_token', 'total_price']);
        });
    }
};
