<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\studio;
use App\state;
use App\country;
use Illuminate\Http\Request;
use Session;

class studiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $studios = studio::paginate(25);

        return view('admin.studios.index', compact('studios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $states = state::pluck('name','id');
        $countries = country::pluck('name','id');
        
        $parameters=array_merge(['states'=>$states,'countries'=>$countries]);
        return view('admin.studios.create',$parameters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        studio::create($requestData);

        Session::flash('flash_message', 'studio added!');

        return redirect('admin/studios');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $studio = studio::findOrFail($id);

        return view('admin.studios.show', compact('studio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $studio = studio::findOrFail($id);
        $states = state::pluck('name','id');
        $countries = country::pluck('name','id');
        
        $parameters=array_merge(compact('studio'),['states'=>$states,'countries'=>$countries]);
        
        return view('admin.studios.edit',$parameters);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $requestData = $request->all();
        file_put_contents('/tmp/request_update',print_r($requestData,true));
        file_put_contents('/tmp/request_id',$id);
        $studio = studio::findOrFail($id);
        $studio->update($requestData);

        Session::flash('flash_message', 'studio updated!');

        return redirect('admin/studios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        studio::destroy($id);

        Session::flash('flash_message', 'studio deleted!');

        return redirect('admin/studios');
    }
}
