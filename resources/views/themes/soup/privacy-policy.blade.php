@extends('layouts.soup', [
'class' => '',
'title'=>"Privacy Policy",
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
br{
    margin-bottom:20px;
} 
</style>
@endpush


@section('content')

<div id="content" class="bg-light">

<!-- Post / Single -->
<article class="post single mb-5">
    <div class="post-image bg-parallax"><img src="http://assets.suelo.pl/soup/img/posts/post01_lg.jpg" alt=""></div>
    <div class="container container-md">
        <div class="post-content">
           
            <h1 class="post-title mb-3">Privacy Policy T & C</h1>
            <hr class="mb-0 mt-2">
           
            
           
            <div class="post-add-comment post-module ">
               
                <div class="content">
                
<p  class="lead" style="text-align: justify;">
Just Order Online (JOO) is a CMS product 
of Just Order Online Limited handed over to restaurants and takeaways in
 the UK. The system works on YII framework on server side and .Net 
framework on the Restaurant terminal side. Any content, image and 
functions on the website do not represent the viewpoints of Just Order 
Online Limited. All purchases and usage of this website are subjected to
 the terms and conditions of the individual restaurant (Business or 
Restaurant from now on), and at no point, the application provider Just 
Order Online Limited will be accountable for any kind of disputes in any
 forms. So please read our terms and conditions carefully.
 <br>
The business (Name, Logo and details are displayed in the website) 
reserve the right to change the terms and conditions from time to time. 
You are obliged to follow our terms and conditions by entering the 
website.
<br>
1. Any activity from viewing the pages to ordering food online is 
subject to our terms and conditions. The terms and conditions of the 
website are conveniently placed at the bottom of the website. You must 
leave the website if you do not comply with our terms and conditions.
<br>
2. If you face any difficulties in using the website, you may contact 
the business through the information on the Contact Us page.
<br>
3. Our system allows you to complete an order by clicking the checkout 
button. We consider ‘checkout button’ event as a purchase. If you do not
 get a feedback on the website from the restaurant or takeaway terminal 
with the delivery time, you should call the business immediately to 
ensure your order is processing.
<br>
4. ’Purchase’ through this website cannot be cancelled.
<br>
5. The management of the business reserve the full rights to take decisions if a refund is requested.
<br>
6. This website is copyright protected. Do not copy, print or steal any 
materials on this website. Just Order Online Limited reserve the full 
rights of intellectual property and software source code of this 
website.
<br>
7. The restaurant do not guarantee the availability of this website and 
its features as it depends on other vendors such as server providers, 
payment gateways and Internet Service Providers.
<br>
8. Every care has been taken in ensuring the security of this website. 
However, the service provider Just Order Online Limited or the 
respective Restaurant are not responsible for the data transfer between 
client and server.
<br>
9. Usage of this website is restricted to only Genuine Customers, 
looking for a convenient solution to order their food without the hustle
 of disclosing card details over the phone etc.
You should not use this website for test purposes by placing fake 
orders. We consider this as a breach of website usage policy.
<br>
10. Use of any automated applications, scripts, snippets or virus on 
this website is against the law and our terms and conditions.
<br>
11. However, provisions to communicate specific requests are provided, 
Please do not use this website if you have any food allergy. We can give
 you a better service if you order over the phone with such specific 
requests.
<br>
12. You should be 18 years or older to use this website. Any purchase of
 beverages through the website are subjected to age verification.The 
restaurant reserve the right to refuse service,
<br>
13. We will not hand over your details to any 3rd parties. We do not use cookies in this website.
<br>
14. Although we aim to deliver your food in 30 minutes to 45 minutes, 
this may vary due to weather conditions and complexity of dishes, as we 
prepare them freshly.
<br>

15.We use Paypal or Other reputed Card Payment Gateways to process card 
payments and we do not store or process any payments within this 
website. 
<br>
16.We do not save any of your Debit/Credit card details on this website.
 We use Restaurant's choice of reputed Payment gateways such as Paypal 
or other service providers to process Online card payments. While 
entering your card details, you are communicating directly with the 
Payment Gateway Provider on a secured connection (SSL).  For everyone’s 
safety SSL of higher encryption has been enabled on this website.</p>
                </div>
            </div>
        </div>
    </div>
</article>

     <!-- Footer -->
     @include('layouts.soup-footer')
     <!-- Footer / End -->

@endsection
