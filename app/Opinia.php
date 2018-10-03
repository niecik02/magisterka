<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opinia extends Model
{
    protected $fillable=[
        'confidence','decision','presentation','quality_of_formalization','significance_for_mml','comments','comments_editors','mml_remarks'
    ];


}

