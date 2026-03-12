<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpeRecapsTable extends Migration
{
    public function up()
    {
        Schema::create('ppe_recaps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('record_id');
            $table->string('acct_code_new')->nullable();
            $table->string('acct_code_old')->nullable();
            $table->string('classification')->nullable();
            $table->integer('year');
            $table->decimal('beginning_balance', 18, 2)->default(0);
            $table->decimal('purchases', 18, 2)->default(0);
            $table->decimal('reclass_from', 18, 2)->default(0);
            $table->decimal('reclass_to', 18, 2)->default(0);
            $table->decimal('disposed', 18, 2)->default(0);
            $table->decimal('donated', 18, 2)->default(0);
            $table->decimal('adjustments', 18, 2)->default(0);
            $table->timestamps();

            $table->foreign('record_id')->references('id')->on('records')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ppe_recaps');
    }
}