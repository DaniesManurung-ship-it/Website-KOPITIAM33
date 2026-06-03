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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('item_id');
            $table->string('item_type'); // 'menu', 'menu_spesial', 'promo'
            $table->string('name');
            $table->integer('price');
            $table->integer('quantity')->default(1);
            $table->string('image')->nullable();
            $table->json('metadata')->nullable(); // untuk extra data seperti diskon, original_price dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
