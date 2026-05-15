<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {

            $table->id('idOrderItem');

            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');

            $table->integer('quantity');
            $table->decimal('price', 10, 2);

            $table->timestamps();

            $table->foreign('order_id')
                  ->references('idOrder')
                  ->on('orders')
                  ->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('idProduct')
                  ->on('products')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
