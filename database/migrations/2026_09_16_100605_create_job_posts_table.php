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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hall_manager_id') 
            ->constrained('users') 
            ->cascadeOnDelete();

            $table->foreignId('hall_id') 
            ->constrained('halls') 
            ->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable(); 
            $table->text('requirements')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('employment_type')->nullable();
            $table->unsignedInteger('workers_needed')->default(1);
            $table->date('deadline')->nullable();
            $table->string('status')->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
