<?php

namespace App\Http\Controllers;

use App\Models\AddonItems;
use App\Models\AddonCategories;
use App\Models\AddonCategoryItems;
use Illuminate\Http\Request;
use DB;
class AddonitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($request->search) && !empty($request->addon_categories_id)){
             $data =  AddonItems::sortable()->select('addon_items.*',DB::raw('group_concat(addon_categories.name) as addon_category'))
                                            ->join('addon_category_items', 'addon_category_items.addon_item_id', '=', 'addon_items.id')
                                            ->join('addon_categories', 'addon_categories.id', '=', 'addon_category_items.addon_category_id')
                                            ->where('addon_category_items.addon_category_id', '=', $request->addon_categories_id)
                                            ->where('addon_items.name', 'LIKE', '%'.$request->search.'%')
                                            ->groupBy('addon_items.id')
                                            ->paginate(8);
        }else if(!empty($request->search)){
              $data =  AddonItems::sortable()->select('addon_items.*',DB::raw('group_concat(addon_categories.name) as addon_category'))
                                            ->join('addon_category_items', 'addon_category_items.addon_item_id', '=', 'addon_items.id')
                                            ->join('addon_categories', 'addon_categories.id', '=', 'addon_category_items.addon_category_id')
                                            ->where('addon_items.name', 'LIKE', '%'.$request->search.'%')
                                            ->groupBy('addon_items.id')
                                            ->paginate(8);
        }else if(!empty($request->addon_categories_id)){
             $data =  AddonItems::sortable()->select('addon_items.*',DB::raw('group_concat(addon_categories.name) as addon_category'))
                                            ->join('addon_category_items', 'addon_category_items.addon_item_id', '=', 'addon_items.id')
                                            ->join('addon_categories', 'addon_categories.id', '=', 'addon_category_items.addon_category_id')
                                            ->where('addon_category_items.addon_category_id', '=', $request->addon_categories_id)
                                            ->groupBy('addon_items.id')
                                            ->paginate(8);
        }else{
             $data =  AddonItems::sortable()->select('addon_items.*',DB::raw('group_concat(addon_categories.name) as addon_category'))
                                            ->join('addon_category_items', 'addon_category_items.addon_item_id', '=', 'addon_items.id')
                                            ->join('addon_categories', 'addon_categories.id', '=', 'addon_category_items.addon_category_id')
                                            ->groupBy('addon_items.id')
                                            ->paginate(8);
        }

        $addon_cat = AddonCategories::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();
        return view('addonitem.list',compact('data','addon_cat','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $addon_cat =  AddonCategories::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();
        return view('addonitem.create',compact('addon_cat','request'));
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
            'addoncategory' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'sort_order' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4048',
        ]);
        if(!empty($request->image)){
            $imageName = time().'.'.$request->file('image')->extension();  
            $request->file('image')->storeAs('public/images', $imageName);
        }
        $addon = new AddonItems;
        $addon->name = $request->name;
        $addon->description = $request->description;
        $addon->price = $request->price;
        $addon->image =  $imageName ?? NULL;
        $addon->sort_order = $request->sort_order;
        $addon->active = $request->active;
        if($addon->save()){
            $addon_item_id = $addon->id;
            $addon_categories = $request->addoncategory;
            foreach( $addon_categories as $ac){
                $data[] = ['addon_category_id' =>  $ac, 'addon_item_id' => $addon_item_id ,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
            }
            AddonCategoryItems::insert($data);
            return back()->with('success', 'Addon Item created successfully.');
        }else{
            return back()->with('error', 'Something went wrong!'); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AddonItems  $addonItems
     * @return \Illuminate\Http\Response
     */
    public function show(AddonItems $addonItems)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AddonItems  $addonItems
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $addon_item = AddonItems::find($id);
        $item_categories = AddonCategoryItems::Where('addon_item_id', $addon_item->id)->pluck('addon_category_id')->toArray();
        $addon_categories = AddonCategories::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();

        return view('addonitem.edit', compact('addon_item','item_categories','addon_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AddonItems  $addonItems
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'addoncategory' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
            'sort_order' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4048',
        ]);
        if(!empty($request->image)){
            $imageName = time().'.'.$request->file('image')->extension();  
            $request->file('image')->storeAs('public/images', $imageName);
        }
        $addon = AddonItems::find($id);
        $addon->name = $request->name;
        $addon->description = $request->description;
        $addon->price = $request->price;
        if(!empty($request->image))
             $addon->image =  $imageName;
        $addon->sort_order = $request->sort_order;
        $addon->active = $request->active;
        if($addon->save()){
            $new_categories = $request->addoncategory;
            $old_categories = AddonCategoryItems::Where('addon_item_id', $id)->pluck('addon_category_id')->toArray();

            $insert = Array();
            $delete = Array();
            foreach($new_categories as $item){
                if(!in_array($item,$old_categories))
                     $insert[] = $item;
            }
            foreach($old_categories as $item){
                if(!in_array($item,$new_categories))
                    $delete[] = $item;
            }
            if(!empty($insert)){
                 foreach( $insert as $ac){
                         $data[] = ['addon_category_id' =>  $ac, 'addon_item_id' => $id ,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
                 }
                 AddonCategoryItems::insert($data);
            }
            if(!empty($delete)){
                 AddonCategoryItems::where('addon_item_id',$id)->whereIn('addon_category_id',$delete)->delete();
            }
           
            return redirect('/addonitem')->with('success', 'Addon Item Updated successfully.');
        }else{
            return redirect('/addonitem')->with('error', 'Something went wrong!');  
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AddonItems  $addonItems
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AddonItems::where('id',$id)->delete();
        return redirect()->back()->with('success','Addon Item Deleted Successfully!');
    }
}
