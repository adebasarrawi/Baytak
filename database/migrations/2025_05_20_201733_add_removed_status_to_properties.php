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
        // Update the status enum to include 'removed'
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE properties MODIFY status ENUM('pending', 'approved', 'rejected', 'archived', 'removed') DEFAULT 'pending'");
        }
        
        
    }

   
    public function down(): void
    {
        // Revert the status enum
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE properties MODIFY status ENUM('pending', 'approved', 'rejected', 'archived') DEFAULT 'pending'");
        }
        
       
    }
};