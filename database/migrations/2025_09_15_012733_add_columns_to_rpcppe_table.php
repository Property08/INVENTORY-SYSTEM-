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
        Schema::table('rpcppe', function (Blueprint $table) {
            if (!Schema::hasColumn('rpcppe', 'date_acquired')) {
                $table->date('date_acquired')->nullable();
            }
            if (!Schema::hasColumn('rpcppe', 'accountable_person')) {
                $table->string('accountable_person', 255)->nullable();
            }
            if (!Schema::hasColumn('rpcppe', 'location')) {
                $table->string('location', 255)->nullable();
            }
            if (!Schema::hasColumn('rpcppe', 'ptsd')) {
                $table->string('ptsd', 255)->nullable();
            }
            if (!Schema::hasColumn('rpcppe', 'division')) {
                $table->string('division', 255)->nullable();
            }
            if (!Schema::hasColumn('rpcppe', 'section_unit')) {
                $table->string('section_unit', 255)->nullable();
            }
            if (!Schema::hasColumn('rpcppe', 'transfer_to')) {
                $table->string('transfer_to', 255)->nullable();
            }
            if (!Schema::hasColumn('rpcppe', 'shortage_overage_qty')) {
                $table->integer('shortage_overage_qty')->nullable(0);
            }
            if (!Schema::hasColumn('rpcppe', 'shortage_overage_value')) {
                $table->decimal('shortage_overage_value', 15, 2)->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rpcppe', function (Blueprint $table) {
            $table->dropColumn([
                'date_acquired',
                'accountable_person',
                'location',
                'ptsd',
                'division',
                'section_unit',
                'transfer_to',
                'shortage_overage_qty',
                'shortage_overage_value',
            ]);
        });
    }
};