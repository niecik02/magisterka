<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Roles;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $user = new User();
        $user->name='edytor';
        $user->email='edytor@gmail.com';
        $user->password=bcrypt('user');
        $user->save();
        $user->roles()->attach(1);
        
    }
}
