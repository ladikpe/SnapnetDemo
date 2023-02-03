<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    //
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
      return $this->hasMany('App\Review');
    }
    public function folder()
    {
      return $this->belongsTo('App\Folder','folder_id');
    }
    public function tags()
    {
      return $this->belongsToMany('App\Tag');
    }
    public function audit_logs()
    {
        return $this->morphMany('App\AuditLog', 'auditable');
    }
}
