<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Folder extends Model
{
  /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tree_data';
    public function documents()
    {
      return $this->hasMany('App\Document', 'folder_id');
    }
  public function users()
  {
    return $this->belongsToMany('App\User', 'folder_user_access', 'folder_id', 'user_id');
  }
  public function groups()
  {
    return $this->belongsToMany('App\Group', 'folder_group_access', 'folder_id', 'group_id');
  }
  public function getNameAttribute()
  {
    return "{$this->nm}";
  }
  public function audit_logs()
  {
      return $this->morphMany('App\AuditLog', 'auditable');
  }
//   public function childfolders()
//     {
//         return $this->hasMany('App\Folder','parent_id');
//     }
//     public function parentfolder()
// {
//     return $this->belongsTo('App\Folder', 'parent_id');
// }



}
