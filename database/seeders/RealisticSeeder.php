<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Intern;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\Attendance;
use App\Models\Assessment;
use App\Models\Report;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RealisticSeeder extends Seeder
{
    /**
     * Indonesian names for realistic data
     */
    private $firstNames = [
        'Ahmad', 'Budi', 'Citra', 'Dewi', 'Eka', 'Fadli', 'Gita', 'Hendra',
        'Indah', 'Joko', 'Kartika', 'Lukman', 'Maya', 'Naufal', 'Olivia',
        'Prasetyo', 'Qori', 'Rizki', 'Sari', 'Taufik', 'Umi', 'Vino',
        'Wulan', 'Yoga', 'Zahra', 'Aditya', 'Bella', 'Cahyo', 'Diana', 'Erwin',
        'Fitri', 'Galih', 'Hani', 'Irfan', 'Julia'
    ];

    private $lastNames = [
        'Pratama', 'Wijaya', 'Kusuma', 'Sari', 'Nugroho', 'Permana', 'Santoso',
        'Putra', 'Wati', 'Hidayat', 'Ramadhan', 'Lestari', 'Setiawan', 'Utami',
        'Saputra', 'Dewi', 'Kurniawan', 'Putri', 'Firmansyah', 'Handayani',
        'Ramadhani', 'Anggraini', 'Prasetya', 'Maharani', 'Arifin', 'Susanti',
        'Wahyudi', 'Puspita', 'Haryanto', 'Safitri'
    ];

    private $schools = [
        'SMK Negeri 1 Jakarta',
        'SMK Negeri 2 Bandung',
        'SMK Telkom Malang',
        'SMK Informatika Surabaya',
        'Politeknik Negeri Jakarta',
        'Universitas Indonesia',
        'Institut Teknologi Bandung',
        'Universitas Gadjah Mada',
        'Universitas Brawijaya',
        'Politeknik Elektronika Negeri Surabaya',
        'SMK Negeri 4 Malang',
        'SMK Prakarya Internasional',
        'SMK Wikrama Bogor',
        'Universitas Bina Nusantara',
        'Universitas Telkom',
    ];

    private $departments = [
        'Rekayasa Perangkat Lunak',
        'Teknik Komputer dan Jaringan',
        'Multimedia',
        'Sistem Informasi',
        'Teknik Informatika',
        'Manajemen Informatika',
        'Desain Grafis',
        'Animasi',
        'Broadcasting',
        'Bisnis Digital',
    ];

    private $taskTitles = [
        'Membuat Landing Page Website',
        'Develop REST API Authentication',
        'Redesign UI Dashboard Admin',
        'Setup CI/CD Pipeline',
        'Database Migration & Optimization',
        'Implementasi Payment Gateway',
        'Unit Testing Module User',
        'Dokumentasi API Swagger',
        'Mobile App - Login Screen',
        'Integrasi Social Media Login',
        'Develop Chat Feature Real-time',
        'Setup Monitoring & Logging',
        'Optimasi Performance Website',
        'Membuat Report Generator PDF',
        'Implementasi Notifikasi Push',
        'Develop E-commerce Cart System',
        'Setup Email Template',
        'Membuat Data Visualization Dashboard',
        'Develop File Upload System',
        'Implementasi Role-based Access Control',
    ];

    private $taskDescriptions = [
        'Membuat landing page responsive dengan design modern menggunakan Tailwind CSS dan animasi smooth scroll.',
        'Mengembangkan REST API untuk autentikasi menggunakan JWT dengan fitur login, register, dan refresh token.',
        'Melakukan redesign pada halaman dashboard admin untuk meningkatkan user experience dan accessibility.',
        'Melakukan setup continuous integration dan continuous deployment menggunakan GitHub Actions.',
        'Melakukan migrasi database dan optimasi query untuk meningkatkan performa aplikasi.',
        'Mengintegrasikan payment gateway Midtrans untuk proses pembayaran online.',
        'Menulis unit test untuk module user dengan coverage minimal 80%.',
        'Membuat dokumentasi API lengkap menggunakan Swagger/OpenAPI specification.',
        'Develop tampilan login screen untuk aplikasi mobile dengan Flutter.',
        'Integrasi login menggunakan Google dan Facebook OAuth.',
        'Mengembangkan fitur chat real-time menggunakan WebSocket.',
        'Setup monitoring aplikasi menggunakan Prometheus dan Grafana.',
        'Melakukan optimasi performa website termasuk lazy loading dan caching.',
        'Membuat sistem generate report dalam format PDF yang bisa di-download.',
        'Implementasi push notification untuk web dan mobile application.',
        'Develop sistem keranjang belanja lengkap dengan kalkulasi harga dan diskon.',
        'Membuat email template responsive untuk berbagai keperluan notifikasi.',
        'Membuat dashboard visualisasi data menggunakan Chart.js atau D3.js.',
        'Develop sistem upload file dengan validasi tipe dan ukuran file.',
        'Implementasi sistem role dan permission untuk kontrol akses user.',
    ];

    public function run(): void
    {
        $this->command->info('Creating realistic data...');

        // Create Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@internhub.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $this->command->info('✓ Admin created');

        // Create Supervisors (Pembimbing)
        $supervisors = [];
        $supervisorNames = [
            ['Ir. Bambang Suryadi, M.Kom', 'bambang.suryadi@internhub.id'],
            ['Dr. Siti Nurhaliza, S.T., M.T.', 'siti.nurhaliza@internhub.id'],
            ['Drs. Agus Hermawan, M.Sc', 'agus.hermawan@internhub.id'],
        ];

        foreach ($supervisorNames as $data) {
            $supervisors[] = User::create([
                'name' => $data[0],
                'email' => $data[1],
                'password' => Hash::make('password'),
                'role' => 'pembimbing',
            ]);
        }

        $this->command->info('✓ 3 Supervisors created');

        // Create Interns
        $interns = [];
        $usedEmails = [];

        for ($i = 0; $i < 20; $i++) {
            $firstName = $this->firstNames[array_rand($this->firstNames)];
            $lastName = $this->lastNames[array_rand($this->lastNames)];
            $fullName = $firstName . ' ' . $lastName;

            // Generate unique email
            $emailBase = strtolower($firstName . '.' . $lastName);
            $email = $emailBase . '@student.id';
            $counter = 1;
            while (in_array($email, $usedEmails)) {
                $email = $emailBase . $counter . '@student.id';
                $counter++;
            }
            $usedEmails[] = $email;

            // Random start date within last 3 months
            $startDate = Carbon::now()->subMonths(rand(1, 3))->subDays(rand(0, 30));
            $endDate = $startDate->copy()->addMonths(rand(3, 6));

            // Determine status based on dates
            $status = 'active';
            if ($endDate->isPast()) {
                $status = 'completed';
            } elseif (rand(1, 20) === 1) {
                $status = 'cancelled';
            }

            $user = User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'intern',
            ]);

            $intern = Intern::create([
                'user_id' => $user->id,
                'nis' => 'NIS' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'school' => $this->schools[array_rand($this->schools)],
                'department' => $this->departments[array_rand($this->departments)],
                'phone' => '08' . rand(10, 99) . rand(1000000, 9999999),
                'address' => 'Jl. ' . $this->lastNames[array_rand($this->lastNames)] . ' No. ' . rand(1, 100) . ', Jakarta',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
                'supervisor_id' => $supervisors[array_rand($supervisors)]->id,
            ]);

            $interns[] = $intern;
        }

        $this->command->info('✓ 20 Interns created');

        // Create Task Assignments with proper intern assignments
        $activeInterns = collect($interns)->filter(fn($i) => $i->status === 'active')->values();
        $allStatuses = ['pending', 'in_progress', 'submitted', 'revision', 'completed'];

        for ($i = 0; $i < 8; $i++) {
            $deadline = Carbon::now()->addDays(rand(-7, 21));
            
            // Create the TaskAssignment
            $taskAssignment = TaskAssignment::create([
                'title' => $this->taskTitles[$i],
                'description' => $this->taskDescriptions[$i],
                'assigned_by' => $admin->id,
                'priority' => ['low', 'medium', 'high'][rand(0, 2)],
                'deadline' => $deadline,
                'deadline_time' => sprintf('%02d:00', rand(14, 18)),
                'estimated_hours' => rand(4, 24),
                'submission_type' => ['github', 'file', 'both'][rand(0, 2)],
                'assign_to_all' => $i < 2, // First 2 assignments are for all
            ]);

            // Determine which interns to assign
            if ($i < 2) {
                // Assign to all active interns
                $assignedInterns = $activeInterns;
            } else {
                // Assign to random subset (5-12 interns)
                $numToAssign = min(rand(5, 12), $activeInterns->count());
                $assignedInterns = $activeInterns->random($numToAssign);
            }

            // Attach interns to pivot table
            $taskAssignment->interns()->attach($assignedInterns->pluck('id'));

            // Create individual Task for each assigned intern
            foreach ($assignedInterns as $intern) {
                $status = $allStatuses[rand(0, 4)];

                // Determine timing based on status
                $isLate = false;
                $completedAt = null;
                $submittedAt = null;
                $startedAt = null;
                $approvedAt = null;
                $score = null;
                $feedback = null;

                if (in_array($status, ['in_progress', 'submitted', 'revision', 'completed'])) {
                    $startedAt = $deadline->copy()->subDays(rand(3, 10));
                }

                if ($status === 'submitted') {
                    $submittedAt = Carbon::now()->subDays(rand(0, 3));
                    $isLate = $submittedAt->isAfter($deadline);
                }

                if ($status === 'completed') {
                    $completedAt = Carbon::now()->subDays(rand(0, 7));
                    $submittedAt = $completedAt->copy()->subHours(rand(1, 24));
                    $approvedAt = $completedAt->copy()->addHours(rand(1, 48));
                    $isLate = $submittedAt->isAfter($deadline);
                    $score = rand(70, 100);
                    $feedback = $score >= 85
                        ? 'Kerja bagus! Hasilnya sesuai ekspektasi.'
                        : 'Sudah cukup baik, perlu sedikit improvement untuk kedepannya.';
                }

                if ($status === 'revision') {
                    $submittedAt = Carbon::now()->subDays(rand(1, 3));
                    $feedback = 'Perlu perbaikan pada bagian ' . ['UI/UX', 'validasi data', 'error handling', 'dokumentasi'][rand(0, 3)] . '.';
                }

                Task::create([
                    'task_assignment_id' => $taskAssignment->id,
                    'title' => $taskAssignment->title, // Same title as TaskAssignment
                    'description' => $taskAssignment->description, // Same description
                    'intern_id' => $intern->id,
                    'assigned_by' => $admin->id,
                    'priority' => $taskAssignment->priority, // Same priority
                    'status' => $status,
                    'deadline' => $deadline,
                    'deadline_time' => $taskAssignment->deadline_time,
                    'started_at' => $startedAt,
                    'submitted_at' => $submittedAt,
                    'completed_at' => $completedAt,
                    'approved_at' => $approvedAt,
                    'is_late' => $isLate,
                    'estimated_hours' => $taskAssignment->estimated_hours,
                    'submission_type' => $taskAssignment->submission_type,
                    'github_link' => $status !== 'pending' ? 'https://github.com/user/project-' . rand(100, 999) : null,
                    'score' => $score,
                    'admin_feedback' => $feedback,
                ]);
            }

            $this->command->info("  ✓ TaskAssignment '{$taskAssignment->title}' - {$assignedInterns->count()} interns assigned");
        }

        $this->command->info('✓ 8 Task Assignments with Tasks created');

        // Create Attendances (last 30 days)
        foreach ($interns as $intern) {
            if ($intern->status === 'cancelled') continue;

            $startDate = Carbon::now()->subDays(30);
            $endDate = Carbon::now();

            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                // Skip weekends
                if ($date->isWeekend()) continue;

                // Random attendance status with weights
                $rand = rand(1, 100);
                if ($rand <= 75) {
                    $status = 'present';
                    $checkIn = sprintf('%02d:%02d', 8, rand(0, 15));
                    $checkOut = sprintf('%02d:%02d', rand(16, 17), rand(0, 59));
                } elseif ($rand <= 88) {
                    $status = 'late';
                    $checkIn = sprintf('%02d:%02d', rand(8, 9), rand(16, 59));
                    $checkOut = sprintf('%02d:%02d', rand(16, 17), rand(0, 59));
                } elseif ($rand <= 94) {
                    $status = 'sick';
                    $checkIn = null;
                    $checkOut = null;
                } elseif ($rand <= 98) {
                    $status = 'permission';
                    $checkIn = null;
                    $checkOut = null;
                } else {
                    $status = 'absent';
                    $checkIn = null;
                    $checkOut = null;
                }

                Attendance::create([
                    'intern_id' => $intern->id,
                    'date' => $date->toDateString(),
                    'check_in' => $checkIn ? $date->copy()->setTimeFromTimeString($checkIn) : null,
                    'check_out' => $checkOut ? $date->copy()->setTimeFromTimeString($checkOut) : null,
                    'status' => $status,
                    'late_reason' => $status === 'late' ? ['Macet', 'Hujan deras', 'Kendaraan mogok', 'Keperluan keluarga'][rand(0, 3)] : null,
                    'notes' => in_array($status, ['sick', 'permission'])
                        ? ($status === 'sick' ? 'Sakit ' . ['flu', 'demam', 'migrain'][rand(0, 2)] : 'Keperluan keluarga')
                        : null,
                ]);
            }
        }

        $this->command->info('✓ Attendance records created');

        // Create Assessments for completed tasks
        $completedTasks = Task::where('status', 'completed')->get();

        foreach ($completedTasks as $task) {
            if (rand(1, 3) !== 1) continue; // Only assess some tasks

            Assessment::create([
                'intern_id' => $task->intern_id,
                'task_id' => $task->id,
                'assessed_by' => $admin->id,
                'quality_score' => rand(70, 100),
                'speed_score' => rand(65, 100),
                'initiative_score' => rand(60, 100),
                'teamwork_score' => rand(70, 100),
                'communication_score' => rand(65, 100),
                'strengths' => ['Problem solving yang baik', 'Tekun dan teliti', 'Komunikatif', 'Cepat belajar', 'Kreatif'][rand(0, 4)],
                'improvements' => ['Perlu lebih teliti', 'Time management', 'Dokumentasi bisa ditingkatkan', 'Komunikasi lebih aktif'][rand(0, 3)],
                'comments' => 'Secara keseluruhan menunjukkan perkembangan yang ' . ['baik', 'cukup baik', 'sangat baik'][rand(0, 2)] . '.',
            ]);
        }

        $this->command->info('✓ Assessments created');

        // Create Reports
        foreach ($interns as $intern) {
            if ($intern->status === 'cancelled') continue;

            // Weekly reports
            for ($w = 1; $w <= rand(2, 4); $w++) {
                $periodStart = Carbon::now()->subWeeks($w)->startOfWeek();
                $periodEnd = $periodStart->copy()->endOfWeek();

                Report::create([
                    'intern_id' => $intern->id,
                    'created_by' => $intern->user_id,
                    'title' => 'Laporan Mingguan - Minggu ke-' . $w,
                    'content' => 'Selama minggu ini saya telah mengerjakan beberapa tugas yang diberikan...',
                    'type' => 'weekly',
                    'period_start' => $periodStart,
                    'period_end' => $periodEnd,
                    'status' => ['draft', 'submitted', 'reviewed'][rand(0, 2)],
                    'feedback' => rand(0, 1) ? 'Laporan sudah cukup lengkap. Teruskan!' : null,
                ]);
            }
        }

        $this->command->info('✓ Reports created');
        $this->command->info('');
        $this->command->info('=== Data Seeding Complete ===');
        $this->command->info('Admin: admin@internhub.id / password');
        $this->command->info('Pembimbing: bambang.suryadi@internhub.id / password');
        $this->command->info('Intern: (any intern email) / password');
    }
}
