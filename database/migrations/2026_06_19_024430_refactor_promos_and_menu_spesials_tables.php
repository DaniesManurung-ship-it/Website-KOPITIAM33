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
        // Truncate tables since we don't need to preserve old data and it avoids foreign key errors
        \DB::table('promos')->truncate();
        \DB::table('menu_spesials')->truncate();

        Schema::table('promos', function (Blueprint $table) {
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            $table->dropColumn(['name', 'image', 'description', 'original_price']);
        });

        Schema::table('menu_spesials', function (Blueprint $table) {
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            $table->dropColumn(['name', 'description', 'price', 'image', 'badge']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropColumn('menu_id');
            $table->string('name');
            $table->string('image');
            $table->text('description')->nullable();
            $table->integer('original_price')->default(0);
        });

        Schema::table('menu_spesials', function (Blueprint $table) {
            $table->dropForeign(['menu_id']);
            $table->dropColumn('menu_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image');
            $table->string('badge')->nullable();
        });
    }
};
