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
        // For SQLite, we need to recreate the column
        // For MySQL, we can use ENUM modification
        
        // Check if using SQLite (testing) or MySQL (production)
        $driver = Schema::getConnection()->getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite doesn't support ENUM, status is stored as string
            // No migration needed for SQLite
        } else {
            // MySQL: Modify the ENUM to include 'pending'
            DB::statement("ALTER TABLE interns MODIFY COLUMN status ENUM('pending', 'active', 'completed', 'cancelled') DEFAULT 'active'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();
        
        if ($driver !== 'sqlite') {
            // Revert to original ENUM
            DB::statement("ALTER TABLE interns MODIFY COLUMN status ENUM('active', 'completed', 'cancelled') DEFAULT 'active'");
        }
    }
};
