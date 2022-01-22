<?php

namespace Database\Seeders;

use App\Models\LordCards;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Database\Factories\FamilyNameFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'username' => 'a',
        //     'email' => 'a@gmail.com',
        //     'password' => Hash::make('azeazeaze'),
        // ]);

    }
}
