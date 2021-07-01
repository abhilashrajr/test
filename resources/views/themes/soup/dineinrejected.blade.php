@extends('layouts.soup', [
'class' => '',
'elementActive' => ''
])

@push('styles')
<style>
.loading {
	 display: flex;
     justify-content: center;
     margin-bottom:60px;
}
 .loading .dot {
	 position: relative;
	 width: 2em;
	 height: 2em;
	 margin: 0.8em;
	 border-radius: 50%;
}
 .loading .dot::before {
	 position: absolute;
	 content: "";
	 width: 100%;
	 height: 100%;
	 background: inherit;
	 border-radius: inherit;
	 animation: wave 2s ease-out infinite;
}
 .loading .dot:nth-child(1) {
	 background: #7ef9ff;
}
 .loading .dot:nth-child(1)::before {
	 animation-delay: 0.2s;
}
 .loading .dot:nth-child(2) {
	 background: #89cff0;
}
 .loading .dot:nth-child(2)::before {
	 animation-delay: 0.4s;
}
 .loading .dot:nth-child(3) {
	 background: #4682b4;
}
 .loading .dot:nth-child(3)::before {
	 animation-delay: 0.6s;
}
 .loading .dot:nth-child(4) {
	 background: #0f52ba;
}
 .loading .dot:nth-child(4)::before {
	 animation-delay: 0.8s;
}
 .loading .dot:nth-child(5) {
	 background: #000080;
}
 .loading .dot:nth-child(5)::before {
	 animation-delay: 1s;
}
 @keyframes wave {
	 50%, 75% {
		 transform: scale(2.5);
	}
	 80%, 100% {
		 opacity: 0;
	}
}
 
.card {
    z-index: 0;
    background-color: #ECEFF1;
    padding-bottom: 20px;
   /*
    margin-top: 90px;
    margin-bottom: 90px;
    */
    border-radius: 10px
}

.top {
    padding-top: 40px;
    padding-left: 13% !important;
    padding-right: 13% !important
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
                        <h1 class="mb-0">Rejected</h1>
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
                     <span class="icon icon-xl icon-danger" style="height:auto;"><i class="ti ti-alert"></i></span>
                        <h1 class="mb-2">Restaurant rejected your order!</h1>
                        <h4 class="text-muted mb-5">Dear Customer , Sorry. Your Order has been Rejected by the restaurant.Usually this happens when they are extremely busy. If its a card payment , we will issue the refund immediately.You may close this window. Thank You</h4>
                        <a href="{{route('dinein')}}" class="btn btn-outline-secondary"><span>Go back to menu</span></a>

            </div>
        </div>
        <div class="row">
             <div class="col-xl-10 offset-xl-1">
              
                            <div class="container px-1 px-md-4 py-5 pt-0 mx-auto">
                    <div class="card">
                        <div class="row d-flex justify-content-between px-3 top">
                            <div class="d-flex">
                                <h5>ORDER <span class="text-primary font-weight-bold"># {{$order_id ?? ''}}</span></h5>
                            </div>
                            <div class="d-flex flex-column text-sm-right">
                               
                            </div>
                        </div> <!-- Add class 'active' to progress -->
                      
                    </div>
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
 

    


    

</script>
@endpush
