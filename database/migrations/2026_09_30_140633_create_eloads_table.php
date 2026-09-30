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
        Schema::create('eloads', function (Blueprint $table) {
            $table->id();
            $table->string('provider'); // Globe, Smart, DITO, TM, TNT, Sun, PLDT
            $table->string('customer_name');
            $table->string('phone_number', 11);
            $table->decimal('amount', 10, 2); // Load amount
            $table->decimal('fee', 10, 2)->default(0); // Top-up mark-up/service charge
            $table->string('reference_number')->nullable();
            $table->enum('status', ['completed', 'pending', 'failed'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eloads');
    }
};
