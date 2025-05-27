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
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->string('recipient_name')->after('order_date');
            $table->string('recipient_phone')->after('recipient_name');
            $table->string('recipient_address')->after('recipient_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropColumn('recipient_name');
            $table->dropColumn('recipient_phone');
            $table->dropColumn('recipient_address');
        });
    }
};
