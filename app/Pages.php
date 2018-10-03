<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    protected $fillable=[
        'title','status','plik_voc','plik_miz','plik_bib'
    ];

    public function Autorzy(){
        return $this->belongsToMany(User::class,'autorzy_artykulows','pages_id','users_id')->withTimestamps();
    }
    public function Recenzenci(){
        return $this->belongsToMany(User::class,'recenzenci_artykulows','pages_id','users_id')->withTimestamps()->withPivot('recenzja_id','status','id','id_rodzica');
    }

    public function Opinia(){
        return $this->belongsToMany(Opinia::class, 'recenzenci_artykulows','pages_id','recenzja_id')->withPivot('users_id');
    }

    public function status(){
        return $this->belongsTo(Status::class,'status');
    }




    public function data(){
        return $this->hasOne(dataRecenzji::class,'pages_id');
    }
}
