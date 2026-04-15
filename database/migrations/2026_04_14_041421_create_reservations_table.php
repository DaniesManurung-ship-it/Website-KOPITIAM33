<?php
// database/migrations/2026_04_04_xxxxxx_create_reservations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('date');
            $table->time('time');
            $table->integer('people');
            $table->string('table_type')->nullable();
            $table->string('floor')->nullable();
            $table->text('notes')->nullable();
            // TAMBAHKAN 'archived' KE DALAM ENUM
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed', 'archived'])->default('pending');
            $table->string('edit_token')->nullable();
            $table->boolean('can_edit')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};