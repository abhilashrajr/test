@extends('layouts.app', [
'title' => 'View Voucher Order',
'class' => '',
'elementActive' => 'voucherorders'
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
   
          <div class="row">
               <div class="col-xl-6">
                    <div class="card">
                         <div class="card-header">
                              <h4 class="card-title">Voucher Order Details</h4>
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
                                                  <td class="font-weight-bold">Phone</td>
                                                  <td>{{$data->phone}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Email</td>
                                                  <td>{{$data->email}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Purchase Code</td>
                                                  <td>{{$data->purchase_code}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Voucher </td>
                                                  <td>@isset($voucher->name){{$voucher->name}}@endisset</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Voucher Amount</td>
                                                  <td>{{$data->voucher_amount}}</td>
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
                                          
                                              <tr>
                                                  <td class="font-weight-bold">Status</td>
                                                  <td>
                                                       @if($data->payment_status == 0)
                                                       Not paid
                                                 @endif
                                                 @if($data->status == 2 )
                                                      Claimed
                                                  @endif
                                                 @if($data->payment_status == 1 && $data->status==1)
                                                   Pending
                                                 @endif

                                                  </td>
                                             </tr>
                                        </tbody>
                                   </table>
                                   @if ($data->status == 1)
                                       <a title="Edit" class="btn btn-warning"
                                        href="{{ route('vostatus',[ 'id'=>$data->id,'status'=>2])}}">Accept</a>
                                   @endif
                                   
                              </div>

                         </div>
                    </div>
               </div>
              

          </div>
    
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
