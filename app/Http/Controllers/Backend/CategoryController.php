<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // if (!auth()->user()->ability('admin', 'manage_categories, show_categories')) {
        //     return redirect('admin/index');
        // }   

 
        
        $categories = Category::withCount('products')
        ->when(\request()->keyword != null, function ($query){
            // $query->where('name', 'like', '%'. \request()->keyword . '%');
            $query->search(\request()->keyword);
        })
        ->when(\request()->status != null,  function ($query) { 
            $query->whereStatus(\request()->status);

        })
        ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
        
        ->paginate(\request()->limit_by ?? 10);
        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // if (!auth()->user()->ability('admin', 'create_categories')) {
        //     return redirect('admin/index');
        // }
        $main_categories = Category::whereNull('parent_id')->get(['id', 'name']);
        return view('backend.categories.create', compact('main_categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(CategoryRequest $request)
    public function store(Request $request)
    {

        // if (!auth()->user()->ability('admin', 'create_categories')) {
        //     return redirect('admin/index');
        // }
        $input['name']      = $request->name;
        $input['status']    = $request->status;
        $input['parent_id'] = $request->parent_id;
        $input['cover']     = upload_image($request->file('cover'), 'public/assets/categories');

        // if ($image = $request->file('cover')) {
        //     $file_name = Str::slug($request->name). ".". $image->getClientOriginalExtension();
        //     $path = public_path('/assets/categories/' . $file_name);
        //     Image::make($image->getRealPath())->resize(500, null, function ($constraint){
        //         $constraint->aspectRatio();
        //     })->save($path, 100);
        //     $input['cover'] = $file_name;
        // }

        Category::create($input);
        return redirect()->route('admin.categories.index')->with([
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

        // if (!auth()->user()->ability('admin', 'manag_categories', 'display_categories')) {
        //     return redirect('admin/index');
        // }
        return view('backend.categories.show');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        // if (!auth()->user()->ability('admin', 'update_categories', 'show_categories')) {
        //     return redirect('admin/index');
        // }
        $main_categories = Category::whereNull('parent_id')->get(['id', 'name']);

        return view('backend.categories.edit', compact('main_categories', 'category'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // if (!auth()->user()->ability('admin', 'update_categories', 'show_categories')) {
        //     return redirect('admin/index');
        // }

        $input['name']      = $request->name;
        $input['slug']      = null;
        $input['status']    = $request->status;
        $input['parent_id'] = $request->parent_id;
        if($request->has('cover')){
            if ($category->cover != null && File::exists('assets/product_categories/'. $category->cover)){
                unlink('assets/product_categories/'. $category->cover);
            }  
            $input['cover']     = upload_image($request->file('cover'), 'public/assets/categories');
        }

     
        // if ($image = $request->file('cover')) {
        //     if ($category->cover != null && File::exists('assets/product_categories/'. $category->cover)){
        //         unlink('assets/product_categories/'. $category->cover);
        //     }     
                  
        //     $file_name = Str::slug($request->name). ".". $image->getClientOriginalExtension();
        //     $path = public_path('/assets/categories/' . $file_name);
        //     Image::make($image->getRealPath())->resize(500, null, function ($constraint){
        //         $constraint->aspectRatio();
        //     })->save($path, 100);
        //     $input['cover'] = $file_name;
        // }
        $category->update($input);
        return redirect()->route('admin.categories.index')->with([
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
    public function destroy(Category $category)
    {

        // if (!auth()->user()->ability('admin', 'delete_categories', 'show_categories')) {
        //     return redirect('admin/index');
        // }

        if(File::exists('assets/categories/'. $category->cover)) {
            unlink('assets/categories/'. $category->cover);


        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with([
            'message' => 'Delete successfully',
            'alert-type' => 'success',
        ]);
    }

    public function remove_image(Request $request)
    {

        
        // if (!auth()->user()->ability('admin', 'delete_categories', 'show_categories')) {
        //     return redirect('admin/index');
        // }

        $category = Category::findOrfail($request->category_id);
        if(File::exists('assets/categories/'. $category->cover)) {
            unlink('assets/categories/'. $category->cover);
            $category->cover = null;
            $category->save();
        }
        return true;
    }
}
