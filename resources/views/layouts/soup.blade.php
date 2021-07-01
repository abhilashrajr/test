

<!DOCTYPE html>
<html lang="en">

<head>

     <!-- Meta -->
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <meta property="og:image" content="{{ url('storage/images/'.$restaurant->logo)}}"/>
     <!-- Title -->
     <title>{{$title ?? ''}}</title>

     <!-- Favicons -->
     <link rel="shortcut icon" href="{{ url('storage/images/'.$restaurant->logo)}}">
     
     <link rel="apple-touch-icon" href="{{  asset('themes') }}/soup/img/favicon_60x60.png">
     <link rel="apple-touch-icon" sizes="76x76" href="{{  asset('themes') }}/soup/img/favicon_76x76.png">
     <link rel="apple-touch-icon" sizes="120x120" href="{{  asset('themes') }}/soup/img/favicon_120x120.png">
     <link rel="apple-touch-icon" sizes="152x152" href="{{  asset('themes') }}/soup/img/favicon_152x152.png">

     <!-- Fonts -->
     <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Raleway:wght@100;200;400;500&display=swap"
          rel="stylesheet">

     <!-- CSS Core -->
     <link rel="stylesheet" href="{{ asset('themes') }}/soup/css/core.css" />

     <!-- CSS Theme -->
     <link id="theme" rel="stylesheet" href="{{ asset('themes') }}/soup/css/theme-beige.css" />
     <style>
     .badge-notify {
          background: #df3232;
          color: #fff;
          position: relative;
          /* top: -12px !important;*/

     }
     .veg-badge-notify {
          background: #13b02b;
          color: #fff;
          position: relative;
          /* top: -12px !important;*/

     }
     .has-search .form-control {
          padding-left: 2.375rem;
     }
     .has-search .form-control-feedback {
          position: absolute;
          z-index: 2;
          display: block;
          width: 2.375rem;
          height: 2.375rem;
          line-height: 3.375rem;
          text-align: center;
          pointer-events: none;
          color: #aaa;
     }
     #search-food::placeholder {
    opacity: 1 !important;

     } 
     
     .shape {
     border-style: solid;
     border-width: 0 70px 40px 0;
     float: right;
     height: 0px;
     width: 0px;
     -ms-transform: rotate(360deg); /* IE 9 */
     -o-transform: rotate(360deg); /* Opera 10.5 */
     -webkit-transform: rotate(360deg); /* Safari and Chrome */
     transform: rotate(360deg);
     }
     .listing {
     background: #fff;
     border: 1px solid #ddd;
     /*  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);*/
     margin: 0 0 0px 0;
     overflow: hidden;
     }

     .shape {
     border-color: rgba(255,255,255,0) #d9534f rgba(255,255,255,0) rgba(255,255,255,0);
     }
     .listing-radius {
     border-radius: 7px;
     }
     .listing-danger {
     border-color: #d9534f;
     }
     .listing-danger .shape {
     border-color: transparent #d9533f transparent transparent;
     }
     .listing-info {
     border-color: #5bc0de;
     }
     .listing-info .shape {
     border-color: transparent #5bc0de transparent transparent;
     }
     .shape-text {
     color: #fff;
     font-size: 12px;
     font-weight: bold;
     position: relative;
     right: -40px;
     top: 2px;
     white-space: nowrap;
     -ms-transform: rotate(30deg); /* IE 9 */
     -o-transform: rotate(360deg); /* Opera 10.5 */
     -webkit-transform: rotate(30deg); /* Safari and Chrome */
     transform: rotate(30deg);
     }
     .listing-content {
     padding: 0 20px 10px;
     }
     .footer-table td, .footer-table th {
          padding: 2px !important;
          margin: 0;
     }
     </style>
     @stack('styles')
   
</head>

<body>

     <!-- Body Wrapper -->
     <div id="body-wrapper" >

          <!-- Header -->
          <header id="header" class="light">

               <div class="container">
                    <div class="row">
                         <div class="col-md-3">
                              <!-- Logo -->
                              <div class="module module-logo dark">
                                   <a href="#">
                                        <img src="{{ url('storage/images/'.$restaurant->logo)}}" alt="" width="88">
                                   </a>
                              </div>
                         </div>
                         <div class="col-md-7">
                              <!-- Navigation -->
                              <nav class="module module-navigation left mr-4">
                                   <ul id="nav-main" class="nav nav-main">
                                      <!--
                                        <li>
                                             <a href="/site/">Home</a>

                                        </li> 
                                    -->   
                                        <li><a href="{{route('home')}}">Order Takeaway</a></li>
                                      
                                       <!--
                                        <li class="has-dropdown">
                                             <a href="#">About</a>
                                             <div class="dropdown-container">
                                                  <ul class="dropdown-mega">
                                                       <li><a href="/site/page-about.html">About Us</a></li>
                                                       <li><a href="/site/page-services.html">Services</a></li>
                                                       <li><a href="/site/page-gallery.html">Gallery</a></li>
                                                       <li><a href="/site/page-reviews.html">Reviews</a></li>
                                                       <li><a href="/site/page-faq.html">FAQ</a></li>
                                                  </ul>
                                                  <div class="dropdown-image">
                                                       <img src="http://assets.suelo.pl/soup/img/photos/dropdown-about.jpg"
                                                            alt="">
                                                  </div>
                                             </div>
                                        </li>
                                      
                                        <li><a href="/site/page-offers.html">Offers</a></li>-->
                                       
                                      @if($restaurant->booking)
                                             <li><a href="{{route('booking')}}">Booking</a></li>
                                       @endif
                                       @if($restaurant->dinein)
                                             <li><a href="{{route('dinein')}}">Dine In</a></li>
                                       @endif
                                       @if($restaurant->paynow)
                                              <li><a href="{{route('paynow')}}">Pay Now</a></li>
                                       @endif
                                       @if($restaurant->voucher)
                                             <li><a href="{{route('vouchers')}}">Voucher</a></li>
                                       @endif
                                       @if($restaurant->booking)
                                             <li><a href="{{route('sbooking')}}">Special Booking</a></li>
                                       @endif
                                   </ul>
                              </nav>
                               <!--<div class="module left">
                                   <a href="{{route('home')}}"
                                        class="btn btn-outline-secondary"><span>Order Takeaway</span></a>
                              </div>-->
                         </div>
                         <div class="col-md-2">
                         @if($elementActive =="menu")
                              <a href="#" id="showcart" class="module module-cart right" data-toggle="panel-cart">
                                   <span class="cart-icon">
                                        <i class="ti ti-shopping-cart"></i>
                                        <span id="cart-count"class="notification">0</span>
                                   </span>
                                   <span  class="cart-value"> {{$restaurant->currency}}<span id="cart-total" class="value cart-total">0.00</span></span>
                              </a>
                         @endif     
                         </div>
                    </div>
               </div>

          </header>
          <!-- Header / End -->

          <!-- Header -->
          <header id="header-mobile" class="light">

               <div class="module module-nav-toggle">
                    <a href="#" id="nav-toggle"
                         data-toggle="panel-mobile"><span></span><span></span><span></span><span></span></a>
               </div>

               <div class="module module-logo">
                    <a href="index.html">
                         <img src="{{ url('storage/images/'.$restaurant->logo)}}" alt="">
                    </a>
               </div>

               <a href="#" id="showcartmob" class="module module-cart">
                    <i class="ti ti-shopping-cart"></i>
                    <span class="notification">0</span>
               </a>

          </header>
          <!-- Header / End -->

        

<!-- Content --->  @yield('content')
@php
$total_price = 0;
$total_qty = 0;

@endphp

@if(!empty($cart['order_type']) && ($cart['order_type']=="dinein" || $cart['order_type']=="deli_coll" ))
  
        
          <!-- Panel Cart -->
          <div id="panel-cart">
               <div class="panel-cart-container">
                    <div class="panel-cart-title">
                         <h5 class="title">Your Cart</h5>
                         <button class="close" id="cartclose" data-toggle="panel-cart"><i
                                   class="ti ti-angle-right"></i></button>
                    </div>
                    <div class="panel-cart-content cart-details">
                         <table class="cart-table" id="cart">
                             
                              @if(!empty($cart['items']))

                                   @foreach($cart['items'] as $key => $item)
                                   <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['quantity'] }}</td>
                                        <td> {{$restaurant->currency}}&nbsp;{{ $item['price'] }}</td>
                                        <td class="actions"><!--<a href="#product-modal" data-toggle="modal"
                                                  class="action-icon"><i class="ti ti-pencil"></i></a>--> <a href="#"
                                                  class="action-icon remove-item" data-id="{{$key}}"><i
                                                       class="ti ti-close"></i></a> </td>



                                      
                                   </tr>
                                   @if(!empty($item['addons']))

                                   @foreach($item['addons'] as  $addons)
                                   <tr>
                                        <td colspan="2" class="text-right" style="line-height: .25;">{{ $addons['name'] }}</td>
                                        
                                        <td class="p-0 text-center" style="line-height: .25;">{{ $addons['qty'] }}</td>
                                         <td  class="p-0 text-left" style="line-height: .25;"> {{$restaurant->currency}}&nbsp;{{ $addons['price'] }}</td>
                                       <!-- <td class="actions"><a href="#product-modal" data-toggle="modal"
                                                  class="action-icon"><i class="ti ti-pencil"></i></a> <a href="#"
                                                  class="action-icon remove-item" data-id="{{$addons['id']}}"><i
                                                       class="ti ti-close"></i></a> </td>-->



                                      
                                   </tr>
                                   @php
                                        $total_price += ($addons['price']*$addons['qty']);
                                   @endphp
                                   @endforeach
                                   @endif
                                   @php
                                        $total_price += $item['quantity'] * $item['price'];
                                        $total_qty += $item['quantity'];
                                        @endphp
                                   @endforeach
                              @endif
                         </table>
                         <div class="cart-summary">
                              <div class="row">
                                   <div class="col-7 text-right text-muted">Order total:</div>
                                   <div class="col-5"><strong> {{$restaurant->currency}} <span
                                                  class="cart-products-total">{{ round($total_price,2)}}</span></strong>
                                   </div>
                              </div>
                              <!--<div class="row">
                                   <div class="col-7 text-right text-muted">Devliery:</div>
                                   <div class="col-5"><strong> {{$restaurant->currency}} <span class="cart-delivery">0.00</span></strong></div>
                              </div>-->
                              <hr class="hr-sm">
                              <div class="row text-lg">
                                   <div class="col-7 text-right text-muted">Total:</div>
                                   <div class="col-5"><strong> {{$restaurant->currency}} <span
                                                  class="cart-total">{{ round($total_price,2)}}</span></strong></div>
                              </div>
                         </div>
                         @empty($cart['items'])
                         <div class="cart-empty" style="display:block;">
                              <i class="ti ti-shopping-cart"></i>
                              <p>Your cart is empty...</p>
                         </div>
                         @endempty


                    </div> 
   
                    <button type="button" class="btn btn-link text-primary empty-cart" style="text-transform: capitalize;"><span>Empty Cart</span></button>
 
               </div>
               <div id="coll-min-alert" data-amount="{{$restaurant->collection_min}}" class="alert alert-danger text-center" role="alert" style="display:none;position: absolute;bottom: 50px;z-index: 1000;width: 100%;">
                    Minimum Order Amount is :  {{$restaurant->currency}}{{$restaurant->collection_min}} 
               </div>
               <div id="deli-min-alert" data-amount="{{$restaurant->delivery_min}}" class="alert alert-danger text-center" role="alert" style="display:none;position: absolute;bottom: 50px;z-index: 1000;width: 100%;">
                    Minimum Order Amount is :  {{$restaurant->currency}}{{$restaurant->delivery_min}} 
               </div>
               @if(!empty($cart['order_type']))
                    @if($cart['order_type']=="dinein")
                          <a id="checkout-btn" href="{{ route('dineincheckout') }}" class="panel-cart-action btn btn-secondary btn-block btn-lg @if($total_qty==0) disabled @endif"><span>Go to
                                   checkout</span></a>
                    @else
                         <a id="checkout-btn" href="{{ route('checkout') }}" class="panel-cart-action btn btn-secondary btn-block btn-lg @if($total_qty==0) disabled @endif"><span>Go to
                                   checkout</span></a>
                    @endif
               @endif          
          </div>
@endif


          <!-- Panel Mobile -->
          <nav id="panel-mobile">
               <div class="module module-logo bg-dark dark">
                    <a href="#">
                         <img src="{{ url('storage/images/'.$restaurant->logo)}}" alt="" width="88">
                    </a>
                    <button class="close" data-toggle="panel-mobile"><i class="ti ti-close"></i></button>
               </div>
               <nav class="module module-navigation"></nav>
               <!--
               <div class="module module-social">
                    <h6 class="text-sm mb-3">Follow Us!</h6>
                    <a href="#" class="icon icon-social icon-circle icon-sm icon-facebook"><i
                              class="fa fa-facebook"></i></a>
                    <a href="#" class="icon icon-social icon-circle icon-sm icon-google"><i
                              class="fa fa-google"></i></a>
                    <a href="#" class="icon icon-social icon-circle icon-sm icon-twitter"><i
                              class="fa fa-twitter"></i></a>
                    <a href="#" class="icon icon-social icon-circle icon-sm icon-youtube"><i
                              class="fa fa-youtube"></i></a>
                    <a href="#" class="icon icon-social icon-circle icon-sm icon-instagram"><i
                              class="fa fa-instagram"></i></a>
               </div>
               -->
          </nav>

          <!-- Body Overlay -->
          <div id="body-overlay"></div>

     </div>

     <!-- Modal / Product -->
     <div class="modal fade product-modal" id="addon-modal" role="dialog">
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header modal-header-lg dark bg-dark">
                         <div class="bg-image"><img src="{{ asset('themes') }}/soup/img/modal-add.jpg" alt="">
                         </div>
                         <h4 class="modal-title" id="addonm-title">Specify your dish</h4>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                   class="ti ti-close"></i></button>
                    </div>
                   
                    <form action="#" method="get" id="addon-form">

                          <div class="modal-product-details pt-3 pb-3">
                              <div class="row align-items-center">
                                   <div class="col-9">
                                        <h6 class="mb-1 product-modal-name">Quantity</h6>
                                        <!--<span class="text-muted product-modal-ingredients">Pasta, Cheese, Tomatoes,
                                             Olives</span>-->
                                   </div>
                                   <div class="col-3 text-lg text-right" id="item-qty"></div>
                              </div>
                          </div>

                         <div class="modal-body panel-details-container">
                              <div id="addon-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
                              <div id="addon-content" style="min-height: 50px;">
                                   
                              </div>


                              <!-- Panel Details / Other -->
                              <div class="panel-details panel-details-form" id="other-form"
                                   style="display:none;border-top: 1px solid #e0e0e0;">
                                   <h5 class="panel-details-title">
                                        <a href="#panel-details-other" data-toggle="collapse"
                                             style="display: block;">Other <span class="icon icon-sm pull-right"><i
                                                       class="ti ti-angle-down"></i></span></a>
                                   </h5>
                                   <div id="panel-details-other" class="collapse">

                                        <textarea id="other_info" name="other_info" autocomplete="off" cols="30" rows="4" class="form-control"
                                             placeholder="Put this any other informations..."></textarea>

                                   </div>
                              </div>
                         </div>

                         <button type="submit" class="modal-btn btn btn-secondary btn-block btn-lg "
                              id="add-to-cart-model "><span>Add to
                                   Cart</span></button>

                    </form>
               </div>
          </div>
     </div>


     <!-- Cookies Bar -->
     <div id="cookies-bar" class="body-bar cookies-bar">
          <div class="body-bar-container container">
               <div class="body-bar-text">
                    <h4 class="mb-2">Cookies</h4>
                    <p>We use cookies in our website to improve your user experience. By Entering your details and proceeding, You agree to our T&C , Cookies and Privacy Policy listed at the bottom of the website</p>
               </div>
               <div class="body-bar-action">
                    <button class="btn btn-primary" data-accept="cookies"><span>Accept</span></button>
               </div>
          </div>
     </div>

     <!-- Modal / COVID -->
     <div class="modal fade" id="order-type" role="dialog" >
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header modal-header-lg dark bg-dark" style="padding: 5rem 2rem 1.5rem;">
                         <div class="bg-image" style=""><img src="{{ asset('themes') }}/soup/img/choose_bg.jpg" alt="">
                         </div>
                         <h3 style="margin-bottom: 0;font-size: 2.1rem;">Delivery/Collection</h3>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                   class="ti ti-close"></i></button>
                    </div>
                   
                    @isset($hours->offer)
                    @if($hours->offer == 1)
                    <div class="modal-product-details" style="padding:1.5rem 2rem;">
                         <ul class="list-check mb-0" style="font-size: 1.1rem;">
                              @if($hours->offer_deli && $restaurant->delivery)
                              <li>{{ (float) $hours->offer_deli}}% Off On All Delivery Orders 
                              @if((float)$hours->deli_min >0) 
                              Over
                                   {{$restaurant->currency}}
                                   {{(float)$hours->deli_min}}
                              @endif     
                                   </li>
                              
                                  
                              @endif
                              @if($hours->offer_coll && $restaurant->collection)
                              <li>{{(float) $hours->offer_coll}}% Off On All Collection Orders
                              @if((float)$hours->coll_min >0) 
                                                  Over
                                                  {{$restaurant->currency}}
                                                  {{(float)$hours->coll_min}}
                              @endif  
                                                    </li>
                              @endif
                             
                         </ul>
                    </div>

                    @endif
                    @endisset

                    <div class="modal-body">

                    @if($restaurant->collection==1)
                         <div class=" panel-details-size " >
                              <h5 class="panel-details-title" style="margin-bottom: 10px;font-size: 1.3rem;">
                                   <label class="custom-control custom-radio" style="pointer-events: All;">
                                        <input id="collection" name="ordertype" type="radio" value="collection"
                                             class="custom-control-input" autocomplete="off">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description" style="line-height: 1.5;">Collection
                                        </span>
                                   </label>
                                   <!--<a href="#panel-details-sizes-list" >Collection</a>-->
                              </h5>

                         </div>
                    @endif
                   
                    @if($restaurant->delivery==1)
                         @if($restaurant->collection==1)
                         <hr class="mt-0 mb-0"/>
                         @endif
                         <div class="panel-details-form">
                              <h5 class="panel-details-title" style="margin-top: 10px;font-size: 1.3rem;">
                                   <label class="custom-control custom-radio" style="pointer-events: All;">
                                        <input id="delivery" name="ordertype" type="radio" value="delivery"
                                             class="custom-control-input" autocomplete="off">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description"
                                             style="line-height: 1.5;">Delivery</span>

                                        <!--<a href="#panel-details-other" data-toggle="collapse">Delivery</a>-->
                                   </label>
                                   <!--<a href="#panel-details-other" data-toggle="collapse">Delivery</a>-->
                              </h5>
                              <div id="delivery-details" class="collapse">
                                   @if(!empty($delivery_charge))
                                        @switch($delivery_charge->first()->type)
                                             @case('free')
                                                  Delivery Fee : Free ( Below {{$restaurant->delivery_radius}} KM )
                                             @break
                                             @case('flat_rate')
                                                  Delivery Fee : {{$restaurant->currency}} {{$delivery_charge->first()->rate}} (Below {{$restaurant->delivery_radius}} KM) @if($delivery_charge->first()->free > 0), Free KM - {{$delivery_charge->first()->free}} @endif
                                             @break
                                             @case('km_rate')
                                                   Delivery Fee : 
                                                   @foreach($delivery_charge as  $kmcharge)
                                                            Above {{$kmcharge->free}} Km - {{$restaurant->currency}}{{$kmcharge->rate}}, 
                                                   @endforeach
                                             @break
                                             @case('post_code')
                                                   Delivery Fee : 
                                                   @foreach($delivery_charge as  $postcode)
                                                             {{$postcode->free}} - {{$restaurant->currency}}{{$postcode->rate}}, 
                                                   @endforeach
                                             @break
                                        @endswitch
                                  @endif     
                                                              
                                 
                                   <!--
                                   <div id="postcodeerr" class=" alert-danger pl-2 mb-1"></div>
                                   <form action="#">
                                        <div class="form-group">
                                             <label>Postcode</label>
                                             <input type="text" name="name" id="userpostcode" placeholder="Enter Your Full Postcode"
                                                  class="form-control" required="" aria-invalid="true">
                                        </div>
                                    
                                   </form>
                                    -->
                              </div>
                         </div>
                    @endif     
                         <!-- 
            <a href="page-offers.html" class="btn btn-outline-primary btn-block" tabindex="0"><span>Collection</span></a>
            <a href="menu-list-navigation.html" class="btn btn-outline-secondary btn-block"><span>Delivery</span></a>
      
                              <button class="btn btn-secondary" data-dismiss="modal"><span>Ok, thanks!</span></button>-->
                    </div>
                    <button type="button" data-dismiss="modal" id="proceed-btn" class="modal-btn btn btn-secondary btn-block btn-lg"
                         ><span>Proceed</span></button>

               </div>
          </div>
     </div>
   
<!-- Dine in Modal -->
<div class="modal" id="Dinein" role="dialog" data-backdrop="static">
     <div class="modal-dialog ">
       <div class="modal-content">  
         <!-- Modal Header -->
         <div class="modal-header p-3">
           <h4 class="modal-title">Dine In</h4>
           
         </div>
   
         <!-- Modal body -->
         <div class="modal-body ">
           Are you inside the Restaurant?
         </div>
   
         <!-- Modal footer -->
         <div class="modal-footer p-1">
           <button type="button" class="btn btn-success" data-dismiss="modal"><span>Yes</span></button>
           <a href="{{route('home')}}"><button type="button" class="btn btn-danger" >No</button></a>
         </div>   
       </div>
     </div>
   </div>
<!--- feedback model --->
<form id="feedbackform" action="" method="post">  
     @csrf 
   <div id="feedback" class="modal bottom  fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     
     <div class="modal-dialog modal-dialog-centered">
         
          <div class="modal-content">
               <div class="modal-header p-4">
                    <h3 id="myModalLabel" class="mb-0 ">Your Feedback</h3>
               </div>
               <div class="modal-body p-3 mt-1">
                   
                         <div class="form-group"><label>E-Mail</label><input name="fbemail" class="form-control email" placeholder="Your Email Address" type="text" required></div>
                         <div class="form-group"><label>Message</label><textarea name="fbmsg" class="form-control" placeholder="Your message here.."  required></textarea></div>
                    
                  
               </div>
               <div class="modal-footer p-2">
                              <button type="button" class="btn btn-dark" data-dismiss="modal"><span>Close</span></button>
                              <button id="sendfeedback"  type="submit" class="btn btn-success" value="submit"><span>Send It!</span></button>
               </div>
           </div>
       
          </div>
     
   </div>
 </form>
    <script src="{{ asset('themes') }}/soup/js/jquery.min.js"></script>
     <script src="{{ asset('themes') }}/soup/js/bootstrap.min.js"></script>

     <script src="{{ asset('themes') }}/soup/js/core.js"></script>
     <script src="{{ asset('themes') }}/soup/js/tata.js"></script>

 

    <script src="{{ asset('themes') }}/soup/js/scripts.js"></script>
     <script>
           if($('.cart-table').length){
                    $('#cart-count').html({{$total_qty}});
                    $('#cart-total').html({{$total_price}});
                    $('#cart-count-right').html({{$total_qty}});
           }
     </script>
     @stack('scripts')
</body>

</html>