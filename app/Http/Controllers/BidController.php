<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\RequisitionEmail;
use App\Notifications\InviteToBidNotification;
use DB;
use Illuminate\Support\Facades\Input;
use Excel;

class BidController extends Controller
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



    public function send_bid_invitation_mail($bidders, $email_list, $email_message, $bid_id, $bid_name)
    {
        //Getting all Vendors to notify    
        foreach ($bidders as $bidder) 
        {            
            $vendor = \App\Vendor::where('id', $bidder->vendor_id)->first();
            //sending email to User
            $sender = Auth::user()->email;  $name = $vendor->name;         $url = url('vendor-bids', [$bid_id]); 
            $message = "This is an email notification of an invitation to bid for ".$bid_name->name.", from AA&R. Click the link below to view more details for this bid.";

            $vendor->notify(new InviteToBidNotification($message, $sender, $name, $url));
        }


        //Getting all User in distribution list to notify    
        foreach ($email_list as $list) 
        {
            $user = \App\User::where('id', $list->user_id)->first();
            //sending email to User
            $sender = Auth::user()->email;  $name = $user->name;         $url = route('bid-packages', [$bid_id]);  
            $message = "An invitaion to bid email was sent to all shortlisted vendors for , ".$bid_name->name." by ". \Auth::user()->name.". ";

          $user->notify(new RequisitionEmail($message, $sender, $name, $url));
        }
    }



    public function bid_number($count, $pre)
    {
        //$dated = getdate();
        $number = '';
        $number .= $pre;
        //$number .= $dated['year'];
        if($count < 10) {           $number .= '-00000'; }
        else if($count >= 10){      $number .= '-0000';  }
        else if($count >= 100){     $number .= '-000';   }
        else if($count >= 1000){    $number .= '-00';    }
        else if($count >= 10000){   $number .= '-0';     }
        else if($count >= 100000){  $number .= '-';      }
        $number .= $count;
        return $number;
    }







    public function index(Request $request)
    {
        //     
        $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        if(!$column){ $column = 'id'; }    if(!$sort){ $sort = 'desc'; }
        if ($search || $column || $sort)
        {
            $bids = \App\Bid::where('bid_code', 'like', "%{$search}%")->where('name', 'like', "%{$search}%")
                ->orwhere('description', 'like', "%{$search}%")->orwhere('start_date', 'like', "%{$search}%")
                ->orwhere('end_date', 'like', "%{$search}%")
                ->orwhereHas('industry', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                ->orderBy($column, $sort)->paginate(10);
        }
        else
        { 
            $bids = \App\Bid::orderBy('id', 'desc')->paginate(10);
        }

        $industries = \App\BidIndustry::orderBy('name', 'asc')->get();
        $controllerName = new BidController;

        return view('bids.index', compact('bids', 'industries', 'controllerName'));
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
        // return $request->all();
        try
        {
            //setting version number
            $words = explode(" ", $request->name);
            $acronym = "";
            foreach ($words as $w) { $acronym .= $w[0]; }

            $count = \App\Bid::orderBy('id', 'desc')->first();     $bid_count = $count->id + 1;
            $bidNo = $this->bid_number($bid_count, $acronym);

            $addBid = \App\Bid::updateOrCreate
            (['id'=> $request->id],
            [              
                'bid_code' => $bidNo,
                'name' => $request->name,
                'description' => $request->description,
                'instruction' => $request->instruction,
                'bid_type' => $request->bid_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'industry_id' => $request->industry_id,
                'countdown' => $request->countdown,
                'submission_after' => $request->submission_after,
                'status_id' => 1,
                'created_by' => \Auth::user()->id,
            ]);
                

            if($request->ajax())
            {
                return response()->json(['details' => $addBid, 'status'=>'ok', 'info'=>'New Bid Create Successfully.']);
            }
            else
            {
                return redirect()->back()->with(['details' => $addBid, 'status'=>'ok', 'info'=>'New Bid Create Successfully.']);
            }            
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        }
    }


    public function upload_bid(Request $request)
    {
        $this->validate($request, ['file' => 'required|mimes:csv,xlsx,txt']);

        try
        {
            $getFile=$request->file('file')->getRealPath();
            $ob = \PhpOffice\PhpSpreadsheet\IOFactory::load($getFile);
            $ob = $ob->getActiveSheet()->toArray(null, true, true, true);

            foreach ($ob as $key => $row)
            {
                if($key >=2)
                {
                    //setting version number
                    $words = explode(" ", $row['A']);   $acronym = "";
                    foreach ($words as $w) { $acronym .= $w[0]; }

                    $count = \App\Bid::orderBy('id', 'desc')->first();     $bid_count = $count->id + 1;
                    $bidNo = $this->bid_number($bid_count, $acronym);   

                    //UPLOADING NEW
                    $upload = \App\Bid::updateOrCreate
                    (['id'=> $request->id],
                    [
                        'bid_code' => $bidNo,
                        'name' => $row['A'],
                        'description' => $row['B'],
                        'bid_type' => $row['C'],
                        'start_date' => date('Y-m-d', strtotime($row['D'])),
                        'end_date' => date('Y-m-d', strtotime($row['E'])),
                        'industry_id' => $row['F'],
                        'status_id' => 1,
                        'created_by' => \Auth::user()->id,
                    ]);
                }
            }

            return redirect()->back()->with(['success'=>'Bids Upload']);
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
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

    public  function getBidDetails(Request $request)
    {
        $vendor = \App\Bid::where('id', $request->id)->first();
        return response()->json($vendor);
    }



    public function bid_packages(Request $request, $id)
    {
        //    
        $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        if(!$column){ $column = 'id'; }    if(!$sort){ $sort = 'desc'; }
        if ($search || $column || $sort)
        {
            $bid_email_lists = \App\BidEmailList::where('created_at', $search)
                // ->orwhereHas('bid', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                ->orwhereHas('user', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                ->orwhereHas('author', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                ->where('bid_id', $id)->orderBy($column, $sort)->paginate(10);
        }
        else
        { 
            $bid_email_lists = \App\BidEmailList::where('bid_id', $id)->orderBy('id', 'desc')->paginate(10);
        }

        $users = \App\User::orderBy('name', 'asc')->get();
        $documents = \App\BidDocument::where('bid_id', $id)->orderBy('id', 'desc')->get();

        $submitted_bids = \App\BidSubmission::where('bid_id', $id)->orderBy('id', 'desc')->get();
        $controllerName = new BidController;

        return view('bids.bid-packages', compact('bid_email_lists', 'users', 'documents', 'id', 'submitted_bids', 'controllerName'));
    }



    public function add_bid_email_list(Request $request)
    {
        //return $request->all();
        try
        {
            $addBidEmail = \App\BidEmailList::updateOrCreate
            (['id'=> $request->id],
            [              
                'bid_id' => $request->bid_id,
                'user_id' => $request->user_id,
                'created_by' => \Auth::user()->id,
            ]);
                

            if($request->ajax())
            {
                return response()->json(['details' => $addBidEmail, 'status'=>'ok', 'info'=>'New bid email list added.']);
            }
            else
            {
                return redirect()->back()->with(['details' => $addBidEmail, 'status'=>'ok', 'info'=>'New bid email list added.']);
            }            
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        }
    }
    
    public function upload_bid_attachment(Request $request)
    {
        //return $request->all();
        try
        {
            $id = $request->id;   $bid_id = $request->bid_id;
            $file = $request->file;
            $file_name = $request->file->getClientOriginalName();
            $destinationPath = 'assets\\images\\bids\\' . Input::file('file')->getClientOriginalName();
            $file->move($destinationPath, Input::file('file')->getClientOriginalName()); 

            $upload = \App\BidDocument::updateOrCreate
            (['id'=> $id],
            [
                'bid_id' => $bid_id,
                'name' => $request->name,
                'doc_name' => $file_name,
                'path' => $destinationPath,
                'created_by' => \Auth::user()->id,
            ]);  

            return response()->json(['status'=>'ok', 'info'=>'Bid document uploaded successfully']);
        }
        catch (\Exception $e)
        {
            return  redirect()->route('bid-packages', $bid_id)->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
            //return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }

    public function load_bid_document_table(Request $request)
    {
        $documents = \App\BidDocument::where('bid_id', $request->bid_id)->get();
        return view('bids.vendors.load-bid-document-table', compact('documents')); 
    }

    public function getBidDocumentDetails(Request $request)
    {
        $bid_documents = \App\BidDocument::where('id', $request->id)->first();
        return response()->json($bid_documents); 
    }


    public function delete_bid_document(Request $request)
    {
        try
        {
            $deletes = \App\BidDocument::where('id', $request->id)->delete();

            if($request->ajax())
            {
                return response()->json(['status'=>'ok', 'info'=>'Deleted.']);
            } 
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        } 
    }




    public function load_email_list_table(Request $request)
    {
        $bid_email_lists = \App\BidEmailList::where('bid_id', $request->bid_id)->orderBy('id', 'desc')->get();
        return view('bids.email-list-table', compact('bid_email_lists')); 
    }

    public function getBidEmailListDetails(Request $request)
    {
        $bid_email_lists = \App\BidEmailList::where('id', $request->id)->first();
        return response()->json($bid_email_lists); 
    }


    public function delete_email_list(Request $request)
    {
        try
        {
            $deletes = \App\BidEmailList::where('id', $request->id)->delete();

            if($request->ajax())
            {
                return response()->json(['status'=>'ok', 'info'=>'Deleted.']);
            } 
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        } 
    }






    public function search_for_bidders(Request $request, $bid_id)
    {     
        $bid_vendors = \App\SearchForBidder::where('bid_id', $bid_id)->orderBy('id', 'desc')->paginate(10);
        $bid_search = \App\SearchForBidder::where('bid_id', $bid_id)->first();

        $vendors = \App\Vendor::orderBy('name', 'asc')->get();
        $industries = \App\BidIndustry::orderBy('name', 'asc')->get();
        $states = \App\State::orderBy('state_name', 'asc')->get();
        $controllerName = new BidController;

        return view('bids.search-for-bidders', compact('bid_id', 'bid_vendors', 'vendors', 'industries', 'states', 'controllerName', 'bid_search'));
    }


    public function list_search_bidders(Request $request)
    {
        //return $request->all();

        $category = $request->category;    $state_id = $request->state_id;    $proximity = $request->proximity;   
        $industry_id = $request->industry_id;           $bid_id = $request->b_id;   

        $bid_vendors = \App\Vendor::where('category', $category)->where('state_id', $state_id)->where('address', 'like', "%{$proximity}%")
                // ->orwhereHas('industry', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                // ->whereHas('state', function($query) use ($request) { $query->where('state_name','like',"%{$request->search}%"); })
                ->orderBy('id', 'desc')->get();
                // dd($bid_vendors);   

        $industries = \App\BidIndustry::orderBy('name', 'asc')->get();
        $states = \App\State::orderBy('state_name', 'asc')->get();
        $controllerName = new BidController;

        if($state_id)
        { $state = \App\State::where('id', $state_id)->first(); $state_name = $state->state_name; }else{ $state_name = 'NA'; }
        if($industry_id)
        { $industry = \App\BidIndustry::where('id', $industry_id)->first(); $name = $industry->name; }else{ $name = 'NA'; }

        $shortlist_vendors = \App\SearchForBidder::where('bid_id', $bid_id)->orderBy('id', 'desc')->get();

        return view('bids.search-for-bidders', compact('bid_vendors', 'shortlist_vendors', 'industries', 'states', 'bid_id', 'controllerName', 'category', 'state_id', 'proximity', 'industry_id', 'state_name', 'name'));        
    }

    public function load_bidders_table(Request $request)
    {
        $shortlist_vendors = \App\SearchForBidder::where('bid_id', $request->bid_id)->orderBy('vendor_id', 'desc')->get();
        $bid_id = $request->bid_id;
        $controllerName = new BidController;

        return view('bids.load-bidders-table', compact('shortlist_vendors', 'bid_id', 'controllerName')); 
    }


    //All
    public function shortlist_all_vendors(Request $request)
    {   
        try
        {   //return $request->all();
            $vendor_number = $request->v_number;    $vendor_bids = [];
            foreach ($vendor_number as $key => $vendor_id) 
            {
                $search_vendor = \App\Vendor::where('id', $vendor_id)->orderBy('id', 'desc')->first();

                //TOTAL VENDOR BIDS
                $bid_invites = \App\SearchForBidder::where('vendor_id', $vendor_id)->count();
                $bid_submited = \App\BidSubmission::where('vendor_id', $vendor_id)->count();
                // if($vendor_bid){    $vendor_bids[$key] = $vendor_bid;   }
                $addBids = \App\SearchForBidder::updateOrCreate
                (['bid_id'=> $request->bid_id, 'vendor_id'=> $search_vendor->id],
                [              
                    'bid_id' => $request->bid_id,
                    'vendor_id' => $search_vendor->id,
                    'category' => $search_vendor->category,
                    'proximity' => $search_vendor->address,
                    'rating' => null,
                    'bid_invites' => $bid_invites,
                    'bid_submited' => $bid_submited,
                    'bid_awarded' => null,
                    'created_by' => \Auth::user()->id,
                ]);
            }  //dd($vendor_bids);

            return response()->json(['status'=>'ok', 'info'=>'Vendors has been shortlisted.']);           
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        }        
    }


    //ONE
    public function shortlist_one_vendor(Request $request)
    {
        try
        {   //return $request->all();
            $search_vendor = \App\Vendor::where('id', $request->vendor_id)->first();
            $addBids = \App\SearchForBidder::updateOrCreate
            (['bid_id'=> $request->bid_id, 'vendor_id'=> $request->vendor_id],
            [              
                'bid_id' => $request->bid_id,
                'vendor_id' => $request->vendor_id,
                'category' => $search_vendor->category,
                'proximity' => $search_vendor->address,
                'rating' => null,
                'bid_invites' => null,
                'bid_submited' => null,
                'bid_awarded' => null,
                'created_by' => \Auth::user()->id,
            ]);

            return response()->json(['status'=>'ok', 'info'=>'Vendor has been shortlisted.']);           
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'error' => 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        }        
    }



    public function remove_one_vendor(Request $request)
    {
        try
        {   //return $request->all();

            $removeBids = \App\SearchForBidder::where('bid_id', $request->bid_id)->where('vendor_id', $request->vendor_id)->delete();  

            return response()->json(['status'=>'ok', 'info'=>'The searched vendor was removed from list.']);           
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        }        
    }

    public function remove_all_vendors(Request $request)
    {
        try
        {   //return $request->all();
            $vendor_number = $request->v_number;
            foreach ($vendor_number as $key => $vendor_id) 
            {
                $search_vendor = \App\Vendor::where('id', $vendor_id)->first();

                $removeBids = \App\SearchForBidder::where('bid_id', $request->bid_id)->where('vendor_id', $search_vendor->id)->delete();
            }  

            return response()->json(['status'=>'ok', 'info'=>'All searched vendors where removed from list.']);           
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        }        
    }

    public function getShortlistedVendors(Request $request)
    {
        $shortlisted = \App\SearchForBidder::where('bid_id', $request->bid_id)->count();
        return response()->json($shortlisted); 
    }

    public function getVendorBidInvites($bid_id, $vendor_id)
    {
        $bid_invites = \App\SearchForBidder::where('bid_id', $bid_id)->where('vendor_id', $vendor_id)->get();
        return $bid_invites->count(); 
    }

    public function getVendorBidSubmits($bid_id, $vendor_id)
    {
        $bid_submits = \App\BidSubmission::where('bid_id', $bid_id)->where('vendor_id', $vendor_id)->get();
        return $bid_submits->count(); 
    }




    public function bid_message(Request $request)
    {
        try
        {   //return $request->all();
            $addMsg = \App\BidMessage::updateOrCreate
            (['id'=> $request->id],
            [              
                'bid_id' => $request->bid_id,
                'message' => $request->message,
                'created_by' => \Auth::user()->id,
            ]);

            return response()->json(['status'=>'ok', 'info'=>'Bid message setup was Successfully.']); 
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'info'=>'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        }
    }


    public function invite_vendors_to_bid(Request $request)
    {

        try
        {
            $bid_id = $request->bid_id;
            $bid_name = \App\Bid::where('id', $bid_id)->first(); 
            $email_message = \App\BidMessage::where('bid_id', $bid_id)->first(); 

            $bidders = \App\SearchForBidder::where('bid_id', $bid_id)->get(); 
            $email_list = \App\BidEmailList::where('bid_id', $bid_id)->get(); 
            // $document = \App\BidDocument::where('bid_id', $bid_id)->first();   $dname = $document->path.'\\'.$document->doc_name;
            // return response()->download(public_path($dname));

            //email notification
            $this->send_bid_invitation_mail($bidders, $email_list, $email_message, $bid_id, $bid_name);

            return response()->json(['status'=>'ok', 'info'=>'Bid invites has been sent to all vendors shortlisted.']); 
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'error'=>'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        }
    }



    public function bid_invitation(Request $request, $bid_id)
    {
        //return $request->all();
        $bid_id = $request->b_id;
        $invitation = \App\BidMessage::where('bid_id', 5)->first();

        return view('bids.bid-invitation', compact('invitation'));        
    }



    public function submitted_bids(Request $request)
    {
        //return $request->all();
        // $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        // if(!$column){ $column = 'id'; }    if(!$sort){ $sort = 'desc'; }
        // if ($search || $column || $sort)
        // {
        //     $bids = \App\BidSubmission::where('bid_code', 'like', "%{$search}%")->where('name', 'like', "%{$search}%")
        //         ->orwhere('description', 'like', "%{$search}%")->orwhere('start_date', 'like', "%{$search}%")
        //         ->orwhere('end_date', 'like', "%{$search}%")
        //         ->orwhereHas('industry', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
        //         ->orderBy($column, $sort)->paginate(10);
        // }
        // else
        // { 
        //     $bids = \App\BidSubmission::orderBy('id', 'desc')->paginate(15);
        // }

        $bids = \App\BidSubmission::orderBy('id', 'desc')->paginate(15);
        $controllerName = new BidController;

        return view('bids.submitted-bids', compact('bids', 'controllerName'));        
    }


    public function GetNumberOfBidResponse($bid_id)
    {
        $no_of_bid_response = \App\BidSubmission::where('bid_id', $bid_id)->count();
        return $no_of_bid_response; 
    }


    public function GetBidStartDate($bid_id)
    {
        $date = \App\Bid::where('id', $bid_id)->first();
        return $date->start_date; 
    }

    public function GetBidEndDate($bid_id)
    {
        $date = \App\Bid::where('id', $bid_id)->first();
        return $date->end_date; 
    }



}
