<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class komentarz extends Model
{
    protected $fillable=[
        'komentarz','pages_id','status'
        ];


}
