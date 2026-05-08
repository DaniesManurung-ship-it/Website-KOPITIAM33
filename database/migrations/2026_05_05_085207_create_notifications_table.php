<?php
// database/migrations/2026_05_05_000001_create_notifications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // order, reservation
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Untuk menyimpan data tambahan
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->string('reference_id')->nullable(); // ID pesanan/reservasi
            $table->string('reference_type')->nullable(); // Order atau Reservation
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};