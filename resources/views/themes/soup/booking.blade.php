@extends('layouts.soup', [
'class' => '',
'title'=>"Book a table in ".$restaurant->name."  ".$restaurant->city.", Best restaurant and takeaway in ".$restaurant->city.", Order directly and save money, Just order online,  buy dine in voucher for special discount,  ".$restaurant->name."  ".$restaurant->city.",".$restaurant->address.",".$restaurant->city.",".$restaurant->state." ,".$restaurant->postcode." ,".$restaurant->name."  ".$restaurant->city,
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
    @if(empty($booktype))
    background-image: url("{{ asset('themes') }}/soup/img/bg1.jpg");
    @else
    background-image: url("{{ asset('themes') }}/soup/img/bg2.jpg");
    @endif
    background-size: cover;
    
}
</style>
@endpush


@section('content')
<div id="content">

        <!-- Section -->
        <section class="section section-lg bg-dark">

            <!-- Video BG -->

            <!-- BG Video
             <div class="bg-video dark-overlay" data-src="{{ asset('themes') }}/soup/video/video_3.mp4" data-type="video/mp4"></div>
             -->
            <div class="bg-video bg-img dark-overlay" "></div>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <!-- Book a Table -->
                        <div class="utility-box">
                            <div class="utility-box-title bg-dark dark">
                                <div class="bg-image"><img src="{{ asset('themes') }}/soup/img/modal-review.jpg" alt=""></div>
                                <div>
                                    <span class="icon icon-primary"><i class="ti ti-bookmark-alt"></i></span>
                                    <h4 class="mb-0">Book a table</h4>
                                    <p class="lead text-muted mb-0">Details about your reservation.</p>
                                </div>
                            </div>
                            <p class="mb-0 " style="line-height:1.1;padding:.5rem 2rem 0rem 2rem;"><small>*We use cookies in our website to improve your user experience. By Entering your details and proceeding, You agree to our T&C , Cookies and Privacy Policy listed at the bottom of the website.</small></p>
                            <form action="{{route('bookingconfirmation')}}" id="booking-form" method="POST"  class="booking-form2" >
                            @csrf
                                <div class="utility-box-content">
                                @if ($errors->any())

                                    <div class="alert alert-danger" id="errors">

                                        <ul style="padding-left: 15px;">

                                            @foreach ($errors->all() as $error)

                                            <li>{{ $error }}</li>

                                            @endforeach

                                        </ul>

                                    </div>

                                    @endif
                                     <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control"  value="{{ old('name')}}"  required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                            <label>Phone:</label>
                                                <input type="text" id="bookphone" name="phone" class="form-control"  value="{{ old('phone')}}"  required>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Email:</label>
                                                <input type="text" name="email"   value="{{ old('email')}}"  class="form-control" >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                            <label>Guests:</label>
                                             <input type="number" name="guests" min="1"  value="{{ old('guests')}}"   class="form-control" required>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                            <label>Date:</label>
                                                <input type="date" name="date" id="booking-date" min="{{date('Y-m-d')}}" class="form-control" autocomplete="off" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                            <label>Time:</label>
                                                 <select class="form-control" id="booking-time" name="time" required>
                                                    <option value="">Please select date</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                         @if(!empty($booktype))
                                         <input type="hidden"  name="booktype" value="2"> 
                                         @endisset
                                    
                                </div>
                                <button id="booking-submit" class="utility-box-btn btn btn-secondary btn-block btn-lg btn-submit" type="submit">
                                    <span class="description">Make reservation!</span>
                                   <!-- <span class="success">
                                        <svg x="0px" y="0px" viewBox="0 0 32 32"><path stroke-dasharray="19.79 19.79" stroke-dashoffset="19.79" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="square" stroke-miterlimit="10" d="M9,17l3.9,3.9c0.1,0.1,0.2,0.1,0.3,0L23,11"/></svg>
                                    </span>
                                    <span class="error">Try again...</span>-->
                                </button>
                            </form>
                        </div>
                        
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


