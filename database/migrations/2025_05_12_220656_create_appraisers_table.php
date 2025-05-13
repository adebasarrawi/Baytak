<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appraisers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('experience_years')->default(0);
            $table->string('license_number')->nullable();
            $table->string('specialty')->nullable();
            $table->text('availability')->nullable(); // يخزن كـ JSON
            $table->decimal('hourly_rate', 8, 2)->default(0);
            $table->decimal('rating', 3, 1)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appraisers');
    }
};