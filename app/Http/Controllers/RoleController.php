<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZmienHasloRequest;
use App\Http\Requests\ZmienImieRequest;
use App\Roles;
use App\RolesHasUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd(Auth::user()->id);
        $edytorzy=Roles::find(1)->User()->whereNotIn('users.id', [Auth::user()->id])->get();
        //dd($edytorzy->all());
        $uzytkownicy=Roles::find(2)->User;
        return view('uzytkownicy.index', compact('edytorzy','uzytkownicy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function zmienImie(ZmienImieRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->get('imie');
        $user->save();
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::find($id)->roles;
        dd($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        RolesHasUsers::where('users_id',$request->users_id)->update(['roles_id'=>$request->roles_id]);
        Alert::success('Wykonano','Pomyślnie zmieniono rolę użytkownikowi')->persistent('Zamknij');
        return redirect(route('uzytkownicy.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function zmiendane()
    {
        $uzytkownik=User::where('id',Auth::user()->id)->first();
        return view('uzytkownicy.zmiendane',compact('uzytkownik'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ZmienHasloRequest $request
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function zmienHaslo(ZmienHasloRequest $request)
    {
        $user = Auth::user();
        $user->password = bcrypt($request->get('nowe'));
        $user->save();
        return response()->json($user);
    }
}
