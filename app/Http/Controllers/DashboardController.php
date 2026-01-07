<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Task;
use App\Models\Attendance;
use App\Models\Report;
use App\Models\Assessment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isIntern()) {
            return $this->internDashboard();
        }

        return $this->adminDashboard();
    }

    private function adminDashboard()
    {
        $totalInterns = Intern::where('status', 'active')->count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('status', 'completed')->count();
        $pendingTasks = Task::whereIn('status', ['pending', 'in_progress'])->count();

        // Late vs On-time stats for admin
        $completedOnTime = Task::where('status', 'completed')->where('is_late', false)->count();
        $completedLate = Task::where('status', 'completed')->where('is_late', true)->count();

        $todayAttendance = Attendance::whereDate('date', today())->count();
        $presentToday = Attendance::whereDate('date', today())
            ->whereIn('status', ['present', 'late'])->count();

        $recentTasks = Task::with(['intern.user'])
            ->latest()
            ->take(5)
            ->get();

        $recentAttendances = Attendance::with(['intern.user'])
            ->whereDate('date', today())
            ->latest()
            ->take(10)
            ->get();

        // Tasks waiting for review
        $submittedTasks = Task::with(['intern.user'])
            ->where('status', 'submitted')
            ->orderBy('submitted_at', 'asc') // Oldest first
            ->get();

        $interns = Intern::with(['user', 'tasks', 'attendances', 'assessments'])->where('status', 'active')->get();

        // Chart Data: Today's Attendance Breakdown
        $attendanceToday = [
            'present' => Attendance::whereDate('date', today())->where('status', 'present')->count(),
            'late' => Attendance::whereDate('date', today())->where('status', 'late')->count(),
            'permission' => Attendance::whereDate('date', today())->where('status', 'permission')->count(),
            'sick' => Attendance::whereDate('date', today())->where('status', 'sick')->count(),
            'absent' => $totalInterns - Attendance::whereDate('date', today())->count(),
        ];

        // Chart Data: Monthly Attendance Trend (Last 7 days)
        $attendanceTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $attendanceTrend[] = [
                'date' => $date->format('d M'),
                'present' => Attendance::whereDate('date', $date)->whereIn('status', ['present', 'late'])->count(),
                'absent' => $totalInterns - Attendance::whereDate('date', $date)->count(),
            ];
        }

        return view('dashboard.admin', compact(
            'totalInterns',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'completedOnTime',
            'completedLate',
            'todayAttendance',
            'presentToday',
            'recentTasks',
            'recentAttendances',
            'submittedTasks',
            'interns',
            'attendanceToday',
            'attendanceTrend'
        ));
    }

    private function internDashboard()
    {
        $user = auth()->user();
        $intern = $user->intern;

        if (!$intern) {
            return view('dashboard.incomplete-profile');
        }

        $tasks = $intern->tasks()->latest()->take(5)->get();
        $attendances = $intern->attendances()->latest()->take(7)->get();
        $todayAttendance = $intern->attendances()->whereDate('date', today())->first();

        $completedTasks = $intern->tasks()->where('status', 'completed')->count();
        $pendingTasks = $intern->tasks()->whereIn('status', ['pending', 'in_progress'])->count();
        $totalTasks = $intern->tasks()->count();

        // Task submission statistics
        $taskStats = $intern->getTaskStatistics();
        $onTimeRate = $intern->getOnTimeRate();

        $attendancePercentage = $intern->getAttendancePercentage();
        $averageSpeed = $intern->getAverageSpeed();
        $overallScore = $intern->getOverallScore();

        // Office Location Settings
        $officeLat = \App\Models\Setting::get('office_latitude', -7.052683);
        $officeLon = \App\Models\Setting::get('office_longitude', 110.469375);
        $maxDist = \App\Models\Setting::get('max_checkin_distance', 100);

        // Chart Data: Weekly Attendance (Last 7 days)
        $weeklyAttendance = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $att = $intern->attendances()->whereDate('date', $date)->first();
            $weeklyAttendance[] = [
                'date' => $date->format('D'),
                'status' => $att ? $att->status : 'absent',
            ];
        }

        // Chart Data: Task Status Breakdown
        $taskBreakdown = [
            'pending' => $intern->tasks()->where('status', 'pending')->count(),
            'in_progress' => $intern->tasks()->where('status', 'in_progress')->count(),
            'submitted' => $intern->tasks()->where('status', 'submitted')->count(),
            'completed' => $intern->tasks()->where('status', 'completed')->count(),
            'revision' => $intern->tasks()->where('status', 'revision')->count(),
        ];

        return view('dashboard.intern', compact(
            'intern',
            'tasks',
            'attendances',
            'todayAttendance',
            'completedTasks',
            'pendingTasks',
            'totalTasks',
            'taskStats',
            'onTimeRate',
            'attendancePercentage',
            'averageSpeed',
            'overallScore',
            'officeLat',
            'officeLon',
            'maxDist',
            'weeklyAttendance',
            'taskBreakdown'
        ));
    }
}
