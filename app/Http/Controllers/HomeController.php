<?php

namespace App\Http\Controllers;

use App\RecenzenciArtykulow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recenzje=RecenzenciArtykulow::where([['users_id',Auth::user()->id],['status','!=',3]])->count();
        return view('home',compact('recenzje'));
    }
}
