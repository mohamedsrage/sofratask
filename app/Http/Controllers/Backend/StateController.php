<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StateRequest;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {

        // if (!auth()->user()->ability('admin', 'manage_tags, show_tags')) {
        //     return redirect('admin/index');
        // }   

 
        
        $states = State::with('cities')
        ->when(\request()->keyword != null, function ($query){
            // $query->where('name', 'like', '%'. \request()->keyword . '%');
            $query->search(\request()->keyword);
        })
        
        ->when(\request()->status != null,  function ($query) { 
            $query->whereStatus(\request()->status);

        })
        ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
        
        ->paginate(\request()->limit_by ?? 10);

        return view('backend.states.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // if (!auth()->user()->ability('admin', 'create_tags')) {
        //     return redirect('admin/index');
        // }

        // $countries = Country::all();
        $countries = Country::get(['id', 'name']);
        return view('backend.states.create', compact('countries'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateRequest $request)
    {

        // if (!auth()->user()->ability('admin', 'create_tags')) {
        //     return redirect('admin/index');
        // }
       // $input['name'] = $request->name;
       // $input['status'] = $request->status;
    

        State::create($request->validated());
        return redirect()->route('admin.states.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success',
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {

        // if (!auth()->user()->ability('admin', 'manag_tags', 'display_tags')) {
        //     return redirect('admin/index');
        // }
        return view('backend.states.show', compact('state'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        // if (!auth()->user()->ability('admin', 'update_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }

        $countries = Country::get('id', 'name');

        return view('backend.states.edit', compact('countries', 'state'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StateRequest $request, State $state)
    {
        // if (!auth()->user()->ability('admin', 'update_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }

        $state->update($request->validated());

        return redirect()->route('admin.states.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function destroy(State $state)
    {

        // if (!auth()->user()->ability('admin', 'delete_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }

        $state->delete();
        return redirect()->route('admin.states.index')->with([
            'message' => 'Delete successfully',
            'alert-type' => 'success',
        ]);
    }
    
    public function get_states(Request $request)
    {
        return [];
        $states = State::whereCountryId($request->country_id)->get(['id', 'name'])->toArray();
        return response()->json($states);
    }
    
    public function show_states(Request $request)
    {
        $data = State::whereCountryId($request->country_id)->get();
        return view('ajax.show_states', compact('data'));
    }

}
