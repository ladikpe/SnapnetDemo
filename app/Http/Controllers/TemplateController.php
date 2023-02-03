<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Actions\TemplateAction;

use App\Actions\MsWordAction;

use App\Template;


class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TemplateAction $templateAction, Template $template)
    {
        //
        $response = $templateAction->index($template);
        return view('template.index',$response);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(TemplateAction $templateAction, Template $template)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,TemplateAction $templateAction,Template $template)
    {
        //
        $response = $templateAction->store($template,$request);

        return redirect(route('template.index'))->with($response);
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
    public function update(Request $request,Template $template,TemplateAction $templateAction)
    {
        //
        $response = $templateAction->update($template,$request);

        return redirect(route('template.index'))->with($response);

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


    function downloadAsWord(MsWordAction $msWordAction,Template $template){
      $msWordAction->downloadWordFromText($template->cover_page . $template->content,$template->name . '_' . date('Y_m_d'));
    } 

}
