<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuTypes;
use App\Models\Category;
use App\Models\AddonCategories;
use App\Models\Sizes;
use App\Models\MenuAddonitems;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

       
        $query = Menu::with('category')->sortable();
        if(!empty($request->search))
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        if(!empty($request->menu_type))
            $query->where('menu_type_id', '=', $request->menu_type);
        if(!empty($request->category))
            $query->where('category_id', '=', $request->category);
         
        $data = $query->paginate(8);
       $menu_types = MenuTypes::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();
       $categories = Category::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();
       return view('menu.list',compact('data','menu_types','categories','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $menu_types = MenuTypes::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();
        if(empty($request->menu_type))
            $first_type  = $menu_types->first()->id;
        else
            $first_type  = $request->menu_type;
        $category =  Category::select('id','name')->Where('menu_type_id', $first_type)->Where('active', '1')->orderBy('sort_order', 'asc')->get();
        $sizes = Sizes::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();
       
    
        $addon =  AddonCategories::sortable()->select('addon_categories.id','addon_categories.name as category','addon_items.id as item_id','addon_items.name as item','addon_items.price')  
                                             ->join('addon_category_items', 'addon_category_items.addon_category_id', '=', 'addon_categories.id')                              
                                             ->join('addon_items', 'addon_category_items.addon_item_id', '=', 'addon_items.id')
                                             ->Where('addon_categories.active', '1')
                                             ->Where('addon_items.active', '1')
                                             ->orderBy('addon_categories.id', 'asc')
                                             ->get()->toArray();
        $data = Array();
        foreach($addon as $cat){
               $data[$cat['id']]['category'] = $cat['category'];
               $data[$cat['id']]['items'][] = ['item_id'=>$cat['item_id'],'name'=>$cat['item'],'price'=>$cat['price']];
        }                    
        return view('menu.create',compact('menu_types','category','data','sizes','request'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->addon);
        $request->validate([
            'name' => 'required',
            'menu_type' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'sort_order' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4048',
        ]);
        if(!empty($request->image)){
            $imageName = time().'.'.$request->file('image')->extension();  
            $request->file('image')->storeAs('public/images', $imageName);
        }
        $menu = new Menu;
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->menu_type_id = $request->menu_type;
        $menu->category_id = $request->category;
        $menu->size_id = $request->size;
        $menu->image =  $imageName ?? NULL;
        $menu->veg = $request->veg ?? 0;
        $menu->best_seller = $request->best_seller ?? 0;
        $menu->sort_order = $request->sort_order;
        $menu->active = $request->active;
        if($menu->save()){
            if(!empty($request->addon)){
                    $data = [];
                    /*
                    foreach( $request->addon as  $addons){                   
                        if(!empty($addons['items'])){
                            foreach( $addons['items'] as  $aditem){
                                    $data[] = ['menu_id'=>$menu->id,'addon_category_id' => $addons['acat_id'], 'addon_item_id' => $aditem , 'required' =>$addons['required'] ?? 0 , 'multiple' =>  $addons['multiple'] ?? 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
                            }
                        }                                                  
                    }                 
                    MenuAddonitems::insert($data);
                    */
                    //dd($request->addon);
                    if(!empty($request->addon_cat_order)){
                        $addons =  $request->addon;
                        $addon_category_ids = json_decode($request->addon_cat_order);
                        foreach( $addon_category_ids as  $aCatId){
                                foreach( $addons[$aCatId]['items'] as  $aditem){
                                    if(!empty($aditem['id'])){  
                                        $data[] = ['menu_id'=>$menu->id,'addon_category_id' => $addons[$aCatId]['acat_id'], 'addon_item_id' => $aditem['id'] , 'min' => $aditem['min'] , 'max' => $aditem['max'] , 'required' =>$addons[$aCatId]['required'] ?? 0 , 'multiple' =>  $addons[$aCatId]['multiple'] ?? 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
                                    }
                                } 
                        }
                    }else{
                        foreach( $request->addon as  $addons){                   
                            foreach( $addons['items'] as  $aditem){    
                                if(!empty($aditem['id'])){                             
                                    $data[] = ['menu_id'=>$menu->id,'addon_category_id' => $addons['acat_id'], 'addon_item_id' => $aditem['id'] , 'min' => $aditem['min'] , 'max' => $aditem['max'] , 'required' =>$addons['required'] ?? 0 , 'multiple' =>  $addons['multiple'] ?? 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];                          
                                }
                            }                                                   
                        } 
                    }
                    MenuAddonitems::insert($data);

            }
            return back()->with('success', 'Menu created successfully.');
        }else{
            return back()->with('error', 'Something went wrong!');    
        }
              

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::find($id);
        $addon =  AddonCategories::sortable()->select('addon_categories.id','addon_categories.name as category','addon_items.id as item_id','addon_items.name as item','addon_items.price')  
                                            ->join('menu_addonitems', 'menu_addonitems.addon_category_id', '=', 'addon_categories.id')                                    
        //->join('addon_category_items', 'addon_category_items.addon_category_id', '=', 'addon_categories.id')                              
                                            ->join('addon_items', 'menu_addonitems.addon_item_id', '=', 'addon_items.id')
                                            ->Where('menu_addonitems.menu_id', $id)
                                            ->Where('addon_categories.active', '1')
                                            ->Where('addon_items.active', '1')
                                            ->orderBy('addon_categories.id', 'asc')
                                            ->get()->toArray();
        $madata = Array();
        foreach($addon as $cat){
            $madata[$cat['id']]['category'] = $cat['category'];
            $madata[$cat['id']]['items'][$cat['item_id']] = ['item_id'=>$cat['item_id'],'name'=>$cat['item'],'price'=>$cat['price']];
        } 
        //dd($madata);


        /*
        $menu_addons = MenuAddonitems::Where('menu_id', $id)->get()->toArray();   
        $madata = Array();
        foreach($menu_addons as $cat){
               $madata[$cat['addon_category_id']]['required'] = $cat['required'];
               $madata[$cat['addon_category_id']]['multiple'] = $cat['multiple'];
               $madata[$cat['addon_category_id']]['items'][$cat['addon_item_id']] = ['item_id'=>$cat['addon_item_id']];
        }   
        */ 
        return view('menu.view',compact('menu','madata'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::find($id);
        $menu_types = MenuTypes::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();
        $category =  Category::select('id','name')->Where('menu_type_id', $menu->menu_type_id)->Where('active', '1')->orderBy('sort_order', 'asc')->get();
        $sizes = Sizes::select('id','name')->Where('active', '1')->orderBy('sort_order', 'asc')->get();
       
    
        $addon =  AddonCategories::sortable()->select('addon_categories.id','addon_categories.name as category','addon_items.id as item_id','addon_items.name as item','addon_items.price')  
                                             ->join('addon_category_items', 'addon_category_items.addon_category_id', '=', 'addon_categories.id')                              
                                             ->join('addon_items', 'addon_category_items.addon_item_id', '=', 'addon_items.id')
                                            // ->Where('addon_categories.active', '1')
                                           //  ->Where('addon_items.active', '1')
                                             ->orderBy('addon_categories.id', 'asc')
                                             ->get()->toArray();
        $data = Array();
        foreach($addon as $cat){
               $data[$cat['id']]['category'] = $cat['category'];
               $data[$cat['id']]['items'][$cat['item_id']] = ['item_id'=>$cat['item_id'],'name'=>$cat['item'],'price'=>$cat['price']];
        }  
        $menu_addons = MenuAddonitems::Where('menu_id', $id)->orderBy('id', 'asc')->get()->toArray();   
        $madata = Array();
        foreach($menu_addons as $cat){
               $madata[$cat['addon_category_id']]['required'] = $cat['required'];
               $madata[$cat['addon_category_id']]['multiple'] = $cat['multiple'];
               $madata[$cat['addon_category_id']]['items'][$cat['addon_item_id']] = ['item_id'=>$cat['addon_item_id'],'min'=>$cat['min'],'max'=>$cat['max']];
               
        }    
        //dd($madata);    
        return view('menu.edit',compact('menu','menu_types','category','data','sizes','madata'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //dd($request->addon_cat_order);
        $request->validate([
            'name' => 'required',
            'menu_type' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'sort_order' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4048',
        ]);
        if(!empty($request->image)){
            $imageName = time().'.'.$request->file('image')->extension();  
            $request->file('image')->storeAs('public/images', $imageName);
        }
        $menu =  Menu::find($id);
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->menu_type_id = $request->menu_type;
        $menu->category_id = $request->category;
        $menu->size_id = $request->size;
        if(!empty($request->image))
             $menu->image =  $imageName;
        $menu->veg = $request->veg ?? 0;
        $menu->best_seller = $request->best_seller ?? 0;
        $menu->sort_order = $request->sort_order;
        $menu->active = $request->active;
        if($menu->save()){
            $new_addons = $request->addon;
            $old_addons =MenuAddonitems::Where('menu_id', $id)->get()->toArray();   
            $insert = Array();
            $delete = Array();   
            
            if(!empty($request->addon)){
                $data = [];
              
                if(!empty($request->addon_cat_order)){
                    $addons =  $request->addon;
                    $addon_category_ids = json_decode($request->addon_cat_order);
                    foreach( $addon_category_ids as  $aCatId){
                        foreach( $addons[$aCatId]['items'] as  $aditem){
                                if(!empty($aditem['id'])){  
                                    $data[] = ['menu_id'=>$menu->id,'addon_category_id' => $addons[$aCatId]['acat_id'], 'addon_item_id' => $aditem['id'] , 'min' => $aditem['min'] , 'max' => $aditem['max'] , 'required' =>$addons[$aCatId]['required'] ?? 0 , 'multiple' =>  $addons[$aCatId]['multiple'] ?? 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
                                }
                         }
                        
                    }
                }else{
                    foreach( $request->addon as  $addons){                   
                      
                            foreach( $addons['items'] as  $aditem){
                                if(!empty($aditem['id'])){  
                                    $data[] = ['menu_id'=>$menu->id,'addon_category_id' => $addons['acat_id'], 'addon_item_id' => $aditem['id'] , 'min' => $aditem['min'] , 'max' => $aditem['max'] , 'required' =>$addons['required'] ?? 0 , 'multiple' =>  $addons['multiple'] ?? 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
                                }
                            }
                                                                        
                    } 
                }
               
                MenuAddonitems::where('menu_id',$id)->delete();              
                MenuAddonitems::insert($data);
            }
       

            /*
            if(!empty($request->addon)){
                foreach( $new_addons as  $addons){    
                    if(!empty($addons['items'])){
                        foreach( $addons['items'] as  $aditem){
                                
                        }
                    }
                }
            }else{
                //delete All
            }
            
            foreach($new_addons as $item){
                if(!in_array($item,$old_categories))
                     $insert[] = $item;
            }
            foreach($old_categories as $item){
                if(!in_array($item,$new_categories))
                    $delete[] = $item;
            }



            if(!empty($request->addon)){

                    $data = [];
                    foreach( $request->addon as  $addons){                   
                        if(!empty($addons['items'])){
                            foreach( $addons['items'] as  $aditem){



                                    $data[] = ['menu_id'=>$menu->id,'addon_category_id' => $addons['acat_id'], 'addon_item_id' => $aditem , 'required' =>$addons['required'] ?? 0 , 'multiple' =>  $addons['multiple'] ?? 0,'created_at' => date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')];
                            
                            
                                }
                        }                                                  
                    }                 
                    MenuAddonitems::insert($data);
            }
            */
            return redirect('/menu')->with('success', 'Menu Updated successfully.');
        }else{
            return redirect('/menu')->with('error', 'Something went wrong!');    
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Menu::where('id',$id)->delete();
        return redirect()->back()->with('success','Menu Deleted Successfully!');
    }
    public function get_categories(Request $request)
    {
         
        $menu_type_id = $request->menu_tid;
         
        $categories = Category::where('menu_type_id',$menu_type_id)->Where('active', '1')->orderBy('sort_order', 'asc')->pluck('name','id');
        return response()->json($categories);
    }


}