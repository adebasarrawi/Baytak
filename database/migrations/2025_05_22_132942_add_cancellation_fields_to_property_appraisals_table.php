<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_appraisals', function (Blueprint $table) {
            $table->enum('cancelled_by', ['user', 'admin'])->nullable()->after('status');
            $table->timestamp('cancelled_at')->nullable()->after('cancelled_by');
            $table->softDeletes(); // إضافة soft delete
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_appraisals', function (Blueprint $table) {
            $table->dropColumn(['cancelled_by', 'cancelled_at']);
            $table->dropSoftDeletes();
        });
    }
};