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
        Schema::create('utangs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->decimal('amount', 10, 2); 
            $table->text('description')->nullable(); // Optional details
            $table->date('due_date')->nullable(); // When the payment is due
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending'); // Payment status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('utangs');
    }
};
