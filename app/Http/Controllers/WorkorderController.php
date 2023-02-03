<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
// use App\Http\Controllers\Controller;

class WorkorderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function __construct()
    {
        $this->middleware('auth');
    }




    public function order_number($count, $pre)
    {
        //$dated = getdate();
        $number = '';
        $number .= $pre;
        //$number .= $dated['year'];
        if($count < 10) {           $number .= '-0000'; }
        else if($count >= 10){      $number .= '-000';  }
        else if($count >= 100){     $number .= '-00';   }
        else if($count >= 1000){    $number .= '-0';    }
        else if($count >= 10000){   $number .= '-';     }
        $number .= $count;
        return $number;
    }



    public function index(Request $request)
    {
        //
        $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        if(!$column){ $column = 'created_at'; }    if(!$sort){ $sort = 'asc'; }
        if ($search || $column || $sort)
        {
            $work_orders = \App\Workorder::where('requisition_id', 'like', "%{$search}%")->orwhere('name', 'like', "%{$search}%")
                ->orwhere('description', 'like', "%{$search}%")->orwhere('workorder_code', 'like', "%{$search}%")
                ->orwhereHas('author', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                ->orderBy($column, $sort)->paginate(15);
        }
        else
        {
            $work_orders = \App\Workorder::where('status_id', 1)->orWhere('created_by',\Auth::user()->id)->orderBy('created_at', 'desc')->paginate(15);
        }

        $users = \App\User::orderBy('name', 'asc')->get();
        $controllerName = new WorkorderController;

        return view('workorder.index', compact('work_orders', 'users', 'controllerName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $default = \App\WorkorderDefault::first();

        $users = \App\User::orderBy('name', 'asc')->get();

        return view('workorder.create', compact('default', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    

    public function store(Request $request)
    {   
        try
        {   //return $request->all();
            $add_order = \App\Workorder::updateOrCreate
            (['id'=> $request->id],
            [
                'name' => $request->name,
                'description' => $request->description,
                'header' => $request->header,
                'comment' => $request->comment,
                'vat' => $request->vat,
                'created_by' => \Auth::user()->id,
            ]);

            //updating Work Order number
            $sub_name = substr($request->name, 0, 3);
            $pref = 'WO-'.$sub_name;
            // $workorderCode = $this->order_number($add->id, $pref);

            //updating workorder code
            $number = '';     $workorder_code = '';
            $number .= $pref;
            //$number .= $dated['year'];
            if($add_order->id < 10) {           $number .= '-0000'; }
            else if($add_order->id >= 10){      $number .= '-000';  }
            else if($add_order->id >= 100){     $number .= '-00';   }
            else if($add_order->id >= 1000){    $number .= '-0';    }
            else if($add_order->id >= 10000){   $number .= '-';     }
            $workorder_code = $number.'-'.$add_order->id;

            $data = array( 'workorder_code'=> $workorder_code );
            $updated = \App\Workorder::where('id', $add_order->id)->update($data);

            //DETACH ALL RECORD
            $delete_detail = \App\WorkorderDetail::where('workorder_id', $request->id)->delete();

            $pm_count = $request->pm_count;
            for($i = 1; $i <= $pm_count; $i++) 
            {
                $pm_item = 'pm_item'.$i;    $quantity = 'quantity'.$i;    
                $unit_price = 'unit_price'.$i;    $line_total = 'line_total'.$i; 
                $add_detail = \App\WorkorderDetail::create
                (
                [
                    'workorder_id' => $add_order->id,
                    'type' => 'Parts & Materials',
                    'item' => $request->$pm_item,
                    'colume_1' => $request->$quantity,
                    'colume_2' => $request->$unit_price,
                    'line_total' => $request->$line_total,
                    'created_by' => \Auth::user()->id,
                ]);
            }


            $sl_count = $request->sl_count;
            for ($i = 1; $i <= $sl_count; $i++) 
            {
                $sl_item = 'sl_item'.$i;    $hour = 'hour'.$i;    $rate = 'rate'.$i;    
                $line_total_sl = 'line_total_sl'.$i;
                $add_detail = \App\WorkorderDetail::create
                (
                [
                    'workorder_id' => $add_order->id,
                    'type' => 'Service & Labour',
                    'item' => $request->$sl_item,
                    'colume_1' => $request->$hour,
                    'colume_2' => $request->$rate,
                    'line_total' => $request->$line_total_sl,
                    'created_by' => \Auth::user()->id,
                ]);
            }

            //     //email notification
            //     $PO = \App\PurchaseOrder::where('id', $request->edit_id)->first();
            //     $created_by = \Auth::user()->id;
            //     $user = \App\User::where('id', $created_by)->first();
            //     $user->notify(new PurchaseOrderNotification($PO));
            // }


            return redirect()->route('workorder.index')->with(['status' => 'ok', 'info'=>'Success']);
        }
        catch (\Exception $e)
        {
            return redirect()->route('workorder.index')->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
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
        $default = \App\WorkorderDefault::first();

        $workorder = \App\Workorder::where('id', $id)->first();
        $details = \App\WorkorderDetail::where('workorder_id', $id)->get();
        $pm_count = $details->where('type', 'Parts & Materials')->count();
        $sl_count = $details->where('type', 'Service & Labour')->count();
        $users = \App\User::orderBy('name', 'asc')->get();

        return view('workorder.view', compact('default', 'users', 'workorder', 'details', 'pm_count', 'sl_count'));

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
        $default = \App\WorkorderDefault::first();

        $workorder = \App\Workorder::where('id', $id)->first();
        $details = \App\WorkorderDetail::where('workorder_id', $id)->get();
        $pm_count = $details->where('type', 'Parts & Materials')->count();  $pm_count++;
        $sl_count = $details->where('type', 'Service & Labour')->count();   $sl_count++;
        $users = \App\User::orderBy('name', 'asc')->get();

        return view('workorder.edit', compact('default', 'users', 'workorder', 'details', 'pm_count', 'sl_count'));
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

}
