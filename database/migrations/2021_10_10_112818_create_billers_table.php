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
        Schema::create('billers', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('biller');
            $table->timestamps();
        });

        DB::table('billers')->insert(array('biller'=>'Meralco'));
        DB::table('billers')->insert(array('biller'=>'Nawasa'));
        DB::table('billers')->insert(array('biller'=>'Bank of the Philippine Islands (BPI)'));
        DB::table('billers')->insert(array('biller'=>'Landbank'));
        DB::table('billers')->insert(array('biller'=>'Home Credit'));
        DB::table('billers')->insert(array('biller'=>'Globe Telecom'));
        DB::table('billers')->insert(array('biller'=>'Landbank'));
        DB::table('billers')->insert(array('biller'=>'beep'));
        DB::table('billers')->insert(array('biller'=>'PLDT'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billers');
    }
};
