@extends('layouts.soup', [
'class' => '',
'elementActive' => 'menu',
'title'=>"Best restaurant and Takeaway in ".$restaurant->city."   ".$restaurant->name.", Order directly and save money, Just order online, ".$restaurant->name."  order your takeaway, order online special discount, ".$restaurant->name."  ".$restaurant->address." ,".$restaurant->city."," .$restaurant->state.",".$restaurant->postcode." ,".$restaurant->name.",".$restaurant->city. "",
'restaurant' =>$restaurant,
'hours'=>$hours
])
@push('styles')
<style>
.page-title {
     background-image: url("{{ asset('themes') }}/soup/img/menu-banner1.jpg");
     background-size: cover;
     
}

.cartbtn {
     position: fixed;
     right: 0;
     top: 46%;
     display: none;
}

.notification {
     border-radius: 30px;
     position: absolute;
     top: -11.2px;
     top: -.8rem;
     right: 0;
     background-color: #4aa36b;
     color: #fff;
     font-weight: 600;
     font-size: 9.799px;
     font-size: .7rem;
     display: inline-block;
     padding: .15rem .3rem .2rem .35rem;
     line-height: 1;
}
.menu-category-title2 h2.title{
     border-bottom: 5px solid #ffa25f;
     width: max-content;
}


.bounce {
     -webkit-animation-name: bounce;
     animation-name: bounce;
     -webkit-transform-origin: center bottom;
     -ms-transform-origin: center bottom;
     transform-origin: center bottom;
     -webkit-animation-duration: 1s;
     animation-duration: 1s;
     -webkit-animation-fill-mode: both;
     animation-fill-mode: both;
}

@-webkit-keyframes bounce {

     0%,
     20%,
     53%,
     80%,
     100% {
          -webkit-transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
          transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
          -webkit-transform: translate3d(0, 0, 0);
          transform: translate3d(0, 0, 0);
     }

     40%,
     43% {
          -webkit-transition-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
          transition-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
          -webkit-transform: translate3d(0, -30px, 0);
          transform: translate3d(0, -30px, 0);
     }

     70% {
          -webkit-transition-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
          transition-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
          -webkit-transform: translate3d(0, -15px, 0);
          transform: translate3d(0, -15px, 0);
     }

     90% {
          -webkit-transform: translate3d(0, -4px, 0);
          transform: translate3d(0, -4px, 0);
     }
}

@keyframes bounce {

     0%,
     20%,
     53%,
     80%,
     100% {
          -webkit-transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
          transition-timing-function: cubic-bezier(0.215, 0.610, 0.355, 1.000);
          -webkit-transform: translate3d(0, 0, 0);
          transform: translate3d(0, 0, 0);
     }

     40%,
     43% {
          -webkit-transition-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
          transition-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
          -webkit-transform: translate3d(0, -30px, 0);
          transform: translate3d(0, -30px, 0);
     }

     70% {
          -webkit-transition-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
          transition-timing-function: cubic-bezier(0.755, 0.050, 0.855, 0.060);
          -webkit-transform: translate3d(0, -15px, 0);
          transform: translate3d(0, -15px, 0);
     }

     90% {
          -webkit-transform: translate3d(0, -4px, 0);
          transform: translate3d(0, -4px, 0);
     }
}
</style>
@endpush
@section('content')
<!-- Content -->
<div id="content">

     <!-- Page Title -->
     <div class="page-title bg-light">
          <div class="container">
               <div class="row">
                    <div class="col-lg-8 offset-lg-4">
                         <h1 class="mb-0">{{$cart["order_type"] == "dinein" ? "Dine In " :""}}Menu</h1>
                         <h4 class="text-muted mb-0"></h4>
                    </div>
               </div>
          </div>
     </div>
@php
$cur_time   =   strtotime(date("H:i:s"));
$open = false;
$start1    =   strtotime($hours->start1);
$end1   =   strtotime($hours->end1);
$start2    =   strtotime($hours->start2);
$end2   =   strtotime($hours->end2);
if($restaurant->active==0){
     $msg = "Restaurant is closed now";
}else if($hours->active == 0){
     $msg = "Restaurant is closed for today";
}else if(!empty($start1) && ($cur_time < $start1))
{
     $msg = "Restaurant is closed now, Will open at ".$hours->start1;
}else if(!empty($start2) && ($cur_time > $end1) && ($cur_time < $start2)){
     $msg = "Restaurant is closed now, Will open at ".$hours->start2;
}else if(!empty($end2) && ($cur_time > $end2)){
     $msg = "Restaurant is closed now"; //start3
}else{
     $open = true;
     $msg = "";
}
//else if(($start1 < $cur_time && $end1 > $cur_time) || ($start2 < $cur_time &&  $end2 > $cur_time) )
@endphp
     <!-- Page Content -->
     <div class="page-content">
          <div class="container">
                @if($msg!="")
                         <div class="row mb-0 mt-n3">
                              <div class="col-md-6 offset-md-3">
                                   <div class="alert alert-danger text-center shadow" style="border:2px solid #902224;border-radius:30px; "> 
                                        <strong>{{$msg}}</strong> 
                                   </div>
                              </div>
                         </div>
                    @endif     
               <div class="row no-gutters">
                    
                    <div class="col-md-3">
                        <!-- Menu Navigation -->
                        <nav id="menu-navigation" class="stick-to-content mr-3" data-local-scroll>
                            <ul class="nav nav-menu bg-dark dark">
                            @forelse($data as $category)
                                <li><a href="#menu-category{{$category->id}}">{{$category->name}}</a></li>
                                @empty
                               <li>No Data</li>
                         @endforelse
                            </ul>
                        </nav>
                    </div>
               
               
               <div class="col-md-9" >                      
                         <div class="row mb-2">
                              <div class="col-9 col-md-6">
                                   <div class="form-group has-search">
                                        <span class="fa fa-search form-control-feedback"></span>
                                        <input type="text" name="search-food" id="search-food" class="form-control"
                                             style="box-shadow:none;border: 1px solid #aeaeae;color:#000;border-radius:8px;"
                                             placeholder="Search for dishes..." autocomplete="off">
                                   </div>

                              </div>
                              <div class="col-3 col-md-6" style="padding-left: 0px;">
                                   <div class="form-group pull-right mt-3"><label class="custom-control custom-checkbox"
                                             style="margin-right: 0px;"><input type="checkbox" name="veg-only"
                                                  id="veg-only" value="veg" class="custom-control-input" required=""
                                                  autocomplete="off"><span class="custom-control-indicator"
                                                  style="border: 2px solid #c6c5c5;"><svg class="icon" x="0px" y="0px"
                                                       viewBox="0 0 32 32">
                                                       <path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79"
                                                            fill="none" stroke="#FFFFFF" stroke-width="4"
                                                            stroke-linecap="square" stroke-miterlimit="10"
                                                            d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11">
                                                       </path>
                                                  </svg></span><span class="custom-control-description"
                                                  style="color: #575757;">Veg&nbsp;Only</span></label></div>

                              </div>
                         </div>

                         @if(($hours->offer == 1) &&  ($cart["order_type"] == "deli_coll"))

                              <div class="row">
                                   <div class="col-md-12">
                                        <div class="listing listing-radius listing-danger">
                                             <div class="shape">
                                                  <div class="shape-text">Offer</div>
                                             </div>
                                             <div class="listing-content p-3">
                                                  @if($hours->offer_deli && $restaurant->delivery && $hours->offer_deli!=0)
                                                  <p class="title mb-1" style="font-weight:500;">{{ (float) $hours->offer_deli}}% Off On All Delivery Orders  
                                                  @if((float)$hours->deli_min >0) 
                                                       Over
                                                       {{$restaurant->currency}}
                                                       {{(float)$hours->deli_min}}
                                                  @endif     
                                                  </p>
                                             @endif
                                                  @if($hours->offer_coll && $restaurant->collection && $hours->offer_coll != 0)
                                                  <p class="title mb-0" style="font-weight:500;">{{(float) $hours->offer_coll}}% Off On All Collection Orders 
                                             @if((float)$hours->coll_min >0) 
                                                       Over
                                                       {{$restaurant->currency}}
                                                       {{(float)$hours->coll_min}}
                                                  @endif     
                                                  </p>
                                                  @endif

                                             </div>
                                        </div>
                                   </div>
                              
                              </div>  
                              @endif


                         @forelse($data as $category)

                         <!-- Menu Category / Burgers -->
                         <div id="menu-category{{$category->id}}" class="menu-category" data-id="{{$category->id}}">
                              <div class="menu-category-title2" >
                                  
                                   <h2 class="title" style="font-weight: 200;">{{$category->name}}</h2>
                              </div>
                              <div id="menuContent{{$category->id}}" class="menu-category-content">

                                   @forelse($category->menu as $menu)

                                   <!-- Menu Item -->
                                   <div class="menu-item menu-list-item" @if($menu->veg ==1) data-veg="true"
                                        @endif>
                                        <div class="row align-items-center">
                                             <div class="col-sm-6 mb-2 mb-sm-0">
                                                  <h6 class="mb-0" id="menu-{{$menu->id}}">{{$menu->name}} @if($menu->best_seller !=0)
                                                       <span class="badge badge-notify" style="font-size:10px;">
                                                       @switch($menu->best_seller)
                                                       @case(1)
                                                            Best seller 	
                                                            @break
                                                       @case(2)
                                                            Must Try
                                                            @break
                                                       @case(3)
                                                            Hot 	
                                                            @break
                                                       @case(4)
                                                            Spicy
                                                            @break
                                                       @default
                                                           
                                                       @endswitch
                                                      
                                                            
                                                            </span>@endif
                                                       @if($menu->veg ==1)
                                                       <span class="badge veg-badge-notify"
                                                            style="font-size:10px;">Veg</span>@endif
                                                  </h6>
                                                  <span class="text-muted text-sm">{{$menu->description}}</span>
                                             </div>
                                             <div class="col-sm-6 text-sm-right">
                                                  <span class="text-md mr-4">@if(in_array($menu->id,$addonmenu))<span class="text-muted">from</span>@endif   {{$restaurant->currency}}<span
                                                            data-product-base-price>{{$menu->price}}</span></span>
                                                  <button
                                                       class="btn btn-outline-secondary btn-sm pull-right add-to-cart"
                                                       data-id="{{$menu->id}}"><span>Add to
                                                            cart</span></button>
                                             </div>
                                        </div>
                                   </div>
                                   @empty
                                   <p>No Items</p>
                                   @endforelse


                              </div>
                         </div>

                         @empty
                         <p>No Data</p>
                         @endforelse

                    </div>
               </div>
          </div>
     </div>

     <!-- Footer -->
     @include('layouts.soup-footer')
     <!-- Footer / End -->

</div>
<!-- Content / End -->
<div class="cartbtn" id="cart-btn">
     <a href="#" id="cart-icon" class="  module module-cart right" data-toggle="panel-cart">
          <span class="cart-icon ">
               <!--<i class="ti ti-shopping-cart shadow rounded-circle p-2 "
                    style="font-size:25px;color:#666;background:#fff;border:3px solid #4aa36b;"></i>-->
                    <img src="{{ asset('themes') }}/soup/img/cart.png" alt="">
               <span id="cart-count-right" class="notification">0</span>
          </span>
     </a>
</div>
@endsection
@push('scripts')
<script src="{{ asset('themes') }}/soup/js/bootstrap-input-spinner.js"></script>
<script>
 
$(document).ready(function() {
    
     $(window).scroll(function() {
          if ($(window).scrollTop() >= 100) {
               $('#cart-btn').show("slide");
          } else {
               $('#cart-btn').hide("slide");
          }
     });
     if ($(window).scrollTop() >= 100) {
          $("#cart-btn").show("slide");

     }
    
    
     @if( isset($cart["order_type"]) && $cart["order_type"] == "deli_coll")
          if (localStorage.getItem("ordertype") === null) {
               $('#order-type').modal('show');
          }
     @endif

     @if(session()->has('popup') && session()->get('popup') && $open && isset($cart["order_type"]) && $cart["order_type"] == "deli_coll")
          if (localStorage.getItem("ordertype") !== null)
               localStorage.removeItem("ordertype");    
          $('#order-type').modal('show'); 
     @endif
     @php
          session()->put('popup', FALSE);
     @endphp
     @if($cart["order_type"] == "dinein")       
         $('#Dinein').modal('show');
     @endif
    
});
</script>
@endpush