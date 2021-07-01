<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\PaymentMethods;
//use App\Models\Hours;
use App\Models\Menu;
use App\Models\Category;
use App\Models\AddonCategories;
use App\Models\AddonItems;
use App\Models\Sizes;
use App\Models\Voucher;
use App\Models\Coupon;

class CommonController extends Controller
{
    public function change(Request $request)
    {
       $status =  $request->status;
       $item =  $request->item;
       $id =  $request->id;
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
                    return ['success' => true, 'message' => 'Test Mode is '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "delivery":
                Settings::first()->update(['delivery' =>  $status]);
                   return ['success' => true, 'message' => 'Delivery turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "collection":
                Settings::first()->update(['collection' =>  $status]);
                    return ['success' => true, 'message' => 'Collection turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "preorder":
                Settings::first()->update(['pre_order' =>  $status]);
                return ['success' => true, 'message' => 'Pre order turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "booking":
                Settings::first()->update(['booking' =>  $status]);
                return ['success' => true, 'message' => 'Booking turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "dinein":
                Settings::first()->update(['dinein' =>  $status]);
                return ['success' => true, 'message' => 'Dine In turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "paynow":
                Settings::first()->update(['paynow' =>  $status]);
                return ['success' => true, 'message' => 'Pay Now turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "rejectorder":
                Settings::first()->update(['reject_order' =>  $status]);
                return ['success' => true, 'message' => 'Reject order turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "vouchers":
                Settings::first()->update(['voucher' =>  $status]);
                return ['success' => true, 'message' => 'Vouchers turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "coupons":
                Settings::first()->update(['coupon' =>  $status]);
                return ['success' => true, 'message' => 'Coupons turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            /* ------                      ------ */

            case "menu":
                Menu::find($id)->update(['active' =>  $status]);
                return ['success' => true, 'message' => 'Menu Item turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "category":
                Category::find($id)->update(['active' =>  $status]);
                return ['success' => true, 'message' => 'Category turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "addon-category":
                AddonCategories::find($id)->update(['active' =>  $status]);
                return ['success' => true, 'message' => 'AddonCategory turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "addon-item":
                AddonItems::find($id)->update(['active' =>  $status]);
                return ['success' => true, 'message' => 'Addon Item turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "size":
                Sizes::find($id)->update(['active' =>  $status]);
                return ['success' => true, 'message' => 'Size turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "voucher":
                Voucher::find($id)->update(['active' =>  $status]);
                return ['success' => true, 'message' => 'Voucher turned '.(($status==1) ? 'ON' : 'OFF')];
            break;
            case "coupon":
                Coupon::find($id)->update(['active' =>  $status]);
                return ['success' => true, 'message' => 'Coupon turned '.(($status==1) ? 'ON' : 'OFF')];
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
      
    }
}
