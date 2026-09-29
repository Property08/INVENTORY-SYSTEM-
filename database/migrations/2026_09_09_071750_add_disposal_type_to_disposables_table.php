<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('disposables', function (Blueprint $table) {
        $table->string('disposal_type')->nullable()->after('place'); // o ilagay kung saang kolum mo gustong sumunod
    });
}

public function down(): void
{
    Schema::table('disposables', function (Blueprint $table) {
        $table->dropColumn('disposal_type');
    });
}
};
