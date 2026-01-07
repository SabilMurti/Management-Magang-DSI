<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Intern;
use App\Models\Task;
use App\Models\TaskAssignment;
use App\Models\Attendance;
use App\Models\Report;
use App\Models\Assessment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@magang.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Pembimbing
        $pembimbing = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.pembimbing@magang.com',
            'password' => Hash::make('password'),
            'role' => 'pembimbing',
        ]);

        $pembimbing2 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti.pembimbing@magang.com',
            'password' => Hash::make('password'),
            'role' => 'pembimbing',
        ]);

        $this->command->info('');
        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('📋 Login Credentials:');
        $this->command->info('   Admin: admin@magang.com / password');
        $this->command->info('   Pembimbing: budi.pembimbing@magang.com / password');
        $this->command->info('   (Data Siswa Kosong - Silakan input manual)');
        $this->command->info('');
    }
}
