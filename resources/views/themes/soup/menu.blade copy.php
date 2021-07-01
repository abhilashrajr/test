<!DOCTYPE html>
<html lang="en">

<head>

     <!-- Meta -->
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />
     <meta name="csrf-token" content="{{ csrf_token() }}">
     <!-- Title -->
     <title> Menu - Order online</title>

     <!-- Favicons -->
     <link rel="shortcut icon" href="{{ asset('themes') }}/soup/img/favicon.png">
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
     .page-title{
          background-image: url("{{ asset('themes') }}/soup/img/menu-banner.jpg");
          background-size: cover;
     }


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
     </style>
</head>

<body>

     <!-- Body Wrapper -->
     <div id="body-wrapper" class="animsition">

          <!-- Header -->
          <header id="header" class="light">

               <div class="container">
                    <div class="row">
                         <div class="col-md-3">
                              <!-- Logo -->
                              <div class="module module-logo dark">
                                   <a href="index.html">
                                        <img src="{{ asset('themes') }}/soup/img/logo-light.svg" alt="" width="88">
                                   </a>
                              </div>
                         </div>
                         <div class="col-md-7">
                              <!-- Navigation -->
                              <nav class="module module-navigation left mr-4">
                                   <ul id="nav-main" class="nav nav-main">
                                        <li>
                                             <a href="/site/">Home</a>

                                        </li>
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

                                        <li><a href="/site/page-offers.html">Offers</a></li>
                                        <li><a href="/site/page-contact.html">Contact</a></li>

                                   </ul>
                              </nav>
                              <!-- <div class="module left">
                                   <a href="menu-list-navigation.html"
                                        class="btn btn-outline-secondary"><span>Order</span></a>
                              </div>-->
                         </div>
                         <div class="col-md-2">
                              <a href="#" id="showcart" class="module module-cart right" data-toggle="panel-cart">
                                   <span class="cart-icon">
                                        <i class="ti ti-shopping-cart"></i>
                                        <span class="notification">0</span>
                                   </span>
                                   <span class="cart-value">$<span class="value cart-total">0.00</span></span>
                              </a>
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
                         <img src="{{ asset('themes') }}/soup/img/logo-horizontal-dark.svg" alt="">
                    </a>
               </div>

               <a href="#" id="showcartmob" class="module module-cart">
                    <i class="ti ti-shopping-cart"></i>
                    <span class="notification">0</span>
               </a>

          </header>
          <!-- Header / End -->

          <!-- Content -->
          <div id="content">

               <!-- Page Title -->
               <div class="page-title bg-light">
                    <div class="container">
                         <div class="row">
                              <div class="col-lg-8 offset-lg-4">
                                   <h1 class="mb-0">Menu</h1>
                                   <h4 class="text-muted mb-0">Some informations about our restaurant</h4>
                              </div>
                         </div>
                    </div>
               </div>

               <!-- Page Content -->
               <div class="page-content">
                    <div class="container">
                         <div class="row no-gutters">
                              <div class="col-md-10 offset-md-1" role="tablist">

                                   <div class="row mb-4">
                                        <div class="col-9 col-md-6">
                                             <div class="form-group has-search">
                                                  <span class="fa fa-search form-control-feedback"></span>
                                                  <input type="text" name="search-food" id="search-food"
                                                       class="form-control"
                                                       style="box-shadow:none;border: 1px solid #aeaeae;color:#000;border-radius:8px;"
                                                       placeholder="Search for dishes..." autocomplete="off">
                                             </div>

                                        </div>
                                        <div class="col-3 col-md-6" style="padding-left: 0px;">
                                             <div class="form-group pull-right mt-3"><label
                                                       class="custom-control custom-checkbox"
                                                       style="margin-right: 0px;"><input type="checkbox" name="veg-only"
                                                            id="veg-only" value="veg" class="custom-control-input"
                                                            required="" autocomplete="off"><span
                                                            class="custom-control-indicator" style="border: 2px solid #c6c5c5;"><svg class="icon" x="0px"
                                                                 y="0px" viewBox="0 0 32 32">
                                                                 <path stroke-dasharray="19.79 19.79"
                                                                      stroke-dashoffset="19.79" fill="none"
                                                                      stroke="#FFFFFF" stroke-width="4"
                                                                      stroke-linecap="square" stroke-miterlimit="10"
                                                                      d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11">
                                                                 </path>
                                                            </svg></span><span class="custom-control-description"
                                                            style="color: #575757;">Veg&nbsp;Only</span></label></div>

                                        </div>
                                   </div>




                                   @forelse($data as $category)

                                   <!-- Menu Category / Burgers -->
                                   <div id="menu-category{{$category->id}}" class="menu-category"
                                        data-id="{{$category->id}}">
                                        <div class="menu-category-title collapse-toggle" role="tab"
                                             data-target="#menuContent{{$category->id}}" data-toggle="collapse"
                                             aria-expanded="true">
                                             <div class="bg-image"><img
                                                       src="{{ url('storage/images/'.$category->image)}}" alt=""></div>
                                             <h2 class="title">{{$category->name}}</h2>
                                        </div>
                                        <div id="menuContent{{$category->id}}" class="menu-category-content collapse">

                                             @forelse($category->menu as $menu)

                                             <!-- Menu Item -->
                                             <div class="menu-item menu-list-item" @if($menu->veg ==1) data-veg="true"
                                                  @endif>
                                                  <div class="row align-items-center">
                                                       <div class="col-sm-6 mb-2 mb-sm-0">
                                                            <h6 class="mb-0">{{$menu->name}} @if($menu->best_seller ==1)
                                                                 <span class="badge badge-notify"
                                                                      style="font-size:10px;">Best seller</span>@endif
                                                                 @if($menu->veg ==1)
                                                                 <span class="badge veg-badge-notify"
                                                                      style="font-size:10px;">Veg</span>@endif
                                                            </h6>
                                                            <span
                                                                 class="text-muted text-sm">{{$menu->description}}</span>
                                                       </div>
                                                       <div class="col-sm-6 text-sm-right">
                                                            <span class="text-md mr-4"><span
                                                                      class="text-muted">from</span> $<span
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
               <footer id="footer" class="bg-dark dark">

                    <div class="container">
                         <!-- Footer 1st Row -->
                         <div class="footer-first-row row">
                              <div class="col-lg-3 text-center">
                                   <a href="index.html"><img src="{{ asset('themes') }}/soup/img/logo-light.svg" alt=""
                                             width="88" class="mt-5 mb-5"></a>
                              </div>
                              <div class="col-lg-4 col-md-6">
                                   <h5 class="text-muted">Latest news</h5>
                                   <ul class="list-posts">
                                        <li>
                                             <a href="blog-post.html" class="title">How to create effective
                                                  webdeisign?</a>
                                             <span class="date">February 14, 2015</span>
                                        </li>
                                        <li>
                                             <a href="blog-post.html" class="title">Awesome weekend in Polish
                                                  mountains!</a>
                                             <span class="date">February 14, 2015</span>
                                        </li>
                                        <li>
                                             <a href="blog-post.html" class="title">How to create effective
                                                  webdeisign?</a>
                                             <span class="date">February 14, 2015</span>
                                        </li>
                                   </ul>
                              </div>
                              <div class="col-lg-5 col-md-6">
                                   <h5 class="text-muted">Subscribe Us!</h5>
                                   <!-- MailChimp Form -->
                                   <form action="
                                        id="sign-up-form" class="sign-up-form validate-form mb-5" method="POST">
                                        <div class="input-group">
                                             <input name="EMAIL" id="mce-EMAIL" type="email" class="form-control"
                                                  placeholder="Tap your e-mail..." required>
                                             <span class="input-group-btn">
                                                  <button class="btn btn-primary btn-submit" type="submit">
                                                       <span class="description">Subscribe</span>
                                                       <span class="success">
                                                            <svg x="0px" y="0px" viewBox="0 0 32 32">
                                                                 <path stroke-dasharray="19.79 19.79"
                                                                      stroke-dashoffset="19.79" fill="none"
                                                                      stroke="#FFFFFF" stroke-width="2"
                                                                      stroke-linecap="square" stroke-miterlimit="10"
                                                                      d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11" />
                                                            </svg>
                                                       </span>
                                                       <span class="error">Try again...</span>
                                                  </button>
                                             </span>
                                        </div>
                                   </form>
                                   <h5 class="text-muted mb-3">Social Media</h5>
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
                         </div>
                         <!-- Footer 2nd Row -->
                         <div class="footer-second-row">
                              <span class="text-muted">Copyright Soup 2020©. Made with love by Suelo.</span>
                         </div>
                    </div>

                    <!-- Back To Top -->
                    <button id="back-to-top" class="back-to-top"><i class="ti ti-angle-up"></i></button>

               </footer>
               <!-- Footer / End -->

          </div>
          <!-- Content / End -->

          <!-- Panel Cart -->
          <div id="panel-cart">
               <div class="panel-cart-container">
                    <div class="panel-cart-title">
                         <h5 class="title">Your Cart</h5>
                         <button class="close" id="cartclose" data-toggle="panel-cart"><i
                                   class="ti ti-close"></i></button>
                    </div>
                    <div class="panel-cart-content cart-details">
                         <table class="cart-table" id="cart">
                              @php
                              $total_price = 0;
                              $total_qty = 0;
                              @endphp

                              @forelse($cart as $key => $item)
                              <tr>
                                   <td>{{ $item['name'] }}</td>
                                   <td>{{ $item['quantity'] }}</td>
                                   <td>{{ $item['price'] }}</td>
                                   <td class="actions"><a href="#product-modal" data-toggle="modal"
                                             class="action-icon"><i class="ti ti-pencil"></i></a> <a href="#"
                                             class="action-icon remove-item" data-id="{{$key}}"><i
                                                  class="ti ti-close"></i></a> </td>



                                   @php
                                   $total_price += $item['quantity'] * $item['price'];
                                   $total_qty += $item['quantity'];
                                   @endphp
                              </tr>
                              @empty
                              @endforelse
                         </table>
                         <div class="cart-summary">
                              <div class="row">
                                   <div class="col-7 text-right text-muted">Order total:</div>
                                   <div class="col-5"><strong>$<span
                                                  class="cart-products-total">{{ round($total_price,2)}}</span></strong>
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col-7 text-right text-muted">Devliery:</div>
                                   <div class="col-5"><strong>$<span class="cart-delivery">0.00</span></strong></div>
                              </div>
                              <hr class="hr-sm">
                              <div class="row text-lg">
                                   <div class="col-7 text-right text-muted">Total:</div>
                                   <div class="col-5"><strong>$<span
                                                  class="cart-total">{{ round($total_price,2)}}</span></strong></div>
                              </div>
                         </div>
                         @empty($cart)
                         <div class="cart-empty" style="display:block;">
                              <i class="ti ti-shopping-cart"></i>
                              <p>Your cart is empty...</p>
                         </div>
                         @endempty


                    </div>
               </div>
               <a href="{{ route('checkout') }}" class="panel-cart-action btn btn-secondary btn-block btn-lg"><span>Go to
                         checkout</span></a>
          </div>

          <!-- Panel Mobile -->
          <nav id="panel-mobile">
               <div class="module module-logo bg-dark dark">
                    <a href="#">
                         <img src="{{ asset('themes') }}/soup/img/logo-light.svg" alt="" width="88">
                    </a>
                    <button class="close" data-toggle="panel-mobile"><i class="ti ti-close"></i></button>
               </div>
               <nav class="module module-navigation"></nav>
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
                         <h4 class="modal-title">Specify your dish</h4>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                   class="ti ti-close"></i></button>
                    </div>
                    <!-- <div class="modal-product-details">
                         <div class="row align-items-center">
                              <div class="col-9">
                                   <h6 class="mb-1 product-modal-name">Boscaiola Pasta</h6>
                                   <span class="text-muted product-modal-ingredients">Pasta, Cheese, Tomatoes,
                                        Olives</span>
                              </div>
                              <div class="col-3 text-lg text-right">$<span class="product-modal-price"></span></div>
                         </div>
                    </div>-->
                    <form action="#" method="get" id="addon-form">
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
                    <h4 class="mb-2">Cookies & GDPR</h4>
                    <p>This is a sample Cookies / GDPR information. You can use it easily on your site and even add link
                         to <a href="#">Privacy Policy</a>.</p>
               </div>
               <div class="body-bar-action">
                    <button class="btn btn-primary" data-accept="cookies"><span>Accept</span></button>
               </div>
          </div>
     </div>

     <!-- Modal / COVID -->
     <div class="modal fade" id="order-type" role="dialog" data-timeout="1000" data-set-cookie="covid-modal">
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header modal-header-lg dark bg-dark" style="padding: 5rem 2rem 1.5rem;">
                         <div class="bg-image" style=""><img src="{{ asset('themes') }}/soup/img/choose_bg.jpg" alt="">
                         </div>
                         <h3 style="margin-bottom: 0;font-size: 2.1rem;">Delivery/Collection</h3>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                   class="ti ti-close"></i></button>
                    </div>
                    <div class="modal-product-details" style="padding:1.5rem 2rem;">
                         <ul class="list-check mb-0" style="font-size: 1.1rem;">
                              <li>30% off on all delivery orders over £20</li>
                              <li>30% off on all collection orders over £25</li>
                         </ul>
                    </div>

                    <div class="modal-body">
                         <div class=" panel-details-size " style="border-bottom: 1px solid #e0e0e0;">
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
                                   <form action="#">
                                        <div class="form-group">
                                             <label>Postcode:</label>
                                             <input type="text" name="name" placeholder="Enter Your Full Postcode"
                                                  class="form-control" required="" aria-invalid="true">
                                        </div>
                                        <a href="#" class="btn btn-primary " data-dismiss="modal"
                                             tabindex="0"><span>Skip</span></a>
                                   </form>
                              </div>
                         </div>
                         <!-- 
            <a href="page-offers.html" class="btn btn-outline-primary btn-block" tabindex="0"><span>Collection</span></a>
            <a href="menu-list-navigation.html" class="btn btn-outline-secondary btn-block"><span>Delivery</span></a>
      
                              <button class="btn btn-secondary" data-dismiss="modal"><span>Ok, thanks!</span></button>-->
                    </div>
                    <button type="button" id="proceed-btn" class="modal-btn btn btn-secondary btn-block btn-lg"
                         data-dismiss="modal"><span>Proceed</span></button>

               </div>
          </div>
     </div>

     <script src="{{ asset('themes') }}/soup/js/core.js"></script>
     <script src="{{ asset('themes') }}/soup/js/tata.js"></script>

<!--
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

     
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="{{ asset('themes') }}/soup/js/scripts.js"></script>-->
     <script>
     $(document).ready(function() {
          $('.add-to-cart').on('click', function(e) {


               $.ajaxSetup({
                    headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
               });
               var menu_id = $(this).data("id");
               $.ajax({
                    type: 'POST',
                    url: "addtocart",
                    data: {
                         menu_id: menu_id,
                         addon: true
                    },
                    dataType: 'json',
                    success: function(data) {
                         if (data.status == "addons") {
                              $("#addon-alert").hide();
                              $('#addon-modal').modal('show');
                              var html =
                                   '<input type="hidden"  name="menu_id" value="' +
                                   menu_id + '">'
                              var first = ''
                              $.each(data.data, function(index, element) {
                                   html +=
                                        '<div class="panel-details panel-details-size"><h5 class="panel-details-title"><!--<label class="custom-control custom-radio"><input name="radio_title_size" type="radio" class="custom-control-input"><span class="custom-control-indicator"></span></label>--><a href="#panel-details-sizes-list' +
                                        index +
                                        '" data-toggle="collapse"  style="display: block;">' +
                                        element.acategory +
                                        ' <span class="icon icon-sm pull-right"><i class="ti ti-angle-down"></i></span></a></h5><div id="panel-details-sizes-list' +
                                        index + '" class="collapse ' +
                                        first +
                                        '"><div class="panel-details-content" data-required="' +
                                        element.required +
                                        '"  data-addon="'+ element.acategory +'"><div class="product-modal-sizes">'
                                   if (element.multiple) {
                                        $.each(element.aitems, function(
                                             index2, value) {
                                             html +=
                                                  '<div class="form-group"><label class="custom-control custom-checkbox"><input type="checkbox" name="addons[' +
                                                  index +
                                                  '][]" value="' +
                                                  value.item_id +
                                                  '" class="custom-control-input"  ><span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span><span class="custom-control-description">' +
                                                  value.name +
                                                  ' - (' + value
                                                  .price +
                                                  ')</span></label></div>'
                                        });
                                   } else {
                                        $.each(element.aitems, function(
                                             index2, value) {
                                             html +=
                                                  '<div class="form-group"><label class="custom-control custom-radio"><input name="addons[' +
                                                  index +
                                                  '][]"  type="radio"  value="' +
                                                  value.item_id +
                                                  '"  class="custom-control-input" ><span class="custom-control-indicator"><svg class="icon" x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="4" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"></path></svg></span><span class="custom-control-description">' +
                                                  value.name +
                                                  ' - (' + value
                                                  .price +
                                                  ')</span></label></div>'
                                        });
                                   }
                                   html += '</div></div></div></div>'
                                   first = ''
                              });
                              $('#addon-content').html(html);
                              $('#other_info').val('');
                              $('#other-form').show();
                              // $('#addon-model-add-btn').data('id', menu_id);
                         } else {
                              //var html = '<table id="cart-table"><thead><tr><th >Name</th><th>Progress</th><th>Gender</th><th>Height</th><th>Favourite Color</th></tr></thead><tbody><tr>'
                              cartupdate(data.data);
                              tata.success('', 'Item added to cart')
                         }
                    }
               })



          })



          $('#addon-form').submit(function(e) {
               e.preventDefault();
               var err = 0;
               // verror[0] = ""; 
               $("#addon-alert").hide();
               $("#addon-alert").empty();
               
               $('.panel-details-content').each(function() {
                    if ($(this).data('required')) {
                         var check = 0;
                         $(this).find(':input').each(function() {
                              if ($(this).prop('checked') == true) {
                                  check++;
                              }
                             
                         });
                         if(check==0){
                              $("#addon-alert").append('<p class="mb-0">'+$(this).data('addon')+' is required</p>');
                              err++;
                         }
                    }


               });
               if(err>0){
                    $("#addon-alert").show();
                    return false;
               }else{
                   
               }
                       



               $.ajaxSetup({
                    headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
               });
               $.ajax({
                    type: 'POST',
                    url: "addtocart",
                    data: $('#addon-form').serialize(),
                    dataType: 'json',
                    success: function(data) {
                         $('#addon-modal').modal('hide');
                         cartupdate(data.data);
                         tata.success('', 'Item added to cart')
                    }
               });

          });

          /*

                    $('#add-to-cart-model').on('click', function(e) {
                         $.ajaxSetup({
                              headers: {
                                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                              }
                         });
                         $.ajax({
                              type: 'POST',
                              url: "addtocart",
                              data: $('#addon-form').serialize(),
                              dataType: 'json',
                              success: function(data) {
                                   $('#addon-modal').modal('hide');
                                   cartupdate(data.data);
                                   tata.success('', 'Item Added')
                              }
                         });
                    });
          */
          $(document).on('click', '.remove-item', function(event) {
               event.preventDefault();
               $.ajaxSetup({
                    headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
               });
               $.ajax({
                    type: 'POST',
                    url: "removeitem",
                    data: {
                         menu_id: $(this).data("id")
                    },
                    dataType: 'json',
                    success: function(data) {
                         cartupdate(data.data);
                         tata.error('', 'Item Removed From Cart')
                    }
               });
          });

          function cartupdate(cart) {
               var html = '';
               var total_price = 0;
               var total_qty = 0;
               $.each(cart, function(key, item) {
                    html += '<tr><td>' + item.name +
                         '</td><td>' + item.quantity +
                         '</td><td>' + item.price +
                         '</td><td class="actions"><a href="#product-modal" data-toggle="modal" class="action-icon"><i class="ti ti-pencil"></i></a> <a href="#" class="action-icon remove-item" data-id="' +
                         key + '"><i class="ti ti-close"></i></a>  </td></tr>';
                    total_price += parseInt(item.quantity) * parseFloat(item.price);
                    total_qty += parseInt(item.quantity);
               })
               $('.cart-table').html(html);
               $('.cart-products-total').html(total_price.toFixed(2));
               $('.cart-total').html(total_price.toFixed(2));
               $('.notification').html(total_qty);
               if (total_qty > 0)
                    $('.cart-empty').hide();
               else
                    $('.cart-empty').show();


          }
          //page load update cart
          $('.notification').html({{$total_qty}});

          /*----  Search -------------*/
          var searchTerm, panelContainer, txtValue, veg;

          $('#search-food').on('change keyup paste', function() {
               searchTerm = $(this).val();
               if (searchTerm != "") {
                    veg = $('#veg-only').is(':checked');
                    $('.menu-category-title').hide();
                    $('.menu-category').each(function() {
                         panelContainer = 'menuContent' + $(this).data('id');
                         $('#' + panelContainer + ' > .menu-item').each(function() {
                              //console.log(veg);
                              //console.log($(this).data('veg'));
                              //if(veg && (typeof  $(this).data('veg') ==="undefined")
                                  // return;
                              txtValue = $(this).text();
                              if (txtValue.toUpperCase().indexOf(searchTerm
                                        .toUpperCase()) > -1) {

                                   $(this).show();
                                   $('#' + panelContainer).addClass('show');
                                   
                              } else {
                                   $(this).hide();
                                   $('#' + panelContainer).removeClass('show');
                              }
                         });
                    });
               } else {
                    $('.menu-category-title').show();
                    $('.menu-item').show();
                    $('.menu-category-content').removeClass('show');
               }
          });


          $('#veg-only').on('click', function() {
               if ($(this).prop("checked") == true) {
                    $('.menu-category').each(function() {
                         var catId = $(this).data('id');
                         panelContainer = 'menuContent' + $(this).data('id');
                         var count = 0;
                         $('#' + panelContainer + ' > .menu-item').each(function() {
                              if (!$(this).data('veg')) {
                                   $(this).hide();
                              } else {
                                   count++;
                              }
                         });
                         if (count == 0)
                              $('#menu-category' + catId).hide();

                    });
               } else {
                    $('.menu-item').show();
                    $('.menu-category').show();
               }

          });


          $('#proceed-btn').on('click', function(e) {
               if (localStorage) {
                    localStorage.setItem("ordertype", $(
                         'input[name="ordertype"]:checked').val());
               }
          });

          $('#showcart,#cartclose,#showcartmob').on('click', function(e) {
               $('#panel-cart').toggleClass('show');
          })


          $('#delivery').on('click', function(e) {
               $('#delivery-details').collapse('show')
          })
          $('#collection').on('click', function(e) {
               $('#delivery-details').collapse('hide')
          })

          if (localStorage.getItem("ordertype") === null) {
              // $('#order-type').model('show');
          }


          var prevValue = "";
          $(document.body).on("click", "#addon-modal input:radio", function() {
               var rvalue = $(this).val();
               if (prevValue == rvalue) {
                    $(this).prop('checked', false);
                    prevValue = "";
               } else {
                    prevValue = rvalue;
               }
          });




     });
     </script>
</body>

</html>