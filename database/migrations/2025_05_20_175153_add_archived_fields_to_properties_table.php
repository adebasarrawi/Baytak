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
        Schema::table('properties', function (Blueprint $table) {
            // Add archived_at timestamp for when property was archived
            $table->timestamp('archived_at')->nullable();
        });

        // Update the status column to accept 'archived' value
        // This depends on your database system
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE properties MODIFY status ENUM('pending', 'approved', 'rejected', 'archived') DEFAULT 'pending'");
        } else {
            // For other database systems, you may need to handle differently
            // For example, if using PostgreSQL:
            // DB::statement("ALTER TABLE properties DROP CONSTRAINT properties_status_check");
            // DB::statement("ALTER TABLE properties ADD CONSTRAINT properties_status_check CHECK (status IN ('pending', 'approved', 'rejected', 'archived'))");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the status column to original values
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE properties MODIFY status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
        } else {
            // For other database systems
            // DB::statement("ALTER TABLE properties DROP CONSTRAINT properties_status_check");
            // DB::statement("ALTER TABLE properties ADD CONSTRAINT properties_status_check CHECK (status IN ('pending', 'approved', 'rejected'))");
        }

        Schema::table('properties', function (Blueprint $table) {
            // Drop the archived_at column
            $table->dropColumn('archived_at');
        });
    }
};