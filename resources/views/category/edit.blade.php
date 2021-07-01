@extends('layouts.app', [
'title' => 'Edit Category',
'class' => '',
'elementActive' => 'category'
])

@section('content')
<div class="content">
     <div class="row">
          <div class="col-12 col-sm-12 col-md-8 col-xl-6 col-lg-8">

                <div class="card">
                    <div class="card-header">
                         <h4 class="card-title">Edit Category</h4>
                    </div>
                    <div class="card-body">
                         <form method="POST" action="{{ route('category.update',$category->id) }}" enctype="multipart/form-data">
                         @csrf
                         @method('PATCH')
                              <div class="form-group">
                                   <label>Name<star>*</star></label>
                                   <input type="text" name="name" placeholder="Category Name" class="form-control"
                                   value="{{ $category->name }}">
                                   @if ($errors->has('name'))
                                   <span class="text-danger">{{ $errors->first('name') }}</span>
                                   @endif
                              </div>

                              <div class="form-group">
                                   <label>Description</label>
                                   <textarea class="form-control" name="description" placeholder="Category Description"
                                        rows="3">{{$category->description}}</textarea>
                              </div>
                              <div class="form-group">
                                   <label>Category Image</label>
                                   <input type="file" name="image" class="form-control border" style="padding:8px;">
                                   @if ($errors->has('image'))
                                   <span class="text-danger">{{ $errors->first('image') }}</span>
                                   @endif
                              </div>
                              <div class="form-group">
                                   <label for="sel1">Menu Type:</label>
                                   <select name="menu" class="form-control" id="sel1">
                                   @foreach($menu_types as $m_type)
                                       <option value="{{ $m_type->id }}" {{ $category->menu_type_id == $m_type->id ? 'selected' : '' }}>{{ $m_type->name }}</option>
                                   @endforeach    
                                   </select>
                              </div>
                             
                              <div class="form-group">
                                   <label>Sort Order</label>
                                   <input type="text" name="sort_order" placeholder="Category Order No."
                                   value="{{ $category->sort_order }}" class="form-control">
                                   @if ($errors->has('sort_order'))
                                   <span class="text-danger">{{ $errors->first('sort_order') }}</span>
                                   @endif
                              </div>
                              <div class="form-group">
                                   <label for="sel2">Active:</label>
                                   <select name="active" class="form-control" id="sel2">
                                        <option value="1" {{ $category->active == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ $category->active == '0' ? 'selected' : '' }}>No</option>
                                   </select>
                              </div>

                              <button type="submit" class="btn btn-fill btn-c1">Update</button>
                         </form>
                    </div>
               </div>
          </div>
          @isset($category->image)
          <!--<div class="col-12 col-sm-12 col-md-4 col-xl-6 col-lg-4">
                <img class="img-fluid" src="{{ $category->image }}" alt="{{ $category->name }}"> 
          </div>-->
          @endisset
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