<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\TaskAssignment;

class TaskObserver
{
    /**
     * Handle the Task "deleted" event.
     * Jika semua task dalam group dihapus, group juga dihapus
     */
    public function deleted(Task $task): void
    {
        if ($task->task_assignment_id) {
            $taskAssignment = TaskAssignment::find($task->task_assignment_id);
            
            // Jika group tidak memiliki task lagi, hapus groupnya
            if ($taskAssignment && $taskAssignment->tasks()->count() === 0) {
                $taskAssignment->delete();
            }
        }
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        if ($task->task_assignment_id) {
            $taskAssignment = TaskAssignment::find($task->task_assignment_id);
            
            if ($taskAssignment && $taskAssignment->tasks()->count() === 0) {
                $taskAssignment->forceDelete();
            }
        }
    }
}
