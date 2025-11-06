<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pending_payments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            // CRÍTICO: El UUID que se enviará a Mercado Pago como 'external_reference'.
            // También se usa como identificador para Cart::store().
            $table->uuid('external_reference')->unique();

            $table->json('products');
            $table->json('address');

            // ID de Pago retornado por MP. NULO inicialmente.
            $table->string('payment_id')->nullable()->unique();

            // Monto total pagado.
            $table->decimal('total', 10, 2);
            
            // Estado interno para la Idempotencia: previene doble procesamiento.
            $table->enum('status', ['pending', 'processed', 'failed', 'manual_review'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_payments');
    }
};