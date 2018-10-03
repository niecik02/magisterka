<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function pages(){
        return $this->hasMany(Pages::class, 'status');
    }
}
