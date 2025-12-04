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
            // Drop columns if they both exist
            if (Schema::hasColumn('rpcppes', 'acc_code_new')) {
                $table->dropColumn('acc_code_new');
            }
            if (Schema::hasColumn('rpcppes', 'acc_code_old')) {
                $table->dropColumn('acc_code_old');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rpcppes', function (Blueprint $table) {
            // Add columns back if they don't exist
            if (!Schema::hasColumn('rpcppes', 'acc_code_new')) {
                $table->string('acc_code_new')->nullable()->after('id');
            }
            if (!Schema::hasColumn('rpcppes', 'acc_code_old')) {
                $table->string('acc_code_old')->nullable()->after('id');
            }
        });
    }
};
