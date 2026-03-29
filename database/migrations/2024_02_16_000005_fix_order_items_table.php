<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First, check if the table exists and add foreign key if needed
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                // Only add foreign key if it doesn't exist
                // This will be added after orders table is created
                if (!Schema::hasColumn('order_items', 'order_id')) {
                    $table->unsignedBigInteger('order_id')->after('idOrderItem');
                }
            });

            // Add foreign key constraint
            Schema::table('order_items', function (Blueprint $table) {
                $table->foreign('order_id')->references('idOrder')->on('orders')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropForeign(['order_id']);
            });
        }
    }
};
