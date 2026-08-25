<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rpcppe', function (Blueprint $table) {
            // Adding the missing column as nullable text, placed cleanly after accountable_person
            $table->string('receive_from')->nullable()->after('accountable_person');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rpcppe', function (Blueprint $table) {
            $table->dropColumn('receive_from');
        });
    }
};