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
    Schema::create('disposables', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->integer('quantity')->default(0);
        $table->string('property_number');
        $table->text('description')->nullable();
        $table->date('DateAcquired')->nullable();
        $table->string('WMR_num');  
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposables');
    }
};