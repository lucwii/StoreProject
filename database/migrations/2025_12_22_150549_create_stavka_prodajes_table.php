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
        Schema::create('stavka_prodajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodaja_id');
            $table->foreignId('artikal_id');
            $table->integer('kolicina');
            $table->decimal('cena', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stavka_prodajes');
    }
};
