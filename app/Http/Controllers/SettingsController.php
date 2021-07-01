<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\PaymentMethods;
use App\Models\Hours;
use App\Models\DeliveryCharge;

use DateTime;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Settings::first();
        $payment_methods = PaymentMethods::all();
        $hours = Hours::all();
        $delivery_charge = DeliveryCharge::all();
        return view('settings', compact('data','payment_methods','hours','delivery_charge'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
       // $data = Settings::get();
        $data = [];
        $data['id'] = 1;
        return view('settings', compact('data'));
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
                'currency' =>'required',
                'delivery_type'=>'required'
            ],[
                'delivery_type.required' => 'Delivery Charge is required',
            ]
        );
        if(!empty($request->logo)){
            $imageName = time().'.'.$request->file('logo')->extension();  
            $request->file('logo')->storeAs('public/images', $imageName);
        }
        $settings = Settings::find($id);
        $settings->name = $request->name;
        if(!empty($imageName))
            $settings->logo = $imageName;
        $settings->contact_no= $request->contact_no;
        $settings->contact_no2= $request->contact_no2;
        $settings->email= $request->email;
        $settings->latitude = $request->latitude;
        $settings->longitude = $request->longitude;
        $settings->address = $request->address;
        $settings->city = $request->city;
        $settings->state = $request->state;
        $settings->postcode = $request->postcode;
        $settings->delivery = $request->delivery ?? 0;
        $settings->collection = $request->collection ?? 0;       
        $settings->active = $request->active ?? 0;
        $settings->test_mode = $request->test_mode ?? 0;
        $settings->pre_order = $request->pre_order ?? 0;
        $settings->booking = $request->booking ?? 0;
        $settings->delivery_radius = $request->delivery_radius;
        $settings->collection_min = $request->collection_min;
        $settings->delivery_min = $request->delivery_min;
        $settings->drinks_discount = $request->drinks_dis;
        $settings->food_discount = $request->food_dis;
        $settings->preorder_start =($request->preorder_start!="") ? DateTime::createFromFormat( 'h:i a', $request->preorder_start)->format( 'H:i:s') : NULL;
     //   $settings->stripe_id = $request->stripe_id;
        $settings->erp_id = $request->erp_id;
        $settings->theme = $request->theme;
        $settings->currency = $request->currency;
        
        if($settings->save()){
            $hours = Hours::all();
            $i = 0;
            foreach ($hours as  $day) {
                $active = $i."-active";
                $start1 =  $i."-start1";
                $end1 =  $i."-end1";
                $start2 =  $i."-start2";
                $end2 =  $i."-end2";

                $offer = $i."-offer";
                $offer_coll =  $i."-offer_coll";
                $offer_deli =  $i."-offer_deli";
                $coll_min =  $i."-coll_min";
                $deli_min =  $i."-deli_min";
                $offer_payn =  $i."-offer_payn";
                $payn_min =  $i."-payn_min";

                $day->active = $request->$active ?? 0;
                $day->start1 = ($request->$start1!="") ? DateTime::createFromFormat( 'h:i a', $request->$start1)->format( 'H:i:s') : NULL;
                $day->end1 =  ($request->$end1!="") ? DateTime::createFromFormat( 'h:i a', $request->$end1)->format( 'H:i:s'):NULL;
                $day->start2 = ($request->$start2!="") ? DateTime::createFromFormat( 'h:i a',$request->$start2)->format( 'H:i:s'):NULL;
                $day->end2 = ($request->$end2!="") ? DateTime::createFromFormat( 'h:i a', $request->$end2)->format( 'H:i:s'):NULL ;  
                $day->offer = $request->$offer ?? 0;
                $day->offer_coll = (float) $request->$offer_coll ?? 0;
                $day->offer_deli = (float) $request->$offer_deli ?? 0;
                $day->coll_min = (float) $request->$coll_min ?? 0;
                $day->deli_min = (float) $request->$deli_min ?? 0;             
                $day->offer_payn = (float) $request->$offer_payn ?? 0;
                $day->payn_min = (float) $request->$payn_min ?? 0;          
                $day->save();
                $i++;
            }
            $deli_charge = DeliveryCharge::firstOrNew();
            $deli_charge->type = $request->delivery_type;
            switch($request->delivery_type){          
                case "free":                  
                    $deli_charge->rate = 0;
                    $deli_charge->free = 0;
                    $deli_charge->save();
                break;
                case "flat_rate":
                    $deli_charge->rate = $request->flat_rate;
                    $deli_charge->free =  $request->flat_free;
                    $deli_charge->save();
                break;
                case "km_rate":
                   //$deli_charge->rate = $request->km_rate;
                  ///  $deli_charge->free = $request->km_free;
                   // $deli_charge->save();
                   
                   // DeliveryCharge::whereNotNull('id')->delete();
                   DeliveryCharge::truncate();
                    foreach($request->km  as $key =>$value){
                        if($request->km[$key]!='' && $request->km_rate[$key]!=''){
                            $deli_charge = new DeliveryCharge;
                            $deli_charge->type = $request->delivery_type;
                            $deli_charge->rate = $request->km_rate[$key];
                            $deli_charge->free = $value;
                            $deli_charge->save();
                        }
                      
                    }
                break;
                case "post_code":
                    DeliveryCharge::truncate();
                   // DeliveryCharge::whereNotNull('id')->delete();
                   
                    foreach($request->post_code  as $key =>$value){
                        if($request->post_code[$key]!='' && $request->ps_rate[$key]!=''){
                            $deli_charge = new DeliveryCharge;
                            $deli_charge->type = $request->delivery_type;
                            $deli_charge->rate = $request->ps_rate[$key];
                            $deli_charge->free = $value;
                            $deli_charge->save();
                        }
                      
                    }
                    
                break;
            }
            

            return redirect()->back()->with('success', 'Settings updated successfully.');
        }else{
            return redirect()->back()->with('error', 'Something went wrong!');
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
        //
    }
    /*
    public function change(Request $request)
    {
       $status =  $request->status;
       $item =  $request->item;
       $payment_methods = PaymentMethods::all();
       switch ($item) {
            case "restaurant":
                Settings::first()->update(['active' =>  $status]);
                if($status==1)
                    return ['success' => true, 'message' => 'Restaurant is Online Now!'];
                else
                    return ['success' => true, 'message' => 'Restaurant is Offline Now!'];   
            break;
            case "testmode":
                Settings::first()->update(['test_mode' =>  $status]);
                if($status==1)
                    return ['success' => true, 'message' => 'Test Mode is ON '];
                else
                    return ['success' => true, 'message' => 'Test Mode is Off'];
            break;
            case "delivery":
                Settings::first()->update(['delivery' =>  $status]);
                if($status==1)
                    return ['success' => true, 'message' => 'Delivery turned ON'];
                else
                    return ['success' => true, 'message' => 'Delivery turned OFF'];
            break;
            case "collection":
                Settings::first()->update(['collection' =>  $status]);
                if($status==1)
                    return ['success' => true, 'message' => 'Collection turned ON'];
                else
                    return ['success' => true, 'message' => 'Collection turned OFF'];
            break;
            case "preorder":
                Settings::first()->update(['pre_order' =>  $status]);
                if($status==1)
                    return ['success' => true, 'message' => 'Pre order turned ON'];
                else
                    return ['success' => true, 'message' => 'Pre order turned OFF'];
            break;
           
         
            default:
            foreach($payment_methods as $payment){
                if( $item == $payment->name){
                    PaymentMethods::find($payment->id)->update(['active' =>  $status]);
                    if($status==1)
                        return ['success' => true, 'message' => $payment->name.' turned ON '];
                    else
                        return ['success' => true, 'message' => $payment->name.' turned OFF'];
                }
            }
      }
      
    }*/
    public function hoursupdate(Request $request)
    {
        
    }

}
