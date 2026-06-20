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
        // Truncate first to avoid issues with adding non-nullable columns and unique constraints
        \DB::table('promos')->truncate();
        \DB::table('menu_spesials')->truncate();

        // 1. Tambahkan promo_id ke menus (1 Promo has Many Menus)
        Schema::table('menus', function (Blueprint $table) {
            $table->foreignId('promo_id')->nullable()->constrained('promos')->nullOnDelete();
        });

        // 2. Modifikasi tabel promos
        Schema::table('promos', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropColumn('menu_id');
            $table->string('name')->after('id');
            $table->string('image')->after('name');
            $table->text('description')->nullable()->after('image');
        });

        // 3. Modifikasi tabel menu_spesials agar 1-to-1 strict (tambah UNIQUE constraint pada menu_id)
        Schema::table('menu_spesials', function (Blueprint $table) {
            $table->unique('menu_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropForeign(['promo_id']);
            $table->dropColumn('promo_id');
        });

        Schema::table('promos', function (Blueprint $table) {
            $table->foreignId('menu_id')->nullable()->constrained('menus')->cascadeOnDelete();
            $table->dropColumn(['name', 'image', 'description']);
        });

        Schema::table('menu_spesials', function (Blueprint $table) {
            $table->dropUnique(['menu_id']);
        });
    }
};
