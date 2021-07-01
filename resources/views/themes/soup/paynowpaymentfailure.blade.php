@extends('layouts.soup', [
'class' => '',
'elementActive' => '',
'title'=>'Payment Failed'
])

@section('content')
<div id="content">

<!-- Section -->
<section class="section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-4">
                <span class="icon icon-xl icon-warning"><i class="ti ti-alert"></i></span>
                <h1 class="mb-2">Payment Failed!</h1>
                <h4 class="text-muted mb-5">Your payment was unsuccessful</h4>
               <a href="{{route('paynow')}}" class="btn btn-outline-secondary"><span>Go back to home</span></a>
            </div>
        </div>
    </div>
</section>

 <!-- Footer -->
 @include('layouts.soup-footer')
     <!-- Footer / End -->

</div>

@endsection

