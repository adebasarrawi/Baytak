<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyAppraisalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_appraisals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('appraiser_id')->nullable();
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone');
            $table->text('property_address');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('additional_notes')->nullable();
            $table->enum('status', ['pending', 'confirmed',  'cancelled'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_appraisals');
    }
}