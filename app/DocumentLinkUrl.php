<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentLinkUrl extends Model
{
    //
    protected $fillable = ['user_id', 'vendor_email', 'file_name', 'file_path', 'link_url', 'comment', 'created_by'];



    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function author()
    {
      return $this->belongsTo('App\Role', 'created_by');
    }
}
