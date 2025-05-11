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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('description');
            $table->string('presentation');
            $table->integer('stock');
            $table->integer('max_stock');
            $table->integer('min_stock');
            $table->decimal('price', 8, 2);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_suspended')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
