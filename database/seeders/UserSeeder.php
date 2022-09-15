<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'market1',
            'username' => 'market1',
            'email' => 'market1@market1.com',
            'password' => Hash::make('123456'),
        ]);
        User::create([
            'name' => 'market2',
            'username' => 'market2',
            'email' => 'market2@market2.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
