<?php

namespace App\Http\Controllers;

use App\AutorzyArtykulow;
use App\Http\Requests\FileRequest;
use App\Http\Requests\KomentarzRequest;
use App\Http\Requests\UpdateFileRequest;
use App\komentarz;
use App\Pages;
use App\Pliki;
use App\RecenzenciArtykulow;
use App\Roles;
use App\Rules\mizar;
use App\Rules\users;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class AutorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function MojArtykul($page)
    {
        $MojArtykul=Pages::find($page->id)->Autorzy;

        foreach($MojArtykul as $Artykul)
        {
            if ($Artykul->id == Auth::user()->id) {

                return true;
            }

        }
        return false;
    }
    public function index()
    {
        $pages=Auth::user()->Autorzy()->orderBY('id','DESC')->get();
        $statusy=Status::all();
        return view('autor.index', compact('pages','statusy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$users=User::pluck('name','id');
        return  view('autor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pages $page)
    {
       if($this->MojArtykul($page)==true){
           $recenzenci=RecenzenciArtykulow::where('pages_id',$page->id)->whereIn('status',[1,2])->orderBY('id','Desc')->get();
           $data = Pages::find($page->id)->data;
           $recenzje = Pages::find($page->id)->Opinia;
           $status=Pages::find($page->id)->Status;
           $ilu=DB::table('recenzenci_artykulows')->select('t1.*','u.email','u.name')
               ->from(DB::raw("recenzenci_artykulows as t1,(SELECT t.users_id AS user, MAX(t.id) AS maxid FROM recenzenci_artykulows AS t where t.pages_id=".$page->id." GROUP BY user) AS t2, users AS u"))
               ->whereRaw('t1.users_id=t2.user and u.id=t2.user and t1.id=t2.maxid')
               ->get();
           $komentarze=komentarz::where('pages_id',$page->id)->orderBY('created_at','DESC')->get();
           return view('autor.show',compact('page','recenzenci','data','recenzje','status','komentarze','ilu'));
       }
      else
      {
           return Redirect::route('autor.index') ;
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Pages $page)
    {
        if($this->MojArtykul($page)==true&&$page->status==6)
        {
            $recenzenci=RecenzenciArtykulow::where('pages_id',$page->id)->whereIn('status',[1,2])->orderBY('id','Desc')->get();
            $data = Pages::find($page->id)->data;
            $recenzje = Pages::find($page->id)->Opinia;

            $ilu=DB::table('recenzenci_artykulows')->select('t1.*','u.email','u.name')
                ->from(DB::raw("recenzenci_artykulows as t1,(SELECT t.users_id AS user, MAX(t.id) AS maxid FROM recenzenci_artykulows AS t where t.pages_id=".$page->id." GROUP BY user) AS t2, users AS u"))
                ->whereRaw('t1.users_id=t2.user and u.id=t2.user and t1.id=t2.maxid')
                ->get();
            $komentarze=komentarz::where('pages_id',$page->id)->orderBY('created_at','DESC')->get();
            return view('autor.edit',compact('page','recenzenci','data','recenzje','users','komentarze','ilu'));
        }
        else
        {
            return Redirect::route('autor.index') ;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFileRequest $request, Pages $page)
    {

        File::delete($page->plik_miz);
        File::delete($page->plik_bib);
        File::delete($page->plik_voc);
        $edytor = Pages::find($page->id)->Autorzy()->pluck('email')->toArray();
        /*Mail::send('emails.edytorPoprawa',['page'=>$page], function ($m) use ($edytor) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($edytor)->subject('Zmiana Statusu!');
        });*/
        $file = $request->file('plik_miz') ;
        $file2= $request->file('plik_bib');
        $file3=$request->file('plik_voc');

        $patch=$file->move('miz', str_replace_last($file->extension(),$file->getClientOriginalExtension(),$file->hashName()));
        $patch2=$file2->move('bib', str_replace_last($file2->extension(),$file2->getClientOriginalExtension(),$file2->hashName()));


        if(isset($file3))
        {
            $patch3=$file3->move('plik_voc', str_replace_last($file3->extension(),$file3->getClientOriginalExtension(),$file3->hashName()));
            $page->update(['plik_miz'=>$patch,'plik_bib'=>$patch2,'plik_voc'=>$patch3,'status'=>1]);
        }
        else
        {
            $page->update(['plik_miz'=>$patch,'plik_bib'=>$patch2,'status'=>1]);
        }
        $edytor = Pages::find($page->id)->Autorzy()->pluck('email')->toArray();
        /*Mail::send('emails.edytorPoprawa',['page'=>$page,'request'=>$request], function ($m) use ($edytor) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($edytor)->subject('Zmiana Statusu!');
        });*/
        Alert::success('Pomyślnie Zaaktualizowano','');
        return Redirect::route('autor.index');

    }

    function odpowiedz(KomentarzRequest $request, Pages $page)
    {
        $edytor = Pages::find($page->id)->Autorzy()->pluck('email')->toArray();
        /*Mail::send('emails.edytorPoprawa',['page'=>$page,'request'=>$request], function ($m) use ($edytor) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($edytor)->subject('Zmiana Statusu!');
        });*/
        $komentarz= new komentarz();
        $komentarz->pages_id=$page->id;
        $komentarz->status=1;
        $komentarz->komentarz=$request->komentarz;
        $komentarz->save();
        $page->update(['status'=>1]);
        return Redirect::route('autor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     */
    public function UploadFile(FileRequest $request) {

        //$kto=['niecik02@o2.pl','niecik92@gmail.com'];
        $kto=Roles::find(1)->User()->pluck('email')->toArray();
        /*Mail::send('emails.edytor', ['request'=>$request], function ($m) use ($kto) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($kto)->subject('Nowa Praca!');
        });*/

        $file = $request->file('plik_miz') ;
        $file2= $request->file('plik_bib');
        $file3=$request->file('plik_voc');
            $patch=$file->move('miz', str_replace_last($file->extension(),$file->getClientOriginalExtension(),$file->hashName()));
            $patch2=$file2->move('bib', str_replace_last($file2->extension(),$file2->getClientOriginalExtension(),$file2->hashName()));

            if(isset($file3))
            {
                $patch3=$file3->move('voc', str_replace_last($file3->extension(),$file3->getClientOriginalExtension(),$file3->hashName()));
                $page=Pages::create(['title'=>$request->title,'status'=>1,'plik_miz'=>$patch,'plik_bib'=>$patch2,'plik_voc'=>$patch3]);
            }
            else
            {
                $page=Pages::create(['title'=>$request->title,'status'=>1,'plik_miz'=>$patch,'plik_bib'=>$patch2]);
            }
            $page->Autorzy()->attach(Auth::user()->id);

        Alert::success('Dodany', 'Pomyślnie dodano nowy artykuł');
        return Redirect::route('autor.index');
    }





}
