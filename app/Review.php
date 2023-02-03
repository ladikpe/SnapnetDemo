<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Review extends Model
{
  /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'document_reviews';
  public function stage()
  {
    return $this->belongsTo('App\Stage');
  }
  public function document()
  {
    return $this->belongsTo('App\Document');
  }
  public function audit_logs()
  {
      return $this->morphMany('App\AuditLog', 'auditable');
  }
  // public function groups()
  // {
  //   return $this->belongsToMany('App\Group', 'folder_group_access', 'folder_id', 'group_id');
  // }
//   public function childfolders()
//     {
//         return $this->hasMany('App\Folder','parent_id');
//     }
//     public function parentfolder()
// {
//     return $this->belongsTo('App\Folder', 'parent_id');
// }



}
