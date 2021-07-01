@extends('layouts.app', [
'title' => 'Edit Food Size',
'class' => '',
'elementActive' => 'size'
])

@section('content')
<div class="content">
     <div class="row">
          <div class="col-12 col-sm-12 col-md-8 col-xl-6 col-lg-8">

                <div class="card">
                    <div class="card-header">
                         <h4 class="card-title">Edit Food Size</h4>
                    </div>
                    <div class="card-body">
                         <form method="POST" action="{{ route('size.update',$size->id) }}" enctype="multipart/form-data">
                         @csrf
                         @method('PATCH')
                              <div class="form-group">
                                   <label>Name<star>*</star></label>
                                   <input type="text" name="name" placeholder="Category Name" class="form-control"
                                   value="{{ $size->name }}">
                                   @if ($errors->has('name'))
                                   <span class="text-danger">{{ $errors->first('name') }}</span>
                                   @endif
                              </div>

                              <div class="form-group">
                                   <label>Sort Order</label>
                                   <input type="text" name="sort_order" placeholder="Category Order No."
                                   value="{{ $size->sort_order }}" class="form-control">
                                   @if ($errors->has('sort_order'))
                                   <span class="text-danger">{{ $errors->first('sort_order') }}</span>
                                   @endif
                              </div>
                              <div class="form-group">
                                   <label for="sel2">Active:</label>
                                   <select name="active" class="form-control" id="sel2">
                                        <option value="1" {{ $size->active == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ $size->active == '0' ? 'selected' : '' }}>No</option>
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