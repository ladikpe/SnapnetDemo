<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
  public function user()
  {
      return $this->belongsTo('App\User');
  }

  public function workflow()
  {
      return $this->belongsTo('App\Workflow');
  }

  public function reviews()
  {
    return $this->hasMany('App\Stage');
  }
  
  public function audit_logs()
  {
      return $this->morphMany('App\AuditLog', 'auditable');
  }
}
