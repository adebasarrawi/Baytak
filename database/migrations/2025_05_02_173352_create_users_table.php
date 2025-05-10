<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('role')->default('user');
            $table->string('user_type', 20)->default('user');
            $table->string('profile_image')->nullable();
            $table->text('bio')->nullable();
            $table->text('address')->nullable();
            
            // إضافة حقول التحقق من البريد
            $table->string('email_verification_code')->nullable();
            $table->timestamp('email_verification_expires_at')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // إزالة الحقول عند التراجع
            $table->dropColumn([
                'email_verification_code', 
                'email_verification_expires_at'
            ]);
        });
    }
}