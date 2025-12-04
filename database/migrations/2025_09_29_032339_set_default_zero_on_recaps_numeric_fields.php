<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Convert existing NULLs to 0 to avoid errors when making NOT NULL
        DB::table('recaps')->whereNull('purchase_2024')->update(['purchase_2024' => 0]);
        DB::table('recaps')->whereNull('beginning_balance')->update(['beginning_balance' => 0]);
        DB::table('recaps')->whereNull('reclassified_from_other')->update(['reclassified_from_other' => 0]);
        DB::table('recaps')->whereNull('reclassified_to_other')->update(['reclassified_to_other' => 0]);
        DB::table('recaps')->whereNull('disposed')->update(['disposed' => 0]);
        DB::table('recaps')->whereNull('donated')->update(['donated' => 0]);
        DB::table('recaps')->whereNull('cancelled_adjustment')->update(['cancelled_adjustment' => 0]);
        DB::table('recaps')->whereNull('total_2024')->update(['total_2024' => 0]);

        // 2) Change column definitions to NOT NULL with DEFAULT 0
        Schema::table('recaps', function (Blueprint $table) {
            $table->decimal('purchase_2024', 15, 2)->default(0)->change();
            $table->decimal('beginning_balance', 15, 2)->default(0)->change();
            $table->decimal('reclassified_from_other', 15, 2)->default(0)->change();
            $table->decimal('reclassified_to_other', 15, 2)->default(0)->change();
            $table->decimal('disposed', 15, 2)->default(0)->change();
            $table->decimal('donated', 15, 2)->default(0)->change();
            $table->decimal('cancelled_adjustment', 15, 2)->default(0)->change();
            $table->decimal('total_2024', 15, 2)->default(0)->change();
        });
    }

    public function down(): void
    {
        // Rollback: make them nullable again and remove default
        Schema::table('recaps', function (Blueprint $table) {
            $table->decimal('purchase_2024', 15, 2)->nullable()->default(null)->change();
            $table->decimal('beginning_balance', 15, 2)->nullable()->default(null)->change();
            $table->decimal('reclassified_from_other', 15, 2)->nullable()->default(null)->change();
            $table->decimal('reclassified_to_other', 15, 2)->nullable()->default(null)->change();
            $table->decimal('disposed', 15, 2)->nullable()->default(null)->change();
            $table->decimal('donated', 15, 2)->nullable()->default(null)->change();
            $table->decimal('cancelled_adjustment', 15, 2)->nullable()->default(null)->change();
            $table->decimal('total_2024', 15, 2)->nullable()->default(null)->change();
        });
    }
};
