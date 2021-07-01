@extends('layouts.app', [
'class' => '',
'elementActive' => ($order_type == "dinein") ? 'dinein' : 'order',
'title' => 'Orders',
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
          <a type="button"  target="_self" href="{{route('orders')}}" class="btn btn-fill {{($order_type != 'dinein') ? 'btn-c1' : 'btn-default' }}  mr-1">Delivery & Collection</a>
          <a  type="button" class="btn {{($order_type == 'dinein') ? 'btn-c1' : 'btn-default' }} mr-1" target="_self" href="{{route('dineinorders')}}">Dine In</a>
          <a  type="button" class="btn btn-default  mr-1" target="_self" href="{{route('paynoworders')}}">Pay Now </a>
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
                         <h4 class="card-title mb-0" style="padding-left:20px;">{{($order_type == "dinein") ? "Dine In " : ""}}Orders</h4>
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
                                       
                                            <!-- <div class="form-group" style="padding-right: 6px;margin-bottom:0px;">
                                             <input  class="form-control" type="text" placeholder="click to show datepicker"  id="example1">
                                                  <input class="form-control" type="text" name="search"
                                                       placeholder="Search" value="{{ Request()->search ?? ''}}"
                                                       style="height: calc(2.25rem + 2px);">

                                             </div>-->
                                              @if($order_type == "deli_coll")     
                                             <div class="form-group" style="padding-right: 5px;margin-bottom:0px;">
                                                  <select name="delivery_type" class="form-control" >
                                                       <option value="">Delivery & Collection</option>
                                                       <option value="delivery" {{ Request()->delivery_type == 'delivery' ? "selected" : "" }}>Delivery Only</option>
                                                       <option value="collection" {{ Request()->delivery_type == 'collection' ? "selected" : "" }}>Collection Only</option>
                                                  </select>
                                             </div>
                                             @endif
                                             <div class="form-group" style="padding-right: 5px;margin-bottom:0px;">
                                                  <select name="status" class="form-control" >
                                                       <option value="" >Status</option>
                                                       <option value="1" {{ Request()->status == "1" ? "selected" : "" }}>Pending</option>
                                                       <option value="2" {{ Request()->status == "2" ? "selected" : "" }}>Accepted</option>
                                                       <option value="3" {{ Request()->status == "3" ? "selected" : "" }}>Delivered</option>
                                                       <option value="4" {{ Request()->status == "4" ? "selected" : "" }}>Rejected</option>
                                                       <option value="10" {{ Request()->status == "10" ? "selected" : "" }}>Card not Paid</option>
                                                       <option value="5" {{ Request()->status == "5" ? "selected" : "" }}>Refund</option>
                                                       <option value="11" {{ Request()->status == "11" ? "selected" : "" }}>Pre Order</option>
                                                  </select>
                                             </div>
                                             @if($order_type == "deli_coll")
                                             <div class="form-group" style="padding-right: 5px;margin-bottom:0px;">
                                                  <select name="payment_type" class="form-control" >
                                                       <option value="">Cash & Card</option>
                                                       <option value="1" {{ Request()->payment_type == '1' ? "selected" : "" }}>Card Only</option>
                                                       <option value="2" {{ Request()->payment_type == '2' ? "selected" : "" }}>Cash Only</option>
                                                  </select>
                                             </div>
                                             @endif
                                             <!--
                                             <div class="form-group w-25" style="padding-right: 6px;margin-bottom:0px;">
                                           
                                                  <input class="form-control w-100" type="text" name="pincode"
                                                       placeholder="Pincode" value="{{ Request()->pincode ?? ''}}"
                                                       style="height: calc(2.25rem + 2px);">

                                             </div>
                                             -->
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

                                                            <th class="" style="padding-left:15px;">
                                                                 <div class="th-inner ">Order No</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th style="">
                                                                 <div class="th-inner sortable both">
                                                                      @sortablelink('order_time', 'Order Time')</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th style="">
                                                                 <div class="th-inner sortable both">
                                                                      @sortablelink('order_type', ' Delivery Type')
                                                                 </div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <!--
                                                            <th style="">
                                                                 <div class="th-inner sortable both">
                                                                      @sortablelink('delivery_postcode', 'Delivery
                                                                      Pincode')
                                                                 </div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            -->
                                                            <th class="text-center">
                                                                 <div class="th-inner ">@sortablelink('payment_method',
                                                                      'Payment Method')</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th class="text-center">
                                                                 <div class="th-inner sortable both">
                                                                      @sortablelink('status', 'Status') </div>
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
                                                            <td style="">
                                                                 {{  date('d M  Y,   h:i A ', strtotime($order->order_time))}}
                                                            </td>
                                                            <td style="">{{ $order->order_type }}</td>
                                                            <!--
                                                            <td style="">
                                                                 {{-- $order->delivery_postcode --}}
                                                            </td>
                                                            -->
                                                            <td class="text-center">
                                                                 {{ $order->payment_methods->name   }}</td>
                                                            <td class="text-center">
                                                                 @switch($order->status)
                                                                 
                                                                 @case(1)
                                                                      @if($order->payment_status ==1)
                                                                            <button   class="btn btn-danger btn-round  s-btn">Pending</button>
                                                                      @else
                                                                            <button class="btn   btn-default btn-round s-btn">Not paid</button>
                                                                      @endif      
                                                                 @break

                                                                 @case(2)
                                                                 <button
                                                                      class="btn  btn-warning btn-round s-btn">Accepted</button>
                                                                 @break
                                                                 @case(3)
                                                                 <button
                                                                      class="btn   btn-success btn-round s-btn">Delivered</button>
                                                                 @break
                                                                 @case(4)
                                                                 <button
                                                                      class="btn   btn-default btn-round s-btn">Rejected</button>
                                                                 @break
                                                                 @case(5)
                                                                 <button
                                                                      class="btn   btn-info btn-round s-btn">Refund</button>
                                                                 @break
                                                                 @case(10)
                                                                 <button
                                                                      class="btn   btn-default btn-round s-btn">Not paid</button>
                                                                 @break
                                                                 @default
                                                                 <span>Error</span>
                                                                 @endswitch



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
                                                                              <div class="dropdown float-left dropleft">
                                                                                     
                                                                                     <a title="View" class="table-action-status "   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                                                href="#" role="button"
                                                                                data-original-title="Edit"><i class="fa fa-ellipsis-h"></i></a>
                                                                                     <div class="dropdown-menu" style="display:'';">
                                                                                     <h5 class="dropdown-header">Change  Status</h5>
     
                                                                                     <a class="dropdown-item btn-danger" href="{{ route('changestatus',[ 'id'=>$order->id,'status'=>1])}}">Pending</a>
                                                                                     <a class="dropdown-item  btn-warning" href="{{ route('changestatus',[ 'id'=>$order->id,'status'=>2])}}">Accepted</a>
                                                                                     <a class="dropdown-item btn-success" href="{{ route('changestatus',[ 'id'=>$order->id,'status'=>3])}}">Delivered</a>
                                                                                     <a class="dropdown-item btn-default" href="{{ route('changestatus',[ 'id'=>$order->id,'status'=>4])}}">Rejected</a>
                                                                                     <a class="dropdown-item btn-info" href="{{ route('changestatus',[ 'id'=>$order->id,'status'=>5])}}">Refund</a>
                                                                                     </div>
                                                                                </div> 
                                                                                
                                                                           
                                                                                <a title="View" class="table-action-view "
                                                                                href="{{  route('orderview', ['id' => $order->id])}}"
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

  
     @if(Session::has('success'))
     showNotification('success', "{{Session::get('success')}}");
     @endif


     window.setTimeout(function () {
          window.location.reload();
          }, 200000);


});
</script>
@endpush

@php
Session::forget('success');
@endphp
