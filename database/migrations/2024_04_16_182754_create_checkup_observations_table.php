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
        Schema::create('checkup_observations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checkup_id')->constrained('checkups');
            $table->foreignId('checkup_observation_type_id')->constrained('checkup_observation_types');
            $table->string('observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkup_observations');
    }
};
