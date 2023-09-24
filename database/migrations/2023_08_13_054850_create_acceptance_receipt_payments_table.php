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
            $table->string('payment_for');
            $table->string('payment_for_description')->nullable();
            $table->integer('payment_method');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->integer('bank_method')->nullable();
            $table->bigInteger('cek_or_giro_number')->nullable();
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
