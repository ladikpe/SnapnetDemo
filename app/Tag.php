<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
 	protected $fillable=['id', 'name'];

  public function documents()
  {
    return $this->belongsToMany('App\Document');
  }
  public function contracts()
  {
    return $this->belongsToMany('App\Contract');
  }
}
