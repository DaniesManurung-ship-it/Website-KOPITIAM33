<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_user_id_and_edit_token_to_reservations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('cascade');
            $table->string('edit_token')->nullable()->after('status');
            $table->boolean('can_edit')->default(true)->after('edit_token');
        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'edit_token', 'can_edit']);
        });
    }
};