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
        \App\Models\User::factory(10)->create();
        \App\Models\User::create([
            'name' => 'alex admin',
            'email' => 'alex.celmer@hotmail.com',
            'password' => bcrypt('12345678'),
            'is_admin' => 1,
        ]);
        \App\Models\User::create([
            'name' => 'alex gh',
            'email' => 'alex@agenciagh.com.br',
            'password' => bcrypt('12345678'),
            'is_admin' => 0,
        ]);

        $apps = \App\Models\Application::factory(20)->has(\App\Models\Collection::factory()->count(3))->create();
        // $collections = ->for($apps)->create();
    }
}
