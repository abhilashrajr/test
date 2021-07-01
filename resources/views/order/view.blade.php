@extends('layouts.app', [
'title' => 'View Order',
'class' => '',
'elementActive' => $data["details"]["order_type"] =="dinein" ? 'dinein': 'order'
])

@push('styles')
<style>
.table>thead>tr>th {
     border: 1px solid #e6ded0 !important;
}

.table {
     color: #66615b;
}
</style>
@endpush

@section('content')
<div class="content">
     <form method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="row">
               <div class="col-xl-6">
                    <div class="card">
                         <div class="card-header">
                              <h4 class="card-title">Customer Details</h4>
                         </div>
                         <div class="card-body">


                              <div class="table-responsive">
                                   <table id="bootstrap-table" class="table  table-bordered table-striped table-sm "
                                        style="white-space:nowrap;background-color: #f3f2ee;">

                                        <tbody>


                                             <tr>
                                                  <td class="font-weight-bold">Name</td>
                                                  <td>{{$data["details"]["customer_name"]}}</td>
                                             </tr>
                                             </tr>
                                             @if($data["details"]["order_type"]=="dinein")
                                             <tr>
                                                  <td class="font-weight-bold">Table No</td>
                                                  <td>{{$data["details"]["tableno"]}}</td>
                                             </tr>
                                             @else
                                             <tr>
                                                  <td class="font-weight-bold">Phone</td>
                                                  <td>{{$data["details"]["delivery_phone"]}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Email</td>
                                                  <td>{{$data["details"]["delivery_email"]}}</td>
                                             </tr>
                                             @if($data["details"]["order_type"]=="delivery")
                                             <tr>
                                                  <td class="font-weight-bold">Address</td>
                                                  <td>{{$data["details"]["delivery_address"]}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Pincode</td>
                                                  <td>{{$data["details"]["delivery_postcode"]}}</td>
                                             </tr>
                                             @endif
                                             @endif
                                             <tr>
                                                  <td class="font-weight-bold">Delivery type</td>
                                                  <td>{{$data["details"]["order_type"]}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Coupon</td>
                                                  <td>{{$data["details"]["coupon"]}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Sub Total</td>
                                                  <td>{{$data["details"]["sub_total"]}}</td>
                                             </tr>
 
                                             <tr>
                                                  <td class="font-weight-bold">Discount</td>
                                                  <td>{{$data["details"]["discount"]}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Coupon Discount</td>
                                                  <td>{{$data["details"]["coupon_discount"]}}</td>
                                             </tr>
                                             @if($data["details"]["order_type"]=="delivery")
                                             <tr>
                                                  <td class="font-weight-bold">Delivery Charge</td>
                                                  <td>{{$data["details"]["delivery_charge"]}}</td>
                                             </tr>
                                             @endif
                                             <tr>
                                                  <td class="font-weight-bold">Amount</td>
                                                  <td>{{$data["details"]["amount"]}}</td>
                                             </tr>
                                            
                                            
                                             <tr>
                                                  <td class="font-weight-bold">Payment Method</td>
                                                  <td>{{$data["details"]["payment_method"]}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Special Requirements</td>
                                                  <td>{{$data["details"]["other_info"]}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Pre Order</td>
                                                  <td>{{$data["details"]["pre_order"]== 1 ? 'Yes' : 'No'}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Status</td>
                                                  <td>
                                                       @switch($data["details"]["status"])
                                                       @case(1)
                                                       Pending
                                                       @break

                                                       @case(2)
                                                       Accepted
                                                       @break
                                                       @case(3)
                                                       Delivered
                                                       @break
                                                       @case(4)
                                                       Rejected
                                                       @break
                                                       @default
                                                       Error
                                                       @endswitch

                                                  </td>
                                             </tr>


                                             <tr>
                                                  <td class="font-weight-bold">Order Time</td>
                                                  <td>{{ date('d M  Y,   h:i A ', strtotime($data["details"]["order_time"]))}}</td>
                                             </tr>
                                             @if($data["details"]["order_type"]=="delivery")
                                             <tr>
                                                  <td class="font-weight-bold">Delivery Time</td>
                                                  <td>@isset($data["details"]["delivery_time"]) {{ date('d M  Y,   h:i A ', strtotime($data["details"]["delivery_time"]))}}  @endisset</td>
                                             </tr>
                                             @endif
                                        </tbody>
                                   </table>
                              </div>

                         </div>
                    </div>
               </div>
               <div class="col-xl-6">
                    <div class="card">
                         <div class="card-header">
                              <h4 class="card-title">Items</h4>
                         </div>
                         <div class="card-body">
                             
                             
                              <strong></strong>
                              <div class="table-responsive">
                                   <table id="bootstrap-table" class="table table-striped table-bordered table-sm "
                                        style="white-space:nowrap;background-color: #f3f2ee;">
                                        <thead>
                                             <tr>
                                                  <th>
                                                       <div class="th-inner ">Name</div>

                                                  </th><th>
                                                       <div class="th-inner ">Qty</div>

                                                  </th>
                                                  <th>
                                                       <div class="th-inner">
                                                            Price</div>

                                                  </th>
                                             </tr>
                                        </thead>
                                        <tbody>

                                        @forelse($data["items"] as $menu)
                                             <tr>
                                                  <td ><strong>{{$menu["name"]}}</strong>
                                                  </td>
                                                  <td >{{$menu["quantity"]}}</td>
                                                  <td >{{$menu["price"]}}</td>
                                             </tr>
                                          
                                             @if(!empty($menu['addon'][0]['ad_name']))
                                             <tr>
                                                  <td colspan="3">
                                                  <table class="ml-5">
                                                  <tr>
                                                  <th>Addon</th>
                                                  <th>Qty</th>
                                                  <th>Price</th>
                                                  </tr>
                                                 
                                                  @foreach($menu['addon'] as $addon)
                                                       <tr>
                                                                  
                                                               <td>   {{$addon["ad_name"]}}</td>
                                                               <td>   {{$addon["ad_qty"]}}</td>
                                                               <td>   {{$addon["ad_price"]}}</td>
                                                       </tr>
                                                  @endforeach
                                                 
                                                  </table>
                                                  </td>
                                             </tr> 
                                             @endif
                                             @if(!empty($menu["other"]))
                                             <tr>
                                                  <td colspan="3">
                                                       <ul class="mb-0" style="list-style-type: none;">
                                                            <li>  {{$menu["other"]}}</li>
                                                       </ul>
                                                  </td>
                                             </tr>
                                             @endif
                                          
                                             @empty
                                             <p>No Items</p>
                                             @endforelse
                                        </tbody>
                                   </table>
                              </div>
                             
                             
                              @switch($data["details"]["status"])
                                   @case(1)
                                   <a title="Edit" class="btn btn-warning"
                                        href="{{ route('changestatus',[ 'id'=>$data["details"]["id"],'status'=>2])}}">Accept</a>
                                   @if($restaurant->reject_order == 1)
                                   <a title="Edit" class="btn  btn-default"
                                        href="{{ route('changestatus',[ 'id'=>$data["details"]["id"],'status'=>4])}}">Reject</a>
                                   @endif
                                   @if($data["details"]["payment_method"]=='Card' && $data["details"]["payment_status"]==1)
                                   <a title="Refund" class="btn  btn-info"
                                        href="{{ route('changestatus',[ 'id'=>$data["details"]["id"],'status'=>5])}}">Refund</a>
                                    @endif
                                  
                                   @break

                                   @case(2)
                                  <!-- <a title="Edit" class="btn btn-success"
                                        href="{{ route('changestatus',[ 'id'=>$data["details"]["id"],'status'=>3])}}">Delivered</a>-->
                                   @if($restaurant->reject_order == 1)
                                   <a title="Edit" class="btn  btn-default"
                                        href="{{ route('changestatus',[ 'id'=>$data["details"]["id"],'status'=>4])}}">Reject</a>
                                   @endif
                                   @if($data["details"]["payment_method"]=='Card' && $data["details"]["payment_status"]==1)
                                   <a title="Edit" class="btn  btn-info"
                                        href="{{ route('changestatus',[ 'id'=>$data["details"]["id"],'status'=>5])}}">Refund</a>
                                   @endif     
                                   @break
                                   @case(3)
                                        
                                   @break
                                   @case(4)
                                   <a title="Edit" class="btn btn-warning"
                                        href="{{ route('changestatus',[ 'id'=>$data["details"]["id"],'status'=>2])}}">Accept</a>
                                  @if($data["details"]["payment_method"]=='Card' && $data["details"]["payment_status"]==1)
                                   <a title="Edit" class="btn  btn-info"
                                        href="{{ route('changestatus',[ 'id'=>$data["details"]["id"],'status'=>5])}}">Refund</a>
                                   @endif     
                                   @break
                                   @default
                                   <a title="Edit" class="btn btn-warning"
                                        href="{{ route('changestatus',[ 'id'=>$data["details"]["id"],'status'=>2])}}">Accept</a>
                                   @if($data["details"]["payment_method"]=='Card' && $data["details"]["payment_status"]==1)
                                   <a title="Edit" class="btn  btn-info"
                                        href="{{ route('changestatus',[ 'id'=>$data["details"]["id"],'status'=>5])}}">Refund</a> 
                                   @endif         
                              @endswitch


                                  
                                  

                              


                         </div>
                    </div>
               </div>

          </div>
     </form>
</div>
@endsection
@push('scripts')
<script>
$(document).ready(function() {


@if(Session::has('success'))
     showNotification('success', "{{Session::get('success')}}");
     @endif
});
</script>
@endpush

@php
Session::forget('success');
@endphp
