<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Check if the column doesn't exist yet before adding it
        if (!Schema::hasColumn('rpcppe', 'receive_from')) {
            Schema::table('rpcppe', function (Blueprint $table) {
                $table->string('receive_from')->nullable()->after('accountable_person');
            });
        }
    }

    public function down()
    {
        Schema::table('rpcppe', function (Blueprint $table) {
            $table->dropColumn('receive_from');
        });
    }
};