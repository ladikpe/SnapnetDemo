<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use App\Notifications\RequisitionEmail;

class VendorBidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth:vendor');
    }



    public function send_submission_mail($email_list, $bid_id, $bid, $documents, $vendor)
    {
        //Getting all User in distribution list to notify    
        foreach ($email_list as $list) 
        {
            $user = \App\User::where('id', $list->user_id)->first();
            //sending email to User
            $sender = Auth::user()->email;  $name = $user->name;         $url = route('vendor-profile', [$vendor->id]);  $vendor_name = $vendor->name; 
            $message = $vendor_name .", has responded to ".$bid->name.". Please click the link below to view and download the bid document sent. ";

          $user->notify(new RequisitionEmail($message, $sender, $name, $url));
        }
    }





    public function index(Request $request)
    {
        //     
        $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        if(!$column){ $column = 'id'; }    if(!$sort){ $sort = 'desc'; }    $bids = \App\Bid::where('id', 0)->orderBy('id', 'desc')->paginate(10);
        if ($search || $column || $sort)
        {
            $bid_invites = \App\SearchForBidder::where('vendor_id', \Auth::guard('vendor')->user()->id)->orderBy('id', 'desc')->get();
            if($bid_invites != "")
            {  
                foreach ($bid_invites as $key => $bid) 
                {
                    $bids = \App\Bid::where('bid_code', 'like', "%{$search}%")
                    ->orwhere('name', 'like', "%{$search}%")->orwhere('description', 'like', "%{$search}%")
                    ->orwhere('start_date', 'like', "%{$search}%")->orwhere('end_date', 'like', "%{$search}%")
                    ->orwhereHas('industry', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
                    ->where('id', $bid->bid_id)
                    ->orderBy($column, $sort)->paginate(10);
                }
            }else{ }
            
        }
        else
        { 
            $bid_invites = \App\SearchForBidder::where('vendor_id', \Auth::guard('vendor')->user()->id)->orderBy('id', 'desc')->get();
            if($bid_invites != "")
            {  
                foreach ($bid_invites as $key => $bid) 
                {
                    $bids = \App\Bid::where('id', $bid->bid_id)->orderBy('id', 'desc')->paginate(10);
                }
            }else{   }
        }   //return $bids;

        $industries = \App\BidIndustry::orderBy('name', 'asc')->get();
        $v_id = \Auth::guard('vendor')->user()->id;
        $vendor = \App\Vendor::where('id', \Auth::guard('vendor')->user()->id)->first();
        $controllerName = new VendorBidController;

        return view('bids.vendors.vendor-bids', compact('bids', 'industries', 'controllerName', 'v_id', 'vendor'));
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
        $bid = \App\Bid::where('id', $id)->first();
        $documents = \App\BidDocument::where('bid_id', $id)->orderBy('id', 'desc')->get();
        $submitted = \App\BidSubmissionFile::where('bid_id', $id)->where('vendor_id', \Auth::guard('vendor')->user()->id)->first();
        $controllerName = new VendorBidController;

        return view('bids.vendors.bid-view', compact('bid', 'controllerName', 'documents', 'submitted'));
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


    public function submit_bids(Request $request)
    {
        //
        // $arr = $request->path(); $exp_arr = explode('/', $arr); $param = $exp_arr[1];

        $submitted_bids = \App\BidSubmission::where('vendor_id', \Auth::guard('vendor')->user()->id)->orderBy('id', 'desc')->get();
        $documents = \App\BidDocument::orderBy('id', 'desc')->get();
        $controllerName = new VendorBidController;

        return view('bids.vendors.submit-bid', compact('submitted_bids', 'controllerName', 'documents'));
    }





    public function respond_to_bid(Request $request)
    {
        // return $request->all();
        try
        {
            $public_path = public_path();
            $id = $request->id;   $bid_id = $request->bid_id;
            $file = $request->file;

            $submitted = \App\BidSubmission::updateOrCreate
            (['id'=> $id],
            [
                'bid_id' => $bid_id,
                'vendor_id' => \Auth::guard('vendor')->user()->id,
                'note' => $request->note,
            ]); 


            if($request->hasFile('file'))
            {
                foreach ($request->file as $k => $file) 
                {
                    $file_name = $file->getClientOriginalName();
                    
                    $destinationPath = 'assets\\images\\bid_submission\\' . $file->getClientOriginalName();
                    $file->move($destinationPath, $file->getClientOriginalName());  
                    $full_path = $public_path.'\\'.$destinationPath;

                    $upload = \App\BidSubmissionFile::create
                    ([
                        'bid_submission_id' => $submitted->id,
                        'bid_id' => $bid_id,
                        'vendor_id' => \Auth::guard('vendor')->user()->id,
                        'file_path' => $destinationPath,
                        'file_name' => $file_name,
                    ]);              
                }
            } 
            $bid = \App\Bid::where('id', $bid_id)->first();
            $documents = \App\BidSubmissionFile::where('bid_id', $bid_id)->where('vendor_id', \Auth::guard('vendor')->user()->id)->get();
            $email_list = \App\BidEmailList::where('bid_id', $bid_id)->get();
            $vendor = \App\Vendor::where('id', \Auth::guard('vendor')->user()->id)->first();

            //email notification
            $this->send_submission_mail($email_list, $bid_id, $bid, $documents, $vendor);

            $bids = \App\Bid::orderBy('id', 'desc')->paginate(10);
            $industries = \App\BidIndustry::orderBy('name', 'asc')->get();
            $v_id = \Auth::guard('vendor')->user()->id;
            $vendor = \App\Vendor::where('id', \Auth::guard('vendor')->user()->id)->first();
            $controllerName = new VendorBidController;

            return redirect()->route('vendor-bids.index')->with(['bids'=>$bids, 'industries'=>$industries, 'v_id'=>$v_id, 'vendor'=>$vendor, 'controllerName'=>$controllerName, 'status'=>'ok', 'info'=>'Bid sent successfully']);
        }
        catch (\Exception $e)
        {
            return  redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
        }
    }


    public function removeBidAttachment($id)
    {
        try
        {   //return $request->all();
            $upload = \App\BidSubmissionFile::where('id', $request->id)->delete();
            return  redirect()->back()->with(['status', 'ok', 'info', 'Attachment Removed.']);
        }
        catch (\Exception $e)
        {
            return  redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
            //return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
        
    }

    public function checkSubmittedBid($bid_id, $vendor_id)
    {
        $submitted = \App\BidSubmission::where('bid_id', $bid_id)->where('vendor_id', $vendor_id)->first();
        if($submitted != null){ return true; }else{ return false; }
    }

    public function getSubmittedBidDetail(Request $request)
    {
        $submitted = \App\BidSubmission::where('bid_id', $request->bid_id)->where('vendor_id', \Auth::guard('vendor')->user()->id)->first();
        $attachments = \App\BidSubmissionFile::where('bid_id', $request->bid_id)->where('vendor_id', \Auth::guard('vendor')->user()->id)->with('bid')->get();
        return response()->json(['submitted'=>$submitted, 'attachments'=>$attachments]);
    }

    public function getSubmittedBidAttachments(Request $request)
    {
        $attachments = \App\BidSubmissionFile::where('bid_id', $request->bid_id)->where('vendor_id', \Auth::guard('vendor')->user()->id)->with('bid')->get();
        return response()->json($attachments);
    }


    public function profile(Request $request)
    {
        $vendor_id = \Auth::guard('vendor')->user()->id;
        $vendor = \App\Vendor::where('id', $vendor_id)->orderBy('id', 'desc')->first();
        $users = \App\User::orderBy('id', 'asc')->get();

        $states = \App\State::orderBy('state_name', 'asc')->get();
        $countries = \App\Country::orderBy('country_name', 'asc')->get();

        $vendor_documents = \App\VendorDocument::where('vendor_id', $vendor_id)->orderBy('id', 'desc')->get();
        $document_types = \App\VendorDocumentType::orderBy('name', 'asc')->get();
        $submitted_bids = \App\BidSubmission::where('vendor_id', $vendor_id)->orderBy('id', 'desc')->get();
        $bid_files = \App\BidSubmissionFile::where('vendor_id', $vendor_id)->orderBy('id', 'desc')->get();

        $industries = \App\BidIndustry::orderBy('name', 'asc')->get();

        return view('bids.vendors.profile', compact('vendor_id', 'vendor', 'users', 'states', 'countries', 'vendor_documents', 'document_types', 'submitted_bids', 'bid_files', 'industries'));
    }


    public function reset_password_view(Request $request)
    {
        $vendor = \App\Vendor::where('id', \Auth::guard('vendor')->user()->id)->first();
        return view('bids.vendors.reset-password', compact('vendor'));
    }

    public function reset_vendor_password(Request $request)
    {
        try
        {    
            $data = array('email' => $request->email,   'password' => bcrypt($request->password),);
            $updated = \App\Vendor::where('id', $request->id)->update($data);

            return response()->json(['status'=>'ok', 'info'=>'Password reset was successfully']);
            // return redirect()->route('vendor.login')->with(['status'=>'ok', 'info'=>'Password reset was successfully']);
        }
        catch (\Exception $e)
        {
            return  redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
        }
    }


    public function get_document_by_id(Request $request)
    {
        $document = \App\VendorDocument::where('id', $request->id)->first();
        return response()->json($document); 
    }


    
    public function upload_document_vendor(Request $request)
    {
        //return $request->all();
        try
        {
            $id = $request->id;
            $file = $request->file;
            $file_name = $request->file->getClientOriginalName();
            $destinationPath = 'assets/images/documents/' . Input::file('file')->getClientOriginalName();
            $file->move($destinationPath, Input::file('file')->getClientOriginalName()); 

            $upload = \App\VendorDocument::updateOrCreate
            (['id'=> $id],
            [
                'vendor_id' => \Auth::guard('vendor')->user()->id,
                'type_id' => $request->type_id,
                'name' => $request->name,
                'document_path' => $destinationPath,
                'file_name' => $file_name,
                'expiry_date' => $request->expiry_date,
                'created_by' => \Auth::guard('vendor')->user()->id,
            ]);  

            if($request->ajax())
            {
                return response()->json(['status'=>'ok', 'details'=>$upload, 'info'=>'Vendor document uploaded successfully']);
            }
            else
            {
                return redirect()->back()->with('info', 'Vendor document uploaded successfully');
            }
        }
        catch (\Exception $e)
        {
            return  redirect()->route('vendors.index')->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
            //return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }



    public function load_vendor_doc_table(Request $request)
    {
        $vendor_documents = \App\VendorDocument::where('vendor_id', $request->vendor_id)->get();
        return view('bids.vendors.document-table', compact('vendor_documents')); 
    }

    public function delete_vendor_doc(Request $request)
    {
        try
        {
            //return $request->all();
            $vendor_documents = \App\VendorDocument::where('vendor_id', $request->vendor_id)->get();
            $deleted_doc = \App\VendorDocument::where('id', $request->document_id)->delete();

            if($request->ajax())
            {   
                return response()->json(['status'=>'ok', 'details'=>$deleted_doc, 'info'=>'Vendor document deleted successfully']);
            }
            else
            {   
                //return redirect()->back()->with(['status'=>'ok', 'details'=>$deleted_doc, 'info', 'Vendor document deleted successfully']);
            }
        }
        catch (\Exception $e)
        { 
            return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
        
        // return view('vendors.document-table', compact('vendor_documents')); 
    }
    
    public function update_about_company(Request $request)
    {
        // return $request->all();
        try
        {  
            $data = (['company_info' => $request->company_info, 'updated_at' => date('Y-m-d h:i:s'),]);
            $update = \App\Vendor::where('id', $request->id)->update($data);

            if($request->ajax())
            {
                return response()->json(['status'=>'ok', 'info'=>'Vendor company info updated successfully']);
            }
            else
            {
                return redirect()->back()->with(['status'=>'ok', 'info', 'Vendor company info updated successfully']);
            }
        }
        catch (\Exception $e)
        {
            return  redirect()->route('profile')->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
            //return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }


    public function uploadVendors(Request $request)
    {
        $vendors = \App\TravelVendor::orderBy('id', 'desc')->paginate(10);
        $controllerName = new VendorBidController;

        return view('bids.vendors..view-vendors', compact('vendors', 'controllerName'));
    }


    public function uploadVendorStore(Request $request)
    {
        // return $request->all();
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
                    //UPLOADING NEW
                    $upload = \App\TravelVendor::updateOrCreate
                    (['id'=> $request->id],
                    [
                        'region' => $row['A'],
                        'name' => $row['B'],
                        'service' => $row['C'],
                        'email' => $row['D'],
                        'phone' => $row['E'],
                        'address' => $row['F'],
                    ]);
                }
            }

            return redirect()->back()->with(['success'=>'Vendor(s) Uploaded successfully']);
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }


}
