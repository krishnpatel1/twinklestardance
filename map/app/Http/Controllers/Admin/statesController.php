<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\state;
use App\country;
use Illuminate\Http\Request;
use Session;

class statesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $states = state::paginate(25);

        return view('admin.states.index', compact('states'));
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
        return view('admin.states.create',$parameters);
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
        
        state::create($requestData);

        Session::flash('flash_message', 'state added!');

        return redirect('admin/states');
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
        $state = state::findOrFail($id);

        return view('admin.states.show', compact('state'));
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
        $state = state::findOrFail($id);

        $states = state::pluck('name','id');
        $countries = country::pluck('name','id');
        
        $parameters=array_merge(compact('state'),['states'=>$states,'countries'=>$countries]);
        return view('admin.states.edit', $parameters);
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
        
        $state = state::findOrFail($id);
        $state->update($requestData);

        Session::flash('flash_message', 'state updated!');

        return redirect('admin/states');
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
        state::destroy($id);

        Session::flash('flash_message', 'state deleted!');

        return redirect('admin/states');
    }
}
