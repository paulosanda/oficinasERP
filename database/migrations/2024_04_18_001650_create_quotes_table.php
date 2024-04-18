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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->integer('company_numbering');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('vehicle_id');
            $table->date('data_de_entrada');
            $table->date('data_de_saida')->nullable();
            $table->text('descricao_do_problema')->nullable();
            $table->text('laudo')->nullable();
            $table->text('observacao')->nullable();
            $table->string('sub_total_servico');
            $table->string('sub_total_produto');
            $table->string('total_bruto');
            $table->string('desconto');
            $table->string('total_liquido');
            $table->string('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
