<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\CausesActivity;
use App\Group;
use DB;

class User extends Authenticatable
{
    use Notifiable, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role_id', 'department_id', 'signature', 'signature_path', 'image', 'status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    

    public function groups()
    {
      return $this->belongsToMany('App\Group', 'group_user', 'user_id', 'group_id');
    }
    public function docReviews()
    {
      return $this->hasManyThrough('App\Review','App\Stage');
    }
    public function audit_logs()
    {
        return $this->morphMany('App\AuditLog', 'auditable');
    }
    public function reviews()
    {
      $reviews=DB::table('document_reviews')
      ->join('stages', 'document_reviews.stage_id', '=', 'stages.id')
      ->join('users', 'stages.user_id', '=', 'users.id')
      ->where('stages.user_id',$this->id)
      ->get();
      return $reviews;
    }
    public function approvedReviews()
    {
      $reviews=DB::table('document_reviews')
      ->join('stages', 'document_reviews.stage_id', '=', 'stages.id')
      ->join('users', 'stages.user_id', '=', 'users.id')
      ->where('status', 1)
      ->get();
      return $reviews;
    }
    public function rejectedReviews()
    {
      $reviews=DB::table('document_reviews')
      ->join('stages', 'document_reviews.stage_id', '=', 'stages.id')
      ->join('users', 'stages.user_id', '=', 'users.id')
      ->where('status', 2)
      ->get();
      return $reviews;
    }
    public function pendingReviews()
    {
      $reviews=DB::table('document_reviews')
      ->join('stages', 'document_reviews.stage_id', '=', 'stages.id')
      ->join('users', 'stages.user_id', '=', 'users.id')
      ->where('status', 0)
      ->get();
      return $reviews;
    }

    

    public function comments()
    {
        return $this->morphMany('App\ContractComment', 'commentable');
    }

    public function details()
    {
        return $this->morphMany('App\ContractDetail', 'updatable');
    }

    public function signatures()
    {
        return $this->morphMany('App\ContractSignature', 'signable');
    }

    

    public function department()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }


    public function roles()
    {
        return$this->belongsTo('App\Role', 'role_id');
    }


    public function user_roles()
    {
        return$this->belongsTo('App\UserRole', 'user_id');
    }



    
}
