<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserFilter
{
    public static function apply(Request $filters)
    {
        $user = (new User)->orderBy('id', 'desc')->newQuery();

        // Search for a user based on their email.
        if ($filters->filled('email_contains')) {
            $user->where('email','like' ,'%' . $filters->input('email_contains') . '%');
        }
        if ($filters->filled('email_equals')) {
            $user->where('email', $filters->input('email_equals'));
        }
        if ($filters->filled('email_starts_with')) {
            $user->where('email','like', '%' . $filters->input('email_starts_with'));
        }
        if ($filters->filled('email_ends_with')) {
            $user->where('email','like', $filters->input('email_ends_with'). '%');
        }
          // Search for a user based on their role.
          if ($filters->filled('role')) {
            $role=$filters->input('role');
            $user->where(function($query) use ($role){
              $query->where('role_id', $role[0]);
              if (count($role)>1) {
              for ($i=1; $i <count($role) ; $i++) {
                $query->orWhere('role_id', $role[$i]);
              }
              }
            });
          }
        // Search for a user based on their creation date.
        if ($filters->filled('created_to')) {
          $dt_from=Carbon::parse($filters->input('created_from'));
          $dt_to=Carbon::parse($filters->input('created_to'));
            $user->whereBetween('created_at', [$dt_from,$dt_to]);
        }


        // Get the results and return them.
        return $user->paginate(15);

        }


    }
