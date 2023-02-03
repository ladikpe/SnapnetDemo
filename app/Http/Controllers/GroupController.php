<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Filters\GroupFilter;
use App\User;
use App\Traits\LogAction;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
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
            if (count($request->all())==0) {
          $users=User::all();
          $groups = Group::withCount('users')->paginate(15);
          return view('groups.list',['groups'=>$groups,'users'=>$users]);
        }else{
          $users=User::all();
            $groups=GroupFilter::apply($request);
            // return $users;
            return view('groups.list',['groups'=>$groups,'users'=>$users]);

          }
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
            $users=User::all();
            return view('groups.create',['users'=>$users]);
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
          $no_of_users=count($request->input('user_id'));
          $this->validate($request, ['name'=>'required|min:2']);
          $group=new Group();
          $group->name=$request->name;
          $group->save();
          $logmsg='Group created';
          $this->saveLog('info','App\Group',$group->id,'groups',$logmsg,Auth::user()->id);
          if($no_of_users>0){
          for ($i=0; $i <$no_of_users ; $i++) {
            $group->users()->attach($request->user_id[$i],['created_at' => date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
            $user=User::find($request->user_id[$i]);
            $logmsg='User was added to '.$group->name;
            $this->saveLog('info','App\User',$user->id,'users',$logmsg,Auth::user()->id);
          }
          }
           return redirect()->route('groups')->with(['success'=>'Group Created Successfully']);
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
          $group= Group::find($id);
          return view('groups.view',['group'=>$group]);
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
        $group= Group::find($id);
        $users=User::all();
        return view('groups.edit',['group'=>$group,'users'=>$users]);
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
        $group=Group::find($id);
        $no_of_users=count($request->input('user_id'));
        $this->validate($request, ['name'=>'required|min:2']);
        $group->name=$request->name;
        $group->save();
        $logmsg='Group Edited';
        $this->saveLog('info','App\Group',$group->id,'groups',$logmsg,Auth::user()->id);
        if($no_of_users>0){
        for ($i=0; $i <$no_of_users ; $i++) {
          if ($group->users->contains('id',$request->user_id[$i])) {
            # code...
          }else{
          $group->users()->attach($request->user_id[$i],['created_at' => date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
          $logmsg='User was added to '.$group->name;
          $this->saveLog('info','App\User',$request->user_id[$i],'users',$logmsg,Auth::user()->id);
          }

        }
        }
         return redirect()->route('groups')->with(['success'=>'Group Updated Successfully']);
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
