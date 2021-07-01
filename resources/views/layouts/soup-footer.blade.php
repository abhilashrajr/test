@php
$opening_hours = App\Models\Hours::all();
 @endphp 
<footer id="footer" class="bg-dark dark">

<div class="container">
    <!-- Footer 1st Row -->
    <div class="footer-first-row row">
        <div class="col-lg-3 text-center">
            <a href="{{route('home')}}"><img src="{{ url('storage/images/'.$restaurant->logo)}}" alt="" width="88" class="mt-5 mb-5"></a>
        </div>
        <div class="col-lg-4 col-md-6">
            <h5 class="text-muted">LINKS</h5>
            <ul class="list-posts">
               <li>
                    <a href="{{route('home')}}" class="title">Home</a>
                    
                </li>
                <li>
                    <a href="{{route('home')}}l" class="title">Menu</a>
                   
                </li>
                @if($restaurant->booking)
                <li>
                    <a href="{{route('booking')}}" class="title">Booking</a>
                   
                </li>
                @endif
                <li>
                    <a href="{{route('privacy-policy')}}" class="title">Privacy Policy</a>
                   
                </li>
                <li>
                    <a  href="#feedback" data-toggle="modal" data-target="#feedback" class="title">Feedback</a>              
                </li>
            </ul>
        </div>
        <div class="col-lg-5 col-md-6">
            <h5 class="text-muted mb-2">OPENING HOURS</h5>
            <table class="table table-borderless  table-sm text-white p-0 footer-table" >
                
                <tbody>

                @php
                    $weekdays =['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                @endphp 
                    @for($i = 0 ;$i < 7;$i++) 
                        @if($opening_hours[$i]->active)
                        <tr>
                            <td>{{$weekdays[$i]}}</td>
                            <td>{{  date('h:i A ', strtotime($opening_hours[$i]->start1)) }}</td>
                            <td class="pr-2">-</td>
                            <td>{{  date('h:i A ', strtotime($opening_hours[$i]->end1)) }}</td>
                            <td>{{  date('h:i A ', strtotime($opening_hours[$i]->start2)) }}</td>
                            <td class="pr-2">- </td>
                            <td>{{  date('h:i A ', strtotime($opening_hours[$i]->end2)) }}</td>
                        </tr>
                        @endif
                    @endfor
               
                </tbody>
            </table>           
                            
                            
             </div>
    </div>
    <!-- Footer 2nd Row -->
    <div class="footer-second-row">
        <span class="text-muted">© {{ now()->year }}<a href="https://justorderonline.co.uk/"> Just Order Online Ltd </a> . All Rights Reserved.</span>
   </div>
</div>

<!-- Back To Top -->
<button id="back-to-top" class="back-to-top"><i class="ti ti-angle-up"></i></button>

</footer>