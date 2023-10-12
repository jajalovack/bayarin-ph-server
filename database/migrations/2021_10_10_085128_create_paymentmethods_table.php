<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paymentmethods', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('payment_method');
            $table->timestamps();
        });

        DB::table('paymentmethods')->insert(array('payment_method'=>'Over the counter (OTC)'));
        DB::table('paymentmethods')->insert(array('payment_method'=>'Debit/Credit Card'));
        DB::table('paymentmethods')->insert(array('payment_method'=>'e-Wallet'));
        DB::table('paymentmethods')->insert(array('payment_method'=>'Direct'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentmethods');
    }
};
