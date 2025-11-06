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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->integer('type'); // 1: home, 2: office, 3: etc.

            $table->string('description'); // la direccion como tal

            $table->string('reference'); // referencias para encontrar la direccion

            $table->string('postal_code');
            $table->string('locality'); 
            $table->string('province'); 

            // $table->string('postal_code');

            // $table->string('locality');

            // $table->string('city');

            $table->string(column: 'receiver'); // persona que recibira el pedido

            $table->json('receiver_info');

            $table->boolean('default')->default(value: false); // si es la direccion por defecto

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
