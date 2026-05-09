<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('idProduct');
            $table->unsignedBigInteger('idCategory');
            $table->string('nameProduct');
            $table->text('descriptionProduct')->nullable();
            $table->decimal('priceProduct', 10, 2);
            $table->integer('quantityProduct')->default(0);
            $table->string('imageProduct')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->foreign('idCategory')->references('idCategory')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
