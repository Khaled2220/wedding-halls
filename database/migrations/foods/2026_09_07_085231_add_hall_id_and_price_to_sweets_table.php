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
        Schema::table('sweets', function (Blueprint $table) {
            $table->foreignId('hall_id')
                ->after('id')
                ->constrained('halls')
                ->cascadeOnDelete();

            $table->decimal('price', 10, 2)
                ->after('hall_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sweets', function (Blueprint $table) {
            $table->dropForeign(['hall_id']);
            $table->dropColumn(['hall_id', 'price']);
        });
    }
};