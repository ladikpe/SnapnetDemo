<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AssignmentEmail;
use App\Notifications\SendClarityEmail;
use App\Notifications\RequisitionEmail;
use App\Notifications\ClarityResponseEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignmentNotification;
use App\Mail\TaskClarityNotification;

class AssignmentController extends Controller
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


    //function for sending email
    public function send_assignee_mail($assign, $requisition_id, $priority, $sensitivity, $new_document)
    {
        $message = \App\EmailMessage::where('header', "Task Assignment Email")->first();
        //sending email to User
        $user = \App\User::where('id', $assign->user_id)->first();
        $requisition = \App\Requisition::where('id', $requisition_id)->first();
        $req_type = \App\RequisitionType::where('id', $requisition->requisition_type_id)->first();

        $sender = Auth::user()->email;
        $name = $user->name;
        $url = url('document-details', $new_document->id);
        // $message = "You are requested to create a new " . $req_type->name . " Requisition for " . $requisition->name . " by " . \Auth::user()->name . ". The document has the following clasification: Priority => " . $priority . ", Sensitivity => " . $sensitivity . ", and deadline date of " . $requisition->deadline . ". Please click the lick below for more.";

        Mail::to($user)->send(new TaskAssignmentNotification($message->message, $sender, $name, $url, 'Task Assignment Notification', $requisition, $priority, $sensitivity));
    }


    //function for sending email
    public function send_clarity_mail($user_id, $requisition, $id, $clarity)
    {
        $message = \App\EmailMessage::where('header', "Send Clarity Email")->first();
        //sending email to User
        $user = \App\User::where('id', $user_id)->first();

        $sender = Auth::user()->email;
        $name = $user->name;
        $url = url('/requisition-clarity', [$id]);
        // $message = "You are requested to provide more clarity on the requisition you created ; " . $requisition . ". Please here is the message sent by " . \Auth::user()->name . ", " . $clarity;

        Mail::to($user)->send(new TaskClarityNotification($message->message, $sender, $name, $url, 'Clarity Request Notification', $requisition, $clarity));
    }

    //function for sending email
    public function send_clarity_response_mail($user_id, $requisition, $id, $response)
    {
        //sending email to User
        $message = \App\EmailMessage::where('header', "Send Clarity Response Email")->first();
        $user = \App\User::where('id', $user_id)->first();

        $sender = Auth::user()->email;
        $name = $user->name;
        $url = url('/requisition-clarity', [$id]);
        // $message = "A response to your request to provide more clarity on this requisition ; " . $requisition . ". Please here is the message sent by " . \Auth::user()->name . ", " . $response;

        $user->notify(new ClarityResponseEmail($message, $sender, $name, $url));

        Mail::to($user)->send(new TaskClarityNotification($message->message, $sender, $name, $url, 'Clarity Response Notification', $requisition, $response));
    }

    //function for sending email
    public function send_clarity_ended($id, $requestor_id, $requisition, $comment)
    {
        //sending email to User
        // $message = \App\EmailMessage::where('header', "Send Clarity Response Email")->first();
        $user = \App\User::where('id', $requestor_id)->first();

        $sender = Auth::user()->email;
        $name = $user->name;
        $url = url('/requisition-clarity', [$id]);
        $message = "This ia to notify you the the clarity request process has ended for  ; " . $requisition . ". Please here is the message sent by " . \Auth::user()->name . ", " . $comment;

        // $user->notify(new ClarityResponseEmail($message, $sender, $name, $url));

        Mail::to($user)->send(new TaskClarityNotification($message, $sender, $name, $url, 'Clarity Ended Notification', $requisition, $requisition));
    }




    //Test email
    public function test_email()
    {
        $users = \App\User::where('id', 2)->get();
        foreach ($users as $receiver) {
            //sending email to User
            $sender = Auth::user()->email;
            $name = $receiver->name;
            $url = route('requisitions.index');
            $message = " Thanks Click the link below to do view";

            $receiver->notify(new RequisitionEmail($message, $sender, $name, $url));
        }
    }


    public function index(Request $request)
    {
        //        
        // $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        // if(!$column){ $column = 'id'; }    if(!$sort){ $sort = 'desc'; }
        // if ($search || $column || $sort)
        // {
        //     $assignments = \App\Requisition::where('id', 'like', "%{$search}%")->where('name', 'like', "%{$search}%")
        //         ->orwhere('description', 'like', "%{$search}%")->orwhere('deadline', 'like', "%{$search}%")
        //         ->orwhereHas('type', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
        //         ->orwhereHas('department', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
        //         ->orwhereHas('author', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
        //         ->orwhereHas('assign', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
        //         ->orwhereHas('status', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
        //         ->orderBy($column, $sort)->paginate(10);
        // }
        // else
        // { 
        //     $assignments = \App\Requisition::where('user_id',\Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        // }

        // for legal
        if (\Auth::user()->department_id == 1) {
            $assignments = \App\Requisition::orderBy('id', 'desc')->get();

            $users = \App\User::where('department_id', 1)->orderBy('name', 'asc')->get();
            $requisition_types = \App\RequisitionType::orderBy('name', 'asc')->get();
            $departments = \App\Department::orderBy('name', 'asc')->get();
            $workflows = \App\Workflow::orderBy('name', 'asc')->get();

            $dept_head = \App\Department::where('id', 1)->first();
            $legal_head = \App\User::where('id', $dept_head->department_head_id)->first();
            // $assignee = \App\AssignContractToUser::where('requisition_id', 'asc')->get();
            // $assignee = \App\AssignContractToUser::where('user_id', 'asc')->get();

            $all_assignments = \App\Requisition::get();
            $pend_assignments = \App\Requisition::where('assigned', 0)->get();
            $appr_assignments = \App\NewDocument::where('reviewed_approved', 3)->get();

            $contract_types = \App\ContractType::orderBy('name', 'desc')->get();
            $controllerName = new AssignmentController;

            return view('assignment.index', compact('assignments', 'users', 'requisition_types', 'departments', 'workflows', 'controllerName', 'legal_head', 'all_assignments', 'pend_assignments', 'appr_assignments', 'contract_types'));
        } else {
            $assignments[] = \App\Requisition::where('id', 0)->get();
            $clarities = \App\RequisitionClarity::where('requestor_id', \Auth::user()->id)->orderBy('id', 'desc')->get();
            // foreach ($clarities as $key => $clarity) 
            // {
            //     $assignments[$key] = \App\Requisition::where('id', $clarity->requisition_id)->first();
            // }  //return $assignments;


            $assignments = \App\Requisition::orderBy('id', 'desc')->get();

            $users = \App\User::where('department_id', 1)->orderBy('name', 'asc')->get();
            $requisition_types = \App\RequisitionType::orderBy('name', 'asc')->get();
            $departments = \App\Department::orderBy('name', 'asc')->get();
            $workflows = \App\Workflow::orderBy('name', 'asc')->get();

            $dept_head = \App\Department::where('id', 1)->first();
            $legal_head = \App\User::where('id', $dept_head->department_head_id)->first();
            // $assignee = \App\AssignContractToUser::where('requisition_id', 'asc')->get();
            // $assignee = \App\AssignContractToUser::where('user_id', 'asc')->get();

            $all_assignments = \App\Requisition::get();
            $pend_assignments = \App\Requisition::where('assigned', 0)->get();
            $appr_assignments = \App\NewDocument::where('reviewed_approved', 3)->get();

            $contract_types = \App\ContractType::orderBy('name', 'desc')->get();
            $controllerName = new AssignmentController;

            return view('assignment.index', compact('assignments', 'users', 'requisition_types', 'departments', 'workflows', 'controllerName', 'legal_head', 'all_assignments', 'pend_assignments', 'appr_assignments', 'contract_types'));
            // return redirect()->back()->with(['status'=>'ok', 'error'=>'Access denied.']);
        }
    }





    public function RequisitionClarityDetails($id)
    {
        return $assignments = \App\Requisition::where('id', $id)->first();
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
        try {
            // return $request->all();
            $requisition_id = $request->requisition_id;
            $user_id = $request->user_id;
            $user = \App\User::where('id', $user_id)->first();
            $requisition = \App\Requisition::where('id', $requisition_id)->first();
            $new_document = \App\NewDocument::where('requisition_id', $requisition->id)->first();
            $position_detail = \App\Position::where('requisition_id', $requisition_id)->first();
            $position = $position_detail->position_id;
            $position++;

            $assign = \App\AssignContractToUser::updateOrCreate(
                ['requisition_id' => $requisition_id],
                [
                    'requisition_id' => $requisition_id,
                    'user_id' => $user_id,
                    'reviewer_id' => $request->reviewer_id,
                    'approver_id' => $request->approver_id,
                    'created_by' => \Auth::user()->id,
                ]
            );

            //update contract type for requisition task
            if ($requisition->requisition_type_id == 1) {
                $data = array('contract_type' => $request->contract_type, 'updated_at' => date('Y-m-d H:i:s'));
                \App\Requisition::where('id', $requisition_id)->update($data);
            }

            //UPDATING assigned in Requisition table
            $status_id = $requisition->status_id;
            $status_id++;
            $data = array('assigned' => 1, 'status_id' => $status_id,);
            \App\Requisition::where('id', $requisition_id)->update($data);


            //update position for workflow
            $data = array('position_id' => $position, 'updated_at' => date('Y-m-d H:i:s'));
            \App\Position::where('requisition_id', $requisition_id)->where('workflow_id', $requisition->workflow_id)->update($data);



            $class = \App\RequisitionClassification::updateOrCreate(
                ['id' => $request->class_id],
                [
                    'requisition_id' => $request->requisition_id,
                    'priority' => $request->priority,
                    'sensitivity' => $request->sensitivity,
                    // 'urgency' => $request->urgency,
                    'assigned_to' => $request->user_id,
                    'requestor_id' => $requisition->user_id,
                    'assigned_by' => \Auth::user()->id,
                ]
            );


            //email notification
            $this->send_assignee_mail($assign, $requisition_id, $request->priority, $request->sensitivity, $new_document);

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Requisition was assigned to ' . $user->name . ' Successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Requisition was assigned to ' . $user->name . ' Successfully.']);
            }


            return redirect()->route('requisition.index')->with(['success' => 'Requisition was assigned to ' . $user->name . ' Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }


    public function RequisitionClarity(Request $request)
    {
        try {
            //return $request->all();
            $requisition = \App\Requisition::where('id', $request->requisition_id)->first();
            $legal_head = \App\Department::where('id', 1)->first();
            $type = 'Request';

            $clarity = \App\RequisitionClarityResponse::updateOrCreate(
                ['id' => $request->id],
                [
                    'requisition_id' => $request->requisition_id,
                    'type' => $type,
                    'user_id' => \Auth::user()->id,
                    'message' => $request->message,
                    'created_by' => \Auth::user()->id,
                ]
            );

            //email notification
            $this->send_clarity_mail($requisition->user_id, $requisition->name, $clarity->id, $request->message);

            if ($request->ajax()) {
                return response()->json(['details' => $clarity, 'status' => 'ok', 'info' => 'Email sent successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Email request sent successfully']);
                // return redirect()->back()->with(['status'=>'ok', 'info'=>'Email sent successfully.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }


    public function RequisitionClarityResponse(Request $request)
    {
        try {
            // return $request->all();           

            $requisition = \App\Requisition::where('id', $request->requisition_id)->first();
            $clarity_info = \App\RequisitionClarityResponse::where('requisition_id', $requisition->id)->first();
            if ($clarity_info->created_by == \Auth::user()->id) {
                $type = 'Request';
            } else {
                $type = 'Response';
            }  //return $type;

            $clarity = \App\RequisitionClarityResponse::updateOrCreate(
                ['id' => $request->id],
                [
                    'requisition_id' => $request->requisition_id,
                    'type' => $type,
                    'user_id' => \Auth::user()->id,
                    'message' => $request->message,
                    'created_by' => \Auth::user()->id,
                ]
            );


            //document file
            $file = $request->file;
            if ($file) {
                $file_name = $file->getClientOriginalName();

                $destinationPath = 'assets/images/clarity_file/' . $file_name;
                $file->move($destinationPath, $file_name);
                // $full_path = $public_path . '/' . $destinationPath;

                $upload = \App\ClarityDocument::create([
                    'clarity_request_id' => $clarity_info->id,
                    'clarity_response_id' => $clarity->id,
                    'document_name' => $file_name,
                    'document_path' => $destinationPath,
                    'uploaded_by' => \Auth::user()->id,
                ]);
            }

            //email notification
            $this->send_clarity_response_mail($request->sender_id, $requisition->name, $request->response_id, $request->response);


            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Email sent successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Email response sent successfully.']);
            }

            return redirect()->back()->with(['success' => 'Email sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }




    public function ShowRequisitionClarity(Request $request, $id)
    {
        //        
        $id;
        $req_clarity = \App\RequisitionClarityResponse::where('id', $id)->first();
        $clarity = \App\Requisition::where('id', $req_clarity->requisition_id)->first();

        $users = \App\User::orderBy('name', 'asc')->get();
        $requisition_types = \App\RequisitionType::orderBy('name', 'asc')->get();
        $departments = \App\Department::orderBy('name', 'asc')->get();
        $workflows = \App\Workflow::orderBy('name', 'asc')->get();


        $all_clarities = \App\RequisitionClarityResponse::where('requisition_id', $clarity->id)->get();
        $legal_head = \App\Department::where('id', 1)->first();
        $clarity_requests = \App\RequisitionClarityResponse::where('user_id', $legal_head->department_head_id)->get();
        if (!$clarity_requests) {
            $clarity_requests = null;
        }
        $clarity_responses = \App\RequisitionClarityResponse::where('user_id', $clarity->user_id)->get();
        if (!$clarity_responses) {
            $clarity_responses = null;
        }
        $document = \App\ClarityDocument::where('clarity_request_id', $req_clarity->id)->first();
        $controllerName = new AssignmentController;

        return view('assignment.requisition-clarity', compact('id', 'req_clarity', 'clarity', 'users', 'requisition_types', 'departments', 'workflows', 'controllerName', 'clarity_requests', 'clarity_responses', 'legal_head', 'all_clarities', 'document'));
    }



    public function clarityEnded(Request $request)
    {
        try {
            // return $request->all();           

            $requestor_id = $request->requestor_id;
            $task_name = $request->task_name;
            $id = $request->c_id;
            $comment = $request->comment;
            $requisition = \App\Requisition::where('id', $request->requisition_id)->first();
            $clarity_info = \App\RequisitionClarityResponse::where('requisition_id', $requisition->id)->first();

            //email notification
            $this->send_clarity_ended($id, $requestor_id, $task_name, $comment);


            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Notification sent successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Notification response sent successfully.']);
            }

            return redirect()->back()->with(['success' => 'Notification sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
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


    public function getRequisitionStage($requisition_id, $workflow_id)
    {
        $position = \App\Position::where('requisition_id', $requisition_id)->first();
        if ($position) {
            $stage = \App\Stage::where('position', $position->position_id)->where('workflow_id', $workflow_id)->first();
            if ($stage) {
                return $stage['name'];
            }
        } else {
            return 'N\A';
        }
    }


    public function getClarity($id)
    {
        $result = \App\RequisitionClarityResponse::where('requisition_id', $id)->first();
        if ($result) {
            if ($result->message != null) {
                return 'Yes';
            } else {
                return 'No';
            }
        } else {
            return 'No';
        }
    }
    public function getClarityView($id)
    {
        $result = \App\RequisitionClarityResponse::where('id', $id)->first();
        if ($result) {
            if ($result->message != null) {
                return 'Yes';
            } else {
                return 'No';
            }
        } else {
            return 'No';
        }
    }


    public function getResponse($id)
    {
        $requisition = \App\Requisition::where('id', $id)->first();
        $result = \App\RequisitionClarityResponse::where('requisition_id', $id)->where('user_id', $requisition->user_id)->first();
        if ($result) {
            if ($result->message != null) {
                return 'Yes';
            } else {
                return 'No';
            }
        } else {
            return 'No';
        }
    }
    public function getResponseView($id)
    {
        $clarity = \App\RequisitionClarityResponse::where('id', $id)->first();
        $requisition = \App\Requisition::where('id', $clarity->requisition_id)->first();
        $result = \App\RequisitionClarityResponse::where('requisition_id', $requisition->id)->where('type', 'Response')->first();
        if ($result) {
            if ($result->message != null) {
                return 'Yes';
            } else {
                return 'No';
            }
        } else {
            return 'No';
        }
    }


    public function getClarityId($id)
    {
        $result = \App\RequisitionClarityResponse::where('requisition_id', $id)->first();
        if ($result) {
            return $result->id;
        } else {
            return null;
        }
    }

    public function getDocumentCreator($requisition_id)
    {
        $user = \App\AssignContractToUser::where('requisition_id', $requisition_id)->first();
        if ($user) {
            return $user->user->name;
        } else {
            return null;
        }
    }

    public function getDocumentReviewer($requisition_id)
    {
        $reviewer = \App\AssignContractToUser::where('requisition_id', $requisition_id)->first();
        if ($reviewer) {
            return $reviewer->user->name;
        } else {
            return null;
        }
    }

    public function getRequisitionPriority($requisition_id)
    {
        $priority = \App\RequisitionClassification::where('requisition_id', $requisition_id)->first();
        if ($priority) {
            return $priority->priority;
        } else {
            return null;
        }
    }

    public function getRequisitionSensitivity($requisition_id)
    {
        $sensitivity = \App\RequisitionClassification::where('requisition_id', $requisition_id)->first();
        if ($sensitivity) {
            return $sensitivity->sensitivity;
        } else {
            return null;
        }
    }



    public function TestEmail(Request $request)
    {
        try {
            // email notification
            $this->test_email();

            return redirect()->back()->with(['info' => 'Email sent']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sorry, could not send email notification. ' . $e->getMessage());
        }
    }
}
