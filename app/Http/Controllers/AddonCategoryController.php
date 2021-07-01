<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddonCategories;

class AddonCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($request->search)){
             $data = AddonCategories::sortable()->where('name', 'LIKE', '%'.$request->search.'%')->paginate(8);
        }else{
             $data = AddonCategories::sortable()->paginate(8);
        }
       
        return view('addoncategory.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('addoncategory.create');
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
        $category = new AddonCategories;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image =  $imageName ?? NULL;
        $category->sort_order = $request->sort_order;
        $category->active = $request->active;
        if($category->save())
             return back()->with('success', 'Addon category created successfully.');
        else
             return back()->with('error', 'Something went wrong!');     
       
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
        $category = AddonCategories::find($id);
        return view('addoncategory.edit', compact('category'));
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
        $category = AddonCategories::find($id);
        $category->name = $request->name;
        $category->description = $request->description;
        if(!empty($imageName))
            $category->image =  $imageName;
        $category->sort_order = $request->sort_order;
        $category->active = $request->active;
        if($category->save())
            return redirect('/addoncategory')->with('success', 'Addon category Updated successfully.');
        else
            return redirect('/addoncategory')->with('error', 'Something went wrong!');  
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AddonCategories::where('id',$id)->delete();
        return redirect()->back()->with('success','Addon category Deleted Successfully!');
    }
}
