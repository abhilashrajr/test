@extends('layouts.app', [
'class' => '',
'elementActive' => 'menu',
'title' => 'Menu',
])

@section('content')
<div class="content">
     <div class="row">
          <div class="col-md-12">
               <div class="card">
                    <div class="card-header">
                         <h4 class="card-title" style="padding-left:20px;">Menu</h4>
                    </div>
                    <div class="card-body">
                         <div class="bootstrap-table">
                              <div class="fixed-table-toolbar">
                                   <div class="bars pull-left">
                                        <div class="toolbar">
                                             <!--Here you can write extra buttons/actions for the toolbar-->
                                        </div>
                                   </div>
                                   <div class="columns columns-right pull-right mt-0">
                                        <a href="{{ url('menu/create')}}?{{$request->getQueryString() }}" style="font-size:16px;padding: 7px 20px;"
                                             class="btn  btn-default btn-fill btn-magnify" role="button"><span
                                                  class="btn-label">
                                                  <i class="fa fa-plus" style="padding-right:5px;"></i>
                                             </span>
                                             Add</a>




                                        <!--<button class="btn btn-default"
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

                                   <div class="pull-left search">
                                        <form method="get" action="" class="form-inline">
                                             <div class="form-group" style="padding-right: 6px;">

                                                  <input class="form-control" type="text" name="search"
                                                       placeholder="Search" value="{{ Request()->search ?? ''}}"
                                                       style="height: calc(2.25rem + 2px);">

                                             </div>
                                             <div class="form-group" style="padding-right: 5px;margin-bottom:0px;">

                                                  <select name="menu_type" class="form-control" id="menutype">
                                                       <option value="">Menu Type</option>
                                                       @foreach($menu_types as $m_type)
                                                       <option value="{{ $m_type->id }}"
                                                            {{ Request()->menu_type == $m_type->id ? 'selected' : '' }}>
                                                            {{ $m_type->name }}</option>
                                                       @endforeach
                                                  </select>
                                             </div>
                                             <div class="form-group"
                                                  style="padding-right: 5px;margin-bottom:0px;display:none;"
                                                  id="catdiv">
                                                  <select name="category" class="form-control" id="category">
                                                       <option value="">Category</option>
                                                       @foreach($categories as $cat)
                                                       <option value="{{ $cat->id }}"
                                                            {{ Request()->category == $cat->id ? 'selected' : '' }}>
                                                            {{ $cat->name }}</option>
                                                       @endforeach
                                                  </select>
                                             </div>
                                             <div class="form-group" style="margin-bottom:0px;">
                                                  <button type="submit" class="btn btn-fill btn-c1">Go</button>
                                             </div>
                                        </form>
                                   </div>

                              </div>
                              <div class="fixed-table-container" style="padding-bottom: 0px;">
                                   <div class="fixed-table-header" style="display: none;">
                                        <table></table>
                                   </div>
                                   <div class="fixed-table-body">
                                        <!--<div class="fixed-table-loading" style="top: 41px;">Loading, please wait...
                                        </div>-->
                                        <div class="table-responsive">
                                             <table id="bootstrap-table" class="table table-hover table-sm "
                                                  style="white-space:nowrap;">
                                                  <thead>
                                                       <tr>

                                                            <th style="padding-left:15px;">
                                                                 <div class="th-inner ">Sl No</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th>
                                                                 <div class="th-inner">
                                                                      @sortablelink('name', 'Name')</div>

                                                            </th>
                                                            <th>
                                                                 <div class="th-inner ">
                                                                      @sortablelink('menu_type.name', 'Menu Type')</div>

                                                            </th>
                                                            <th>
                                                                 <div class="th-inner ">
                                                                      @sortablelink('category.name', 'Category')</div>

                                                            </th>
                                                            <th>
                                                                 <div class="th-inner"> @sortablelink('price', 'Price')
                                                                 </div>

                                                            </th>
                                                            <th class="text-center">
                                                                 <div class="th-inner ">@sortablelink('sort_order',
                                                                      'Order')</div>
                                                            </th>
                                                            <th class="text-center">
                                                                 <div class="th-inner">
                                                                      @sortablelink('active', 'Active')
                                                                      </div>

                                                            </th>
                                                            <th class="td-actions text-right"
                                                                 style="padding-right:15px;" data-field="actions">
                                                                 <div class="th-inner ">Actions</div>

                                                            </th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       @php
                                                       $i = $data->perPage() * ($data->currentPage() - 1);
                                                       @endphp
                                                       @forelse($data as $item)
                                                       <tr>

                                                            <td class="" style="padding-left:25px;">{{++$i}}</td>
                                                            <td style="">{{ $item->name }}</td>
                                                            <td style="">{{ $item->menu_type->name }}</td>
                                                            <td style="">{{ $item->category->name }}</td>
                                                            <td style="">{{ $item->price }}</td>
                                                            <td class="text-center">{{ $item->sort_order }}</td>
                                                            <td class="text-center">
                                                                 <!--{{ $item->active==1 ? 'Yes': 'No' }} -->
                                                                 
                                                                 <label class="switch">
                                                                      <input type="checkbox"  class="switch-class"    data-name="menu"  data-id="{{$item->id}}" autocomplete="off"{{ $item->active==1 ? 'checked': '' }}>
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                                
                                                                 
                                                                 
                                                                 </td>
                                                            <td class="td-actions text-right" style="">
                                                                 <form action="{{ route('menu.destroy', $item->id) }}"
                                                                      method="POST" class="form-inline float-right">
                                                                      <div class="table-icons">
                                                                           <a title="View" class="table-action-view "
                                                                                href="{{ route('menu.show', $item->id)}}"
                                                                                data-original-title="View"><i
                                                                                     class="fa fa-eye"></i></a>
                                                                           <a title="Edit" class="table-action-edit"
                                                                                href="{{ route('menu.edit', $item->id)}}"
                                                                                data-original-title="Edit"><i
                                                                                     class="fa fa-edit"></i></a>
                                                                           @csrf
                                                                           @method('DELETE')

                                                                           <button
                                                                                onclick="return confirm('Are you sure?')"
                                                                                title="Remove" type="submit"
                                                                                class="table-action-remove"><i
                                                                                     class="fa fa-times"></i></button>
                                                                      </div>
                                                                 </form>
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
                                        
                                        <!--
                                        <div class="dropup pull-left">
                                             <button type="button" class="btn btn-outline-secondary dropdown-toggle"
                                                  data-toggle="dropdown" style="border-radius: 20px;background-color: transparent;border: 2px solid #666158;color: #66615B;">
                                                 8
                                             </button>
                                             <div class="dropdown-menu">
                                                  <a  class="dropdown-item" href="javascript:{}" >15</a>
                                                  <a class="dropdown-item" href="#">25</a>
                                                  <a class="dropdown-item" href="#">50</a>
                                             </div>
                                        </div>
                                        -->
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
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
     if ($('#menutype').val() != "") {
          $("#catdiv").show();
     }
     $('#menutype').change(function() {
          var menutype_id = $(this).val();
          if (menutype_id) {

               var _token = $("input[name='_token']").val();
               $.ajax({
                    type: "POST",
                    url: "{{url('get_categories')}}",
                    data: {
                         _token: _token,
                         menu_tid: menutype_id
                    },
                    success: function(res) {
                         if (res) {
                              $("#catdiv").show();
                              $("#category").empty();
                              $("#category").append('<option value="">Category</option>');
                              $.each(res, function(key, value) {
                                   $("#category").append(
                                        '<option value="' +
                                        key + '">' + value +
                                        '</option>');
                              });

                         } else {
                              $("#catdiv").hide();
                         }
                    }
               });

          } else {
               $("#catdiv").hide();

          }
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