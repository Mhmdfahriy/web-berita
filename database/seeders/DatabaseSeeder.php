<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       Role::create(['name' => 'Admin']);
       Role::create(['name' => 'Member']);

       $admin = User::create([
         'name' => 'Admin',
         'email' => 'admin@gmail.com',
         'password' => bcrypt('admin1234'),
       ]);

       $admin->assignRole('Admin'); 

       $member = User::create([
        'name' => 'Member',
        'email' => 'member@gmail.com',
        'password' => bcrypt('member1234'),
      ]);

        $member->assignRole('Member');

      Category::create(['name' => 'Sport']);
      Category::create(['name' => 'Politic']);
      Category::create(['name' => 'LifeStyle']);
    }
}
