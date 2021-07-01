<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\PaynowOrders;
use App\Models\Hours;

class PaynowController extends Controller
{
    //
    public function index()
    {
        $restaurant = Settings::first();
        if($restaurant->paynow == 0)
            abort(403, 'Pay Now Currently Unavailable');
        $opening_hours = Hours::all();

        $day = $opening_hours->where('day',date('w'))->first();
        //discount percentage
        $drinks_discount = $day->offer_payn;
        $food_discount = 0;

        return view('themes.soup.paynow',compact('restaurant','drinks_discount','food_discount','opening_hours'));
    }

    public function save(Request $request){
        //get paynow discounts

        $restaurant = Settings::first();
        $request->validate([
                    'name' => 'required',
                    'tableno' => 'required',
                    'drinks' => 'numeric',
                    'food' => 'numeric',
                ]);
        $day = Hours::where('day',date('w'))->first();
        $drinks_discount =  $day->offer_payn;
        $food_discount =  0;

        $drinks_total = $request->drinks;
        $food_total = $request->food;

        if($drinks_discount > 0 && $drinks_total > 0){
            $drinks_total = round($drinks_total-($drinks_total*$drinks_discount/100),2);
        }else{
            if($drinks_total=="")
                $drinks_total=0;
        }
        
        if($food_discount>0 && $food_total>0){
            $food_total =  round( $food_total- ($food_total*$food_discount/100),2);
        }else{
             if($food_total=="")
                    $food_total=0;
        }
        
        $amount_to_pay =  round(($drinks_total + $food_total),2);


       // $hours = Hours::where('day',date('w'))->first();

        $order =  new PaynowOrders;
        $order->customer_name = $request->name;
        $order->tableno = $request->tableno;
        $order->order_time = date('Y-m-d H:i:s');
        $order->drinks_amount = $request->drinks;
        $order->food_amount = $request->food;
        $order->drinks_discount = $drinks_discount;
        $order->food_discount = $food_discount;
        $order->drinks_total = $drinks_total;
        $order->food_total = $food_total;      
        $order->total_amount =  $amount_to_pay; 
        $order->payment_method = 1;
        $order->payment_status =  0;
        $order->status = 1;
        if($order->save()){ 
            $paynow = ["id"=>$order->id,"amount"=>$amount_to_pay];
            session()->put('paynow', $paynow);
            return redirect('/paynowpayment');           
                
        }
            
    }
    
    public function paymentfailure(){
        $restaurant = Settings::first();
        $opening_hours = Hours::all();
        return view('themes.soup.paynowpaymentfailure',compact('restaurant','opening_hours'));
    }
}
