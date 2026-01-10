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
        // Update task_assignments table
        Schema::table('task_assignments', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('deadline_time');
            $table->dropColumn('estimated_hours');
        });

        // Update tasks table
        Schema::table('tasks', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('deadline_time');
            $table->json('submission_links')->nullable()->after('submission_notes');
            $table->dropColumn(['estimated_hours', 'submission_file', 'github_link', 'submission_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_assignments', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->integer('estimated_hours')->nullable();
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'submission_links']);
            $table->integer('estimated_hours')->nullable();
            $table->string('submission_file')->nullable();
            $table->string('github_link')->nullable();
            $table->enum('submission_type', ['github', 'file', 'both'])->default('both');
        });
    }
};
