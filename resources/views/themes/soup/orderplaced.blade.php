@extends('layouts.soup', [
'class' => '',
'title' => 'Order Placed',
'elementActive' => ''
])

@push('styles')

<link rel="stylesheet" href="{{ asset('themes') }}/soup/css/confirmation.css" />
<style>
.page-title {
     background-image: url("{{ asset('themes') }}/soup/img/bg-croissant.jpg");
     background-size: cover;
     
}

</style>
@endpush
@section('content')
<div id="content">
<!-- Page Title -->
<div class="page-title bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-4">
                        <h1 class="mb-0 text-white">Order Placed</h1>
                        <h4 class="text-muted mb-0">&nbsp;</h4>
                    </div>
                </div>
            </div>
        </div>
<!-- Section -->
<section class="section ">
    <div class="container">
    <div class="row">
            <div class="col-xl-10 offset-xl-1 text-center">
                     <span class="icon icon-xl icon-success" style="height:auto;"><i class="ti ti-check-box"></i></span>
                        <h1 class="mb-2">Thank you for your order!</h1>
                       <!-- <h4 class="text-muted mb-5">Expected Delivery Time : </h4>
                        <a href="{{route('home')}}" class="btn btn-outline-secondary"><span>Go back to menu</span></a>
-->
            </div>
        </div>
     


        <div class="row mb-5 mt-4">
             <div class="col-xl-6 offset-xl-3">
              
      
                    <table class="table table-bordered">
                         <tbody>
                          <tr>
                            <td class="col-6 text-right font-weight-bold">Order No</td>
                            <td class="col-6  text-left font-weight-bold"><span class="text-primary font-weight-bold">#{{$order->id}}</span></td>
                          </tr>
                          <tr>
                            <td class="col-6  text-right font-weight-bold">Order Mode</td>
                            <td class="col-6 text-left font-weight-bold">{{$order->order_type}}</td>
                          </tr>
                          <tr>
                            <td class="col-6  text-right font-weight-bold">Payment Mode</td>
                            <td class="col-6  text-left font-weight-bold">{{$order->payment_method==1 ? 'Card' :''}} {{$order->payment_method==2 ? 'Cash On Delvery' :''}}</td>
                          </tr>
                          <tr>
                            <td class="col-6  text-right font-weight-bold">Order Amount</td>
                            <td class="col-6 text-left font-weight-bold">{{$restaurant->currency}} {{$order->amount}}</td>
                          </tr>
                        </tbody>
                      </table>
               
             </div>  
        </div>       
       
    </div>
</section>

<!-- Footer -->
@include('layouts.soup-footer')
<!-- Footer / End -->

</div>

@endsection
@push('scripts')
<script>

</script>
@endpush