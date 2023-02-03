<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractPerformance extends Model
{
    //
    protected $fillable = ['contract_id', 'performance_metric_id', 'rating', 'user_type', 'user_id', 'appraiser_id', 'created_by'];


    
    public function contract()
    {
       return $this->belongsTo('\App\Contract', 'contract_id');
    }
    
    public function metric()
    {
       return $this->belongsTo('\App\PerformanceMetric', 'performance_metric_id');
    }
    
    public function author()
    {
       return $this->belongsTo('\App\User', 'created_by');
    }
    
    public function user()
    {
       return $this->belongsTo('\App\User', 'user_id');
    }
    
    public function appriaser()
    {
       return $this->belongsTo('\App\User', 'appriaser_id');
    }
}
