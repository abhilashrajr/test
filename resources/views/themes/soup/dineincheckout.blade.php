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

                         <h1 class="mb-0">Dine In Checkout</h1>

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

                                   <h5 class="mb-0">You order</h5>

                              </div>

                              <table class="cart-table">

                                   

                                   @isset($cart['items'])

                                   @forelse($cart['items'] as $key => $item)

                                   <tr>

                                        <td>{{ $item['name'] }}</td>

                                        <td>{{ $item['quantity'] }}</td>

                                        <td>{{ $item['price'] }}</td>

                                        <td class="actions"><!--<a href="#product-modal" data-toggle="modal"

                                                  class="action-icon"><i class="ti ti-pencil"></i></a>--> <a href="#"

                                                  class="action-icon remove-item" data-id="{{$key}}"><i

                                                       class="ti ti-close"></i></a> </td>







                                      

                                   </tr>

                                   @if(!empty($item['addons']))



                                   @foreach($item['addons'] as  $addons)

                                   <tr>

                                        <td colspan="2" class="text-right" style="line-height: .25;">{{ $addons['name'] }}</td>

                                        

                                        <td class="p-0 text-center" style="line-height: .25;">{{ $addons['qty'] }}</td>

                                         <td  class="p-0 text-left" style="line-height: .25;"> {{$restaurant->currency}} {{ $addons['price'] }}</td>



                                   <!-- <td class="actions"><a href="#product-modal" data-toggle="modal"

                                                  class="action-icon"><i class="ti ti-pencil"></i></a> <a href="#"

                                                  class="action-icon remove-item" data-id="{{$addons['id']}}"><i

                                                       class="ti ti-close"></i></a> </td>-->







                                   

                                   </tr>

                                

                                   @endforeach

                                   @endif

                                  





                                   @empty

                                   @endforelse

                                   @endisset

                              </table>

                              <div class="cart-summary">

                                  

                                   <div class="row text-lg">

                                        <div class="col-7 text-right text-muted">Total:</div>

                                        <div class="col-5"><strong> {{$restaurant->currency}}<span 

                                                       class="cart-total"  id="order-total">{{ number_format($cart['total'],2)}}</span></strong>

                                        </div>

                                   </div>

                              </div>

                              <div class="cart-empty">

                                   <i class="ti ti-shopping-cart"></i>

                                   <p>Your cart is empty...</p>

                              </div>

                         </div>

                    </div>



                    <div class="col-xl-8 col-lg-7 order-lg-first">



                         <form action="{{route('dineinorder')}}" method="POST" id="checkout-form">

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

                                   

                                   <a  href="{{ route('dinein') }}" class="btn btn-primary  mb-5"><span>Back to

                                   menu</span></a>

                                   
                                  

                                  

                             



                                



                                   <h4 class="border-bottom pb-4"><i class="ti ti-user mr-3 text-primary"></i>Your

                                        informations</h4>

                                        <div id="postcodeerr" class=" alert-danger pl-2 mb-1"></div>

                                   <div class="row mb-5">

                                        <div class="form-group col-sm-6">

                                             <label>Name:</label>

                                             <input type="text" name="name" class="form-control"

                                                  value="{{ old('name')}}" required>

                                        </div>

                                        <div class="form-group col-sm-6">

                                             <label>Table Number:</label>

                                             <input type="text" name="tableno" class="form-control"

                                                  value="{{ old('tableno')}}" required>

                                        </div>


                                                  
                                        <div class="form-group col-sm-12 ">

                                        <label>Special Requirements:</label>

                                        <textarea name="other_info"

                                             class="form-control " > {{ old('other_info')}}</textarea>

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

                              

                                   <button type="submit" id="orderbtn" class="btn btn-primary btn-lg"><span>Order now!</span></button>

                             

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

