<?php

namespace Database\Seeders;

use App\Models\TrainingPackage;
use Illuminate\Database\Seeder;
use Database\Seeders\TrainingPackageSeeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'user_name' => 'admin',
            'password' => Hash::make('gadai')
        ]);
    }
}
