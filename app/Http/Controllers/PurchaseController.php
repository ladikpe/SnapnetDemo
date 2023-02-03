<?php

namespace App\Http\Controllers;

use App\PurchaseOrder;
use Illuminate\Http\Request;
use App\Notifications\RequisitionNotification;
use App\Notifications\PurchaseOrderNotification;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function order_number($count, $pre)
    {
        //$dated = getdate();
        $number = '';
        $number .= $pre;
        //$number .= $dated['year'];
        if($count < 10)	{			$number .= '-0000';	}
        else if($count >= 10){		$number .= '-000';	}
        else if($count >= 100){		$number .= '-00'; 	}
        else if($count >= 1000){	$number .= '-0';	}
        else if($count >= 10000){	$number .= '-';		}
        $number .= $count;
        return $number;
    }

    public function version_number($count, $pre)
    {
        $count += 1;  $date='';
        $number = '';
        $number .= $pre;
        $date .= date("d-M-y");
        if($count < 10){	    $number .= '-0';	}
        else if($count >= 10){	$number .= '-';		}
        $number .=$count;
        $number .=' / '.$date;
        return $number;
    }

    public function index(Request $request)
    {
        // $response = $contractAction->index($contract);
        $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        if(!$column){ $column = 'created_at'; }    if(!$sort){ $sort = 'asc'; }
        if ($search || $column || $sort)
        {
            $purchase_orders = \App\PurchaseOrder::where('purchase_order_no', 'like', "%{$search}%")->orwhere('name', 'like', "%{$search}%")
                ->orwhere('description', 'like', "%{$search}%")->orwhere('deadline', 'like', "%{$search}%")
                ->orwhereHas('author', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                ->orwhereHas('assign', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                ->orderBy($column, $sort)->paginate(15);
        }
        else
        {
            $purchase_orders = \App\PurchaseOrder::where('status_id', 1)->orWhere('created_by',\Auth::user()->id)->orderBy('created_at', 'desc')->paginate(15);
        }

        $users = \App\User::orderBy('name', 'asc')->get();

        return view('purchase.index', compact('purchase_orders', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = \App\User::orderBy('name', 'asc')->get();
        $purchase_templates = \App\PurchaseOrderTemplate::orderBy('name', 'asc')->get();
        return view('purchase.create', compact('users', 'purchase_templates'));
    }


    public function create_purchase_order($id)
    {
        $users = \App\User::orderBy('name', 'asc')->get();
        $purchase_templates = \App\PurchaseOrderTemplate::orderBy('name', 'asc')->get();
        $purchase_order = \App\PurchaseOrder::where('requisition_id', $id)->first();
        return view('purchase.create', compact('users', 'purchase_templates', 'id', 'purchase_order'));
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
        {
            $requisition_id = $request->requisition_id;
            $add = \App\PurchaseOrder::updateOrCreate
            (['id'=> $request->edit_id],
            [
                'requisition_id' => $requisition_id,
                'name' => $request->name,
                'contents' => $request->contents,
                'description' => $request->description,
                'assigned_to' => $request->assigned_to,
                'deadline' => $request->deadline,
                'created_by' => \Auth::user()->id,
            ]);

            //updating purchase order number
            if($add && $request->edit_id == '')
            {
                $PO_no = $this->order_number($add->id, 'PO');
                $data = array( 'purchase_order_no'=> $PO_no );
                $updated = \App\PurchaseOrder::where('id', $add->id)->update($data);
            }

            //updating requisition status
            if($add)
            {
                $data = array( 'status_id' => 2 );
                $updated = \App\PurchaseOrderRequisition::where('id', $requisition_id)->update($data);

                //email notification
                $created_by = \Auth::user()->id;
                $user = \App\User::where('id', $created_by)->first();
                $user->notify(new PurchaseOrderNotification($add));
            }

            //INSERTING NEW VERSION
            if($request->edit_id == '')
            {
                $words = explode(" ", $request->name);
                $acronym = "";
                foreach ($words as $w) { $acronym .= $w[0]; }

                $version_count = \App\Version::where('name', $request->name)->count();      $version_count;
                $versionNo = $this->version_number($version_count, 'V-'.$acronym);

                $insert = \App\Version::updateOrCreate
                (['id' => $request->id],
                    [
                        'document_id' => $add->id,
                        'version_no' => $versionNo,
                        'name' => $request->name,
                        'contents' => $request->contents,
                        'assigned_to' => $request->assigned_to,
                        'created_by' => \Auth::user()->id,
                    ]);
            }

            //count version
            if($request->edit_id != '')
            {
                $words = explode(" ", $request->name);
                $acronym = "";
                foreach ($words as $w) { $acronym .= $w[0]; }

                $version_count = \App\Version::where('name', $request->name)->count();
                $versionNo = $this->version_number($version_count, 'V-'.$acronym);

                $add = \App\Version::updateOrCreate
                (['id'=> $request->idd],
                [
                    'document_id' => $request->edit_id,
                    'version_no' => $versionNo,
                    'name' => $request->name,
                    'contents' => $request->contents,
                    'assigned_to' => $request->assigned_to,
                    'created_by' => \Auth::user()->id,
                ]);

                //email notification
                $PO = \App\PurchaseOrder::where('id', $request->edit_id)->first();
                $created_by = \Auth::user()->id;
                $user = \App\User::where('id', $created_by)->first();
                $user->notify(new PurchaseOrderNotification($PO));
            }


            return redirect()->route('purchase-order.index')->with(['success'=>'Purchase Order Created Successfully']);
        }
        catch (\Exception $e)
        {
            return redirect()->route('purchase-order.index')->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
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
    public function editTemplate(Request $request, $id)
    {
        $purchase_templates = \App\PurchaseOrderTemplate::orderBy('name', 'asc')->get();
        $purchase_order = \App\PurchaseOrder::where('id', $id)->first();
        $users = \App\User::orderBy('name', 'asc')->get();
        $purchase_order_versions = \App\Version::where('document_id', $purchase_order->id)->orderBy('id', 'desc')->get();
        $purchase_order_comments = \App\Comment::where('document_id', $purchase_order->id)->orderBy('id', 'desc')->paginate(5);

        return view('purchase.edit', compact('users', 'purchase_templates', 'purchase_order', 'purchase_order_versions', 'purchase_order_comments'));
    }

    public function getPurchaseOrderVersion(Request $request)
    {
        $po_version = \App\Version::where('id', $request->id)->first();
        return response()->json($po_version);
    }


    public function purchase_order_view(Request $request, $id)
    {
        $purchase_order = \App\PurchaseOrder::where('id', $id)->first();

        return view('purchase.view', compact('purchase_order'));
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




    public function storeComment(Request $request)
    {
        try
        {   //return $request->all();
            $add = \App\Comment::updateOrCreate
            (['id'=> $request->id],
                [
                    'document_id' => $request->document_id,
                    'name' => $request->comment_name,
                    'comment' => $request->comment,
                    'created_by' => \Auth::user()->id,
                ]);

            if($request->ajax())
            {
                $comment_detail = ['document_id'=>$add->document_id, 'name'=>$add->name, 'comment'=>$add->comment, 'created_by'=>$add->author->name, 'id'=>$add->id];

                return response()->json(['status'=>'ok', 'message'=>$comment_detail, 'info'=>'Comment Added Successfully.']);
            }
            else
            {
                return redirect()->back()->with('info', 'Comment Added Successfully');
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }

    public function removeComment(Request $request)
    {
        try
        {
            \App\Comment::where('id', $request->id)->delete();

            if($request->ajax())
            {
                return response()->json(['status'=>'ok', 'info'=>'Comment Delete Successfully.']);
            }
            else
            {
                return redirect()->back()->with('info', 'Comment Delete Successfully');
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }

    public function getComments(Request $request)
    {
        $comments = \App\Comment::where('document_id', $request->document_id)->orderBy('id', 'desc')->with(['author'])->get(2);
        return response()->json($comments);
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


    public function template(Request $request)
    {
        $purchase_templates = \App\PurchaseOrderTemplate::orderBy('name', 'asc')->get();
        $users = \App\User::orderBy('name', 'asc')->get();

        return view('purchase.template', compact('purchase_templates', 'users'));
    }


    public function storeTemplate(Request $request)
    {
        try
        {
            $add = \App\PurchaseOrderTemplate::updateOrCreate
            (['name'=> $request->name],
            [
                'name' => $request->name,
                'contents' => $request->contents,
                'created_by' => \Auth::user()->id,
            ]);
            return redirect()->route('purchase-template')->with(['success'=>'Template Created Successfully']);
        }
        catch (\Exception $e)
        {
            return redirect()->route('purchase-template')->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }

    public function getPurchaseOrderTemplate(Request $request)
    {
        $purchase_template = \App\PurchaseOrderTemplate::where('name', $request->name)->first();
        return response()->json($purchase_template);
    }




    //REQUISITION
    public function requisition(Request $request)
    {
        $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        if(!$column){ $column = 'created_at'; }    if(!$sort){ $sort = 'asc'; }
        if ($search || $column || $sort)
        {
            $requisitions = \App\PurchaseOrderRequisition::where('requisition_no', 'like', "%{$search}%")->orwhere('name', 'like', "%{$search}%")
                ->orwhere('description', 'like', "%{$search}%")->orwhere('deadline', 'like', "%{$search}%")
                ->orwhereHas('assign', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                ->orderBy($column, $sort)->paginate(15);
        }
        else
        {
            $requisitions = \App\PurchaseOrderRequisition::where('status_id', 1)->orWhere('created_by',\Auth::user()->id)->orderBy('created_at', 'desc')->paginate(15);
        }

        $users = \App\User::orderBy('name', 'asc')->get();

        return view('purchase.requisition', compact('requisitions', 'users'));
    }


    public function requisition_store(Request $request)
    {
        try
        {
            $add = \App\PurchaseOrderRequisition::updateOrCreate
            (['id'=> $request->id],
            [
                'name' => $request->name,
                'description' => $request->description,
                'assigned_to' => $request->assigned_to,
                'deadline' => $request->deadline,
                'created_by' => \Auth::user()->id,
            ]);

            //count requisition
            $requisition_count = \App\PurchaseOrderRequisition::orderBy('id', 'asc')->count();
            $requisitionNo = $this->order_number($requisition_count, 'RQ');
            if($add && $request->id == '')
            {
                //updating requisition number
                $data = array( 'requisition_no'=> $requisitionNo );
                $updated = \App\PurchaseOrderRequisition::where('id', $add->id)->update($data);
            }

            //email notification
            $assignedTo = $request->assigned_to;
            $user = \App\User::where('id', $assignedTo)->first();
            $user->notify(new RequisitionNotification($add));

            return redirect()->route('purchase-order-requisition')->with(['success'=>'Requisition for Purchase Order Created Successfully']);
        }
        catch (\Exception $e)
        {
            return redirect()->route('purchase-order-requisition')->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }



    public function fetchRequisitionDetails(Request $request)
    {
        $requisition = \App\PurchaseOrderRequisition::where('id', $request->id)->first();
        return response()->json($requisition);
    }




    public function no_of_versions($id)
    {
        $count = \App\Version::where('document_id', $id)->count();
        return $count;
    }

}
