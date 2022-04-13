<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            "name" => "Admin",
            "email" => 'admin@gmail.com',
            "password" => bcrypt('12345'),
        ]);
        \App\Models\User::factory(4)->create();
        \App\Models\Task::factory(30)->create();
    }
}
