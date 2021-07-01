@extends('layouts.soup', [
'class' => '',
'title'=>"Pay now faster at ".$restaurant->name."  ".$restaurant->city.", Order without card machine, Just Order Online, Best  Restaurant and Takeaway in ".$restaurant->city.", Order Directly and save Money, ".$restaurant->name."  ".$restaurant->city.", ".$restaurant->address.",".$restaurant->city.",".$restaurant->state.",".$restaurant->postcode.",".$restaurant->name."  ".$restaurant->city,
'elementActive' => 'paynow',
'restaurant' =>$restaurant
])
@push('styles')
<style>
.table-borderless td,
.table-borderless th {
    padding: 0 ;
  margin: 0;
}
.post-image{
    height:30vh !important;
}
.paysummary td{
  font-weight:bold;
}
.btxt{
    color :#383c40;
}
</style>
@endpush


@section('content')

<div id="content" class="bg-light">

<!-- Post / Single -->
<article class="post single mb-5">
    <div class="post-image bg-parallax"><img src="{{ asset('themes') }}/soup/img/post01_lg.jpg" alt=""></div>
    <div class="container container-md">
        <div class="post-content">
           
            <h1 class="post-title mb-3">Pay Now</h1>
            <hr class="mb-0 mt-2">
           
            
           
            <div class="post-add-comment post-module ">
                <h4><i class="ti ti-pencil-alt mr-3 text-primary"></i>Details</h4>
                <div class="content">
                    <form action="{{route('paynowsave')}}" id="pay-now" class="" method="POST">
                    @csrf
                        <div class="row gutters-sm">
                            <div class="col-md-6 form-group">
                                <label>Name :</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Your Name" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Table Number :</label>
                                <input type="text" name="tableno" class="form-control" placeholder="Enter Table Number" required>
                            </div>
                        </div>
                       
                        <div class="row gutters-sm mb-4">
                            <div class="col-md-6 form-group">
                                <label>Drinks Bill Amount :</label>
                                <input type="text" name="drinks"  class="form-control" placeholder="Enter Drinks Bill Amount" autocomplete="off">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Food Bill Amount :</label>
                                <input type="text" name="food" class="form-control" placeholder="Enter Food Bill Amount" autocomplete="off">
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <textarea id="comment" cols="30" rows="4" class="form-control" placeholder="Comment" required></textarea>
                        </div>
                      -->
                        <table class="table paysummary table-bordered btxt  mb-4">
                             <tbody>
                                <tr>
                                    <td class="col-6 text-right ">Drinks Total :</td>
                                    <td class="col-6" id="drinks-total">0</td>
                                   
                                </tr>
                                <tr>
                                    <td class="col-6 text-right">Food Total :</td>
                                    <td class="col-6" id="food-total">0</td>
                           
                                </tr>
                                <tr>
                                    <td class="col-6 text-right">Amount To Pay :</td>
                                    <td class="col-6" id="amount">0</td>
                                 
                                </tr>
                                </tbody>
                        </table>
                        <div class="text-center">
                            <button class="btn btn-primary"><span>Pay</span></button>
                        </div>
                    </form>
                    <p class="mt-5"><small>*We use cookies in our website to improve your user experience. By Entering your details and proceeding, You agree to our T&C , Cookies and Privacy Policy listed at the bottom of the website.</small></p>
                </div>
            </div>
        </div>
    </div>
</article>

     <!-- Footer -->
     @include('layouts.soup-footer')
     <!-- Footer / End -->

@endsection
@push('scripts')
<script>
 
$(document).ready(function() {
    var drinksDiscount = {{$drinks_discount}};
    var foodDiscount = {{$food_discount}};
    var drinksTotal , foodTotal , amountToPay = 0;
   
    function calcAmount(){
        drinksTotal = $("input[name='drinks']").val();
        if(drinksDiscount>0 && drinksTotal>0){
            drinksTotal = (drinksTotal-(drinksTotal*drinksDiscount/100)).toFixed(2);
            $("#drinks-total").html("{{$restaurant->currency}}"+parseFloat(drinksTotal)+" <span style='font-weight:normal'>("+ drinksDiscount+"% Discount)</span>" );
        }else{
            if(drinksTotal=="")
                drinksTotal=0;
            $("#drinks-total").html("{{$restaurant->currency}}"+parseFloat(drinksTotal));
        }
        foodTotal =  $("input[name='food']").val();
        if(foodDiscount>0 && foodTotal>0){
            foodTotal =  ( foodTotal- (foodTotal*foodDiscount/100)).toFixed(2);
            $("#food-total").html("{{$restaurant->currency}}"+parseFloat(foodTotal)+" <span style='font-weight:normal'>("+ foodDiscount+"% Discount)</span>" );
        }else{
             if(foodTotal=="")
                foodTotal=0;
            $("#food-total").html("{{$restaurant->currency}}"+parseFloat(foodTotal));
        }
        amountToPay =  (parseFloat(drinksTotal )+ parseFloat(foodTotal)).toFixed(2);
        $("#amount").html("{{$restaurant->currency}}" + parseFloat(amountToPay));
    }
    $("input[name='drinks'] , input[name='food']").keyup(function(){
        calcAmount();
    });

   
    $("input[name='drinks'] , input[name='food']").keypress(function(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
    });
    
});
</script>
@endpush