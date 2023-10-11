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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bill_id');
            $table->foreign('bill_id')->references('id')->on('bills');
            $table->unsignedBigInteger('payor_id');
            $table->foreign('payor_id')->references('id')->on('users');
            $table->unsignedTinyInteger('payment_method');
            $table->foreign('payment_method')->references('id')->on('paymentmethods');
            $table->unsignedTinyInteger('status');
            $table->foreign('status')->references('id')->on('transactionstatuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
