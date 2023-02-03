<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'deleted_at', 'created_by'];

    protected $dates = ['deleted_at'];


    public function users()
    {
      return $this->belongsToMany(App\User::class);
    }

    public function permission()
    {
    	return $this->belongsToMany('App\Permission', 'user_role', 'role_id', 'user_id');
    }
}
