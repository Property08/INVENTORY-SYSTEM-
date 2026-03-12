<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('disposables', function (Blueprint $table) {
            // Adds the year column after DateAcquired
            $table->integer('year')->nullable()->after('DateAcquired');
        });
    }

    public function down() {
        Schema::table('disposables', function (Blueprint $table) {
            $table->dropColumn('year');
        });
    }
};