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
         \App\Models\User::factory(24)->create();
         \App\Models\Messages::factory(50)->create();
         \App\Models\Replies::factory(70)->create();
    }
}
