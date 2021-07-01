<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use DB;
use App\Models\PaynowOrders;
use App\Models\Settings;
class OrderController extends Controller
{
    public function orders(Request $request){
        $order_type = "deli_coll";
        $orders = Orders::sortable()->where(function($query) {
                                        $query->where('order_type', 'collection')
                                            ->orWhere('order_type', 'delivery');
                                    });
        

        if($request->filled('from'))
                $orders->whereDate('order_time', '>=', $request->from);
        if($request->filled('to'))
                $orders->whereDate('order_time', '<=', $request->to);

        if ($request->filled('delivery_type')) {
            $orders->where('order_type', $request->delivery_type);
        }
        if ($request->filled('status')) {
            if($request->status == 10){// card not paid
                $orders->where('payment_method', 1);
            }else if($request->status == 11){ // pre order
                $orders->where('pre_order', 1);
            }else{
                $orders->where('status', $request->status); 
            }                         
        }
        if ($request->filled('payment_type')) {
            $orders->where('payment_method', $request->payment_type);
        }
        if ($request->filled('pincode')) {
            $orders->where('delivery_postcode', $request->pincode);
        }
       if($request->status == 10) // card not paid
            $orders->where('payment_status',0);
      // else
          //  $orders->where('payment_status',1);
 
        $data =$orders->latest()->paginate(8);
        return view('order.list',compact('data','order_type'));
    }
    public function dineinorders(Request $request)
    {
        
        $order_type = "dinein";
        $orders = Orders::sortable()->where('order_type',"dinein");
    
        if($request->filled('from'))
                $orders->whereDate('order_time', '>=', $request->from);
        if($request->filled('to'))
                $orders->whereDate('order_time', '<=', $request->to);

        if ($request->filled('delivery_type')) {
            $orders->where('order_type', $request->delivery_type);
        }
        if ($request->filled('status')) {
            if($request->status == 10)// card not paid
                $orders->where('payment_method', 1);
            else
                $orders->where('status', $request->status);           
        }
        if ($request->filled('payment_type')) {
            $orders->where('payment_method', $request->payment_type);
        }
        if ($request->filled('pincode')) {
            $orders->where('delivery_postcode', $request->pincode);
        }
       if($request->status == 10) // card not paid
            $orders->where('payment_status',0);
       else
            $orders->where('payment_status',1);

            $data =$orders->latest()->paginate(8);

        return view('order.list',compact('data','order_type'));
    }
    public function orderview($id)
    {
        $restaurant = Settings::first();
      

       // $data = Orders::with('order_items','order_items.order_addons','order_items.order_addons.addons')->find($id);
       
       // dd($data->order_items);
      // DB::enableQueryLog(); //,'order_items.*','order_addons.*'
        $data =  Orders::select('orders.*','order_items.id as item_id','order_items.name','order_items.quantity','order_items.price','order_items.other','addon_items.name as addon_name','addon_items.price as addon_price','order_addons.addon_qty as addon_qty','payment_methods.name as paymethod')//,'addon_items.name'
                       ->Join('order_items', 'order_items.order_id', '=', 'orders.id')
                        ->leftJoin('order_addons', 'order_addons.order_items_id', '=', 'order_items.id')
                        ->leftJoin('addon_items', 'addon_items.id', '=', 'order_addons.addon_items_id')
                        ->leftJoin('payment_methods', 'payment_methods.id', '=', 'orders.payment_method')
                        ->where('orders.id',$id)
                        ->get()->toArray();
                   
    //dd(DB::getQueryLog());
   // dd($data);

        $order_data = Array();
        foreach($data as $order){
              if(!isset($order_data['details']))
                $order_data['details'] = ["id" => $order['id'], "customer_id" => $order['customer_id'], "customer_name" => $order['customer_name'],"order_type" =>  $order['order_type'],"coupon" =>  $order['coupon'],"coupon_discount" =>  $order['coupon_discount'],"order_time" =>  $order['order_time'],"sub_total"=>$order['sub_total'],"discount"=>$order['discount'],"amount" =>  $order['amount'],"delivery_charge" =>  $order['delivery_charge'], "delivery_phone" =>  $order['delivery_phone'], "delivery_email" =>  $order['delivery_email'],"delivery_postcode" =>  $order['delivery_postcode'], "delivery_address" =>  $order['delivery_address'], "delivery_time" =>  $order['delivery_time'], "other_info" =>  $order['other_info'],"pre_order" =>  $order['pre_order'],"tableno" =>  $order['tableno'], "payment_method" =>  $order['paymethod'], "payment_status" =>  $order['payment_status'],"status" =>  $order['status']];
              if(!isset($order_data['items'][$order['item_id']]))
                $order_data['items'][$order['item_id']] = ["item_id"=>$order['item_id'],"name" => $order['name'], "quantity" =>  $order['quantity'],"price"=>  $order['price'],"other"=>$order['other']];

              $order_data['items'][$order['item_id']]['addon'][] = ["ad_name" => $order['addon_name'], "ad_qty" =>  $order['addon_qty'],"ad_price" => $order['addon_price']];   
        }   

        //dd($order_data);


        return view('order.view',["data"=>$order_data,"restaurant"=>$restaurant]);
        
       // DB::raw('group_concat(addon_categories.name) as addon_category')
    }
    public function changestatus($id,$status)
    {
        Orders::find($id)->update(['status' => $status]);
        return redirect()->back()->with('success', 'Order Updated successfully.');
    }
    public function export(Request $request)
    {
       $fileName = 'orders.csv';
      
       $orders = Orders::latest();
       if($request->filled('from'))
               $orders->whereDate('order_time', '>=', $request->from);
       if($request->filled('to'))
               $orders->whereDate('order_time', '<=', $request->to);

       if ($request->filled('delivery_type')) {
           $orders->where('order_type', $request->delivery_type);
       }
       if ($request->filled('status')) {
           if($request->status == 10)// card not paid
               $orders->where('payment_method', 1);
           else
               $orders->where('status', $request->status);           
       }
       if ($request->filled('payment_type')) {
           $orders->where('payment_method', $request->payment_type);
       }
       if ($request->filled('pincode')) {
           $orders->where('delivery_postcode', $request->pincode);
       }
      if($request->status == 10) // card not paid
           $orders->where('payment_status',0);
      else
           $orders->where('payment_status',1);

       $orders =$orders->get();




            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );
    
            $columns = array('Order No','Customer', 'Order Type', 'Order Time','Payment Method', 'Amount', 'Status');
            $payment_methods =  array(1=>'Card',2=>'Cash');
            $status = array(1=>'Pending',2=>'Accepted',3=>'Delivered',4=>'Rejected',10=>'Card not Paid',5=>'Refund');

            $callback = function() use($orders, $columns,$payment_methods,$status) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                foreach ($orders as $order) {
                    $row['Order No']  = $order->id;
                    $row['Customer']  = $order->customer_name;
                    $row['Order Type']    = $order->order_type;
                    $row['Order Time']    = $order->order_time;
                    $row['Payment Method']    = $payment_methods[$order->payment_method];
                    $row['Amount']  = $order->amount;
                    $row['Status']  = $status[$order->status];
    
                    fputcsv($file, array( $row['Order No'],$row['Customer'], $row['Order Type'], $row['Order Time'], $row['Payment Method'], $row['Amount'], $row['Status']));
                }
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
        }
        public function paynoworders(Request $request)
        {

            $order_type = "paynow";
            $orders = PaynowOrders::sortable();
        
            if($request->filled('from'))
                    $orders->whereDate('order_time', '>=', $request->from);
            if($request->filled('to'))
                    $orders->whereDate('order_time', '<=', $request->to);
    
           
            if ($request->filled('status')) {
                if($request->status == 10)// card not paid
                    $orders->where('payment_method', 1);
                else
                    $orders->where('status', $request->status);           
            }
            if ($request->filled('payment_type')) {
                $orders->where('payment_method', $request->payment_type);
            }
          
           if($request->status == 10) // card not paid
                $orders->where('payment_status',0);
           else
                $orders->where('payment_status',1);
           
                $data =$orders->latest()->paginate(8);
    
            return view('order.paynowlist',compact('data','order_type'));
        }  
    public function paynowview($id)
    {
        $data  = PaynowOrders::find($id);
        return view('order.paynowview',["data"=>$data]);
      
    }  
}
