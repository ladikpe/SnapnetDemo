<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
 	protected $fillable=['name', 'department_head_id', 'description', 'created_by'];
   
    
    public function department_head()
    {
    	return $this->belongsTo('\App\User','department_head_id');
    }
    
    public function author()
    {
    	return $this->belongsTo('\App\User','created_by');
    }
}
