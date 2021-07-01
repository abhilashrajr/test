@extends('layouts.app', [
'title' => 'Booking Details',
'class' => '',
'elementActive' => 'bookings'
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
                              <h4 class="card-title">Booking Details</h4>
                         </div>
                         <div class="card-body">


                              <div class="table-responsive">
                                   <table id="bootstrap-table" class="table  table-bordered table-striped table-sm "
                                        style="white-space:nowrap;background-color: #f3f2ee;">

                                        <tbody>


                                             <tr>
                                                  <td class="font-weight-bold">Booking Date</td>
                                                  <td>{{date('d M  Y', strtotime($data->date))}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Time</td>
                                                  <td>{{date('h:i A ', strtotime($data->time))}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Name</td>
                                                  <td>{{$data->name}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Phone</td>
                                                  <td>{{$data->phone}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Email</td>
                                                  <td>{{$data->email}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Guests</td>
                                                  <td>{{$data->guests}}</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Booking Type</td>
                                                  <td> @switch($data->type)
                                                       @case(1)
                                                       
                                                       @break

                                                       @case(2)
                                                       Special
                                                       @break
                                              
                                                       @default
                                                       
                                                       @endswitch</td>
                                             </tr>
                                             <tr>
                                                  <td class="font-weight-bold">Booked Date & time</td>
                                                  <td>{{date('d M  Y, h:i A', strtotime($data->created_at))}}</td>
                                             </tr>
                                             
                                             <tr>
                                                  <td class="font-weight-bold">Status</td>
                                                  <td>
                                                       @switch($data->status)
                                                       @case(1)
                                                       Pending
                                                       @break

                                                       @case(2)
                                                       Accepted
                                                       @break
                                                       @case(3)
                                                       Rejected
                                                       @break
                                                       @default
                                                       Error
                                                       @endswitch

                                                  </td>
                                             </tr>


                                            
                                        </tbody>
                                   </table>
                                   @switch($data->status)
                                   @case(1)
                                   <a title="Edit" class="btn btn-warning"
                                        href="{{ route('bookingstatus',[ 'id'=>$data->id,'status'=>2])}}">Accept</a>
                                   <a title="Edit" class="btn  btn-default"
                                        href="{{ route('bookingstatus',[ 'id'=>$data->id,'status'=>3])}}">Reject</a>
                                   @break

                                   @case(2)
                              
                                   <a title="Edit" class="btn  btn-default"
                                        href="{{ route('bookingstatus',[ 'id'=>$data->id,'status'=>3])}}">Reject</a>
                                   @break
                                  
                                  
                                   @default
                                   <a title="Edit" class="btn btn-warning"
                                        href="{{ route('bookingstatus',[ 'id'=>$data->id,'status'=>2])}}">Accept</a>
                              @endswitch
                              </div>

                         </div>
                         
                    </div>
                   

               </div>
              
          </div>
     </form>
</div>
@endsection