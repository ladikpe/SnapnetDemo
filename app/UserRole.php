<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    //
    protected $fillable = ['user_id', 'role_id', 'created_by'];



    public function user()
    {
      return $this->belongsToMany('App\User', 'user_id');
    }

    public function role()
    {
      return $this->belongsToMany('App\Role', 'role_id');
    }

    public function UserRole()
    {
      return $this->belongsToMany('App\UserRole', 'user_id');
    }
}
