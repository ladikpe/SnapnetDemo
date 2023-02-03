<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
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

    // public function users_api(Request $request)
    // {
    //     $users = file_get_contents('http://localhost:1000/getAllUsers');
    //     // dd($users);
    //     foreach ($users as $k => $user) 
    //     {
    //         $add = \App\Role::updateOrCreate
    //         (['id'=> $request->id],
    //         [              
    //             'name' => $request->name,
    //             'description' => $request->description,
    //             'created_by' => \Auth::user()->id,
    //         ]);
    //     }
    // }


    public function index(Request $request)
    {
        $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        if(!$column){ $column = 'id'; }    if(!$sort){ $sort = 'desc'; }
        if ($search || $column || $sort)
        {
            $roles = \App\Role::where('id', 'like', "%{$search}%")->where('name', 'like', "%{$search}%")
                ->orwhere('description', 'like', "%{$search}%")->orderBy($column, $sort)->paginate(10);
        }
        else
        { 
            $roles = \App\Role::orderBy('id', 'desc')->paginate(10);
        }

        $users = \App\User::where('name', 'asc')->get();
        $no_of_roles = \App\Role::orderBy('id', 'desc')->count();

        return view('roles.index', compact('roles', 'users', 'no_of_roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.new');
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
            // return $request->all();
            //adding document versions
            $add = \App\Role::updateOrCreate
            (['id'=> $request->id],
            [              
                'name' => $request->name,
                'description' => $request->description,
                'created_by' => \Auth::user()->id,
            ]);
  

            //email notification
            // $this->send_creation_mail($request->name, $requisition_type->name, $requisition);

            if($request->ajax())
            {
                return response()->json(['details' => $add, 'status'=>'ok', 'info'=>'New Role Create Successfully.']);
            }
            else
            {
                return redirect()->back()->with(['status'=>'ok', 'info'=>'New Role Create Successfully.']);
            }            
              
            return redirect()->route('roles.index')->with(['success' => 'New Role Create Successfully']);
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
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

        $role=Role::find($id);
        return view('roles.edit',['role'=>$role]);
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
          $this->validate($request, ['name'=>'required|min:3']);
          $role=Role::find($id);
          $role->name=$request->name;
          $role->description=$request->description;
          $role->save();
          $message="Role updated successfully";
          return redirect()->route('roles.list')->with(['message'=>$message]);
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
        try {
          $role=Role::find($id);
          $role->delete();
          $message="Role deleted successfully";
          return redirect()->route('roles.list')->with(['message'=>$message]);
        } catch (\Exception $e) {

        }

    }







    public function get_role_by_id(Request $request)
    {
        //
        $role = \App\Role::where('id', $request->id)->first();
        return response()->json($role); 
    }




    public function users_api(Request $request) //NOTE URL USING aar_hcm
    {
        $users = json_decode(file_get_contents('http://localhost:1000/getAllUsers'));  $add = []; 
        //return $users;
        foreach ($users as $k => $user) 
        {
            $add[$k] = $added = \App\UserImport::updateOrCreate
            (['id'=> $user->id],
            [              
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'role_id' => $user->role_id,
                'department_id' => $user->department_id,
                // 'status' => $user->status,
                'phone' => $user->phone,
                // 'signature' => $user->signature,
                // 'remember_token' => $user->remember_token,
                // 'api_token' => $user->api_token,
            ]);
        }   //dd($add);
    }

}
