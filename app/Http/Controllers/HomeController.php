<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\MenuTypes;
use App\Models\Category;
//use App\Models\AddonCategories;
use App\Models\MenuAddonitems;
use App\Models\AddonItems;
use App\Models\Orders;
use App\Models\OrderItems;
use App\Models\OrderAddons;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Hours;
use App\Models\PaymentMethods;
use App\Models\DeliveryCharge;
use App\Models\Bookings;
use App\Models\PaynowOrders;
use App\Models\Notification;
use App\Models\Voucher;
use App\Models\VoucherOrders;
use App\Models\Sms;
use App\Models\Email;
use App\Models\Coupon;
//use Illuminate\Support\Facades\View;
//use Redirect;// r
use \Mailjet\Resources;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

     //stripe keys
    private $purcahse  = "pk_test_MhbicPy0cGkHBnEQ2l9NnuS8";
    private $secret = "sk_test_sIQ7FJQSaNrJpbxP7DKCADRK";



    public function index()
    {

        if(!session()->has('cart') && !session()->has('popup'))
                session()->put('popup', TRUE);

        $clear_cart = false;
        if(session()->has('cart')){
            $cart = session()->get('cart');
            if(isset($cart["order_type"])){
                if($cart["order_type"]!= "dev_coll"){
                     $clear_cart = true;
                     session()->put('popup', TRUE);
                }                
            }else{
                $clear_cart = true;
            }
        }else{
            $clear_cart = true;
        }    
       if($clear_cart){
            $cart = array();
            $cart["order_type"] = "dev_coll";
            session()->put('cart', $cart);
       }

       
        $restaurant = Settings::first();
        $opening_hours = Hours::all();
        $hours = $opening_hours->where('day',date('w'))->first();
        $delivery_charge = DeliveryCharge::all();
        $menu_type = 2; // delivery /collection menu
       
             
        $cart = session()->get('cart') ?? [];
        $cart["order_type"] = "deli_coll";

        $data  = Category::with('menu')->where('menu_type_id', '=',$menu_type)->Where('active', '1')->orderBy('sort_order', 'asc')->get();
        $addonmenu =  MenuAddonitems::distinct()->pluck('menu_id')->toArray() ?? [];

        return view("themes.soup.{$restaurant->theme}",compact('data','cart','restaurant','hours','opening_hours','addonmenu','delivery_charge'));
    }
   
    /*
    public function getaddons(Request $request)
    {
        $menu_id = $request->menu_id;
        
        $addons = MenuAddonitems::select('addon_categories.id','addon_categories.name as category','addon_items.id as item_id','addon_items.name as item','addon_items.price','menu_addonitems.required','menu_addonitems.multiple')  
                                            ->join('addon_categories', 'addon_categories.id', '=', 'menu_addonitems.addon_category_id')
                                            ->join('addon_items', 'addon_items.id', '=', 'menu_addonitems.addon_item_id')                                   
                                            ->Where('menu_addonitems.menu_id', $menu_id)
                                            ->Where('addon_categories.active', '1')
                                            ->Where('addon_items.active', '1')
                                            ->orderBy('addon_categories.sort_order', 'asc')
                                            ->get()->toArray();
        /*
        $addons = MenuAddonitems::select('addon_category_id','addon_item_id','required','multiple')->with(array('addon_categories'=>function($query){
            $query->select('id','name');
        }))->with(array('addon_items'=>function($query){
            $query->select('id','name','price');
        }))->Where('menu_id', $menu_id)->get();                                                                      
       ;*/ 
       //dd($data);
       /*
        if(!empty($addons)){
            $data = Array();
            foreach($addons as $item){
                    $data[$item['id']]['acategory'] = $item['category'];
                    $data[$item['id']]['required'] = $item['required'];
                    $data[$item['id']]['multiple'] = $item['multiple'];
                    $data[$item['id']]['aitems'][] = ['item_id'=>$item['item_id'],'name'=>$item['item'],'price'=>$item['price']];
                
            }       
                                             
            return response()->json(['status'=>'addons','data'=>$data]);
        }else{
            //$menu =  Menu::find($menu_id);
            $menu =  Menu::select('id','name','price')->Where('id', $menu_id)->Where('active', '1')->first();
            if(!$menu) {
               // abort(404);
            }else{
                $cart = session()->get('cart');
               /* if(!$cart) { //as first item
                     $cart = [
                            $menu_id => [
                                "name" => $menu->name,
                                "quantity" => 1,
                                "price" => $menu->price
                            ]
                    ];
                    session()->put('cart', $cart);
                    return redirect()->back()->with('success', 'Product added to cart successfully!');
                }*/
                /*
                if(isset($cart[$menu_id])) {
                    $cart[$menu_id]['quantity']++;
                    session()->put('cart', $cart);
                    return response()->json(['status'=>'success','message'=>'Item Quantity Updated','data'=>$cart]);
                }
                // adding to current cart
                $cart[$menu_id] = [
                    "name" => $menu->name,
                    "quantity" => 1,
                    "price" => $menu->price,
                    "addons"=>[]
                ];
                session()->put('cart', $cart);
                return response()->json(['status'=>'success','message'=>'Item Added to Cart','data'=>$cart]);
            }
            // return response()->json(null);
        }
        
    }*/

    public function addtocart(Request $request)
    { 
 
        //date_default_timezone_set('Asia/Kolkata');// remove later

        $restaurant = Settings::first();
        $hours = Hours::where('day',date('w'))->first();

        if(($restaurant->active==0 || $hours->active == 0) && $restaurant->test_mode==0 && $restaurant->pre_order==0){
            return response()->json(['status'=>'error','message'=>'Restaurant is Offline Now!' ]);
        }else{
           
        }
        $cur_time   =   strtotime(date("H:i:s"));
        $open = false;
        $start1    =   strtotime($hours->start1);
        $end1   =   strtotime($hours->end1);
        $start2    =   strtotime($hours->start2);
        $end2   =   strtotime($hours->end2);
        $pre_order_time = strtotime($restaurant->preorder_start);
   
        if(!$restaurant->test_mode){
            if($restaurant->active==0){
                $msg = "Restaurant is closed now";
            }else if($hours->active == 0){
                $msg = "Restaurant is closed for today";
            }else if($restaurant->pre_order && !empty($pre_order_time) && ($cur_time < $pre_order_time))
            {
                $msg = "Restaurant is closed now, Pre order starts at ".$restaurant->preorder_start;
            }else if(!$restaurant->pre_order && !empty($start1) && ($cur_time < $start1))
            {
                $msg = "Restaurant is closed now, Will open at ".$hours->start1;
            }else if(!$restaurant->pre_order && !empty($start2) && ($cur_time > $end1) && ($cur_time < $start2)){
                $msg = "Restaurant is closed now, Will open at ".$hours->start2;
            }else if(!empty($end2) && ($cur_time > $end2)){
                $msg = "Restaurant is closed now"; //start3
            }else{
                $open = true;
                $msg = "";
            }
            if(!$open)
                return response()->json(['status'=>'error','message'=> $msg ]);
        }    
        $menu_id = $request->menu_id; 
        
        if(session()->has('cart')){
            $cart = session()->get('cart');
           
        }else{
            $cart = Array();   
        }
        if($cur_time < $start1){
            $cart['pre_order'] = TRUE;
        }else{
            $cart['pre_order'] = FALSE;
        } 


        if($request->has('addon')){// from add to cart btn
            $addons = MenuAddonitems::select('addon_categories.id','addon_categories.name as category','addon_items.id as item_id','addon_items.name as item','addon_items.price','menu_addonitems.min','menu_addonitems.max','menu_addonitems.required','menu_addonitems.multiple')  
                                    ->join('addon_categories', 'addon_categories.id', '=', 'menu_addonitems.addon_category_id')
                                    ->join('addon_items', 'addon_items.id', '=', 'menu_addonitems.addon_item_id')                                   
                                    ->Where('menu_addonitems.menu_id', $menu_id)
                                    ->Where('addon_categories.active', '1')
                                    ->Where('addon_items.active', '1')
                                    ->orderBy('menu_addonitems.id', 'asc')
                                    ->get()->toArray();

            if(!empty($addons)){
                $data = Array();
                foreach($addons as $item){ 
                        $data[$item['id']]['acatid'] = $item['id'];
                        $data[$item['id']]['acategory'] = $item['category'];
                        $data[$item['id']]['required'] = $item['required'];
                        $data[$item['id']]['multiple'] = $item['multiple'];
                        $data[$item['id']]['aitems'][] = ['item_id'=>$item['item_id'],'name'=>$item['item'],'price'=>$item['price'],'min'=>$item['min'],'max'=>$item['max']];
                    
                }       
                $data = array_values($data);                  
                return response()->json(['status'=>'addons','data'=>$data]);
            }else{
                if(!empty($cart["items"])){
                    //$key = array_search($menu_id, array_column($cart["items"], 'id'));
                    //if($key !== false ){    
                    $collect =  collect($cart["items"]);
                    $keys = $collect->where('id',$menu_id)->keys(); 
                    
                    if(!$keys->isEmpty()){ 
                       
                        $key = $keys[0];               
                        $cart['items'][$key]['quantity']++;
                        $this->cartupdate($cart);
                        return response()->json(['status'=>'success','message'=>'Item Quantity Updated','data'=>$cart]);
                    }
                }
               
            }
        }

        $menu =  Menu::select('id','name','price')->Where('id', $menu_id)->Where('active', '1')->first();
        $addonIds = [];
        $aqty =  [];
        if(!empty($request->addons)){
            foreach($request->addons as $items){
                foreach($items as $addon){
                    if(isset($addon["id"])){
                         $addonIds[] = $addon["id"];
                         if(isset($aqty[$addon["id"]]))
                                $aqty[$addon["id"]] += $items[$addon["id"]]["qty"];
                         else
                                 $aqty[$addon["id"]] = $items[$addon["id"]]["qty"];
                    }
                }
                
            }          
        }
        $addons = Addonitems::select('id','name','price')->whereIn('id', $addonIds)->get()->toArray();                                 
        foreach($addons as $key =>$value){
            $addons[$key]["qty"] = $aqty[$value["id"]];
        }
       
        $cart['items'][] = [
            "id" => $menu_id,
            "name" => $menu->name,
            "quantity" => $request->quantity ?? 1,
            "price" => $menu->price,
            "addons"=> $addons,
            "other"=>$request->other_info ?? ''
        ];
        
         
        $this->cartupdate($cart);
         return response()->json(['status'=>'success','message'=>'Item Added to Cart','data'=>$cart]);
    }
    public function cartupdate($cart){
        $total = 0;
        $count = 0;
        
        foreach($cart['items'] as $key => $item){
            $item_total =  $item['quantity'] * $item['price'];
            $count += $item['quantity'];
           // $item_total =  $total;
            if(!empty($item['addons'])){
                foreach($item['addons'] as $addon){
                    $item_total += $addon['price']* $addon['qty'];
                }
            }
            $cart['items'][$key]['item_total'] =  $item_total;
            $total +=  $item_total;
        }
        $cart['total'] = $total;
        $cart['total_items'] =  $count;
        session()->put('cart', $cart);
       
    }
    public function removeitem(Request $request)
    {
        $key = $request->key;
        $cart = session()->get('cart');
        unset($cart['items'][$key]);
        $this->cartupdate($cart);
        return response()->json(['status'=>'success','message'=>'Item Removed From Cart','data'=>$cart]);
    }
    public function getcartdetails()
    {
        if(session()->has('cart')){
            $cart = session()->get('cart');
            return response()->json(['status'=>'success','data'=>$cart]);
        }
        return response()->json(['status'=>'error']);
        
    }
    public function emptycart()
    {
        $cart = [];
        if(session()->has('cart')){
            $cart = session()->get('cart');
            $cart['items'] = [];
            $this->cartupdate($cart);
        }
        return response()->json(['status'=>'success','data'=>$cart]);      
    }
    public function checkout(){
        $restaurant = Settings::first();
        if(!session()->has('cart')||$restaurant->isClosed($restaurant)){
            if(isset($cart["order_type"]) && $cart["order_type"] == "dinein")
                 return redirect('/dinein');
            else
                return redirect('/home');
        }
           

        $opening_hours = Hours::all();
        $payment_methods = PaymentMethods::where('active',1)->get();
        $hours = $opening_hours->where('day',date('w'))->first(); 
        $cart = session()->get('cart') ?? [];
         if(isset($cart["order_type"]) && $cart["order_type"] == "dinein"){
            return view('themes.soup.dineincheckout',compact('restaurant','cart','payment_methods','hours','opening_hours'));
        }else{
            return view('themes.soup.checkout',compact('restaurant','cart','payment_methods','hours','opening_hours'));
        }    
      
    }

    public function calcdistance(Request $request) {
        $restaurant = Settings::first();
        $rest_postcode =  str_replace(' ', '',$restaurant->postcode);       
        $cust_postcode = str_replace(' ', '',$request->postcode);
       
        $result = array();
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=$rest_postcode&destinations=$cust_postcode&mode=driving&language=en-EN&sensor=false&key=AIzaSyCnpYAiC-_sqhdhDcbsm2LlrY_Tt_ErC-g";
        $data = @file_get_contents($url);
        $obj = json_decode($data, true);
       
        if(isset($obj['rows'][0]['elements'][0]['distance']['text']))
            $distance = floatval($obj['rows'][0]['elements'][0]['distance']['text']);
        else
            return response()->json(['status'=>'error','message'=>'Invalid postcode']);
        if($distance >  $restaurant->delivery_radius){
            return response()->json(['status'=>'error','message'=>'Unfortunately, we cannot deliver to this area. Please try a different postcode or select collection from the dropdown above to collect your order.']);
        }else{
            $delivery_free = $this->__calcdeliveryfee($request->postcode,$distance);

            $cart = session()->get('cart') ?? [];
            $cart['d_postcode'] =  $cust_postcode;
            $cart['d_km'] = $distance;
            $cart['d_charge'] =  $delivery_free;
            session()->put('cart', $cart);
            
            return response()->json(['status'=>'success','fee'=>$delivery_free]);
        }
            
        
    }
    /*
      public function deliveryfee(Request $request)
    {
        $postcode =  $request->postcode;
      
        $delivery_free = $this->__calcdeliveryfee($postcode);
      
        $cart['d_charge'] =  $delivery_free;
        session()->put('cart', $cart);
        return response()->json(['status'=>'success','fee'=>$delivery_free]);
    }*/
    public function __calcdeliveryfee($postcode,$distance=NULL)
    {
        $delivery_charge = DeliveryCharge::all();
  
        $cart = session()->get('cart') ?? [];
        if($distance==NULL)
            $distance =  $cart['d_km'];
        $delivery_free = 0;
        switch($delivery_charge->first()->type){          
            case "free":                  
                $delivery_free = 0;
            break;
            case "flat_rate":
                if( $distance <= $delivery_charge->first()->free){
                    $delivery_free = 0;
                }else{
                    $delivery_free = $delivery_charge->first()->rate;
                }
            break;
            case "km_rate":
                $delivery =  $delivery_charge->where('free','<=',$distance)->sortByDesc('free')->first();
                if(empty($delivery))
                     $delivery_free = 0;
                else
                     $delivery_free =  $delivery->rate;
                /*
                if( $distance <= $delivery_charge->first()->free){
                    $delivery_free = 0;
                }else{
                     $delivery_free = $delivery_charge->first()->rate * $distance;
                }*/
            break;
            case "post_code":
                    $delivery =  DeliveryCharge::whereRaw("? LIKE CONCAT(`free`, '%')", [$postcode])->first();
               // $delivery =  $delivery_charge->where('free','LIKE','{$postcode}%')->first();
                if(empty($delivery))
                    $delivery_free = 0;
                else
                    $delivery_free =  $delivery->rate;     
            break;
        }
        return $delivery_free;
    }

    public function order(Request $request){
        $restaurant = Settings::first();
        if(!session()->has('cart')||$restaurant->isClosed($restaurant))
            return redirect('/home');
     
        $cart = session()->get('cart') ?? [];
      //dd($cart);
        if($request->order_type=="collection"){
            if( $cart['total'] < $restaurant->collection_min)
                return back()->withErrors(['Minimun Order Amount For Collection is '.$restaurant->collection_min])->withInput();
                $request->validate([
                    'order_type' => 'required',
                    'name' => 'required',
                    'phone' => 'required',
                    'email' => 'email|required',
                    'payment_type' => 'required',
                ]);
        }else{
            if( $cart['total'] < $restaurant->delivery_min)
                return back()->withErrors(['Minimun Order Amount For Delivery is '.$restaurant->delivery_min])->withInput();

             $request->validate([
                    'order_type' => 'required',
                    'name' => 'required',
                    'phone' => 'required',
                    'email' => 'email|required',
                    'postcode' => ['required',function ($attribute, $value, $fail) use ($cart){
                        /*if(empty($cart['d_postcode']) || ($value != $cart['d_postcode']))
                            $fail($attribute.' is invalid.');*/ //  check later
                       
                    }],
                    'address' => 'required',
                    'payment_type' => 'required',
                    
                ]);
        }
        $hours = Hours::where('day',date('w'))->first();
       // dd($cart); 
       // return back()->withErrors('postcode','Invalid Postccode')->withInput();
        $pre_order =  $cart['pre_order']==TRUE ? 1 : 0;
        
        $order =  new orders;
        $order->customer_name = $request->name;
        $order->order_type = $request->order_type;
        $order->order_time = date('Y-m-d H:i:s');
        $order->tableno = NULL;
        $order->coupon = $cart['coupon'] ?? NULL;
        $order->amount = 1;
        $order->sub_total = 0;
        $order->discount = 0;
        $order->coupon_discount =  $cart['coupon_discount'] ?? 0;
        $order->delivery_charge = ($request->order_type=="delivery") ?  $this->__calcdeliveryfee($request->postcode) : 0;
        $order->delivery_phone = $request->phone;
        $order->delivery_email = $request->email;
        $order->delivery_postcode = $request->postcode;
        $order->delivery_address = $request->address;
        $order->delivery_time = NULL;
        $order->other_info = $request->other_info ?? NULL;
        $order->pre_order =  $pre_order;
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
            $discount = 0;
            switch($request->order_type){          
                case "collection":                  
                    if($total > $hours->coll_min)
                    $discount = $total*$hours->offer_coll/100;
                break;
                case "delivery":
                    if($total > $hours->deli_min)
                    $discount  = $total*$hours->offer_deli/100;
                break;
            }
 
            $amount = $total - $discount - $order->coupon_discount +   $order->delivery_charge;    

            Orders::find($order->id)->update(['amount' =>  number_format($amount,2),'sub_total' =>   number_format($total,2),'discount' =>   number_format($discount,2)]); 
            //can use Order eq
            session()->forget('cart');

            $order = ["id"=>$order->id,"amount"=>$amount,"type"=>$order->order_type,"pre_order" => $pre_order];
            session()->put('order', $order);
            if($request->payment_type == 2){
                if($order['pre_order'])
                     return redirect('/orderplaced');
                else
                     return redirect('/confirmation');
            }else{
                return redirect('/payment');
            }
               
           
                
        }
            
    }
    public function coupon(Request $request)
    {
        $code =  $request->code;
      
        $coupon = Coupon::where('name',$code)->get();
        $reduction =  $coupon->value;
        $ctype =  $coupon->reduction==1 ? 'amount' : 'percentage';

        $cart = session()->get('cart') ?? [];
        $cart['coupon'] =  $coupon->name;
        $cart['creduction'] = $reduction;
        session()->put('cart', $cart);
        return response()->json(['status'=>'success','reduction'=>$reduction]);
    }

    public function paymentfailure(){
        $restaurant = Settings::first();
        $opening_hours = Hours::all();
        return view('themes.soup.paymentfailure',compact('restaurant','opening_hours'));
    }
   
    public function payment(){

        //1
        $purcahse_key  = $this->purcahse;
        $secret_key = $this->secret;
   
        if(!empty(session()->get('order')))
            $order = session()->get('order');
        else
            return redirect('/home');
           
        $restaurant = Settings::first();
        //require_once('stripe/init.php');
        include(app_path() . '/stripe/init.php');
        
        \Stripe\Stripe::setApiKey($secret_key);
        try {

            $session = \Stripe\Checkout\Session::create(array(
                        'payment_method_types' => array('card'),
                        'line_items' => array(array(
                                'name' => "Live",
                                'amount' =>  round($order['amount'],2) * 100,
                                'currency' => 'gbp',
                                'quantity' => 1,
                                'images' => array(url('images/secure-payment.png'))
                            )),
                        'metadata'=>array(
                            'restaurant_id'=>$restaurant->erp_id,
                        ),
                        'success_url' =>  $order['pre_order'] == 1 ? url('/orderplaced?session_id={CHECKOUT_SESSION_ID}') : url('/confirmation?session_id={CHECKOUT_SESSION_ID}'),
                        'cancel_url' =>  url('/payment-failure'),
                        'client_reference_id' =>$order['id'],
                         ), 
                        array(
                        'stripe_account' => $restaurant->stripe_id,
            ));
        } catch (Exception $e) {
            echo $error3 = $e->getMessage();
        }
       
        return view('payment',compact('session','purcahse_key','restaurant'));
    }

    public function dineinpayment(){

        //1
        $purcahse_key  = $this->purcahse;
        $secret_key = $this->secret;
   
        if(!empty(session()->get('order')))
            $order = session()->get('order');
        else
            return redirect('/dinein');
           
        $restaurant = Settings::first();
        //require_once('stripe/init.php');
        include(app_path() . '/stripe/init.php');
        
        \Stripe\Stripe::setApiKey($secret_key);
        try {

            $session = \Stripe\Checkout\Session::create(array(
                        'payment_method_types' => array('card'),
                        'line_items' => array(array(
                                'name' => "Live",
                                'amount' =>  round($order['amount'],2) * 100,
                                'currency' => 'gbp',
                                'quantity' => 1,
                                'images' => array(url('images/secure-payment.png'))
                            )),
                        'metadata'=>array(
                            'restaurant_id'=>$restaurant->erp_id,
                        ),
                        'success_url' =>  url('/dineinconfirmation?session_id={CHECKOUT_SESSION_ID}') ,
                        'cancel_url' =>  url('/dineinpayment-failure'),
                        'client_reference_id' =>$order['id'],
                         ), 
                        array(
                        'stripe_account' => $restaurant->stripe_id,
            ));
        } catch (Exception $e) {
            echo $error3 = $e->getMessage();
        }
       
        return view('payment',compact('session','purcahse_key','restaurant'));
    }
    public function paynowpayment(){

        //1
        $purcahse_key  = $this->purcahse;
        $secret_key = $this->secret;
   
        if(!empty(session()->get('paynow')))
            $paynow = session()->get('paynow');
        else
            return redirect('/paynow');
           
        $restaurant = Settings::first();
        //require_once('stripe/init.php');
        include(app_path() . '/stripe/init.php');
        
        \Stripe\Stripe::setApiKey($secret_key);
        try {

            $session = \Stripe\Checkout\Session::create(array(
                        'payment_method_types' => array('card'),
                        'line_items' => array(array(
                                'name' => "Live",
                                'amount' =>  round($paynow['amount'],2) * 100,
                                'currency' => 'gbp',
                                'quantity' => 1,
                                'images' => array(url('images/secure-payment.png'))
                            )),
                        'metadata'=>array(
                            'restaurant_id'=>$restaurant->erp_id,
                        ),
                        'success_url' =>  url('/paynowconfirmation?session_id={CHECKOUT_SESSION_ID}') ,
                        'cancel_url' =>  url('/payment-failure'),
                        'client_reference_id' =>$paynow['id'],
                         ), 
                        array(
                        'stripe_account' => $restaurant->stripe_id,
            ));
        } catch (Exception $e) {
            echo $error3 = $e->getMessage();
        }
       
        return view('payment',compact('session','purcahse_key','restaurant'));
    }
    public function confirmation(Request $request){
        $restaurant = Settings::first();
        if(!empty(session()->get('order'))){
             $order_data = session()->get('order');
             $order =  Orders::find($order_data['id']);
         }else{
             $order = NULL;
        }
            
        if(!empty($request->session_id)){
                //2
            $purcahse_key  = $this->purcahse;
            $secret_key = $this->secret;

            include(app_path() . '/stripe/init.php');
            
            \Stripe\Stripe::setApiKey($secret_key);
            
            $checkout_session = \Stripe\Checkout\Session::retrieve($request->session_id); 
            $order_id = $checkout_session['client_reference_id'];
            Orders::find($order_id)->update(['payment_status' =>  1]); 

          
        }
        $title ="order";
        $message ="You have a new order ". $restaurant->name;
        $notification = new Notification();
        $notification->send( $title,$message);
       
        $opening_hours = Hours::all();
        return view('themes.soup.confirmation',compact('restaurant','opening_hours','order'));
    }
    public function dineinconfirmation(Request $request){
        $restaurant = Settings::first();
        if(!empty(session()->get('order'))){
             $order_data = session()->get('order');
             $order =  Orders::find($order_data['id']);
         }else{
             $order = NULL;
        }
            
        if(!empty($request->session_id)){
                //2
            $purcahse_key  = $this->purcahse;
            $secret_key = $this->secret;

            include(app_path() . '/stripe/init.php');
            
            \Stripe\Stripe::setApiKey($secret_key);
            
            $checkout_session = \Stripe\Checkout\Session::retrieve($request->session_id); 
            $order_id = $checkout_session['client_reference_id'];
            Orders::find($order_id)->update(['payment_status' =>  1]); 
        }
        
        $title ="dinein";
        $message ="You have a new Dine In order ". $restaurant->name;
        $notification = new Notification();
        $notification->send( $title,$message);
        $opening_hours = Hours::all();
        return view('themes.soup.dineinconfirmation',compact('restaurant','opening_hours','order'));
    }
    public function paynowconfirmation(Request $request){
        $restaurant = Settings::first();
        $pay_now = NULL;           
        if(!empty($request->session_id)){
                //2
            $purcahse_key  = $this->purcahse;
            $secret_key = $this->secret;

            include(app_path() . '/stripe/init.php');
            
            \Stripe\Stripe::setApiKey($secret_key);
            
            $checkout_session = \Stripe\Checkout\Session::retrieve($request->session_id); 
            $paynow_id = $checkout_session['client_reference_id'];
            $pay_now = PaynowOrders::find($paynow_id);
            $pay_now->payment_status = 1;
            $pay_now->save();
        }
        
        $title ="paynow";
        $message ="You have a new Pay Now order ". $restaurant->name;
        $notification = new Notification();
        $notification->send( $title,$message);
        $opening_hours = Hours::all();
        return view('themes.soup.paynowconfirmed',compact('restaurant','opening_hours','pay_now'));
    }
    
    public function confirmed(){
        $order = NULL;
        if(!empty(session()->get('order'))){
            $order = session()->get('order');
            $order_id = $order['id'];
            $order = Orders::find($order_id);
        }
             
        $restaurant = Settings::first();
        $opening_hours = Hours::all();
        return view('themes.soup.confirmed',compact('restaurant','opening_hours','order'));
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
        return view('themes.soup.rejected',compact('restaurant','opening_hours','order_id'));
    }
     public function orderplaced(Request $request){
        $order = NULL;
        if(!empty(session()->get('order'))){
            $order = session()->get('order');
            $order_id = $order['id'];
            $order = Orders::find($order_id);
        }
        if(!empty($request->session_id)){
                //2
            $purcahse_key  = $this->purcahse;
            $secret_key = $this->secret;

            include(app_path() . '/stripe/init.php');
            
            \Stripe\Stripe::setApiKey($secret_key);
            
            $checkout_session = \Stripe\Checkout\Session::retrieve($request->session_id); 
            $order_id = $checkout_session['client_reference_id'];
            Orders::find($order_id)->update(['payment_status' =>  1]); 

        }
        $restaurant = Settings::first();
        $opening_hours = Hours::all();
        return view('themes.soup.orderplaced',compact('restaurant','opening_hours','order'));
    }
    public function confirmstatus(Request $request){
        $orderId = $request->id;
        $order = Orders::find($orderId);
        $result  = "";
        if($order->status == 2)
            $result = "accepted";
        if($order->status == 4)
            $result = "rejected";

        return response()->json(['status'=>'success','message'=>$result]);

    }



    public function booking(){
        $restaurant = Settings::first();
        if($restaurant->booking == 0)
            abort(403, 'Booking Currently Unavailable');
        $hours = Hours::all();
        return view('themes.soup.booking',compact('restaurant','hours'));
    }
    public function sbooking(){
        $booktype = "special";
        $restaurant = Settings::first();
        if($restaurant->booking == 0)
            abort(403, 'Booking Currently Unavailable');
        $hours = Hours::all();
        return view('themes.soup.booking',compact('restaurant','hours','booktype'));
    }
    public function bookingconfirmation(Request $request){
        $restaurant = Settings::first();
        $request->validate([
            'name' => 'required',
            'date' => 'required',
            'time' => 'required',
            'guests' => 'required|numeric',
            'phone' =>'required',
            'email' => 'email|required',
           /* 'phone' => ['required',function ($attribute, $value, $fail){
                $pattern = "/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/";
                $match = preg_match($pattern,$value);
                if ($match != false) {
                    // We have a valid phone number
                } else {
                    $fail($attribute.' Number is invalid.');
                }
               
            }],*/
        ]);

       
        $booking =  new Bookings; 
        $booking->name = $request->name;
        $booking->phone = $request->phone;
        $booking->email = $request->email;
        $booking->date = date('Y-m-d', strtotime($request->date));
        $booking->time =  date('H:i:s', strtotime($request->time));
        $booking->guests = $request->guests;
        $booking->type = $request->booktype ?? 1;
        $booking->save();
        
        $title ="booking";
        $message ="You have a new Booking ". $restaurant->name;
        $notification = new Notification();
        $notification->send( $title,$message);
        $opening_hours = Hours::all();
        return view('themes.soup.bookingconfirmation',compact('restaurant','opening_hours'));
  
    }
    public function voucher(){
        $restaurant = Settings::first();
        if($restaurant->voucher == 0)
            abort(403, 'Voucher Currently Unavailable');
        $vouchers = Voucher::where('active', '=',1)->orderBy('sort_order', 'asc')->get();
       
        return view('themes.soup.voucher',compact('vouchers','restaurant'));
    }
    public function vouchercheckout($id){
        $restaurant = Settings::first();
        if($restaurant->voucher == 0)
            abort(403, 'Voucher Currently Unavailable');
        $voucher = Voucher::find($id);
        return view('themes.soup.vouchercheckout',compact('voucher','restaurant'));
    }


    
    public function voucherpayment()
    {
        $restaurant = Settings::first();
        if($restaurant->voucher == 0)
            abort(403, 'Voucher Currently Unavailable');
        
        if(!empty(session()->get('voucher'))){
            $voucher = session()->get('voucher');
        }else{
            $voucher = NULL;
       }
       
        $amount = $voucher['amount'];     
        $purcahse_key  = $this->purcahse;
        $secret_key = $this->secret;

        //require_once('stripe/init.php');
        include(app_path() . '/stripe/init.php');
        
        \Stripe\Stripe::setApiKey($secret_key);
        try {

            $session = \Stripe\Checkout\Session::create(array(
                        'payment_method_types' => array('card'),
                        'line_items' => array(array(
                                'name' => "Live",
                                'amount' =>  round($amount,2) * 100,
                                'currency' => 'gbp',
                                'quantity' => 1,
                                'images' => array(url('images/secure-payment.png'))
                            )),
                        'metadata'=>array(
                            'restaurant_id'=>$restaurant->erp_id,
                        ),
                        'success_url' =>  url('/voucherconfirmation?session_id={CHECKOUT_SESSION_ID}') ,
                        'cancel_url' =>  url('/voucherpayment-failure'),
                        'client_reference_id' =>$voucher['id'],
                         ), 
                        array(
                        'stripe_account' => $restaurant->stripe_id,
            ));
        } catch (Exception $e) {
            echo $error3 = $e->getMessage();
        }
       
        return view('payment',compact('session','purcahse_key','restaurant'));
    }
    public function voucherconfirmation(Request $request){
        $restaurant = Settings::first();
        $pay_now = NULL;           
        if(!empty($request->session_id)){
                //2
            $purcahse_key  = $this->purcahse;
            $secret_key = $this->secret;

            include(app_path() . '/stripe/init.php');
            
            \Stripe\Stripe::setApiKey($secret_key);
            
            $checkout_session = \Stripe\Checkout\Session::retrieve($request->session_id); 
            $vorder_id = $checkout_session['client_reference_id'];
            $voucher_order = VoucherOrders::find($vorder_id);
            $voucher_order->payment_status = 1;
            $voucher_order->save();

            $msg = "Dear customer, Thank you for purchasing the Voucher, Your Purchase Code is" . $voucher_order->purchase_code . ".See you soon  , ".$restaurant->name." ";           
            //Sms::send( $voucher_order->phone,$msg)
            $to =  $voucher_order->email;
            $cname = $voucher_order->customer_name;
            $subject = "Voucher Purchased";
            $logo = url('storage/images/'.$restaurant->logo);
            $rests = $restaurant->name;
            $pcode = $voucher_order->purchase_code;
            $rmail =  $restaurant->email;
            $cnumber = $restaurant->contact_no;
            $html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"/><meta content="width=device-width" name="viewport"/><meta content="IE=edge" http-equiv="X-UA-Compatible"/><title></title><style type="text/css">body {margin: 0;padding: 0;}table,td,tr {vertical-align: top;border-collapse: collapse;}* {line-height: inherit;}a[x-apple-data-detectors=true] {color: inherit !important;text-decoration: none !important;}</style><style id="media-query" type="text/css">@media (max-width: 520px) {.block-grid,.col {min-width: 320px !important;max-width: 100% !important;display: block !important;}.block-grid {width: 100% !important;}.col {width: 100% !important;}.col_cont {margin: 0 auto;}img.fullwidth,img.fullwidthOnMobile {max-width: 100% !important;}.no-stack .col {min-width: 0 !important;display: table-cell !important;}.no-stack.two-up .col {width: 50% !important;}.no-stack .col.num2 {width: 16.6% !important;}.no-stack .col.num3 {width: 25% !important;}.no-stack .col.num4 {width: 33% !important;}.no-stack .col.num5 {width: 41.6% !important;}.no-stack .col.num6 {width: 50% !important;}.no-stack .col.num7 {width: 58.3% !important;}.no-stack .col.num8 {width: 66.6% !important;}.no-stack .col.num9 {width: 75% !important;}.no-stack .col.num10 {width: 83.3% !important;}.video-block {max-width: none !important;}.mobile_hide {min-height: 0px;max-height: 0px;max-width: 0px;display: none;overflow: hidden;font-size: 0px;}.desktop_hide {display: block !important;max-height: none !important;}}</style><style id="icon-media-query" type="text/css">@media (max-width: 520px) {.icons-inner {text-align: center;}.icons-inner td {margin: 0 auto;}}</style></head><body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #32b8ba;"><table bgcolor="#32b8ba" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #32b8ba; width: 100%;" valign="top" width="100%"><tbody><tr style="vertical-align: top;" valign="top"><td style="word-break: break-word; vertical-align: top;" valign="top"><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div align="center" class="img-container center autowidth" style="padding-right: 0px;padding-left: 0px;"><img align="center" border="0" class="center autowidth" src="'.$logo.'" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 150px; display: block;" width="150"/></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 22px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 26px; margin-top: 0; margin-bottom: 0;"><span style="font-size: 18px;"><strong><br/>VOUCHER STATUS : VOUCHER PURCHASED</strong></span></p></div></div></div></div></div></div></div></div><div><div class="block-grid mixed-two-up" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num3" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 123px; width: 125px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px; text-align: center; width: 100%;" valign="top" width="100%"><h1 style="color:#ffffff;direction:ltr;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:23px;font-weight:normal;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><strong>'.$rests.'</strong></h1></td></tr></table></div></div></div><div class="col num9" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 369px; width: 375px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Dear Customer,</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Thank you for purchasing the Voucher, Your Purchase Code is :'.$pcode.'<br/></h3></p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;"> </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">For Further Details</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">please Contact: '.$rmail.'</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Or Call '.$cnumber.' </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-top: 5px; padding-right: 0px; padding-bottom: 5px; padding-left: 0px; text-align: center;" valign="top"><table cellpadding="0" cellspacing="0" class="icons-inner" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;" valign="top"><tr style="vertical-align: top;" valign="top"></tr></table></td></tr></table></div></div></div></div></div></div></td></tr></tbody></table></body></html>';
            Email::send($to, $rests,$cname,$subject,$html);
        }
        
        /*$title ="paynow";
        $message ="You have a new Pay Now order ". $restaurant->name;
        $notification = new Notification();
        $notification->send( $title,$message);
        */
        $opening_hours = Hours::all();
        return view('themes.soup.voucherconfirmed',compact('restaurant','opening_hours','pay_now'));
    }
    


    public function privacy(){
        $restaurant = Settings::first();
        return view('themes.soup.privacy-policy',compact('restaurant'));
    }
    
    public function test(){
        $restaurant = Settings::first();
        $logo = url('storage/images/'.$restaurant->logo);
        $rests = "Kerala Hotel";
        $pcode = "#kerala6renil56";
        $rmail = "rmail@gmail.com";
        $cnumber = "12342435436";
  
 $html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"/><meta content="width=device-width" name="viewport"/><meta content="IE=edge" http-equiv="X-UA-Compatible"/><title></title><style type="text/css">body {margin: 0;padding: 0;}table,td,tr {vertical-align: top;border-collapse: collapse;}* {line-height: inherit;}a[x-apple-data-detectors=true] {color: inherit !important;text-decoration: none !important;}</style><style id="media-query" type="text/css">@media (max-width: 520px) {.block-grid,.col {min-width: 320px !important;max-width: 100% !important;display: block !important;}.block-grid {width: 100% !important;}.col {width: 100% !important;}.col_cont {margin: 0 auto;}img.fullwidth,img.fullwidthOnMobile {max-width: 100% !important;}.no-stack .col {min-width: 0 !important;display: table-cell !important;}.no-stack.two-up .col {width: 50% !important;}.no-stack .col.num2 {width: 16.6% !important;}.no-stack .col.num3 {width: 25% !important;}.no-stack .col.num4 {width: 33% !important;}.no-stack .col.num5 {width: 41.6% !important;}.no-stack .col.num6 {width: 50% !important;}.no-stack .col.num7 {width: 58.3% !important;}.no-stack .col.num8 {width: 66.6% !important;}.no-stack .col.num9 {width: 75% !important;}.no-stack .col.num10 {width: 83.3% !important;}.video-block {max-width: none !important;}.mobile_hide {min-height: 0px;max-height: 0px;max-width: 0px;display: none;overflow: hidden;font-size: 0px;}.desktop_hide {display: block !important;max-height: none !important;}}</style><style id="icon-media-query" type="text/css">@media (max-width: 520px) {.icons-inner {text-align: center;}.icons-inner td {margin: 0 auto;}}</style></head><body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #32b8ba;"><table bgcolor="#32b8ba" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #32b8ba; width: 100%;" valign="top" width="100%"><tbody><tr style="vertical-align: top;" valign="top"><td style="word-break: break-word; vertical-align: top;" valign="top"><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div align="center" class="img-container center autowidth" style="padding-right: 0px;padding-left: 0px;"><img align="center" border="0" class="center autowidth" src="'.$logo.'" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 150px; display: block;" width="150"/></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 22px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 26px; margin-top: 0; margin-bottom: 0;"><span style="font-size: 18px;"><strong><br/>VOUCHER STATUS : VOUCHER PURCHASED</strong></span></p></div></div></div></div></div></div></div></div><div><div class="block-grid mixed-two-up" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num3" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 123px; width: 125px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px; text-align: center; width: 100%;" valign="top" width="100%"><h1 style="color:#ffffff;direction:ltr;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:23px;font-weight:normal;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><strong>'.$rests.'</strong></h1></td></tr></table></div></div></div><div class="col num9" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 369px; width: 375px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Dear Customer,</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Thank you for purchasing the Voucher, Your Purchase Code is :'.$pcode.'<br/></h3></p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;"> </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">For Further Details</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">please Contact: '.$rmail.'</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Or Call '.$cnumber.' </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-top: 5px; padding-right: 0px; padding-bottom: 5px; padding-left: 0px; text-align: center;" valign="top"><table cellpadding="0" cellspacing="0" class="icons-inner" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;" valign="top"><tr style="vertical-align: top;" valign="top"></tr></table></td></tr></table></div></div></div></div></div></div></td></tr></tbody></table></body></html>';
        require app_path().'/../vendor/autoload.php';
        
        include(app_path() . '/Mailjet/src/Mailjet/Client.php');
        include(app_path() . '/Mailjet/src/Mailjet/Config.php');
        include(app_path() . '/Mailjet/src/Mailjet/Resources.php');
        include(app_path() . '/Mailjet/src/Mailjet/Request.php');
        include(app_path() . '/Mailjet/src/Mailjet/Response.php');
        
        $mj = new \Mailjet\Client('cf7605a32717d7b016f974a988aaf71a','cf416e1237e4703a5c8d51b6a9176147',true,['version' => 'v3.1']);
        $body = [
        'Messages' => [
        [
        'From' => [
        'Email' => "info@ijoo.co.uk",
        'Name' => $rests
        ],
        'To' => [
        [
        'Email' => "kr.renil@gmail.com",
        'Name' => "Renil"
        ]
        ],
        'Subject' => "Booking rejected",
        'TextPart' => "My first Mailjet email",
        //'HTMLPart' => $html,
        'CustomID' => "AppGettingStartedTest"
        ]
        ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success() && var_dump($response->getData());


         /*$title ="New order";
        $message ="You have a new order";
        $notification = new Notification();
        $notification->send( $title,$message);


       
        $title ="New order";
        $message ="You have a new order";

        $device_id ="f09e5248-51f7-4dc8-9c90-fdd12ef8d689";

        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => "c81a5971-02a1-4c7f-8b7f-2e3200a7234f",
            'include_player_ids' => array($device_id),
            'data' => array("title" => $title),
            'android_sound' => "ring",
            'contents' => $content
        );
        $fields = json_encode($fields);
       
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($ch);
       dd( $response);
       */
    }
//move

    




}