<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserImport extends Model
{
    //
    protected $fillable = ['id', 'name', 'email', 'password', 'phone', 'role_id', 'department_id', 'signature', 'remember_token'];

    

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }


    public function role()
    {
        return$this->belongsTo('App\Role', 'role_id');
    }
}
