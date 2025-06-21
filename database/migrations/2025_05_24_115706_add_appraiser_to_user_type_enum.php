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
        // Add 'appraiser' to the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('user', 'seller', 'admin', 'appraiser') DEFAULT 'user'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'appraiser' from the enum
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('user', 'seller', 'admin') DEFAULT 'user'");
    }
};