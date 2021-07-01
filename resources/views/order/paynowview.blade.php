@extends('layouts.app', [
'title' => 'View Order',
'class' => '',
'elementActive' => 'order'
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
                              <h4 class="card-title">Pay Now Details</h4>
                         </div>
                         <div class="card-body">


                              <div class="table-responsive">
                                   <table id="bootstrap-table" class="table  table-bordered table-striped table-sm "
                                        style="white-space:nowrap;background-color: #f3f2ee;">

                                        <tbody>


                                             <tr>
                                                  <td class="font-weight-bold">Name</td>
                                                  <td>{{$data->customer_name}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Table Number</td>
                                                  <td>{{$data->tableno}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Drinks Amount</td>
                                                  <td>{{$data->drinks_amount}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Food Amount</td>
                                                  <td>{{$data->food_amount}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Drinks Discount</td>
                                                  <td>{{$data->drinks_discount}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Food Discount</td>
                                                  <td>{{$data->food_discount}}</td>
                                             </tr>
                                              <tr>
                                                  <td class="font-weight-bold">Drinks Total</td>
                                                  <td>{{$data->drinks_total}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Food Total</td>
                                                  <td>{{$data->food_total}}</td>
                                             </tr>

                                             <tr>
                                                  <td class="font-weight-bold">Total Amount</td>
                                                  <td>{{$data->total_amount}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Payment Type</td>
                                                  <td>{{$data->payment_method == 1 ? 'card' : ''}}</td>
                                             </tr>
 
                                             <tr>
                                                  <td class="font-weight-bold">Payment Status</td>
                                                  <td>{{$data->payment_status == 1 ? 'Paid' : 'Not Paid'}}</td>
                                             </tr>
                                              <tr>
                                                  <td class="font-weight-bold">Order Time</td>
                                                  <td>{{ date('d M  Y,   h:i A ', strtotime($data->order_time))}}</td>
                                             </tr>
                                          
                                        </tbody>
                                   </table>
                              </div>

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
