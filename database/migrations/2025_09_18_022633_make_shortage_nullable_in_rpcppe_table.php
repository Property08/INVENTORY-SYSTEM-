<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rpcppe', function (Blueprint $table) {
            $table->integer('shortage_overage_qty')->nullable()->change();
            $table->decimal('shortage_overage_value', 15, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('rpcppe', function (Blueprint $table) {
            $table->integer('shortage_overage_qty')->nullable(false)->change();
            $table->decimal('shortage_overage_value', 15, 2)->nullable(false)->change();
        });
    }
};
