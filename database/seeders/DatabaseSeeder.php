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

        $apps = \App\Models\Application::factory(2)->hasUsers(2)->create();
        $collections = \App\Models\Collection::factory(2)->forApplication()->create();
        // $apps_user = \App\Models\User::factory(2)->hasApplications()->create();
        // $apps = \App\Models\Application::get();
        // foreach ($apps as $value) {
        // }
        // $collections = \App\Models\Collection::get();
    }
}
