@extends('layouts.soup', [
'class' => '',
'elementActive' => ''
])
@push('styles')


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
                <h1 class="mb-0 text-white">Booking</h1>
                <h4 class="text-muted mb-0">&nbsp;</h4>
            </div>
        </div>
    </div>
</div>
<!-- Section -->
<section class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-4">
                <span class="icon icon-xl icon-success"><i class="ti ti-check-box"></i></span>
                <h1 class="mb-2">Thank you for your Booking!</h1>
                <!--<h4 class="text-muted mb-5">You will receive  confirmation in 30 minutes.</h4>
                <a href="{{route('home')}}" class="btn btn-outline-secondary"><span>Go back to menu</span></a>-->
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
@include('layouts.soup-footer')
<!-- Footer / End -->

</div>

@endsection

