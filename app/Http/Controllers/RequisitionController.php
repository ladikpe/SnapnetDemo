<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\RequisitionEmail;
use App\Notifications\ExecutedCopyEmail;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Storerequest;
use Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskCreationNotification;

class RequisitionController extends Controller
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
    public function send_requisition_mail($id, $requisition_name, $type, $deadline)
    {
        //GETTING EMAIL MESSAGE
        $message = \App\EmailMessage::where('header', "Send Task Requisition Email")->first();
        //Getting all Users in Legal Department
        $department = \App\Department::where('id', 1)->first();
        $receivers = \App\User::where('department_id', 1)->where('id', '<>', $department->department_head_id)->get();

        foreach ($receivers as $receiver) {
            //sending email to User
            $sender = Auth::user()->email;
            $name = $receiver->name;
            $url = url('task-detail', $id);
            // $message = "A request to create a new task, " . $type . " document category with the title of; " . $requisition_name . " was sent by " . \Auth::user()->name . ". The Requisition has a deadline date of " . $deadline;

            // $receiver->notify(new RequisitionEmail($message, $sender, $name, $url));
            Mail::to($receiver)->send(new TaskCreationNotification($message->message, $sender, $name, $url, 'New Task Notification'));
        }

        //LEGAL HEAD EMAIL
        $dept_head = \App\Department::where('id', 1)->first();
        $legal_head = \App\User::where('id', $dept_head->department_head_id)->first();
        $sender_head = $legal_head->email;
        $name_head = $legal_head->name;
        $url = url('task-detail', $id);
        // $message_head = "A request to create a new " . $type . " Requisition for " . $requisition_name . " was sent by " . \Auth::user()->name . ". Your responsibility is to review and classify this requisition by order of priority, sensitivity & urgency before assigning this task to a legal officer in your team. The Requisition has a deadline date of " . $deadline;

        Mail::to($legal_head)->send(new TaskCreationNotification($message->message, $sender_head, $name_head, $url, 'New Task Notification'));
    }


    //function for sending email
    public function executed_copy_mail($id, $requisition_name)
    {
        //GETTING EMAIL MESSAGE
        $message = \App\EmailMessage::where('header', "Send Executed Email")->first();

        $req = \App\Requisition::where('id', $id)->first();
        $requestor = \App\User::where('id', $req->user_id)->first();
        //sending email to User
        $req_sender = Auth::user()->email;
        $req_name = $requestor->name;
        $url = route('document-link-url');
        // $req_message = "Executed copy for " . $requisition_name . " was uploaded by " . \Auth::user()->name;

        Mail::to($requestor)->send(new TaskCreationNotification($message->message, $req_sender, $req_name, $url, 'Executed Copy Uploaded Notification'));



        //Getting all Users in Legal Department
        $receivers = \App\User::where('department_id', 1)->get();
        // $department = \App\Department::where('id', $department_head_id)->first();

        foreach ($receivers as $receiver) {
            //sending email to User
            $sender = Auth::user()->email;
            $name = $receiver->name;
            // $message = "Executed copy for " . $requisition_name . " was uploaded by " . \Auth::user()->name;

            $receiver->notify(new ExecutedCopyEmail($message, $sender, $name, $url));
            Mail::to($receiver)->send(new TaskCreationNotification($message->message, $sender, $name, $url, 'Executed Copy Uploaded Notification'));
        }
    }


    public function requisition_number($count, $pre)
    {
        //$dated = getdate();
        $number = '';
        $number .= $pre;
        //$number .= $dated['year'];
        if ($count < 10) {
            $number .= '-0000';
        } else if ($count >= 10) {
            $number .= '-000';
        } else if ($count >= 100) {
            $number .= '-00';
        } else if ($count >= 1000) {
            $number .= '-0';
        } else if ($count >= 10000) {
            $number .= '-';
        }
        $number .= $count;
        return $number;
    }





    public function index(Request $request)
    {
        //return $request->all();      
        // $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        // if(!$column){ $column = 'id'; }    if(!$sort){ $sort = 'desc'; }
        // if ($search || $column || $sort)
        // {
        //     $requisitions = \App\Requisition::where('requisition_code', 'like', "%{$search}%")->where('name', 'like', "%{$search}%")
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
        //     $requisitions = \App\Requisition::where('user_id',\Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        // }

        // FOR LEGAL USERS
        if (\Auth::user()->department_id == 1) {
            $requisitions = \App\Requisition::orderBy('id', 'desc')->get();
            $pend_assignments = \App\Requisition::where('assigned', 0)->get();
            $appr_assignments = \App\NewDocument::where('reviewed_approved', 3)->get();
        } else {
            $requisitions = \App\Requisition::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->get();
            $pend_assignments = \App\Requisition::where('user_id', \Auth::user()->id)->where('assigned', 0)->get();

            $appr_assignments = [];
            if (count($requisitions) > 0) {
                foreach ($requisitions as $k => $requisition) {
                    $doc = \App\NewDocument::where('requisition_id', $requisition->id)->where('reviewed_approved', 3)->first();
                    if ($doc != null) {
                        $appr_assignments[$k] = $doc;
                    } else {
                    }
                }
            } else {
                // return null;
            }  //dd($appr_assignments);
        }


        $users = \App\User::orderBy('name', 'asc')->get();
        $requisition_types = \App\RequisitionType::orderBy('name', 'asc')->get();
        $contract_types = \App\ContractType::orderBy('name', 'asc')->get();
        $departments = \App\Department::where('name', 'Legal Department')->orderBy('name', 'asc')->get();
        $workflows = \App\Workflow::orderBy('name', 'asc')->get();
        $workflow = \App\Workflow::where('id', 6)->orderBy('name', 'asc')->first();
        $controllerName = new RequisitionController;

        //return requisition stage
        $stages = \App\Stage::where('workflow_id', \Auth::user()->id)->orderBy('id', 'desc')->paginate(10);


        return view('requisition.index', compact('requisitions', 'users', 'controllerName', 'requisition_types', 'contract_types', 'departments', 'workflows', 'workflow', 'pend_assignments', 'appr_assignments'));
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
            //return $request->all();
            $requisition_type = \App\RequisitionType::where('id', $request->requisition_type_id)->first();
            $id = $request->id;
            if ($id > 0) {
                $req_detail = \App\Requisition::where('id', $id)->first();
                $user_id = $req_detail['user_id'];
            } else {
                $user_id = \Auth::user()->id;
            }


            $document = $request->document;
            $file = $request->template_content;

            if ($document != null) {
                $document_name = $document->getClientOriginalName();
                $documentPath = 'assets/images/task-documents/' . $document->getClientOriginalName();
                $document->move($documentPath, $document->getClientOriginalName());

                $type = pathinfo($documentPath, PATHINFO_EXTENSION);
                $data = file_get_contents($documentPath . '/' . $document_name);
                $documentbase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                //for edit
                if ($id > 0) {
                    //if file dose not exist
                    if ($req_detail->document_name == null) {
                        $document_name = null;
                        $documentPath = null;
                        $documentbase64 = null;
                    } //else populate file details
                    else {
                        $document_name = $req_detail->document_name;
                        $documentPath = $req_detail->document_path;
                    }
                } else {
                    $document_name = null;
                    $documentPath = null;
                    $documentbase64 = null;
                }
            }

            if ($file != null) {
                $file_name = $file->getClientOriginalName();
                $destinationPath = 'assets/images/prefered-templates/' . $file->getClientOriginalName();
                $file->move($destinationPath, $file->getClientOriginalName());

                $type = pathinfo($destinationPath, PATHINFO_EXTENSION);
                $data = file_get_contents($destinationPath . '/' . $file_name);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                $destinationPath = null;
                $template_name = null;
                $base64 = null;
            }



            $add = \App\Requisition::updateOrCreate(
                ['id' => $id],
                [
                    'requisition_type_id' => $request->requisition_type_id,
                    'name' => $request->name,
                    'title' => $request->name,
                    'department_id' => 1,
                    'deadline' => $request->deadline,
                    'workflow_id' => $request->workflow_id,
                    'description' => $request->description,
                    'status_id' => 1,
                    'contract_created' => 0,
                    'start' => $request->deadline,
                    'end' => $request->deadline,
                    'template_path' => $destinationPath,
                    'template_content' => $base64,
                    'document_name' => $document_name,
                    'document_path' => $documentPath,
                    'user_id' => $user_id,
                ]
            );


            //updating requisition number
            $sub_name = substr($request->name, 0, 3);
            $sub_cate = substr($request->category, 0, 2);
            $pref = $sub_name;
            $requisitionCode = $this->requisition_number($add->id, $pref);
            $data = array('requisition_code' => $requisitionCode);
            $updated = \App\Requisition::where('id', $add->id)->update($data);


            //insert position for workflow
            $position = \App\Position::Create([
                'requisition_id' => $add->id,
                'workflow_id' => $request->workflow_id,
                'position_id' => 1,
            ]);  //dd($add->id);


            $addDoc = \App\NewDocument::updateOrCreate(
                ['id' => $id],
                [
                    'requisition_id' => $add->id,
                    'name' => $request->name,
                    'title' => $request->name,
                    'document_type_id' => $request->requisition_type_id,
                    'cover_page' => '',
                    'content' => '',
                    'workflow_id' => $request->workflow_id,
                    'expire_on' => date('Y-m-d H:i:s'),
                    'grace_period' => Null,
                    'vendor_id' => Null,
                    'stage_id' => 0,
                    'start' => $request->deadline,
                    'end' => $request->deadline,
                    'created_by' => \Auth::user()->id,
                ]
            );


            //email notification
            $this->send_requisition_mail($add->id, $request->name, $requisition_type->name, $request->deadline);

            if ($request->ajax()) {
                return response()->json(['details' => $add, 'status' => 'ok', 'info' => 'New task create successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'New task create successfully.']);
            }

            return redirect()->route('requisition.index')->with(['status' => 'ok', 'info' => 'New task create successfully']);
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





    public function task_detail(Request $request, $id)
    {
        $arr = $request->path();
        $exp_arr = explode('/', $arr);
        // $id = $exp_arr[1];
        $detail = \App\Requisition::where('id', $id)->first();


        $users = \App\User::where('department_id', 1)->orderBy('name', 'asc')->get();
        $requisition_types = \App\RequisitionType::orderBy('name', 'asc')->get();
        $departments = \App\Department::orderBy('name', 'asc')->get();
        $workflows = \App\Workflow::orderBy('name', 'asc')->get();
        $workflow = \App\Workflow::where('id', 6)->orderBy('name', 'asc')->first();
        $dept_head = \App\Department::where('id', 1)->first();
        $legal_head = \App\User::where('id', $dept_head->department_head_id)->first();
        $clarities = $this->getClarityMessage($detail->id, 'Request');
        $contract_types = \App\ContractType::orderBy('name', 'desc')->get();

        $controllerName = new RequisitionController;

        return view('requisition.task-detail', compact('id', 'detail', 'users', 'requisition_types', 'departments', 'workflows', 'workflow', 'dept_head', 'legal_head', 'contract_types', 'clarities', 'controllerName'));
    }



    public function getDocumentUsers($requisition_id, $type)
    {
        $assign = \App\AssignContractToUser::where('requisition_id', $requisition_id)->first();
        if ($assign && $type == 'user_id') {
            $details = \App\User::where('id', $assign->user_id)->first();
            return $details->name;
        } elseif ($assign && $type == 'reviewer_id') {
            $details = \App\User::where('id', $assign->reviewer_id)->first();
            return $details->name;
        } elseif ($assign && $type == 'approver_id') {
            $details = \App\User::where('id', $assign->approver_id)->first();
            return $details->name;
        } elseif ($assign && $type == 'created_by') {
            $details = \App\User::where('id', $assign->created_by)->first();
            return $details->name;
        } else {
            return 'Pending Assignment';
        }
    }


    public function get_requisition_by_id(Request $request)
    {
        //
        $requisition = \App\Requisition::where('id', $request->id)->with('author')->first();
        return response()->json($requisition);
    }


    public function delete_requisition(Request $request)
    {
        //return $request->all();
        try {
            \App\Requisition::where('id', $request->id)->delete();

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Requisition Deleted Successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Requisition Deleted Successfully.']);
            }
            return redirect()->route('requisition.index')->with(['success' => 'Requisition Deleted Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
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

    public function checkClarityStatus($requisition_id)
    {
        $clarity = \App\RequisitionClarityResponse::where('requisition_id', $requisition_id)->first();
        if ($clarity) {
            return 'Yes';
        } else {
            return null;
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

    public function getClarityId($id)
    {
        $result = \App\RequisitionClarityResponse::where('requisition_id', $id)->first();
        if ($result) {
            return $result->id;
        } else {
            return null;
        }
    }

    public function getClarityMessage($id, $type)
    {
        if ($type == 'Request') {
            $clarity_message = \App\RequisitionClarityResponse::where('requisition_id', $id)->where('type', $type)->get();
            if ($clarity_message) {
                return $clarity_message;
            } else {
                return null;
            }
        } elseif ($type == 'Response') {
            $clarity_message = \App\RequisitionClarityResponse::where('requisition_id', $id)->where('type', $type)->get();
            if ($clarity_message) {
                return $clarity_message;
            } else {
                return null;
            }
        }
    }





    public function uploadExecutedCopy(Request $request)
    {
        try {
            //return $request->all();
            $file = $request->executed_copy;
            $id = $request->id;
            $requisition = \App\Requisition::where('id', $id)->first();

            if ($file != null) {
                $executed_copy = $file->getClientOriginalName();
                $documentPath = 'assets/images/executed-copy/' . $file->getClientOriginalName();
                $file->move($documentPath, $file->getClientOriginalName());
            } else {
                $documentPath = null;
            }


            $data = array('executed_copy' => $executed_copy,  'executed_copy_path' => $documentPath,  'updated_at' => date('Y-m-d h:i:s'));
            \App\Requisition::where('id', $id)->update($data);



            //email notification
            $this->executed_copy_mail($id, $requisition->name);

            if ($request->ajax()) {
                return response()->json(['details' => $add, 'status' => 'ok', 'info' => 'Excuted copy uploaded successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Excuted copy uploaded successfully.']);
            }

            return redirect()->route('requisition.index')->with(['success' => 'Excuted copy uploaded successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }

    public function requestForm(Request $request)
    {

        if (\Auth::user()->department_id == 1) {
            $requisitions = \App\Storerequest::orderBy('id', 'desc')->get();
            $pend_assignments = \App\Storerequest::where('status_id', 1)->get();
            $appr_assignments = \App\Storerequest::where('status_id', 0)->get();
        } else {
            $requisitions = \App\Storerequest::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->get();
            $pend_assignments = \App\Storerequest::where('user_id', \Auth::user()->id)->where('assigned', 0)->get();

            $appr_assignments = [];
            if (count($requisitions) > 0) {
                foreach ($requisitions as $k => $requisition) {
                    $doc = \App\NewDocument::where('requisition_id', $requisition->id)->where('reviewed_approved', 3)->first();
                    if ($doc != null) {
                        $appr_assignments[$k] = $doc;
                    } else {
                    }
                }
            } else {
            }
        }

        $users = \App\User::orderBy('name', 'asc')->get();
        $requisition_types = \App\RequisitionType::orderBy('name', 'asc')->get();
        $contract_types = \App\ContractType::orderBy('name', 'asc')->get();
        $departments = \App\Department::where('name', 'Legal Department')->orderBy('name', 'asc')->get();
        $workflows = \App\Workflow::orderBy('name', 'asc')->get();
        $workflow = \App\Workflow::where('id', 6)->orderBy('name', 'asc')->first();
        $controllerName = new RequisitionController;
        $stages = \App\Stage::where('workflow_id', \Auth::user()->id)->orderBy('id', 'desc')->paginate(10);

        return view('request.requestForm', compact('requisitions', 'users', 'controllerName', 'requisition_types', 'contract_types', 'departments', 'workflows', 'workflow', 'pend_assignments', 'appr_assignments'));
    }

    public function storeRequest(Request $request)
    {
        try {

            $this->validate($request, [
                'purpose' => 'required',
                'request_type' => 'required',
            ]);

            $document = $request->document;

            if ($document != null) {
                $document_name = $document->getClientOriginalName();
                $documentPath = 'assets/images/requests-documents/' . $document->getClientOriginalName();
                $document->move($documentPath, $document->getClientOriginalName());

                $type = pathinfo($documentPath, PATHINFO_EXTENSION);
                $data = file_get_contents($documentPath . '/' . $document_name);
                $documentbase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                $destinationPath = null;
                $template_name = null;
                $base64 = null;
            }

            $makeRequest = new Storerequest;
            $makeRequest->department_id      = \Auth::user()->department_id;
            $makeRequest->department_head_id = \Auth::user()->department_id;
            $makeRequest->purpose            = $request->purpose;
            $makeRequest->description        = $request->description;
            $makeRequest->request_type       = $request->request_type;
            $makeRequest->document_name      = $document_name;
            $makeRequest->document_path      = $documentPath;
            $makeRequest->status_id          = 1;
            $makeRequest->created_by         = \Auth::user()->id;
            $makeRequest->save();

            return redirect()->back()->with(['status' => 'ok', 'info' => 'Request sent successfully.']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, Your requests cannot be processed at this moment. ' . $e->getMessage()]);
        }
    }
}
