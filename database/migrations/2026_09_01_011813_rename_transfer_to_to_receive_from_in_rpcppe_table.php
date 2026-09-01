<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rpcppe', function (Blueprint $table) {
            // Kung umiiral pa ang 'transfer_to', palitan ito para maging 'receive_from'
            if (Schema::hasColumn('rpcppe', 'transfer_to') && !Schema::hasColumn('rpcppe', 'receive_from')) {
                $table->renameColumn('transfer_to', 'receive_from');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rpcppe', function (Blueprint $table) {
            if (Schema::hasColumn('rpcppe', 'receive_from')) {
                $table->renameColumn('receive_from', 'transfer_to');
            }
        });
    }
};