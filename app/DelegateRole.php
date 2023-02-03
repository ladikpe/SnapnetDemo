<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DelegateRole extends Model
{
    //
    protected $fillable=['department_id', 'prev_dept_head_id', 'user_id', 'role_id', 'end_date', 'delegated_by'];
   
    
    public function department()
    {
        return $this->belongsTo('\App\Department','department_id');
    }
    
    public function prev_dept_head()
    {
        return $this->belongsTo('\App\User','prev_dept_head_id');
    }
    
    public function delegate()
    {
        return $this->belongsTo('\App\User','user_id');
    }
    
    public function role()
    {  
        return $this->belongsTo('\App\Role','role_id');
    }
    
    public function delegator()
    {
        return $this->belongsTo('\App\User','delegated_by');
    }
}
