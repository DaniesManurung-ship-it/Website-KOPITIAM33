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
        Schema::table('reservations', function (Blueprint $table) {
            $table->text('admin_message')->nullable()->after('notes');
            $table->text('customer_reply')->nullable()->after('admin_message');
            $table->string('assigned_table')->nullable()->after('customer_reply');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['admin_message', 'customer_reply', 'assigned_table']);
        });
    }
};
