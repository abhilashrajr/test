@extends('layouts.app', [
'title' => 'Add Menu',
'class' => '',
'elementActive' => 'menu'
])

@push('styles')
<link href="{{ asset('paper') }}/css/bootstrap-select.min.css" rel="stylesheet" />
<style>
.myaccordion {
     box-shadow: 0 0 0px rgba(0, 0, 0, 0.1);
}

.myaccordion .card,
.myaccordion .card:last-child .card-header {
     border: 1px solid #e8e7e3;
     box-shadow: none;
     border-radius: 0px;
}

.myaccordion .card {
     margin-bottom: 10px !important;
}

.myaccordion .card-header {
     border-bottom-color: #EDEFF0;
     /*background: transparent;*/
     background-color: #F3F2EE;
     border: 1px solid #e8e7e3;
     padding: 3px 10px !important;
}

.myaccordion .card-header a {
     text-decoration: none;
     font-size: 14px;
     /* font-weight:bold;*/
     color: #66615b;
     font-weight: 400;
}

.myaccordion .fa {
     display: inline-block;
     font: normal normal normal 14px/1 FontAwesome;
     color: #aea8a0;
     font-size: 18px !important;
     line-height: 28px;
     font-weight: lighter;
     /*font-size: inherit;*/
     text-rendering: auto;
     -webkit-font-smoothing: antialiased;
     -moz-osx-font-smoothing: grayscale;
}

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
                              <h4 class="card-title">Menu Details</h4>
                         </div>
                         <div class="card-body">


                              <div class="form-group">
                                   <label>Name<star>*</star></label>
                                   <input type="text" name="name" placeholder="Name"
                                        class="form-control  {{ $errors->has('name') ? 'has-error' : '' }}"
                                        value="{{old('name')}}">
                                   @if ($errors->has('name'))
                                   <span class="text-danger">{{ $errors->first('name') }}</span>
                                   @endif
                              </div>

                              <div class="form-group">
                                   <label>Description</label>
                                   <textarea class="form-control" name="description" placeholder="Description"
                                        rows="3">{{old('description')}}</textarea>
                              </div>



                              <div class="row">
                                   <div class="col">
                              <div class="form-group">
                                   <label>Price<star>*</star></label>
                                   <input type="text" name="price" placeholder="Price"
                                        class="form-control  {{ $errors->has('price') ? 'has-error' : '' }}"
                                        value="{{old('price')}}">
                                   @if ($errors->has('price'))
                                   <span class="text-danger">{{ $errors->first('price') }}</span>
                                   @endif
                              </div>
                              </div>
                              <div class="col">
                              <div class="form-group">
                                   <label for="sel1">Menu Type<star>*</star></label>
                                   <select name="menu_type"
                                        class="form-control {{ $errors->has('menu_type') ? 'has-error' : '' }}"
                                        id="menutype">
                                        @foreach($menu_types as $m_type)
                                        <option value="{{ $m_type->id }}"
                                             {{ (old('menu_type') == $m_type->id || $request->menu_type ==  $m_type->id ) ? 'selected' : '' }}>{{ $m_type->name }}
                                        </option>
                                        @endforeach
                                   </select>
                                   @if ($errors->has('menu_types'))
                                   <span class="text-danger">{{ $errors->first('menu_types') }}</span>
                                   @endif
                              </div>
                              </div>
                              </div>


                              <div class="form-group" style="">
                                   <label for="category">Category<star>*</star></label>
                                   <select name="category"
                                        class="form-control {{ $errors->has('category') ? 'has-error' : '' }}" id="category">
                                        <option value="">Please Select Category</option>
                                        @foreach($category as $cat)
                                        <option value="{{ $cat->id }}"
                                             {{ (old('category') == $cat->id || $request->category ==  $cat->id) ? 'selected' : '' }}>{{ $cat->name }}
                                        </option>
                                        @endforeach
                                   </select>
                                   @if ($errors->has('category'))
                                   <span class="text-danger">{{ $errors->first('category') }}</span>
                                   @endif
                              </div>



                              <div class="row">
                                   <div class="col">
                                        <div class="form-group">
                                             <label>Image</label>
                                             <input type="file" name="image" class="form-control border"
                                                  style="padding:8px;">
                                             @if ($errors->has('image'))
                                             <span class="text-danger">{{ $errors->first('image') }}</span>
                                             @endif
                                        </div>
                                   </div>
                                   <div class="col">
                                        <div class="form-group">
                                             <label>Size</label>
                                             <select name="size" class="form-control">
                                                  <option value=""></option>
                                                  @foreach($sizes as $size)
                                                  <option value="{{ $size->id }}"
                                                       {{ old('size') == $size->id ? 'selected' : '' }}>
                                                       {{ $size->name }}
                                                  </option>
                                                  @endforeach
                                             </select>
                                             @if ($errors->has('size'))
                                             <span class="text-danger">{{ $errors->first('size') }}</span>
                                             @endif
                                        </div>
                                   </div>
                              </div>

                             
                              <div class="row ">
                                  
                                   <div class="col">
                                        <div class="form-group">
                                             <label class="form-check-label">
                                                 Badge  </label>
                                                  <select name="best_seller" class="form-control" id="sel2">
                                                        <option value="0" {{ old('best_seller') == '0' ? 'selected' : '' }}>None
                                                       <option value="1" {{ old('best_seller') == '1' ? 'selected' : '' }}>Best Seller
                                                       </option>
                                                       <option value="2" {{ old('best_seller') == '2' ? 'selected' : '' }}>Must Try
                                                  </option>
                                                  <option value="3" {{ old('best_seller') == '3' ? 'selected' : '' }}>Hot
                                                  </option>
                                                  <option value="4" {{ old('best_seller') == '4' ? 'selected' : '' }}>Spicy
                                                  </option>
                                                 
                                              </select>
                                            
                                        </div>
                                   </div>
                                   <div class="col">
                                        <div class="form-group">
                                             <label class="form-check-label">
                                                 Veg 
                                             </label> 
                                             <select name="veg" class="form-control" id="sel2">
                                             <option value="0" {{ old('veg') == '1' ? 'selected' : '' }}>No
                                                  </option>
                                                  <option value="1" {{ old('veg') == '0' ? 'selected' : '' }}>Yes
                                                  </option>
                                                  </select>
                                        </div>
                                   </div>
                              </div>
                              <div class="row">
                                   <div class="col">
                                        <div class="form-group">
                                             <label>Sorting Order</label>
                                             <input type="text" name="sort_order" placeholder="Order No."
                                                  value="{{old('sort_order', 1)}}"
                                                  class="form-control {{ $errors->has('sort_order') ? 'has-error' : '' }}">
                                             @if ($errors->has('sort_order'))
                                             <span class="text-danger">{{ $errors->first('sort_order') }}</span>
                                             @endif
                                        </div>
                                   </div>
                                   <div class="col">
                                        <div class="form-group">
                                             <label for="sel2">Active:</label>
                                             <select name="active" class="form-control" id="sel2">
                                                  <option value="1" {{ old('active') == '1' ? 'selected' : '' }}>Yes
                                                  </option>
                                                  <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>No
                                                  </option>
                                             </select>
                                        </div>
                                   </div>
                              </div>


                         </div>
                    </div>
               </div>
               <div class="col-xl-6">
                    <div class="card">
                         <div class="card-header">
                              <h4 class="card-title">Addons</h4>
                         </div>
                         <div class="card-body">
                              <div id="accordion" class="myaccordion">
                              <input type="hidden" name="addon_cat_order" value="">
                                   @foreach($data as $key => $cat)
                                   <input type="hidden" name="addon[{{$key}}][acat_id]" value="{{$key}}">

                                   <div class="card" data-id="{{$key}}">
                                        <h5 class="card-header" data-background-color="#F3F2EE" role="tab"
                                             id="heading{{$key}}">
                                             <a class="collapsed d-block" data-toggle="collapse"
                                                  data-parent="#accordion" href="#collapse{{$key}}"
                                                  aria-expanded="false" aria-controls="collapse{{$key}}">
                                                  <i class="fa fa-chevron-down pull-right"></i> {{$cat['category']}}
                                             </a>
                                        </h5>
                                        <div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}"
                                             data-parent="#accordion">
                                             <div class="card-body">
                                                  <div class="table-responsive">
                                                       <table id="bootstrap-table"
                                                            class="table table-bordered table-sm "
                                                            style="white-space:nowrap;background-color: #f3f2ee;">
                                                            <tr>
                                                                 <td><input name="btSelectAll" type="checkbox"
                                                                           onClick="check_uncheck(this.checked,{{$key}})">
                                                                      Check
                                                                      All
                                                                 </td>
                                                                 <td><input name="addon[{{$key}}][required]"
                                                                           type="checkbox" value="1"> Required
                                                                 </td>
                                                                 <td><input name="addon[{{$key}}][multiple]"
                                                                           type="checkbox" value="1"> Multiple
                                                                 </td>
                                                            </tr>
                                                       </table>
                                                  </div>

                                                  <div class="table-responsive">
                                                       <table id="bootstrap-table"
                                                            class="table table-bordered table-sm "
                                                            style="white-space:nowrap;background-color: #f3f2ee;">
                                                            <thead>
                                                                 <tr>
                                                                      <th class="bs-checkbox " style="width: 36px; "
                                                                           data-field="state">

                                                                      </th>
                                                                      <th>
                                                                          Name
              
                                                                      </th>
                                                                      <th>
                                                                                Price
                                                                      </th>
                                                                      <th>
                                                                                   Min
                                                                      </th>
                                                                      <th>
                                                                                   Max
                                                                      </th>
                                                                 </tr>
                                                            </thead>
                                                            <tbody>
                                                                 <!--<tr>
                                                                      <td style=""></td>
                                                                      <td class="" >Name
                                                                      </td>
                                                                      <td style="">Price</td>
                                                                 </tr>-->
                                                                 @php 
                                                                 $i = 0;
                                                                 @endphp
                                                                 @foreach($cat['items'] as $item)
                                                                 <tr>
                                                                      <td class="text-center"><input
                                                                                name="addon[{{$key}}][items][{{$i}}][id]"
                                                                                type="checkbox"
                                                                                value="{{$item['item_id']}}" class="acheckbox{{$key}}">
                                                                      </td>
                                                                      <td>{{$item['name']}}
                                                                      </td>
                                                                      <td>{{$item['price']}}</td>
                                                                      <td>  <input type="number" name="addon[{{$key}}][items][{{$i}}][min]" 
                                        class="form-control form-control-sm text-center p-1 bg-light {{ $errors->has('price') ? 'has-error' : '' }}"
                                        value="{{old('addon[$key][items][$i][min]') ?? 1}}" min="1"  style="max-width: 90px;min-width: 50px;"></td>
                                                                      <td>  <input type="number" name="addon[{{$key}}][items][{{$i}}][max]" 
                                        class="form-control form-control-sm text-center p-1 bg-light {{ $errors->has('price') ? 'has-error' : '' }}"
                                        value="{{old('addon[$key][items][$i][max]') ?? 1}}" min="1"  style="max-width: 90px;min-width: 50px;"></td>
                                                                 </tr>
                                                                 @php 
                                                                 $i++;
                                                                 @endphp
                                                                 @endforeach
                                                            </tbody>
                                                       </table>
                                                  </div>


                                             </div>
                                        </div>
                                   </div>
                                   @endforeach


                              </div>
                              <button type="submit" class="btn btn-fill btn-c1">Create</button>
                         </div>
                    </div>
               </div>

          </div>
     </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('paper') }}/js/bootstrap-select.min.js"></script>
<script src="{{ asset('paper') }}/js/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
     $("#accordion").on("hide.bs.collapse show.bs.collapse", e => {
          $(e.target)
               .prev()
               .find("i:last-child")
               .toggleClass("fa-minus fa-plus");
     });
 /*---sorting---*/

 $('#accordion').sortable();
        $('#accordion').on("show.bs.collapse", function(){ $('#accordion').sortable('disable'); });
        $('#accordion').on("hide.bs.collapse", function(){ $('#accordion').sortable('enable'); });

        $('#accordion').accordion({
            collapsible: true,
            active: true,
            heightStyle: 'fill',
            header: 'card'
        }).sortable({
            change: function(event, ui) {
                ui.placeholder.css({visibility: 'visible', border : '3px solid #ef8157'});
            },
            items: '.card'
        }).bind('sortupdate', function(e, ui) {
          var acatorder =  $(this).sortable('toArray',{ attribute: 'data-id'});
            $("input[name='addon_cat_order']").val(JSON.stringify(acatorder)); 
		});
     /*---- end sorting -----*/     




     $('#menutype').change(function() {
          var menutype_id = $(this).val();
          if (menutype_id) {
              
               var _token = $("input[name='_token']").val();
               $.ajax({
                    type: "POST",
                    url: "{{url('get_categories')}}",
                    data: {
                         _token:_token,menu_tid: menutype_id
                    },
                    success: function(res) {
                         if (res) {
                              $("#category").empty();
                              $("#category").append('<option>Select Category</option>');
                              $.each(res, function(key, value) {
                                   $("#category").append('<option value="' +
                                        key + '">' + value +
                                        '</option>');
                              });

                         } else {
                              $("#category").empty();
                         }
                    }
               });
                    
          } else {
               $("#category").empty();

          }
     });


    


});

function check_uncheck(isChecked, key) {
     $('.acheckbox'+key).prop('checked',isChecked);
}
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
