<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\Settings;
use App\Models\VoucherOrders;
use App\Models\Hours;
use App\Models\Merchant;
use App\Models\Email;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($request->search) && !empty($request->price)){
            $data = Voucher::sortable()->where('name', 'LIKE', '%'.$request->search.'%')->where('price', '=', $request->price)->paginate(8);
        }else if(!empty($request->search)){
            $data = Voucher::sortable()->where('name', 'LIKE', '%'.$request->search.'%')->paginate(8);
        }else if(!empty($request->price)){
             $data = Voucher::sortable()->where('price', '=', $request->price)->paginate(8);
        }else{
             $data = Voucher::sortable()->paginate(8);
        }
        return view('voucher.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('voucher.create');
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
            'price' => 'required',
            'sort_order' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4048',
        ]);
        if(!empty($request->image)){
            $imageName = time().'.'.$request->file('image')->extension();  
            $request->file('image')->storeAs('public/images', $imageName);
        }
        $voucher = new Voucher;
 
        $voucher->name = $request->name;
        $voucher->description = $request->description;
        $voucher->image =  $imageName ?? NULL;
        $voucher->price = $request->price;
        $voucher->sort_order = $request->sort_order;
        $voucher->active = $request->active;
        if($voucher->save()){
            return back()->with('success', 'Voucher created successfully.');
        }else{
            return back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $voucher = Voucher::find($id);
        return view('voucher.edit', compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'sort_order' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
        ]);
        if(!empty($request->image)){
            $imageName = time().'.'.$request->file('image')->extension();  
            $request->file('image')->storeAs('public/images', $imageName);
        }
        $voucher = Voucher::find($id);
        $voucher->name = $request->name;
        $voucher->description = $request->description;
        if(!empty($imageName))
            $voucher->image =  $imageName;
        $voucher->price = $request->price;
        $voucher->sort_order = $request->sort_order;
        $voucher->active = $request->active;
        if($voucher->save()){
            return redirect('/voucher')->with('success', 'Voucher updated successfully.');
        }else{
            return redirect('/voucher')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Voucher::where('id',$id)->delete();
        return redirect()->back()->with('success','Voucher Deleted Successfully!');
    }

    public function order(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'email|required',
             'payment_type' => 'required',
         ]);
        $voucher = Voucher::find($id);
        $restaurant = Settings::first();
  
        $order =  new VoucherOrders;
        $order->customer_name = $request->name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->order_time = date('Y-m-d H:i:s');
        $order->voucher_id = $id;
        $order->voucher_amount = $voucher->price;
        $order->purchase_code = "";
        $order->payment_method = $request->payment_type;
        $order->payment_status =  0;
        $order->status = 1;
        if($order->save()){ 

            $rests=str_replace(' ', '',$restaurant->name);
            $rests = substr($rests, 0,6);
            //list($firstName, $lastName) = explode(' ', $order->customer_name);
            $firstName = strtok($order->customer_name, ' ');
            $rslug = '#'.$rests;
            $rslug .= $order->id;
            $rslug .= $firstName;
            $rslug .= substr($order->phone, -4);
            $pcode = $rslug;

            $order->purchase_code = $pcode;
            $order->save();
            
            $voucher_data = ["id"=>$order->id,"amount"=> $voucher->price];
            session()->put('voucher', $voucher_data);
            return redirect('/voucherpayment');           
                
        }
            
    }
    public function orders(Request $request)
    {
        
        if(!empty($request->search) && !empty($request->pcode)){
            $data = VoucherOrders::sortable()->where('customer_name', 'LIKE', '%'.$request->search.'%')->where('purchase_code', '=', $request->pcode)->latest()->paginate(8);
        }else if(!empty($request->search)){
            $data = VoucherOrders::sortable()->where('customer_name', 'LIKE', '%'.$request->search.'%')->latest()->paginate(8);
        }else if(!empty($request->pcode)){
             $data = VoucherOrders::sortable()->where('purchase_code', '=', $request->pcode)->latest()->paginate(8);
        }else{
             $data = VoucherOrders::sortable()->latest()->paginate(8);
        }
  
        return view('voucher.orders',compact('data'));
    }
    public function orderview($id)
    {
        $data  = VoucherOrders::find($id);
        $voucher = NULL;
        $voucher = Voucher::find($data->voucher_id);
        return view('voucher.orderview',["data"=>$data,"voucher"=>$voucher]);     
    }  
    public function paymentfailure()
    {
        $restaurant = Settings::first();
        $opening_hours = Hours::all();
        return view('themes.soup.voucherpaymentfailure',compact('restaurant','opening_hours'));    
    } 
    public function changestatus($id,$status)
    {
        $voucher_order =  VoucherOrders::find($id);
        $voucher_order->status = $status;
        $voucher_order->save();
        if($status==2){
            $restaurant = Settings::first();
            $msg="Dear customer, You have successfully claimed the Voucher with Purchase Code".$voucher_order->purchase_code.".Thank You,".$restaurant->name;
			Merchant::sendSMS($voucher_order->phone,$msg);

			$to =  $voucher_order->email;
			$cname = $voucher_order->customer_name;
			$subject = "Voucher Claimed";
			$logo = url('storage/images/'.$restaurant->logo);
			$rests = $restaurant->name;
			$pcode = $voucher_order->purchase_code;
			$rmail =  $restaurant->email;
			$cnumber = $restaurant->contact_no;
			$html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"/><meta content="width=device-width" name="viewport"/><meta content="IE=edge" http-equiv="X-UA-Compatible"/><title></title><style type="text/css">body {margin: 0;padding: 0;}table,td,tr {vertical-align: top;border-collapse: collapse;}* {line-height: inherit;}a[x-apple-data-detectors=true] {color: inherit !important;text-decoration: none !important;}</style><style id="media-query" type="text/css">@media (max-width: 520px) {.block-grid,.col {min-width: 320px !important;max-width: 100% !important;display: block !important;}.block-grid {width: 100% !important;}.col {width: 100% !important;}.col_cont {margin: 0 auto;}img.fullwidth,img.fullwidthOnMobile {max-width: 100% !important;}.no-stack .col {min-width: 0 !important;display: table-cell !important;}.no-stack.two-up .col {width: 50% !important;}.no-stack .col.num2 {width: 16.6% !important;}.no-stack .col.num3 {width: 25% !important;}.no-stack .col.num4 {width: 33% !important;}.no-stack .col.num5 {width: 41.6% !important;}.no-stack .col.num6 {width: 50% !important;}.no-stack .col.num7 {width: 58.3% !important;}.no-stack .col.num8 {width: 66.6% !important;}.no-stack .col.num9 {width: 75% !important;}.no-stack .col.num10 {width: 83.3% !important;}.video-block {max-width: none !important;}.mobile_hide {min-height: 0px;max-height: 0px;max-width: 0px;display: none;overflow: hidden;font-size: 0px;}.desktop_hide {display: block !important;max-height: none !important;}}</style><style id="icon-media-query" type="text/css">@media (max-width: 520px) {.icons-inner {text-align: center;}.icons-inner td {margin: 0 auto;}}</style></head><body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #32b8ba;"><table bgcolor="#32b8ba" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #32b8ba; width: 100%;" valign="top" width="100%"><tbody><tr style="vertical-align: top;" valign="top"><td style="word-break: break-word; vertical-align: top;" valign="top"><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div align="center" class="img-container center autowidth" style="padding-right: 0px;padding-left: 0px;"><img align="center" border="0" class="center autowidth" src="'.$logo.'" style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 100%; max-width: 150px; display: block;" width="150"/></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 22px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 26px; margin-top: 0; margin-bottom: 0;"><span style="font-size: 18px;"><strong><br/>VOUCHER STATUS : VOUCHER CLAIMED</strong></span></p></div></div></div></div></div></div></div></div><div><div class="block-grid mixed-two-up" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num3" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 123px; width: 125px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px; text-align: center; width: 100%;" valign="top" width="100%"><h1 style="color:#ffffff;direction:ltr;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;font-size:23px;font-weight:normal;letter-spacing:normal;line-height:120%;text-align:center;margin-top:0;margin-bottom:0;"><strong>'.$rests.'</strong></h1></td></tr></table></div></div></div><div class="col num9" style="display: table-cell; vertical-align: top; max-width: 320px; min-width: 369px; width: 375px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Dear Customer,</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">You successfully claimed the voucher with purchase code : '.$pcode.'<br/></h3></p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;"> </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">For Further Details</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">please Contact: '.$rmail.'</p><p style="margin: 0; font-size: 14px; line-height: 1.2; word-break: break-word; text-align: center; mso-line-height-alt: 17px; margin-top: 0; margin-bottom: 0;">Or Call '.$cnumber.' </p></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><div style="color:#ffffff;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:10px;padding-right:10px;padding-bottom:10px;padding-left:10px;"><div class="txtTinyMce-wrapper" style="line-height: 1.2; font-size: 12px; color: #ffffff; font-family: Arial, Helvetica Neue, Helvetica, sans-serif; mso-line-height-alt: 14px;"></div></div></div></div></div></div></div></div><div style="background-color:transparent;"><div class="block-grid" style="min-width: 320px; max-width: 500px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; Margin: 0 auto; background-color: transparent;"><div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;"><div class="col num12" style="min-width: 320px; max-width: 500px; display: table-cell; vertical-align: top; width: 500px;"><div class="col_cont" style="width:100% !important;"><div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;"><table cellpadding="0" cellspacing="0" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" valign="top" width="100%"><tr style="vertical-align: top;" valign="top"><td align="center" style="word-break: break-word; vertical-align: top; padding-top: 5px; padding-right: 0px; padding-bottom: 5px; padding-left: 0px; text-align: center;" valign="top"><table cellpadding="0" cellspacing="0" class="icons-inner" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; display: inline-block; margin-right: -4px; padding-left: 0px; padding-right: 0px;" valign="top"><tr style="vertical-align: top;" valign="top"></tr></table></td></tr></table></div></div></div></div></div></div></td></tr></tbody></table></body></html>';
			Email::send($to, $rests,$cname,$subject,$html);


        }



        return redirect()->back()->with('success', 'Voucher Updated successfully.');
    }

    
}



