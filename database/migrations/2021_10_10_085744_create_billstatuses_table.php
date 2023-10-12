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
        Schema::create('billstatuses', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('status');
            $table->timestamps();
        });

        DB::table('billstatuses')->insert(array('status'=>'Unpaid'));
        DB::table('billstatuses')->insert(array('status'=>'Paid'));
        DB::table('billstatuses')->insert(array('status'=>'Paid by'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billstatuses');
    }
};
