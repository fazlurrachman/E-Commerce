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
        Schema::table('transactions_details', function (Blueprint $table) {
            $table->string('shipping_status'); //--PENDING--SUKSES--SHIPPING-
            $table->string('resi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions_details', function (Blueprint $table) {
            $table->dropColumn('shipping_status');
            $table->dropColumn('resi');
        });
    }
};
