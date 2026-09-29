<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('disposables', function (Blueprint $table) {
            // Nagdadagdag ng 'location' column pagkatapos ng 'name' column
            $table->string('location')->nullable()->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposables', function (Blueprint $table) {
            // Tatanggalin ang 'location' column kapag nag-rollback
            $table->dropColumn('location');
        });
    }
};