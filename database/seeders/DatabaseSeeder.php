<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Coach;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        DB::table('users')->insert([
            'name' => 'amabless',
            'firstname' => 'amabless',
            'middlename' => 'training',
            'lastname' => 'center',
            'email' => 'amabless.training@gmail.com',
            'password' => Hash::make('123qwe'),
            'userType' => 'Admin',
            'status' => 'enrolled'
        ]);

    }
}
