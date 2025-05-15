<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('property_appraisals', function (Blueprint $table) {
            $table->string('property_type')->nullable()->after('property_address');
        });
    }
    
    public function down()
    {
        Schema::table('property_appraisals', function (Blueprint $table) {
            $table->dropColumn('property_type');
        });
    }
};
