<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Workflow;
use App\Stage;
use App\Document;
use App\Filters\WorkflowFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\LogAction;

class WorkflowController extends Controller
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
        try 
        {
          if (count($request->all())==0) 
          {
            $stages=Stage::all();
            $workflows=Workflow::where('id', 6)->withCount('stages')->orderBy('id', 'desc')->paginate(10);
            return view('workflows.list',['workflows'=>$workflows,'stages'=>$stages]);
          }
          else 
          {
            $stages=Stage::all();
              $workflows=WorkflowFilter::apply($request);
              // return $users;
              return view('workflows.list',['workflows'=>$workflows,'stages'=>$stages]);
          }
        } 
        catch (\Exception $e) 
        {
          return  $e;
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try 
        {
          $users=User::all();
          return view('workflows.create',['users'=>$users]);
        } 
        catch (\Exception $e) 
        {
            return  $e;
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
        try 
        {
          $this->validate($request, ['name' => 'required']);
          $wf = new Workflow();
          $wf->name = $request->name;
          $wf->save();

          $logmsg='Workflow was created.';
          $this->saveLog('info', 'App\Workflow', $wf->id, 'workflows', $logmsg, Auth::user()->id);
          $no_of_stages=count($request->input('stagename'));
          for ($i = 0; $i < $no_of_stages; $i++) 
          {
            $stg = new Stage();
            $stg->name = $request->stagename[$i];
            $stg->position = $i;
            $stg->user_id = $request->user_id[$i];
            $stg->workflow_id = $wf->id;
            $stg->signable = $request->signable[$i];
            $stg->shareable = $request->shareable[$i];
            $stg->appraisal = $request->appraisal[$i];
            $stg->save();

            $logmsg='stage was created and added to ';
            $this->saveLog('info', 'App\Stage', $stg->id, 'stages', $logmsg, Auth::user()->id);
          }
          return redirect()->route('workflows')->with(['success'=>'Workflow Created Successfully']);
        } 
        catch (\Exception $e) 
        {
            return  $e;
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
      try 
      {
        $wf=Workflow::find($id);
        return view('workflows.view', ['workflow'=>$wf]);
      } 
      catch (\Exception $e) 
      {
          return  $e;
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
        try 
        {
            $users=User::all();
            $wf=Workflow::find($id);
            return view('workflows.edit', ['workflow'=>$wf,'users'=>$users]);
        } 
        catch (\Exception $e) 
        {
            return  $e;
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
      try 
      {
        $workflow= Workflow::find($id);
        if ($this->hasactivereviews($id)) 
        {
          return redirect()->route('workflows.edit', $id)->with('error', 'Workflow is in use by a document in review! Therefore changes cannot be made to the workflow');
        }
        else
        {
          //return $request->all();
          $this->validate($request, ['name'=>'required']);
          $workflow = Workflow::find($id);
          $workflow->name =$request->name;
          $workflow->save();
          $no_of_stages=count($request->input('stagename'));
          for ($i=0; $i < $no_of_stages; $i++) 
          {
            $stage=Stage::find($request->stage_id[$i]);
            if($stage)
            {
              if ($request->user_id[$i]!=$stage->user_id) 
              {
                $logmsg='Approver in '.$stage->name.'was changed from '.$stage->user->name.' to '.User::find($request->user_id[$i])->name;
                $this->saveLog('info','App\Workflow',$workflow->id,'workflows',$logmsg,Auth::user()->id);
              }
              if ($request->stagename[$i]!=$stage->name) 
              {
                $logmsg='The Stage name in '.$stage->name.'was changed from '.$stage->name.' to '.$request->stagename[$i];
                $this->saveLog('info','App\Workflow',$workflow->id,'workflows',$logmsg,Auth::user()->id);
              }
              if ($stage->position!=$i) 
              {
                $logmsg=''.$stage->name.'was moved from position'.$stage->position.' to position '.$i;
                $this->saveLog('info','App\Workflow',$workflow->id,'workflows',$logmsg,Auth::user()->id);
              }
              $stage->name=$request->stagename[$i];
              $stage->position=$i;
              $stage->user_id=$request->user_id[$i];
              $stage->signable=$request->signable[$i];
              $stage->appraisal=$request->appraisal[$i];
              $stage->save();
              }
              else
              {
                $stage=new Stage();
                $stage->name=$request->stagename[$i];
                $stage->position=$i;
                $stage->user_id=$request->user_id[$i];
                $stage->workflow_id=$wf->id;
                $stage->signable=$request->signable[$i];            
                $stage->appraisal=$request->appraisal[$i];
                $stage->save();
              }

         }

          return redirect()->route('workflows')->with(['success'=>'Changes saved Successfully']);
        }
      } 
      catch (\Exception $e) 
      {
        return $e->getMessage();
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


    public function hasactivereviews($id)
    {
      $has_reviews=DB::table('document_reviews')
      ->join('stages', 'document_reviews.stage_id', '=', 'stages.id')
      ->where('document_reviews.status', 0)
      ->where('stages.workflow_id', $id)->exists();
      return $has_reviews;
    }

    public function alterStatus(Request $request)
    {
      if ($this->hasactivereviews($request->id)) {
      return response()->json('Cannot be changed. Workflow in use',200);
    }else{
      $wf=Workflow::find($request->id);
      if ($request->status=='true') {
        $wf->status=1;
        $wf->save();
        $logmsg='Workflow status was changed from inactive to active.';
        $this->saveLog('info','App\Workflow',$wf->id,'workflows',$logmsg,Auth::user()->id);
        return response()->json('enabled',200);
      }elseif($request->status=='false')
      {
        $wf->status=0;
        $wf->save();
        $logmsg='Workflowstatus was changed from active to inactive';
        $this->saveLog('info','App\Workflow',$wf->id,'workflows',$logmsg,Auth::user()->id);
        return response()->json('disabled',200);
      }
    }

    }

}
