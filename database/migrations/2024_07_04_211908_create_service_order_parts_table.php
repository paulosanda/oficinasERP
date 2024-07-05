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
        Schema::create('service_order_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_order_id')->constrained('service_order')->cascadeOnDelete();
            $table->string('part_code')->nullable();
            $table->string('description');
            $table->tinyInteger('quantity');
            $table->string('value');
            $table->string('discount')->nullable();
            $table->string('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_parts');
    }
};
