<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Group;
use App\Folder;
use App\Review;
use App\Document;
use App\WorkFlow;
use Illuminate\Support\Facades\Auth;

class VendorHomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth:vendor');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function soctest()
  {
    // header( 'Content-type: text/html; charset=utf-8' );
    echo 'Begin ...<br />';
    for ($i = 0; $i < 10; $i++) 
    {
      echo $i . '<br />';
      flush();
      ob_flush();
      sleep(1);
    }
    echo 'End ...<br />';
    // echo 'works';
  }


  public function vendor_home(Request $request)
  {
      //BIDS
      $today = date('Y-m-d');

      $submitted_bids = \App\BidSubmission::where('vendor_id', Auth::guard('vendor')->user()->id)->orderBy('created_at', 'desc')->get();
      $bid_count = $submitted_bids->count();

      $bid_docs = \App\VendorDocument::where('vendor_id', Auth::guard('vendor')->user()->id)->orderBy('created_at', 'desc')->get();
      $bid_doc_count = $submitted_bids->count();

      $expired_docs = $submitted_bids->where('expiry_date', '<', $today)->count();

      return view('vendor-home', compact('submitted_bids', 'bid_count', 'bid_docs', 'bid_doc_count', 'expired_docs'));
  }


}
