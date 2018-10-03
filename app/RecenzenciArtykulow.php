<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecenzenciArtykulow extends Model
{
    protected $fillable=[
        'users_id','pages_id','status','recenzja_id','id_rodzica'
    ];
    public function Opinia(){
        return $this->belongsToMany(Opinia::class, 'recenzenci_artykulows','pages_id','recenzja_id')->withPivot('users_id');
    }

    public function pages(){
        return $this->hasOne(Pages::class,'pages_id');
    }
}
