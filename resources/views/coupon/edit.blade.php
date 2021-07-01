@extends('layouts.app', [
'title' => 'Create Coupon',
'class' => '',
'elementActive' => 'coupon'
])

@push('styles')
<link rel="stylesheet" type="text/css" media="screen" href="{{asset('paper') }}/css/tempusdominus-bootstrap-4.css">
@endpush

@section('content')
<div class="content">
     <div class="row">
          <div class="col-12 col-sm-12 col-md-12  col-lg-8 col-xl-6">

                <div class="card">
                    <div class="card-header">
                         <h4 class="card-title">Edit Coupon</h4>
                    </div>
                    <div class="card-body">
                         <form method="POST" action="{{ route('coupon.update',$coupon->id) }}" enctype="multipart/form-data">
                         @csrf
                         @method('PATCH')
                              <div class="form-group">
                                   <label>Code<star>*</star></label>
                                   <input type="text" name="code" placeholder="Coupon Code" class="form-control  {{ $errors->has('code') ? 'has-error' : '' }}"
                                        value="{{$coupon->name}}">
                                   @if ($errors->has('code'))
                                   <span class="text-danger">{{ $errors->first('code') }}</span>
                                   @endif
                              </div>

                              <div class="form-group">
                                   <label>Coupon Type</label>
                                   <select name="type" class="form-control" >
                                                        <option value="" {{ $coupon->type == '' ? 'selected' : '' }}>Please Select</option>
                                                      <!--  <option value="1" {{$coupon->type == '1' ? 'selected' : '' }}>For All </option>-->
                                                       <option value="2" {{$coupon->type == '2' ? 'selected' : '' }}>Collection only 
                                                       </option>
                                                       <option value="3" {{ $coupon->type == '3' ? 'selected' : '' }}>Delivery only
                                                       </option>
                                                       <option value="4" {{ $coupon->type == '4' ? 'selected' : '' }}>Delivery & Collection
                                                       </option>
                                                   <!--    <option value="5" {{ $coupon->type == '5' ? 'selected' : '' }}>Dine in only
                                                       </option>
                                                       <option value="6" {{ $coupon->type == '6' ? 'selected' : '' }}>Pay Now only
                                                       </option>
                                                       <option value="7" {{ $coupon->type == '7' ? 'selected' : '' }}>Booking only
                                                       </option>-->
                                              </select>
                              </div>
                              <div class="row ">
                             
                                  <div class="col">
                                   <div class="form-group">
                                        <label>Value</label>
                                        <input type="text" name="value" placeholder="Coupon Value" class="form-control  {{ $errors->has('value') ? 'has-error' : '' }}"
                                             value="{{$coupon->value}}">
                                        @if ($errors->has('value'))
                                        <span class="text-danger">{{ $errors->first('value') }}</span>
                                        @endif
                                   </div>
                                   </div>
                              <div class="col">
                                   <div class="form-group">
                                        <label>Reduction Type</label>
                                        <select name="reduction" class="form-control" id="sel2">
                                             <option value="1" {{ $coupon->reduction == '1' ? 'selected' : '' }}>Amount</option>
                                             <option value="2" {{  $coupon->reduction == '2' ? 'selected' : '' }}>Percentage</option>
                                        </select>
                                        @if ($errors->has('percentage'))
                                        <span class="text-danger">{{ $errors->first('percentage') }}</span>
                                        @endif
                                   </div>
                                   </div>
                              </div>
                              <div class="row ">
                                  <div class="col">
                                        <div class="form-group">
                                             <label>Min Amount</label>
                                             <input type="text" name="min_amount" placeholder="Min Order Amount"
                                                  value="{{$coupon->min_amount}}" class="form-control {{ $errors->has('min_amount') ? 'has-error' : '' }}">
                                             @if ($errors->has('min_amount'))
                                             <span class="text-danger">{{ $errors->first('min_amount') }}</span>
                                             @endif
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                             <label>Maximum Reduction (For percentage reduction)</label>
                                             <input type="text" name="max_reduction" placeholder="Max Reduction Amount"
                                                  value="{{$coupon->max_reduction}}" class="form-control {{ $errors->has('max_reduction') ? 'has-error' : '' }}">
                                             @if ($errors->has('max_reduction'))
                                             <span class="text-danger">{{ $errors->first('max_reduction') }}</span>
                                             @endif
                                        </div>
                                        </div>
                                    </div>
                              <div class="row ">
                                  <div class="col">      
                                        <div class="form-group">
                                             <label>Start Date</label>
                                             <input type="text" name="start_date" id="datetimepicker1"  data-toggle="datetimepicker" data-target="#datetimepicker1" placeholder="Start Date"
                                                  value="{{$coupon->start_date}}" class="form-control datetimepicker-input {{ $errors->has('start_date') ? 'has-error' : '' }}">
                                             @if ($errors->has('start_date'))
                                             <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                             @endif
                                        </div>
                                   </div>
                                   <div class="col">   
                                        <div class="form-group">
                                             <label>End Date</label>
                                             <input type="text" name="end_date" id="datetimepicker2"  data-toggle="datetimepicker" data-target="#datetimepicker2" placeholder="End Date"
                                                  value="{{$coupon->end_date}}" class="form-control datetimepicker-input {{ $errors->has('end_date') ? 'has-error' : '' }}">
                                             @if ($errors->has('end_date'))
                                             <span class="text-danger">{{ $errors->first('end_date') }}</span>
                                             @endif
                                        </div>
                                    </div>
                              </div>
                              
                              <div class="form-group">
                                   <label for="sel2">Active:</label>
                                   <select name="active" class="form-control" id="sel2">
                                        <option value="1" {{ $coupon->active == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ $coupon->active == '0' ? 'selected' : '' }}>No</option>
                                   </select>
                              </div>

                              <button type="submit" class="btn btn-fill btn-c1">Update</button>
                         </form>
                    </div>
               </div>
          </div>

     </div>
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