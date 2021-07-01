@extends('layouts.soup', [

'class' => '',

'elementActive' => ''

])



@section('content')

<div id="content">



     <!-- Page Title -->

     <div class="page-title bg-dark dark">

          <!-- BG Image -->

          <div class="bg-image bg-parallax"><img src="{{ asset('themes') }}/soup/img/bg-croissant.jpg" alt="">

          </div>

          <div class="container">

               <div class="row">

                    <div class="col-lg-8 offset-lg-4">

                         <h1 class="mb-0">Checkout</h1>

                         <h4 class="text-muted mb-0"></h4>

                    </div>

               </div>

          </div>

     </div>



     <!-- Section -->

     <section class="section bg-light">



          <div class="container">

               <div class="row">

                    <div class="col-xl-4 col-lg-5">

                         <div class="cart-details shadow bg-white stick-to-content mb-4">

                              <div class="bg-dark dark p-4">

                                   <h5 class="mb-0">You Vouher</h5>

                              </div>
                               <div>
                                   <img class="img-responsive p-3" src="{{ url('storage/images/'.$voucher->image)}}" alt="Chania"> 
                               </div >
                               <div class="pl-3 pr-3">
                                <table class="table mb-0" style="border-bottom: 1px solid #dee2e6;border-top: none">
                                   <tr>
                                        <td>{{ $voucher->name }}</td>
                                   </tr>
                                   <tr>
                                        <td>{{ $voucher->description }}</td>
                                   </tr>
                                   <!--<tr>
                                        <td>{{ $voucher->price }}</td>
                                   </tr>-->
                                   
                                </table>   
                                </div>
                                <div class="cart-summary">



                                   <div class="row text-lg">

                                        <div class="col-6 text-right text-muted pr-0">Total :</div>

                                        <div class="col-6 pl-0"><strong>&nbsp; {{$restaurant->currency}}<span class=""
                                                      >{{ number_format($voucher->price,2)}}</span></strong>

                                        </div>

                                   </div>

                              </div>
                            

                         </div>

                    </div>



                    <div class="col-xl-8 col-lg-7 order-lg-first">



                         <form action="{{route('voucherorder',$voucher->id)}}" method="POST" id="checkout-form">

                              @csrf

                              <div class="bg-white p-4 p-md-5 mb-4">

                                   @if ($errors->any())

                                   <div class="alert alert-danger" id="errors">

                                        <ul style="padding-left: 15px;">

                                             @foreach ($errors->all() as $error)

                                             <li>{{ $error }}</li>

                                             @endforeach

                                        </ul>

                                   </div>

                                   @endif



                                   <a href="{{ route('vouchers') }}" class="btn btn-primary  mb-5"><span>Back to

                                             Vouchers</span></a>














                                   <h4 class="border-bottom pb-4"><i class="ti ti-user mr-3 text-primary"></i>Your

                                        informations</h4>

                                   <div id="postcodeerr" class=" alert-danger pl-2 mb-1"></div>

                                   <div class="row mb-5">

                                        <div class="form-group col-sm-6">

                                             <label>Name :</label>

                                             <input type="text" name="name" class="form-control"
                                                  value="{{ old('name')}}" required>

                                        </div>

                                        <div class="form-group col-sm-6">

                                             <label>Phone Number :</label>

                                             <input type="text" name="phone" class="form-control"
                                                  value="{{ old('phone')}}" required>

                                        </div>



                                        <div class="form-group col-sm-12 ">

                                             <label>Email :</label>
                                             <input type="text" name="email" class="form-control"
                                                  value="{{ old('email')}}" required>
                                         

                                        </div>

                                   </div>





                                   <h4 class="border-bottom pb-4"><i class="ti ti-wallet mr-3 text-primary"></i>Payment

                                   </h4>

                                   <div class="row text-lg">



                                        <div class="col-md-4 col-sm-6 form-group">

                                             <label class="custom-control custom-radio">

                                                  <input type="radio" name="payment_type" value="1"
                                                       class="custom-control-input"
                                                       {{ old('payment_type') ==1 ? 'checked' : ''}} required>

                                                  <span class="custom-control-indicator"></span>

                                                  <span class="custom-control-description">Card</span>

                                             </label>

                                        </div>





                                   </div>

                              </div>

                              <div class="text-center">



                                   <button type="submit" id="orderbtn" class="btn btn-primary btn-lg"><span>Pay
                                             Now!</span></button>



                              </div>

                         </form>

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