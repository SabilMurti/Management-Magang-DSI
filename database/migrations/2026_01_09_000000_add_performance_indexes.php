<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tasks table indexes
        Schema::table('tasks', function (Blueprint $table) {
            // Single column indexes for common filters
            $table->index('status');
            $table->index('priority');
            $table->index('assigned_by');
            
            // Composite indexes for common query patterns
            $table->index(['intern_id', 'status']);
            $table->index(['assigned_by', 'created_at']);
            $table->index(['status', 'deadline']);
            $table->index(['intern_id', 'is_late']);
        });

        // Attendances table indexes
        Schema::table('attendances', function (Blueprint $table) {
            // Single column indexes for common filters
            $table->index('status');
            $table->index('date');
            
            // Composite indexes for common query patterns
            $table->index(['intern_id', 'date']);
            $table->index(['status', 'date']);
            $table->index(['date', 'status']);
        });

        // Interns table indexes
        Schema::table('interns', function (Blueprint $table) {
            $table->index('status');
            $table->index('supervisor_id');
        });

        // Assessments table indexes
        Schema::table('assessments', function (Blueprint $table) {
            $table->index('task_id');
            $table->index(['task_id', 'intern_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop all added indexes
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['priority']);
            $table->dropIndex(['intern_id']);
            $table->dropIndex(['assigned_by']);
            $table->dropIndex(['intern_id', 'status']);
            $table->dropIndex(['assigned_by', 'created_at']);
            $table->dropIndex(['status', 'deadline']);
            $table->dropIndex(['intern_id', 'is_late']);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['date']);
            $table->dropIndex(['intern_id']);
            $table->dropIndex(['intern_id', 'date']);
            $table->dropIndex(['status', 'date']);
            $table->dropIndex(['date', 'status']);
        });

        Schema::table('interns', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['supervisor_id']);
        });

        Schema::table('assessments', function (Blueprint $table) {
            $table->dropIndex(['task_id']);
            $table->dropIndex(['intern_id']);
            $table->dropIndex(['task_id', 'intern_id']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
            $table->dropIndex(['user_id', 'read_at']);
        });
    }
};
