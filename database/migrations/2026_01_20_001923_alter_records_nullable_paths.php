<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->string('pdf_path')->nullable()->change();
            $table->string('excel_path')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('records', function (Blueprint $table) {
            $table->string('pdf_path')->nullable(false)->change();
            $table->string('excel_path')->nullable(false)->change();
        });
    }
};
