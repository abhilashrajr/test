<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\Settings;
use App\Models\Orders;
use App\Models\Bookings;
use App\Models\Member;
use App\Models\OrderItems;
use App\Models\PaynowOrders;
use App\Models\Voucher;
use App\Models\VoucherOrders;
use App\Models\Email;

class MerchantController extends Controller
{
    //check payment_status
	
    public function merlogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' =>'required'
        ]);
	   $merchant = new Merchant;
	   $result = $merchant->doLogin($request->username,$request->password);
	   if($result){
		  $restaurant = Settings::first();
            $data = array('restaurant_name'=>$restaurant->name,'restaurant_phone'=>$restaurant->contact_no,'address'=>$restaurant->address.",".$restaurant->postcode,'username'=>$request->username);
            $result  = array('status'=>'success','data'=>array($data));
	   }else{
            $result = array('status'=>'error');
        }  

        return response()->json($result);

	}

	public function pendings()
    {

        $data = Orders::where('status',1)->where('payment_status',1)->where(function($query) {
										$query->where('order_type', 'collection')
										->orWhere('order_type', 'delivery');
								})->whereDate('order_time', '=', date("Y-m-d"))->get();
        if($data->isEmpty())
            $result = array('value'=>'0');
        else
            $result = array('value'=>'1');

        return response()->json($result);    
    }
  
   public function merpending()
	{
		$member = Member::first();
          $orders = Orders::where('status',1)->where('payment_status',1)->where(function($query) {
											$query->where('order_type', 'collection')
											->orWhere('order_type', 'delivery');
									})->whereDate('order_time', '=', date("Y-m-d"))->get();	  
         if(!$orders->isEmpty()){	   
			foreach($orders as $order){
				$data[] = array("orderid"=>$order->id,"ordertime"=>$order->order_time,"memberid"=>$member->id,"firstname"=>$order->customer_name,"lastname"=>"","total" =>$order->amount,"status"=>$this->__appStatus($order->status));
			}
			$result  = array('status'=>'success','data'=>$data);
         }else{
            $result = array('status'=>'error');
         }  
        return response()->json($result);    

	}
	
    public function merallorders()
	{
		$member = Member::first();
       	$orders = Orders::where('payment_status',1)->where(function($query) {
								$query->where('order_type', 'collection')
								->orWhere('order_type', 'delivery');
						})->orderBy('id', 'desc')->limit(100)->get();
		
		if(!$orders->isEmpty()){
			foreach($orders as $order){
				$data[] = array("orderid"=>$order->id,"ordertime"=>$order->order_time,"memberid"=>$member->id,"firstname"=>$order->customer_name,"lastname"=>"","total" =>$order->amount,"status"=>$this->__appStatus($order->status));
			}
			$result  = array('status'=>'success','data'=>$data);
		}else{
			$result = array('status'=>'no order');
		}  
		return response()->json($result);

	}
	/*
    public function merorderdetails(Request $request)
	{
		$orderId  = $request->orderid;
		$member = Member::first();
		$restaurant = Settings::first();
		$rejectStatus = 1; //c
		$qrStatus = 0;//c
		$qrURL  =  $qrStatus == 1 ? $restaurant->qr_url : "";//c
		$order = Orders::find($orderId);
		if(!empty($order)){
			$payment_method = "";
			if($order->payment_method ==1)
				$payment_method = "Card Payment Method";
			if($order->payment_method ==2)	
				$payment_method = "cashondelivery";

		    $data = array("orderid"=>$order->id,"ordertime"=>$order->order_time,"transtype"=>$order->order_type,"payment_type"=>$payment_method,"memberid"=>$member->id,"firstname"=>$order->customer_name,"lastname"=>"","address"=>$member->address1,"postcode"=>$member->postcode,"contactno"=>$member->contactno,"email"=>$member->email,"subtotal"=>$order->amount,"discount"=>0,"total"=>$order->amount,"grandtotal" =>$order->amount,"status"=>$this->__appStatus($order->status),"instruction"=>$order->other_info,"deliveryfee"=>$order->delivery_charge,"tableno"=>0,"preorder"=>$order->pre_order,"deliverytime"=>$order->delivery_time,'qurl'=>$qrURL,'reject'=>$rejectStatus);          
		    $OrderItems = OrderItems::where('order_id',$orderId)->get();
		  
		    foreach($OrderItems as $menu){
			   
			   $details[] = array("quantity"=>$menu->quantity,"amount"=>$menu->price,"item"=>htmlspecialchars_decode($menu->name));
		    }    
		    $result = array('status'=>'success','data'=>$data,'details'=>$details);     
		}else{
			  $result = array('status'=>'no order');
		  }
  
		return response()->json($result);
	}
*/
public function merorderdetails(Request $request)
	{
		$orderId  = $request->orderid;
		$member = Member::first();
		$restaurant = Settings::first();
		$rejectStatus = $restaurant->reject_order; 
		$qrStatus = 0;//c
		$qrURL  =  $qrStatus == 1 ? $restaurant->qr_url : "";//c

		$data =  Orders::select('orders.*','order_items.id as item_id','order_items.name','order_items.quantity','order_items.price','order_items.other','addon_items.name as addon_name','addon_items.price as addon_price','order_addons.addon_qty as addon_qty')//,'addon_items.name'
					->Join('order_items', 'order_items.order_id', '=', 'orders.id')
					->leftJoin('order_addons', 'order_addons.order_items_id', '=', 'order_items.id')
					->leftJoin('addon_items', 'addon_items.id', '=', 'order_addons.addon_items_id')
					->where('orders.id',$orderId)
					->get()->toArray();
		$order_data = Array();
		foreach($data as $order){
			if(!isset($order_data['details']))
				$order_data['details'] = ["id" => $order['id'], "customer_id" => $order['customer_id'], "customer_name" => $order['customer_name'],"order_type" =>  $order['order_type'],"order_time" =>  $order['order_time'],"amount" =>  $order['amount'],"delivery_charge" =>  $order['delivery_charge'], "delivery_phone" =>  $order['delivery_phone'], "delivery_email" =>  $order['delivery_email'],"delivery_postcode" =>  $order['delivery_postcode'], "delivery_address" =>  $order['delivery_address'], "delivery_time" =>  $order['delivery_time'], "other_info" =>  $order['other_info'],"sub_total"=>$order['sub_total'],"discount"=>$order['discount'],"total"=>$order['amount'],"pre_order" =>  $order['pre_order'],"payment_method" =>  $order['payment_method'], "payment_status" =>  $order['payment_status'],"status" =>  $order['status']];
			if(!isset($order_data['items'][$order['item_id']]))
				$order_data['items'][$order['item_id']] = ["item_id"=>$order['item_id'],"name" => $order['name'], "quantity" =>  $order['quantity'],"price"=>  $order['price'],"other"=>$order['other']];

			$order_data['items'][$order['item_id']]['addon'][] = ["ad_name" => $order['addon_name'], "ad_qty" =>  $order['addon_qty'],"ad_price" => $order['addon_price']];   
		}   
		$order = $order_data;
		if(!empty($order)){
			$payment_method = "";
			if($order['details']['payment_method'] ==1)
				$payment_method = "Card Payment Method";
			if($order['details']['payment_method']  ==2)	
				$payment_method = "cashondelivery";

		    $data = array("orderid"=>$order['details']['id'],"ordertime"=>$order['details']['order_time'],"transtype"=>$order['details']['order_type'],"payment_type"=>$payment_method,"memberid"=>$member->id,"firstname"=>$order['details']['customer_name'],"lastname"=>"","address"=>$order['details']['delivery_address'],"postcode"=>$order['details']['delivery_postcode'],"contactno"=>$order['details']['delivery_phone'],"email"=>$order['details']['delivery_email'],"subtotal"=>$order['details']['sub_total'],"discount"=>$order['details']['discount'],"total"=>round($order['details']['sub_total']-$order['details']['discount'],2),"grandtotal" =>$order['details']['amount'],"status"=>$this->__appStatus($order['details']['status']),"instruction"=>$order['details']['other_info'],"deliveryfee"=>$order['details']['delivery_charge'],"tableno"=>0,"preorder"=>$order['details']['pre_order'],"deliverytime"=>$order['details']['delivery_time'],'qurl'=>$qrURL,'reject'=>$rejectStatus);          
		  
		    foreach($order_data['items'] as $menu){
				$addons = "";
				if(!empty($menu['addon'][0]['ad_name'])){		
					foreach($menu['addon'] as $addon){	 
							$addons .= $addon['ad_name']."(".$addon['ad_qty'].")"."(".$addon['ad_price'].") , ";
					}
					if(!empty($menu['other']))
						$addons .=  "  ".$menu['other'];
					else
						$addons = rtrim($addons, ", ");

					$addons = " - ".$addons; 
				}else  if(!empty($menu['other'])){
					$addons = " - ".$menu['other'];
				}
						
			   $details[] = array("quantity"=>$menu['quantity'],"amount"=>$menu['price'],"item"=>htmlspecialchars_decode($menu['name'].$addons));
		    } 
		    $result = array('status'=>'success','data'=>$data,'details'=>$details);     
		}else{
			  $result = array('status'=>'no order');
		  }
 		return response()->json($result);
	}
   public function meraccept(Request $request)
    {
        $restaurant = Settings::first();

        $orderId  = $request->orderid;
        $time = $request->time;

        $order = Orders::find($orderId);
        //if(empty($order))
        $orderTime = $order->order_time;
        $order_type = $order->order_type;
        $preOrder = $order->pre_order;
        if(!$preOrder){
            $oTime = date("H:i:s",strtotime($orderTime));
            $deliveryTime = date( "Y-m-d H:i:s", strtotime($oTime)+($time*60));
            $order->status = 2;
            $order->delivery_time =  $deliveryTime;
        }else{
            $order->status = 2;
        }
        if($order->save()){

            $postData = ['orderid' => $orderId,'mode'=>1,'restid' => $restaurant->erp_id];
		 
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"https://erp.ijoo.co.uk/index.php/admin/getcall");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            $response = curl_exec($ch);
            curl_close($ch);
		  
            return response()->json(['status'=>'success']);
        }else{
            return response()->json(['status'=>'error']);
        }    
    
	}


    public function meraccepts(Request $request)
	{
		$restaurant = Settings::first();
	     $orderId  = $request->orderid;
    		$order = Orders::find($orderId);
		if(!empty($order)){
			$orderTime = $order->order_time;
			$order_type = $order->order_type;
			$preOrder = $order->pre_order;
			
			if(!$preOrder){
				$oTime = date("H:i:s",strtotime($orderTime));
				$deliveryTime = date( "Y-m-d H:i:s", strtotime($oTime)+(20*60));
				$order->status = 2;
				$order->delivery_time =  $deliveryTime;
			 }else{
				$order->status = 2;
			 }
			 if($order->save()){
				$postData = ['orderid' => $orderId,'mode'=>1,'restid' => $restaurant->erp_id];
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,"https://erp.ijoo.co.uk/index.php/admin/getcall");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
				$response = curl_exec($ch);
				curl_close($ch);
				
				return response()->json(['status'=>'success']);
			 }else{
				return response()->json(['status'=>'error']);
			 }    
		}
	
	}
	public function merreject(Request $request)
	{
		$orderId = $request->orderid;
		$order = Orders::find($orderId);

		$orderTime = $order->order_time;
		$order_type = $order->order_type;
		$preOrder = $order->pre_order;
		$order->status = 4;
		if($order->save()){

			$restaurant = Settings::first();
			$post = [
				'orderid' => $orderId,
				'mode'=>1,
				'restid' => $restaurant->erp_id,
				];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://erp.ijoo.co.uk/index.php/admin/orderreject");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);			
			// execute!
			$response = curl_exec($ch);			
			// close the connection, release resources used
			curl_close($ch);
			
			$result = array('status'=>'success');    
		}else{
			$result = array('status'=>'error');
		}
		return response()->json($result);
	}
    public function merbookaccept(Request $request)
	{
		$restaurant = Settings::first();
		$bookingId  = $request->bookid;
		$booking = Bookings::find($bookingId);
		$booking->status = 2;
		if($booking->save()){

			$bDate = $booking->date;
			$bTime = $booking->time;
			$bMobile = $booking->phone;

			$bMsg = "Dear customer , Your Booking(".$bTime."  ".date("d-m-Y", strtotime($bDate)).") is Confirmed. Booking id ".$bookingId.",".$restaurant->name ;
			Merchant::sendSMS($bMobile,$bMsg);

			$to =  $booking->email;
			$cname = $booking->name;
			$subject = "Booking Confirmed";
			$logo = url('storage/images/'.$restaurant->logo);
			$rests = $restaurant->name;
			$bid = $booking->id;
			$rmail =  $restaurant->email;
			$cnumber = $restaurant->contact_no;
			$html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"/><meta content="width=device-width" name="viewport"/><meta content="IE=edge" http-equiv="X-UA-Compatible"/><title></title><style type="text/css">body {margin: 0;padding: 0;}table,td,tr {vertical-align: top;border-collapse: collapse;}* {line-height: inherit;}a[x-apple-data-detectors=true] {color: inherit !important;text-decoration: none !important;}</style><style id="media-query" type="text/css">@media (max-width: 520px) {.block-grid,.col {min-width: 320px !important;max-width: 100% !important;display: block !important;}.block-grid {width: 100% !important;}.col {width: 100% !important;}.col_cont {margin: 0 auto;}img.fullwidth,img.fullwidthOnMobile {max-width: 100% !important;}.no-stack .col {min-width: 0 !important;display: table-cell !important;}.no-stack.two-up .col {width: 50% !important;}.no-stack .col.num2 {width: 16.6% !important;}.no-stack .col.num3 {width: 25% !important;}.no-stack .col.num4 {width: 33% !important;}.no-stack .col.num5 {width: 41.6% !important;}.no-stack .col.num6 {width: 50% !important;}.no-stack .col.num7 {width: 58.3% !important;}.no-stack .col.num8 {width: 66.6% !important;}.no-stack .col.num9 {width: 75% !important;}.no-stack .col.num10 {width: 83.3% !important;}.video-block {max-width: none !important;}.mobile_hide {min-height: 0px;max-height: 0px;max-width: 0px;display: none;overflow: hidden;font-size: 0px;}.desktop_hide {display: block !important;max-height: none !important;}}</style><style id="icon-media-query" type="text/css">@media (max-width: 520px) {.icons-inner {text-align: center;}.icons-inner td {margin: 0 auto;}}</style></head><body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #32b8ba;"><table bgcolor="#32b8ba" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #32b8ba; width: 100%;" valign="top" width="100%"><tbody><tr style="vertical-align: top;" valign="top"><td style="word-break: break-word; vertical-align: top;" valign="top"><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div align="center" class="img-container center autowidth" style="padding-right: 0px;padding-left: 0px;"><img align="center" border="0" class="center autowidth" src="'.$logo.'" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 150px; display: block;" width="150"/></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 22px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 26px; margin-top: 0; margin-bottom: 0;"><span style="font-size: 18px;"><strong>Booking ID #'.$book_id.'<br/>BOOKING STATUS : NOT ACCEPTED</strong></span></p></div></div></div></div></div></div></div></div><div><div class="block-grid mixed-two-up" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num3" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 123px; width: 125px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px; text-align: center; width: 100%;" valign="top" width="100%"><h1 style="color:#ffffff;direction:ltr;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:23px;font-weight:normal;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><strong>'.$rests.'</strong></h1></td></tr></table></div></div></div><div class="col num9" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 369px; width: 375px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Dear Customer,</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Your Booking('.$btime.'  '.$bdates.') is  confirmed. Your Booking id '.$bid.'<br/></h3></p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;"> </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">For Further Details</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">please Contact: '.$rmail.'</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Or Call '.$cnumber.' </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-top: 5px; padding-right: 0px; padding-bottom: 5px; padding-left: 0px; text-align: center;" valign="top"><table cellpadding="0" cellspacing="0" class="icons-inner" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;" valign="top"><tr style="vertical-align: top;" valign="top"></tr></table></td></tr></table></div></div></div></div></div></div></td></tr></tbody></table></body></html>';
			Email::send($to, $rests,$cname,$subject,$html);


			$erpId = $restaurant->erp_id;
			$post = ['orderid' => $bookingId,'mode'=>3,'restid' => $restaurant->erp_id];
			$chw = curl_init();
			curl_setopt($chw, CURLOPT_URL,"https://erp.ijoo.co.uk/index.php/admin/getcall");
			curl_setopt($chw, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($chw, CURLOPT_POSTFIELDS, $post);
			$response = curl_exec($chw);
			// close the connection, release resources used
			curl_close($chw);

			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}    

	
	}

    public function merbookrejects(Request $request)
	{
		$restaurant = Settings::first();
		$bookingId  = $request->bookid;
		$booking = Bookings::find($bookingId);
		$booking->status = 3;
		if($booking->save()){
			$bDate = $booking->date;
			$bTime = $booking->time;
			$bMobile = $booking->phone;

			$bMsg="Dear customer, Your Booking(".$bTime."  ".date("d-m-Y", strtotime($bDate)).") is not confirmed as we are fully booked. Booking id ".$bookingId.",".$restaurant->name ;
			Merchant::sendSMS($bMobile,$bMsg); 


			$to =  $booking->email;
			$cname = $booking->name;
			$subject = "Booking Rejected";
			$logo = url('storage/images/'.$restaurant->logo);
			$rests = $restaurant->name;
			$rmail =  $restaurant->email;
			$cnumber = $restaurant->contact_no;
			$html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"/><meta content="width=device-width" name="viewport"/><meta content="IE=edge" http-equiv="X-UA-Compatible"/><title></title><style type="text/css">body {margin: 0;padding: 0;}table,td,tr {vertical-align: top;border-collapse: collapse;}* {line-height: inherit;}a[x-apple-data-detectors=true] {color: inherit !important;text-decoration: none !important;}</style><style id="media-query" type="text/css">@media (max-width: 520px) {.block-grid,.col {min-width: 320px !important;max-width: 100% !important;display: block !important;}.block-grid {width: 100% !important;}.col {width: 100% !important;}.col_cont {margin: 0 auto;}img.fullwidth,img.fullwidthOnMobile {max-width: 100% !important;}.no-stack .col {min-width: 0 !important;display: table-cell !important;}.no-stack.two-up .col {width: 50% !important;}.no-stack .col.num2 {width: 16.6% !important;}.no-stack .col.num3 {width: 25% !important;}.no-stack .col.num4 {width: 33% !important;}.no-stack .col.num5 {width: 41.6% !important;}.no-stack .col.num6 {width: 50% !important;}.no-stack .col.num7 {width: 58.3% !important;}.no-stack .col.num8 {width: 66.6% !important;}.no-stack .col.num9 {width: 75% !important;}.no-stack .col.num10 {width: 83.3% !important;}.video-block {max-width: none !important;}.mobile_hide {min-height: 0px;max-height: 0px;max-width: 0px;display: none;overflow: hidden;font-size: 0px;}.desktop_hide {display: block !important;max-height: none !important;}}</style><style id="icon-media-query" type="text/css">@media (max-width: 520px) {.icons-inner {text-align: center;}.icons-inner td {margin: 0 auto;}}</style></head><body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #32b8ba;"><table bgcolor="#32b8ba" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #32b8ba; width: 100%;" valign="top" width="100%"><tbody><tr style="vertical-align: top;" valign="top"><td style="word-break: break-word; vertical-align: top;" valign="top"><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div align="center" class="img-container center autowidth" style="padding-right: 0px;padding-left: 0px;"><img align="center" border="0" class="center autowidth" src="'.$logo.'" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 150px; display: block;" width="150"/></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 22px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 26px; margin-top: 0; margin-bottom: 0;"><span style="font-size: 18px;"><strong>Booking ID #'.$book_id.'<br/>BOOKING STATUS : NOT ACCEPTED</strong></span></p></div></div></div></div></div></div></div></div><div><div class="block-grid mixed-two-up" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num3" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 123px; width: 125px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px; text-align: center; width: 100%;" valign="top" width="100%"><h1 style="color:#ffffff;direction:ltr;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:23px;font-weight:normal;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><strong>'.$rests.'</strong></h1></td></tr></table></div></div></div><div class="col num9" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 369px; width: 375px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Dear Customer,</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Your Booking('.$btime.'  '.$bdates.') is  confirmed as we are fully booked.<br/></h3></p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;"> </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">For Further Details</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">please Contact: '.$rmail.'</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Or Call '.$cnumber.' </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-top: 5px; padding-right: 0px; padding-bottom: 5px; padding-left: 0px; text-align: center;" valign="top"><table cellpadding="0" cellspacing="0" class="icons-inner" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;" valign="top"><tr style="vertical-align: top;" valign="top"></tr></table></td></tr></table></div></div></div></div></div></div></td></tr></tbody></table></body></html>';
			Email::send($to, $rests,$cname,$subject,$html);



			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}    

    }
    public function merpendingbooking()
	{

		$bookings = Bookings::where('status',1)->orderBy('id', 'desc')->limit(100)->get();
		if(!$bookings->isEmpty()){
			foreach($bookings as $booking){
				$data[] = array("booking_id"=>$booking->id,"number_guest"=>$booking->guests,"date_booking"=>$booking->date,"booking_time"=>$booking->time,"booking_name"=>$booking->name,"status"=>$this->__appBookingStatus($booking->status),"book_type"=>($booking->type==2 ? 'Special' : 'Normal'));
			}
			$result = array('status'=>'success','data'=>$data);     
		}else{
		 	$result = array('status'=>'error');
	 	 }

		return response()->json($result);

	}

     public function merallbooking()
	{
		$bookings = Bookings::orderBy('id', 'desc')->limit(100)->get(); //c
		if(!$bookings->isEmpty()){
			foreach($bookings as $booking){
				$data[] = array("booking_id"=>$booking->id,"number_guest"=>$booking->guests,"date_booking"=>$booking->date,"booking_time"=>$booking->time,"booking_name"=>$booking->name,"status"=>$this->__appBookingStatus($booking->status),"book_type"=>($booking->type==2 ? 'Special' : 'Normal'));
			}
			$result = array('status'=>'success','data'=>$data);     
		}else{
		 	$result = array('status'=>'error');
	 	}
		return response()->json($result);

	}

     public function merbookdetails(Request $request)
	{
		$bookingId = $request->bookid;
		$booking = Bookings::find($bookingId); 
		if(!empty($booking)){
			$data[]=array("booking_id"=>$booking->id,"number_guest"=>$booking->guests,"date_booking"=>$booking->date,"booking_time"=>$booking->time,"coupon_status"=>"0","booking_name"=>$booking->name,"email"=>"","mobile"=>$booking->phone,"booking_notes"=>$booking->message,"coupon_count"=>"0","coupon_name"=>NULL,"total"=>"","date_created"=>date('Y-m-d H:i:s', strtotime($booking->created_at)),"status"=>$this->__appBookingStatus($booking->status),"book_type"=>($booking->type==2 ? 'Special' : 'Normal'));
			$result = array('status'=>'success','data'=>$data);    
		}else{
			$result = array('status'=>'error');
		}
		return response()->json($result);

	}
	
	public function merreport()
	{
		$query = Orders::select('payment_method',\DB::raw("IFNULL(SUM(amount),0) as revenue"),\DB::raw("IFNULL(COUNT(id),0) as total"))->where('status','=',2);
		
		$summary = $query->where(function($query) {
								$query->where('order_type', 'collection')
								->orWhere('order_type', 'delivery');
						})->groupby('payment_method')->orderBy('payment_method', 'asc')->get();

		$cash_orders = $card_orders = $cash_revenue = $card_revenue = 0;
		if($summary){
			foreach($summary as $item){
				if($item->payment_method == 1){
					$card_orders = $item->total;
					$card_revenue = $item->revenue;
				}
				if($item->payment_method == 2){
					$cash_orders = $item->total;
					$cash_revenue = $item->revenue;
				}
			}

		}

		$result = array('status'=>'success','data'=>array('totalcashorders'=> (string)$cash_orders ,'totalcardorders'=> (string)$card_orders ,'totalorders'=> (string)($cash_orders+$card_orders),'totalcash'=> round($cash_revenue,2),'totalcard'=> round($card_revenue,2),'totalamount'=> round( ($cash_revenue+$card_revenue),2)));
		return response()->json($result);

	}

     public function merdeid(Request $request)
	{
		$device_id  = $request->id;
		if(empty($device_id)){
			$result = array('status'=>'error');
		}else{
			$merchant = Member::first();
			$merchant->device_id = $device_id;
			$merchant->d_id_modified_at = date("Y-m-d H:i:s");
			$merchant->save();
			$result = array('status'=>'success');
		}
		return response()->json($result);

	}

	function dpendings()
	{
		$data = Orders::where('status',1)->where('payment_status',1)->where('order_type','dinein')->whereDate('order_time', '=', date("Y-m-d"))->get();
		if($data->isEmpty())
		    $result = array('value'=>'0');
		else
		    $result = array('value'=>'1');
  
		return response()->json($result);   
	}
 
	function ppendings()
	{
		$data = PaynowOrders::where('status',1)->where('payment_status',1)->whereDate('order_time', '=', date("Y-m-d"))->get();
		if($data->isEmpty())
		    $result = array('value'=>'0');
		else
		    $result = array('value'=>'1');
		return response()->json($result);
	}

	function merdpending()
	{
		$member = Member::first();
          $orders = Orders::where('status',1)->where('payment_status',1)->where('order_type','dinein')->whereDate('order_time', '=', date("Y-m-d"))->get();	  
         if(!$orders->isEmpty()){	   
			foreach($orders as $order){
				$data[] = array("orderid"=>$order->id,"ordertime"=>$order->order_time,"memberid"=>$member->id,"firstname"=>$order->customer_name,"lastname"=>"","total" =>$order->amount,"status"=>$this->__appStatus($order->status));
			}
			$result  = array('status'=>'success','data'=>$data);
         }else{
            $result = array('status'=>'error');
         }  
        return response()->json($result); 

	}
	function merdallorders()
	{
		$member = Member::first();
		$orders = Orders::where('order_type','dinein')->where('payment_status',1)->orderBy('id', 'desc')->limit(100)->get();
	   
	   if(!$orders->isEmpty()){
		   foreach($orders as $order){
			   $data[] = array("orderid"=>$order->id,"ordertime"=>$order->order_time,"memberid"=>$member->id,"firstname"=>$order->customer_name,"lastname"=>"","total" =>$order->amount,"status"=>$this->__appStatus($order->status));
		   }
		   $result  = array('status'=>'success','data'=>$data);
	   }else{
		   $result = array('status'=>'no order');
	   }  
	   return response()->json($result);
	}
	function merpallorders()
	{
		$member = Member::first();
		$orders = PaynowOrders::where('payment_status',1)->orderBy('id', 'desc')->limit(100)->get();
	   
	   if(!$orders->isEmpty()){
		   foreach($orders as $order){
			   $data[] = array("orderid"=>$order->id,"ordertime"=>$order->order_time,"memberid"=>$member->id,"firstname"=>$order->customer_name,"lastname"=>"","total" =>$order->total_amount,"status"=>$this->__appStatus($order->status));
		   }
		   $result  = array('status'=>'success','data'=>$data);
	   }else{
		   $result = array('status'=>'no order');
	   }  
	   return response()->json($result);
	}
	function merdorderdetails(Request $request)
	{
		$orderId  = $request->orderid;
		$member = Member::first();
		$data =  Orders::select('orders.*','order_items.id as item_id','order_items.name','order_items.quantity','order_items.price','order_items.other','addon_items.name as addon_name','addon_items.price as addon_price','order_addons.addon_qty as addon_qty')//,'addon_items.name'
					->Join('order_items', 'order_items.order_id', '=', 'orders.id')
					->leftJoin('order_addons', 'order_addons.order_items_id', '=', 'order_items.id')
					->leftJoin('addon_items', 'addon_items.id', '=', 'order_addons.addon_items_id')
					->where('orders.id',$orderId)
					->get()->toArray();
		$order_data = Array();
		foreach($data as $order){
			if(!isset($order_data['details']))
				$order_data['details'] = ["id" => $order['id'], "customer_id" => $order['customer_id'], "customer_name" => $order['customer_name'],"order_type" =>  $order['order_type'],"order_time" =>  $order['order_time'],"amount" =>  $order['amount'],"tableno" =>  $order['tableno'], "other_info" =>  $order['other_info'],"total"=>$order['amount'],"payment_method" =>  $order['payment_method'], "payment_status" =>  $order['payment_status'],"status" =>  $order['status']];
			if(!isset($order_data['items'][$order['item_id']]))
				$order_data['items'][$order['item_id']] = ["item_id"=>$order['item_id'],"name" => $order['name'], "quantity" =>  $order['quantity'],"price"=>  $order['price'],"other"=>$order['other']];

			$order_data['items'][$order['item_id']]['addon'][] = ["ad_name" => $order['addon_name'], "ad_qty" =>  $order['addon_qty'],"ad_price" => $order['addon_price']];   
		}   
		$order = $order_data;
		if(!empty($order)){
			$payment_method = "";
			if($order['details']['payment_method'] ==1)
				$payment_method = "Card Payment Method";
			if($order['details']['payment_method']  ==2)	
				$payment_method = "cashondelivery";

		    $data = array("orderid"=>$order['details']['id'],"ordertime"=>$order['details']['order_time'],"transtype"=>$order['details']['order_type'],"payment_type"=>$payment_method,"memberid"=>$member->id,"firstname"=>$order['details']['customer_name'],"total"=>round($order['details']['amount'],2),"grandtotal" =>$order['details']['amount'],"status"=>$this->__appStatus($order['details']['status']),"instruction"=>$order['details']['other_info'],"tableno"=>$order['details']['tableno']);          
		    //$arrays= array("orderid"=>$row->d_orderid,"ordertime"=>$row->ordertime,"transtype"=>$row->deliverytype,"payment_type"=>$row->modeofpay,"memberid"=>$row->d_memberid,"firstname"=>$row->firstname,"total" =>$row->total,"status"=>$row->status,"instruction"=>$row->misc,"tableno"=>$row->dinein_table_number);
		    foreach($order_data['items'] as $menu){
				$addons = "";
				if(!empty($menu['addon'][0]['ad_name'])){		
					foreach($menu['addon'] as $addon){	 
							$addons .= $addon['ad_name']."(".$addon['ad_qty'].")"."(".$addon['ad_price'].") , ";
					}
					if(!empty($menu['other']))
						$addons .=  "  ".$menu['other'];
					else
						$addons = rtrim($addons, ", ");

					$addons = " - ".$addons; 
				}else  if(!empty($menu['other'])){
					$addons = " - ".$menu['other'];
				}
						
			   $details[] = array("quantity"=>$menu['quantity'],"amount"=>$menu['price'],"item"=>htmlspecialchars_decode($menu['name'].$addons));
		    } 
		    $result = array('status'=>'success','data'=>$data,'details'=>$details);     
		}else{
			  $result = array('status'=>'no order');
		  }
 		return response()->json($result);
	}

	function merporderdetails(Request $request)
	{
		$orderId  = $request->orderid;
		$order = PaynowOrders::find($orderId);
		$member = Member::first();
		if($order){
			$payment_method = "";
			if($order->payment_method ==1)
				$payment_method = "Card Payment Method";
			if($order->payment_method  ==2)	
				$payment_method = "cashondelivery";
			$data= array("orderid"=>$order->id,"ordertime"=>$order->order_time,"transtype"=>"Pay Now","payment_type"=>$payment_method,"memberid"=>$member->id,"firstname"=>$order->customer_name,"total" =>$order->total_amount,"status"=>$this->__appStatus($order->status),"instruction"=>"","tableno"=>$order->tableno,"drinksamount"=>$order->drinks_amount,"foodamount"=>$order->food_amount,"drinkstotal"=>$order->drinks_total,"foodtotal"=>$order->food_total,"discount"=>"");
			$result = array('status'=>'success','data'=>$data,);  
		}else{
			$result = array('status'=>'no order');
		}
	    return response()->json($result);
	}
	function merdaccept(Request $request)
	{
		$restaurant = Settings::first();
		$orderId  = $request->orderid;
	 	$order = Orders::find($orderId);
		$orderTime = $order->order_time;
		$order_type = $order->order_type;
		$oTime = date("H:i:s",strtotime($orderTime));
		$deliveryTime = date("Y-m-d H:i:s", strtotime($oTime)+(20*60));
		$order->status = 2;
		$order->delivery_time =  $deliveryTime;
		if($order->save()){
 		    $postData = ['orderid' => $orderId,'mode'=>2,'restid' => $restaurant->erp_id];
		    
		    $ch = curl_init();
		 	 curl_setopt($ch, CURLOPT_URL,"https://erp.ijoo.co.uk/index.php/admin/getcall");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		    $response = curl_exec($ch);
		    curl_close($ch);
		   
		    return response()->json(['status'=>'success']);
		}else{
		    return response()->json(['status'=>'error']);
		}    
	}
	function merpaccept(Request $request)
	{
		$restaurant = Settings::first();
		$orderId  = $request->orderid;
		$order = PaynowOrders::find($orderId);
		$orderTime = $order->order_time;
		$order_type = $order->order_type;

		$oTime = date("H:i:s",strtotime($orderTime));
		$deliveryTime = date("Y-m-d H:i:s", strtotime($oTime)+(20*60));
		$order->status = 2;
	//	$order->delivery_time =  $deliveryTime;  enable later
		if($order->save()){
 		    $postData = ['orderid' => $orderId,'mode'=>2,'restid' => $restaurant->erp_id];
 
		    $ch = curl_init();
		 	curl_setopt($ch, CURLOPT_URL,"https://erp.ijoo.co.uk/index.php/admin/getcall");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		    $response = curl_exec($ch);
		    curl_close($ch);
		   
		    return response()->json(['status'=>'success']);
		}else{
		    return response()->json(['status'=>'error']);
		}    
	}

	function merpendingvoucher()
	{
		$vouchers = VoucherOrders::where('status',1)->where('payment_status',1)->latest()->get();
		if($vouchers->isEmpty()){
			return response()->json(['status'=>'error']);
		}else{
			foreach($vouchers as $voucher){
				$data[] = array("booking_id"=> $voucher->id,"date_created"=>$voucher->order_time,"booking_name"=>$voucher->customer_name,"status"=>'Pending',"purchasecode "=>$voucher->purchase_code);
			}
			return response()->json(['status'=>'success','data'=>$data]);
		}
	}

	function merallvoucher()
	{
		$vouchers = VoucherOrders::where('payment_status',1)->orderBy('id', 'desc')->limit(100)->get();
	   
		if(!$vouchers->isEmpty()){
			foreach($vouchers as $voucher){
				$data[]=array("booking_id"=>$voucher->id,"date_created"=>$voucher->order_time,"booking_name"=>$voucher->customer_name,"status"=>($voucher->status==1) ? 'Pending' : 'Claimed',"purchasecode "=>$voucher->purchase_code);
			}
			$result  = array('status'=>'success','data'=>$data);
		}else{
			$result = array('status'=>'no order');
		}  
		return response()->json($result);
	}
	function mervoucherdetails(Request $request)
	{
		$vbookId  = $request->bookid;
		$order = VoucherOrders::find($vbookId);
		if(!empty($order)){
			$data[]  = array("booking_id"=>$order->id,"booking_name"=>$order->customer_name,"voucher_id"=>$order->voucher_id,"email"=>$order->email,"mobile"=>$order->phone,"date_created"=>$order->order_time,"date_modified"=>$order->updated_at,"status"=>($order->status==1) ? 'Pending' : 'Claimed',"purchasecode"=>$order->purchase_code);
			$voucher = Voucher::find($order->voucher_id);
			if(!empty($voucher)){
				$data[0]['voucher_name'] = $voucher->name;
				$data[0]['description'] = $voucher->description;
				$data[0]['amount'] = $voucher->price;
			}
			$result  = array('status'=>'success','data'=>$data);
		}else{
			$result = array('status'=>'no order');
		}
		return response()->json($result);
	}
	function mervoucheraccept(Request $request)
	{
		$restaurant = Settings::first();
		$vbookId  = $request->bookid;
		$order = VoucherOrders::find($vbookId);
		$order->status = 2;
		if($order->save()){
			$msg="Dear customer, You have successfully claimed the Voucher with Purchase Code".$order->purchase_code.".Thank You,".$restaurant->name;
			Merchant::sendSMS($order->phone,$msg);

			$to =  $voucher_order->email;
			$cname = $voucher_order->customer_name;
			$subject = "Voucher claimed";
			$logo = url('storage/images/'.$restaurant->logo);
			$rests = $restaurant->name;
			$pcode = $voucher_order->purchase_code;
			$rmail =  $restaurant->email;
			$cnumber = $restaurant->contact_no;
			$html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"/><meta content="width=device-width" name="viewport"/><meta content="IE=edge" http-equiv="X-UA-Compatible"/><title></title><style type="text/css">body {margin: 0;padding: 0;}table,td,tr {vertical-align: top;border-collapse: collapse;}* {line-height: inherit;}a[x-apple-data-detectors=true] {color: inherit !important;text-decoration: none !important;}</style><style id="media-query" type="text/css">@media (max-width: 520px) {.block-grid,.col {min-width: 320px !important;max-width: 100% !important;display: block !important;}.block-grid {width: 100% !important;}.col {width: 100% !important;}.col_cont {margin: 0 auto;}img.fullwidth,img.fullwidthOnMobile {max-width: 100% !important;}.no-stack .col {min-width: 0 !important;display: table-cell !important;}.no-stack.two-up .col {width: 50% !important;}.no-stack .col.num2 {width: 16.6% !important;}.no-stack .col.num3 {width: 25% !important;}.no-stack .col.num4 {width: 33% !important;}.no-stack .col.num5 {width: 41.6% !important;}.no-stack .col.num6 {width: 50% !important;}.no-stack .col.num7 {width: 58.3% !important;}.no-stack .col.num8 {width: 66.6% !important;}.no-stack .col.num9 {width: 75% !important;}.no-stack .col.num10 {width: 83.3% !important;}.video-block {max-width: none !important;}.mobile_hide {min-height: 0px;max-height: 0px;max-width: 0px;display: none;overflow: hidden;font-size: 0px;}.desktop_hide {display: block !important;max-height: none !important;}}</style><style id="icon-media-query" type="text/css">@media (max-width: 520px) {.icons-inner {text-align: center;}.icons-inner td {margin: 0 auto;}}</style></head><body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #32b8ba;"><table bgcolor="#32b8ba" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #32b8ba; width: 100%;" valign="top" width="100%"><tbody><tr style="vertical-align: top;" valign="top"><td style="word-break: break-word; vertical-align: top;" valign="top"><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div align="center" class="img-container center autowidth" style="padding-right: 0px;padding-left: 0px;"><img align="center" border="0" class="center autowidth" src="'.$logo.'" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 150px; display: block;" width="150"/></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 22px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 26px; margin-top: 0; margin-bottom: 0;"><span style="font-size: 18px;"><strong><br/>VOUCHER STATUS : VOUCHER CLAIMED</strong></span></p></div></div></div></div></div></div></div></div><div><div class="block-grid mixed-two-up" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num3" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 123px; width: 125px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px; text-align: center; width: 100%;" valign="top" width="100%"><h1 style="color:#ffffff;direction:ltr;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:23px;font-weight:normal;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><strong>'.$rests.'</strong></h1></td></tr></table></div></div></div><div class="col num9" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 369px; width: 375px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Dear Customer,</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">You successfully claimed the voucher with purchase code : '.$pcode.'<br/></h3></p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;"> </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">For Further Details</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">please Contact: '.$rmail.'</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Or Call '.$cnumber.' </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-top: 5px; padding-right: 0px; padding-bottom: 5px; padding-left: 0px; text-align: center;" valign="top"><table cellpadding="0" cellspacing="0" class="icons-inner" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;" valign="top"><tr style="vertical-align: top;" valign="top"></tr></table></td></tr></table></div></div></div></div></div></div></td></tr></tbody></table></body></html>';
			Email::send($to, $rests,$cname,$subject,$html);


			$post = ['orderid' => $vbookId,'mode'=>4,'restid' =>$restaurant->erp_id];
			 
			$chw = curl_init();
			curl_setopt($chw, CURLOPT_URL,"https://erp.ijoo.co.uk/index.php/admin/getcall");
			curl_setopt($chw, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($chw, CURLOPT_POSTFIELDS, $post);
			$response = curl_exec($chw);
			curl_close($chw);
			return response()->json(['status'=>'success']);
		}else{
			return response()->json(['status'=>'error']);
		}

	}








	public function __appStatus($status){
		$appStatus = $status;
		switch($status){
			case 1:                  
				$appStatus = 0;
			 break;
			 case 2:                  
				$appStatus = 1;
			 break;
			 case 3:                  
				$appStatus = 1;
			 break;
			 case 4:                  
				$appStatus = 3;
			 break;

		}
		return $appStatus;
	}
	public function __appBookingStatus($status){
		$appStatus = $status;
		switch($status){
			case 1:                  
				$appStatus = "pending";
			 break;
			 case 2:                  
				$appStatus = "approved";
			 break;
			 case 3:                  
				$appStatus = "rejected";
			 break;
		}
		return $appStatus;
	}


}
