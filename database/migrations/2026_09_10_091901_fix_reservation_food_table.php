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
        Schema::table('reservation_food', function (Blueprint $table) {
            $table->foreignId('reservation_id')
                ->after('id')
                ->constrained('reservations')
                ->cascadeOnDelete();
            $table->foreignId('food_id')
                ->after('reservation_id')
                ->constrained('foods')
                ->cascadeOnDelete();
            $table->decimal('price', 10, 2)
                ->after('food_id');

            $table->unique([
                'reservation_id',
                'food_id',
                ]);    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation_food', function (Blueprint $table) {
            $table->dropUnique('reservation_food_reservation_id_food_id_unique');
            $table->dropForeign(['reservation_id']);
            $table->dropForeign(['food_id']);
            $table->dropColumn([
                'reservation_id',
                'food_id',
                'price',
            ]); 
        });
    }
};
