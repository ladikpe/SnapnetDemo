<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\TaskRequestNotification;
use App\Mail\TaskRequestApprovalNotification;
use Illuminate\Support\Facades\Mail;

class TaskRequestController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['requests_store']);
    }


    //function for sending email
    public function task_request_mail($id, $name)
    {
        //DEPT HEAD EMAIL
        $user = \App\User::where('id', \Auth::user()->id)->first();
        $dept = \App\Department::where('id', $user->department_id)->first();
        $dept_head = \App\User::where('id', $dept->department_head_id)->first();
        $sender = $dept_head->email;
        $name = $dept_head->name;
        $url = url('requests');
        $message = "A request to create a new document" . $name . " was sent by " . \Auth::user()->name . ". Please click the link below to review this request and approve accordilly";

        // Mail::to($dept_head)->send(new TaskRequestNotification($message, $sender, $name, $url, 'Task Request Approval Notification'));
        Mail::to($user)->send(new TaskRequestNotification($message, $sender, $name, $url, 'Task Request Approval Notification'));
    }


    //function for sending email
    public function task_request_external_mail($id, $purpose, $vendor_name, $email, $organization)
    {
        // EMAIL TO LEGAL
        $dept = \App\Department::where('id', 1)->first();
        $legal_users = \App\User::where('department_id', 1)->get();

        foreach ($legal_users as $key => $user) 
        {
            $sender = $user->email;
            $name = $user->name;
            $url = url('home');

            $message = "A new request from ".$vendor_name. " with " .$organization. " to create a document/contract. Please see full request description below ";
            $title = "External Task Request Notification";

            Mail::to($user)->send(new TaskRequestApprovalNotification($message, $sender, $name, $url, $title, $purpose));
        }
    }


    //function for sending email
    public function request_approval_notification($id, $status_id, $reason)
    {
        //USER EMAIL
        $task_request = \App\TaskRequest::where('id', $id)->first();
        $requestor = \App\User::where('id', $task_request->created_by)->first();
        $sender = $requestor->email;
        $name = $requestor->name;
        $url = url('requests');
        if ($status_id == 2) {
            $message = "Your request " . $task_request->purpose . " has been approved by " . \Auth::user()->name . ". See message below";
            $title = "Approved Task Request Notification";
        } elseif ($status_id == 0) {
            $message = "Your request " . $task_request->purpose . " was declined by " . \Auth::user()->name . ". See message below";
            $title = "Decline Task Request Notification";
        }

        Mail::to($requestor)->send(new TaskRequestApprovalNotification($message, $sender, $name, $url, $title, $reason));


        //LEGAL DEPT EMAIL
        if ($status_id == 2) {
            $dept = \App\Department::where('id', 1)->first();
            $legal_users = \App\User::where('department_id', 1)->get();

            foreach ($legal_users as $key => $user) {
                $sender = $user->email;
                $name = $user->name;

                $message = "A new request to create " . $task_request->purpose . " has been approved by " . \Auth::user()->name . ". See message below";
                $title = "Approved Task Request Notification";

                Mail::to($user)->send(new TaskRequestApprovalNotification($message, $sender, $name, $url, $title, $reason));
            }
        }
    }




















    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index(Request $request)
    {
        // FOR LEGAL USERS
        if (\Auth::user()->department_id == 1) {
            $requests = \App\TaskRequest::orderBy('id', 'desc')->get();
        } else {
            $requests = \App\TaskRequest::where('created_by', \Auth::user()->id)->orderBy('id', 'desc')->get();
        }


        $users = \App\User::orderBy('name', 'asc')->get();
        $requisition_types = \App\RequisitionType::orderBy('name', 'asc')->get();
        $controllerName = new TaskRequestController;

        return view('task-requests.index', compact('requests', 'users', 'controllerName', 'requisition_types'));
    }


    public function request_externals(Request $request)
    {
        // FOR LEGAL USERS
        // if (\Auth::user()->department_id == 1) 
        // {
        //     $requests = \App\TaskRequest::orderBy('id', 'desc')->get();
        // } 
        // else 
        // {
        //     $requests = \App\TaskRequest::where('created_by', \Auth::user()->id)->orderBy('id', 'desc')->get();
        // }

        $requests = \App\TaskRequestExternal::orderBy('id', 'desc')->get();

        $controllerName = new TaskRequestController;

        return view('task-requests.request-externals', compact('requests', 'controllerName'));
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
        $user = \Auth::user();
        $file = $request->file;
        try {
            //return $request->all();
            if ($file) {
                $document_name = $file->getClientOriginalName();
                $destinationPath = 'assets/images/task-documents/' . $file->getClientOriginalName();
                $file->move($destinationPath, $file->getClientOriginalName());

                $type = pathinfo($destinationPath, PATHINFO_EXTENSION);
                $data = file_get_contents($destinationPath . '/' . $document_name);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            } else {
                $destinationPath = null;
                $document_name = null;
                $base64 = null;
            }


            $add = \App\TaskRequest::updateOrCreate(
                ['id' => $request->id],
                [
                    'department_id' => $user->department_id,
                    'department_head_id' => $user->department->department_head_id,
                    'purpose' => $request->purpose,
                    'description' => $request->description,
                    'request_type' => $request->request_type,
                    'document_path' => $destinationPath,
                    'document_name' => $document_name,
                    'status_id' => 1,
                    'created_by' => $user->id,
                ]
            );

            //email notification
            $this->task_request_mail($add->id, $request->purpose);

            return redirect()->back()->with(['status' => 'ok', 'info' => 'Task request create successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }



    
    public function requests_store(Request $request)
    {
        try 
        {
            // return $request->all();

            $add = \App\TaskRequestExternal::updateOrCreate(
                ['id' => $request->id],
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'organization' => $request->organization,
                    'purpose' => $request->purpose
                ]
            );

            //email notification
            $this->task_request_external_mail($add->id, $request->purpose, $request->name, $request->email, $request->organization);

            return redirect()->back()->with(['success' => 'Task request sent successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }






    public function approve_request(Request $request)
    {
        // return $request->all();
        try {
            $req_id = $request->req_id;
            $approval_type = $request->approval_type;
            if ($approval_type == 'Approve') {
                $status_id = 2;
            } elseif ($approval_type == 'Decline') {
                $status_id = 0;
            }
            $task_request = \App\TaskRequest::where('id', $req_id)->first();

            //UPDATE COMMITTEE APPROVAL STATUS
            $data = array('status_id' => $status_id,   'updated_at' => date('Y-m-d h:i:s'));
            $updated = \App\TaskRequest::where('id', $req_id)->update($data);

            $this->request_approval_notification($req_id, $status_id, $request->reason);


            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Success']);
            } else {
                return redirect()->back()->with('info', 'Success');
            }
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





    public function get_request_by_id(Request $request)
    {
        //
        $request = \App\TaskRequest::where('id', $request->id)->first();
        return response()->json($request);
    }


    public function delete_request(Request $request)
    {
        //return $request->all();
        try {
            \App\TaskRequest::where('id', $request->id)->delete();

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Request Deleted Successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Request Deleted Successfully.']);
            }
            return redirect()->back()->with(['success' => 'Request Deleted Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }
}
