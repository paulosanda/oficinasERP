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
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('company_id')->constrained('companies');
            $table->integer('company_numbering');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('vehicle_id');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->date('entry_date')->nullable();
            $table->date('exit_date')->nullable();
            $table->text('problem_description')->nullable();
            $table->text('report')->nullable();
            $table->text('observation')->nullable();
            $table->string('subtotal_service');
            $table->string('subtotal_part');
            $table->string('gross_total');
            $table->string('discount');
            $table->string('net_total');
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
