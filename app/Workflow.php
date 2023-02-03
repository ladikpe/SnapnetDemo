<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Workflow extends Model
{
  public function stages()
  {
    return $this->hasMany('App\Stage', 'workflow_id')->orderBy('position', 'asc');
  }
  public function documents()
  {
    return $this->hasMany('App\Document');
  }
  public function audit_logs()
  {
      return $this->morphMany('App\AuditLog', 'auditable');
  }

}
