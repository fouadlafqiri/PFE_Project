<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id('idDelivery');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('vehicle_type')->nullable(); // bike, car, truck
            $table->string('vehicle_number')->nullable();
            $table->enum('status', ['active', 'inactive', 'on_delivery'])->default('active');
            $table->integer('orders_completed')->default(0);
            $table->decimal('rating', 3, 2)->default(5.0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
