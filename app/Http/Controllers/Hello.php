<?php

namespace App\Http\Controllers;

use App\AutorzyArtykulow;
use App\dataRecenzji;
use App\Http\Requests\DataRequest;
use App\Http\Requests\HelloRequest;
use App\Http\Requests\KomentarzRequest;
use App\Http\Requests\RecenzentRequest;
use App\Http\Requests\UsersRequest;
use App\komentarz;
use App\Pages;
use App\RecenzenciArtykulow;
use App\Rules\users;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Response;
use File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Collection;
class Hello extends Controller
{
   /* public function __construct()
    {
        $this->middleware('auth');
    }*/
    /**dsd
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function users()
    {
        return User::pluck('name','id');
    }


    public function index()
    {
        //$dodane=Pages::find('dodana')->status();
            //->orderBY('created_at','DESC')->paginate(2);
        $wyznacz_recenzentow=Status::find(1)->pages()->orderBY('created_at','DESC')->get();
        $oczekujace_recenzje=Status::find(2)->pages()->orderBY('created_at','DESC')->get();
        $zaakceptowane=Status::find(4)->pages()->orderBY('created_at','DESC')->get();
        $do_akceptacji=Status::find(3)->pages()->orderBY('created_at','DESC')->get();
        $odrzucone=Status::find(5)->pages()->orderBY('created_at','DESC')->get();
        $dopoprawy=Status::find(6)->pages()->orderBY('created_at','DESC')->get();
        return view('hello.index', compact('wyznacz_recenzentow','oczekujace_recenzje','odrzucone','zaakceptowane','do_akceptacji','dopoprawy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Pages $page)
    {
        if ($page->status == 1) {
            $autorzy = Pages::find($page->id)->Autorzy;
            $recenzenci=DB::table('recenzenci_artykulows')->select('t1.*','u.name')
                ->from(DB::raw("recenzenci_artykulows as t1,(SELECT t.users_id AS user, MAX(t.id) AS maxid FROM recenzenci_artykulows AS t where t.pages_id=".$page->id." GROUP BY user) AS t2, users AS u"))
                ->whereRaw('t1.users_id=t2.user and u.id=t2.user and t1.id=t2.maxid')
                ->get();
            $a=array();
            foreach ($autorzy as $autor) {
                $a[]+= $autor->id;
            }
            foreach ($recenzenci as $recenzent) {
                if($recenzent->status==3) {
                    $a[] += $recenzent->id;
                }
            }
            $day   = date('d'); // dzień
            $month = date('m'); // miesiąc
            $year  = date('Y'); // rok
            $month++;
            if ($month == 13) {
                $month = 1;
                $year++;
            }
            $data=date('Y-m-d',strtotime($year.'-'.$month.'-'.$day));
            $users = User::  whereNotIn('id', $a)->pluck('name', 'id');
            $komentarze=komentarz::where('pages_id',$page->id)->orderBY('created_at','DESC')->get();
            return view('hello.create', compact('page', 'users', 'autorzy', 'pliki','komentarze','recenzenci','data'));
        }
        else{return redirect()->route('hello.index');}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HelloRequest $request, Pages $page)
    {
        $data= new dataRecenzji();
        $data->data=$request->data;
        $page->data()->save($data);
            $page->Recenzenci()->attach($request->users_id, ['status' => 1, 'id_rodzica' => 0]);
        $page->update(['status'=>2]);
        $recenzenci=Pages::find($page->id)->Recenzenci()->pluck('email')->toArray();

       /* Mail::send('emails.dodanieRecenzentow',['page'=>$page,'request'=>$request], function ($m) use ($recenzenci) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($recenzenci)->subject('Zostałeś Recenzentem!');
        });*/
        Alert::success('Dodano','Poprawnie dodano recenzentów!!!');
      return redirect()->route('hello.index');
    }


    /**
     * @param HelloRequest $request
     * @param Pages $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ponow(HelloRequest $request, Pages $page)
    {

        dataRecenzji::where('pages_id',$page->id)->update(['data'=>$request->data]);

        $recenzenci=DB::table('recenzenci_artykulows')->select('t1.*','u.name')
            ->from(DB::raw("recenzenci_artykulows as t1,(SELECT t.users_id AS user, MAX(t.id) AS maxid FROM recenzenci_artykulows AS t where t.pages_id=".$page->id." GROUP BY user) AS t2, users AS u"))
            ->whereRaw('t1.users_id=t2.user and u.id=t2.user and t1.id=t2.maxid')
            ->get();

        foreach ($request->users_id as $user)
        {

            foreach ($recenzenci as $recenzent)
            {
                if($recenzent->users_id==$user)
                {
                    $page->Recenzenci()->attach(['users_id'=>$user],['id_rodzica'=>$recenzent->id,'status'=>2]);
                }
            }

        }

        $page->update(['status'=>2]);
        $recenzenci_w=User::whereIn('id',$request->users_id)->pluck('email')->toArray();
        /*Mail::send('emails.dodanieRecenzentow',['page'=>$page,'request'=>$request], function ($m) use ($recenzenci_w) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($recenzenci_w)->subject('Zostałeś Recenzentem!');
        });*/
        Alert::success('Dodano','Poprawnie dodano recenzentów!!!');
        return redirect()->route('hello.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pages $page)
    {
        if ($page->status != 1) {
            $autorzy = Pages::find($page->id)->Autorzy;
            $recenzenci=RecenzenciArtykulow::where('pages_id',$page->id)->orderBY('id','Desc')->get();
            $ilu=DB::table('recenzenci_artykulows')->select('t1.*','u.email','u.name')
                ->from(DB::raw("recenzenci_artykulows as t1,(SELECT t.users_id AS user, MAX(t.id) AS maxid FROM recenzenci_artykulows AS t where t.pages_id=".$page->id." GROUP BY user) AS t2, users AS u"))
                ->whereRaw('t1.users_id=t2.user and u.id=t2.user and t1.id=t2.maxid')
                ->get();

            //dd($ilu->all());
            $recenzje = Pages::find($page->id)->Opinia;
            $data = Pages::find($page->id)->data;
            $komentarze=komentarz::where('pages_id',$page->id)->orderBY('created_at','DESC')->get();



            return view('hello.show', compact('page', 'autorzy', 'recenzenci', 'recenzje', 'data','komentarze','ilu'));
        }
        else {
            return Redirect::route('hello.index');
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param Pages $page
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Pages $page)
    {
        if($page->status=2)
        {
            $autorzy = Pages::find($page->id)->Autorzy;
            $recenzenci = Pages::find($page->id)->Recenzenci()->whereIn('status',[1,2])->orderBY('recenzenci_artykulows.id')->get();
            $data = Pages::find($page->id)->data;
            $a = array();
            foreach ($autorzy as $autor) {
                $a[] += $autor->id;
            }
            $users = User::  whereNotIn('id', $a)->pluck('name', 'id');
            $komentarze=komentarz::where('pages_id',$page->id)->orderBY('created_at','DESC')->get();
            return view('hello.edit', compact('page', 'autorzy', 'recenzenci', 'data', 'users','komentarze'));
        }
        return redirect()->route('hello.index');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pages $page)
    {
        $page->update($request->all());
        $autor = Pages::find($page->id)->Autorzy()->pluck('email')->toArray();
       /* Mail::send('emails.autorAkceptacja',['page'=>$page,'request'=>$request], function ($m) use ($autor) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($autor)->subject('Zmiana Statusu!');
        });*/
        return redirect()->route('hello.index');
    }

    public function poprawa(KomentarzRequest $request, Pages $page)
    {
        $page->update(['status'=>6]);
        $autor = Pages::find($page->id)->Autorzy()->pluck('email')->toArray();
        /*Mail::send('emails.autorPoprawa',['page'=>$page,'request'=>$request], function ($m) use ($autor) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($autor)->subject('Zmiana Statusu!');
        });*/
        $komentarz= new komentarz();
        $komentarz->pages_id=$page->id;
        $komentarz->status=2;
        $komentarz->komentarz=$request->komentarz;
        $komentarz->save();
        Alert::success('Wysłano','Poprawnie zmieniono status pracy!!!');
        return redirect()->route('hello.index');
    }

    public function odrzuc(KomentarzRequest $request, Pages $page)
    {
        $page->update(['status'=>5]);

        $autor = Pages::find($page->id)->Autorzy()->pluck('email')->toArray();
       /* Mail::send('emails.autor',['page'=>$page,'request'=>$request], function ($m) use ($autor) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($autor)->subject('Usunięta Praca!');
        });*/
        $komentarz= new komentarz();
        $komentarz->pages_id=$page->id;
        $komentarz->status=2;
        $komentarz->komentarz=$request->komentarz;
        $komentarz->save();
        Alert::success('Usunieto','Pomyślnie usunieto prace!!!');
        return redirect()->route('hello.index');
    }


    public function zmienDate(DataRequest $request, Pages $page)
    {

        if($page->status==2) {
            $page->data()->update(['data' => $request->data]);
            $recenzenci=Pages::find($page->id)->Recenzenci()->pluck('email')->toArray();
           /* Mail::send('emails.ZmianaDaty',['page'=>$page,'request'=>$request], function ($m) use ($recenzenci) {
                $m->from('systemstrona@gmail.com', 'System');
                $m->to($recenzenci)->subject('Zmiana Daty!');
            });*/
            Alert::success('Wykonano','Pomyślnie zmieniono date')->persistent('Zamknij');
            return Redirect::route('hello.index');
        }
        else
        {
            return Redirect::route('hello.index');
        }
    }

    public function editRecenzent(Pages $page)
    {
        if($page->status==2) {
            $autorzy = Pages::find($page->id)->Autorzy;
            $recenzenci = Pages::find($page->id)->Recenzenci()->orderBY('recenzenci_artykulows.id')->get();

            $data = Pages::find($page->id)->data;
            $recenzje = Pages::find($page->id)->Opinia;
            $a = array();
            foreach ($autorzy as $autor) {
                $a[] += $autor->id;
            }
            foreach ($recenzenci as $recenzent) {
                if($recenzent->pivot->status==3) {
                    $a[] += $recenzent->id;
                }
            }
            $users = User::  whereNotIn('id', $a)->pluck('name', 'id');
            $komentarze=komentarz::where('pages_id',$page->id)->orderBY('created_at','DESC')->get();
            return view('hello.editRecenzent', compact('page', 'autorzy', 'recenzenci','komentarze', 'recenzje', 'data', 'users'));
        }
        else
        {
            return Redirect::route('hello.index');
        }
    }

    public function updateRecenzent(RecenzentRequest $request, Pages $page)
    {
        $recezenci=RecenzenciArtykulow::whereNotNull('recenzja_id')->where('pages_id',$page->id)->get();
        foreach ($recezenci as $recenzent)
        {
            foreach ($request->users_id as $user)
            {
                if($recenzent->users_id==$user)
                {
                    Alert::error('Błąd', 'Użytkownik który wyznaczył recenzję powtarza się!!!')->persistent("Zamknij");;
                    return redirect()->back();
                }
            }
        }
        RecenzenciArtykulow::whereNull('recenzja_id')->where([['pages_id',$page->id],['status',1]])->delete();
        $page->Recenzenci()->attach($request->users_id,['status'=>1,'id_rodzica'=>0]);
        $recenzenci=Pages::find($page->id)->Recenzenci()->where([['status',1],['id_rodzica',0]])->whereNULL('recenzja_id')->pluck('email')->toArray();

        /*Mail::send('emails.dodanieRecenzentow',['page'=>$page,'request'=>$request], function ($m) use ($recenzenci) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($recenzenci)->subject('Zostałeś Recenzentem!');
        });*/
        Alert::success('Wykonano','Pomyślnie zmieniono Recenzentów')->persistent('Zamknij');
        return Redirect::route('hello.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Pages $page)
    {
        if($page->status==2)
        {
            RecenzenciArtykulow::where([['users_id', $request->users_id], ['pages_id', $page->id]])->delete();
            if (RecenzenciArtykulow::where('pages_id', $page->id)->count() == 0) {
                $page->update(['status' => 1]);
                dataRecenzji::where('pages_id',$page->id)->delete();
                return  Redirect::route('hello.index');
            }
            /*$page->Autorzy()->detach();
            $page->Recenzenci()->detach();
            $page->delete();*/

            return redirect()->back();
        }
        else
        {
            return  Redirect::route('hello.index');
        }
    }
    public function add(UsersRequest $request)
    {

        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $pasword=str_random(8);
        $users->password=bcrypt($pasword);
       /* Mail::send('emails.nowyUzytkownik',['haslo'=>$pasword,'login'=>$request->email], function ($m) use ($request) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($request->email)->subject('Nowy Użytkownik!');
        });*/
        $users->save();
        $users->roles()->attach(2);
        return response()->json($users);
    }

    public function statystyka(Request $request)
    { switch($request->sortuj){case 1: return 'DESC';break;case 2: return 'ASC';break;}
        //SELECT * FROM `pages` WHERE created_at>="2018-01-01" AND created_at<="2018-06-13 23:59:59"
        switch ($request->szukaj){
            case 0:
                $dane=emptyArray();
                $wszystko=1;
                $szukane=0;
                return view('hello.statystyka',compact('dane','wszystko','szukane'));
                break;
            case 1:
                $dane=DB::table('users')->select(DB::raw('f.id as id, COUNT(b.pages_id) as ilosc, f.name'))
                ->from(DB::raw('users as f,(SELECT a.pages_id, a.users_id from autorzy_artykulows as a,
                    (SELECT c.id as jak  from pages as c where c.status=4 and  c.created_at>"'.date("Y-m-d", strtotime($request->data_pocz)).'" AND c.created_at<"'.date("Y-m-d", strtotime($request->data_kon)).'")As d WHERE d.jak=a.pages_id) AS b'))
                    ->whereRaw('b.users_id=f.id ')
                    ->GroupBY('f.name')->orderBY('ilosc',$request->sortuj)->LIMIT($request->ilosc)
                ->get();
                $array=$dane->pluck('id')->toArray();
                $dane2=AutorzyArtykulow::select(DB::raw('count(users_id) as wszystkie, users_id as id'))->whereIn('users_id',$array)->groupBY('users_id')->get();
                $szukane=Pages::where([['status',4],['created_at','>',date("Y-m-d", strtotime($request->data_pocz))],['created_at','<',date("Y-m-d", strtotime($request->data_kon))]])->count();
                $wszystko=Pages::where([['created_at','>',date("Y-m-d", strtotime($request->data_pocz))],['created_at','<',date("Y-m-d", strtotime($request->data_kon))]])->count();

                return view('hello.statystyka',compact('dane','wszystko','szukane','dane2'));
                break;
            case 2:
                $dane=DB::table('users')->select(DB::raw('a.id as id,a.name, count(b.users_id) as ilosc'))
                ->from(DB::raw('users as a, recenzenci_artykulows as b'))
                ->whereRaw('b.users_id=a.id and b.created_at>"'.date("Y-m-d", strtotime($request->data_pocz)).'" AND b.created_at<"'.date("Y-m-d", strtotime($request->data_kon)).'" and b.recenzja_id Is NOT NULL GROUP BY a.name order BY ilosc '.$request->sortuj)->LIMIT($request->ilosc)->get();
                $array=$dane->pluck('id')->toArray();
                $dane2=RecenzenciArtykulow::select(DB::raw('count(users_id) as wszystkie, users_id as id'))->whereIn('users_id',$array)->groupBY('users_id')->get();
                $szukane=RecenzenciArtykulow::where([['created_at','>',date("Y-m-d", strtotime($request->data_pocz))],['created_at','<',date("Y-m-d", strtotime($request->data_kon))]])->whereNotNull('recenzja_id')->count();
                $wszystko=RecenzenciArtykulow::where([['created_at','>',date("Y-m-d", strtotime($request->data_pocz))],['created_at','<',date("Y-m-d", strtotime($request->data_kon))]])->count();

                return view('hello.statystyka',compact('dane','wszystko','szukane','dane2'));
                break;
            case 3:
                $dane=DB::table('users')->select(DB::raw('f.id as id,COUNT(f.id) as ilosc, f.name'))
                    ->from(DB::raw('users as f,(SELECT a.pages_id, a.users_id from autorzy_artykulows as a,(SELECT c.id from pages as c where c.status=5 and c.created_at>"'.date("Y-m-d", strtotime($request->data_pocz)).'" AND c.created_at<"'.date("Y-m-d", strtotime($request->data_kon)).'")As d WHERE d.id=a.pages_id) AS b'))
                    ->whereRaw('b.users_id=f.id')
                    ->GroupBY('f.name')->orderBY('ilosc',$request->sortuj)->LIMIT($request->ilosc)
                    ->get();
                $array=$dane->pluck('id')->toArray();
                $dane2=AutorzyArtykulow::select(DB::raw('count(users_id) as wszystkie, users_id as id'))->whereIn('users_id',$array)->groupBY('users_id')->get();
                $szukane=Pages::where([['status',5],['created_at','>',date("Y-m-d", strtotime($request->data_pocz))],['created_at','<',date("Y-m-d", strtotime($request->data_kon))]])->count();
                $wszystko=Pages::where([['created_at','>',date("Y-m-d", strtotime($request->data_pocz))],['created_at','<',date("Y-m-d", strtotime($request->data_kon))]])->count();

                return view('hello.statystyka',compact('dane','wszystko','szukane','dane2'));
                break;
            case 4:
                $dane=DB::table('users')->select(DB::raw('a.id as id,a.name, count(b.users_id) as ilosc'))
                    ->from(DB::raw('users as a, recenzenci_artykulows as b'))
                    ->whereRaw('b.users_id=a.id and b.status=3 and b.created_at>"'.date("Y-m-d", strtotime($request->data_pocz)).'" AND b.created_at<"'.date("Y-m-d", strtotime($request->data_kon)).'" GROUP BY a.name order BY ilosc '.$request->sortuj)->LIMIT($request->ilosc)->get();
                $szukane=RecenzenciArtykulow::where([['status',3],['created_at','>',date("Y-m-d", strtotime($request->data_pocz))],['created_at','<',date("Y-m-d", strtotime($request->data_kon))]])->count();
                $wszystko=RecenzenciArtykulow::where([['created_at','>',date("Y-m-d", strtotime($request->data_pocz))],['created_at','<',date("Y-m-d", strtotime($request->data_kon))]])->count();
                $array=$dane->pluck('id')->toArray();
                $dane2=RecenzenciArtykulow::select(DB::raw('count(users_id) as wszystkie, users_id as id'))->whereIn('users_id',$array)->groupBY('users_id')->get();

                return view('hello.statystyka',compact('dane','wszystko','szukane','dane2'));
                break;
            case 5;
                $dane=DB::table('users')->select(DB::raw('f.id as id,COUNT(f.id) as ilosc, f.name'))
                    ->from(DB::raw('users as f,(SELECT a.pages_id, a.users_id from autorzy_artykulows as a,
                    (SELECT c.id from pages as c where c.created_at>"'.date("Y-m-d", strtotime($request->data_pocz)).'" AND c.created_at<"'.date("Y-m-d", strtotime($request->data_kon)).'")As d WHERE d.id=a.pages_id) AS b'))
                    ->whereRaw('b.users_id=f.id')
                    ->GroupBY('f.name')->orderBY('ilosc', $request->sortuj)->LIMIT($request->ilosc)
                    ->get();
                $szukane=Pages::where([['created_at','>',date("Y-m-d", strtotime($request->data_pocz))],['created_at','<',date("Y-m-d", strtotime($request->data_kon))]])->count();
                $wszystko=Pages::count();
                $array=$dane->pluck('id')->toArray();
                $dane2=AutorzyArtykulow::select(DB::raw('count(users_id) as wszystkie, users_id as id'))->whereIn('users_id',$array)->groupBY('users_id')->get();

                //dd($dane);
                return view('hello.statystyka',compact('dane','wszystko','szukane','dane2'));
                break;


        }

    }


}
