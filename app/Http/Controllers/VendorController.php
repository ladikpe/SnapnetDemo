<?php

namespace App\Http\Controllers;

//use App\Vendor;
use App\Vendor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Excel;
use DB;
use Illuminate\Support\Facades\Input;
use App\Notifications\RequisitionEmail;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['vendor_registration', 'store', 'getAllVendors', 'getAllVendorIdNames']);
    }

    public function vendor_registration_mail($vendor_name, $vendor_id) 
    {
        //Getting all Users to notify    
        $admin_id = \App\Role::where('id', 1)->pluck('id');
        $recipients = \App\User::where('role_id', $admin_id)->get();
        foreach ($recipients as $recipient) 
        {
            //sending email to User
            $sender = Auth::user()->email;  $name = $recipient->name;         $url = route('vendor-profile', [$vendor_id]);  
            $message = "A new Vendor ".$vendor_name."  has been created pending approval. Note that vendors that are yet to be approved can not be shortlisted for bidding or, view and respond to bids.  Click the link below to view the vendors profile and approve where necessary ";

            $recipient->notify(new RequisitionEmail($message, $sender, $name, $url));
        }


        $vendor = \App\Vendor::where('id', $vendor_id)->first();
        //sending email to User
        $sender = Auth::user()->email;  $name = $vendor->name;         $url = route('vendor-profile', [$vendor_id]);  
        $message = "Your registration was successful, please find your login details. Email : ".$vendor->email." Password : ".substr($vendor->name, 0, 3)."@1234 . Please note that your profile is pending approval before you could . Click the link below to view your profile. "; 

        $vendor->notify(new RequisitionEmail($message, $sender, $name, $url));


    }

    public function vendor_approval_mail($vendor_id) 
    {
        //Getting all Users to notify    
        $recipient = \App\Vendor::where('id', $vendor_id)->first();

        //sending email to User
        $sender = Auth::user()->email;  $name = $recipient->name;         $url = route('vendor-profile', [$vendor_id]);  
        $message = "Your registration is complete and  ".\Auth::user()->name." has approved your vendor status. Click the link below to view your profile and add other necessary details partaining to your profile";

        $recipient->notify(new RequisitionEmail($message, $sender, $name, $url));
    }

    public function order_number($count, $pre)
    {
        //$dated = getdate();
        $number = '';
        $number .= $pre;
        //$number .= $dated['year'];
        if($count < 10)	{			$number .= '-0000';	}
        else if($count >= 10){		$number .= '-000';	}
        else if($count >= 100){		$number .= '-00'; 	}
        else if($count >= 1000){	$number .= '-0';	}
        else if($count >= 10000){	$number .= '-';		}
        $number .= $count;
        return $number;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function index(Request $request)
    {
        //
        $states = \App\State::orderBy('state_name', 'asc')->get();
        $countries = \App\Country::orderBy('country_name', 'asc')->get();

        $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        if ($search || $column || $sort)
        {
            if(!$column){ $column = 'created_at'; }    if(!$sort){ $sort = 'asc'; }
                $vendors = \App\Vendor::where('name', 'like', "%{$search}%")->orwhere('email', 'like', "%{$search}%")->orwhere('phone', 'like', "%{$search}%")
                ->orwhere('category', 'like', "%{$search}%")->orwhere('contact_name', 'like', "%{$search}%")->orwhere('address', 'like', "%{$search}%")
                ->orwhere('website', 'like', "%{$search}%")->orwhere('vendor_code', 'like', "%{$search}%")
                ->orwhereHas('state', function($query) use ($request) { $query->where('state_name','like',"%{$request->search}%"); })
                ->orwhereHas('country', function($query) use ($request) { $query->where('country_name','like',"%{$request->search}%"); })
                ->orderBy($column, $sort)->paginate(15);
        }
        else
        {
            $vendors = \App\Vendor::orderBy('id', 'desc')->paginate(15);
        }

        return view('vendors.index', compact('states', 'countries', 'vendors'));
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
        //return $request->all();
        try
        {   
            $name = $request->name;   $id = $request->id;
            $add = \App\Vendor::updateOrCreate
            (['id'=> $id],
            [
                'name' => $name,
                'email' => $request->email,
                'password' => bcrypt(substr($request->name, 0, 3).'@1234'),
                'phone' => $request->phone,
                'category' => $request->category,
                'contact_name' => $request->contact_name,
                'address' => $request->address,
                'address_2' => $request->address_2,
                'state_id' => $request->state_id,
                'country_id' => $request->country_id,
                'website' => $request->website,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'vat_number' => $request->vat_number,
                'fax_number' => $request->fax_number,
                'created_by' => 0,
            ]);

            //return $add;

            //updating Vendor number
            $sub_name = substr($name, 0, 4);
            $sub_cate = substr($request->category, 0, 2);
            $pref = $sub_name.'-'.$sub_cate;
            $vendorCode = $this->order_number($add->id, $pref);
            $data = array( 'vendor_code'=> $vendorCode );
            $updated = \App\Vendor::where('id', $add->id)->update($data);

            //email notification
            $this->vendor_registration_mail($name, $add->id);


            return redirect()->route('show.login')->with(['info'=>'Vendor registered successfully pending approval']);
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }
    
    public function upload_document(Request $request)
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
                'vendor_id' => $request->vendor_id,
                'type_id' => $request->type_id,
                'name' => $request->name,
                'document_path' => $destinationPath,
                'file_name' => $file_name,
                'expiry_date' => $request->expiry_date,
                'created_by' => \Auth::user()->id,
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


    public function upload_vendor(Request $request)
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
                    //UPLOADING NEW
                    $upload = \App\Vendor::updateOrCreate
                    (['id'=> $request->id],
                    [
                        'name' => $row['A'],
                        'email' => $row['B'],
                        'password' => bcrypt(substr($row['A'], 0, 5).'@1234'),
                        'phone' => $row['C'],
                        'category' => $row['D'],
                        'contact_name' => $row['E'],
                        'address' => $row['F'],
                        'address_2' => $row['G'],
                        'state_id' => $row['H'],
                        'country_id' => $row['I'],
                        'website' => $row['J'],
                        'vat_number' => $row['K'],
                        'fax_number' => $row['L'],
                        'bank_name' => $row['M'],
                        'account_number' => $row['N'],
                        'company_info' => $row['O'],
                        'created_by' => 0,
                    ]);

                    //updating Vendor number
                    $sub_name = substr($row['A'], 0, 4);
                    $sub_cate = substr($row['D'], 0, 2);
                    $pref = $sub_name.'-'.$sub_cate;
                    $vendorCode = $this->order_number($upload->id, $pref);
                    $data = array( 'vendor_code'=> $vendorCode );
                    $updated = \App\Vendor::where('id', $upload->id)->update($data);
                }
            }

            return redirect()->back()->with(['success'=>'New Vendor Created successfully']);
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }





    public function download_template(Request $request)
    {
        $vendors = collect($this->getTableColumns('vendors'))->filter(function($value)
        {
            if(in_array($value, ['vendor_code', 'id', 'password', 'remenber_token', 'created_by', 'created_at', 'updated_at']))
            {
                return false;
            }
            return $value;
        });

        $state = \App\State::select('id', 'state_name')->get();
        $country = \App\Country::select('id', 'country_name')->get();

        return   $this->exportexcel('Vendor Excel', ['Vendor Excel'=>$vendors, 'States'=>$state, 'Countries'=>$country]);
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

    public  function getVendorDetails(Request $request)
    {
        $vendor = \App\Vendor::where('id', $request->id)->first();

        return response()->json($vendor);
    }


    public function vendor_shortlist(Request $request)
    {
        $document_id = $request->id;
        $states = \App\State::orderBy('state_name', 'asc')->get();
        $countries = \App\Country::orderBy('country_name', 'asc')->get();

        $search = $request->search;      $column = $request->column;     $sort = $request->sort;   $category= $request->category;   $state = $request->state_id;
        if ($search != '' || $column || $sort)
        {
            if(!$column){ $column = 'created_at'; }    if(!$sort){ $sort = 'asc'; }
            $vendors = \App\Vendor::where('name', 'like', "%{$search}%")->orwhere('email', 'like', "%{$search}%")->orwhere('phone', 'like', "%{$search}%")
                ->orwhere('category', 'like', "%{$search}%")->orwhere('contact_name', 'like', "%{$search}%")->orwhere('address', 'like', "%{$search}%")
                ->orwhere('website', 'like', "%{$search}%")->orwhere('vendor_code', 'like', "%{$search}%")
                ->orwhereHas('state', function($query) use ($request) { $query->where('state_name','like',"%{$request->search}%"); })
                ->orwhereHas('country', function($query) use ($request) { $query->where('country_name','like',"%{$request->search}%"); })
                ->orderBy($column, $sort)->paginate(15);
        }
        else if ($category != null && $state != null || $column || $sort)
        {
            if(!$column){ $column = 'created_at'; }    if(!$sort){ $sort = 'asc'; }
            $vendors = \App\Vendor::where('category', 'like', "%{$category}%")
                ->whereHas('state', function($query) use ($request) { $query->where('state_name','like',"%{$request->state_id}%"); })->orderBy($column, $sort)->paginate(15);
        }
        else if ($category != null || $column || $sort)
        {
            if(!$column){ $column = 'created_at'; }    if(!$sort){ $sort = 'asc'; }
            $vendors = \App\Vendor::where('category', 'like', "%{$category}%")->orderBy($column, $sort)->paginate(15);
        }
        else if ($state != null || $column || $sort)
        {
            if(!$column){ $column = 'created_at'; }    if(!$sort){ $sort = 'asc'; }
            $vendors = \App\Vendor::whereHas('state', function($query) use ($request) { $query->where('state_name','like',"%{$request->state_id}%"); })
                ->orderBy($column, $sort)->paginate(15);
        }
        else
        {
            $vendors = \App\Vendor::orderBy('id', 'desc')->paginate(15);
        }

        return view('vendors.shortlist', compact('states', 'countries', 'vendors', 'document_id'));

    }


    public function shortlist_vendor(Request $request)
    {
        //return $request->all();
        try
        {
            $vendor_id = $request->vendor_id;     $document_id = $request->document_id;     $action_type = $request->action_type;
            if($action_type == 1)
            {
                $add = \App\VendorShortlist::updateOrCreate
                (['vendor_id'=> $request->vendor_id, 'document_id'=> $request->document_id],
                    [
                        'vendor_id' => $vendor_id,
                        'document_id' => $document_id,
                        'status_id' => $request->status_id,
                        'created_by' => \Auth::user()->id,
                    ]);
            }
            elseif($action_type == 0)
            {
                $delete_record = \App\VendorShortlist::where('vendor_id', $request->vendor_id)->where('document_id', $request->document_id)->delete();
            }

            return response()->json(['status'=>'ok', 'info'=>'Vendor shortlisted successfully.']);
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }

    public  function getVendorShortlists($vendor_id, $document_id)
    {
        $vendor_shortlist = \App\VendorShortlist::where('vendor_id', $vendor_id)->where('document_id', $document_id)->count();
        if($vendor_shortlist> 0) return true;
    }


    public function shortlisted_vendor(Request $request, $id)
    {
        $states = \App\State::orderBy('state_name', 'asc')->get();
        $countries = \App\Country::orderBy('country_name', 'asc')->get();

        $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        if ($search || $column || $sort)
        {
            if(!$column){ $column = 'created_at'; }    if(!$sort){ $sort = 'asc'; }

            $query = (new Vendor)->newQuery();
            $query = $query->whereHas('VendorShortlist', function(Builder $builder){ return $builder; });

            $vendors = $query->where('name', 'like', "%{$search}%")->orwhere('email', 'like', "%{$search}%")->orwhere('phone', 'like', "%{$search}%")
                ->orwhere('category', 'like', "%{$search}%")->orwhere('contact_name', 'like', "%{$search}%")->orwhere('address', 'like', "%{$search}%")
                ->orwhere('website', 'like', "%{$search}%")->orwhere('vendor_code', 'like', "%{$search}%")
                ->orwhereHas('state', function($query) use ($request) { $query->where('state_name','like',"%{$request->search}%"); })
                ->orwhereHas('country', function($query) use ($request) { $query->where('country_name','like',"%{$request->search}%"); })->paginate(15);
        }
        else
        {
            $query = (new Vendor)->newQuery();
            $query = $query->whereHas('VendorShortlist',function(Builder $builder){ return $builder;});
        }



        $shortlisted_vendors = $query->paginate(15);

        return view('vendors.shortlisted-vendors', compact('states', 'countries', 'shortlisted_vendors', 'id'));
    }






    public function getTableColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }


    private function exportexcel($worksheetname, $data)
    {
        return \Excel::create($worksheetname, function($excel) use ($data)
        {
            foreach($data as $sheetname=>$realdata)
            {
                $excel->sheet($sheetname, function($sheet) use ($realdata)
                {
                    $sheet->fromArray($realdata);
                });
            }


        })->download('xlsx');
    }





    public function vendor_registration(Request $request)
    {
        //
        $states = \App\State::orderBy('state_name', 'asc')->get();
        $countries = \App\Country::orderBy('country_name', 'asc')->get();
        $vendor_documents = \App\VendorDocument::orderBy('name', 'asc')->get();
        $document_types = \App\VendorDocumentType::orderBy('name', 'asc')->get();

        return view('vendors.registration', compact('states', 'countries', 'vendor_documents', 'document_types'));
    }





    public function vendor_profile(Request $request)
    {
        $vendor_id = $request->id;
        $vendor = \App\Vendor::where('id', $vendor_id)->orderBy('id', 'desc')->first();
        $users = \App\User::orderBy('id', 'asc')->get();

        $states = \App\State::orderBy('state_name', 'asc')->get();
        $countries = \App\Country::orderBy('country_name', 'asc')->get();

        $vendor_documents = \App\VendorDocument::where('vendor_id', $vendor_id)->orderBy('id', 'desc')->get();
        $document_types = \App\VendorDocumentType::orderBy('name', 'asc')->get();
        $submitted_bids = \App\BidSubmission::where('vendor_id', $vendor_id)->orderBy('id', 'desc')->get();
        $bid_files = \App\BidSubmissionFile::where('vendor_id', $vendor_id)->orderBy('id', 'desc')->get();

        return view('vendors.profile', compact('vendor_id', 'vendor', 'users', 'states', 'countries', 'vendor_documents', 'document_types', 'submitted_bids', 'bid_files'));

    }




    public function get_doc_type_by_id(Request $request)
    {
        $documentType = \App\VendorDocumentType::where('id', $request->id)->first();
        return response()->json($documentType); 
    }
    
    public function approve_vendor(Request $request)
    {
        // return $request->all();
        try
        {  
            $data = (['status' => 1, 'approved_by' => \Auth::user()->id, 'approved_at' => date('Y-m-d h:i:s'),]);
            $update = \App\Vendor::where('id', $request->vendor_id)->update($data);

            //email notification
            $this->vendor_approval_mail($request->vendor_id);

            if($request->ajax())
            {
                return response()->json(['status'=>'ok', 'info'=>'Vendor was approved successfully']);
            }
            else
            {
                return redirect()->back()->with(['status'=>'ok', 'info', 'Vendor was approved successfully']);
            }
        }
        catch (\Exception $e)
        {
            return  redirect()->route('vendor.index')->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
            //return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }

    public function load_document_table(Request $request)
    {
        $vendor_documents = \App\VendorDocument::where('vendor_id', $request->vendor_id)->get();
        return view('vendors.document-table', compact('vendor_documents')); 
    }



    public function delete_document(Request $request)
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
    
    public function update_company_info(Request $request)
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
            return  redirect()->route('vendor.index')->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
            //return redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage());
        }
    }





    public function get_submitted_bid_documents(Request $request)
    {
        $attachments = \App\BidSubmissionFile::where('bid_submission_id', $request->bid_submission_id)->with(['bid'])->get();
        return response()->json($attachments); 
    }


    public function get_submitted_bid_docs(Request $request)
    {
        $bid_docs = \App\BidSubmissionFile::where('bid_submission_id', $request->bid_submission_id)->with(['bid'])->get();
        return view('vendors.load-bid-documents', compact('bid_docs'));
    }


    public function load_bid_documents(Request $request)
    {
        $bid_docs = \App\BidSubmissionFile::where('bid_submission_id', $request->bid_submission_id)->with(['bid'])->get();
        return view('vendors.load-bid-documents', compact('bid_docs'));
    }


    //SYN
    public function getAllVendors(Request $request)
    {
        // $key = $request->key;
        // if($key != '2gfgyjdry' && ){
        //     return 'unauthrized';
        // }

        $vendors = DB::table('vendors')->select('id', 'vendor_code', 'name', 'email', 'phone', 'category', 'contact_name', 'address', 'address_2', 'state_id', 'country_id', 'website', 'vat_number', 'fax_number', 'bank_name', 'account_number', 'status')->get();
      
        return response()->json($vendors); 
    }
    public function getAllVendorIdNames(Request $request)
    {
        $vendors = \App\Vendor::get();     $vendor_ids = [];
        foreach ($vendors as $k => $vendor_id) 
        {
            $vendor_ids[$k] = $vendor_id->id;
        }
        return response()->json($vendor_ids); 
    }


}
