<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateRoleColumnLength extends Migration
{
    public function up()
    {
        // Check if it's an enum
        $column = DB::select("SHOW COLUMNS FROM users LIKE 'role'")[0];
        
        if (strpos($column->Type, 'enum') !== false) {
            // If it's an enum, convert to string
            DB::statement('ALTER TABLE users MODIFY COLUMN role VARCHAR(20)');
        } else {
            // If it's already a string, just increase the size
            DB::statement('ALTER TABLE users MODIFY COLUMN role VARCHAR(20)');
        }
    }

    public function down()
    {
        // Revert is difficult if it was an enum
    }
}