<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserTypeColumnLength extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type', 20)->change(); // Increase to a larger value like 20
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type')->change(); // Revert to default
        });
    }
}