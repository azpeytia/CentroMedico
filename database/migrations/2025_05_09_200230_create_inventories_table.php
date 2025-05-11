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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('shift_id');
            $table->date('date');
            $table->integer('opening_stock')->default(0);
            $table->integer('sold_stock')->default(0);
            $table->integer('closing_stock')->default(0);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
