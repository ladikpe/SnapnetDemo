<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Group;

class Group extends Model
{
  public function users()
  {
    return $this->belongsToMany('App\User', 'group_user', 'group_id', 'user_id');
  }
  public function audit_logs()
  {
      return $this->morphMany('App\AuditLog', 'auditable');
  }

  public function contracts()
    {
        return $this->belongsToMany('\App\Contract','contract_group_access','group_id','contract_id')->withPivot('permission_id');
    }
}
