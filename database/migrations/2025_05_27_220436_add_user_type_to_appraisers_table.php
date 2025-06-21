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
        Schema::table('appraisers', function (Blueprint $table) {
            $table->string('user_type')->default('appraiser')->after('id');
        });

        // تحديث جميع السجلات الموجودة لتكون user_type = 'appraiser'
        DB::table('appraisers')->update(['user_type' => 'appraiser']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appraisers', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });
    }
};