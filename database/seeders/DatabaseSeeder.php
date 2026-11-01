<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $devEmail = env('DEVELOPER_EMAIL', 'dhoocin21@gmail.com');
        $devPassword = env('DEVELOPER_PASSWORD', '@Godonly1');
        $devName = env('DEVELOPER_NAME', 'Super Developer');

        // Update existing developer account or create if not exists
        $devUser = User::where('role', 'developer')
            ->orWhere('email', 'wahyukurniawan101630@gmail.com')
            ->first() ?? new User();

        $devUser->fill([
            'name' => $devName,
            'email' => $devEmail,
            'password' => bcrypt($devPassword),
            'role' => 'developer',
            'plan' => 'pro',
            'email_verified_at' => now(),
            'otp_code' => null,
            'otp_expires_at' => null,
        ]);
        $devUser->save();

        $this->call([
            \Database\Seeders\ProjectSeeder::class,
            \Database\Seeders\UpdateCarSpecificationsSeeder::class,
            \Database\Seeders\PostSeeder::class,
            \Database\Seeders\AnalyticsSeeder::class,
            \Database\Seeders\TestimonialSeeder::class,
        ]);

    }
}
