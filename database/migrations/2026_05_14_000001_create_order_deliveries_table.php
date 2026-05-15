<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('delivery_id');
            $table->enum('status', ['pending', 'picked_up', 'in_transit', 'delivered', 'failed'])->default('pending');
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('idOrder')->on('orders')->onDelete('cascade');
            $table->foreign('delivery_id')->references('idDelivery')->on('deliveries')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_deliveries');
    }
};
