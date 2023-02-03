<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Group;
use App\Folder;
use App\WorkFlow;
use App\Document;
use App\Review;
use App\Stage;
use App\Notifications\ReviewDocument;
use App\Notifications\DocumentApproved;
use App\Notifications\DocumentRejected;
use App\Notifications\DocumentPassedStage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Filters\DocumentFilter;
use Illuminate\Support\Str;
use App\Traits\LogAction;
use App\Tag;

class DocumentController extends Controller
{
  use LogAction;
  public function __construct()
  {
    $this->middleware('auth');
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    switch (Auth::user()->role_id) {
      case 3:
        $documents = Document::where('user_id', Auth::user()->id)->paginate(15);
        return  view('documents.list', ['documents' => $documents]);
        break;

      default:
        if (count($request->all()) == 0) {
          $users = User::all();
          $folders = Folder::all();
          $documents = Document::paginate(15);
          return  view('documents.list', ['documents' => $documents, 'users' => $users, 'folders' => $folders]);
        } else {
          $users = User::all();
          $folders = Folder::all();
          $documents = DocumentFilter::apply($request);
          return  view('documents.list', ['documents' => $documents, 'users' => $users, 'folders' => $folders]);
        }
        break;
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $users = User::all();
    $groups = Group::all();
    $folders = Folder::all();
    $workflows = Workflow::all();
    return view('documents.create', ['users' => $users, 'groups' => $groups, 'folders' => $folders, 'workflows' => $workflows]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {

    // try {
    $no_of_files = count($request->file('file'));
    //  $this->validate($request, ['description'=>'required|min:5','comment'=>'required|min:5','assigned_user'=>'required|integer','worflow_id'=>'required|integer']);
    for ($i = 0; $i < $no_of_files; $i++) 
    {

      // $filename = uniqid().File::extension($request->file('file')[$i]->getClientOriginalName());
      // $path = "Documents/";
      // Storage::disk('local')->put($path.$filename,file_get_contents($request->file('file')[$i]->getClientOriginalName()));
      $document = new Document();
      $document->description = $request->description;
      $document->comment = $request->comment;
      $document->workflow_id = $request->workflow_id;
      if (session('node_id')) {
        $document->folder_id = session('node_id');
      } else {
        $document->folder_id = 1;
      }
      $document->user_id = $request->assigned_user;
      $document->expires = $request->expires;
      $document->filename = $request->file('file')[$i]->getClientOriginalName();
      $document->size = $request->file('file')[$i]->getSize();

      //store get_included_files
      if ($request->file('file')[$i]) {
        $path = $request->file('file')[$i]->store('public');
        if (Str::contains($path, 'public/')) {
          $filepath = Str::replaceFirst('public/', '', $path);
        } else {
          $filepath = $path;
        }
        $document->path = $filepath;
      }
      $document->save();

      $logmsg = 'Document was created';
      $this->saveLog('info', 'App\Document', $document->id, 'documents', $logmsg, Auth::user()->id);
      $stage = Workflow::find($document->workflow_id)->stages->first();
      $review = new Review();
      $review->stage_id = $stage->id;
      $review->document_id = $document->id;
      $review->status = 0;
      $review->save();
      $logmsg = 'New review process started for ' . $document->filename . ' in the ' . $stage->workflow->name;
      $this->saveLog('info', 'App\Review', $review->id, 'reviews', $logmsg, Auth::user()->id);

      $no_of_perms = count($request->input('group_id'));
      for ($i = 0; $i < $no_of_perms; $i++) {
        $check_values = ['document_id' => $document->id, 'group_id' => $request->input('group_id')[$i]];
        $insert_values = [
          'document_id' => $document->id, 'group_id' => $request->input('group_id')[$i],
          'permission_id' => $request->input("perm_$i"), 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')
        ];
        $exists = DB::table('document_group_access')
          ->where($check_values)
          ->exists();
        if ($exists) {
          DB::table('document_group_access')
            ->where($check_values)
            ->update(['permission_id' => $request->input("perm_$i")]);
        } else {
          DB::table('document_group_access')->insert($insert_values);
        }
      }
      $tags = $request->input('tags');
      $tagsArray = [];
      $tok = strtok($tags, " ,");

      while ($tok !== false) {
        $arrayName[] = $tok;
        $tag = Tag::where('name', $tok)->first();
        if ($tag) {
          $document->tags()->attach($tag->id, ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        } else {
          $newtag = new Tag();
          $newtag->name = $tok;
          $newtag->save();
          $document->tags()->attach($newtag->id, ['created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
        }
        $tok = strtok(",");
      }


      //
      $stage->user->notify(new ReviewDocument($document));
    }
    return redirect()->route('documents')->with(['success' => 'Documents Created Successfully']);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      $document = Document::find($id);
      return view('documents.view', ['document' => $document]);
    } catch (\Exception $e) { }
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
  public function hasPendingReviews($id)
  {
    $has_reviews = DB::table('document_reviews')
      ->where('document_reviews.status', 0)
      ->where('document_reviews.document_id', $id)->exists();
    return $has_reviews;
  }
  public function documentReviews($id)
  {
    $reviews = Document::find($id)->reviews;
    // $reviews=DB::table('document_reviews')
    // ->where('document_reviews.document_id', $id)
    // ->orderBy('created_at', 'asc')->get();
    return $reviews;
  }
  public function search(Request $request)
  {
    $q = $request->q;
    $documents = Document::whereHas('tags', function ($query) use ($q) {
      $query->where('name', 'like', '%' . $q . '%');
    })
      ->orWhereHas('reviews', function ($query) use ($q) {
        $query->where('comment', 'like', '%' . $q . '%');
      })
      ->orWhereHas('folder', function ($query) use ($q) {
        $query->where('nm', 'like', '%' . $q . '%');
      })
      ->orWhere('filename', 'LIKE', '%' . $q . '%')->orWhere('comment', 'LIKE', '%' . $q . '%')
      ->orWhere('description', 'LIKE', '%' . $q . '%')->orderBy('created_at', 'asc')->distinct()->get();

    
    $contracts = \App\Contract::whereHas('tags', function ($query) use ($q) {
      $query->where('name', 'like', '%' . $q . '%');
    })
      ->orWhereHas('contract_reviews', function ($query) use ($q) {
        $query->where('comment', 'like', '%' . $q . '%');
      })
      ->orWhereHas('contract_details', function ($query) use ($q) {
        $query->where('cover_page', 'like', '%' . $q . '%')
        ->orWhere('content', 'like', '%' . $q . '%');
      })

     
      ->orWhere('name', 'LIKE', '%' . $q . '%')->orderBy('created_at', 'asc')->distinct()->get();
    // $merged;
    // $tok = strtok($q, " ");
    // while ($tok !== false) {
    //   $documents_tok = Document::whereHas('tags', function($query) use($tok) {
    //     $query->where('name', 'like', '%'.$tok.'%');
    //   })
    //   ->orWhereHas('reviews', function($query) use($tok) {
    //     $query->where('comment', 'like', '%'.$tok.'%');
    //   })
    //   ->orWhereHas('folder', function($query) use($tok) {
    //     $query->where('nm', 'like', '%'.$tok.'%');
    //   })
    //   ->orWhere('filename','LIKE','%'.$tok.'%')->orWhere('comment','LIKE','%'.$tok.'%')
    //   ->orWhere('description','LIKE','%'.$tok.'%')->orderBy('created_at', 'asc')->distinct()->get();
    //
    //     $tok = strtok(" ");
    //     $merged = $documents->merge($documents_tok);
    // }
    //
    //
    // // return $documents;
    // //$merged = $document->merge($document);
    // $result = $merged->all();
    return  view('documents.result', ['documents' => $documents,'contracts'=>$contracts]);
  }
  public function showReview($document_id)
  {
    $document = Document::find($document_id);
    return view('documents.review', ['document' => $document]);
  }
  public function storeReview(Request $request, $review_id)
  {
    $review = Review::find($review_id);
    $review->comment = $request->comment;
    if ($request->action == "approve") {
      $review->status = 1;
      $review->save();
      $logmsg = $review->document->filename . ' was approved in the ' . $review->stage->name . ' in the ' . $review->stage->workflow->name;
      $this->saveLog('info', 'App\Review', $review->id, 'reviews', $logmsg, Auth::user()->id);
    } elseif ($request->action == "reject") {
      $review->status = 2;
      $review->save();
      $logmsg = $review->document->filename . ' was rejected in the ' . $review->stage->name . ' in the ' . $review->stage->workflow->name;
      $this->saveLog('info', 'App\Review', $review->id, 'reviews', $logmsg, Auth::user()->id);
      $review->document->user->notify(new DocumentRejected($document, $review->stage));
      return redirect()->route('documents.mypendingreviews')->with(['success' => 'Document Reviewed Successfully']);
    }

    //create new review if another stage exist
    $newposition = $review->stage->position + 1;
    $nextstage = Stage::where(['workflow_id' => $review->stage->workflow->id, 'position' => $newposition])->first();
    // return $review->stage->position+1;
    // return $nextstage;
    if ($nextstage) {
      $newreview = new Review();
      $newreview->stage_id = $nextstage->id;
      $newreview->document_id = $review->document->id;
      $newreview->status = 0;
      $newreview->save();
      $logmsg = 'New review process started for ' . $newreview->document->filename . ' in the ' . $newreview->stage->workflow->name;
      $this->saveLog('info', 'App\Review', $review->id, 'reviews', $logmsg, Auth::user()->id);
      $newreview->stage->user->notify(new ReviewDocument($review->document));
      $review->document->user->notify(new DocumentPassedStage($review, $review->stage, $newreview->stage));
    } else {
      $review->document->status = 1;
      $review->document->save();
      $review->stage->user->notify(new DocumentApproved($review->stage, $review));
    }


    return redirect()->route('documents.mypendingreviews')->with(['success' => 'Document Reviewed Successfully']);
  }
  public function myPendingReviews()
  {
    $reviews = Auth::user()->docReviews()->where('status', 0)->paginate(10);
    //return $reviews;
    return view('documents.reviews', ['reviews' => $reviews]);
  }
  public function reviews()
  {
    $reviews = Review::where('status', 0)->paginate(10);
    // return $reviews;
    return view('documents.reviews', ['reviews' => $reviews]);
  }
  public function downloadFile(Request $request)
  {

    $document = Document::where('id', $request->button)->first();
    return response()->download('storage/' . $document->path);
  }
  public function viewFile(Request $request)
  {
    //return $request->button;
    $document = Document::where('id', $request->button)->first();
    // return $document;
    return response()->file('storage/' . $document->path);
  }
}
