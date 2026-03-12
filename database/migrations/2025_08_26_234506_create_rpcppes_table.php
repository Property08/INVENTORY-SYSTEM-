<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rpcppe', function (Blueprint $table) {
            $table->id();
          //  $table->string('rpcppe_id')->unique(); // Unique auto-generated ID
            $table->string('article');
            $table->text('description')->nullable();
            $table->string('property_no')->unique();
            $table->decimal('unit_value', 15, 2)->nullable();
            $table->string('unit_of_measure', 50)->nullable();
            $table->integer('quantity_per_property_card')->nullable();
            $table->integer('quantity_per_physical_count')->nullable();
           // $table->string('acc_code_new', 100)->nullable();
           // $table->string('acc_code_old', 100)->nullable();
          //  $table->string('classcode', 100)->nullable(); //removed
            $table->string('remarks', 255)->nullable();
            $table->date('date_acquired')->nullable();
            $table->string('accountable_person', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('ptsd', 100)->nullable();
            $table->string('division', 100)->nullable();
            $table->string('section_unit', 100)->nullable();
            $table->string('transfer_to', 100)->nullable();
            $table->integer('shortage_overage_qty')->default(0);
            $table->decimal('shortage_overage_value', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rpcppe');
    }
};