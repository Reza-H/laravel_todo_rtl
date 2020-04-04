<?php

use App\User;
use Illuminate\Database\Seeder;

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
            'name' => 'admin1',
            'email'=> 'admin@admin.com',
            'password' => bcrypt('adminadmin')
        ]);
        User::create([
            'name' => 'admin2',
            'email'=> 'admin2@admin.com',
            'password' => bcrypt('adminadmin')
        ]);
        User::create([
            'name' => 'admin3',
            'email'=> 'admin3@admin.com',
            'password' => bcrypt('adminadmin')
        ]);
        User::create([
            'name' => 'admin4',
            'email'=> 'admin4@admin.com',
            'password' => bcrypt('adminadmin')
        ]);
        User::create([
            'name' => 'admin5',
            'email'=> 'admin5@admin.com',
            'password' => bcrypt('adminadmin')
        ]);
        User::create([
            'name' => 'admin6',
            'email'=> 'admin6@admin.com',
            'password' => bcrypt('adminadmin')
        ]);
        User::create([
            'name' => 'admin7',
            'email'=> 'admin7@admin.com',
            'password' => bcrypt('adminadmin')
        ]);
        User::create([
            'name' => 'admin8',
            'email'=> 'admin8@admin.com',
            'password' => bcrypt('adminadmin')
        ]);
        User::create([
            'name' => 'admin9',
            'email'=> 'admin9@admin.com',
            'password' => bcrypt('adminadmin')
        ]);
        User::create([
            'name' => 'admin10',
            'email'=> 'admin10@admin.com',
            'password' => bcrypt('adminadmin')
        ]);
    }
}
