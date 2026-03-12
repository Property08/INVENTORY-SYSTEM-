<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('rpcppe', function (Blueprint $table) {
            // Added nullable() just in case some rows are empty in your Excel
            $table->text('article')->nullable()->change();
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('rpcppe', function (Blueprint $table) {
            // This reverts the columns back to standard strings (255 chars)
            $table->string('article')->nullable()->change();
            $table->string('description')->nullable()->change();
        });
    }
};