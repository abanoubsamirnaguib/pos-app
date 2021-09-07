<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use  App\Models\User;

class UserTableSeederr extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $user=User::create([
            'First_name'=>'Super',
            'Last_name'=>'Admin',
            'email'=>'super_admin@app.com',
            'password'=>bcrypt('123456')
        ]);

        $user->attachRole('super_admin');
    }
}
