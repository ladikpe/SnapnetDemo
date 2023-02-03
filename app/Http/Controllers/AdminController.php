<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
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

    public function index()
    {
        //
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
        //
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














    //DEPARTMENT
    public function departments(Request $request)
    {  //return $request->all();      
        $search = $request->search;
        $column = $request->column;
        $sort = $request->sort;
        if (!$column) {
            $column = 'id';
        }
        if (!$sort) {
            $sort = 'desc';
        }
        if ($search || $column || $sort) {
            $departments = \App\Department::where('name', 'like', "%{$search}%")->orwhere('description', 'like', "%{$search}%")
                ->orwhereHas('author', function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->search}%");
                })
                ->orderBy($column, $sort)->get();
        } else {
            $departments = \App\Department::orderBy('id', 'desc')->get();
        }
        $department_heads = \App\User::orderBy('name', 'asc')->get();

        return view('admin.departments', compact('departments', 'department_heads'));
    }


    public function addDepartment(Request $request)
    {
        try {
            // return $request->all();
            $id = $request->id;
            if ($id > 0) {
                $dept_detail = \App\Department::where('id', $id)->first();
                $user_id = $dept_detail['created_by'];
            } else {
                $user_id = \Auth::user()->id;
            }

            $add = \App\Department::updateOrCreate(
                    ['id' => $id],
                    [
                        'name' => $request->name,
                        'description' => $request->description,
                        'department_head_id' => $request->department_head_id,
                        'created_by' => $user_id,
                    ]
                );

            if ($request->ajax()) {
                return response()->json(['details' => $add, 'status' => 'ok', 'info' => 'New Department Create Successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'New Department Create Successfully.']);
            }

            return redirect()->route('admin.departments')->with(['success' => 'New Department Create Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }


    public function get_department_by_id(Request $request)
    {
        //
        $department = \App\Department::where('id', $request->id)->with('department_head')->first();
        return response()->json($department);
    }


    public function delete_department(Request $request)
    {
        //return $request->all();
        try {
            \App\Department::where('id', $request->id)->delete();

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Department Deleted Successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Department Deleted Successfully.']);
            }
            return redirect()->route('admin.departments')->with(['success' => 'Department Deleted Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }




    //ASSIGN TASK
    public function assignTask(Request $request)
    {
        //return $request->all();  
        $today = date('Y-m-d');
        $assigned_tasks = \App\AssignTask::orderBy('id', 'desc')->get();
        $users = \App\User::where('department_id', 1)->orderBy('name', 'asc')->get();
        $documents = \App\Requisition::orderBy('name', 'asc')->get();

        $expired = \App\AssignTask::where('end_date', '<', $today)->get();
        $active = \App\AssignTask::where('end_date', '>=', $today)->get();

        return view('admin.assign-tasks', compact('assigned_tasks', 'users', 'documents', 'today', 'expired', 'active'));
    }


    public function addAssignTask(Request $request)
    {
        try {
            //return $request->all();
            $document_id = $request->document_id;
            $previous_task_owner = \App\AssignContractToUser::where('requisition_id', $document_id)->first();
            //MAPPING ACTION/ROLE TO ASSIGNMENT USER COLUMN
            $action = $request->action;
            switch ($action) {
                case 'Creation':
                    $add = \App\AssignTask::updateOrCreate(
                            ['id' => $request->id],
                            [
                                'document_id' => $document_id,
                                'previous_user_id' => $previous_task_owner->user_id,
                                'user_id' => $request->user_id,
                                'action' => $request->action,
                                'end_date' => $request->end_date,
                                'created_by' => \Auth::user()->id,
                            ]
                        );

                    // updating record for task Creation
                    $data = array('user_id' => $request->user_id,  'updated_at' => date('Y-m-d h:i:s'));
                    \App\AssignContractToUser::where('requisition_id', $document_id)->update($data);
                    break;

                case 'Review':
                    $add = \App\AssignTask::updateOrCreate(
                            ['id' => $request->id],
                            [
                                'document_id' => $document_id,
                                'previous_user_id' => $previous_task_owner->reviewer_id,
                                'user_id' => $request->user_id,
                                'action' => $request->action,
                                'end_date' => $request->end_date,
                                'created_by' => \Auth::user()->id,
                            ]
                        );

                    // updating record for task Review
                    $data = array('reviewer_id' => $request->user_id,  'updated_at' => date('Y-m-d h:i:s'));
                    \App\AssignContractToUser::where('requisition_id', $document_id)->update($data);
                    break;

                case 'Approval':
                    $add = \App\AssignTask::updateOrCreate(
                            ['id' => $request->id],
                            [
                                'document_id' => $document_id,
                                'previous_user_id' => $previous_task_owner->approver_id,
                                'user_id' => $request->user_id,
                                'action' => $request->action,
                                'end_date' => $request->end_date,
                                'created_by' => \Auth::user()->id,
                            ]
                        );

                    // updating record for task Approval
                    $data = array('approver_id' => $request->user_id,  'updated_at' => date('Y-m-d h:i:s'));
                    \App\AssignContractToUser::where('requisition_id', $document_id)->update($data);
                    break;

                default:
                    // code...
                    break;
            }


            if ($request->ajax()) {
                return response()->json(['details' => $add, 'status' => 'ok', 'info' => 'Task Assignment was successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Task Assignment was successfully.']);
            }

            return redirect()->route('admin.assign-tasks')->with(['success' => 'Task Assignment was successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }


    public function get_assign_by_id(Request $request)
    {
        //
        $assigned = \App\AssignTask::where('id', $request->id)->with(['document', 'delegate', 'author'])->first();
        return response()->json($assigned);
    }


    public function delete_assign(Request $request)
    {
        //return $request->all();
        try {
            \App\AssignTask::where('id', $request->id)->delete();

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Assigned task deleted successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Assigned task deleted successfully.']);
            }
            return redirect()->back()->with(['success' => 'Assigned task deleted successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }



    //DELEGATE
    public function delegateRole(Request $request)
    {
        //return $request->all();  
        $today = date('Y-m-d');
        $delegate_roles = \App\DelegateRole::orderBy('id', 'desc')->get();
        $users = \App\User::orderBy('name', 'asc')->get();
        $roles = \App\Role::orderBy('name', 'asc')->get();
        $departments = \App\Department::orderBy('name', 'asc')->get();

        $department_id = \Auth::user()->department_id;
        $department = \Auth::user()->department->name;

        $expired = \App\DelegateRole::where('end_date', '<', $today)->get();
        $active = \App\DelegateRole::where('end_date', '>=', $today)->get();

        return view('admin.delegate-role', compact('delegate_roles', 'users', 'roles', 'departments', 'today', 'expired', 'active', 'department_id', 'department'));
    }


    public function addDelegateRole(Request $request)
    {
        $department_id = $request->department_id;
        $prev_user_dept = \App\Department::where('id', $department_id)->first();
        try {
            //return $request->all();
            $add = \App\DelegateRole::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'department_id' => $department_id,
                        'prev_dept_head_id' => $prev_user_dept->department_head_id,
                        'user_id' => $request->user_id,
                        'role_id' => \Auth::user()->role_id,
                        'end_date' => $request->end_date,
                        'delegated_by' => \Auth::user()->id,
                    ]
                );

            // updating records
            $data = array('department_head_id' => $request->user_id,  'updated_at' => date('Y-m-d h:i:s'));
            \App\Department::where('id', $request->department_id)->update($data);


            $Data = array('user_id' => $request->user_id,  'updated_at' => date('Y-m-d h:i:s'));
            \App\Stage::where('user_id', $request->user_id)->update($Data);


            $DATE = array('approver_id' => $request->user_id,  'updated_at' => date('Y-m-d h:i:s'));
            \App\AssignContractToUser::where('approver_id', $request->user_id)->update($DATE);


            if ($request->ajax()) {
                return response()->json(['details' => $add, 'status' => 'ok', 'info' => 'Role delegated successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Role delegated successfully.']);
            }

            return redirect()->route('admin.delegate-role')->with(['success' => 'Role delegated successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }


    public function get_delegate_by_id(Request $request)
    {
        //
        $delegate = \App\DelegateRole::where('id', $request->id)->first();
        return response()->json($delegate);
    }


    public function delete_delegate(Request $request)
    {
        //return $request->all();
        try {
            \App\DelegateRole::where('id', $request->id)->delete();

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Delegate deleted successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Delegate deleted successfully.']);
            }
            return redirect()->back()->with(['success' => 'Delegate deleted successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }






    //MESSAGE SETUP
    public function emailMessages(Request $request)
    {
        $messages = \App\EmailMessage::orderBy('id', 'desc')->get();
        $users = \App\User::orderBy('name', 'asc')->get();

        return view('admin.messages', compact('messages', 'users'));
    }


    public function addMessage(Request $request)
    {
        try {
            // return $request->all();
            $add = \App\EmailMessage::updateOrCreate(
                    ['id' => $request->id],
                    [
                        'header' => $request->header,
                        'title' => $request->title,
                        'message' => $request->message,
                        'created_by' => \Auth::user()->id,
                    ]
                );

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'New Email Message Created Successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'New Email Message Created Successfully.']);
            }

            return redirect()->route('admin.messages')->with(['success' => 'New Email Message Created Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }


    public function get_message_by_id(Request $request)
    {
        //
        $message = \App\EmailMessage::where('id', $request->id)->first();
        return response()->json($message);
    }


    public function delete_message(Request $request)
    {
        //return $request->all();
        try {
            \App\EmailMessage::where('id', $request->id)->delete();

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Email Message Deleted Successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Email Message Deleted Successfully.']);
            }
            return redirect()->route('admin.messages')->with(['success' => 'Email Message Deleted Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }
}
