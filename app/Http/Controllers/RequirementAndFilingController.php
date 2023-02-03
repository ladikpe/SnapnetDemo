<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequirementAndFilingController extends Controller
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



    public function index(Request $request)
    {
        //return $request->all();      
        $search = $request->search;      $column = $request->column;     $sort = $request->sort;
        if(!$column){ $column = 'id'; }    if(!$sort){ $sort = 'desc'; }
        if ($search || $column || $sort)
        {
            $calendars = \App\RequirementAndFiling::where('id', 'like', "%{$search}%")->orwhere('title', 'like', "%{$search}%")
                ->orwhere('description', 'like', "%{$search}%")->orwhere('start', 'like', "%{$search}%")->orwhere('end', 'like', "%{$search}%")
                ->orwhere('start_time', 'like', "%{$search}%")->orwhere('end_time', 'like', "%{$search}%")
                ->orderBy($column, $sort)->paginate(10);
        }
        else
        { 
            $calendars = \App\RequirementAndFiling::orderBy('id', 'desc')->paginate(10);
        }

        $users = \App\User::orderBy('name', 'asc')->get();
        $controllerName = new DocumentCreationController;

        return view('requirements-and-filings.index', compact('calendars', 'users', 'controllerName'));
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
            //return $request->all();
            $id = $request->id;    $document = $request->document;
            if($id > 0)
            {  
                $requirement_filing = \App\RequirementAndFiling::where('id', $id)->first();
                $document_name = $requirement_filing->document_name;
                $document_path = $requirement_filing->document_path;
            }

            if($document != null)
            {
                $document_name = $document->getClientOriginalName();
                $destinationPath = 'assets/images/filings/' . $document->getClientOriginalName();
                $document->move($destinationPath, $document->getClientOriginalName());
            }else{  }
            

            //adding 
            $add = \App\RequirementAndFiling::updateOrCreate
            (['id'=> $id],
            [              
                'title' => $request->title,
                'description' => $request->description,
                'start' => date('Y-m-d', strtotime($request->start)),
                'end' => date('Y-m-d', strtotime($request->end)),
                'start_time' => date('h:i:s', strtotime($request->start)),
                'end_time' => date('h:i:s', strtotime($request->end)),
                'recurring' => $request->recurring,
                'monthly' => $request->monthly,
                'quarterly' => $request->quarterly,
                'bi_annually' => $request->bi_annually,
                'yearly' => $request->yearly,
                'document_name' => $document_name,
                'document_path' => $destinationPath,
                'created_by' => \Auth::user()->id,
            ]);
            

            //email notification
            // $this->send_creation_mail($request->name, $requisition_type->name, $requisition);

            if($request->ajax())
            {
                return response()->json(['details' => $add, 'status'=>'ok', 'info'=>'Requirements & Filings Created Successfully.']);
            }
            else
            {
                return response()->json(['details' => $add, 'status'=>'ok', 'info'=>'Requirements & Filings Created Successfully.']);
            }            
              
            return redirect()->route('requirements-and-filings.index')->with(['info' => 'Requirements & Filings Created Successfully']);
        }
        catch (\Exception $e) 
        {
            return response()->json(['status'=>'error', 'Sorry, An Error Occurred Please Try Again. '.$e->getMessage()]);
        }
    }




    public function upload_requirementfiling(Request $request)
    {
        $this->validate($request, ['file' => 'required|mimes:csv,xlsx,txt']);

        try 
        {
            $getFile = $request->file('file')->getRealPath();
            $ob = \PhpOffice\PhpSpreadsheet\IOFactory::load($getFile);
            $ob = $ob->getActiveSheet()->toArray(null, true, true, true);

            foreach ($ob as $key => $row) 
            {
                //getting the Recurring
                $monthly = null;    $quarterly = null;    $bi_annually = null;    $yearly = null;
                $recurr = \App\Recurring::where('name', $row['E'])->first();
                if ($recurr) 
                {   
                    $recurring = $recurr->name;
                    switch ($recurring) 
                    {
                      case "Monthly":
                          $monthly = $recurring;
                      break;
                      case "Quartherly":
                          $quarterly = $recurring;
                      break;
                      case "Bi-annually":
                          $bi_annually = $recurring;
                      break;
                      case "Yearly":
                          $yearly = $recurring;
                      break;
                      
                      default:
                          // code...
                      break;
                    }  
                } 
                else 
                {   
                    $recurring = null;   
                    switch ($recurring) 
                    {
                      case "Monthly":
                          $monthly = $recurring;
                      break;
                      case "Quartherly":
                          $quarterly = $recurring;
                      break;
                      case "Bi-annually":
                          $bi_annually = $recurring;
                      break;
                      case "Yearly":
                          $yearly = $recurring;
                      break;
                      
                      default:
                          // code...
                      break;
                    }
                }

                if ($key >= 2) 
                {
                    //UPLOADING NEW
                    $upload = \App\RequirementAndFiling::updateOrCreate(
                        ['title' => $row['A']],
                        [
                            'title' => $row['A'],
                            'description' => $row['B'],
                            'start' => date('Y-m-d', strtotime($row['C'])),
                            'end' => date('Y-m-d', strtotime($row['D'])),
                            'recurring' => $recurring ,
                            'monthly' => $monthly,
                            'quarterly' => $quarterly,
                            'bi_annually' => $bi_annually,
                            'yearly' => $yearly,
                            'document_name' => $row['F'],
                            'created_by' => \Auth::user()->id
                        ]
                    );

                    //email notification
                    // $this->vendor_registration_mail($vendor_name, $upload->id);
                }
            }

            return redirect()->back()->with(['info' => 'New requirement & filing uploaded successfully']);
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
        return $request->$id;
            // $arr = $request->path(); $exp_arr = explode('/', $arr); $param = $exp_arr[1];
        \App\RequirementAndFiling::where('id', $id)->delete();
    }

    public function delete(Request $request)
    {
        //return $request->all();
        // $arr = $request->path(); $exp_arr = explode('/', $arr); $param = $exp_arr[1];
        \App\RequirementAndFiling::where('id', $request->id)->delete();
    }



    public function get_requirement_filings_by_id(Request $request)
    {
        $requirement_filing = \App\RequirementAndFiling::where('id', $request->id)->first();
        return response()->json($requirement_filing); 
    }


    public function calendar(Request $request)
    {
        // return view('vendors.calendar', compact('arr'));
        return view('requirements-and-filings.calendar');
    }


    public function action(Request $request)
    {
        //return $request->all();
        if($request->ajax())
        {
            if($request->type == 'add')
            {
                $event = \App\Event::create(
                [
                    'title' => $request->title,
                    'start' => date('Y-m-d'),
                    'end' => date('Y-m-d')
                ]);
                return response()->json($event);
            }
        }
    }




    public function getEventData(Request $request)
    {
        //return $request->all();
        $allData = \App\NewDocument::get();
        return response()->json($allData);       
    }

}
