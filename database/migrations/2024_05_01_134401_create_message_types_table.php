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
        Schema::create('message_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedulable_service_id')->constrained('schedulable_services');
            $table->string('model_name')->unique();
            $table->string('title')->nullable();
            $table->string('message')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_types');
    }
};
