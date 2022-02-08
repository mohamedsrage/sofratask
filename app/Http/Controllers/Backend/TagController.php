<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\TagRequest;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagController extends Controller
{
   
    public function index()
    {

        // if (!auth()->user()->ability('admin', 'manage_tags, show_tags')) {
        //     return redirect('admin/index');
        // }   

 
        
        $tags = Tag::with('products')
        ->when(\request()->keyword != null, function ($query){
            // $query->where('name', 'like', '%'. \request()->keyword . '%');
            $query->search(\request()->keyword);
        })
        
        ->when(\request()->status != null,  function ($query) { 
            $query->whereStatus(\request()->status);

        })
        ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
        
        ->paginate(\request()->limit_by ?? 10);

        return view('backend.tags.index', compact('tags'));
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
        return view('backend.tags.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {

        // if (!auth()->user()->ability('admin', 'create_tags')) {
        //     return redirect('admin/index');
        // }
    //    $input['name'] = $request->name;
    //    $input['status'] = $request->status;
    

        Tag::create($request->validated());
        return redirect()->route('admin.tags.index')->with([
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
    public function show($id)
    {

        // if (!auth()->user()->ability('admin', 'manag_tags', 'display_tags')) {
        //     return redirect('admin/index');
        // }
        return view('backend.tags.show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        // if (!auth()->user()->ability('admin', 'update_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }

        return view('backend.tags.edit', compact('tag'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        // if (!auth()->user()->ability('admin', 'update_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }

        $input['name'] = $request->name;
        $input['slug'] = null;
        $input['status'] = $request->status;

        $tag->update($input);
        return redirect()->route('admin.tags.index')->with([
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
    public function destroy(Tag $tag)
    {

        // if (!auth()->user()->ability('admin', 'delete_tags', 'show_tags')) {
        //     return redirect('admin/index');
        // }

        $tag->delete();
        return redirect()->route('admin.tags.index')->with([
            'message' => 'Delete successfully',
            'alert-type' => 'success',
        ]);
    }
}
