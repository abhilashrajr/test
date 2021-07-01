@extends('layouts.app', [
'title' => 'View Menu',
'class' => '',
'elementActive' => 'menu'
])

@push('styles')
<style>

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


                              <div class="table-responsive">
                                   <table id="bootstrap-table" class="table  table-bordered table-striped table-sm "
                                        style="white-space:nowrap;background-color: #f3f2ee;">
                                       
                                        <tbody>


                                             <tr>
                                                  <td class="font-weight-bold">Name</td>
                                                  <td>{{$menu->name}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Description</td>
                                                  <td>{{$menu->description}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Price</td>
                                                  <td>{{$menu->price}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Menu Type</td>
                                                  <td>{{$menu->menu_type->name}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Category</td>
                                                  <td>{{$menu->category->name}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Size</td>
                                                  <td>{{$menu->size->name ?? ''}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Order</td>
                                                  <td>{{$menu->sort_order}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Active</td>
                                                  <td>{{$menu->active == 1 ? 'Yes' : 'No'}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Veg</td>
                                                  <td>{{$menu->veg  == 1 ? 'Yes' : 'No'}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Best Seller</td>
                                                  <td>{{$menu->best_seller  == 1 ? 'Yes' : 'No'}}</td>
                                             </tr>
                                              <tr>
                                                  <td class="font-weight-bold">Image</td>
                                                  <td><img src="{{ url('storage/images/'.$menu->image)}}" class="img-fluid" style="max-width:300px;max-height:300px"alt=""/></td>
                                             </tr>
                                             
                                             <tr>
                                                  <td class="font-weight-bold">Created At</td>
                                                  <td>{{$menu->created_at}}</td>
                                             </tr>
                                        </tbody>
                                   </table>
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

                              @forelse($madata as $key => $cat)
                              <strong>{{$cat['category']}}</strong>
                              <div class="table-responsive">
                                   <table id="bootstrap-table" class="table table-striped table-bordered table-sm "
                                        style="white-space:nowrap;background-color: #f3f2ee;">
                                        <thead>
                                             <tr>
                                                  <th>
                                                       <div class="th-inner ">Name</div>
                                                 
                                                  </th>
                                                  <th>
                                                       <div class="th-inner">
                                                            Price</div>
                                                  
                                                  </th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                    
                                             @foreach($cat['items'] as $k => $item)
                                             <tr>
                                                  <td class="col-6">{{$item['name']}}
                                                  </td>
                                                  <td class="col-6">{{$item['price']}}</td>
                                             </tr>
                                             @endforeach
                                        </tbody>
                                   </table>
                              </div>
                              @empty
                              <p>No Addons</p>
                              @endforelse


                              <form action="{{ route('menu.destroy', $menu->id) }}" method="POST"
                                   class="form-inline ">
                                  
                                       
                                        <a title="Edit" class="btn btn-info"
                                             href="{{ route('menu.edit', $menu->id)}}" >Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-fill btn-c1">Delete</button>
                                      
                                
                              </form>

                             
                         </div>
                    </div>
               </div>

          </div>
     </form>
</div>
@endsection

