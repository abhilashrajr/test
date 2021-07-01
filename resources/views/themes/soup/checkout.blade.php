@extends('layouts.soup', [

'class' => '',
'title' => 'Checkout',
'elementActive' => ''

])



@section('content')

<div id="content">



     <!-- Page Title -->

     <div class="page-title bg-dark dark">

          <!-- BG Image -->

          <div class="bg-image bg-parallax"><img src="{{ asset('themes') }}/soup/img/bg-croissant.jpg" alt="">

          </div>

          <div class="container">

               <div class="row">

                    <div class="col-lg-8 offset-lg-4">

                         <h1 class="mb-0">Checkout</h1>

                         <h4 class="text-muted mb-0"></h4>

                    </div>

               </div>

          </div>

     </div>



     <!-- Section -->

     <section class="section bg-light">



          <div class="container">

               <div class="row">

                    <div class="col-xl-4 col-lg-5">

                         <div class="cart-details shadow bg-white stick-to-content mb-4">

                              <div class="bg-dark dark p-4">

                                   <h5 class="mb-0">You order</h5>

                              </div>

                              <table class="cart-table">

                                   

                                   @isset($cart['items'])

                                   @forelse($cart['items'] as $key => $item)

                                   <tr>

                                        <td>{{ $item['name'] }}</td>

                                        <td>{{ $item['quantity'] }}</td>

                                        <td>{{ $item['price'] }}</td>

                                        <td class="actions"><!--<a href="#product-modal" data-toggle="modal"

                                                  class="action-icon"><i class="ti ti-pencil"></i></a><a href="#"

                                                  class="action-icon remove-item" data-id="{{$key}}"><i

                                                       class="ti ti-close"></i></a>-->  </td>







                                      

                                   </tr>

                                   @if(!empty($item['addons']))



                                   @foreach($item['addons'] as  $addons)

                                   <tr>

                                        <td colspan="2" class="text-right" style="line-height: .25;">{{ $addons['name'] }}</td>

                                        

                                        <td class="p-0 text-center" style="line-height: .25;">{{ $addons['qty'] }}</td>

                                         <td  class="p-0 text-left" style="line-height: .25;"> {{$restaurant->currency}} {{ $addons['price'] }}</td>



                                   <!-- <td class="actions"><a href="#product-modal" data-toggle="modal"

                                                  class="action-icon"><i class="ti ti-pencil"></i></a> <a href="#"

                                                  class="action-icon remove-item" data-id="{{$addons['id']}}"><i

                                                       class="ti ti-close"></i></a> </td>-->







                                   

                                   </tr>

                                

                                   @endforeach

                                   @endif

                                  





                                   @empty

                                   @endforelse

                                   @endisset

                              </table>

                              <div class="cart-summary">

                                   <div class="row">

                                        <div class="col-7 text-right text-muted">Order total:</div>

                                        <div class="col-5"><strong> {{$restaurant->currency}} <span

                                                       class="cart-products-total" id="order-total">{{ number_format($cart['total'],2)}}</span></strong>

                                        </div>

                                   </div>
                                  
                                  

                                   @php

                                   $discount_coll=0;

                                   $discount_deli =0;

                                   if($hours->offer == 1){

                                   if($cart['total'] > $hours->coll_min)

                                         $discount_coll = $cart['total']*$hours->offer_coll/100;

                               

                                   if($cart['total'] > $hours->deli_min)

                                         $discount_deli = $cart['total']*$hours->offer_deli/100;

                                   }

                                   @endphp

                                   <div class="row for-collection">

                                        <div class="col-7 text-right text-muted">Discount:</div>

                                        <div class="col-5"><strong> {{$restaurant->currency}} <span

                                                       class="cart-delivery"  id="discount-coll">{{ round($discount_coll,2)}}</span></strong>

                                        </div>

                                   </div>

                                   <div class="row for-delivery">

                                        <div class="col-7 text-right text-muted">Discount:</div>

                                        <div class="col-5"><strong> {{$restaurant->currency}} <span

                                                       class="cart-delivery"  id="discount-deli">{{ round($discount_deli,2)}}</span></strong>

                                        </div>

                                   </div>
                                   <div class="row coupon_dis" style="display:none">

                                        <div class="col-7 text-right text-muted">Coupon:</div>

                                        <div class="col-5"><strong> {{$restaurant->currency}} <span

                                                       class="cart-delivery"  id="discount-coupon">@if(isset($discount_coup)){{ round($discount_coup,2)}}@else 0 @endif</span></strong>

                                        </div>

                                   </div>
                                  

                                   <div class="row for-delivery">

                                        <div class="col-7 text-right text-muted">Devliery Charge:</div>

                                        <div class="col-5"><strong> {{$restaurant->currency}}<span  id="delivery-charge"

                                                       class="cart-delivery" >0.00</span></strong>

                                        </div>

                                   </div>

                                    <hr class="hr-sm">
                                    <div class="row ">
                                        <div class="col-7 text-right text-muted">  <input type="text" name="ccode" id="ccode" class="form-control input-sm"

                                             value="{{ old('coupon')}}" style="height: calc(2.5rem + 2px);" placeholder="Coupon if any"></div>
                                        <div class="col-5"> 
                                             <button type="button" id="couponapply" class="btn btn-primary btn-sm"><span>Apply</span></button>
                                        </div>
                                   </div>
                                   <hr class="hr-sm">
                                   <div class="row text-lg">

                                        <div class="col-7 text-right text-muted">Total:</div>

                                        <div class="col-5"><strong> {{$restaurant->currency}}<span 

                                                       class="cart-total" id="amount-to-pay">{{ number_format($cart['total'],2)}}</span></strong>

                                        </div>

                                   </div>

                              </div>

                              <div class="cart-empty">

                                   <i class="ti ti-shopping-cart"></i>

                                   <p>Your cart is empty...</p>

                              </div>

                         </div>

                    </div>



                    <div class="col-xl-8 col-lg-7 order-lg-first">



                         <form action="{{route('order')}}" method="POST" id="checkout-form">

                              @csrf

                              <div class="bg-white p-4 p-md-5 mb-4">

                                   @if ($errors->any())

                                   <div class="alert alert-danger" id="errors">

                                        <ul style="padding-left: 15px;">

                                             @foreach ($errors->all() as $error)

                                             <li>{{ $error }}</li>

                                             @endforeach

                                        </ul>

                                   </div>

                                   @endif

                                   @if($cart['total'] < $restaurant->delivery_min || $cart['total'] < $restaurant->collection_min)

                                   <div class="alert alert-danger shadow mb-4" role="alert"

                                        style="border-left:#721c24 5px solid;  border-radius: 0px">

                                        <!--<h4 class="alert-heading pl-2  mb-1" style="font-weight:400;">Oh snap!</h4>-->

                                        <div class="">

                                            

                                             <p class="mb-0 pl-2">Minimum Order Amount For Delivery :

                                                  {{$restaurant->currency}}

                                                  {{(float)$restaurant->delivery_min}}</p>

                                           

                                             <p class="mb-0 pl-2">Minimum Order Amount For Collection :

                                                  {{$restaurant->currency}}

                                                  {{(float)$restaurant->collection_min}}</p>

                                             

                                        </div>

                                   </div>

                                   @endif
                                              <a  href="{{ route('home') }}" class="btn btn-primary  mb-5"><span>Back to

                                   menu</span></a>

                                   @if($hours->offer == 1)

                                   <div class="alert alert-warning shadow mb-5" role="alert"

                                        style="border-left:#816e4e 5px solid;  border-radius: 0px">



                                        <div class="">

                                             <h4 class="alert-heading pl-2  mb-1" style="font-weight:400;">Offer</h4>

                                             @if($hours->offer_deli && $restaurant->delivery && $hours->offer_deli!=0)

                                                  <p class="mb-0 pl-2">{{ (float) $hours->offer_deli}}% Off On All Delivery Orders  

                                                  @if((float)$hours->deli_min >0) 

                                                       Over

                                                       {{$restaurant->currency}}

                                                       {{(float)$hours->deli_min}}

                                                  @endif     

                                                  </p>

                                             @endif

                                             @if($hours->offer_coll && $restaurant->collection && $hours->offer_coll != 0)

                                                  <p class="mb-0 pl-2">{{(float) $hours->offer_coll}}% Off On All Collection Orders 

                                                  @if((float)$hours->coll_min >0) 

                                                       Over

                                                       {{$restaurant->currency}}

                                                       {{(float)$hours->coll_min}}

                                                  @endif     

                                                  </p>

                                             @endif

                                        </div>

                                   </div>

                                   @endif

                                  

                                   <h4 class="border-bottom pb-4"><i

                                             class="ti ti-package mr-3 text-primary"></i>Delivery /

                                        Collection</h4>

                                   <div class="row mb-5">

                                        <div class="form-group col-sm-6">

                                             <!-- <label>Delivery time:</label>-->

                                             <div class="select-container" >

                                                  <select name="order_type" id="checkout-order-type" class="form-control" required>

                                                       <option value="" {{ old('order_type') =='' ? 'selected' : ''}}>

                                                            Please Choose</option>

                                                       @if($restaurant->delivery==1)<option value="delivery"

                                                            {{ old('order_type') =='delivery' ? 'selected' : ''}}>

                                                            Delivery</option>@endif

                                                       @if($restaurant->collection==1)<option value="collection"

                                                            {{ old('order_type') =='collection' ? 'selected' : ''}}>

                                                            Collection</option>@endif

                                                  </select>

                                             </div>

                                             

                                        </div>

                                       

                                   </div>



                                



                                   <h4 class="border-bottom pb-4"><i class="ti ti-user mr-3 text-primary"></i>Delivery

                                        informations</h4>

                                        <div id="postcodeerr" class=" alert-danger pl-2 mb-1"></div>

                                   <div class="row mb-5">

                                        <div class="form-group col-sm-6">

                                             <label>Name:</label>

                                             <input type="text" name="name" class="form-control"

                                                  value="{{ old('name')}}" required>

                                        </div>

                                        <div class="form-group col-sm-6">

                                             <label>Phone No:</label>

                                             <input type="text" name="phone" id="cphone" class="form-control"

                                                  value="{{ old('phone')}}" required>

                                        </div>

                                        <div class="form-group col-sm-6 ">

                                             <label>Email:</label>

                                             <input type="text" name="email" class="form-control"

                                                  value="{{ old('email')}}">

                                        </div>

                                        <div class="form-group col-sm-6 for-delivery">

                                             <label>Post Code:</label>

                                             <input type="text" name="postcode" id="userpostcode" class="form-control"

                                                  value="{{ $cart['d_postcode'] ?? old('postcode')  }}">

                                        </div>

                                        <div class="form-group col-sm-6 for-delivery">

                                             <label>Exact Door No + Street Address:</label>

                                             <textarea name="address"

                                                  class="form-control " > {{ old('address')}}</textarea>

                                        </div>
                                        <div class="form-group col-sm-6 ">

                                        <label>Special Requirements:</label>

                                        <textarea name="other_info"

                                             class="form-control " > {{ old('other_info')}}</textarea>

                                        </div>

                                   </div>





                                   <h4 class="border-bottom pb-4"><i class="ti ti-wallet mr-3 text-primary"></i>Payment

                                   </h4>

                                   <div class="row text-lg">

                                        @foreach($payment_methods as $payment)

                                        <div class="col-md-4 col-sm-6 form-group">

                                             <label class="custom-control custom-radio">

                                                  <input type="radio" name="payment_type" value="{{$payment->id}}"

                                                       class="custom-control-input"

                                                       {{ old('payment_type') ==$payment->id ? 'checked' : ''}} required>

                                                  <span class="custom-control-indicator"></span>

                                                  <span class="custom-control-description">{{$payment->name}}</span>

                                             </label>

                                        </div>

                                        @endforeach



                                   </div>

                              </div>

                              <div class="text-center">

                              

                                   <button type="submit" id="orderbtn" class="btn btn-primary btn-lg"><span>Order now!</span></button>

                             

                              </div>

                         </form>
                         <p class="mt-5 mb-0" style="line-height:1"><small>*We use cookies in our website to improve your user experience. By Entering your details and proceeding, You agree to our T&C , Cookies and Privacy Policy listed at the bottom of the website.</small></p>
                      
                    </div>



               </div>

          </div>



     </section>



     <!-- Footer -->
     @include('layouts.soup-footer')
     <!-- Footer / End -->



</div>
@endsection

