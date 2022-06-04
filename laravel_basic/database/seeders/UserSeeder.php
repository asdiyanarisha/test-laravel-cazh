<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
 
        $user->name = "Administrator";
        $user->email = "admin@cazh.id";
        $user->password = Hash::make("cazh2022");
        $user->remember_token = hash('sha256', Str::random(128));
 
        $user->save();
    }
}
