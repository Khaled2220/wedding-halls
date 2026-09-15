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
        Schema::table('payments', function (Blueprint $table) {
        $table->foreignId('reservation_id')
            ->after('id')
            ->constrained('reservations')
            ->cascadeOnDelete();

        $table->decimal('amount', 10, 2)
                ->after('reservation_id');

        $table->string('payment_method')
                ->default('paytabs')
                ->after('amount');

        $table->string('transaction_id')
            ->nullable()
            ->unique()
            ->after('payment_method');

        $table->string('status')
            ->default('pending')
            ->after('transaction_id');  

        $table->timestamp('paid_at')
            ->nullable()
            ->after('status');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign([
                'reservation_id'
            ]);
            $table->dropColumn([
                'reservation_id',
                'amount',
                'payment_method',
                'transaction_id',
                'status',
                'paid_at',
            ]);
        });
    }
};
