<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerformanceMetric extends Model
{
    //
    protected $fillable=['metric_name', 'weight', 'status_id', 'created_by'];

    
    public function ContractPerformance()
    {
        return $this->hasMany('\App\ContractPerformance', 'performance_metric_id');
    }
    
}
