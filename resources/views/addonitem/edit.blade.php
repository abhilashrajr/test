@extends('layouts.app', [
'title' => 'Edit Addon Item',
'class' => '',
'elementActive' => 'addonitem'
])
@push('styles')
<link href="{{ asset('paper') }}/css/bootstrap-select.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="content">
     <div class="row">
          <div class="col-12 col-sm-12 col-md-8 col-xl-6 col-lg-8">

                <div class="card">
                    <div class="card-header">
                         <h4 class="card-title">Edit Addon Category</h4>
                    </div>
                    <div class="card-body">
                         <form method="POST" action="{{ route('addonitem.update',$addon_item->id) }}" enctype="multipart/form-data">
                         @csrf
                         @method('PATCH')
                              <div class="form-group">
                                   <label>Name<star>*</star></label>
                                   <input type="text" name="name" placeholder="Addon Item Name" class="form-control  {{ $errors->has('name') ? 'has-error' : '' }}"
                                        value="{{$addon_item->name}}">
                                   @if ($errors->has('name'))
                                   <span class="text-danger">{{ $errors->first('name') }}</span>
                                   @endif
                              </div>
                              <div class="form-group">
                                   <label>Description</label>
                                   <textarea class="form-control" name="description" placeholder="Addon Item Description"
                                        rows="3">{{$addon_item->description}}</textarea>
                              </div>
                              <div class="form-group">
                                   <label>Price<star>*</star></label>
                                   <input type="text" name="price" placeholder="Addon Item price" class="form-control  {{ $errors->has('price') ? 'has-error' : '' }}"
                                        value="{{$addon_item->price}}">
                                   @if ($errors->has('price'))
                                   <span class="text-danger">{{ $errors->first('price') }}</span>
                                   @endif
                              </div>
                              <div class="form-group">
                                   <label for="addoncat">Addon Categories<star>*</star> </label>
                                   <select name="addoncategory[]" class="form-control selectpicker" data-live-search="true" data-style="bsselect" title="Choose categories..." id="addoncat" multiple>
                              
                                   @foreach($addon_categories as $acat)
                                       <option value="{{ $acat->id }}" {{ in_array($acat->id, $item_categories) ? 'selected' : '' }}>{{ $acat->name }}</option>
                                   @endforeach    
                                   </select>
                                   @if ($errors->has('addoncategory'))
                                   <span class="text-danger">{{ $errors->first('addoncategory') }}</span>
                                   @endif
                              </div>
                              <div class="form-group">
                                   <label>Addon Item Image</label>
                                   <input type="file" name="image" class="form-control border" style="padding:8px;">
                                   @if ($errors->has('image'))
                                   <span class="text-danger">{{ $errors->first('image') }}</span>
                                   @endif
                              </div>
                              <div class="form-group">
                                   <label>Sorting Order</label>
                                   <input type="text" name="sort_order" placeholder="Order No."
                                        value="{{$addon_item->sort_order}}" class="form-control {{ $errors->has('sort_order') ? 'has-error' : '' }}">
                                   @if ($errors->has('sort_order'))
                                   <span class="text-danger">{{ $errors->first('sort_order') }}</span>
                                   @endif
                              </div>
                            
                              <div class="form-group">
                                   <label for="sel2">Active:</label>
                                   <select name="active" class="form-control" id="sel2">
                                        <option value="1" {{ $addon_item->active == '1' ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ $addon_item->active == '0' ? 'selected' : '' }}>No</option>
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
@push('scripts')
<script src="{{ asset('paper') }}/js/bootstrap-select.min.js"></script>
@endpush