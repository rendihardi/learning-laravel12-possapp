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
        Schema::create('item_pengeluaran_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengeluaran');
            $table->string('name_product');
            $table->integer('qty');
            $table->integer('harga_jual');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_pengeluaran_barangs');
    }
};
