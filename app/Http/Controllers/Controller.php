<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function mail($users, $view,$page){
        /*Mail::send($view, ['user' => $users,'page'=>$page], function ($m) use ($users) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to(['niecik92@gmail.com','paulinaniebrzydowska@gmail.com'])->subject('Nowa Praca!');
        });*/
    }


}
