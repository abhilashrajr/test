@extends('layouts.app', [
'title' => 'Add Food Size',
'class' => '',
'elementActive' => 'size'
])

@section('content')
<div class="content">
     <div class="row">
          <div class="col-12 col-sm-12 col-md-12  col-lg-8 col-xl-6">

                <div class="card">
                    <div class="card-header">
                         <h4 class="card-title">Add Food Size</h4>
                    </div>
                    <div class="card-body">
                         <form method="POST" action="{{ route('size.store') }}" enctype="multipart/form-data">
                         @csrf
                         
                              <div class="form-group">
                                   <label>Name<star>*</star></label>
                                   <input type="text" name="name" placeholder="Size Name" class="form-control  {{ $errors->has('name') ? 'has-error' : '' }}"
                                        value="{{old('name')}}">
                                   @if ($errors->has('name'))
                                   <span class="text-danger">{{ $errors->first('name') }}</span>
                                   @endif
                              </div>
                             
                              <div class="form-group">
                                   <label>Order No</label>
                                   <input type="text" name="sort_order" placeholder="Order No."
                                        value="{{old('sort_order', 1)}}" class="form-control {{ $errors->has('sort_order') ? 'has-error' : '' }}">
                                   @if ($errors->has('sort_order'))
                                   <span class="text-danger">{{ $errors->first('sort_order') }}</span>
                                   @endif
                              </div>
                              <div class="form-group">
                                   <label for="sel2">Active:</label>
                                   <select name="active" class="form-control" id="sel2">
                                        <option value="1" {{ old('active') == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>No</option>
                                   </select>
                              </div>

                              <button type="submit" class="btn btn-fill btn-c1">Create</button>
                         </form>
                    </div>
               </div>
          </div>

     </div>
</div>

@endsection

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