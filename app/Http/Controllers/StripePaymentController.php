<?php
   
namespace App\Http\Controllers;
   
use Illuminate\Http\Request;
use Session;
use Stripe;
   
class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
       
        return view('stripe');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => 70 * 100,
                "currency" => "gbp",
                "source" => $request->stripeToken,
                "description" => "Test payment via Stripe From onlinewebtutorblog.com" 
        ]);
  
        Session::flash('success', 'Payment done successfully!');
          
        return back();
    }
}