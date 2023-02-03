<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\AuditLog;
use App\Filters\UserFilter;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserAccountCreated;
use App\Mail\PasswordResetNotification;
use App\Traits\LogAction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;



class UserController extends Controller
{
    use LogAction;

    public function __construct()
    {
        $this->middleware('auth')->except(['reset_password']);
    }






    //PASSWORD RESET email
    public function send_reset_password_mail($user, $password)
    {
        //LEGAL HEAD EMAIL
        $user = \App\User::where('id', $user->id)->first();
        $sender = 'erpproject@aarinvest.com';
        $name = $user->name;
        $url = url('change-password');
        $message = "Your password was reset successfully. See new default password : " .$password. " Click the link below to login and change your password Immediately";

        Mail::to($user)->send(new PasswordResetNotification($message, $sender, $name, $url, 'Password Reset Notification'));
    }


    //ACCOUNT DEACTIVATION email
    public function send_deactivate_acc_mail($user)
    {
        //LEGAL HEAD EMAIL
        $user = \App\User::where('id', $user->id)->first();
        $sender = 'erpproject@aarinvest.com';
        $name = $user->name;
        $url = route('home');
        $message = "Your aacount has been deactivated, you can  o longer login to this platform";

        Mail::to($user)->send(new PasswordResetNotification($message, $sender, $name, $url, 'Account Deactivation Notification'));
    }





    
    public function index(Request $request, User $user)
    {  
      if (count($request->all())==0)
      {
        $users=User::withCount('groups')->orderBy('id', 'desc')->get();
        $user_count=User::get();
        $roles = \App\Role::orderBy('name', 'asc')->get();
        $controllerName = new UserController;

        return view('users.list', compact('users', 'roles', 'controllerName', 'user_count'));
      }
      else
      {
        $users=UserFilter::apply($request);
        $roles = \App\Role::orderBy('name', 'asc')->get();
        $user_count=User::get();
        $controllerName = new UserController;
        // return $users;
        return view('users.list', compact('users', 'roles', 'controllerName', 'user_count'));
      }
      // $users=User::withCount('groups')->get();
      // return view('users.list',['users'=>$users]);
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
         if (Auth::user()->role_id == 1)
         {
            $groups=Group::all();
            $departments = \App\Department::orderBy('name', 'asc')->get();
            $roles = \App\Role::orderBy('name', 'asc')->get();
            return view('users.create', compact('groups', 'departments', 'roles'));
         }else { }

       } catch (\Exception $e) { }
     }

     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */

     public function store(Request $request)
     {
       $this->validate($request, ['name'=>'required|min:3','email' => 'unique:users']);
       $user=new User();
       $user->name=$request->name;
       $user->email=$request->email;
       $user->role_id=$request->role_id;
       $user->status=1;
       $user->department_id=$request->department_id;
       $user->password= bcrypt('qwerty!@#');
       $user->save();

       if ($request->file('signature')) 
       {
          $path = $request->file('signature')->store('public');
          if (Str::contains($path, 'public/')) 
          {
            $filepath = Str::replaceFirst('public/', '', $path);
          } 
          else 
          {
            $filepath = $path;
          }
          $user->signature = $filepath;
        }
        $user->save();

         // $no_of_groups=count($request->input('group_id'));
         // if($no_of_groups>0)
         // {
         //    for ($i=0; $i <$no_of_groups ; $i++) 
         //    {
         //      $user->groups()->attach($request->group_id[$i], ['created_at' => date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
         //      $group=Group::find($request->group_id[$i]);
         //      $logmsg='User was added to the '.$group->name." group";
         //      $this->saveLog('info','App\User',$user->id, 'users', $logmsg, Auth::user()->id);
         //    }
         // }
         $user->notify(new UserAccountCreated($user));
         $logmsg='User was created';
         $this->saveLog('info','App\User',$user->id,'users',$logmsg,Auth::user()->id);

        return redirect()->route('users')->with(['success'=>'User Created Successfully']);
    }


    public function upload_user(Request $request)
    {
        $this->validate($request, ['file' => 'required|mimes:csv,xlsx,txt']);

        try {
            $getFile = $request->file('file')->getRealPath();
            $ob = \PhpOffice\PhpSpreadsheet\IOFactory::load($getFile);
            $ob = $ob->getActiveSheet()->toArray(null, true, true, true);

            foreach ($ob as $key => $row) {
                //getting the roles
                $role = \App\Role::where('name', $row['C'])->first();
                if ($role) {   $role_id= $role->id;  } 
                else {   $role_id= 0;   }

                //departments
                $department = \App\Department::where('name', $row['D'])->first();
                if ($department) {   $department_id= $department->id;  } 
                else {   $department_id= 0;   }

                if ($key >= 2) 
                {
                    //UPLOADING NEW
                    $upload = \App\User::updateOrCreate(
                        ['email' => $row['B']],
                        [
                            'password' => bcrypt('qwerty!@#'),
                            'name' => $row['A'],
                            'email' => $row['B'],
                            'role_id' => $role_id,
                            'department_id' => $department_id,
                            'status' => 1
                        ]
                    );

                    //email notification
                    // $this->vendor_registration_mail($vendor_name, $upload->id);
                }
            }

            return redirect()->back()->with(['success' => 'New users uploaded successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage());
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
         $user= User::find($id);
         $groups = Group::all();
         $roles = \App\Role::orderBy('name', 'asc')->get();
         $department = \App\Department::where('id', $id)->first();
         return view('users.view', compact('user', 'groups', 'roles', 'department'));
       } 
       catch (\Exception $e) 
       {

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
         $user = User::find($id);
         $groups = Group::all();
         $department = \App\Department::where('id', $user->department_id)->first();
         $departments = \App\Department::orderBy('name', 'asc')->get();

         $role = \App\Role::where('id', $user->role_id)->first();
         $roles = \App\Role::orderBy('name', 'asc')->get();
         return view('users.edit', compact('user', 'groups', 'department', 'departments', 'role', 'roles'));
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
        // try {

        $this->validate($request, ['name'=>'required|min:3', 'email' => ['required', Rule::unique('users')->ignore($id) ]]);
        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->role_id=$request->role_id;
        $user->department_id=$request->department_id;
        $user->save();
        if ($request->file('signature')) 
        {
          $path = $request->file('signature')->store('public');
          if (Str::contains($path, 'public/')) {
          $filepath = Str::replaceFirst('public/', '', $path);
        } 
        else 
        {
          $filepath = $path;
        }
        $user->signature = $filepath;
      }
      $user->save();

        // $no_of_groups=count($request->input('group_id'));
        // foreach ($user->groups as $ugrp) 
        // {
        //   $logmsg='User removed from the '.$ugrp->name." group";
        //   $this->saveLog('info','App\User',$user->id,'users',$logmsg,Auth::user()->id);
        // }
        // $user->groups()->detach();
        // if($no_of_groups>0)
        // {
        //   for ($i=0; $i <$no_of_groups ; $i++) 
        //   {
        //     $user->groups()->attach($request->group_id[$i],['created_at' => date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        //     $group=Group::find($request->group_id[$i]);
        //     $logmsg='User was added to the '.$group->name." group";
        //     $this->saveLog('info','App\User',$user->id,'users',$logmsg,Auth::user()->id);
        //   }
        //   $logmsg='User details was edited';
        //   $this->saveLog('info','App\User',$user->id,'users',$logmsg,Auth::user()->id);
        // }
        return redirect()->route('users')->with(['success'=>'Changes saved successfully']);
         // } catch (\Exception $e) {
         //
         // }


     }
     public function profile()
     {
       $user=Auth::user();
       return view('users.profile',['user'=>$user]);
     }

     public function updateProfile(Request $request)
     {
       try 
       {
          $user=Auth::user();
          $this->validate($request, ['name'=>'required|min:3','email'=>'required|email',Rule::unique('users')->ignore($user->id)]);
          $user->name=$request->name;
          $user->email=$request->email;
          $user->save();

          $logmsg='User updated profile';
          $this->saveLog('info','App\User',$user->id,'users',$logmsg,Auth::user()->id);
          return redirect()->back()->with("success","Profile Updated successfully !");
       } 
       catch (\Exception $e) 
       {

       }

     }


     public function changePassword(Request $request)
     {
       try 
       {
         if (!(Hash::check($request->get('current-password'), Auth::user()->password))) 
         {
             // The passwords matches
             return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
         }

         if(strcmp($request->get('current-password'), $request->get('new-password')) == 0)
         {
             //Current password and new password are same
             return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
         }

         $validatedData = $request->validate([
             'current-password' => 'required',
             'new-password' => 'required|string|min:6|confirmed',
         ]);

         //Change Password
         $user = Auth::user();
         $user->password = bcrypt($request->get('new-password'));
         $user->save();

         $logmsg='User changed password';
         $this->saveLog('info','App\User',$user->id,'users',$logmsg,Auth::user()->id);
         return redirect()->back()->with("success-pass","Password changed successfully !");


       } catch (\Exception $e) 
       {

       }


     }






    public function userChangePassword(Request $request)
    {
        $user = Auth::user();
        $controllerName = new UserController;

        return view('users.change-password', compact('user', 'controllerName')); 
    }





    public function saveChangePassword(Request $request)
    {
       try 
       {
            // return $request->all();
            if (!(Hash::check($request->current_password, Auth::user()->password))) 
            {
                // The passwords matches
                return redirect()->back()->with(['status' => 'ok', 'error' => 'Your current password does not matches with the password you provided. Please try again.']);
            }

            if(strcmp($request->current_password, $request->password) == 0)
            {
                //Current password and new password are same
                return redirect()->back()->with(['status' => 'ok', 'error' => 'New Password cannot be same as your current password. Please choose a different password.']);
            }

            //Change Password
            $user = Auth::user();
            $user->password = bcrypt($request->get('new-password'));
            $user->save();

            return redirect()->back()->with(['status' => 'ok', 'success' => 'Password saved successfully']);

        } 
        catch (\Exception $e)
        {
            return ['status'=>'error', 'error'=>'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()];
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
         try 
         {
           $user=User::find($id);
           $user->delete();
           $message="User deleted successfully";
           $logmsg='User deleted';
           $this->saveLog('info','App\User',$user->id,'users',$logmsg,Auth::user()->id);
           return redirect()->route('users.list')->with(['message'=>$message]);
         } 
         catch (\Exception $e) {

         }

     }
     public function alterStatus(Request $request)
     {
       if ($this->isSuperAdmin($request->id)) 
       {
         return response()->json('Cannot be changed. User is Super Admin',200);
       }
     else
     {
        $wf=User::find($request->id);
        if ($request->status=='true') 
        {
         $wf->status=1;
         $wf->save();
         return response()->json('enabled',200);
       }
       elseif($request->status=='false')
       {
         $wf->status=0;
         $wf->save();
         return response()->json('disabled',200);
       }
     }

     }
     public function isSuperAdmin($id)
     {
       $user=User::find($id);
       if ($user->role_id==1) 
       {
         return true;
       }
       else 
       {
         return false;
       }
     }





    public function get_user_by_id(Request $request)
    {
        $user = \App\User::where('id', $request->id)->first();
        return response()->json($user); 
    }



    public function get_all_assigned_roles(Request $request)
    {
        $user_roles = \App\UserRole::where('user_id', $request->user_id)->get();
        return response()->json($user_roles);
    }



    public function getUserRoles($user_id)
    {
        $user_roles = \App\UserRole::where('user_id', $user_id)->first();
        return  $user_roles;
    }


    public function addRolesToUser(Request $request)
    {
        try
        {
            // return $request->all();
            $count = count($request->input('role_array'));
            $userRole = \App\UserRole::where('user_id', $request->user_id)->delete();


            if($count > 0)
            {
              for ($i=0; $i <$count ; $i++) 
              {
                  $add = \App\UserRole::create
                  ([              
                      'user_id' => $request->user_id,
                      'role_id' => $request->role_array[$i],
                      'created_by' => \Auth::user()->id,
                  ]);
              } 
            }
                       

            //email notification
            //$this->send_creation_mail($request->name, $requisition_type->name, $requisition);

            if($request->ajax())
            {
                return response()->json(['details' => $add, 'status'=>'ok', 'info'=>'Role(s) assigned to user successfully.']);
            }
            else
            {
                return redirect()->back()->with(['status'=>'ok', 'info'=>'Role(s) assigned to user successfully.']);
            }            
              
            return redirect()->route('roles.index')->with(['success' => 'Role(s) assigned to user successfully']);
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        }
    }



    public function reset_user_password(Request $request)
    {
        try
        {    

            //GENERATING PASSWORD RANDOM NUMBERS AND LETTERS                       $rand = substr(uniqid('', true), -5);
            $letters = array_merge(range('a', 'z'), range('A', 'Z'));

            $rand = $letters[rand(0, 51)];
            $rand1 = $letters[rand(0, 51)];
            $rand2 = $letters[rand(1, 51)];

            $random_pass = $rand;
            $random_pass .= mt_rand(11, 99);
            $random_pass .= $rand1;
            $random_pass .= mt_rand(11, 99);
            $random_pass .= $rand2;
            $random_pass .= mt_rand(11, 99);

            $password = bcrypt($random_pass);

            $id = $request->userId;
            $user = \App\User::where('id', $id)->first();

            $data = array('password' => $password);
            $updated = \App\User::where('id', $id)->update($data);

            //email notification
            $this->send_reset_password_mail($user, $random_pass);

            // return response()->json(['status'=>'ok', 'success'=>'Password reset was successfully']);
            return redirect()->back()->with(['status'=>'ok', 'success'=>'Password reset was successfully']);
        }
        catch (\Exception $e)
        {
            return  redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
        }
    }


    public function reset_password(Request $request)
    {
        try
        {    
            // return $request->all();

            $email = $request->email;
            $user = \App\User::where('email', $email)->first();
            if(!$user)
            {
                return redirect()->back()->with('error', 'Sorry, provided email not registered on this platform. ');
            }


            //GENERATING PASSWORD RANDOM NUMBERS AND LETTERS                       $rand = substr(uniqid('', true), -5);
            $letters = array_merge(range('a', 'z'), range('A', 'Z'));

            $rand = $letters[rand(0, 51)];
            $rand1 = $letters[rand(0, 51)];
            $rand2 = $letters[rand(1, 51)];

            $random_pass = $rand;
            $random_pass .= mt_rand(11, 99);
            $random_pass .= $rand1;
            $random_pass .= mt_rand(11, 99);
            $random_pass .= $rand2;
            $random_pass .= mt_rand(11, 99);

            $password = bcrypt($random_pass);



            $data = array('password' => $password);
            $updated = \App\User::where('id', $user->id)->update($data);

            //email notification
            $this->send_reset_password_mail($user, $random_pass);

            // return response()->json(['status'=>'ok', 'success'=>'Password reset was successfully']);
            return redirect()->back()->with(['status'=>'ok', 'success'=>'Password reset was successfully. Please check your mail']);
        }
        catch (\Exception $e)
        {
            return  redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
        }
    }



    public function deactivate_account(Request $request)
    {
        try
        {  
            // return $request->all(); 

            $id = $request->userid_dec_acc;
            $user = \App\User::where('id', $id)->first();

            $data = array('password' => '', 'status' => 0);
            $updated = \App\User::where('id', $id)->update($data);

            //email notification
            $this->send_deactivate_acc_mail($user);

            // return response()->json(['status'=>'ok', 'success'=>'Access deactivated successfully']);
            return redirect()->back()->with(['status'=>'ok', 'success'=>'Access deactivated successfully']);
        }
        catch (\Exception $e)
        {
            return  redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
        }
    }

}
