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
        Schema::create('transactionstatuses', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('status');
            $table->timestamps();
        });

        DB::table('transactionstatuses')->insert(array('status'=>'Paid'));
        DB::table('transactionstatuses')->insert(array('status'=>'Failed'));
        DB::table('transactionstatuses')->insert(array('status'=>'Reversed'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactionstatuses');
    }
};
