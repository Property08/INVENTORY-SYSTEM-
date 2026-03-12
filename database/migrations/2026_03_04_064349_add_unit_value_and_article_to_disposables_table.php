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
            // Nilagay natin ito after 'name' para maayos ang pagkakasunod sa database
            $table->string('article')->nullable()->after('name'); 
            // Ang decimal(15, 2) ay standard para sa pera/halaga
            $table->decimal('unit_value', 15, 2)->default(0.00)->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposables', function (Blueprint $table) {
            $table->dropColumn(['article', 'unit_value']);
        });
    }
}; 