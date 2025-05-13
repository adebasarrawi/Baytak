<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // تحقق من وجود الجدول أولاً
        if (!Schema::hasTable('appraisers')) {
            // إنشاء الجدول إذا لم يكن موجوداً
            Schema::create('appraisers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->integer('experience_years')->default(0);
                $table->string('license_number')->nullable();
                $table->string('specialty')->nullable();
                $table->text('availability')->nullable();
                $table->decimal('hourly_rate', 8, 2)->default(0);
                $table->decimal('rating', 3, 1)->default(0);
                $table->timestamps();
            });
        } else {
            // إضافة عمود user_id إذا كان الجدول موجوداً ولا يحتوي على العمود
            if (!Schema::hasColumn('appraisers', 'user_id')) {
                Schema::table('appraisers', function (Blueprint $table) {
                    $table->foreignId('user_id')->constrained()->onDelete('cascade');
                });
            }
        }
    }

    public function down()
    {
        if (Schema::hasTable('appraisers')) {
            if (Schema::hasColumn('appraisers', 'user_id')) {
                Schema::table('appraisers', function (Blueprint $table) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                });
            }
        }
    }
};