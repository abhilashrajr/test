@extends('layouts.app', [
'class' => '',
'elementActive' => 'voucherorders',
'title' => 'Voucher Orders',
])
@push('styles')
<link rel="stylesheet" type="text/css" media="screen" href="{{asset('paper') }}/css/tempusdominus-bootstrap-4.css">
<style>
.s-btn {
     padding: 3px 10px !important;
}
td.new, td.old{
     visibility:hidden;
}
</style>
@endpush
@section('content')
<div class="content">
<!--
<div class="row mb-3">
     <div class="col-md-12">
          <a type="button"  target="_self" href="{{route('orders')}}" class="btn btn-fill btn-default mr-1">Delivery & Collection</a>
          <a  type="button" class="btn btn-default mr-1" target="_self" href="{{route('dineinorders')}}">Dine In</a>
          <a  type="button" class="btn btn-c1  mr-1" target="_self" href="{{route('paynoworders')}}">Pay Now </a>
     </div>
 </div>
 -->    
<form method="get" action="" class="" id="order-form">
     <!--<div class="row">
          <div class=" col  mx-auto" style="max-width: max-content;">
               <div class="card card-stats shadow-none" style="padding: 0px 10px;">
                    <div class="card-body p-0 align-items-center d-flex justify-content-center ">
                       
                              <div class="form-group " style="padding-right: 6px;margin-bottom:0px;">

                              <input type="text" name="from" value="{{Request()->from ?? ''}}" class="form-control datetimepicker-input" id="datetimepicker1" placeholder="From" data-toggle="datetimepicker" data-target="#datetimepicker1" style="height: calc(2.25rem + 2px);"/>
                            
                              </div>

                              <div class="form-group" style="padding-right: 5px;margin-bottom:0px;">

                              <input type="text" name="to" value="{{Request()->to ?? ''}}" class="form-control datetimepicker-input" id="datetimepicker2" placeholder="To" data-toggle="datetimepicker" data-target="#datetimepicker2" style="height: calc(2.25rem + 2px);"/>

                              </div>
                              <div class="form-group" style="margin-bottom:0px;">
                                   <button type="submit" class="btn btn-fill btn-c1">Go</button>
                              </div>
                        

                    </div>
               </div>
          </div>
        
          <a href="{{ route('exportorders',Request::query()) }}" style="font-size:16px;padding: 7px 10px;min-width:120px;height:35px;border-radius: 20px;text-transform: capitalize;margin-right: 10px;"
                                             class="btn btn-wd btn-info btn-fill  pull-right " role="button"><span
                                                  class="btn-label">
                                                  <i class="fa fa-download" style="padding-right:5px;"></i>
                                             </span>
                                             Export</a>

     </div>-->

     <div class="row">
          <div class="col-md-12">
         <!-- <button class="btn {{(Request()->type == 'dinein') ? 'btn-c1' : 'btn-default' }} mr-1" name="type" value="dinein">Dine In</button>
          <button class="btn btn-default  mr-1"  name="type" value="pay">Pay Now </button>-->
               <div class="card">
                    <div class="card-header">
                         <h4 class="card-title mb-0" style="padding-left:20px;">Voucher Orders</h4>
                    </div>
                    <div class="card-body pt-0">
                         <div class="bootstrap-table">
                              <div class="fixed-table-toolbar">
                                   <div class="bars pull-left">
                                        <div class="toolbar">
                                             <!--Here you can write extra buttons/actions for the toolbar-->
                                        </div>
                                   </div>
                                   <div class="columns columns-right pull-right mt-0">
                                        <!--<a href="{{ url('category/create') }}" style="font-size:16px;padding: 7px 20px;"
                                             class="btn  btn-default btn-fill btn-magnify" role="button"><span
                                                  class="btn-label">
                                                  <i class="fa fa-plus" style="padding-right:5px;"></i>
                                             </span>
                                             Add</a>




                                       <button class="btn btn-default"
                                             type="button" name="refresh" title="Refresh"><i
                                                  class="glyphicon fa fa-refresh"></i></button><button
                                             class="btn btn-default" type="button" name="toggle" title="Toggle"><i
                                                  class="glyphicon fa fa-th-list"></i></button>
                                        <div class="keep-open btn-group" title="Columns"><button type="button"
                                                  class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i
                                                       class="glyphicon fa fa-columns"></i> <span
                                                       class="caret"></span></button>
                                             <ul class="dropdown-menu" role="menu">
                                                  <li><label><input type="checkbox" data-field="id" value="1"
                                                                 checked="checked"> ID</label></li>
                                                  <li><label><input type="checkbox" data-field="name" value="2"
                                                                 checked="checked"> Name</label></li>
                                                  <li><label><input type="checkbox" data-field="salary" value="3"
                                                                 checked="checked"> Salary</label></li>
                                                  <li><label><input type="checkbox" data-field="country" value="4"
                                                                 checked="checked"> Country</label></li>
                                                  <li><label><input type="checkbox" data-field="city" value="5"
                                                                 checked="checked"> City</label></li>
                                                  <li><label><input type="checkbox" data-field="actions" value="6"
                                                                 checked="checked"> Actions</label></li>
                                             </ul>
                                        </div>-->
                                   </div>

                                   <div class="pull-left search form-inline" >
                                       <!-- <form method="get" action="{{ Request::fullUrl() }}" class="form-inline" id="order-form">-->
                                       
                                           <div class="form-group" style="padding-right: 6px;margin-bottom:0px;">                                          
                                                  <input class="form-control" type="text" name="search"
                                                       placeholder="Customer Name" value="{{ Request()->search ?? ''}}"
                                                       style="height: calc(2.25rem + 2px);">

                                             </div>
                                             <div class="form-group " style="padding-right: 6px;margin-bottom:0px;">                     
                                                  <input class="form-control " type="text" name="pcode"
                                                       placeholder="Purchase Code" value="{{ Request()->pcode ?? ''}}"
                                                       style="height: calc(2.25rem + 2px);">
                                             </div>
                                             
                                             <div class="form-group" style="margin-bottom:0px;">
                                                  <button type="submit" class="btn btn-fill btn-c1">Go</button>
                                             </div>
                                             <div class="form-group" style="margin-bottom:0px;">
                                                  <button type="button" value="Reset" class="btn btn-outline-secondary reset-btn"><i class="fa fa-refresh"></i> </button>
                                             </div>
                                        <!--</form>-->
                                   </div>

                              </div>
                              <div class="fixed-table-container" style="padding-bottom: 0px;">
                                   <div class="fixed-table-header" style="display: none;">
                                        <table></table>
                                   </div>
                                   <div class="fixed-table-body">
                                        <!--<div class="fixed-table-loading" style="top: 41px;">Loading, please wait...
                                        </div>-->
                                        <div class="table-responsive" >
                                             <table id="bootstrap-table" class="table table-hover table-sm "
                                                  style="white-space:nowrap;overflow: hidden;">
                                                  <thead>
                                                       <tr>

                                                            <th class="" style="padding-left:25px;">
                                                                 <div class="th-inner ">Booking ID</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th style="">
                                                                 <div class="th-inner sortable both">
                                                                      @sortablelink('customer_name', ' Customer Name')
                                                                 </div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th style="">
                                                                 <div class="th-inner sortable both">
                                                                      @sortablelink('order_time', 'Order Time')</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                           
                                                         
                                                           
                                                            <th class="text-center">
                                                                 <div class="th-inner sortable both">
                                                                      Purchase Code </div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th class="text-center">
                                                                 <div class="th-inner "> @sortablelink('voucher_amount', 'Amount')</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th class="text-center">
                                                                 <div class="th-inner "> @sortablelink('payment_status', 'Status')</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th class="td-actions text-right"
                                                                 style="padding-right:15px;" data-field="actions">
                                                                 <div class="th-inner ">Actions</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       @php
                                                       // $i = $data->perPage() * ($data->currentPage() - 1);
                                                       @endphp
                                                       @forelse($data as $order)
                                                       <tr>

                                                            <td class="" style="padding-left:25px;">#{{$order->id}}</td>
                                                            <td style="">{{ $order->customer_name }}</td>
                                                            <td style="">
                                                                 {{  date('d M  Y,   h:i A ', strtotime($order->order_time))}}
                                                            </td>
                                                           
                                                            <!--
                                                            <td style="">
                                                                 {{-- $order->delivery_postcode --}}
                                                            </td>
                                                            -->
                                                            <td class="text-center">
                                                                 {{ $order->purchase_code  }}</td>
                                                            <td class="text-center">
                                                                 {{ $order->voucher_amount   }}</td>
                                                            <td class="text-center">
                                                                 @if($order->payment_status == 0)
                                                                       <button   class="btn   btn-default btn-round s-btn">Not paid</button>
                                                                 @endif
                                                                 @if($order->status == 2 )
                                                                       <button   class="btn   btn-success btn-round s-btn">Claimed</button>
                                                                  @endif
                                                                 @if($order->payment_status == 1 && $order->status==1)
                                                                      <button   class="btn   btn-danger btn-round s-btn">Pending</button>
                                                                 @endif
                                                            </td>

                                                                 
                                                            <td class="td-actions text-right" style="">
                                                                <!-- <form action="{{ route('category.destroy', $order->id) }}"
                                                                      method="POST" class="form-inline float-right">-->
                                                                      <div class="table-icons">
                                                                       <!--     
                                                                      <div class="dropdown float-left dropleft">
                                                                               
                                                                                <a title="View" class="table-action-status "  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                                                href="{{ route('menu.show', $order->id)}}"
                                                                                data-original-title="Edit"><i class="fa fa-ellipsis-v"></i></a>
                                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item" href="#">Action</a>
                                                                                <a class="dropdown-item" href="#">Another action</a>
                                                                                <a class="dropdown-item" href="#">Something else here</a>
                                                                                </div>
                                                                      </div>-->
                                                                           
                                                                           
                                                                                <a title="View" class="table-action-view "
                                                                                href="{{  route('voucherorderview', ['id' => $order->id])}}"
                                                                                data-original-title="View"><i
                                                                                     class="fa fa-eye"></i></a>
                                                                           <!--@csrf
                                                                           @method('DELETE')

                                                                           <button
                                                                                onclick="return confirm('Are you sure?')"
                                                                                title="Remove" type="submit"
                                                                                class="table-action-remove"><i
                                                                                     class="fa fa-times"></i></button>-->
                                                                      </div>
                                                                 <!--</form>-->
                                                            </td>
                                                       </tr>

                                                       @empty
                                                       <tr>
                                                            <td colspan="6" class="text-center">No Data</td>
                                                       </tr>
                                                       @endforelse
                                                  </tbody>
                                             </table>
                                        </div>
                                   </div>
                                   <div class="fixed-table-footer" style="display: none;">
                                        <table>
                                             <tbody>
                                                  <tr></tr>
                                             </tbody>
                                        </table>
                                   </div>
                                   <div class="fixed-table-pagination">
                                        <!-- <div class="pull-left pagination-detail"><span
                                                  class="pagination-info"></span><span class="page-list"><span
                                                       class="btn-group dropup"><button type="button"
                                                            class="btn btn-default  dropdown-toggle"
                                                            data-toggle="dropdown"><span class="page-size">8</span>
                                                            <span class="caret"></span></button>
                                                       <ul class="dropdown-menu" role="menu">
                                                            <li class="active"><a href="javascript:void(0)">8</a></li>
                                                            <li><a href="javascript:void(0)">10</a></li>
                                                            <li><a href="javascript:void(0)">25</a></li>
                                                       </ul>
                                                  </span> rows visible</span>
                                             </div>-->
                                        <div class="pull-right pagination">
                                             {!! $data->withQueryString()->links() !!}

                                             <!--<ul class="pagination">
                                                  <li class="page-first disabled"><a href="javascript:void(0)"><i
                                                                 class="fa fa-angle-double-left"
                                                                 aria-hidden="true"></i></a></li>
                                                  <li class="page-pre disabled"><a href="javascript:void(0)">‹</a></li>
                                                  <li class="page-number active"><a href="javascript:void(0)">1</a></li>
                                                  <li class="page-number"><a href="javascript:void(0)">2</a></li>
                                                  <li class="page-number"><a href="javascript:void(0)">3</a></li>
                                                  <li class="page-next"><a href="javascript:void(0)">›</a></li>
                                                  <li class="page-last"><a href="javascript:void(0)"><i
                                                                 class="fa fa-angle-double-right"
                                                                 aria-hidden="true"></i></a></li>
                                             </ul>-->
                                        </div>
                                   </div>
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
$(document).ready(function() {

     $('#datetimepicker1').datetimepicker({
          format: 'YYYY-MM-DD'
     });
     $('#datetimepicker2').datetimepicker({
          format: 'YYYY-MM-DD'
     });
     @if($errors->has('from'))
           showNotification('error', "please fill from date");
     @endif
     @if($errors->has('to'))
           showNotification('error', "please fill to date");
     @endif


    $(".reset-btn").click(function(){
     $(':input','#order-form')
          .not(':button, :submit, :reset, :hidden')
          .val('')
          .prop('checked', false)
          .prop('selected', false);
        $("#order-form").trigger("submit");
    });




    window.setTimeout(function () {
          window.location.reload();
          }, 200000);


     
     @if(Session::has('success'))
     showNotification('success', "{{Session::get('success')}}");
     @endif
});
</script>
@endpush

@php
Session::forget('success');
@endphp
