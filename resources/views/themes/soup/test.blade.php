<!DOCTYPE html>
<html lang="en">

<head>

     <!-- Meta -->
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />
     <meta name="csrf-token" content="Fq6XaCViL4wTGS0fHag1epZPPuCPaaWLTJLLrDHz">
     <!-- Title -->
     <title> Menu - Order online</title>

     <!-- Favicons -->
     <link rel="shortcut icon" href="http://localhost/uk/blog/public/themes/soup/img/favicon.png">
     <link rel="apple-touch-icon" href="http://localhost/uk/blog/public/themes/soup/img/favicon_60x60.png">
     <link rel="apple-touch-icon" sizes="76x76" href="http://localhost/uk/blog/public/themes/soup/img/favicon_76x76.png">
     <link rel="apple-touch-icon" sizes="120x120" href="http://localhost/uk/blog/public/themes/soup/img/favicon_120x120.png">
     <link rel="apple-touch-icon" sizes="152x152" href="http://localhost/uk/blog/public/themes/soup/img/favicon_152x152.png">

     <!-- Fonts -->
     <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Raleway:wght@100;200;400;500&display=swap"
          rel="stylesheet">

     <!-- CSS Core -->
     <link rel="stylesheet" href="http://localhost/uk/blog/public/themes/soup/css/core.css" />

     <!-- CSS Theme -->
     <link id="theme" rel="stylesheet" href="http://localhost/uk/blog/public/themes/soup/css/theme-beige.css" />
    
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
                                        <img src="http://localhost/uk/blog/public/themes/soup/img/logo-light.svg" alt="" width="88">
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
                                        <li><a href="http://localhost/uk/blog/public/home">Menu</a></li>
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
                                   <span class="cart-value">$<span class="value">0.00</span></span>
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
                         <img src="http://localhost/uk/blog/public/themes/soup/img/logo-horizontal-dark.svg" alt="">
                    </a>
               </div>

               <a href="#" id="showcartmob" class="module module-cart">
                    <i class="ti ti-shopping-cart"></i>
                    <span class="notification">0</span>
               </a>

          </header>
          <!-- Header / End -->



          <!-- Panel Cart -->
       

       
          <!-- Body Overlay -->
          <div id="body-overlay"></div>

     </div>

     <!-- Modal / Product -->
     <div class="modal fade product-modal" id="addon-modal" role="dialog">
          <div class="modal-dialog" role="document">
               <div class="modal-content">
                    <div class="modal-header modal-header-lg dark bg-dark">
                         <div class="bg-image"><img src="http://localhost/uk/blog/public/themes/soup/img/modal-add.jpg" alt="">
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
                    <form action="#" method="get" id="addon-form" >
                         <div class="modal-body panel-details-container">
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

                                        <textarea cols="30" rows="4" class="form-control"
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
                         <div class="bg-image" style=""><img src="http://localhost/uk/blog/public/themes/soup/img/choose_bg.jpg" alt="">
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

     <script src="http://localhost/uk/blog/public/themes/soup/js/core.js"></script>
    
     <!--
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="http://localhost/uk/blog/public/themes/soup/js/scripts.js"></script>-->
     
</body>

</html>

