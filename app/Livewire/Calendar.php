<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Attendance;
use App\Models\Task;
use Carbon\Carbon;

class Calendar extends Component
{
    public $currentMonth;
    public $currentYear;
    public $days = [];
    public $events = [];
    public $viewMode = 'attendance'; // 'attendance' or 'tasks'

    public function mount($mode = 'attendance')
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->viewMode = $mode;
        $this->generateCalendar();
    }

    public function generateCalendar()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $date->daysInMonth;
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        // Get the day of week for the first day (0 = Sunday, 6 = Saturday)
        $startDayOfWeek = $startOfMonth->dayOfWeek;

        $this->days = [];
        $this->events = [];

        // Add empty slots for days before the start of month
        for ($i = 0; $i < $startDayOfWeek; $i++) {
            $this->days[] = null;
        }

        // Add actual days
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $this->days[] = $day;
        }

        // Load events based on view mode
        $this->loadEvents($startOfMonth, $endOfMonth);
    }

    public function loadEvents($start, $end)
    {
        $user = auth()->user();

        if ($this->viewMode === 'attendance') {
            $this->loadAttendanceEvents($user, $start, $end);
        } else {
            $this->loadTaskEvents($user, $start, $end);
        }
    }

    public function loadAttendanceEvents($user, $start, $end)
    {
        if ($user->isIntern() && $user->intern) {
            $attendances = Attendance::where('intern_id', $user->intern->id)
                ->whereBetween('date', [$start, $end])
                ->get();
        } elseif ($user->canManage()) {
            // For admin/supervisor, show summary counts
            $attendances = Attendance::whereBetween('date', [$start, $end])
                ->selectRaw('date, status, COUNT(*) as count')
                ->groupBy('date', 'status')
                ->get();
        } else {
            $attendances = collect();
        }

        foreach ($attendances as $att) {
            $day = Carbon::parse($att->date)->day;
            if (!isset($this->events[$day])) {
                $this->events[$day] = [];
            }

            if ($user->isIntern()) {
                $this->events[$day][] = [
                    'type' => 'attendance',
                    'status' => $att->status,
                    'check_in' => $att->check_in,
                    'check_out' => $att->check_out,
                ];
            } else {
                $this->events[$day][] = [
                    'type' => 'attendance_summary',
                    'status' => $att->status,
                    'count' => $att->count,
                ];
            }
        }
    }

    public function loadTaskEvents($user, $start, $end)
    {
        $query = Task::whereBetween('deadline', [$start, $end]);

        if ($user->isIntern() && $user->intern) {
            $query->where('intern_id', $user->intern->id);
        }

        $tasks = $query->get();

        foreach ($tasks as $task) {
            if (!$task->deadline) continue;

            $day = Carbon::parse($task->deadline)->day;
            if (!isset($this->events[$day])) {
                $this->events[$day] = [];
            }

            $this->events[$day][] = [
                'type' => 'task',
                'id' => $task->id,
                'title' => $task->title,
                'status' => $task->status,
                'priority' => $task->priority,
            ];
        }
    }

    public function previousMonth()
    {
        if ($this->currentMonth == 1) {
            $this->currentMonth = 12;
            $this->currentYear--;
        } else {
            $this->currentMonth--;
        }
        $this->generateCalendar();
    }

    public function nextMonth()
    {
        if ($this->currentMonth == 12) {
            $this->currentMonth = 1;
            $this->currentYear++;
        } else {
            $this->currentMonth++;
        }
        $this->generateCalendar();
    }

    public function switchMode($mode)
    {
        $this->viewMode = $mode;
        $this->generateCalendar();
    }

    public function getMonthNameProperty()
    {
        return Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->translatedFormat('F Y');
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
