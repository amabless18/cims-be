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
        $users = User::all();

        $bulkData = [];

        User::factory(10)->create();

        
        foreach ($users as $user) {
            $bulkData[] = [
                'firstname' => 'Amabless',
                'lastname' => 'Training Center',
                'user_id' => $user->id,
            ];
        }

        DB::table('students')->insert($bulkData);


        //CoachSeeder

        foreach ($users as $user) {
            $bulkData[] = [
                'firstname' => 'Amabless',
                'lastname' => 'Training Center',
                'user_id' => $user->id,
            ];
        }

        DB::table('coaches')->insert($bulkData);

    }
}
