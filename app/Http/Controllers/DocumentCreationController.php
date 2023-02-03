<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Notifications\RequisitionEmail;
use App\Notifications\DocumentCreationEmail;
use App\Notifications\DocumentCommentEmail;
use App\Notifications\DocumentReviewEmail;
use App\Notifications\DocumentApprovedEmail;
use App\Notifications\DocumentDeclinedEmail;
use App\Notifications\PreferedTemplateEmail;
use App\Notifications\SharedLinkEmail;
use App\Notifications\DocumentPushForApprovalEmail;
use App\Notifications\DocumentModificationEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SharedLinkURLNotification;

class DocumentCreationController extends Controller
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


    //function for sending email
    public function send_creation_mail($document_name, $type, $requisition, $document)
    {
        //Getting all Users in Legal Department
        $receiver = \App\User::where('id', $requisition->user_id)->first();
        //sending email to User
        $sender = Auth::user()->email;
        $name = $receiver->name;
        $url = route('document-details', [$document->id]);
        $message = $type . " for " . $document_name . " has been created by " . \Auth::user()->name . ". You can view the document by clicking the link below ";

        $receiver->notify(new DocumentCreationEmail($message, $sender, $name, $url));
    }

    public function send_modified_mail($document_name, $type, $requisition, $document)
    {
        //Getting all Users in Legal Department
        $recipients = \App\NewDocumentVersion::where('document_id', $document->id)->distinct()->get(['created_by']);
        foreach ($recipients as $key => $recipient) {
            $receiver = \App\User::where('id', $recipient->created_by)->first();
            //sending email to User
            $sender = Auth::user()->email;
            $name = $receiver->name;
            $url = route('document-details', [$document->id]);
            $message = $type . " for " . $document_name . " was modified by " . \Auth::user()->name . ". You can view the document by clicking the link below to see the updated version ";

            $receiver->notify(new DocumentModificationEmail($message, $sender, $name, $url));
        }


        // Notify Assinor
        $assignor = \App\User::where('id', $requisition->user_id)->first();
        //sending email to User
        $sender = Auth::user()->email;
        $name = $assignor->name;
        $url = route('document-details', [$document->id]);
        $message = $type . " for " . $document_name . " has been created by " . \Auth::user()->name . ". You can view the document by clicking the link below ";

        $assignor->notify(new DocumentModificationEmail($message, $sender, $name, $url));
    }

    public function send_comment_mail($document_name, $recipient_id, $comment, $requisition_id)
    {        //Getting all Users to notify    
        foreach ($recipient_id as $recipient) {
            if ($recipient != null) {
                $receiver = \App\User::where('id', $recipient)->first();
                //sending email to User
                $sender = Auth::user()->email;
                $name = $receiver->name;
                $url = route('create-document', [$requisition_id, $requisition_id]);
                $message = "The Document, " . $document_name . " was reviewed by " . \Auth::user()->name . ". with the following comments " . $comment . ". Click the link below to effect the necessary changes ";

                $receiver->notify(new DocumentCommentEmail($message, $sender, $name, $url));
            }
        }
    }

    public function send_comment_mail_user($document_name, $recipient_id, $comment, $requisition_id)
    {
        $receiver = \App\User::where('id', $recipient_id)->first();
        //sending email to User
        $sender = Auth::user()->email;
        $name = $receiver->name;
        $url = route('create-document', [$requisition_id, $requisition_id]);
        $message = "The Document, " . $document_name . " was reviewed by " . \Auth::user()->name . ". with the following comments " . $comment . ". Click the link below to effect the necessary changes ";

        $receiver->notify(new DocumentCommentEmail($message, $sender, $name, $url));
    }

    public function send_reviewed_mail($document_name, $recipient_id, $document_id, $position)
    {
        //Getting all Users to notify 
        $stage_name = \App\Stage::where('position', $position)->first();
        foreach ($recipient_id as $recipient) {
            $receiver = \App\User::where('id', $recipient)->first();
            //sending email to User
            $sender = Auth::user()->email;
            $name = $receiver->name;
            $url = route('create-document', [$document_id, $document_id]);
            $message = "The Document, " . $document_name . " has been reviewed by " . \Auth::user()->name . ". The document is now in " . $stage_name->name . " click the link below to view the reviewed document ";

            $receiver->notify(new DocumentReviewEmail($message, $sender, $name, $url));
        }
    }

    public function send_push_for_approval_mail($document_name, $recipient_id, $document_id)
    {
        //Getting all Users to notify    
        foreach ($recipient_id as $recipient) {
            $receiver = \App\User::where('id', $recipient)->first();
            //sending email to User
            $sender = Auth::user()->email;
            $name = $receiver->name;
            $url = route('create-document', [$document_id, $document_id]);
            $message = "A request to approve " . $document_name . " has been sent by " . \Auth::user()->name . ". Click the link below to view the document ";

            $receiver->notify(new DocumentPushForApprovalEmail($message, $sender, $name, $url));
        }
    }

    public function send_approve_document_mail($document_name, $recipient_id, $document_id, $requisition_id)
    {
        //Getting all Users to notify    
        $document_detail = \App\NewDocument::where('id', $document_id)->first();
        $requisition = \App\Requisition::where('id', $requisition_id)->first();
        $requestor = \App\User::where('id', $requisition->user_id)->first();

        //sending email to User
        $requestor_sender = Auth::user()->email;
        $requestor_name = $requestor->name;
        $url = route('view-document', [$document_id]);
        $requestor_message = "The document " . $document_name . " was approved successfully by " . \Auth::user()->name . ". Click the link below to view the approved document and download/print";

        $requestor->notify(new DocumentApprovedEmail($requestor_message, $requestor_sender, $requestor_name, $url));

        foreach ($recipient_id as $recipient) {
            $receiver = \App\User::where('id', $recipient)->first();
            //sending email to User
            $sender = Auth::user()->email;
            $name = $receiver->name;
            $message = "The document " . $document_name . " was approved successfully by " . \Auth::user()->name . ". Click the link below to view the approved document and download/print";

            $receiver->notify(new DocumentApprovedEmail($message, $sender, $name, $url));
        }
    }

    public function send_decline_document_mail($document_name, $recipient_id, $document_id, $comment)
    {
        //Getting all Users to notify    
        foreach ($recipient_id as $recipient) {
            $receiver = \App\User::where('id', $recipient)->first();
            //sending email to User
            $sender = Auth::user()->email;
            $name = $receiver->name;
            $url = route('create-document', [$document_id, $document_id]);
            $message = "The document " . $document_name . " approval was declined by " . \Auth::user()->name . " with the following reasons : " . $comment . ". Click the link below to see document";

            $receiver->notify(new DocumentDeclinedEmail($message, $sender, $name, $url));
        }

        //
        $dept = \App\Department::where('id', 1)->first();
        $receiver_dept_head = \App\User::where('id', $dept->department_head_id)->first();
        //sending email to User
        $sender = Auth::user()->email;
        $name = $receiver_dept_head->name;
        $url = route('create-document', [$document_id, $document_id]);
        $message = "The document " . $document_name . " approval was declined by " . \Auth::user()->name . " with the following reasons : " . $comment . ". Click the link below to see document";

        $receiver_dept_head->notify(new DocumentDeclinedEmail($message, $sender, $name, $url));
    }

    public function send_prefered_template_mail($user_id, $requisition, $id)
    {
        //Getting all Users to notify    
        $receiver = \App\User::where('id', $user_id)->first();
        //sending email to User
        $sender = Auth::user()->email;
        $name = $receiver->name;
        $url = route('prefered-tamplate-view', [$id]);
        $message = "A template has been sent to you for use in creating " . $requisition . " document creation by " . \Auth::user()->name . ". Click the link below to view and download the template";

        $receiver->notify(new PreferedTemplateEmail($message, $sender, $name, $url));
    }


    public function send_share_link_mail($user_id, $vendor_email, $comment, $link_url)
    {
        //GETTING EMAIL MESSAGE
        $message = \App\EmailMessage::where('header', "Send Share Link Email")->first();

        // for user
        if ($user_id != null) {
            $receiver = \App\User::where('id', $user_id)->first();
            //sending email to User
            $sender = Auth::user()->email;
            $name = $receiver->name;
            $url = route('document-link-url');
            // $message = "Please find attached url of the shared document link below " . $link_url . " with comment : " . $comment . ". Click the link below to view more";

            Mail::to($receiver)->send(new SharedLinkURLNotification($message->message, $sender, $name, $url, 'Shared URL/Link Notification', $comment, $link_url));
        }
        // for vendor
        if ($vendor_email != null) {
            $vendor = \App\VendorEmail::where('id', $vendor_email)->first();
            //sending email to User
            $sender = $vendor->email;
            $name = $vendor->email;
            $url = route('document-link-url');
            // $message = "Please find attached url of the shared document link below " . $link_url . " with comment : " . $comment . ". Click the link below to view more";

            $vendor->notify(new SharedLinkEmail($message, $sender, $name, $link_url));
            Mail::to($receiver)->send(new SharedLinkURLNotification($message->message, $sender, $name, $url, 'Shared URL/Link Notification', $comment, $link_url));
        }
    }



    public function version_number($count, $pre)
    {
        $count += 1;
        $date = '';
        $number = '';
        $number .= $pre;
        $date .= date("d-M-y");
        if ($count < 10) {
            $number .= '-0';
        } else if ($count >= 10) {
            $number .= '-';
        }
        $number .= $count;
        $number .= ' / ' . $date;
        return $number;
    }

    public function document_number($count, $pre)
    {
        //$dated = getdate();
        $number = '';
        $number .= $pre;
        //$number .= $dated['year'];
        if ($count < 10) {
            $number .= '-00000';
        } else if ($count >= 10) {
            $number .= '-0000';
        } else if ($count >= 100) {
            $number .= '-000';
        } else if ($count >= 1000) {
            $number .= '-00';
        } else if ($count >= 10000) {
            $number .= '-0';
        } else if ($count >= 100000) {
            $number .= '-';
        }
        $number .= $count;
        return $number;
    }




    public function index(Request $request)
    {  //return $request->all();      
        // $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        // if(!$column){ $column = 'id'; }    if(!$sort){ $sort = 'desc'; }
        // if ($search || $column || $sort)
        // {
        //     $document_creations = \App\Requisition::where('id', 'like', "%{$search}%")->where('name', 'like', "%{$search}%")
        //         ->orwhere('description', 'like', "%{$search}%")->orwhere('deadline', 'like', "%{$search}%")
        //         ->orwhereHas('type', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
        //         ->orwhereHas('department', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
        //         ->orwhereHas('author', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
        //         ->orwhereHas('assign', function($query) us e($request) { $query->where('name','like',"%{$request->search}%"); })
        //         ->orwhereHas('status', function($query) use ($request) { $query->where('name','like',"%{$request->search}%"); })
        //         ->orderBy($column, $sort)->paginate(10);
        // }
        // else
        // { 
        //     $document_creations = \App\Requisition::where('user_id',\Auth::user()->id)->orderBy('id', 'desc')->get();
        // }


        $today = date('Y-m-d');
        $document_creations = \App\Requisition::orderBy('id', 'desc')->get();

        $users = \App\User::orderBy('name', 'asc')->get();
        $requisition_types = \App\RequisitionType::orderBy('name', 'asc')->get();
        $departments = \App\Department::orderBy('name', 'asc')->get();
        $workflows = \App\Workflow::orderBy('name', 'asc')->get();

        $pend_assignments = \App\Requisition::where('contract_created', 0)->get();
        $reviewed = \App\NewDocument::where('reviewed_approved', 1)->get();
        $appr_assignments = \App\NewDocument::where('reviewed_approved', 3)->get();

        $controllerName = new DocumentCreationController;

        if (\Auth::user()->department_id == 1 || \Auth::user()->department_id == 4) 
        {
            $document_creations = \App\Requisition::orderBy('id', 'desc')->get();

            return view('document-creation.index', compact('document_creations', 'users', 'controllerName', 'requisition_types', 'departments', 'workflows', 'pend_assignments', 'reviewed', 'appr_assignments', 'today'));
        } 
        else 
        {
            $document_creations = \App\Requisition::where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->get();

            return view('document-creation.index', compact('document_creations', 'users', 'controllerName', 'requisition_types', 'departments', 'workflows', 'pend_assignments', 'reviewed', 'appr_assignments', 'today'));
        }
    }


    public function getExpirationDate($id)
    {
        $detail = \App\NewDocument::where('requisition_id', $id)->first();
        if ($detail) 
        {
            $today = date('Y-m-d'); 
            $expire_on = date('Y-m-d', strtotime($detail->expire_on));
            $grace_end = date('Y-m-d', strtotime($detail->grace_end));
            
            //null
            if ($expire_on == null) 
            {
                return 'N/A';
            }
            //grace period
            elseif (($today >= $expire_on) && ($today <= $grace_end)) 
            {
                return 'Grace Period';
            }
            //Active
            elseif ($expire_on >= $today) 
            {
                return 'Active';
            }
            //Expired
            else 
            {
                return 'Expired';
            }
        } else return 'N/A';


        // if($detail){ return $expire_on; }else{ return 'N/A'; }
    }

    public function getExpiresOn($id)
    {
        $detail = \App\NewDocument::where('requisition_id', $id)->first();
        if ($detail) { return $detail->expire_on;  } else return 'N/A';
    }

    public function getGraceEnd($id)
    {
        $detail = \App\NewDocument::where('requisition_id', $id)->first();
        if ($detail) { return $detail->grace_end;  } else return 'N/A';
    }

    public function getDuration($id)
    {
        $detail = \App\NewDocument::where('requisition_id', $id)->first();
        if ($detail) {
            $start = strtotime($detail->created_at);
            $end = strtotime($detail->expire_on);
            $duration_in_days = ceil(abs($end - $start) / 86400);
            return $duration_in_days . ' day(s)';
        } else {
            return 'N/A';
        }
    }



    public function getAssigner($id)
    {
        $assignor = \App\AssignContractToUser::where('requisition_id', $id)->first();
        if ($assignor) {
            if ($assignor) {
                return $assignor->author->name;
            } else {
                return 'N/A';
            }
        } else {
            return 'N/A';
        }
    }

    public function getAssignee($id)
    {
        $assigner = \App\AssignContractToUser::where('requisition_id', $id)->first();
        if ($assigner) 
        {
            if ($assigner) 
            {
                return $assigner->user->name;
            } else {
                return 'N/A';
            }
        } 
        else 
        {
            return 'N/A';
        }
    }



    public function getClarityId($id)
    {
        $result = \App\RequisitionClarityResponse::where('requisition_id', $id)->first();
        if ($result) {
            return $result->id;
        } else {
            return null;
        }
    }


    public function getClarity($id)
    {
        $result = \App\RequisitionClarityResponse::where('requisition_id', $id)->first();
        if ($result) {
            if ($result->message != null) {
                return 'Yes';
            } else {
                return 'No';
            }
        } else {
            return 'No';
        }
    }
    public function getClarityView($id)
    {
        $result = \App\RequisitionClarityResponse::where('id', $id)->first();
        if ($result) {
            if ($result->message != null) {
                return 'Yes';
            } else {
                return 'No';
            }
        } else {
            return 'No';
        }
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
        try 
        {
            // return $request->all();
            // return date('Y-m-d', strtotime($request->expire_on . '+ ' . $request->grace_period . 'days'));
            // $arr = $request->path(); $exp_arr = explode('/', $arr); $param = $exp_arr[1];
            $requisition = \App\Requisition::where('id', $request->requisition_id)->first();
            $document = \App\NewDocument::where('requisition_id', $requisition->id)->first();
            $requisition_type = \App\RequisitionType::where('id', $request->document_type_id)->first();

            //updating Doc number
            $sub_name = substr($request->name, 0, 4);
            $sub_cate = substr($requisition_type->name, 0, 2);
            $pref = $sub_name . '-' . $sub_cate;
            $documentCode = $this->document_number($document->id, $pref);

            $document_data = array(
                'document_code' => $documentCode,
                'requisition_id' => $request->requisition_id,
                'name' => $request->name,
                'document_type_id' => $request->document_type_id,
                'cover_page' => $request->cover_page,
                'content' => $request->content,
                'workflow_id' => $requisition->workflow_id,
                'expire_on' => date('Y-m-d', strtotime($request->expire_on)),
                'grace_period' => $request->grace_period,
                'grace_end' => date('Y-m-d', strtotime($request->expire_on . '+ ' . $request->grace_period . 'days')),
                'vendor_id' => $request->vendor_id,
                'stage_id' => 0,
                'title' => $request->name,
                'start' => date('Y-m-d', strtotime($request->expire_on)),
                'end' => date('Y-m-d', strtotime($request->expire_on)),
                'created_by' => \Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s')
            );
            \App\NewDocument::where('id', $document->id)->update($document_data);



            //setting version number
            $words = explode(" ", $request->name);
            $acronym = "";
            foreach ($words as $w) {
                $acronym .= $w[0];
            }

            $version_count = \App\NewDocumentVersion::where('name', $request->name)->count();
            $version_count;
            $versionNo = $this->version_number($version_count, $acronym);

            //adding document versions
            $addVersion = \App\NewDocumentVersion::Create([
                'version_number' => $versionNo,
                'document_id' => $document->id,
                'requisition_id' => $requisition->id,
                'name' => $request->name,
                'document_type_id' => $request->document_type_id,
                'cover_page' => $request->cover_page,
                'content' => $request->content,
                'workflow_id' => $requisition->workflow_id,
                'expire_on' => date('Y-m-d', strtotime($request->expire_on)),
                'grace_period' => $request->grace_period,
                'vendor_id' => $request->vendor_id,
                'stage_id' => 0,
                'created_by' => \Auth::user()->id,
            ]);


            $users = \App\User::orderBy('name', 'asc')->get();

            $position = $requisition->status_id;
            $position = $position++;
            //update requisition contract_created
            $data = array('contract_created' => 1, 'status_id' => $position, 'updated_at' => date('Y-m-d H:i:s'));
            \App\Requisition::where('id', $requisition->id)->where('workflow_id', $requisition->workflow_id)->update($data);

            //update position for workflow
            $DATA = array('position_id' => $position, 'updated_at' => date('Y-m-d H:i:s'));
            \App\Position::where('requisition_id', $requisition->id)->where('workflow_id', $requisition->workflow_id)->update($DATA);

            $stage_detail = \App\Stage::where('workflow_id', $requisition->workflow_id)->where('position', $requisition->status_id)->first();
            $signable = \App\Stage::where('workflow_id', $requisition->workflow_id)->where('position', $requisition->status_id)->where('user_id', \Auth::user()->id)->first();
            $can_approve = \App\Stage::where('workflow_id', $requisition->workflow_id)->where('user_id', \Auth::user()->id)->first();

            $version_ct = \App\NewDocumentVersion::where('document_id', $document->id)->get();
            //email notification
            if (count($version_ct) == 1) 
            {
                $this->send_creation_mail($request->name, $requisition_type->name, $requisition, $document);
            } else {
                $this->send_modified_mail($request->name, $requisition_type->name, $requisition, $document);
            }


            if ($request->ajax()) 
            {
                return response()->json(['details' => $added, 'status' => 'ok', 'info' => 'Success.']);
            } else {
                return redirect()->back()->with(['requisition' => $requisition, 'document' => $document, 'stage_detail' => $stage_detail, 'signable' => $signable, 'can_approve' => $can_approve, 'info' => 'Success']);
                // return view('document-creation.all-documents', compact('document_creations', 'users'));
                // return redirect()->route('document-creation.all-documents')->with(['success' => 'Success']);
            }

            // return redirect()->route('document-creation.new-document')->with(['success' => 'Success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
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




    public function get_requisition_by_id(Request $request)
    {
        $requisition = \App\Requisition::where('id', $request->id)->first();
        return response()->json($requisition);
    }


    public function delete_requisition(Request $request)
    {
        //return $request->all();
        try {
            \App\Requisition::where('id', $request->id)->delete();

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Document Deleted Successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Document Deleted Successfully.']);
            }
            return redirect()->route('document-creation.index')->with(['success' => 'Document Deleted Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }



    public function allDocuments(Request $request)
    {
        $documents = \App\NewDocument::orderBy('id', 'desc')->get();

        $all_documents = \App\NewDocument::orderBy('id', 'desc')->get();
        $pend_assignments = \App\Requisition::where('contract_created', 0)->get();
        $reviewed = \App\NewDocument::where('reviewed_approved', 1)->get();
        $appr_assignments = \App\NewDocument::where('reviewed_approved', 3)->get();
        $controllerName = new DocumentCreationController;

        return view('document-creation.all-documents', compact('documents', 'all_documents', 'pend_assignments', 'reviewed', 'appr_assignments', 'controllerName'));
    }





    public function userDocuments(Request $request)
    {
        // for User Department
        $documents = \App\NewDocument::orderBy('id', 'desc')->get();

        $all_documents = \App\NewDocument::orderBy('id', 'desc')->get();
        $pend_assignments = \App\Requisition::where('contract_created', 0)->get();
        $reviewed = \App\NewDocument::where('reviewed_approved', 1)->get();
        $appr_assignments = \App\NewDocument::where('reviewed_approved', 3)->get();
        $controllerName = new DocumentCreationController;

        return view('document-creation.user-documents', compact('documents', 'all_documents', 'pend_assignments', 'reviewed', 'appr_assignments', 'controllerName'));
    }


    public function getUserTask($requisition_id)
    {
        $document = \App\NewDocument::where('requisition_id', $requisition_id)->first();
        if ($document) {
            $task = \App\Requisition::where('id', $document->requisition_id)->where('user_id', \Auth::user()->id)->orderBy('id', 'desc')->first();

            if ($task) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    public function getPreferedTemplate(Request $request)
    {
        $prefered_temp = \App\Requisition::where('id', $request->id)->first();
        $record = base64_decode($prefered_temp);
        return response()->json($record);
    }




    public function NewDocument(Request $request)
    {
        if (\Auth::user()->department_id == 1) 
        {
            $search = $request->search;
            if ($search) {
                $new_documents = \App\NewDocument::where('name', 'like', "%{$search}%")
                    ->orwhereHas('document_type', function ($query) use ($request) {
                        $query->where('name', 'like', "%{$request->search}%");
                    })
                    ->where('id', '<>', '1')->orderBy('name', 'asc')->paginate(12);
            } else {
                $new_documents = \App\NewDocument::where('id', '<>', '1')->orderBy('id', 'desc')->paginate(11);
            }

            $document_count = \App\NewDocument::orderBy('id', 'desc')->get();

            $arr = $request->path();
            $exp_arr = explode('/', $arr);
            $param = $exp_arr[1];
            $default_document = \App\NewDocument::where('id', '1')->first();
            // $new_documents = \App\NewDocument::where('id', '<>', '1')->orderBy('id', 'desc')->get();
            // $param = $request->query('parameter'); 
            $text = 'Default Template';   //return $new_documents->count();

            return view('document-creation.new-document', compact('default_document', 'new_documents', 'param', 'text', 'document_count'));
        } else {
            return redirect()->back()->with(['status' => 'ok', 'error' => 'Access denied.']);
        }
    }


    public function getRequisitionStage($requisition_id, $workflow_id)
    {
        $position = \App\Position::where('requisition_id', $requisition_id)->first();
        if ($position) {
            $stage = \App\Stage::where('position', $position->position_id)->where('workflow_id', $workflow_id)->first();
            return $stage['name'];
        } else {
            return 'N\A';
        }
    }





    public function createDocument(Request $request)
    {
        if (\Auth::user()->department_id == 1) 
        {
            $arr = $request->path();
            $exp_arr = explode('/', $arr);
            $param = $exp_arr[1];
            $url = $request->path();
            $exp_url = explode('/', $url);
            $temp = $exp_arr[2];
            $requisition = \App\Requisition::where('id', $param)->first();
            // checking for termplate
            if ($temp != null) {
                $doc_temp = \App\NewDocument::where('id', $temp)->first();
            } else if ($temp == 'temp') {
                $doc_temp = \App\NewDocument::where('id', 0)->first();
            }

            $document = \App\NewDocument::where('requisition_id', $requisition->id)->first();



            $versions = \App\NewDocumentVersion::where('document_id', $document->id)->orderBy('id', 'desc')->get();
            $comments = \App\Comment::where('document_id', $document->id)->orderBy('id', 'desc')->get();
            $version_users = \App\NewDocumentVersion::where('document_id', $document->id)->distinct()->get(['created_by']);

            $users = \App\User::orderBy('name', 'asc')->get();

            $vendors = \App\Vendor::orderBy('name', 'asc')->get();
            $categories = \App\RequisitionType::orderBy('name', 'asc')->get();
            $signature = \App\User::where('id', \Auth::user()->id)->first();

            $position = \App\Position::where('requisition_id', $requisition->id)->first();

            $stage_detail = \App\Stage::where('workflow_id', $requisition->workflow_id)->where('position', $position->position_id)->first();
            $signable = \App\Stage::where('workflow_id', $requisition->workflow_id)->where('position', $requisition->status_id)->where('user_id', \Auth::user()->id)->first();

            $approver = \App\Stage::where('workflow_id', $requisition->workflow_id)->where('appraisal', 1)->pluck('user_id')->toArray();
            if (in_array(\Auth::user()->id, $approver)) {
                $can_approve = true;
            } else {
                $can_approve = false;
            }
            $stage = \App\Stage::where('workflow_id', $requisition->workflow_id)->where('user_id', \Auth::user()->id)->first();


            $signables = \App\Stage::where('workflow_id', $document->workflow_id)->where('signable', 1)->get();
            foreach ($signables as $key => $value) {
                $signatures[$key] = \App\User::where('id', $value->user_id)->first();
            }

            $controllerName = new DocumentCreationController;


            return view('document-creation.create', compact('param', 'temp', 'users', 'doc_temp', 'requisition', 'document', 'vendors', 'categories', 'controllerName', 'versions', 'comments', 'version_users', 'signature', 'stage_detail', 'signable', 'can_approve', 'stage', 'signatures'));
        } else {
            $arr = $request->path();
            $exp_arr = explode('/', $arr);
            $param = $exp_arr[1];
            $url = $request->path();
            $exp_url = explode('/', $url);
            $temp = $exp_arr[2];
            $requisition = \App\Requisition::where('id', $param)->first();
            //if this is the user/requestor
            if (\Auth::user()->id == $requisition->user_id) {
                // checking for termplate
                if ($temp != null) {
                    $doc_temp = \App\NewDocument::where('id', $temp)->first();
                } else if ($temp == 'temp') {
                    $doc_temp = \App\NewDocument::where('id', 0)->first();
                }
                $document = \App\NewDocument::where('requisition_id', $requisition->id)->first();



                $versions = \App\NewDocumentVersion::where('document_id', $document->id)->orderBy('id', 'desc')->get();
                $comments = \App\Comment::where('document_id', $document->id)->orderBy('id', 'desc')->get();
                $version_users = \App\NewDocumentVersion::where('document_id', $document->id)->distinct()->get(['created_by']);

                $users = \App\User::orderBy('name', 'asc')->get();

                $vendors = \App\Vendor::orderBy('name', 'asc')->get();
                $categories = \App\RequisitionType::orderBy('name', 'asc')->get();
                $signature = \App\User::where('id', \Auth::user()->id)->first();

                $position = \App\Position::where('requisition_id', $requisition->id)->first();

                $stage_detail = \App\Stage::where('workflow_id', $requisition->workflow_id)->where('position', $position->position_id)->first();
                $signable = \App\Stage::where('workflow_id', $requisition->workflow_id)->where('position', $requisition->status_id)->where('user_id', \Auth::user()->id)->first();

                $approver = \App\Stage::where('workflow_id', $requisition->workflow_id)->where('appraisal', 1)->pluck('user_id')->toArray();
                if (in_array(\Auth::user()->id, $approver)) {
                    $can_approve = true;
                } else {
                    $can_approve = false;
                }
                $stage = \App\Stage::where('workflow_id', $requisition->workflow_id)->where('user_id', \Auth::user()->id)->first();


                $signables = \App\Stage::where('workflow_id', $document->workflow_id)->where('signable', 1)->get();
                foreach ($signables as $key => $value) {
                    $signatures[$key] = \App\User::where('id', $value->user_id)->first();
                }

                $controllerName = new DocumentCreationController;


                return view('document-creation.create', compact('param', 'temp', 'users', 'doc_temp', 'requisition', 'document', 'vendors', 'categories', 'controllerName', 'versions', 'comments', 'version_users', 'signature', 'stage_detail', 'signable', 'can_approve', 'stage', 'signatures'));
            } else {
                return redirect()->back()->with(['status' => 'ok', 'error' => 'Access denied.']);
            }
        }
    }


    public function document_details(Request $request, $id)
    {
        $arr = $request->path();
        $exp_arr = explode('/', $arr);
        // $id = $exp_arr[1];
        $detail = \App\NewDocument::where('id', $id)->first();
        $requisition = \App\Requisition::where('id', $detail->requisition_id)->first();


        $users = \App\User::orderBy('name', 'asc')->get();
        $requisition_types = \App\RequisitionType::orderBy('name', 'asc')->get();
        $departments = \App\Department::orderBy('name', 'asc')->get();
        $workflows = \App\Workflow::orderBy('name', 'asc')->get();

        $controllerName = new DocumentCreationController;

        return view('document-creation.detail', compact('id', 'requisition', 'detail', 'users', 'requisition_types', 'departments', 'workflows', 'controllerName'));
    }





    public function viewDocument(Request $request)
    {
        $users = \App\User::orderBy('name', 'asc')->get();

        $arr = $request->path();
        $exp_arr = explode('/', $arr);
        $id = $exp_arr[1];
        $requisition = \App\Requisition::where('id', $id)->first();
        $document_detail = \App\NewDocument::where('id', $id)->first();
        $signables = \App\Stage::where('workflow_id', $document_detail->workflow_id)->where('signable', 1)->get();
        foreach ($signables as $key => $value) {
            $signatures[$key] = \App\User::where('id', $value->user_id)->first();
        }

        $position = \App\Position::where('workflow_id', $document_detail->workflow_id)->where('requisition_id', $id)->first();
        $classification = \App\RequisitionClassification::where('requisition_id', $id)->first();


        return view('document-creation.view', compact('users', 'id', 'requisition', 'document_detail', 'signatures', 'position', 'classification'));
    }


    public function getDocumentStage($requisition_id, $workflow_id)
    {
        $position = \App\Position::where('requisition_id', $requisition_id)->first();
        if ($position) 
        {
            $stage = \App\Stage::where('position', $position->position_id)->where('workflow_id', $workflow_id)->first();
            if($stage)
            {
                return $stage['name'];
            }else return null;
            
        } else {
            return 'N\A';
        }
    }

    public function getDocPosition($requisition_id)
    {
        $position = \App\Position::where('requisition_id', $requisition_id)->first();
        if($position){ return $position->position_id; }        
    }

    public function getDocumentCreator($requisition_id)
    {
        $user = \App\AssignContractToUser::where('requisition_id', $requisition_id)->first();
        if ($user) {
            return $user['user_id'];
        } else {
            return null;
        }
    }

    public function getDocumentReviewer($requisition_id)
    {
        $reviewer = \App\AssignContractToUser::where('requisition_id', $requisition_id)->first();
        if ($reviewer) {
            return $reviewer['reviewer_id'];
        } else {
            return null;
        }
    }

    public function getDocumentApprover($requisition_id)
    {
        $approver = \App\AssignContractToUser::where('requisition_id', $requisition_id)->first();
        if ($approver) {
            return $approver['approver_id'];
        } else {
            return null;
        }
    }

    public function getDelegateApprover($document_id)
    {
        $approver = \App\AssignTask::where('document_id', $document_id)->where('action', 'Approval')->first();
        return $approver['user_id'];
    }

    public function getDelegateRoleDate($document_id)
    {
        $approver = \App\AssignTask::where('document_id', $document_id)->where('action', 'Approval')->first();
        return $approver['end_date'];
    }





    public function getDocumentUsers($requisition_id, $type)
    {
        $assign = \App\AssignContractToUser::where('requisition_id', $requisition_id)->first();
        if($type == 'user_id')
        {
            $details = \App\User::where('id', $assign->user_id)->first();
            return $details->name; 
        }
        elseif($type == 'reviewer_id')
        {
            $details = \App\User::where('id', $assign->reviewer_id)->first();
            return $details->name; 
        }
        elseif($type == 'approver_id')
        {
            $details = \App\User::where('id', $assign->approver_id)->first();
            return $details->name; 
        }
        elseif($type == 'created_by')
        {
            $details = \App\User::where('id', $assign->created_by)->first();
            return $details->name; 
        }
    }






    public function reviewsAndComments(Request $request)
    {
        try {
            //return $request->all();
            $document_id = $request->document_id;
            $requisition_id = $request->requisition_id;
            $comment = $request->comment;
            $name = $request->name;
            $recipients = \App\NewDocumentVersion::where('document_id', $document_id)->distinct()->get(['created_by']);

            // adding document Comments
            $add = \App\Comment::Create([
                'document_id' => $document_id,
                'name' => $name,
                'comment' => $comment,
                'created_by' => \Auth::user()->id,
            ]);

            // $position_detail = \App\Position::where('requisition_id', $requisition_id)->first();
            // $position = $position_detail->position_id; $position++;
            //update position for workflow
            // $DATA = array('position_id' => $position, 'updated_at' => date('Y-m-d H:i:s'));   
            // \App\Position::where('requisition_id', $requisition_id)->where('workflow_id', $position_detail->workflow_id)->update($DATA);

            $count = $request->count;
            for ($i = 1; $i <= $count; $i++) {
                $recipient_id[$i] = $request->input('recipient_' . $i . '');
            }  //dd($recipient_id);

            if ($recipient_id == null) {
                $recipient_id = \App\NewDocumentVersion::where('document_id', $document->id)->distinct()->get(['created_by']);
            }

            //email notification
            $this->send_comment_mail($name, $recipient_id, $comment, $requisition_id);
            if ($request->recipient_user != null) {
                $this->send_comment_mail_user($name, $request->recipient_user, $comment, $requisition_id);
            }


            if ($request->ajax()) {
                return response()->json(['details' => $add, 'status' => 'ok', 'info' => 'Comment Added Successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Comment Added Successfully.']);
            }

            return redirect()->route('document-creations.index')->with(['success' => 'Comment Added Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }

    public function reviewDocument(Request $request)
    {
        try {
            // return $request->all();
            $document_id = $request->document_id;
            $requisition_id = $request->requisition_id;
            $name = $request->name;

            $document_detail = \App\NewDocument::where('id', $document_id)->first();
            $position_detail = \App\Position::where('requisition_id', $requisition_id)->first();
            $position = $position_detail->position_id;
            $position++;

            $recipients = \App\NewDocumentVersion::where('document_id', $document_id)->distinct()->get(['created_by']);

            //update document reviewed_approved
            $data = array('reviewed_approved' => 1, 'updated_at' => date('Y-m-d H:i:s'));
            \App\NewDocument::where('id', $document_id)->update($data);

            //update position for workflow
            $DATA = array('position_id' => $position, 'updated_at' => date('Y-m-d H:i:s'));
            \App\Position::where('requisition_id', $requisition_id)->where('workflow_id', $document_detail->workflow_id)->update($DATA);

            foreach ($recipients as $k => $recipient) {
                $recipient_id[$k] = $recipient->created_by;
            } //return $recipient_id;

            //email notification
            $this->send_reviewed_mail($name, $recipient_id, $requisition_id, $position);

            if ($request->ajax()) {
                return response()->json(['details' => $add, 'status' => 'ok', 'info' => 'Document Was reviewed Successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Document Was reviewed Successfully.']);
            }

            return redirect()->route('document-creations.index')->with(['success' => 'Document Was reviewed Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }

    public function pushForApproval(Request $request)
    {
        try {
            // return $request->all();
            $document_id = $request->document_id;
            $requisition_id = $request->requisition_id;
            $name = $request->name;

            $document_detail = \App\NewDocument::where('id', $document_id)->first();
            $position_detail = \App\Position::where('workflow_id', $document_detail->workflow_id)->first();
            $position = $position_detail->position_id;
            $position++;

            // $recipients = \App\NewDocumentVersion::where('document_id', $document_id)->distinct()->get(['created_by']);
            $recipients = \App\Stage::where('workflow_id', $document_detail->workflow_id)->get();

            //update document reviewed_approved
            $data = array('reviewed_approved' => 2, 'updated_at' => date('Y-m-d H:i:s'));
            \App\NewDocument::where('id', $document_id)->update($data);

            $position_detail = \App\Position::where('requisition_id', $requisition_id)->first();
            $position = $position_detail->position_id;
            $position++;

            //update position for workflow
            $DATA = array('position_id' => $position, 'updated_at' => date('Y-m-d H:i:s'));
            \App\Position::where('requisition_id', $requisition_id)->where('workflow_id', $document_detail->workflow_id)->update($DATA);

            foreach ($recipients as $k => $recipient) {
                $recipient_id[$k] = $recipient->user_id;
            } //return $recipient_id;

            //email notification
            $this->send_push_for_approval_mail($name, $recipient_id, $document_id);

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Request for document approval was sent successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Request for document approval was sent successfully.']);
            }

            return redirect()->route('document-creations.index')->with(['success' => 'Request for document approval was sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }



    public function signSignature(Request $request)
    {
        try {
            $id = \Auth::user()->id;
            $type = 'png';
            $image = 'data:image/' . $type . ';base64,' . $request->img_data;

            $signature = '<p><img alt="" src="' . $image . '" style="width: 130px; height: 45px;"></p>';

            $add = \App\User::updateOrCreate(
                ['id' => $id],
                array('signature' => $signature,)
            );

            return response()->json(['status' => 'ok', 'info' => 'Your signature saved successfully.']);
        } catch (\Exception $e) {
            return ['status' => 'error', 'info' => 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()];
        }
    }


    public function uploadSignature(Request $request)
    {
        try {
            $file = $request->file;
            $signature = $file->getClientOriginalName();
            $destinationPath = 'assets/images/signature/' . $file->getClientOriginalName();
            $file->move($destinationPath, $file->getClientOriginalName());
            $document_path = $destinationPath;

            $type = pathinfo($document_path, PATHINFO_EXTENSION);
            $data = file_get_contents($document_path . '/' . $signature);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

            // $image = 'data:image/' . $type . ';base64,' . $request->img_data;

            $base64 = '<img alt="" src="' . $base64 . '" style="width: 130px; height: 45px;">';


            $id = \Auth::user()->id;

            $add = \App\User::updateOrCreate(
                ['id' => $id],
                array('signature' => $signature, 'signature_path' => $destinationPath, 'image' => $base64,)
            );

            return redirect()->back()->with(['status' => 'ok', 'info' => 'Your signature saved successfully.']);
        } catch (\Exception $e) {
            return ['status' => 'error', 'info' => 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()];
        }
    }

    public function approveDocument(Request $request)
    {
        try {
            // return $request->all();
            $document_id = $request->document_id;
            $requisition_id = $request->requisition_id;
            $name = $request->name;

            $document_detail = \App\NewDocument::where('id', $document_id)->first();
            $position_detail = \App\Position::where('workflow_id', $document_detail->workflow_id)->first();
            $position = $position_detail->position_id;
            $position++;

            $recipients = \App\NewDocumentVersion::where('document_id', $document_id)->distinct()->get(['created_by']);

            //update document reviewed_approved
            $data = array('cover_page' => $request->signatures, 'reviewed_approved' => 3, 'updated_at' => date('Y-m-d H:i:s'));
            \App\NewDocument::where('id', $document_id)->update($data);

            //update position for workflow
            $DATA = array('position_id' => $position, 'updated_at' => date('Y-m-d H:i:s'));
            \App\Position::where('requisition_id', $requisition_id)->where('workflow_id', $document_detail->workflow_id)->update($DATA);

            //update requisition status
            // $_data = array('status_id' => $position, 'updated_at' => date('Y-m-d H:i:s'));   
            // \App\Requisition::where('id', $requisition_id)->update($_data);

            foreach ($recipients as $k => $recipient) 
            {
                $recipient_id[$k] = $recipient->created_by;
            } //return $recipient_id;

            //email notification
            $this->send_approve_document_mail($name, $recipient_id, $document_id, $requisition_id);

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Document was approved successfully.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Document was approved successfully.']);
            }

            return redirect()->route('view-document', $document->id)->with(['info' => 'Document was approved successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }

    public function declineDocument(Request $request)
    {
        try {
            // return $request->all();
            $document_id = $request->document_id;
            $requisition_id = $request->requisition_id;
            $name = $request->name;
            $document_detail = \App\NewDocument::where('id', $document_id)->first();

            // adding decline
            $add = \App\DocumentDecline::Create([
                'document_id' => $document_id,
                'comment' => $request->comment,
                'status_id' => 0,
                'created_by' => \Auth::user()->id,
            ]);

            //RE-SETTING DOCUMENT STAGE TO CREATION STAGE
            //update document reviewed_approved
            $data = array('reviewed_approved' => 0, 'updated_at' => date('Y-m-d H:i:s'));
            \App\NewDocument::where('id', $document_id)->update($data);

            //update position for workflow
            $DATA = array('position_id' => 2, 'updated_at' => date('Y-m-d H:i:s'));
            \App\Position::where('requisition_id', $requisition_id)->where('workflow_id', $document_detail->workflow_id)->update($DATA);



            $recipients = \App\NewDocumentVersion::where('document_id', $document_id)->distinct()->get(['created_by']);
            foreach ($recipients as $k => $recipient) {
                $recipient_id[$k] = $recipient->created_by;
            } //return $recipient_id;

            //email notification
            $this->send_decline_document_mail($name, $recipient_id, $document_id, $request->comment);

            if ($request->ajax()) {
                return response()->json(['status' => 'ok', 'info' => 'Document approval request declined.']);
            } else {
                return redirect()->back()->with(['status' => 'ok', 'info' => 'Document approval request declined.']);
            }

            return redirect()->route('create-document', $document->id)->with(['success' => 'Document approval request declined']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }




    public function preferedTemplate(Request $request)
    {
        $prefered_templates = \App\PreferedTemplate::orderBy('id', 'desc')->get();
        $requisitions = \App\Requisition::orderBy('id', 'desc')->get();
        $users = \App\User::orderBy('name', 'asc')->get();

        return view('document-creation.prefered-template', compact('prefered_templates', 'requisitions', 'users'));
    }

    public function CreatePreferedTemplate(Request $request)
    {
        $requisitions = \App\Requisition::orderBy('id', 'desc')->get();
        $users = \App\User::orderBy('name', 'asc')->get();

        return view('document-creation.create-prefered-template', compact('requisitions', 'users'));
    }

    public function StorePreferedTemplate(Request $request)
    {
        try {   //return $request->all();
            $file = $request->file;

            $file_name = $file->getClientOriginalName();
            $destinationPath = 'assets/images/prefered-templates/' . $file_name;
            $file->move($destinationPath, $file_name);

            $add = \App\PreferedTemplate::updateOrCreate(
                ['id' => $request->id],
                [
                    'requisition_id' => $request->requisition_id,
                    'template_name' => $file_name,
                    'template_path' => $destinationPath,
                    'user_id' => $request->user_id,
                    'created_by' => \Auth::user()->id,
                ]
            );


            //email notification
            $requisition = \App\Requisition::where('id', $request->requisition_id)->first();
            $this->send_prefered_template_mail($request->user_id, $requisition->name, $add->id);

            return redirect()->route('prefered-tamplates')->with(['status' => 'ok', 'info' => 'Template created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }

    public function preferedTemplateView(Request $request, $id)
    {
        $template = \App\PreferedTemplate::where('id', $id)->first();

        return view('document-creation.prefered-template-view', compact('template'));
    }

    public function get_template_by_id(Request $request)
    {
        $template = \App\PreferedTemplate::where('id', $request->id)->first();

        return response()->json($template);
    }




    public function getPreferedTemplateById(Request $request, $id)
    {
        $template = \App\Requisition::where('id', $id)->first();

        return view('document-creation.get-prefered-template', compact('template'));
    }





    public function downloadWord(Request $request)
    {
        // $template = new \PhpOffice\PhpWord\TemplateProcessor('C:\Users\JIMI-Snapnet\Desktop\Test Excel\Proposal Template.docx');
        $constants = \App\ProposalConstant::where('proposal_name', 'Enterprise Resource Planning')->get();
        $text = 'This is a Text';
        $alias = "test word doc";
        $word = new PhpWord;
        $section = $word->addSection();
        Html::addHtml($section, trim($constants), false, false);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment;filename="' . $alias . '.docx"');
        $objWriter = IOFactory::createWriter($word, 'Word2007');
        $objWriter->save('php://output');
    }


    public  function convertToDoc(Request $request)
    {

        header("Content-Type: application/vnd.ms-word");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("content-disposition: attachment;filename=Report.doc");
    }















    public function pending_reviews(Request $request)
    {  //return $request->all();      
        $pending_reviews = \App\NewDocument::where('reviewed_approved', '>', 0)->where('reviewed_approved', '<', 3)->orderBy('id', 'desc')->get();

        $reviewing = $pending_reviews->where('reviewed_approved', 1);
        $approving = $pending_reviews->where('reviewed_approved', 2);
        $declined = $pending_reviews->where('reviewed_approved', 3);

        $controllerName = new DocumentCreationController;

        return view('document-creation.reviews', compact('pending_reviews', 'controllerName', 'reviewing', 'approving', 'declined'));
    }



    public function testword()
    {
        // $inputFileName = 'assets\images\prefered-templates\MTN SLA Contract.docx\MTN SLA Contract.docx';

        /** Load $inputFileName to a Spreadsheet object **/
        // $inputFileName = IOFactory::identify($inputFileName);
        // dd($inputFileName);
        // return $spreadsheet = IOFactory::load($inputFileName);

        /*Name of the document file*/
        $document = 'assets\images\prefered-templates\MTN SLA Contract.docx\MTN SLA Contract.docx';

        /**Function to extract text*/
        function extracttext($filename)
        {
            //Check for extension
            $ext = end(explode('.', $filename));

            //if its docx file
            if ($ext == 'docx')
                $dataFile = "word/document.xml";
            //else it must be odt file
            else
                $dataFile = "content.xml";

            //Create a new ZIP archive object
            $zip = new ZipArchive;

            // Open the archive file
            if (true === $zip->open($filename)) {
                // If successful, search for the data file in the archive
                if (($index = $zip->locateName($dataFile)) !== false) {
                    // Index found! Now read it to a string
                    $text = $zip->getFromIndex($index);
                    // Load XML from a string
                    // Ignore errors and warnings
                    $xml = DOMDocument::loadXML($text, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                    // Remove XML formatting tags and return the text
                    return strip_tags($xml->saveXML());
                }
                //Close the archive file
                $zip->close();
            }

            // In case of failure return a message
            return "File not found";
        }

        echo extracttext($document);
    }



    public function shareLinkUrl(Request $request)
    {
        try {
            //return $request->all();            
            $file = $request->file;

            if ($file != null) {
                $file_name = $file->getClientOriginalName();
                $destinationPath = 'assets/images/link-urls/' . $file->getClientOriginalName();
                $file->move($destinationPath, $file->getClientOriginalName());
            } else {
                $file_name = null;
                $destinationPath = null;
            }


            // adding document Comments
            $add = \App\DocumentLinkUrl::updateOrCreate(
                ['id' => $request->id],
                [
                    'user_id' => $request->user_id,
                    'vendor_email' => $request->vendor_email,
                    'file_name' => $file_name,
                    'file_path' => $destinationPath,
                    'link_url' => $request->link_url,
                    'comment' => $request->comment,
                    'created_by' => \Auth::user()->id,
                ]
            );

            //create temp Vendor
            $vendor = \App\VendorEmail::updateOrCreate(
                ['email' => $request->vendor_email],
                [
                    'email' => $request->vendor_email,
                ]
            );


            //email notification
            $this->send_share_link_mail($request->user_id, $vendor->id, $request->comment, $request->link_url);

            if ($request->ajax()) {
                return response()->json(['details' => $add, 'status' => 'ok', 'info' => 'Document link / url sent successfully.']);
            } else {
                return redirect()->route('document-link-url')->with(['info' => 'Document link / url sent successfully']);
            }

            // return redirect()->route('document-creations.document-link-url')->with(['info' => 'Document link / url sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'Sorry, An Error Occurred Please Try Again. ' . $e->getMessage()]);
        }
    }


    public function documentLinkUrl(Request $request)
    {
        $users = \App\User::orderBy('name', 'asc')->get();

        // $arr = $request->path(); $exp_arr = explode('/', $arr); $id = $exp_arr[1];
        $link_urls = \App\DocumentLinkUrl::orderBy('id', 'desc')->get();

        return view('document-creation.document-link-url', compact('users', 'link_urls'));
    }

    


    public function checkIfDepartmentHead($id)
    {
        $requisition = \App\Requisition::where('id', $id)->first();
        $department = \App\Department::where('id', $requisition->department_id)->first();
        if(\Auth::user()->id == $department->department_head_id){ return true; }
        else{ return false; }
    }


    public function testdocument(Request $request)
    {
        return view('document-creation.test-document');
    }



    public function googleReact(Request $request)
    {
        return view('document-creation.google-react');
    }

    public function googleReactEdit(Request $request)
    {
        return view('document-creation.google-react-edit');
    }


    public function getTaskById(Request $request)
    {
        $task = \App\Requisition::where('id', $request->id)->first();
        return response()->json($task);
    }


    public function getTaskGoogleId(Request $request)
    {
        $task = \App\Requisition::where('id', $request->id)->first();
        return response()->json($task->google_doc_id);
    }


    public function updateDocumentId(Request $request)
    {
        // updating document         
        $data = array('google_doc_id' => $request->google_doc_id, 'updated_at' => date('Y-m-d H:i:s'));
        \App\Requisition::where('id', $request->id)->update($data);
    }
}
