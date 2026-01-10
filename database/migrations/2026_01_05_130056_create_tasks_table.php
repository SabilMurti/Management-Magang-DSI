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
        Schema::create('task_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->date('deadline')->nullable();
            $table->time('deadline_time')->nullable();
            $table->integer('estimated_hours')->nullable();
            $table->enum('submission_type', ['github', 'file', 'both'])->default('both');
            $table->boolean('assign_to_all')->default(false);
            $table->timestamps();
        });

        Schema::create('task_assignment_interns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_assignment_id')->constrained()->onDelete('cascade');
            $table->foreignId('intern_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_assignment_id')->nullable()->constrained()->onDelete('set null');
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('intern_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('assigned_by')->constrained('users')->onDelete('cascade');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'revision', 'submitted'])->default('pending');
            $table->date('deadline')->nullable();
            $table->time('deadline_time')->nullable();
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->datetime('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_late')->default(false);
            $table->integer('estimated_hours')->nullable();
            $table->enum('submission_type', ['github', 'file', 'both'])->default('both');
            $table->string('github_link')->nullable();
            $table->string('submission_file')->nullable();
            $table->text('submission_notes')->nullable();
            $table->integer('score')->nullable();
            $table->text('admin_feedback')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
