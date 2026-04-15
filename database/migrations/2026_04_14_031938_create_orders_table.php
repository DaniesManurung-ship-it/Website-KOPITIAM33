<?php
// database/migrations/2026_01_01_000001_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('order_number')->unique();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone')->nullable();
            $table->json('items');
            $table->integer('subtotal');
            
            // STATUS LENGKAP DENGAN archived
            $table->enum('status', [
                'pending',     // Menunggu diproses
                'processed',   // Sedang diproses
                'completed',   // Selesai
                'cancelled',   // Dibatalkan oleh customer
                'archived'     // Diarsipkan oleh admin (tidak terlihat di admin, tapi tetap di customer)
            ])->default('pending');
            
            $table->boolean('can_cancel')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Index untuk mempercepat query
            $table->index('status');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};