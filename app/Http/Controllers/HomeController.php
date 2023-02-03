<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\Folder;
use App\Review;
use App\Document;
use App\WorkFlow;
use DateTime;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
    //    $this->middleware('auth')->except('vendor_home');
    //    $this->middleware('guest:vendor')->except(['soctest', 'index']);
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function soctest()
  {
    // header( 'Content-type: text/html; charset=utf-8' );
    echo 'Begin ...<br />';
    for ($i = 0; $i < 10; $i++) {
      echo $i . '<br />';
      flush();
      ob_flush();
      sleep(1);
    }
    echo 'End ...<br />';
    // echo 'works';
  }


  public function index()
  {
    // if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 5) 
    // {
    $today = date('Y-m-d');

    $latestusers = User::where('status', 1)->orderBy('created_at', 'desc')->take(5)->get();
    $latestdocuments = Document::orderBy('created_at', 'desc')->take(5)->get();
    $requisition_types = \App\RequisitionType::orderBy('name', 'asc')->get();
    $users_count = User::all()->count();
    $documents_count = Document::all()->count();
    $size_count = Document::sum('size');
    $workflows_count = Workflow::all()->count();
    $groups_count = Group::all()->count();
    $pending_reviews_count = Review::where('status', 0)->get()->count();
    $latest_pending_reviews = Review::where('status', 0)->take(5)->get();
    //$myreviews=Review::where(['status'=> 0,'user_id'=>Auth::user()->id])->take(5)->get();
    $myreviews = Review::whereHas('stage', function ($query) {
      $query->where('user_id', '=', Auth::user()->id);
    })->where('status', 0)->take(5)->get();

    //REQUISITIONS
    $all_requisitions = \App\Requisition::orderBy('created_at', 'desc')->get();
    $all_user_requisitions = \App\Requisition::orderBy('created_at', 'desc')->take('10')->get();
    // FOR HEAD OF LEGAL
    if (\Auth::user()->department->department_head_id == \Auth::user()->id) {
      $unassigned_requisitions = \App\Requisition::where('assigned', 0)->orderBy('created_at', 'desc')->get();
    } else {
      $unassigned_reqs = \App\AssignContractToUser::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->get();
      $unassigned_requisitions = null;
      if (count($unassigned_reqs) > 0) {
        foreach ($unassigned_reqs as $k => $unassigned_req) {
          $task = \App\Requisition::where('id', $unassigned_req->requisition_id)->first();
          if ($task != null) {
            $unassigned_requisitions[$k] = $task;
          } else {
          }
        }
      } else {
      }
    }

    $assigned_requisitions = \App\AssignContractToUser::orderBy('created_at', 'desc')->limit(4)->get();
    $your_requisitions = \App\Requisition::orderBy('created_at', 'desc')->get();
    // $your_requisitions = \App\AssignContractToUser::orderBy('created_at','desc')->get();

    //YOUR REQUISITION


    //DOCUMENTS
    $your_documents = \App\Requisition::get();
    if (count($your_documents) > 0) {
      foreach ($your_documents as $k => $document) {
        $appr_docs = \App\Position::where('requisition_id', $document->id)->where('position_id', 5)->first();
        if ($appr_docs != null) {
          $approved_docs[$k] = $appr_docs;
        } else {
          $approved_docs = [];
        }
      }
      $approved_docs = count($approved_docs);
    } else {
      ($approved_docs = 0);
    }


    //REVIEWS
    $review_docs = [];
    if (count($your_documents) > 0) 
    {
      foreach ($your_documents as $k => $document) 
      {
        $rev_docs = \App\Position::where('requisition_id', $document->id)->where('position_id', 3)->first();
        if ($rev_docs != null) {
          $review_docs[$k] = $rev_docs;
        } else {
          // 
        }
      }
      $review_docs = count($review_docs);
    } 
    else {
      
    $review_docs;
    }


    //REVIEWS

    $reviewing_docs = [];
    if (count($your_documents) > 0) 
    {
      foreach ($your_documents as $k => $document) 
      {
        $rev_docs = \App\Position::where('requisition_id', $document->id)->where('position_id', 3)->first();
        if ($rev_docs != null) 
        {
          $reviewing_docs[$k] = $rev_docs;
        } else {
          $reviewing_docs = [];
        }
      }
      $revapping_docs = count($reviewing_docs);
    } else {
      ($reviewing_docs = 0);   $revapping_docs = 0;
    }  //dd($reviewing_docs);


    //CONTRACTS
    $all_contracts = \App\Contract::orderBy('created_at', 'desc')->get();
    $approved_contracts = \App\Contract::where('status', 1)->orderBy('created_at', 'desc')->get();
    $pending_contracts = \App\Contract::where('status', 0)->orderBy('created_at', 'desc')->get();

    $your_all_contracts = \App\Contract::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
    $your_approved_contracts = \App\Contract::where('user_id', Auth::user()->id)->where('status', 1)->orderBy('created_at', 'desc')->get();



    $reviews = \App\ContractReview::whereHas('stage', function ($query) {
      $query->where('stages.user_id', \Auth::user()->id);
    })->where('status', 0)->orderBy('created_at', 'desc')->get();

    // $rejected = \App\ContractReview::whereHas('stage', function($query) { $query->where('stages.user_id', \Auth::user()->id);  })->where('status', 2)->orderBy('created_at', 'desc')->get();
    $doc = \App\NewDocument::count();
    $rejected = \App\DocumentDecline::where('status_id', 0)->distinct()->count(['document_id']);

    $today = date('Y-m-d');
    $expired_contracts = \App\Contract::where('expires', '<', $today)->orderBy('expires', 'desc')->get();
    $about_to_expires = \App\Contract::orderBy('expires', 'asc')->get();



    $reminders = \App\RequirementAndFiling::where('end', '<=', $today)->count();   //$reminders = 1;
    $total_reminders = \App\RequirementAndFiling::count();

    $vendors = \App\Vendor::where('status', 0)->count();
    $total_vendors = \App\Vendor::count();

    $doc_pending_reviews = \App\Position::where('position_id', 3)->get();
    $doc_reviews = null;
    $doc_pending_reviews = null;
    $review_count = 0;
    if ($doc_pending_reviews != null) {
      foreach ($doc_pending_reviews as $key => $document) {
        $doc_reviews = \App\NewDocument::where('requisition_id', $document->requisition_id)->get();
      }
      $review_count = $doc_pending_reviews->count();
    } else {
      $doc_reviews = null;
    }


    $completions = \App\JobCompletion::orderBy('id', 'desc')->get();




    $user_requisitions = \App\Requisition::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->get();
    $user_review_docs = [];
    //REVIEWS
    if (count($user_requisitions) > 0) {
      foreach ($user_requisitions as $k => $document) {
        $rev_docs = \App\Position::where('requisition_id', $document->id)->where('position_id', 3)->first();
        if ($rev_docs != null) {
          $user_review_docs[$k] = $rev_docs;
        } else {
        }
      }
      $user_review_docs = count($user_review_docs);
    } else {
      ($user_review_docs = 0);
    }


    $user_approved_docs = [];
    if (count($user_requisitions) > 0) {
      foreach ($user_requisitions as $k => $document) {
        $appr_docs = \App\Position::where('requisition_id', $document->id)->where('position_id', 5)->first();
        if ($appr_docs != null) {
          $user_approved_docs[$k] = $appr_docs;
        } else {
        }
      }
      $user_approved_docs = count($user_approved_docs);
    } else {
      ($user_approved_docs = 0);
    }

    $user_rejected = [];
    if (count($user_requisitions) > 0) {
      foreach ($user_requisitions as $k => $document) {
        $rejt_docs = \App\DocumentDecline::where('document_id', $document->id)->first();
        if ($rejt_docs != null) {
          $user_rejected[$k] = $rejt_docs;
        } else {
        }
      }
      $user_rejected = count($user_rejected);
    } else {
      ($user_rejected = 0);
    }

    //REVIEWS
    $user_reviewing_docs = [];
    if (count($user_requisitions) > 0) {
      foreach ($user_requisitions as $k => $document) {
        $rev_docs = \App\Position::where('requisition_id', $document->id)->where('position_id', 3)->first();
        if ($rev_docs != null) {
          $user_reviewing_docs[$k] = $rev_docs;
        } else {
        }
      }
      $revapping_docs = count($user_reviewing_docs);
    } else {
      ($user_reviewing_docs = 0);
    }  //dd($user_reviewing_docs);




    //FOR REQUEST
    $new_user_requests = \App\TaskRequest::where('created_by', \Auth::user()->id)->orderBy('created_at', 'desc')->take('10')->get();

    $all_requests = \App\TaskRequest::orderBy('created_at', 'desc')->get();
    $all_user_requests = \App\TaskRequest::where('created_by', \Auth::user()->id)->orderBy('created_at', 'desc')->get();
    $declined_requests = \App\TaskRequest::where('created_by', \Auth::user()->id)->where('status_id', 0)->orderBy('created_at', 'desc')->get();
    $pending_requests = \App\TaskRequest::where('created_by', \Auth::user()->id)->where('status_id', 1)->orderBy('created_at', 'desc')->get();
    $approved_requests = \App\TaskRequest::where('created_by', \Auth::user()->id)->where('status_id', 2)->orderBy('created_at', 'desc')->get();

    // FOR HEAD OF LEGAL
    if (\Auth::user()->department->department_head_id == \Auth::user()->id) {
      $unapproved_requests = \App\TaskRequest::where('status_id', 1)->orderBy('created_at', 'desc')->get();
    } else {
      $unassigned_reqs = \App\AssignContractToUser::where('user_id', \Auth::user()->id)->orderBy('created_at', 'desc')->get();
      $unassigned_requisitions = null;
      if (count($unassigned_reqs) > 0) {
        foreach ($unassigned_reqs as $k => $unassigned_req) {
          $task = \App\Requisition::where('id', $unassigned_req->requisition_id)->first();
          if ($task != null) {
            $unassigned_requisitions[$k] = $task;
          } else {
          }
        }
      } else {
      }
    }



    $controllerName = new HomeController;

    return view('home', compact('today', 'latestdocuments', 'users_count', 'documents_count', 'workflows_count', 'groups_count', 'pending_reviews_count', 'size_count', 'latest_pending_reviews', 'myreviews', 'all_requisitions', 'all_user_requisitions', 'unassigned_requisitions', 'assigned_requisitions', 'your_requisitions', 'all_contracts', 'approved_contracts', 'pending_contracts', 'expired_contracts', 'about_to_expires', 'your_all_contracts', 'your_approved_contracts', 'reviews', 'doc', 'rejected', 'your_documents', 'approved_docs', 'review_docs', 'revapping_docs', 'reviewing_docs', 'reminders', 'total_reminders', 'vendors', 'total_vendors', 'doc_reviews', 'review_count', 'completions', 'controllerName', 'user_requisitions', 'user_review_docs', 'user_approved_docs', 'user_rejected', 'user_reviewing_docs', 'requisition_types', 'all_requests', 'all_user_requests', 'declined_requests', 'pending_requests', 'approved_requests'));
    // } 

  }



  public function statutoryDashboard()
  {
    // if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 5) 
    // {
    $today = date('Y-m-d');

    //CURRENT MONTH
    $date = new DateTime('now');

    $month = date('m');
    $year = date('Y');
    $last_day = new DateTime('2020-02-01');
    $last_day_of_the_month = $last_day->format('Y-m-t');

    $first_day = date('Y-m-01');


    $statutory_docs = \App\RequirementAndFiling::orderBy('end', 'desc')->get();
    $expired_docs = $statutory_docs->where('end', '<', $today);


    $this_month_expired_docs = \App\RequirementAndFiling::where('start', '>=', $first_day)->orwhere('end', '<=', $last_day_of_the_month)->orderBy('end', 'desc')->get();
    $due_this_month = $statutory_docs->where('end', '>', $today);



    //charts
    $all = $statutory_docs->count();
    $expired = $expired_docs->count();
    $dued_this_month = $due_this_month = $statutory_docs->where('end', '>', $today)->count();
    $chart_legends = ['Valid', 'Expired'];
    $chart_data = ['Valid' => $all - $expired, 'Expired' => $expired];


    $chart_all = $all;
    $chart_expired = $expired;
    $chart_dued_this_month = $dued_this_month;
    $chart_dued_legends = ['Valid', 'Dued This Month', 'Expired'];
    $chart_dued_month = ['Valid' => $chart_all - $chart_expired, 'Expired' => $chart_dued_this_month, 'Dued This Month' => $chart_expired];

    $controllerName = new HomeController;

    return view('statutory-dashboard', compact('today', 'statutory_docs', 'expired_docs', 'all', 'this_month_expired_docs', 'expired', 'chart_legends', 'chart_data', 'chart_dued_legends', 'chart_all', 'chart_expired', 'chart_dued_month', 'chart_dued_this_month'));
    // } 

  }

  public function taskDashboard()
  {
    // if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 5) 
    // {
    $today = date('Y-m-d');
    $date = new DateTime('now');
    $month = date('m');
    $year = date('Y');
    $last_day = new DateTime('2020-02-01');
    $last_day_of_the_month = $last_day->format('Y-m-t');

    $first_day = date('Y-m-01');


    $task_docs = \App\Requisition::orderBy('deadline', 'desc')->get();
    $pending_assignment = $task_docs->where('assigned', '<', 1);
    $past_deadline = $task_docs->where('deadline', '<', $today)->where('contract_created', '<', 1);




    //charts
    $valid = 0;
    $all = $task_docs->count();
    $pending = $pending_assignment->count();
    $past_dead = $past_deadline->count();
    $chart_legends = ['Valid', 'Pending', 'Past Deadline'];
    if ($all > 0) 
    {
      $valid = $all - ($past_dead);
      $pending = (($pending * 100) / $all);
      $past_dead = (($past_dead * 100) / $all);
      $valid = (($valid * 100) / $all);
      $chart_data = ['Valid' => number_format($valid, 0), 'Pending' => number_format($pending, 0), 'Past Deadline' => number_format($past_dead, 0)];
    } 
    else 
    {
      $chart_data = ['Valid' => 0, 'Pending' => 0, 'Past Deadline' => 0];
    }


    $chart_all = $all;
    $chart_expired = $pending_assignment;
    $past_deadline = $past_deadline;
    $chart_past_legends = ['Approved', 'Pending', 'Past Deadline'];
    $chart_past_deadline = ['Approved' => $all - $pending_assignment->count(), 'Pending' => $pending_assignment->count(), 'Past Deadline' => $past_deadline->count()];


    // LEGAL USERS COMLIANCE
    $legal_users = \App\User::where('department_id', 1)->orderBy('name', 'asc')->get();
    $user_compliance = [];
    $user_tasks = [];
    foreach ($legal_users as $k => $legal_user) {
      $userAssigns = \App\AssignContractToUser::where('user_id', $legal_user->id)->get();
      // if($userAssign != null) {    $user_assign[$k] = $userAssign;   }

      foreach ($userAssigns as $key => $userAssign) {
        $allUserTasks = \App\Requisition::where('id', $userAssign->requisition_id)->get();
        $allUserTaskCount = $allUserTasks->count();
        $allUserDocCreated = $allUserTasks->where('contract_created', 1)->count();

        // Compute Compliance Percent
        if ($allUserTaskCount != 0) {
          $user_compliance[$key] = ['user_id' => $userAssign->user_id, 'Name' => $userAssign->user->name, 'Percent' => (($allUserDocCreated * 100) / $allUserTaskCount)];
        } else {
          $user_compliance[$key] = ['user_id' => $userAssign->user_id, 'Name' => $userAssign->user->name, 'Percent' => 0];
        }
      }
    }  //return $user_compliance;

    $user_Assigns = \App\AssignContractToUser::distinct()->get(['user_id']);
    // foreach ($user_Assigns as $i => $user_Assign) 
    // {
    //     $allUserTasks = \App\Requisition::where('id', $user_Assign->requisition_id)->get();
    //     $allUserTaskCount = $allUserTasks->count();
    //     $allUserDocCreated = $allUserTasks->where('contract_created', 1)->count();
    // }

    $controllerName = new HomeController;

    return view('task-dashboard', compact('today', 'task_docs', 'pending_assignment', 'all', 'past_deadline', 'pending_assignment', 'chart_legends', 'chart_data', 'chart_past_legends', 'chart_all', 'chart_expired', 'chart_past_deadline', 'pending', 'past_dead', 'past_deadline', 'valid'));
    // } 

  }

  public function contractDashboard()
  {
    // if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2 || Auth::user()->role_id == 3 || Auth::user()->role_id == 5) 
    // {
    $today = date('Y-m-d');
    $date = new DateTime('now');
    $month = date('m');
    $year = date('Y');
    $last_day = new DateTime('2020-02-01');
    $last_day_of_the_month = $last_day->format('Y-m-t');

    $first_day = date('Y-m-01');


    $contracts = \App\NewDocument::where('document_type_id', 1)->orderBy('created_at', 'desc')->get();
    $contract_count = $contracts->count();
    $expired_contracts = $contracts->where('expire_on', '<=', $today);
    $expired_count = $expired_contracts->count();
    $grace_end = $contracts->where('expire_on', '<=', $today)->where('grace_end', '>=', $today);
    $grace_count = $grace_end->count();
    //cotegory

    $categories = [];
    $types = \App\ContractType::orderBy('name', 'asc')->get();
    foreach ($types as $k => $type) {
      $name = $type->name;
      $value = \App\Requisition::where('contract_type', $type->id)->count();
      $categories[$k] = ['name' => $name, 'value' => $value];
    }    //return $categories;


    //charts
    $contract_legend = ['Expired', 'Grace', 'Valid'];
    if ($contract_count > 0) {
      $valid = $contract_count - ($expired_count + $grace_count);
      $expired_count = (($expired_count * 100) / $contract_count);
      $grace_count = (($grace_count * 100) / $contract_count);
      $valid = (($valid * 100) / $contract_count);
      $contract_chart = ['Expired' => number_format($expired_count, 0), 'Grace' => number_format($grace_count, 0), 'Valid' => number_format($valid, 0)];
    } else {
      $contract_chart = ['Expired' => 0, 'Grace' => 0, 'Valid' => 0];
    }


    $controllerName = new HomeController;

    return view('contract-register-dashboard', compact('today', 'types', 'contracts', 'contract_count', 'expired_contracts', 'expired_count', 'grace_count', 'categories', 'contract_legend', 'contract_chart', 'controllerName'));
    // } 

  }











  public function getReviewStage($requisition_id)
  {
    $position = \App\Position::where('requisition_id', $requisition_id)->first();
    $stage = \App\Stage::where('workflow_id', $position->workflow_id)->where('position', $position->position_id)->first();
    return $stage->name;
  }

  public function getRequisitor($requisition_id)
  {
    $requisitor = \App\Requisition::where('id', $requisition_id)->first();
    $user = \App\User::where('id', $requisitor->user_id)->first();
    return $user->name;
  }


  //  public function vendor_home(Request $request)
  //  {
  //      return view('vendor-home');
  //  }

  public function sign(Request $request)
  {
    $signature = \App\User::where('id', \Auth::user()->id)->first();
    return view('sign', compact('signature'));
  }
}
