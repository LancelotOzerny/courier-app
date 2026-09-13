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
        User::query()->delete();

        User::query()->insert([
            ['login' => 'aleks', 'email' => 'aleks@example.test', 'phone' => '+79990000001', 'password_hash' => '$2y$12$J6q1BqR.3pw8/tXmXZnZz.Z9rxw/W3iLL16fVn4lyx2Tz/UAs4Czu', 'created_at' => now(), 'updated_at' => now()],
            ['login' => 'maria', 'email' => 'maria@example.test', 'phone' => '+79990000002', 'password_hash' => '$2y$12$zcISgiZzTE16rIgfeXdNBO5X7OZ31FgoMC/4XvlHqqn0ePfXs2zZ2', 'created_at' => now(), 'updated_at' => now()],
            ['login' => 'dmitry', 'email' => 'dmitry@example.test', 'phone' => '+79990000003', 'password_hash' => '$2y$12$nzea8EkeSmwXIDafaZ0be.MJtmsZmMyJdIKvDNDMaval.KQg8RVNi', 'created_at' => now(), 'updated_at' => now()],
            ['login' => 'sofia', 'email' => 'sofia@example.test', 'phone' => '+79990000004', 'password_hash' => '$2y$12$/aKlJ.JMWIVFScL3uqEXYeZxxOsrQh8aAyc3fc5zFo32lGICK0E8K', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
