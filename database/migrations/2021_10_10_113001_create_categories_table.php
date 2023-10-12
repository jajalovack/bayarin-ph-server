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
        Schema::create('categories', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('category');
            $table->timestamps();
        });

        DB::table('categories')->insert(array('category'=>'Utility'));
        DB::table('categories')->insert(array('category'=>'Mortgage'));
        DB::table('categories')->insert(array('category'=>'Credit/Loan'));
        DB::table('categories')->insert(array('category'=>'Prepaid Load'));
        DB::table('categories')->insert(array('category'=>'Miscellaneous'));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
