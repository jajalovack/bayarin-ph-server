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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('profilePic')->default('default.jpg');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('isVerified')->default(false);
            $table->date('birthdate');
            $table->boolean('isActive')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(array([
            'first_name'=>'Daniele',
            'last_name'=>'Tejuco',
            'email'=>'dvtejuco@gmail.com',
            'birthdate'=>'2003-02-25',
            'password'=>'asdfasdf'
        ]));

        DB::table('users')->insert(array([
            'first_name'=>'Raphael',
            'last_name'=>'Pascual',
            'email'=>'rpascual@gmail.com',
            'birthdate'=>'1998-02-25',
            'password'=>'asdfasdf'
        ]));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
