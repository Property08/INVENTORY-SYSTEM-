<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recaps', function (Blueprint $table) {
            $table->dropColumn('classification_name');
        });
    }

    public function down(): void
    {
        Schema::table('recaps', function (Blueprint $table) {
            // Recreate the column in case of rollback
            $table->string('classification_name')->nullable();
        });
    }
};


