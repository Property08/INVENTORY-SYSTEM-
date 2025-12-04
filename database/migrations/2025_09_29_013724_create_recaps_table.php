<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('recaps', function (Blueprint $table) {
            $table->id();
            $table->string('acct_code_old')->nullable();
            $table->string('acct_code_new')->nullable();
            $table->string('classification_code')->nullable(); // e.g. 201 Land
            $table->string('classification_name'); // Land, Building, etc.

            // Financial Columns
            $table->decimal('beginning_balance', 18, 2)->default(0);
            $table->decimal('purchase_2024', 18, 2)->default(0);
            $table->decimal('reclassified_from_other', 18, 2)->default(0);
            $table->decimal('reclassified_to_other', 18, 2)->default(0);
            $table->decimal('disposed', 18, 2)->default(0);
            $table->decimal('donated', 18, 2)->default(0);
            $table->decimal('cancelled_adjustment', 18, 2)->default(0);
            $table->decimal('total_2024', 18, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('recaps');
    }
};
