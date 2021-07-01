<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($request->search) && !empty($request->type)){
            $data = Coupon::sortable()->where('name', 'LIKE', '%'.$request->search.'%')->where('type', '=', $request->type)->paginate(8);
        }else if(!empty($request->search)){
            $data = Coupon::sortable()->where('name', 'LIKE', '%'.$request->search.'%')->paginate(8);
        }else if(!empty($request->type)){
             $data = Coupon::sortable()->where('type', '=', $request->type)->paginate(8);
        }else{
             $data = Coupon::sortable()->paginate(8);
        }     
        return view('coupon.list',compact('data','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('coupon.create');
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
            'code' => 'required',
            'value' => 'required|numeric',
            'reduction' => 'required|numeric',
            'min_amount' => 'numeric|nullable',
            'max_reduction' => 'numeric|nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
        ]);

        $coupon = new Coupon;
        $coupon->name = $request->code;
        $coupon->value = $request->value ?? 0;
        $coupon->reduction = $request->reduction ?? 1;
        $coupon->min_amount = $request->min_amount ?? 0;
        $coupon->max_reduction = $request->max_reduction ?? 0;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->active = $request->active;
        if($coupon->save()){
            return back()->with('success', 'Coupon created successfully.');
        }else{
            return back()->with('error', 'Something went wrong!'); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::find($id);
         return view('coupon.edit', compact('coupon'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'value' => 'required|numeric',
            'reduction' => 'required|numeric',
            'min_amount' => 'numeric|nullable',
            'max_reduction' => 'numeric|nullable',
            'start_date' => 'date|nullable',
            'end_date' => 'date|nullable',
        ]);
        
        $coupon =  Coupon::find($id);
        $coupon->name = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value ?? 0;
        $coupon->reduction = $request->reduction ?? 1;
        $coupon->min_amount = $request->min_amount ?? 0;
        $coupon->max_reduction = $request->max_reduction ?? 0;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->active = $request->active;
        if($coupon->save()){
            return redirect('/coupon')->with('success', 'Coupon Updated successfully.');
        }else{
            return redirect('/coupon')->with('error', 'Something went wrong!'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        Coupon::where('id',$id)->delete();
        return redirect()->back()->with('success','Coupon Deleted Successfully!');
    }

     public function apply(Request $request)
    {
        $result = [];
        $code = $request->ccode;
        $coupon = Coupon::where('name',$code)->where('active',1)->first();
        $order_type = $request->ordertype;
            if(!empty($coupon)){
            	$coupon = $coupon->toArray();
                switch($order_type){
                    case "collection":
                        if($coupon['type']!=1 && $coupon['type']!=2 && $coupon['type']!=4){
                            $result['status'] ="error";
                            $result['message'] ="Coupon cannot be applied for this type of order";
                        }
                    break;
                    case "delivery":
                        if($coupon['type']!=1 && $coupon['type']!=3 && $coupon['type']!=4){
                            $result['status'] ="error";
                            $result['message'] ="Coupon cannot be applied for this type of order";
                        }
                    break;
                }
               
                if(!isset($result['status'])){

                        if(session()->has('cart')){
                            $cart = session()->get('cart');
                            $amount = $cart['total']; 

                        

                            $startDate = $coupon['start_date'];
                            $endDate = $coupon['end_date'];
                            $now = date("Y-m-d H:i:s");
                            if(strtotime($now)>strtotime($startDate) && strtotime($now)<strtotime($endDate)){
                                if($coupon['min_amount']>$amount){
                                        $result['status'] ="error";
                                        $result['message'] ="Minimum order amount for reduction is ".$coupon['min_amount'];
                                }else{ 
                                        if($coupon['reduction']==1){
                                            $discount = $coupon['value'];
                                        }else{
                                            $discount = $amount*($coupon['value']/100);
                                            if($coupon['max_reduction']!=0 && $discount > $coupon['max_reduction']){
                                                $discount = $coupon['max_reduction'];
                                            }
                                        }
                                        $result['status'] ="success";
                                        $result['message'] ="Coupon Applied Successfully";
                                        $result['discount'] = $discount;

                                        $cart['coupon'] = $code;
                                        $cart['coupon_discount'] = $discount; 
                                        session()->put('cart', $cart);
                                }            
                            }else{
                                $result['status'] ="error";
                                $result['message'] ="Coupon expired/Not started";                               
                            }				
                        }else{
                            $result['status'] ="error";
                            $result['message'] ="Session Expired";
                        }
                }
				
            }else{
                $result['status'] ="error";
                $result['message'] ="Invalid Coupon";
            }

        if(isset($result['status']) && $result['status'] =="error"){
            $cart['coupon'] = NULL;
            $cart['coupon_discount'] = 0; 
            session()->put('cart', $cart);
        }
         return response()->json($result);
    }


}
