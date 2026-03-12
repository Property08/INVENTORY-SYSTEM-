<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rpcppe', function (Blueprint $blueprint) {
            // Idagdag ang classification column pagkatapos ng property_no
            $blueprint->string('classification')->nullable()->after('property_no');
        });
    }

    public function down(): void
    {
        Schema::table('rpcppe', function (Blueprint $blueprint) {
            $blueprint->dropColumn('classification');
        });
    }
};
