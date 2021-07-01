@extends('layouts.soup', [
'class' => '',
'title'=>"Buy a voucher from ".$restaurant->name."  ".$restaurant->city.", Best  restaurant and takeaway in ".$restaurant->city.", Order directly and save money, Just order online, ".$restaurant->city." order your voucher and save money, buy dine in voucher for special discount, ".$restaurant->name."  ".$restaurant->city.", ".$restaurant->address.", ".$restaurant->address.", ".$restaurant->postcode." ".$restaurant->city." ".$restaurant->name,
'elementActive' => 'booking',
'restaurant' =>$restaurant
])
@push('styles')
<style>
.table-borderless td,
.table-borderless th {
    padding: 0 ;
  margin: 0;
}
.bg-img{
    background-image: url("{{ asset('themes') }}/soup/img/bg1.jpg");
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
                        <h1 class="mb-0">Vouchers</h1>
                        <h4 class="text-muted mb-0"></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content bg-light pb-5">
            <div class="container ">
                      

             @forelse($vouchers as $voucher)
                <!-- Special Offer -->
                <div class="special-offer mb-5 " >
                    <img src="{{ url('storage/images/'.$voucher->image)}}" alt="" class="special-offer-image">
                    <div class="special-offer-content card mb-0">
                        <h2 class="mb-2">{{$voucher->name}}</h2>
                        <h5 class="text-muted card-body pl-0">{{$voucher->description}}</h5>
                        <div class="card-footer bg-transparent border-0 row  align-items-center p-0">
                            <div class="col-6 "> <h3 class="mb-0">£{{$voucher->price}}</h3></div>
                            <div class="col-6 text-sm-right "><a href="{{  route('vouchercheckout', ['id' => $voucher->id])}}" class="btn btn-primary"><span>Buy Now</span></a></div>
                        </div>
                    </div>
                </div>

            @empty
                <p>No Vouchers</p>
            @endforelse
    
        <!-- Section - Steps -->
        <section class="section section-extended right dark mb-5">
            <div class="container bg-dark" style="padding:3rem 6rem">
                <div class="row">
                    <div class="col-md-4">
                        <!-- Step -->
                        <div class="feature feature-1 mb-md-0">
                            <div class="feature-icon icon icon-primary"><i class="ti ti-home"></i></div>
                            <div class="feature-content">
                                <h4 class="mb-2"><a href="menu-list-collapse.html">Address</a></h4>
                                <p class="text-muted mb-0">{{$restaurant->address}}<br>{{$restaurant->city}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Step -->
                        <div class="feature feature-1 mb-md-0">
                            <div class="feature-icon icon icon-primary"><i class="ti ti-mobile"></i></div>
                            <div class="feature-content">
                                <h4 class="mb-2">Phone</h4>
                                <p class="text-muted mb-0">{{$restaurant->contact_no}} <br>{{$restaurant->contact_no2}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Step -->
                        <div class="feature feature-1 mb-md-0">
                            <div class="feature-icon icon icon-primary"><i class="ti ti-email"></i></div>
                            <div class="feature-content">
                                <h4 class="mb-2">Email</h4>
                                <p class="text-muted mb-3">{{$restaurant->email}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
 

            <div class="post-content bg-white" style="padding:5rem;">
                    <div class="post-add-comment post-module ">
                        <h3><i class="ti ti-file mr-4 text-primary"></i>How it works</h3>
                        <hr class="mb-5 mt-2">
                        <div class="content mb-5">
                            <ul class="list-check text-lg mb-0">
                                <li>Purcase the Voucher</li>
                                <li>Receive Text message and Email with Unique Purchase Code</li>
                                <li>Visit restaurant and Produce the Unique Purchase code(Gift Vouchers are accepted)</li>
                            </ul>
                            
                        </div>

                        <h3><i class="ti ti-file mr-4 text-primary"></i>Terms and Conditions</h3>
                        <hr class="mb-5 mt-2">
                        <div class="content">
                            <ul class="list-check text-lg mb-0">
                                <li class="false">Cannot be used in conjunction with other offers.</li>
                                <li class="false">Subject to availability.</li>
                                <li>Voucher must be used within 60 days after purchase.</li>
                                <li class="false">Vouchers not used within this time will be forfeited with no entitlement to refund or exchange.</li>
                                <li>Booking is not mandatory. However Booking may be required to avoid waiting times during busy hours.</li>
                                <li class="false">Vouchers are non refundable</li>
                                <li class="false">Vouchers are non-transferable and cannot be exchanged for cash.</li>
                                <li class="false">Purchase of a voucher is not a guarantee of a reservation.</li>
                                <li>All vouchers are to be redeemed in the issuing restaurant only.</li>
                                <li class="false">Vouchers can only be used for a single sitting and any remaining amount is not exchangeable for cash or another voucher and will be automatically forfeited</li>
                               
                                <li>The buyer must protect the Unique Voucher code.</li>
                                <li>You must be 18 years or older to purchase vouchers from this website.</li>
                                
                            </ul>
                            <p class="mt-5"><small>*We use cookies in our website to improve your user experience. By Entering your details and proceeding, You agree to our T&C , Cookies and Privacy Policy listed at the bottom of the website.</small></p>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <!-- Footer -->
        @include('layouts.soup-footer')
        <!-- Footer / End -->

    </div>

@endsection
@push('scripts')
<script>
 
$(document).ready(function() {
    var bdate;
    $('#booking-date').change(function() {
           bdate = $(this).val();

           if(bdate!=""){
               $.ajaxSetup({
                    headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
               });  
               $.ajax({
                    type: 'GET',
                    url: "\gettimeslot",
                    data: { date:  bdate  },
                    dataType: 'html',
                    success: function(data) {
                         $('#booking-time').html(data);
                    },
                    error: function () {
                         alert("Something went wrong, Please try later");
                    }
               });  
          }

    });

    function validatePhone(){
        var x = $('#bookphone').val();

        if (x.charAt(0) != "0") {
            alert("Phone number should start with 0");
            return false
        } else if (x.charAt(1) != "7") {
            alert("2nd digit of phone number should be 7");
            return false
        } else if (!/^[0-9]{11}$/.test(x)) {
            alert("Please input exactly 11 numbers!");
            return false
        }
        return true;
    }

    
    $("#booking-submit").on("click", function(e){
        e.preventDefault();
        if(validatePhone())
            $("#booking-form").submit();
    })
    
});

</script>
@endpush


