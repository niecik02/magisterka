<?php

use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = new \App\Status();
        $status->status='Złożony';
        $status->save();

        $status = new \App\Status();
        $status->status='Oczekuje na recenzje';
        $status->save();

        $status = new \App\Status();
        $status->status='Oczekiwanie na akceptacje';
        $status->save();

        $status = new \App\Status();
        $status->status='Zaakceptowany';
        $status->save();

        $status = new \App\Status();
        $status->status='Odrzucony';
        $status->save();

        $status = new \App\Status();
        $status->status='Do Poprawy';
        $status->save();

        $status = new \App\Status();
        $status->status='Poprawiony';
        $status->save();
    }
}
