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
        Schema::create('quote_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes');
            $table->string('codigo_do_produto')->nullable();
            $table->string('descricao');
            $table->tinyInteger('quantidade');
            $table->string('valor');
            $table->string('desconto')->nullable();
            $table->string('sub_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_parts');
    }
};
