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
        Schema::create('acceptance_receipt_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('acceptance_receipt_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_for_category_id')->constrained('acceptance_payment_for_categories')->cascadeOnDelete();
            $table->string('payment_for_description');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->cascadeOnDelete();
            $table->unsignedBigInteger('bank_id')->nullable();

            $table->bigInteger('cheque_or_bilyet_number')->nullable();
            $table->timestamps();

            $table->foreign('bank_id')->references('id')->on('banks')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acceptance_receipt_payments');
    }
};
