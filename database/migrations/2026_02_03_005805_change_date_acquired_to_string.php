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
        // Gawing string para tanggapin ang kahit anong text format
        $table->string('date_acquired')->nullable()->change();
    });
}

public function down()
{
    Schema::table('rpcppe', function (Blueprint $table) {
        // Ibalik sa date format kung i-rollback
        $table->date('date_acquired')->nullable()->change();
    });
}
};
