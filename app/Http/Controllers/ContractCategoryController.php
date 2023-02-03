<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ContractCategory;
use App\Contract;
use App\Workflow;
use App\Filters\ContractCategoryFilter;
use App\User;
use App\Traits\LogAction;
use Illuminate\Support\Facades\Auth;

class ContractCategoryController extends Controller
{
  use LogAction;
  public function __construct()
  {
      $this->middleware('auth');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // try {
            // if (count($request->all())==0) {
          $workflows=Workflow::all();
          $contract_categories = ContractCategory::paginate(15);
          return view('contract_categories.list',['contract_categories'=>$contract_categories,'workflows'=>$workflows]);
        // }else{
        //   $users=User::all();
        //     $contract_categories=ContractCategoryFilter::apply($request);
        //     // return $users;
        //     return view('contract_categories.list',['contract_categories'=>$contract_categories,'users'=>$users]);

        //   }
        // } catch (\Exception $e) {
        //
        // }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          try {
            $workflows=Workflow::all();
            return view('contract_categories.create',['workflows'=>$workflows]);
          } catch (\Exception $e) {

          }


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        try {
          
          $this->validate($request, ['name'=>'required|min:2']);
          $contract_category=new ContractCategory();
          $contract_category->name=$request->name;
          $contract_category->workflow_id=$request->workflow_id;
          $contract_category->created_by=\Auth::user()->id;
          $contract_category->updated_by=\Auth::user()->id;
          $contract_category->save();
          $logmsg='Contract Category created';
          $this->saveLog('info','App\ContractCategory',$contract_category->id,'contract_categories',$logmsg,Auth::user()->id);
         
           return redirect()->route('contract_categories')->with(['success'=>'Contract Category Created Successfully']);
        } catch (\Exception $e) {

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
        try {
          $contract_category= ContractCategory::find($id);
          return view('contract_categories.view',['contract_category'=>$contract_category]);
        } catch (\Exception $e) {

        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      try {
        $contract_category= ContractCategory::find($id);
        $workflows=Workflow::all();
        return view('contract_categories.edit',['contract_category'=>$contract_category,'workflows'=>$workflows]);
      } catch (\Exception $e) {

      }
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
      try {
        $contract_category=ContractCategory::find($id);
       
        $this->validate($request, ['name'=>'required|min:2']);
        $contract_category->name=$request->name;
        $contract_category->workflow_id=$request->workflow_id;
        $contract_category->updated_by=\Auth::user()->id;
        $contract_category->save();
        $logmsg='Contract Category Edited';
        $this->saveLog('info','App\ContractCategory',$contract_category->id,'contract_categories',$logmsg,Auth::user()->id);
      
         return redirect()->route('contract_categories')->with(['success'=>'Contract Category Updated Successfully']);
      } catch (\Exception $e) {

      }
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
