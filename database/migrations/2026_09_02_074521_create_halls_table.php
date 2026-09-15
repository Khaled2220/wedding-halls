<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('halls', function (Blueprint $table) {
            $table->id();

            // Hall Manager who owns/manages the hall
            $table->foreignId('hall_manager_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Hall information
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('address');
            $table->string('phone', 30)->nullable();

            // Price and capacity
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('capacity')->nullable();

            // active / inactive
            $table->string('status')->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('halls');
    }
};
