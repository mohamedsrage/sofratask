<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ShippingCompanyRequest;
use App\Models\Country;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;

class ShippingCompanyController extends Controller
{
    public function index()
    {

        // if (!auth()->user()->ability('admin', 'manage_tags, show_tags')) {
        //     return redirect('admin/index');
        // }   

 
        
        $shipping_companies = ShippingCompany::withCount('countries')
        ->when(\request()->keyword != null, function ($query){
            // $query->where('name', 'like', '%'. \request()->keyword . '%');
            $query->search(\request()->keyword);
        })
        
        ->when(\request()->status != null,  function ($query) { 
            $query->whereStatus(\request()->status);

        })
        ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
        
        ->paginate(\request()->limit_by ?? 10);

        return view('backend.shipping_companies.index', compact('shipping_companies'));
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
        $countries = Country::orderBy('id', 'asc')->get('id', 'name');
        return view('backend.shipping_companies.create', compact('countries'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShippingCompanyRequest $request)
    {

        // if (!auth()->user()->ability('admin', 'create_tags')) {
        //     return redirect('admin/index');
        // }
       // $input['name'] = $request->name;
       // $input['status']  = $request->status;
    
    //   if($request->validated()) {
    //       dd($request->except('countries', '_token', 'submit'), $request->only('countries'));
    //   } else {
    //       dd('ok');
    //   }
      if($request->validated()) {



          $shipping_companies = ShippingCompany::create($request->except('countries', '_token', 'submit'));
        //   $shipping_companies->countries()->attach($request->only('countries'));
          $shipping_companies->countries()->attach(array_values($request->countries));


    //   $shipping_companies = ShippingCompany::create($request->validated());
    //   $shipping_companies->countries()->attach($request->countries);

        return redirect()->route('admin.shipping_companies.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success',
        ]);

    } else {
        return redirect()->route('admin.shipping_companies.index')->with([
            'message' => 'Something wrong',
            'alert-type' => 'danger',
        ]);
    }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingCompany $shipping_companies)
    {

        // if (!auth()->user()->ability('admin', 'manag_tags', 'display_tags')) {
        //     return redirect('admin/index');
        // }
        return view('backend.shipping_companies.show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingCompany $shipping_companies)
    {
        // if (!auth()->user()->ability('admin', 'update_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }

        $shipping_companies->with('countries');
        $countries = Country::get(['id','name']);
        return view('backend.shipping_companies.edit', compact('shipping_companies', 'countries'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShippingCompanyRequest $request, ShippingCompany $shipping_companies)
    {
        // if (!auth()->user()->ability('admin', 'update_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }


        if($request->validated()) {


            $shipping_companies->update($request->except('countries', '_token', 'submit'));



          //   $shipping_companies->countries()->attach($request->only('countries'));
            $shipping_companies->countries()->sync(array_values($request->countries));
  
  
      //   $shipping_companies = ShippingCompany::create($request->validated());
      //   $shipping_companies->countries()->attach($request->countries);
  
          return redirect()->route('admin.shipping_companies.index')->with([
              'message' => 'Updated successfully',
              'alert-type' => 'success',
          ]);
  
      } else {
          return redirect()->route('admin.shipping_companies.index')->with([
              'message' => 'Something wrong',
              'alert-type' => 'danger',
          ]);
      }

 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function destroy(ShippingCompany $shipping_companies)
    {

        // if (!auth()->user()->ability('admin', 'delete_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }

        $shipping_companies->delete();
        return redirect()->route('admin.shipping_companies.index')->with([
            'message' => 'Delete successfully',
            'alert-type' => 'success',
        ]);
    }
}
