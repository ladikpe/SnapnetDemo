<?php

namespace App\Http\Controllers;

use App\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auditLogs=AuditLog::paginate(10);

        return view('auditlogs',['auditlogs'=>$auditLogs]);
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
     * @param  \App\AuditLog  $auditLog
     * @return \Illuminate\Http\Response
     */
    public function show(AuditLog $auditLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AuditLog  $auditLog
     * @return \Illuminate\Http\Response
     */
    public function edit(AuditLog $auditLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AuditLog  $auditLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuditLog $auditLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AuditLog  $auditLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuditLog $auditLog)
    {
        //
    }
}
