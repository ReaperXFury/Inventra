<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gcashes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['cash_in', 'cash_out']);
            $table->string('customer_name');
            $table->string('phone_number', 11);
            $table->decimal('amount', 10, 2);
            $table->decimal('fee', 8, 2)->default(0.00);
            $table->string('reference_number')->nullable()->unique();
            $table->enum('status', ['pending', 'completed', 'failed'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gcashes');
    }
};
