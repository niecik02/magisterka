<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role= new \App\Roles();
        $role->name='Edytor';
        $role->save();

        $role= new \App\Roles();
        $role->name='Uzytkownik';
        $role->save();


    }
}
