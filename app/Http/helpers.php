<?php

/*
|--------------------------------------------------------------------------
| Detect Active Route
|--------------------------------------------------------------------------
|
| Compare given route with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
use Illuminate\Support\Facades\DB;
function isActiveRoute($route, $output = "active")
{
    if (Route::currentRouteName() == $route) return $output;
}

/*
|--------------------------------------------------------------------------
| Detect Active Routes
|--------------------------------------------------------------------------
|
| Compare given routes with current route and return output if they match.
| Very useful for navigation, marking if the link is active.
|
*/
function areActiveRoutes(Array $routes, $output = "active")
{
    foreach ($routes as $route)
    {
        if (Route::currentRouteName() == $route) return $output;
    }

}
function stage_user($stage_id){
  $user=DB::table('stages')
  ->join('users', 'stage.user_id', '=', 'users.id')
  ->where('stages.user_id', $id)->first();
  return $user;
}
function getReviewStatus($document_id)
{
  $status=DB::table('document_reviews')
  ->join('stages','document_reviews.stage_id','=','stages.id')
  ->where(['document_reviews.document_id'=>$document_id,'status'=>0])->exists();
  return $status;

}
function getDocumentReview($document_id,$stage_id)
{
  $review=\App\Review::where(['document_id'=>$document_id,'stage_id'=>$stage_id])->first();
  return $review;
}
