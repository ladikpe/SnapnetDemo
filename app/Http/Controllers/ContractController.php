<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;

use App\Actions\ContractAction;

use App\Actions\MsWordAction;

use App\Contract;
use App\ContractDetail;
use App\Template;
use App\User;
use Auth;
use App\Traits\LogAction;
use App\Notifications\VendorReviewContract;
use App\Notifications\ReviewContract;
use App\Notifications\CreateContract;
use App\Notifications\CreateRequisition;
use App\Notifications\ContractApproved;
use App\Notifications\ContractPassedStage;
use App\Notifications\ContractRejected;
use App\Notifications\SendContractDocument;
use App\Workflow;
use App\ContractReview;
use App\ContractCategory;
use App\Tag;
use App\Stage;
use App\Exports\ContractApprovalExport;
use App\Exports\ContractVersionExport;
use Maatwebsite\Excel\Facades\Excel;



class ContractController extends Controller
{
    use LogAction;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request, ContractAction $contractAction, Contract $contract)
    {
      // $response = $contractAction->index($contract);
      $search = $request->search;
      $column = $request->column;
      if(!$column){ $column = 'created_at'; }
      if ($search)
      {
        $contracts = \App\Contract::where('name', 'like', "%{$search}%")
                             ->orwhereHas('vendor', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orwhereHas('Status', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orwhereHas('user', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orderBy($column, 'asc')->paginate(15);         
      }
      else
      {
        $contracts = \App\Contract::where('status', 1)->orWhere('user_id',\Auth::user()->id)->orderBy('created_at', 'asc')->paginate(15);
      }

      $users = \App\User::get();
      $performance_metrics = \App\PerformanceMetric::get();          

      return view('contracts.index', compact('contracts', 'users', 'performance_metrics'));
    }


  // load sorted table
  public function contractTable(Request $request)
  {
    $search = $request->search;
    $column = $request->column;
    if(!$column){ $column = 'created_at'; }
    if ($search)
    {
      $contracts = \App\Contract::where('name', 'like', "%{$search}%")
                           ->orwhereHas('vendor', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                           ->orwhereHas('Status', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                           ->orwhereHas('user', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                           ->orderBy($column, 'asc')->paginate(15);         
    }
    else
    {
      $contracts = \App\Contract::where('status', 1)->orWhere('user_id',\Auth::user()->id)->orderBy('created_at', 'asc')->paginate(15);
    }

    $users = \App\User::get();
    $performance_metrics = \App\PerformanceMetric::get(); 

    return view('contracts.load-contract', compact('contracts', 'users', 'performance_metrics'));
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $users = \App\User::all();
        $groups = \App\Group::all();
        $folders = \App\Folder::all();
        $contract_categories = \App\ContractCategory::all();
        $template = \App\Template::find($request->template);
        if (!$template) 
        {
          $template = \App\Template::find(1);
        }
        $requisition_id = $request->requisition;

        $vendors = \App\Vendor::orderBy('name', 'asc')->get();
        $performance_metrics = \App\PerformanceMetric::get(); 

        return view('contracts.create', compact('users', 'groups', 'folders', 'contract_categories', 'template', 'requisition_id', 'vendors', 'performance_metrics') );
       

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $request->all();
       $contract_category=\App\ContractCategory::find($request->contract_category_id);
       $contract=\App\Contract::create(
       [
         'name'=>$request->name, 
         'workflow_id'=>$contract_category->workflow_id, 
         'contract_category_id'=>$request->contract_category_id,
         'status'=>0,'user_id'=>\Auth::user()->id,
         'expires'=>date('Y-m-d',strtotime($request->expires)),
         'grace_period'=>$request->grace_period, 
         'requisition_id'=>$request->requisition_id,
         'vendor_id'=>$request->vendor_id
       ]);

        //updating REQUISITION STATUS TO contract created
        $data = array
        (
            'contract_created' => '1', 'updated_at' => date('Y-m-d h:i:s')
        );
        \App\Requisition::where('id', $request->requisition_id)->update($data);

        $logmsg = 'Contract was created';
        $this->saveLog('info', 'App\Contract', $contract->id, 'contracts', $logmsg, \Auth::user()->id);

          $contract_detail = \Auth::user()->details()->create(
            [
              'contract_id' => $contract->id, 
              'version_parent_id' => 0, 
              'version_comment' => $request->comment, 
              'cover_page' => $request->cover_page, 
              'content' => $request->content
            ]);
          $logmsg = 'Contract Version was created';
          $this->saveLog('info', 'App\ContractDetail', $contract_detail->id, 'contracts', $logmsg, \Auth::user()->id);

          $stage = Workflow::find($contract->workflow_id)->stages->first();
          $review = new ContractReview();
          $review->stage_id = $stage->id;
          $review->contract_id = $contract->id;
          $review->status = 0;
          $review->comment = $request->comment;
          $review->approved_by = 0;
          $review->save();
          $logmsg = 'New review process started for ' . $contract->name . ' in the ' . $stage->workflow->name;
          $this->saveLog('info', 'App\ContractReview', $review->id, 'contract_reviews', $logmsg, \Auth::user()->id);

          // $no_of_perms = count($request->input('group_id'));
          // for ($i = 0; $i < $no_of_perms; $i++) {
            
          //   $contract->groups()->attach($request->input('group_id')[$i], ['permission_id' =>  $request->input("perm_$i")]);
            
          // }

          $tags = $request->input('tags');
          $tagsArray = [];
          $tok = strtok($tags, " ,");

          while ($tok !== false) 
          {
            $arrayName[] = $tok;
            $tag = Tag::where('name', $tok)->first();
            if ($tag) 
            {
              $contract->tags()->attach($tag->id, ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            } 
            else 
            {
              $newtag = new Tag();
              $newtag->name = $tok;
              $newtag->save();
              $contract->tags()->attach($newtag->id, ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
            $tok = strtok(",");
          }

          $stage->user->notify(new ReviewContract($contract,$review));
        
        return redirect()->route('contracts.index')->with(['success' => 'Contracts Created Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $version=0)
    {
        $contract = Contract::find($id);
        if ($version == 0) 
        {
            $detail = $contract->contract_details()->orderBy('created_at', 'desc')->first();
        }
        else
        {
            $detail = ContractDetail::find($version);
        }
        $operation = "view";
        $performance_metrics = \App\PerformanceMetric::get(); 
        $metrics = \App\PerformanceMetric::get();  
        return view('contracts.view-contract', compact('contract', 'operation', 'detail', 'performance_metrics', 'metrics'));
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
    public function update(Request $request,$id)
    {
        //
       $parent_id=$request->parent_id;
       $contract=Contract::find($id);
       

       if ($contract->name==$request->name) {
        $contract->update(['name'=>$request->name,'vendor_approved'=>0]);
          $logmsg = 'Contract was updated';
          $this->saveLog('info', 'App\Contract', $contract->id, 'contracts', $logmsg, Auth::user()->id);
       }
        $old_version=\App\ContractDetail::find($request->parent_id);
        $cover_page_diff=strcmp($request->cover_page,$old_version->cover_page);
         $content_diff=strcmp($request->content,$old_version->content);
          if ($cover_page_diff!=0 || $content_diff!=0) {
            $contract_detail = \Auth::user()->details()->create(['contract_id' => $contract->id, 'version_parent_id' => $request->parent_id, 'version_comment' => $request->comment, 'cover_page' => $request->cover_page, 'content' => $request->content]);
            $logmsg = 'Contract Version was created';
          $this->saveLog('info', 'App\ContractDetail', $contract_detail->id, 'contracts', $logmsg, Auth::user()->id);
          }
           


          $tags = $request->input('tags');
          $tagsArray = [];
          $tok = strtok($tags, " ,");
          if ($request->filled('tags')) {
            $contract->tags()->detach();
          }

          while ($tok !== false) {
            $arrayName[] = $tok;
            $tag = Tag::where('name', $tok)->first();
            if ($tag) {
              $contract->tags()->attach($tag->id, ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            } else {
              $newtag = new Tag();
              $newtag->name = $tok;
              $newtag->save();
              $contract->tags()->attach($newtag->id, ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
            }
            $tok = strtok(",");
          }

          if ($contract->status==2) {
           $stage = Workflow::find($contract->workflow_id)->stages->first();
          $review = new ContractReview();
          $review->stage_id = $stage->id;
          $review->contract_id = $contract->id;
          $review->status = 0;
          $review->comment = $request->comment;
          $review->save();
          $logmsg = 'New review process started for ' . $contract->name . ' in the ' . $stage->workflow->name;
          $this->saveLog('info', 'App\ContractReview', $review->id, 'contract_reviews', $logmsg, Auth::user()->id);
       }else{

         $review = ContractReview::find($request->review_id);
            $review->comment = $request->comment;
            if ($request->action == "approve") {
              $review->status = 1;
              $review->comment = $request->comment;
              $review->approved_by = Auth::user()->id;
              $review->save();
              $logmsg = $review->contract->name . ' was approved in the ' . $review->stage->name . ' in the ' . $review->stage->workflow->name;
              $this->saveLog('info', 'App\ContractReview', $review->id, 'contract_reviews', $logmsg, Auth::user()->id);

              $newposition = $review->stage->position + 1;
            $nextstage = Stage::where(['workflow_id' => $review->stage->workflow->id, 'position' => $newposition])->first();
            // return $review->stage->position+1;
            // return $nextstage;
            if ($nextstage) {
              $newreview = new ContractReview();
              $newreview->stage_id = $nextstage->id;
              $newreview->contract_id = $review->contract->id;
              $newreview->status = 0;
              $newreview->approved_by = 0;
              $newreview->save();
              $logmsg = 'New review process started for ' . $newreview->contract->name . ' in the ' . $newreview->stage->workflow->name;
              $this->saveLog('info', 'App\Review', $review->id, 'reviews', $logmsg, Auth::user()->id);
              $newreview->stage->user->notify(new ReviewContract($review->contract,$newreview));
              $review->contract->user->notify(new ContractPassedStage($review, $review->stage, $newreview->stage));
            } else {
              $review->contract->status = 1;
              $review->contract->save();
              if($review->contract->requisition){
                $review->contract->requisition->author->notify(new ContractApproved($review->stage, $review));
              $review->contract->requisition->author->notify(new SendContractDocument($contract));
              }
              $review->contract->user->notify(new ContractApproved($review->stage, $review));
              $review->contract->user->notify(new SendContractDocument($contract));
            }

            } elseif ($request->action == "reject") {
                $newposition = $review->stage->position - 1;
                $prevstage = Stage::where(['workflow_id' => $review->stage->workflow->id, 'position' => $newposition])->first();
                if ($prevstage) {
              $newreview = new ContractReview();
              $newreview->stage_id = $prevstage->id;
              $newreview->contract_id = $review->contract->id;
              $newreview->status = 0;
              $newreview->approved_by = 0;
              $newreview->save();
              $logmsg = 'Contract has been moved to a previous stage for ' . $newreview->contract->name . ' in the ' . $newreview->stage->workflow->name;
              $this->saveLog('info', 'App\ContractReview', $review->id, 'reviews', $logmsg, Auth::user()->id);
              $newreview->stage->user->notify(new ReviewContract($review->contract,$newreview));
              $review->contract->user->notify(new ContractPassedStage($review, $review->stage, $newreview->stage));
            } else {
              $review->contract->status = 2;
              $review->contract->save();
              $review->contract->user->notify(new ContractApproved($review->stage, $review));
               
            }
            $review->comment = $request->comment;
            $review->approved_by = Auth::user()->id;
              $review->status = 2;
              $review->save();
              $logmsg = $review->contract->name . ' was rejected in the ' . $review->stage->name . ' in the ' . $review->stage->workflow->name;
              $this->saveLog('info', 'App\ContractReview', $review->id, 'reviews', $logmsg, Auth::user()->id);
              $review->contract->user->notify(new ContractRejected( $review->stage,$review));
              return redirect()->route('contracts.reviews')->with(['success' => 'Contract Reviewed Successfully']);
            }


       }

         
            //create new review if another stage exist
            


           
        
        return redirect()->route('contracts.reviews')->with(['success' => 'Contracts Reviewed Successfully']);

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


    public function new(Request $request){
      $requisition=\App\Requisition::find($request->requisition_id);

      if ($requisition) {
        $tok = strtok($requisition->name, " ");
      $arrayName=[];

       $data = \App\Template::where('name', 'LIKE', '%' . $requisition->name . '%');
      while ($tok !== false) {
      $arrayName[] = $tok; 
      $tok = strtok(" ");
      $data=$data->orWhere('name', 'LIKE', '%' . $tok . '%')
       ->orWhere('cover_page', 'LIKE', '%' . $tok . '%')
       ->orWhere('content', 'LIKE', '%' . $tok . '%');
        }
        
       $data=$data->orderBy('created_at', 'asc')->distinct()->paginate(12);
     
      }
      else
      {
         $data=Template::paginate(12);
      }
        return view('contracts.new',['data'=>$data]);
    }

    public function ContractApproval(Request $request)
    {
      $search = $request->search;
      $column = $request->column;
      if(!$column){ $column = 'created_at'; }
      if ($search)
      {
          $reviews = \App\ContractReview::whereHas('stage', function($query){  $query->where('stages.user_id', \Auth::user()->id); })
                             ->where('status', 0)
                             ->whereHas('contract', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orwhereHas('stage', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orwhereHas('contract.user', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orderBy($column, 'asc')->paginate(15);         
      }
      else
      {
        $reviews = ContractReview::whereHas('stage', function($query) 
        {
            $query->where('stages.user_id', \Auth::user()->id);
        })->where('status', 0)->orderBy('created_at', 'desc')->paginate(15);
      }

        return view('contracts.contract-approval', compact('reviews'));
    }
    
    public function reviewContract($id, $version = 0)
    {
        $review = ContractReview::where(['id'=>$id, 'status'=>0])->whereHas('stage', function($query) 
        {
            $query->where('stages.user_id', \Auth::user()->id);

        })->first();
        
        $performance_metrics = \App\PerformanceMetric::get();   
        if($review) 
        {
          $contract = $review->contract;
          $operation="approve";
            if ($version==0) 
            {
              $detail=$review->contract->contract_details()->orderBy('created_at', 'desc')->first();
            }
            else
            {
              $detail=ContractDetail::find($version);
            }
            $metrics = \App\PerformanceMetric::all();

            return view('contracts.view-contract', compact('contract', 'operation', 'detail', 'review', 'performance_metrics', 'metrics'));
        }
        else
        {
          return redirect(route('contracts.reviews'));
        }
        
    } 

    function downloadAsWord(MsWordAction $msWordAction, $contract_id)
    {

      $contract=Contract::find($contract_id);

       // if ($version_id==0) {
       //     $detail=$review->contract->contract_details->first();
       //  }else{
       //      $detail=ContractDetail::find($version);
       //  }


     return $msWordAction->downloadWordFromText($contract->contract_details()->orderBy('created_at','desc')->first()->cover_page . $contract->contract_details()->orderBy('created_at','desc')->first()->content,$contract->name . '_' . date('Y_m_d'));
    } 


    public function addComment(Request $request)
    {
      if ($request->session()->has('vendor_id')) 
      {
        $vendor=\App\Vendor::find(session('vendor_id'));
        $vendor->comments()->create(['comment' => $request->comment, 'contract_id' => $request->contract_id]);
      }elseif(\Auth::user()){
        \Auth::user()->comments()->create(['comment' => $request->comment, 'contract_id' => $request->contract_id]);
      }
      return redirect()->back();
    }

    public function deleteComment(Request $request)
    {
      $comment=\App\ContractComment::find($request->contract_comment_id);
      if ($comment) {
       $comment->delete();
      }
       return redirect()->back();
    }

    public function downloadContractApprovalHistory($contract_id)
    {
        return (new ContractApprovalExport)->contract($contract_id)->download('approval_history.xlsx');
    }


     public function downloadContractVersionHistory($contract_id)
     {
        return (new ContractVersionExport)->contract($contract_id)->download('version_history.xlsx');
     } 


    public function downloadContractPDF($contract_id)
    {
      // $image=url('logo.png');
       $contract=Contract::find($contract_id);
       if ($contract->status==1) {
          $detail=$contract->contract_details()->orderBy('created_at','desc')->first();
       $pdf = \PDF::loadView('exports.final_contract', compact('detail','contract'));
       // $pdf->setWatermarkImage($image, $opacity = 0.3, $top = '30%', $width = '100%', $height = '100%');
        return $pdf->stream($contract->name.'.pdf');
       }else{
        return redirect()->back();
       }
      
    }


    public function dashboard()
    {
      $contracts_count=Contract::all()->count();
      $approved_contracts_count=Contract::where('status',1)->count();
      $rejected_contracts_count=Contract::where('status',2)->count();
      $pending_contracts_count=Contract::where('status',0)->count();
      return view('contracts.dashboard',compact('contracts_count','approved_contracts_count','rejected_contracts_count','pending_contracts_count'));
    }

    public function new_requisition()
    {     
      return view('contracts.requisition');
    }


    public function save_requisitions(Request $request)
    {
      $requisition=\App\Requisition::create(['name'=>$request->name, 'description'=>$request->description, 'deadline'=>$request->deadline, 'user_id'=>\Auth::user()->id]);
      $managers = User::where('role_id', 5)->get();
      if($managers){
       foreach($managers as $manager)
       {
          $manager->notify(new CreateRequisition($requisition));
       }
     }
    //  $group = \App\Group::find(2);
    //  foreach ($group->users as $user) {
    //    $user->notify(new CreateContract($requisition));
    //  }
      return redirect()->route('contracts.requisitions')->with(['success' => 'New Contract Requisition Made Successfully']);
    }

    public function requisitions(Request $request)
    {
      $requisitions=\App\Requisition::orderBy('created_at','desc')->paginate(15);
      $users = \App\User::get();
      $performance_metrics = \App\PerformanceMetric::get();
      $requisition_types = \App\RequisitionType::orderBy('name', 'asc')->get();
      return view('contracts.requisitions',compact('requisitions', 'users', 'performance_metrics', 'requisition_types'));
    }


    public function delete_requisition($requisition_id)
    {
      $requisition=\App\Requisition::find($requisition_id);
      if ($requisition) {
       $requisition->delete();
      }
       return redirect()->back();
     }





     

    public function user_requisitions(Request $request)
    {
      $search = $request->search;
      // $column = $request->column;
      if ($search)
      {
        $requisitions_assigned_to_users = \App\AssignContractToUser::whereHas('requisition', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orwhereHas('requisition', function($query) use ($request) { $query->where('deadline','like',"%{$request->search}%"); })
                             ->orwhereHas('user', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orwhereHas('requisition.contract.Status', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->orwhereHas('requisition.author', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                             ->where('user_id', \Auth::user()->id)
                             ->orderBy('created_at', 'desc')->paginate(15);         
      }
      else
      {
        $requisitions_assigned_to_users = \App\AssignContractToUser::where('user_id', \Auth::user()->id)->orderBy('created_at','desc')->paginate(15);
      }


      // $requisitions_assigned_to_users = \App\AssignContractToUser::where('user_id', \Auth::user()->id)->orderBy('created_at','desc')->paginate(15);
      $users = \App\User::get();
      $performance_metrics = \App\PerformanceMetric::get();

      return view('contracts.user_requisitions', compact('requisitions_assigned_to_users', 'users', 'performance_metrics'));
    }






    public  function getRatingDetails(Request $request)
    {
        $performance_ratings = \App\ContractPerformance::with(['metric', 'author', 'contract'])->where('contract_id', $request->id)->where('user_type', 2)->get();
        // return $performance_ratings;
        return response()->json($performance_ratings);
    }

    public  function getManagerRatingDetails(Request $request)
    {
        $performance_ratings = \App\ContractPerformance::with(['metric', 'author', 'contract'])->where('contract_id', $request->id)->where('user_type', 1)->get();        
        $metrics = \App\PerformanceMetric::all();

        return response()->json($performance_ratings);
    }

    public  function getLegalRatings(Request $request)
    {
        $legal_ratings = \App\ContractPerformance::with(['metric', 'author', 'contract'])->where('contract_id', $request->id)->where('user_type', 2)->get();  //return $legal_ratings;
        return response()->json($legal_ratings);
    }

    public  function getManagerRatings(Request $request)
    {
        $manager_ratings = \App\ContractPerformance::with(['metric', 'author', 'contract'])->where('contract_id', $request->id)->where('user_type', 1)->get(); 
        return response()->json($manager_ratings);
    }

    public  function legalContractRatingsById(Request $request)
    {
        $leg_ratings = \App\ContractPerformance::with(['metric', 'author', 'contract'])->where('contract_id', $request->id)->where('user_type', 2)->get(); 
        return response()->json($leg_ratings);
    }

    public  function managerContractRatingsById(Request $request)
    {
        $man_ratings = \App\ContractPerformance::with(['metric', 'author', 'contract'])->where('contract_id', $request->id)->where('user_type', 1)->get(); 
        return response()->json($man_ratings);
    }





  

  public function share_with_vendor(Request $request)
  {
    // $vendor = \App\Vendor::find($request->vendor_id);
    $key = mt_rand(10101010, 99999999);
    $contract = Contract::find($request->contract_id);
    $vendor = \App\Vendor::find($contract->vendor_id);
    $contract->vendor_key = $key;
    $contract->save();


    $vendor->notify(new VendorReviewContract($contract, $key));
    return redirect()->back()->with(['success' => 'Request made Successfully']);
  }

  public function vendor_view_contract($contract_id)
  {      
    try 
    {
       $contract = Contract::find(\Crypt::decryptString($contract_id));
      if ($contract) 
      {
        if($contract->vendor_approved==0)
        {
          session(['vendor_key' => $contract->vendor_key]);
          return view('contracts.vendor_validate', compact('contract'));      
         }
         else 
         {  
                   
            return redirect('accessdenied');
        }
       }
       else { 
         
        return redirect('accessdenied');
      }
    } catch (DecryptException $e) {
       
      return redirect('accessdenied');
    }
  }

  public function vendor_validate(Request $request)
  {
    if ($request->session()->has('vendor_key')) {
    
      $contract = Contract::find($request->contract_id);
      $vendor=\App\Vendor::find($contract->vendor_id);
      $detail = $contract->contract_details()->orderBy('created_at', 'desc')->first();
      $operation='vendor';
      return view('contracts.vendor_contract_review', compact('contract', 'detail','vendor','operation'));
    
    }else{
       $contract = Contract::find($request->contract_id);
       return redirect()->route('contract.vendor_view_contract',['contract'=>\Crypt::encryptString($contract->id)]);
    }
  }

  public function save_vendor_review(Request $request)
  {  
    $contract=Contract::find($request->contract_id);
    $vendor=\App\Vendor::find($request->vendor_id);
    $old_version = \App\ContractDetail::find($request->parent_id);
    $cover_page_diff = strcmp($request->cover_page, $old_version->cover_page);
    $content_diff = strcmp($request->content, $old_version->content);
    if ($cover_page_diff != 0 || $content_diff != 0) {
     
      $vendor->details()->create(['contract_id' => $contract->id, 'version_parent_id' => $request->parent_id, 'version_comment' => $request->comment, 'cover_page' => $request->cover_page, 'content' => $request->content]);
     
    }
    $contract->update(['vendor_approved'=>$request->action]);
    $request->session()->forget('vendor_key');
    return redirect()->route('contracts.vendor_success');
  }


  public function vendor_success()
  {
    return view('contracts.vendor_success');
  }


  public function saveSignature(Request $request)
  {
    
    $result = array();
    $imagedata = base64_decode($request->img_data);

    // $filename = md5(date("dmYhisA"));
    $filename = Auth::user()->name.'-'.date('d-M-Y');
    //Location to where you want to created sign image
    $file_name = 'public/e-signature/'.$filename.'.png';
    \Storage::disk('local')->put($file_name, $imagedata);
    // $path=$imagedata->store('file');
    // file_put_contents($file_name, $imagedata);
    $result['status'] = 1;
    $result['file_name'] = $file_name;


      if ($request->session()->has('vendor_id')) 
      {
        $vendor=\App\Vendor::find(session('vendor_id'));
        $vendor->signatures()->create(['signature' => $filename.'.png', 'contract_id' => $request->contract_id]);
      }
      elseif(\Auth::user())
      {
        \Auth::user()->signatures()->create(['signature' => $filename.'.png', 'contract_id' => $request->contract_id]);
      }

    return json_encode($result);

    // return redirect()->back('');

  }

    

}
