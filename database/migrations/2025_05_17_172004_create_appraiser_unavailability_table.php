<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppraiserUnavailabilityTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appraiser_unavailability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appraiser_id')->constrained('appraisers')->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->timestamps();

            // Ensure each appraiser can only have one unavailability record per date and time
            $table->unique(['appraiser_id', 'date', 'time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appraiser_unavailability');
    }
}