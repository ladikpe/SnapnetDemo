<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompletionController extends Controller
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


    public function index(Request $request)
    {
        $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        if(!$column){ $column = 'created_at'; }    if(!$sort){ $sort = 'asc'; }
        if ($search || $column || $sort)
        {
            $completions = \App\JobCompletion::where('name', 'like', "%{$search}%")
                ->orwhere('description', 'like', "%{$search}%")->orwhere('completion_code', 'like', "%{$search}%")
                ->orwhereHas('author', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                ->orwhereHas('approver', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                ->orderBy($column, $sort)->paginate(15);
        }
        else
        {
            $completions = \App\JobCompletion::orderBy('created_at', 'desc')->paginate(15);
        }

        $users = \App\User::orderBy('name', 'asc')->get();
        $controllerName = new CompletionController;

        return view('completion.index', compact('completions', 'controllerName'));    
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

        return view('completion.create', compact('default', 'users'));
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
        try
        {   //return $request->all();
            $add_ = \App\JobCompletion::updateOrCreate
            (['id'=> $request->id],
            [
                'name' => $request->name,
                'description' => $request->description,
                'content' => $request->content,
                'created_by' => \Auth::user()->id,
            ]);

            //updating Work Order number
            $sub_name = substr($request->name, 0, 3);
            $pref = 'CO-'.$sub_name;
            // $workorderCode = $this->order_number($add->id, $pref);

            //updating workorder code
            $number = '';     $workorder_code = '';
            $number .= $pref;
            //$number .= $dated['year'];
            if($add_->id < 10) {           $number .= '-0000'; }
            else if($add_->id >= 10){      $number .= '-000';  }
            else if($add_->id >= 100){     $number .= '-00';   }
            else if($add_->id >= 1000){    $number .= '-0';    }
            else if($add_->id >= 10000){   $number .= '-';     }
            $completion_code = $number.'-'.$add_->id;

            $data = array( 'completion_code'=> $completion_code );
            $updated = \App\JobCompletion::where('id', $add_->id)->update($data);

            //     //email notification
            //     $PO = \App\PurchaseOrder::where('id', $request->edit_id)->first();
            //     $created_by = \Auth::user()->id;
            //     $user = \App\User::where('id', $created_by)->first();
            //     $user->notify(new PurchaseOrderNotification($PO));
            // }


            return redirect()->route('completion.index')->with(['status' => 'ok', 'info'=>'Success']);
        }
        catch (\Exception $e)
        {
            return redirect()->route('completion.index')->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
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

        $completion = \App\JobCompletion::where('id', $id)->first();

        return view('completion.view', compact('default', 'completion'));
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

        $completion = \App\JobCompletion::where('id', $id)->first();

        return view('completion.edit', compact('default', 'completion'));
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
