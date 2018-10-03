<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpiniaFileRequest;
use App\Http\Requests\OpiniaRequest;
use App\komentarz;
use App\Opinia;
use App\Pages;
use App\Pliki;
use App\RecenzenciArtykulow;
use App\Roles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Mockery\Exception;
use RealRashid\SweetAlert\Facades\Alert;

class RecenzentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function MojArtykul($page)
    {
        $MojArtykul=RecenzenciArtykulow::where([['pages_id',$page->id],['users_id',Auth::user()->id]])->first();
        if(isset($MojArtykul))return true;
        return false;

    }
    public function CzyJestRecenzja($page)
    {
        $recenzja=RecenzenciArtykulow::whereNull('recenzja_id')->where([['pages_id',$page->id],['users_id',Auth::user()->id]])->first();
        if(isset($recenzja))return true;
        return false;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $wystawione=Auth::user()->Recenzenci()->whereNotNull('recenzja_id')->groupBY('recenzenci_artykulows.pages_id')->orderBY('pages.id','DESC')->get();
        $do_wystawienia=Auth::user()->Recenzenci()->orderBY('id','DESC')->whereIn('recenzenci_artykulows.status',[1,2])->whereNull('recenzja_id')->get();
        return view('recenzent.index', compact('wystawione','do_wystawienia'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Pages $page)
    {
        if($this->MojArtykul($page)==true&&$this->CzyJestRecenzja($page)==true)
        {
            $autorzy=Pages::find($page->id)->Autorzy;
            $recenzent=Pages::find($page->id)->Recenzenci;
            $data = Pages::find($page->id)->data;
            $id=RecenzenciArtykulow::where([['pages_id',$page->id],['users_id',Auth::user()->id]])->whereNull('recenzja_id')->first();
            $komentarze=komentarz::where('pages_id',$page->id)->orderBY('created_at','DESC')->get();
            return view('recenzent.create', compact('page', 'autorzy', 'recenzent','id','data','komentarze'));
        }
        else {
            return Redirect::route('recenzent.index') ;
        }
    }

    public function createPlik(Pages $page)
    {
        if($this->MojArtykul($page)==true&&$this->CzyJestRecenzja($page)==true)
        {

            $id=RecenzenciArtykulow::where([['pages_id',$page->id],['users_id',Auth::user()->id]])->whereNull('recenzja_id')->first();
            if($id->status=2) {
                $autorzy=Pages::find($page->id)->Autorzy;
                $recenzent=Pages::find($page->id)->Recenzenci;
                $data = Pages::find($page->id)->data;
                $komentarze=komentarz::where('pages_id',$page->id)->orderBY('created_at','DESC')->get();
                return view('recenzent.createPlik', compact('page', 'autorzy', 'recenzent', 'id', 'data','komentarze'));
            }
            else
            {
                return Redirect::route('recenzent.index');
            }
        }
        else {
            return Redirect::route('recenzent.index') ;
        }
    }

    function akceptuj(RecenzenciArtykulow $id)
    {
        $id->update(['status'=>2]);
        return redirect()->back();;
    }
    function odrzuc(RecenzenciArtykulow $id)
    {

        $id->update(['status'=>3]);
        $user=User::where('id',$id->users_id)->select('name')->first();
        $title=Pages::select('title')->where('id',$id->pages_id)->first();
        $kto=Roles::find(1)->User()->pluck('email')->toArray();
       /* Mail::send('emails.odrzuconaRecenzja', ['user'=>$user,'title'=>$title], function ($m) use ($kto) {
            $m->from('systemstrona@gmail.com', 'System');
            $m->to($kto)->subject('Nie odda recenzji!');
        });*/
        $this->wszystkieOpinie($id);
        return Redirect::route('recenzent.index') ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OpiniaFileRequest $request, RecenzenciArtykulow $id)
    {

        $the_decision['A'] = "accept as is (editorial changes only, can be done by the editor)";
        $the_decision['B'] = "accept, requires changes by the author to be approved by the editor";
        $the_decision['C'] = "reject, substantial author's revisions needed before resubmission for another review";
        $the_decision['D'] = "decision delayed, MML revision needed";
        $the_decision['E'] = "reject, no hope of getting anything of value";

        $confidence['A'] = 'very confident';
        $confidence['B'] = 'quite confident';
        $confidence['C'] = 'not very confiden';

        $skala[0] = "very poor";
        $skala[1] = "poor";
        $skala[2] = "good";
        $skala[3] = "very good";

                $dane = file($request->opinia);

                $dane2 = implode('', file($request->opinia));
                $confiden = substr(str_replace(' ', '', $dane[14]), 11, 1);
                $decision = substr(str_replace(' ', '', $dane[19]), 12, 1);
                $presentation = substr(str_replace(' ', '', $dane[30]), 13, 1);
                $quality = substr(str_replace(' ', '', $dane[33]), 26, 1);
                $MML = substr(str_replace(' ', '', $dane[36]), 19, 1);
                $poz_justification = strRpos($dane2, 'Justification/comments (to be forwarded to the authors)') + 55;
                $poz_comments = strRpos($dane2, 'Comments to editors only') + 24;
                $poz_mml = strRpos($dane2, 'MML remarks') + 11;
                $comments= trim(substr($dane2, $poz_justification, $poz_comments - $poz_justification - 57));
                $comments_editors= trim(substr($dane2, $poz_comments, $poz_mml - $poz_comments - 44));
                $mml_remarks= substr($dane2, $poz_mml);

                $opinia= new Opinia();
                $opinia->confidence=$confidence[ucfirst($confiden)];
                $opinia->decision=$the_decision[ucfirst($decision)];
                $opinia->presentation=$skala[$presentation];
                $opinia->quality_of_formalization=$skala[$quality];
                $opinia->significance_for_mml=$skala[$MML];
                $opinia->comments=$comments;
                $opinia->comments_editors=$comments_editors;
                $opinia->mml_remarks=$mml_remarks;
                $opinia->save();
                $id->update(['status'=>2,'recenzja_id'=>$opinia->id]);

                $this->wszystkieOpinie($id);
                Alert::success('Success Title', 'Success Message');
                return Redirect::route('recenzent.index');




    }

    function storeFormularz(OpiniaRequest $request, RecenzenciArtykulow $id)
    {
        Opinia::create($request->all());
        $this->wszystkieOpinie($id);
        return Redirect::route('recenzent.index');
    }

    function wszystkieOpinie(RecenzenciArtykulow $id)
    {
        $dodane=RecenzenciArtykulow::where('pages_id',$id->pages_id)->whereNotNull('recenzja_id')->where('status',2)->count();
        if((RecenzenciArtykulow::where('pages_id',$id->pages_id)->whereIN('status',[1,2])->count())===$dodane && $dodane>=2)
        {
            Pages::where('id',$id->pages_id)->update(['status'=>3]);
            $title=Pages::select('title')->where('id',$id->pages_id)->first();
            $kto=Roles::find(1)->User()->pluck('email')->toArray();
           /* Mail::send('emails.wszystkieRecenzje', ['title'=>$title], function ($m) use ($kto) {
                $m->from('systemstrona@gmail.com', 'System');
                $m->to($kto)->subject('Wszystkie recenzje');
            });*/
        }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Pages $page)
    {
        if($this->MojArtykul($page)==true&&$this->CzyJestRecenzja($page)==false)
        {

            $recenzenci=RecenzenciArtykulow::where('pages_id',$page->id)->whereIn('status',[1,2])->orderBY('id','Desc')->get();
            $ilu=DB::table('recenzenci_artykulows')->select('t1.*','u.email','u.name')
                ->from(DB::raw("recenzenci_artykulows as t1,(SELECT t.users_id AS user, MAX(t.id) AS maxid FROM recenzenci_artykulows AS t where t.pages_id=".$page->id." GROUP BY user) AS t2, users AS u"))
                ->whereRaw('t1.users_id=t2.user and u.id=t2.user and t1.id=t2.maxid')
                ->get();
            $recenzje = Pages::find($page->id)->Opinia;
            $data = Pages::find($page->id)->data;
            $komentarze=komentarz::where('pages_id',$page->id)->orderBY('created_at','DESC')->get();

            return view('recenzent.show', compact('page',  'recenzenci', 'recenzje', 'data','ilu','komentarze'));}
        else {
            return Redirect::route('recenzent.index') ;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getDownload()
    {
        return response()->download('ref_form.txt');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
