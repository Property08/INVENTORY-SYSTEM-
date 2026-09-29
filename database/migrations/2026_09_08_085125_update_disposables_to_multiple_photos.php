<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disposables', function (Blueprint $table) {
            // 1. Magdagdag ng bagong JSON column para sa multiple files
            if (!Schema::hasColumn('disposables', 'scanned_photos')) {
                $table->json('scanned_photos')->nullable()->after('WMR_num');
            }
        });

        // 2. (Opsyonal) Kung gusto mong i-save ang lumang single file papunta sa bagong array format
        $disposables = DB::table('disposables')->whereNotNull('scanned_photo')->get();
        foreach ($disposables as $item) {
            if (!empty($item->scanned_photo)) {
                // I-convert ang lumang string patungong array format
                DB::table('disposables')
                    ->where('id', $item->id)
                    ->update(['scanned_photos' => json_encode([$item->scanned_photo])]);
            }
        }

        // 3. Tanggalin ang lumang single column pagkatapos mailipat
        Schema::table('disposables', function (Blueprint $table) {
            if (Schema::hasColumn('disposables', 'scanned_photo')) {
                $table->dropColumn('scanned_photo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('disposables', function (Blueprint $table) {
            $table->string('scanned_photo')->nullable()->after('WMR_num');
            $table->dropColumn('scanned_photos');
        });
    }
};