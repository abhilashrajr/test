<?php

namespace App\Http\Controllers;
use App\Models\Sizes;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($request->search)){
            $data = Sizes::sortable()->where('name', 'LIKE', '%'.$request->search.'%')->paginate(8);
       }else{
            $data = Sizes::sortable()->paginate(8);
       }
      
        return view('size.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('size.create');
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
        ]);
        if(Sizes::create($request->all())){
            return back()->with('success', 'Size added successfully.');
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
        $size = Sizes::find($id);
        return view('size.edit', compact('size'));
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
        ]);
        $size = Sizes::find($id);
        $size->name = $request->name;
        $size->sort_order = $request->sort_order;
        $size->active = $request->active;
        if($size->save()){
            return redirect('/size')->with('success', 'Food Size updated successfully.');
        }else{
            return redirect('/size')->with('error', 'Something went wrong!');
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
        Sizes::where('id',$id)->delete();
        return redirect()->back()->with('success','Food Size Deleted Successfully!');
    }
}
