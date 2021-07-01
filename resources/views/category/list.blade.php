@extends('layouts.app', [
'class' => '',
'elementActive' => 'category',
'title' => 'Categories',
])

@section('content')
<div class="content">
     <div class="row">
          <div class="col-md-12">
               <div class="card">
                    <div class="card-header">
                         <h4 class="card-title" style="padding-left:20px;">Categories</h4>
                    </div>
                    <div class="card-body">
                         <div class="bootstrap-table">
                              <div class="fixed-table-toolbar">
                                   <div class="bars pull-left">
                                        <div class="toolbar">
                                             <!--Here you can write extra buttons/actions for the toolbar-->
                                        </div>
                                   </div>
                                   <div class="columns columns-right pull-right mt-0" >
                                        <a href="{{ url('category/create') }}" style="font-size:16px;padding: 7px 20px;"
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
                                             <div class="form-group" style="padding-right: 6px;margin-bottom:0px;">

                                                  <input class="form-control" type="text" name="search"
                                                       placeholder="Search" value="{{ Request()->search ?? ''}}" style="height: calc(2.25rem + 2px);">

                                             </div>

                                             <div class="form-group" style="padding-right: 5px;margin-bottom:0px;">

                                                  <select name="menu_type" class="form-control" id="sel1">
                                                       <option value="">Menu Type</option>
                                                       @foreach($menu_types as $m_type)
                                                       <option value="{{ $m_type->id }}"
                                                            {{ Request()->menu_type == $m_type->id ? 'selected' : '' }}>
                                                            {{ $m_type->name }}</option>
                                                       @endforeach
                                                  </select>
                                             </div>
                                             <div class="form-group"  style="margin-bottom:0px;">
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

                                                            <th class="" style="padding-left:15px;">
                                                                 <div class="th-inner ">Sl No</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th style="">
                                                                 <div class="th-inner sortable both">
                                                                      @sortablelink('name', 'Name')</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th style="">
                                                                 <div class="th-inner sortable both">Description</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th style="">
                                                                 <div class="th-inner sortable both">
                                                                      @sortablelink('menu_type_id', 'Menu Type')</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th class="text-center">
                                                                 <div class="th-inner ">@sortablelink('sort_order',
                                                                      'Sort order')</div>
                                                                 <div class="fht-cell"></div>
                                                            </th>
                                                            <th class="text-center">
                                                                 <div class="th-inner sortable both">
                                                                      @sortablelink('active', 'Active')</div>
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
                                                       $i = $data->perPage() * ($data->currentPage() - 1);
                                                       @endphp
                                                       @forelse($data as $category)
                                                       <tr>

                                                            <td class="" style="padding-left:25px;">{{++$i}}</td>
                                                            <td style=""><a href="{{ route('menu.index', ['menu_type' => $category->menu_type_id, 'category' => $category->id]) }}" style="color:#000;text-decoration: underline;">{{ $category->name }}</a></td>
                                                            <td style="">{{  \Illuminate\Support\Str::limit($category->description, 30) }}</td>
                                                            <td style="">
                                                                 {{ $category->menu_type->name}}
                                                            </td>
                                                            <td class="text-center">{{ $category->sort_order }}</td>
                                                            <td class="text-center">
                                                                 <label class="switch">
                                                                      <input type="checkbox"  class="switch-class"    data-name="category"  data-id="{{$category->id}}" autocomplete="off"{{ $category->active==1 ? 'checked': '' }}>
                                                                      <span class="slider round"></span>
                                                                 </label>
                                                            </td>
                                                            <td class="td-actions text-right" style="">
                                                                 <form action="{{ route('category.destroy', $category->id) }}"
                                                                      method="POST" class="form-inline float-right">
                                                                      <div class="table-icons">
                                                                           <a  title="Edit"
                                                                                class="table-action-edit"
                                                                                href="{{ route('category.edit', $category->id)}}"
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