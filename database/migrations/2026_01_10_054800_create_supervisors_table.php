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
        Schema::create('supervisors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nip')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('institution')->nullable();
            $table->enum('status', ['pending', 'active'])->default('active');
            $table->timestamps();
        });

        // Migrate existing pembimbing users to supervisors table
        $pembimbings = \DB::table('users')->where('role', 'pembimbing')->get();
        foreach ($pembimbings as $pembimbing) {
            \DB::table('supervisors')->insert([
                'user_id' => $pembimbing->id,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisors');
    }
};
