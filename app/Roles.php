<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    public function User(){
        return $this->belongsToMany(User::class, 'roles_has_users','roles_id','users_id')->withTimestamps();
    }
}
