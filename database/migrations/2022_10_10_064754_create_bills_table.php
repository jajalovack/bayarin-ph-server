<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    
    // public function up(): void
    // {
    //     Schema::create('bills', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('refnum');
    //         $table->unsignedTinyInteger('biller_id');
    //         $table->foreign('biller_id')->references('id')->on('billers');
    //         $table->unsignedTinyInteger('bill_category');
    //         $table->foreign('bill_category')->references('id')->on('categories');
    //         $table->string('billed_to',150);
    //         $table->string('description')->default('No description');
    //         $table->decimal('amount');
    //         $table->unsignedTinyInteger('status');
    //         $table->foreign('status')->references('id')->on('billstatuses');
    //         $table->timestamps();
    //     });
    // }

    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('refnum');
            $table->unsignedTinyInteger('biller_id')->index();
            $table->unsignedTinyInteger('category_id')->index();
            $table->string('billed_to',150);
            $table->string('description')->default('No description');
            $table->decimal('amount');
            $table->unsignedTinyInteger('billstatus_id')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
