<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {

        // if (!auth()->user()->ability('admin', 'manage_tags, show_tags')) {
        //     return redirect('admin/index');
        // }   

 
        
        $countries = Country::with('states')
        ->when(\request()->keyword != null, function ($query){
            // $query->where('name', 'like', '%'. \request()->keyword . '%');
            $query->search(\request()->keyword);
        })
        
        ->when(\request()->status != null,  function ($query) { 
            $query->whereStatus(\request()->status);

        })
        ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
        
        ->paginate(\request()->limit_by ?? 10);

        return view('backend.countries.index', compact('countries'));
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
        return view('backend.countries.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {

        // if (!auth()->user()->ability('admin', 'create_tags')) {
        //     return redirect('admin/index');
        // }
       // $input['name'] = $request->name;
       // $input['status'] = $request->status;
    

        Country::create($request->validated());
        return redirect()->route('admin.countries.index')->with([
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
    public function show(Country $country)
    {

        // if (!auth()->user()->ability('admin', 'manag_tags', 'display_tags')) {
        //     return redirect('admin/index');
        // }
        return view('backend.countries.show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        // if (!auth()->user()->ability('admin', 'update_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }

        return view('backend.countries.edit', compact('country'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, Country $country)
    {
        // if (!auth()->user()->ability('admin', 'update_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }

        
        $country->update($request->validated());

        return redirect()->route('admin.countries.index')->with([
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
    public function destroy(Country $country)
    {

        // if (!auth()->user()->ability('admin', 'delete_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }

        $country->delete();
        return redirect()->route('admin.countries.index')->with([
            'message' => 'Delete successfully',
            'alert-type' => 'success',
        ]);
    }
}
