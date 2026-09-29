<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disposables', function (Blueprint $table) {
            if (!Schema::hasColumn('disposables', 'scanned_photo')) {
                $table->string('scanned_photo')->nullable()->after('WMR_num');
            }
            if (!Schema::hasColumn('disposables', 'place')) {
                $table->string('place')->nullable()->after('description');
            }
            if (!Schema::hasColumn('disposables', 'rpcppe_id')) {
                $table->unsignedBigInteger('rpcppe_id')->nullable()->after('id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('disposables', function (Blueprint $table) {
            $table->dropColumn(['scanned_photo', 'place', 'rpcppe_id']);
        });
    }
};
