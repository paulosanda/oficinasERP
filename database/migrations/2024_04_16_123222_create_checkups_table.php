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
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->string('avarias_frente')->nullable();
            $table->string('av_frente_foto')->nullable();
            $table->string('avarias_traseiro')->nullable();
            $table->string('av_traseira_foto')->nullable();
            $table->string('avarias_direito')->nullable();
            $table->string('av_direito_foto')->nullable();
            $table->string('avarias_esquerdo')->nullable();
            $table->string('av_esquerdo_foto')->nullable();
            $table->string('avarias_teto')->nullable();
            $table->string('av_teto_foto')->nullable();
            $table->enum('combustivel',['vazio', '1/4','1/2','3/4', 'cheio'])->nullable();
            $table->string('combustivel_foto')->nullable();
            $table->enum('avaliacao', ['aprovado para uso', 'manutenção recomendada'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkups');
    }
};
