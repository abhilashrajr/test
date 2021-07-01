@extends('layouts.soup', [
'class' => '',
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
                        <h1 class="mb-0 text-white">Confirmation</h1>
                        <h4 class="text-muted mb-0">&nbsp;</h4>
                    </div>
                </div>
            </div>
        </div>
<!-- Section -->
<section class="section ">
    <div class="container">
    <div class="row">
            <div class="col-xl-10 offset-xl-1 ">
                <div class="loading">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
                <!--<span class="icon icon-xl icon-success"><i class="ti ti-check-box"></i></span>-->
                <h3 class="mb-2 text-center">Waiting for order confirmation from restaurant</h31>
               <!-- <h4 class="text-muted mb-5">Your order Placed at </h4>
                <a href="{{route('home')}}" class="btn btn-outline-secondary"><span>Cancel Order</span></a>-->
            </div>
        </div>

        <div class="row">
            <div class="col-12">
            <ul id="progressbar" class="text-center w-100 mt-1">
                <li class="active step0">Your Payment is processed. <br>Please do not try to place the order again</li>
                <li class="active step0">Your order is Placed </li>

                
                                    <li id="dtm" class="step0 ">Your Order is accepted for <h3 id="tmd"></h3></li>
                <li id="cmp" class="step0 ">Thank you for supporting<br> our small business</li>
             </ul>  
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
 

    
function checkstatus(){
        $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });  
        $.ajax({
            type: 'GET',
            url: "confirmstatus",
            data: { id:  {{$order['id']?? NULl}}  },
            dataType: 'json',
            success: function(data) {
                   if(data.message == "accepted")
                        window.location.href = "{{route('dineinconfirmed')}}";
                   if(data.message == "rejected")
                        window.location.href = "{{route('dineinrejected')}}";
            }
        });  
}

$(document).ready(function(){
    setInterval(checkstatus,7000);
});


    

</script>
@endpush
