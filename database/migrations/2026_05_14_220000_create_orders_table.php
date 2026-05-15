<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('idOrder');

            $table->unsignedBigInteger('user_id');

            $table->string('order_number')->unique();
            $table->decimal('total_amount', 10, 2)->default(0);

            $table->string('status')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();

            $table->text('shipping_address')->nullable();
            $table->text('billing_address')->nullable();

            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
