<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (!Schema::hasColumn('carts', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('idCart');
            }
            if (!Schema::hasColumn('carts', 'session_id')) {
                $table->string('session_id', 255)->nullable()->after('user_id');
            }

            // Optional: indexes (safe)
            if (!Schema::hasColumn('carts', 'user_id')) {
                // no-op
            }
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (Schema::hasColumn('carts', 'user_id')) {
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('carts', 'session_id')) {
                $table->dropColumn('session_id');
            }
        });
    }
};
