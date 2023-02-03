<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\EmailUser;

class PerformanceMetricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $performance_metrics = \App\PerformanceMetric::paginate(10);
        return view('performance.index', compact('performance_metrics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        switch ($request->type)
        {
            case 'add_performance_metric':
                return $this->addPerformanceMetric($request);
            break;

            case 'disable_metric':
                return $this->metricDisable($request);
            break;

            case 'enable_metric':
                return $this->metricEnable($request);
            break;
            
            case 'assign_to_user':
                return $this->assignContractToUser($request);
            break;
            
            case 'rate_performance':
                return $this->rateContractPerformance($request);
            break;
            
            case 'view_rate_performance':
                return $this->viewRateContractPerformance($request);
            break;
            
            case 'rated_performance':
                return $this->ratedPerformance($request);
            break;
            
            case 'add_vendor':
                return $this->addVendor($request);
            break;


            
            default:
                # code...
            break;
        } 


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }








    public function addPerformanceMetric(Request $request)
    {
        //
        try
        {  
            $add = \App\PerformanceMetric::updateOrCreate
            (['id'=> $request->id],
            [              
                 'metric_name' => $request->metric_name,   
                 'weight' => $request->weight,
                 'created_by' => \Auth::user()->id,
             ]);

            return redirect()->route('performance.index')->with(['success'=>'Performance Metric Created Successfully']);
        } 
        catch (\Exception $e) 
        {
            return redirect()->route('performance.index')->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }

    public function assignContractToUser(Request $request)
    {
        try
        {  
            $add = \App\AssignContractToUser::updateOrCreate
            (['id'=> $request->id],
            [                 
                 'user_id' => $request->user_id,   
                 'requisition_id' => $request->requisition_id, 
                 'created_by' => \Auth::user()->id,
             ]);

             $user = \App\User::findOrFail($request->user_id);
             $requisition = \App\Requisition::findOrFail($request->requisition_id);
             $user->notify(new EmailUser($requisition));

             //updating REQUISITION STATUS TO ASSIGNED
            $data = array
            (
                'assigned' => '1', 'updated_at' => date('Y-m-d h:i:s')
            );
            \App\Requisition::where('id', $request->requisition_id)->update($data);


            return redirect()->route('contracts.requisitions')->with(['success'=>'Contract Assigned To User Successfully']);
        } 
        catch (\Exception $e) 
        {
            return redirect()->route('contracts.requisitions')->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }

    public function rateContractPerformance(Request $request)
    {
        // return $request->all();
        //
        try
        {  
            $contract = \App\Contract::findOrFail($request->contracted_id); 
            if(\Auth::user()->role_id == 5){ $type = 1; } else{ $type = 2; }
            //for loop to update all existing part items in workorderitem table for the related workordernumber
            $count = $request->count;  
            for($i = 1; $i <= $count; $i++)
            {
                //Rating
                $add = \App\ContractPerformance::updateOrCreate
                (['id'=> $request->id],
                [
                    'contract_id' => $request->contracted_id,   
                    'performance_metric_id' => $request->input('metric_'.$i.''),
                    'rating' => $request->input('rating_'.$i.''),
                    'user_type' => $type,
                    'user_id' => $contract->user_id,
                    'appraiser_id' => \Auth::user()->id,
                    'created_by' => \Auth::user()->id
                ]);             
            }

           return redirect()->route('contracts.index')->with(['success'=>'Contract Performance Has Been Rated Successfully']);
        } 
        catch (\Exception $e) 
        {
            return redirect()->route('contracts.index')->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }

    public function viewRateContractPerformance(Request $request)
    {
        // return $request->all();
        //
        try
        { 
            $contract = \App\Contract::findOrFail($request->contracted_id); 
            if(\Auth::user()->role_id == 3){ $type = 1; } else{ $type = 2; }
            //for loop to update all existing part items in workorderitem table for the related workordernumber
            $count = $request->count;  
            for($i = 1; $i <= $count; $i++)
            {
                //Rating
                $add = \App\ContractPerformance::updateOrCreate
                (['id'=> $request->id_],
                [
                    'contract_id' => $request->contracted_id,   
                    'performance_metric_id' => $request->input('metric_'.$i.''),
                    'rating' => $request->input('added_'.$i.''),
                    'user_type' => $type,
                    'user_id' => $contract->user_id,
                    'appraiser_id' => \Auth::user()->id,
                    'created_by' => \Auth::user()->id
                ]);             
            }

            return response()->json(['success'=>'Contract Performance Has Been Rated Successfully']);
        //    return redirect()->back()->with(['success'=>'Contract Performance Has Been Rated Successfully']);
        } 
        catch (\Exception $e) 
        {
            return response()->json(['error'=>'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
            // return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }

    public function RatedPerformance(Request $request)
    {
        // return $request->all();
        try
        {  
            $contract = \App\Contract::findOrFail($request->contract_id);
            $type = 1;   $count = $request->count;     $u_id = $request->u_id; 
            for($i = 1; $i <= $count; $i++)
            {
                //Rating
                $add = \App\ContractPerformance::updateOrCreate
                (['id'=> $request->input('idd_'.$u_id.'_'.$i.'')],
                [
                    'contract_id' => $request->contract_id,   
                    'performance_metric_id' => $request->input('metric_'.$i.''),
                    'rating' => $request->input('manager_'.$u_id.'_'.$i.''),
                    'user_type' => $type,
                    'user_id' => $contract->user_id,
                    'appraiser_id' => \Auth::user()->id,
                    'created_by' => \Auth::user()->id
                ]);             
            }       

            // return response()->json(['success'=>'Contract Performance Has Been Rated Successfully']);
            return redirect()->back()->with(['success'=>'Contract Performance Has Been Rated Successfully']);
        } 
        catch (\Exception $e) 
        {
            // return response()->json(['error'=>'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
            return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }


    public function getPerformanceMetricDetials(Request $request)
    {
        $metric = \App\PerformanceMetric::where('id', $request->id)->first();

        return response()->json($metric);
    }
    
    public function setMetricDetials(Request $request)
    {
        $ratings = \App\ContractPerformance::where('contract_id', $request->contract_id)->get();

        return response()->json($ratings);
    }

    
    public function metricDisable(Request $request)
    {
        try
        {  
            $data = array
            (
                'status_id' => '0', 'updated_at' => date('Y-m-d h:i:s')
            );
            \App\PerformanceMetric::where('id', $request->id)->update($data);

            return redirect()->route('performance.index')->with(['success'=>'Performance Metric Disabled Successfully']);
        }
        catch (\Exception $e) 
        {
            return  $e->getMessage();
        }

    }

    
    public function metricEnable(Request $request)
    {
        try
         {  
            $data = array
            (
                'status_id' => '1', 'updated_at' => date('Y-m-d h:i:s')
            );
            \App\PerformanceMetric::where('id', $request->id)->update($data);

            return redirect()->route('performance.index')->with(['success'=>'Performance Metric Reactivated Successfully']);
        }
        catch (\Exception $e) 
        {
            return  $e->getMessage();
        }

    }





    public function ratings(Request $request)
    {
      $search = $request->search;
      $column = $request->column;
      if(!$column){ $column = 'created_at'; }
      if ($search)
      {
        $contracts_paginated = \App\Contract::where('name', 'like', "%{$search}%")
                             ->orwhereHas('vendor', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orwhereHas('Status', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orwhereHas('user', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orwhereHas('contract_category', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orderBy($column, 'asc')->paginate(15);         
      }
      else
      {
        $contracts_paginated = \App\Contract::orderBy('id', 'desc')->paginate(15);
      }

        $metrics = \App\PerformanceMetric::all();        
        $contracts = \App\Contract::orderBy('id', 'desc')->with(['workflow'])->get();
        $stages = \App\Stage::where('workflow_id', '5')->get();

        return view('performance.ratings', compact('contracts_paginated', 'contracts', 'metrics', 'stages'));
    }

    public function vendors()
    {
        //
        $vendors = \App\Vendor::orderBy('id', 'desc')->paginate(15);
        return view('performance.vendors', compact('vendors'));
    }

    public  function getVendorDetials(Request $request)
    {
        $vendor = \App\Vendor::where('id', $request->id)->first();

        return response()->json($vendor);
    }

    public function addVendor(Request $request)
    {
        //
        try
        {  
            $add = \App\Vendor::updateOrCreate
            (['id'=> $request->id],
            [              
                 'name' => $request->name,   
                 'email' => $request->email,
                 'password' => bcrypt(substr($request->name, 0, 5).'@1234'),
                 'phone' => $request->phone,
                 'category' => $request->category,
                 'created_by' => \Auth::user()->id,
             ]);

            return redirect()->back()->with(['success'=>'New Vendor Created Successfully']);
        } 
        catch (\Exception $e) 
        {
            return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }

    
}
