<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Settings;
use App\Models\Hours;
use App\Models\Category;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\OrderAddons;
use App\Models\MenuAddonitems;

class DineinController extends Controller
{
    public function index(){   
        $restaurant = Settings::first();
        if($restaurant->dinein == 0)
            abort(403, 'Dine In Currently Unavailable');
        $opening_hours = Hours::all();
        $hours = $opening_hours->where('day',date('w'))->first();
        $menu_type = 3; // dine in menu

        $clear_cart = false;
        if(session()->has('cart')){
            $cart = session()->get('cart');
            if(isset($cart["order_type"])){
                if($cart["order_type"]!= "dinein"){
                   $clear_cart = true;
                }
            }else{
                $clear_cart = true;
            }
        }else{
            $clear_cart = true;
        }    
       if($clear_cart){
            $cart = array();
            $cart["order_type"] = "dinein";
            session()->put('cart', $cart);
       }
        

       
        $data  = Category::with('menu')->where('menu_type_id', '=',$menu_type)->Where('active', '1')->orderBy('sort_order', 'asc')->get();
        $addonmenu =  MenuAddonitems::distinct()->pluck('menu_id')->toArray() ?? [];
        return view("themes.soup.{$restaurant->theme}",compact('data','cart','restaurant','hours','opening_hours','addonmenu'));
    }
    public function checkout(){
        $restaurant = Settings::first();
        if(!session()->has('cart'))
            return redirect('/dinein');

        $opening_hours = Hours::all();
        $hours = $opening_hours->where('day',date('w'))->first(); 
        $cart = session()->get('cart') ?? [];
        return view('themes.soup.dineincheckout',compact('restaurant','cart','hours','opening_hours'));
    }
    public function order(Request $request){
        if(!session()->has('cart'))
            return redirect('/dinein');
        $restaurant = Settings::first();
        $cart = session()->get('cart') ?? [];
        $request->validate([
            'name' => 'required',
            'tableno' => 'required|numeric',
            'payment_type' => 'required',
        ]);

        $hours = Hours::where('day',date('w'))->first();
       // dd($cart); 
       // return back()->withErrors('postcode','Invalid Postccode')->withInput();
        $order =  new orders;
        $order->customer_name = $request->name;
        $order->order_type = "dinein";
        $order->order_time = date('Y-m-d H:i:s');
        $order->tableno = $request->tableno;
        $order->amount = 1;
        $order->sub_total = 0;
        $order->discount = 0;
        $order->delivery_charge =  0;
        $order->delivery_phone = "";
        $order->delivery_email = "";
        $order->delivery_postcode = "";
        $order->delivery_address = "";
        $order->delivery_time = NULL;
        $order->other_info = $request->other_info ?? NULL;
        $order->payment_method = $request->payment_type;
        $order->payment_status = $request->payment_type == 2 ? 1 : 0;
        $order->status = 1;
        if($order->save()){ 
            $data = array(); 
            $total = 0;
            foreach($cart['items'] as $menu){
               
                $item =  new OrderItems; 
                $item->order_id = $order->id;
                $item->name = $menu['name'];
                $item->quantity = $menu['quantity'];
                $item->price = $menu['price'];
                $item->other = $menu['other'];
                if($item->save()){
                    if(!empty($menu['addons'])){
                            $data = Array();
                        foreach($menu['addons'] as $addon){
                            $data[] = [
                                "order_items_id"=>$item->id,
                                "addon_items_id"=>$addon['id'],
                                "addon_qty"=>$addon['qty'],
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ];
                            $total +=  $addon['qty']*$addon['price'];
                        }
                        OrderAddons::insert($data);
                    }
               
                }
                $total +=  $menu['quantity']*$menu['price']; 
            }
           
            $amount = $total;    

            Orders::find($order->id)->update(['amount' =>  number_format($amount,2),'sub_total' =>   number_format($total,2)]); 
           
            session()->forget('cart');

            $order = ["id"=>$order->id,"amount"=>$amount];
            session()->put('order', $order);
            if($request->payment_type == 2){
                return redirect('/confirmation');
            }else{
               
                return redirect('/dineinpayment');
            }
               
           
                
        }
            
    }
    public function confirmed(){
        $order_data = NULL;
        if(!empty(session()->get('order'))){
            $order_data = session()->get('order');
            $order_id = $order_data['id'];
            $order = Orders::find($order_id);
        }
             
        $restaurant = Settings::first();
        $opening_hours = Hours::all();
        return view('themes.soup.dineinconfirmed',compact('restaurant','opening_hours','order'));
    }
    public function rejected(){
        $restaurant = Settings::first();
        $opening_hours = Hours::all();
        if(!empty(session()->get('order'))){
            $order = session()->get('order');
            $order_id = $order['id'];
        }else{
            $order_id = NULL; 
        }
        return view('themes.soup.dineinrejected',compact('restaurant','opening_hours','order_id'));
    }
    public function paymentfailure(){
        $restaurant = Settings::first();
        $opening_hours = Hours::all();
        return view('themes.soup.dineinpaymentfailure',compact('restaurant','opening_hours'));
    }
}
