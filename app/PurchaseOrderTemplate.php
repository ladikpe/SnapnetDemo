<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderTemplate extends Model
{
    //
    protected $fillable = ['id', 'name', 'contents', 'status_id', 'created_by'];
}
