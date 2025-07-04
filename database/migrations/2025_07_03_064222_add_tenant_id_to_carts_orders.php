<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('carts', function (Blueprint $table) {
        $table->string('tenant_id')->index()->nullable();
    });
    Schema::table('orders', function (Blueprint $table) {
        $table->string('tenant_id')->index()->nullable();
    });
    Schema::table('order_items', function (Blueprint $table) {
        $table->string('tenant_id')->index()->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            //
        });
    }
};
