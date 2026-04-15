<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_original_price_to_promos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            if (!Schema::hasColumn('promos', 'original_price')) {
                $table->integer('original_price')->nullable()->default(0)->after('discount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->dropColumn('original_price');
        });
    }
};