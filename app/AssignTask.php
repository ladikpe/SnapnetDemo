<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignTask extends Model
{
    //
    protected $fillable=['document_id', 'previous_user_id', 'user_id', 'action', 'end_date', 'created_by'];
   
    
    public function document()
    {
        return $this->belongsTo('\App\Requisition','document_id');
    }
    
    public function delegate()
    {
        return $this->belongsTo('\App\User','user_id');
    }
    
    public function prev_delegate()
    {
        return $this->belongsTo('\App\User','previous_user_id');
    }
    
    public function author()
    {
        return $this->belongsTo('\App\User','created_by');
    }
}
