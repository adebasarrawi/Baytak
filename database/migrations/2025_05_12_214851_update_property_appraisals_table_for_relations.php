<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('property_appraisals', function (Blueprint $table) {
            // إذا كانت الحقول غير موجودة أصلاً، أضفها
            if (!Schema::hasColumn('property_appraisals', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }

            if (!Schema::hasColumn('property_appraisals', 'appraiser_id')) {
                $table->foreignId('appraiser_id')->constrained('users')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('property_appraisals', function (Blueprint $table) {
            // التراجع عن التغييرات (حذف المفاتيح الأجنبية أولاً)
            $table->dropForeign(['user_id']);
            $table->dropForeign(['appraiser_id']);

            // حذف الحقول (اختياري)
            $table->dropColumn(['user_id', 'appraiser_id']);
        });
    }
};