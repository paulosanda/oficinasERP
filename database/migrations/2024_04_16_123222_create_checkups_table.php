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
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->string('front_damage')->nullable();
            $table->string('front_photo')->nullable();
            $table->string('back_damage')->nullable();
            $table->string('back_photo')->nullable();
            $table->string('right_side_damage')->nullable();
            $table->string('right_side_photo')->nullable();
            $table->string('left_side_damage')->nullable();
            $table->string('left_side_photo')->nullable();
            $table->string('roof_damage')->nullable();
            $table->string('roof_photo')->nullable();
            $table->enum('fuel_gauge', ['vazio', '1/4', '1/2', '3/4', 'cheio'])->nullable();
            $table->string('fuel_gauge_photo')->nullable();
            $table->enum('evaluation', ['pending', 'approved for use', 'maintenance recommended', 'quote'])->nullable();
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
