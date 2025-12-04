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
        Schema::table('rpcppes', function (Blueprint $table) {
            if (Schema::hasColumn('rpcppes', 'rpcppe_id')) {
                $table->dropColumn('rpcppe_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rpcppes', function (Blueprint $table) {
            if (!Schema::hasColumn('rpcppes', 'rpcppe_id')) {
                $table->unsignedBigInteger('rpcppe_id')->nullable()->after('id');
            }
        });
    }
};
