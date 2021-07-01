@extends('layouts.app', [
'title' => 'Settings',
'class' => '',
'elementActive' => 'settings'
])

@push('styles')
<link rel="stylesheet" type="text/css" media="screen" href="{{asset('paper') }}/css/tempusdominus-bootstrap-4.css">
<style>
.table td,
.table th {
     padding: .5rem .4rem !important;
}

hr {
     margin-top: 0rem !important;
}

.switch {
     float: right;
}

.form-control {
     background-color: #FFF !important;
}

.col-form-label {
     color: #aaaab0;
     font-weight: bold;
}

/*
*
* ==========================================
* CUSTOM UTIL CLASSES
* ==========================================
*/
.nav-pills-custom .nav-link {
     color: #aaa;
     background: #f4f3ef;
     position: relative;
}

.nav-pills-custom .nav-link.active {
     color: #ef8157;
     background: #f4f3ef;
}


/* Add indicator arrow for the active tab */
@media (min-width: 992px) {
     .nav-pills-custom .nav-link::before {
          content: '';
          display: block;
          border-top: 8px solid transparent;
          border-left: 10px solid #fff;
          border-bottom: 8px solid transparent;
          position: absolute;
          top: 50%;
          right: -10px;
          transform: translateY(-50%);
          opacity: 0;
     }
}

.nav-pills-custom .nav-link.active::before {
     opacity: 1;
}

#v-pills-tabContent {
     background-color: #f4f3ef;
}

.bootstrap-datetimepicker-widget a.btn {
     background-color: #fff !important;
}

.timepicker1 {
     margin-bottom: 0px;
}
</style>
@endpush

@section('content')
<div class="content">
     <form method="POST" action="{{ route('settings.update',$data->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PATCH')

          <div class="row">
               <div class=" col-12 col-sm-12 col-md-12  col-lg-12 col-xl-10">
                    <div class="card">
                         <div class="card-header">
                              <h4 class="card-title">Settings</h4>
                         </div>
                         <div class="card-body">
                              @if($errors->any())
                              <div class="alert alert-danger">
                                   <ul class="mb-0">

                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                   </ul>
                              </div>
                              @endif
                              <div class="row">
                                   <div class="col-md-3">
                                        <!-- Tabs nav -->
                                        <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab"
                                             role="tablist" aria-orientation="vertical">
                                             <a class="nav-link mb-3 p-3  active" id="v-pills-home-tab"
                                                  data-toggle="pill" href="#v-pills-home" role="tab"
                                                  aria-controls="v-pills-home" aria-selected="true">
                                                  <i class="fa fa-cogs  mr-2"></i>
                                                  <span class="font-weight-bold small text-uppercase">General</span></a>

                                             <a class="nav-link mb-3 p-3 " id="v-pills-profile-tab" data-toggle="pill"
                                                  href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                                  aria-selected="false">
                                                  <i class="fa fa-cutlery mr-2"></i>
                                                  <span
                                                       class="font-weight-bold small text-uppercase">Resturant</span></a>
                                             <a class="nav-link mb-3 p-3 " id="v-pills-messages-tab" data-toggle="pill"
                                                  href="#hours" role="tab" aria-controls="v-pills-messages"
                                                  aria-selected="false">
                                                  <i class="fa fa-clock-o mr-2"></i>
                                                  <span class="font-weight-bold small text-uppercase">Hours</span></a>

                                             <a class="nav-link mb-3 p-3 " id="v-pills-messages-tab" data-toggle="pill"
                                                  href="#collection" role="tab" aria-controls="v-pills-messages"
                                                  aria-selected="false">
                                                  <i class="fa fa-percent  mr-2"></i>
                                                  <span class="font-weight-bold small text-uppercase">Offer</span></a>

                                             <a class="nav-link mb-3 p-3 " id="v-pills-settings-tab" data-toggle="pill"
                                                  href="#delivery" role="tab" aria-controls="v-pills-settings"
                                                  aria-selected="false">
                                                  <i class="fa fa-truck mr-2"></i>
                                                  <span class="font-weight-bold small text-uppercase">Delivery
                                                       Charges</span></a>
                                             <a class="nav-link mb-3 p-3 " id="v-pills-settings-tab" data-toggle="pill"
                                                  href="#paynow" role="tab" aria-controls="v-pills-settings"
                                                  aria-selected="false">
                                                  <i class="fa fa-money mr-2"></i>
                                                  <span class="font-weight-bold small text-uppercase">Pay Now</span></a>
                                             <a class="nav-link mb-3 p-3 " id="v-pills-settings-tab" data-toggle="pill"
                                                  href="#currency" role="tab" aria-controls="v-pills-settings"
                                                  aria-selected="false">
                                                  <i class="fa fa-wrench mr-2"></i>
                                                  <span class="font-weight-bold small text-uppercase">Other</span></a>
                                        </div>
                                   </div>


                                   <div class="col-md-9">
                                        <!-- Tabs content -->
                                        <div class="tab-content" id="v-pills-tabContent">

                                             <div class="tab-pane fade  rounded  show active p-4" id="v-pills-home"
                                                  role="tabpanel" aria-labelledby="v-pills-home-tab">
                                                  <div class="row">
                                                       <div class="col-md-6">
                                                  <div class="row">
                                                       <div class="col col-form-label">
                                                            <h6>Restaurant</h6>
                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox" class="switch-class"
                                                                           name="active" value="1"
                                                                           data-name="restaurant" autocomplete="off"
                                                                           @isset($data){{  $data->active==1 ? 'checked': ''  }}@endisset>
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <hr>
                                                  <div class="row">
                                                       <div class="col col-form-label">
                                                            <h6>Test Mode</h6>
                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox" class="switch-class"
                                                                           data-name="testmode" name="test_mode"
                                                                           value="1" autocomplete="off" @isset($data)
                                                                           {{ $data->test_mode==1 ? 'checked': '' }}@endisset>
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <hr>
                                                  <div class="row">
                                                       <div class="col col-form-label">
                                                            <h6>Delivery</h6>
                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox" class="switch-class"
                                                                           data-name="delivery" name="delivery"
                                                                           value="1" autocomplete="off" @isset($data)
                                                                           {{ $data->delivery==1 ? 'checked': '' }}@endisset>
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <hr>
                                                  <div class="row">
                                                       <div class="col col-form-label">

                                                            <h6>Collection</h6>

                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox" class="switch-class"
                                                                           data-name="collection" name="collection"
                                                                           value="1" autocomplete="off" @isset($data)
                                                                           {{ $data->collection==1 ? 'checked': '' }}@endisset>
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <hr>



                                                  @foreach($payment_methods as $payment)
                                                  <div class="row">
                                                       <div class="col col-form-label">

                                                            <h6>{{$payment->name}}</h6>

                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox" class="switch-class"
                                                                           data-name="{{$payment->name}}"
                                                                           name="{{$payment->name}}" value="1"
                                                                           autocomplete="off"
                                                                           {{ $payment->active==1 ? 'checked': '' }}>
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <hr>
                                                  @endforeach
                                                 
                                                 
                                                  </div>
                                                  <div class="col-md-6">
                                                  <div class="row">
                                                       <div class="col col-form-label">
                                                            <h6>Booking</h6>
                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox"  class="switch-class "  data-name="booking"  name="booking" value="1" autocomplete="off" @isset($data) 
                                                                           {{ $data->booking==1 ? 'checked': '' }}@endisset  >
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <hr>
                                                  <div class="row">
                                                       <div class="col col-form-label">
                                                            <h6>Reject Order</h6>
                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox"  class="switch-class "  data-name="rejectorder"  name="reject_order" value="1" autocomplete="off" @isset($data) 
                                                                           {{ $data->reject_order==1 ? 'checked': '' }}@endisset  >
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <hr>
                                                 <div class="row">
                                                       <div class="col col-form-label">
                                                            <h6>Dine In</h6>
                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox"  class="switch-class "  data-name="dinein"  name="dinein" value="1" autocomplete="off" @isset($data) 
                                                                           {{ $data->dinein==1 ? 'checked': '' }}@endisset  >
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                 
                                                  <hr>
                                                  <div class="row">
                                                       <div class="col col-form-label">
                                                            <h6>Pay Now</h6>
                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox"  class="switch-class "  data-name="paynow"  name="paynow" value="1" autocomplete="off" @isset($data) 
                                                                           {{ $data->paynow==1 ? 'checked': '' }}@endisset  >
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                <hr>
                                                <div class="row">
                                                       <div class="col col-form-label">
                                                            <h6>Voucher</h6>
                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox"  class="switch-class "  data-name="vouchers"  name="voucher" value="1" autocomplete="off" @isset($data) 
                                                                           {{ $data->voucher==1 ? 'checked': '' }}@endisset  >
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <hr>
                                                  <div class="row">
                                                       <div class="col col-form-label">
                                                            <h6>Coupon</h6>
                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox"  class="switch-class "  data-name="coupons"  name="coupon" value="1" autocomplete="off" @isset($data) 
                                                                           {{ $data->coupon==1 ? 'checked': '' }}@endisset  >
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <hr>
                                                    <div class="row">
                                                       <div class="col col-form-label">
                                                            <h6>Pre Order</h6>
                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox"  class="switch-class "  data-name="preorder"  name="pre_order" value="1" autocomplete="off" @isset($data) 
                                                                           {{ $data->pre_order==1 ? 'checked': '' }}@endisset  >
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <hr>
                                                  <!-- <div class="row">
                                                       <div class="col col-form-label">
                                                            <h6>QR Code</h6>
                                                       </div>
                                                       <div class="col">
                                                            <div class="form-group">
                                                                 <label class="switch">
                                                                      <input type="checkbox"  class="switch-class "  data-name="preorder"  name="pre_order5" value="1" autocomplete="off" @isset($data) 
                                                                           {{ $data->pre_order==1 ? 'checked': '' }}@endisset  disabled>
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <hr>-->
                                                  </div>
                                                  </div>
                                             </div>

                                             <div class="tab-pane fade  rounded  p-3" id="v-pills-profile"
                                                  role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Name</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="name" class="form-control"
                                                                      placeholder="" value="{{$data->name}}">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Logo</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="file" name="logo" class="form-control">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Contact No's</label>
                                                       <div class="col-md-9">

                                                            <div class="row">
                                                                 <div class="col">
                                                                      <div class="form-group">
                                                                           <input type="text" name="contact_no"
                                                                                class="form-control"
                                                                                value="{{$data->contact_no}}"
                                                                                placeholder="">
                                                                      </div>
                                                                 </div>
                                                                 <div class="col">
                                                                      <div class="form-group">
                                                                           <input type="text" name="contact_no2"
                                                                                class="form-control"
                                                                                value="{{$data->contact_no2}}"
                                                                                placeholder="">
                                                                      </div>
                                                                 </div>
                                                            </div>



                                                       </div>
                                                  </div>

                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Email</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="email" class="form-control"
                                                                      placeholder="" value="{{$data->email}}">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="row">

                                                       <label class="col-md-3 col-form-label">Latitude &
                                                            Longitude</label>
                                                       <div class="col-md-9">
                                                            <div class="row">
                                                                 <div class="col">
                                                                      <div class="form-group">
                                                                           <input type="text" name="latitude"
                                                                                class="form-control"
                                                                                value="{{$data->latitude}}"
                                                                                placeholder="">
                                                                      </div>
                                                                 </div>
                                                                 <div class="col">
                                                                      <div class="form-group">
                                                                           <input type="text" name="longitude"
                                                                                class="form-control"
                                                                                value="{{$data->longitude}}"
                                                                                placeholder="">
                                                                      </div>
                                                                 </div>
                                                            </div>


                                                       </div>
                                                  </div>

                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Address</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <textarea class="form-control" name="address"
                                                                      placeholder=""
                                                                      rows="3">{{$data->address}}</textarea>
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">City</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="city" value="{{$data->city}}"
                                                                      class="form-control" placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">State</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="state"
                                                                      value="{{$data->state}}" class="form-control"
                                                                      placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">PostCode</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="postcode"
                                                                      value="{{$data->postcode}}" class="form-control"
                                                                      placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="tab-pane fade  rounded  p-5" id="delivery" role="tabpanel"
                                                  aria-labelledby="v-pills-messages-tab">
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Delivery Radius</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="delivery_radius"
                                                                      value="{{$data->delivery_radius}}"
                                                                      class="form-control" placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Delivery Type</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <select name="delivery_type" id="delivery_type"
                                                                      class="form-control" autocomplete="off" >
                                                                      <option value=""
                                                                          @isset($delivery_charge->first()->type) {{ $delivery_charge->first()->type =='' ? 'selected' : ''}} @endisset>
                                                                           Please Choose</option>
                                                                      <option value="free"
                                                                      @isset($delivery_charge->first()->type){{ $delivery_charge->first()->type =='free' ? 'selected' : ''}} @endisset>
                                                                           Free</option>
                                                                      <option value="flat_rate"
                                                                      @isset($delivery_charge->first()->type){{ $delivery_charge->first()->type =='flat_rate' ? 'selected' : ''}} @endisset>
                                                                           Flat Rate</option>
                                                                      <option value="km_rate"
                                                                      @isset($delivery_charge->first()->type)     {{ $delivery_charge->first()->type =='km_rate' ? 'selected' : ''}} @endisset>
                                                                           KM Charge</option>
                                                                      <option value="post_code"
                                                                      @isset($delivery_charge->first()->type)    {{ $delivery_charge->first()->type =='post_code' ? 'selected' : ''}} @endisset>
                                                                           Postcode Charge</option>
                                                                 </select>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="row delivery-type" id="flat_rate" style="display:none">
                                                       <label class="col-md-3 col-form-label">Flat Rate</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="flat_rate"
                                                                      value="{{$delivery_charge->first()->type == 'flat_rate' ? $delivery_charge->first()->rate : 0}}"
                                                                      class="form-control" placeholder="">
                                                            </div>
                                                       </div>
                                                       <label class="col-md-3 col-form-label">Free KM</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="flat_free"
                                                                      value="{{$delivery_charge->first()->type == 'flat_rate' ? $delivery_charge->first()->free : 0}}"
                                                                      class="form-control" placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="row delivery-type" id="km_rate" style="display:none">
                                                       <label class="col-md-3 col-form-label">KM & Rate</label>
                                                       <div class="col-md-9">
                                                       <div class="km_container">
                                                            @if($delivery_charge->first()->type == 'km_rate')
                                                                  @foreach($delivery_charge as  $kmcharge)
                                                                  <div class="row ">
                                                                      <div class="col">
                                                                           <div class="form-group">
                                                                                <input type="text" name="km[]"
                                                                                     value="{{$kmcharge->free}}"
                                                                                     class="form-control"
                                                                                     placeholder="Post Code">
                                                                           </div>
                                                                      </div>
                                                                      <div class="col">
                                                                           <div class="form-group">
                                                                                <input type="text" name="km_rate[]"
                                                                                     value="{{$kmcharge->rate}}"
                                                                                     class="form-control" placeholder="Rate">
                                                                           </div>
                                                                      </div>
                                                                 </div>
                                                                  @endforeach
                                                            @endif
                                                             </div>    
                                                            </div>                  
                                                             <div class="row" style="width:100%;justify-content: right;">
                                                           
                                                           <a href="#" id="km_add_more" style="font-size:16px;padding: 7px 20px;"
                                                                class="btn  btn-default btn-fill btn-magnify pull-right "
                                                                role="button"><span class="btn-label">
                                                                     <i class="fa fa-plus"
                                                                          style="padding-right:5px;"></i>
                                                                </span>
                                                                More</a>
                                                     
                                                 </div>
                                                 <p><small>* Clear data to remove</small></p>
                                                  </div>
                                                  <div class="row delivery-type" id="post_code" style="display:none">
                                                       <label class="col-md-3 col-form-label">Post Code & Rate</label>

                                                       <div class="col-md-9">
                                                            <div class="postcode_container">
                                                            @if($delivery_charge->first()->type == 'post_code')
                                                             @foreach($delivery_charge as  $postcode)    
                                                            <div class="row ">
                                                                 <div class="col">
                                                                      <div class="form-group">
                                                                           <input type="text" name="post_code[]"
                                                                                value="{{$postcode->free}}"
                                                                                class="form-control"
                                                                                placeholder="Post Code">
                                                                      </div>
                                                                 </div>
                                                                 <div class="col">
                                                                      <div class="form-group">
                                                                           <input type="text" name="ps_rate[]"
                                                                                value="{{$postcode->rate}}"
                                                                                class="form-control" placeholder="Rate">
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            @endforeach
                                                            @endif
                                                            </div>
                                                       </div>
                                                       <div class="row" style="width:100%;justify-content: right;">
                                                           
                                                                 <a href="#" id="add_more" style="font-size:16px;padding: 7px 20px;"
                                                                      class="btn  btn-default btn-fill btn-magnify pull-right "
                                                                      role="button"><span class="btn-label">
                                                                           <i class="fa fa-plus"
                                                                                style="padding-right:5px;"></i>
                                                                      </span>
                                                                      More</a>
                                                           
                                                       </div>
                                                       <p><small>* Clear data to remove</small></p>
                                                  </div>

                                             </div>

                                             <div class="tab-pane fade  rounded  p-5" id="collection" role="tabpanel"
                                                  aria-labelledby="v-pills-settings-tab">
                                                  <!--
                                                  <p>Minimum Amount For Discount</p>
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Collection</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="coll_disc_min" value="{{$data->collection_discount_min}}"
                                                                      class="form-control" placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Delivery</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="deli_disc_min" value="{{$data->delivery_discount_min}}"
                                                                      class="form-control" placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  -->
                                                  <div class="row">
                                                       <div class="table-responsive-sm">
                                                            <table class="table table-bordered bg-white">
                                                                 <thead>
                                                                      <tr>

                                                                           <td colspan="2"></td>
                                                                           <td colspan="2" class="text-center">
                                                                                Discount(%)</td>
                                                                           <td colspan="2" class="text-center">Min
                                                                                Amount</td>
                                                                           <td colspan="1" class="text-center">
                                                                                Paynow(%)</td>
                                                                           <td colspan="1" class="text-center">Min
                                                                                Amount</td>
                                                                      </tr>
                                                                      <tr>
                                                                           <th>Day</th>
                                                                           <th></th>
                                                                           <td class="font-weight-bold">Collection</td>
                                                                           <td class="font-weight-bold">Delivery</td>
                                                                           <td class="font-weight-bold">Collection</td>
                                                                           <td class="font-weight-bold">Delivery</td>
                                                                           <td class="font-weight-bold">Drinks</td>
                                                                           <td class="font-weight-bold">Drinks</td>

                                                                      </tr>
                                                                 </thead>
                                                                 <tbody>

                                                                      <tr>
                                                                           <td>Sunday</td>
                                                                           <td> <label class="switch">
                                                                                     <input type="checkbox"
                                                                                          name="0-offer" value="1"
                                                                                          {{ $hours[0]->offer==1 ? 'checked': '' }}>
                                                                                     <span class="slider round"></span>
                                                                                </label></td>
                                                                           <td><input type="number"  min="0" step=".01" name="0-offer_coll"
                                                                                     value="{{ $hours[0]->offer_coll }}"
                                                                                     class=" form-control" step=".01">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="0-offer_deli"
                                                                                     value="{{ $hours[0]->offer_deli }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="0-coll_min"
                                                                                     value="{{$hours[0]->coll_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="0-deli_min"
                                                                                     value="{{ $hours[0]->deli_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0.00" step=".01" name="0-offer_payn"
                                                                                     value="{{$hours[0]->offer_payn }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="0-payn_min"
                                                                                     value="{{ $hours[0]->payn_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                      </tr>
                                                                      <tr>
                                                                           <td>Monday</td>
                                                                           <td> <label class="switch">
                                                                                     <input type="checkbox"
                                                                                          name="1-offer" value="1"
                                                                                          {{ $hours[1]->offer==1 ? 'checked': '' }}>
                                                                                     <span class="slider round"></span>
                                                                                </label></td>
                                                                           <td><input type="number"  min="0" step=".01" name="1-offer_coll"
                                                                                     value="{{ $hours[1]->offer_coll }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="1-offer_deli"
                                                                                     value="{{ $hours[1]->offer_deli }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="1-coll_min"
                                                                                     value="{{ $hours[1]->coll_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="1-deli_min"
                                                                                     value="{{ $hours[1]->deli_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="1-offer_payn"
                                                                                     value="{{ $hours[1]->offer_payn }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="1-payn_min"
                                                                                     value="{{ $hours[1]->payn_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                      </tr>
                                                                      <tr>
                                                                           <td>Tuesday</td>
                                                                           <td> <label class="switch">
                                                                                     <input type="checkbox"
                                                                                          name="2-offer" value="1"
                                                                                          {{ $hours[2]->offer==1 ? 'checked': '' }}>
                                                                                     <span class="slider round"></span>
                                                                                </label></td>
                                                                           <td><input type="number"  min="0" step=".01" name="2-offer_coll"
                                                                                     value="{{ $hours[2]->offer_coll }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="2-offer_deli"
                                                                                     value="{{ $hours[2]->offer_deli }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="2-coll_min"
                                                                                     value="{{ $hours[2]->coll_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="2-deli_min"
                                                                                     value="{{ $hours[2]->deli_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="2-offer_payn"
                                                                                     value="{{ $hours[2]->offer_payn }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="2-payn_min"
                                                                                     value="{{ $hours[2]->payn_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                      </tr>
                                                                      <tr>
                                                                           <td>Wednesday</td>
                                                                           <td> <label class="switch">
                                                                                     <input type="checkbox"
                                                                                          name="3-offer" value="1"
                                                                                          {{ $hours[3]->offer==1 ? 'checked': '' }}>
                                                                                     <span class="slider round"></span>
                                                                                </label></td>
                                                                           <td><input type="number"  min="0" step=".01" name="3-offer_coll"
                                                                                     value="{{ $hours[3]->offer_coll }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="3-offer_deli"
                                                                                     value="{{ $hours[3]->offer_deli }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="3-coll_min"
                                                                                     value="{{ $hours[3]->coll_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="3-deli_min"
                                                                                     value="{{ $hours[3]->deli_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="3-offer_payn"
                                                                                     value="{{ $hours[3]->offer_payn }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="3-payn_min"
                                                                                     value="{{ $hours[3]->payn_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                      </tr>
                                                                      <tr>
                                                                           <td>Thursday</td>
                                                                           <td> <label class="switch">
                                                                                     <input type="checkbox"
                                                                                          name="4-offer" value="1"
                                                                                          {{ $hours[4]->offer==1 ? 'checked': '' }}>
                                                                                     <span class="slider round"></span>
                                                                                </label></td>
                                                                           <td><input type="number"  min="0" step=".01" name="4-offer_coll"
                                                                                     value="{{ $hours[4]->offer_coll }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="4-offer_deli"
                                                                                     value="{{ $hours[4]->offer_deli }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="4-coll_min"
                                                                                     value="{{ $hours[4]->coll_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="4-deli_min"
                                                                                     value="{{ $hours[4]->deli_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="4-offer_payn"
                                                                                     value="{{ $hours[4]->offer_payn }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="4-payn_min"
                                                                                     value="{{ $hours[4]->payn_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                      </tr>
                                                                      <tr>
                                                                           <td>Friday</td>
                                                                           <td> <label class="switch">
                                                                                     <input type="checkbox"
                                                                                          name="5-offer" value="1"
                                                                                          {{ $hours[5]->offer==1 ? 'checked': '' }}>
                                                                                     <span class="slider round"></span>
                                                                                </label></td>
                                                                           <td><input type="number"  min="0" step=".01" name="5-offer_coll"
                                                                                     value="{{ $hours[5]->offer_coll }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="5-offer_deli"
                                                                                     value="{{ $hours[5]->offer_deli }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="5-coll_min"
                                                                                     value="{{ $hours[5]->coll_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="5-deli_min"
                                                                                     value="{{ $hours[5]->deli_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="5-offer_payn"
                                                                                     value="{{ $hours[5]->offer_payn }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="5-payn_min"
                                                                                     value="{{ $hours[5]->payn_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                      </tr>
                                                                      <tr>
                                                                           <td>Saturday</td>
                                                                           <td> <label class="switch">
                                                                                     <input type="checkbox"
                                                                                          name="6-offer" value="1"
                                                                                          {{ $hours[6]->offer==1 ? 'checked': '' }}>
                                                                                     <span class="slider round"></span>
                                                                                </label></td>
                                                                           <td><input type="number"  min="0" step=".01" name="6-offer_coll"
                                                                                     value="{{ $hours[6]->offer_coll }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="6-offer_deli"
                                                                                     value="{{ $hours[6]->offer_deli }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="6-coll_min"
                                                                                     value="{{ $hours[6]->coll_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="6-deli_min"
                                                                                     value="{{ $hours[6]->deli_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="6-offer_payn"
                                                                                     value="{{ $hours[6]->offer_payn }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                           <td><input type="number"  min="0" step=".01" name="6-payn_min"
                                                                                     value="{{ $hours[6]->payn_min }}"
                                                                                     class=" form-control">
                                                                           </td>
                                                                      </tr>

                                                                 </tbody>
                                                            </table>
                                                       </div>
                                                  </div>
                                             </div>

                                             <div class="tab-pane fade  rounded  p-3" id="hours" role="tabpanel"
                                                  aria-labelledby="v-pills-settings-tab">
                                                  <div class="row">


                                                       <div class="table-responsive-sm">
                                                            <table class="table table-bordered bg-white">
                                                                 <thead>
                                                                      <tr>
                                                                           <th>Day</th>
                                                                           <th></th>
                                                                           <th>from</th>
                                                                           <th>To</th>
                                                                           <th>from</th>
                                                                           <th>To</th>

                                                                      </tr>
                                                                 </thead>
                                                                 <tbody>
                                                                      @php
                                                                      $weekdays
                                                                      =['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                                                                      @endphp
                                                                      @for($i = 0 ;$i < 7;$i++) <tr>
                                                                           <td>{{$weekdays[$i]}}</td>
                                                                           <td> <label class="switch">
                                                                                     <input type="checkbox"
                                                                                          name="{{$i}}-active" value="1"
                                                                                          {{ $hours[$i]->active==1 ? 'checked': '' }}>
                                                                                     <span class="slider round"></span>
                                                                                </label></td>
                                                                           <td>
                                                                                <div class="input-group date timepicker1"
                                                                                     id="{{$i}}-time-1"
                                                                                     data-target-input="nearest">
                                                                                     <input type="text"
                                                                                          class="form-control datetimepicker-input datetimepicker"
                                                                                          data-target="#{{$i}}-time-1"
                                                                                          name="{{$i}}-start1"
                                                                                          value="{{ $hours[$i]->start1 }}" />
                                                                                     <div class="input-group-append"
                                                                                          data-target="#{{$i}}-time-1"
                                                                                          data-toggle="datetimepicker">
                                                                                          <div class="input-group-text">
                                                                                               <i
                                                                                                    class="fa fa-clock-o"></i>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </td>
                                                                           <td>
                                                                                <div class="input-group date timepicker1"
                                                                                     id="{{$i}}-time-2"
                                                                                     data-target-input="nearest">
                                                                                     <input type="text"
                                                                                          class="form-control datetimepicker-input datetimepicker"
                                                                                          data-target="#{{$i}}-time-2"
                                                                                          name="{{$i}}-end1"
                                                                                          value="{{ $hours[$i]->end1 }}" />
                                                                                     <div class="input-group-append"
                                                                                          data-target="#{{$i}}-time-2"
                                                                                          data-toggle="datetimepicker">
                                                                                          <div class="input-group-text">
                                                                                               <i
                                                                                                    class="fa fa-clock-o"></i>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </td>
                                                                           <td>
                                                                                <div class="input-group date timepicker1"
                                                                                     id="{{$i}}-time-3"
                                                                                     data-target-input="nearest">
                                                                                     <input type="text"
                                                                                          class="form-control datetimepicker-input datetimepicker"
                                                                                          data-target="#{{$i}}-time-3"
                                                                                          name="{{$i}}-start2"
                                                                                          value="{{ $hours[$i]->start2 }}" />
                                                                                     <div class="input-group-append"
                                                                                          data-target="#{{$i}}-time-3"
                                                                                          data-toggle="datetimepicker">
                                                                                          <div class="input-group-text">
                                                                                               <i
                                                                                                    class="fa fa-clock-o"></i>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </td>
                                                                           <td>
                                                                                <div class="input-group date timepicker1"
                                                                                     id="{{$i}}-time-4"
                                                                                     data-target-input="nearest">
                                                                                     <input type="text"
                                                                                          class="form-control datetimepicker-input datetimepicker"
                                                                                          data-target="#{{$i}}-time-4"
                                                                                          name="{{$i}}-end2"
                                                                                          value="{{ $hours[$i]->end2 }}" />
                                                                                     <div class="input-group-append"
                                                                                          data-target="#{{$i}}-time-4"
                                                                                          data-toggle="datetimepicker">
                                                                                          <div class="input-group-text">
                                                                                               <i
                                                                                                    class="fa fa-clock-o"></i>
                                                                                          </div>
                                                                                     </div>
                                                                                </div>
                                                                           </td>
                                                                           </tr>
                                                                           @endfor




                                                                 </tbody>
                                                            </table>
                                                       </div>
                                                  </div>



                                             </div>
                                             <div class="tab-pane fade  rounded  p-5" id="paynow" role="tabpanel"
                                                  aria-labelledby="v-pills-messages-tab">
                                                 
                                                 
                                                  
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Drinks Offer %</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="drinks_dis"
                                                                      value="{{$data->drinks_discount}}"
                                                                      class="form-control" placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Food Offer %</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="food_dis"
                                                                      value="{{$data->food_discount}}"
                                                                      class="form-control" placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  
                                                  
                                                  
                                                 

                                             </div>
                                             <div class="tab-pane fade  rounded  p-5" id="currency" role="tabpanel"
                                                  aria-labelledby="v-pills-settings-tab">
                                                  <p>Minimum Order Amount</p>
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Collection</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="collection_min"
                                                                      value="{{$data->collection_min}}"
                                                                      class="form-control" placeholder=""  autocomplete="off">
                                                            </div>
                                                       </div>
                                                  </div>

                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Delivery</label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="delivery_min"
                                                                      value="{{$data->delivery_min}}"
                                                                      class="form-control" placeholder="" autocomplete="off">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <br>
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Pre Order Start Time
                                                       </label>
                                                       <div class="col-md-9">
                                                            <div class="input-group w-25 date timepicker1"
                                                                 id="preotime"
                                                                 data-target-input="nearest" style="margin-bottom: 10px;min-width:150px;">
                                                                 <input type="text"
                                                                      class="form-control datetimepicker-input datetimepicker"
                                                                      data-target="#preotime"
                                                                      name="preorder_start"
                                                                      value="{{$data->preorder_start}}" />
                                                                 <div class="input-group-append"
                                                                      data-target="#preotime"
                                                                      data-toggle="datetimepicker">
                                                                      <div class="input-group-text">
                                                                           <i
                                                                                class="fa fa-clock-o"></i>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>

                                                  </div>
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Payment Gateway 
                                                       </label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <select name="pgateway" class="form-control">
                                                                      <option value="menu-list" selected > Stripe</option>
      
                                                                 </select>
                                                            </div>
                                                       </div>
                                                  </div>
                                                 
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Notification 
                                                       </label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <select name="notification" class="form-control">
                                                                      <option value="menu-list" selected > Signal</option>
      
                                                                 </select>
                                                            </div>
                                                       </div>
                                                  </div>
                                                 <!--
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Stripe child Acc_Id
                                                       </label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="stripe_id"
                                                                      value="{{$data->stripe_id}}" class="form-control"
                                                                      placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>
                                                 -->
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Erp Id
                                                       </label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="erp_id"
                                                                      value="{{$data->erp_id}}" class="form-control"
                                                                      placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Theme 
                                                       </label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <select name="theme" class="form-control">
                                                                      <option value="menu-list"
                                                                      {{ $data->theme =='menu-list' ? 'selected' : ''}}>
                                                                           JOO List Collapse</option>
                                                                           <option value="menu-grid"
                                                                           {{ $data->theme =='menu-grid' ? 'selected' : ''}}>
                                                                          JOO Grid Collapse</option>
                                                                           <option value="menu-list-nav"
                                                                      {{ $data->theme =='menu-list-nav' ? 'selected' : ''}}>
                                                                          JOO List Navigation</option>
                                                                           <option value="menu-grid-nav"
                                                                           {{ $data->theme =='menu-grid-nav' ? 'selected' : ''}}>
                                                                           JOO Grid Navigation</option>
                                                                           <option value="menu-long-list-nav"
                                                                      {{ $data->theme =='menu-long-list-nav' ? 'selected' : ''}}>
                                                                          JOO Long List Navigation</option>
                                                                           <option value="menu-long-list"
                                                                      {{ $data->theme =='menu-long-list' ? 'selected' : ''}}>
                                                                           JOO Long List Collapse</option>
                                                                 </select>
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="row">
                                                       <label class="col-md-3 col-form-label">Currency
                                                       </label>
                                                       <div class="col-md-9">
                                                            <div class="form-group">
                                                                 <input type="text" name="currency"
                                                                      value="{{$data->currency}}" class="form-control"
                                                                      placeholder="">
                                                            </div>
                                                       </div>
                                                  </div>

                                             </div>

                                        </div>
                                        <button type="submit" value="submit" class="btn btn-fill btn-c1">Update</button>
                                   </div>
                              </div>
                         </div>
                    </div>

               </div>

          </div>
     </form>
</div>
@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('paper') }}/js/moment.min.js"></script>
<script type="text/javascript" src="{{asset('paper') }}/js/tempusdominus-bootstrap-4.js"></script>
<script>
$(function() {

     $('#add_more').click(function(e){
        e.preventDefault();
       
            $('.postcode_container').append('<div class="row "><div class="col"><div class="form-group"><input type="text" name="post_code[]" value=""  class="form-control" placeholder="Post Code">   </div>   </div> <div class="col"> <div class="form-group"> <input type="text" name="ps_rate[]" value="" class="form-control" placeholder="Rate"> </div> </div>  </div>'); //add input field

    });  
    $('#km_add_more').click(function(e){
        e.preventDefault();     
            $('.km_container').append('<div class="row "><div class="col"><div class="form-group"><input type="text" name="km[]" value=""  class="form-control" placeholder="KM >">   </div>   </div> <div class="col"> <div class="form-group"> <input type="text" name="km_rate[]" value="" class="form-control" placeholder="Rate"> </div> </div>  </div>'); //add input field

    }); 
     /*
     $('.switch-class').change(function() {
          var status = $(this).prop('checked') == true ? 1 : 0;
          var item = $(this).data('name');

          $.ajax({
               type: "GET",
               dataType: "json",
               url: 'change',
               data: {
                    'status': status,
                    'item': item
               },
               success: function(data) {
                    if (data.success)
                         showNotification('success', data.message);
               }
          });
     });*/
     $('#delivery_type').change(function() {
          var id = "#" + $(this).val();
          $('.delivery-type').hide();
          $(id).show();
     });


     $('.timepicker1').datetimepicker({
          format: 'LT'
     });

     var id = "#" + $('#delivery_type').val();
     $('.delivery-type').hide();
     $(id).show();
});
</script>
@endpush

@if(Session::has('success'))
@push('scripts')
<script>
$(document).ready(function() {
     showNotification('success', "{{Session::get('success')}}");
});
</script>
@endpush

@php
Session::forget('success');
@endphp
@endif

@if(Session::has('error'))
@push('scripts')
<script>
$(document).ready(function() {
     showNotification('error', "{{Session::get('error')}}");
});
</script>
@endpush

@php
Session::forget('error');
@endphp
@endif