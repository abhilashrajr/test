<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\MenuTypes;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    { 
        if(!empty($request->search) && !empty($request->menu_type)){
            $data = Category::sortable()->where('name', 'LIKE', '%'.$request->search.'%')->where('menu_type_id', '=', $request->menu_type)->paginate(8);
        }else if(!empty($request->search)){
            $data = Category::sortable()->where('name', 'LIKE', '%'.$request->search.'%')->paginate(8);
        }else if(!empty($request->menu_type)){
             $data = Category::sortable()->where('menu_type_id', '=', $request->menu_type)->paginate(8);
        }else{
             $data = Category::sortable()->paginate(8);
        }
       


        $menu_types = MenuTypes::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();
        return view('category.list',compact('data','menu_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menu_types = MenuTypes::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();
        return view('category.create',compact('menu_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'sort_order' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4048',
        ]);
        if(!empty($request->image)){
            $imageName = time().'.'.$request->file('image')->extension();  
            $request->file('image')->storeAs('public/images', $imageName);
        }
        $category = new Category;
 
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image =  $imageName ?? NULL;
        $category->menu_type_id = $request->menu;
        $category->sort_order = $request->sort_order;
        $category->active = $request->active;
        if($category->save()){
            return back()->with('success', 'Category created successfully.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
      
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $menu_types = MenuTypes::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();
        return view('category.edit', compact('category','menu_types'));
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
        $request->validate([
            'name' => 'required',
            'sort_order' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
        ]);
        if(!empty($request->image)){
            $imageName = time().'.'.$request->file('image')->extension();  
            $request->file('image')->storeAs('public/images', $imageName);
        }
        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;
        if(!empty($imageName))
            $category->image =  $imageName;
        $category->menu_type_id = $request->menu;
        $category->sort_order = $request->sort_order;
        $category->active = $request->active;
        if($category->save()){
            return redirect('/category')->with('success', 'Category updated successfully.');
        }else{
            return redirect('/category')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::where('id',$id)->delete();
        return redirect()->back()->with('success','Category Deleted Successfully!');
    }
}