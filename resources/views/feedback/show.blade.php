@extends('layouts.app', [
'title' => 'User feedbacks',
'class' => '',
'elementActive' => 'feedback'
])

@push('styles')
<style>
body{
background:#ddd;
}

/*-------------------
-----News Styles-----
---------------------*/    
.timeline{
    position:relative;
    margin-bottom:100px;
    z-index:1;
}

.timeline:before{
    display:block;
    content:"";
    position:absolute;
    width:50%;
    height:100%;
    left:1px;
    top:0;
    border-right:1px solid #5CC9DF;
    z-index:-1;
} 

.timeline:after{
    display:block;
    content:"";
    position:absolute;
    width:50%;
    height:100px;
    left:1px;
    bottom:-105px;
    border-right:1px dashed #5CC9DF;
    z-index:-1;
} 

.timeline .date-title{
    text-align:center;
    margin:70px 0 50px;
}

.timeline .date-title span{
    padding:15px 30px;
    font-size:21px;
    font-weight:400;
    color:#fff;
    background:#5CC9DF;
    border-radius:5px;
}

.news-item {
    padding-bottom:45px;
}

.news-item.right {
    float:right;
    margin-top:40px;
}

.news-item .news-content {
    margin:20px 30px 0 0;
    position:relative;
    padding:30px;
    padding-left:100px;
    background:#f5f5f5;
    border-radius:10px;
    box-shadow:-5px 5px 0 rgba(0,0,0,0.08);
    -webkit-transition:all .3s ease-out;
    transition:all .3s ease-out;
}

.news-item:hover .news-content {
    background:#5CC9DF;
    color:#fff;
}

.news-item.right .news-content {
    margin:20px 0 0 30px;
    box-shadow:5px 5px 0 rgba(0,0,0,0.08);
}

.news-item .news-content:after {
    display:block;
    content:"";
    position:absolute;
    top:50px;
    right:-40px;
    width:0px;
    height:0px;
    background:transparent;
    border:20px solid transparent;
    border-left:20px solid #f5f5f5;
    -webkit-transition:border-left-color .3s ease-out;
    transition:border-left-color .3s ease-out;
}

.news-item.right .news-content:after {
    position:absolute;
    left:-40px;
    right:auto;
    border-left:20px solid transparent;
    border-right:20px solid #f5f5f5;
    -webkit-transition:border-right-color .3s ease-out;
    transition:border-right-color .3s ease-out;
}

.news-item:hover .news-content:after {
    border-left-color:#5CC9DF;
}

.news-item.right:hover .news-content:after {
    border-left-color:transparent;
    border-right-color:#5CC9DF;
}

.news-item .news-content:before {
    display:block;
    content:"";
    position:absolute;
    width:20px;
    height:20px;
    right:-55px;
    top:60px;
    background:#5CC9DF;
    border:3px solid #fff;
    border-radius:50%;
    -webkit-transition:background .3s ease-out;
    transition:background .3s ease-out;
}

.news-item.right .news-content:before {
    left:-55px;
    right:auto;
}

.news-content .date {
    position:absolute;
    width:80px;
    height:80px;
    left:10px;
    text-align:center;
    color:#5CC9DF;
    -webkit-transition:color .3s ease-out;
    transition:color .3s ease-out;
}

.news-item:hover .news-content .date {
    color:#fff;
}

.news-content .date p{
    margin:0;
    font-size:48px;
    font-weight:600;
    line-height:48px;
}

.news-content .date small{
    margin:0;
    font-size:26px;
    font-weight:300;
    line-height:24px;
}

.news-content .news-title{
    font-size:24px;
    font-weight:300;
}

.news-content p{
    font-size:16px;
    line-height:24px;
    font-weight:300;
    letter-spacing:0.02em;
    margin-bottom:10px;
}

.news-content .read-more,
.news-content .read-more:hover,
.news-content .read-more:active,
.news-content .read-more:focus{
    padding:10px 0;
    text-decoration:none;
    font-size:16px;
    color:#7A7C7F;
    line-height:24px;
}

.news-item:hover .news-content .read-more,
.news-item:hover .news-content .read-more:hover,
.news-item:hover .news-content .read-more:active,
.news-item:hover .news-content .read-more:focus{
    color:#fff;
}

.news-content .read-more{
    -webkit-transition:padding .3s ease-out;
    transition:padding .3s ease-out;
}

.news-content .read-more:hover {
    padding-left:7px;
}

.news-content .read-more:after{
    content:'\f054';
    padding-left:15px;
    font-family:'FontAwesome';
    font-size:21px;
    line-height:21px;
    color:#5CC9DF;
    vertical-align:middle;
    -webkit-transition:padding .3s ease-out;
    transition:padding .3s ease-out;
}

.news-content .read-more:hover:after{
    padding-left:20px;
}

.news-item:hover .news-content .read-more:after{
    color:#fff;
}

.news-content .news-media{
    position:absolute;
    width:80px;
    bottom:-45px;
    right:40px;
    border-radius:8px;
}

.news-content .news-media img{
    border-radius:8px;
    transform:scale(1);
    -webkit-transition:-webkit-transform .3s ease-out;
    transition:transform .3s ease-out;
}

.news-content .news-media a{
    display:block;
	text-decoration:none;
    background:#fff;
    border-radius:8px;
    overflow:hidden;
    -webkit-mask-image: -webkit-radial-gradient(circle, white, black);
}

.news-content .news-media a:hover img{
    -webkit-transform:scale(1.3);
    transform:scale(1.3);
}

.news-content .news-media a:after{
    content:'\f065';
    position:absolute;
    width:100%;
    top:0;
    left:0;
    font-family:FontAwesome;
    font-size:32px;
    line-height:80px;
    text-align:center;
    color:#5CC9DF;
    -webkit-transform:scale(0);
    transform:scale(0);
    opacity:0;
    -webkit-transition:all .2s ease-out .1s;
    transition:all .2s ease-out .1s;
}

.news-content .news-media.video a:after{
    content:'\f04b';
}

.news-content .news-media a:hover:after{
    -webkit-transform:scale(1);
    transform:scale(1);
    opacity:1;
}

.news-content .news-media.gallery{
    box-shadow:4px 4px 0 #bbb,8px 8px 0 #ddd;
}
                                        
 </style>
@endpush

@section('content')

<div class="content">
     <div class="row">
          <div class="col-md-12">
               <div class="card ">
                    <div class="card-header">
                         <h4 class="card-title" style="padding-left:20px;">Feedback</h4>
                    </div>
                    <div class="card-body pl-5 pr-5 pt-0">
                         <div class="timeline">

                           
                      @php
                          $pmonth = "";
                      @endphp  
                      @for($i=0;$i<=(count($feedbacks));$i++)                              
                         @if(array_key_exists($i,$feedbacks))
                              @if($pmonth != date('m',strtotime($feedbacks[$i]['created_at'])))
                                    <div class="date-title">
                                        <span>{{date('F',strtotime($feedbacks[$i]['created_at']))}} {{date('Y',strtotime($feedbacks[$i]['created_at']))}}</span>
                                    </div>
                              @endif

                             
                                <div class="row">
                             
                             
                                        <div class="col-sm-6 news-item ">
                                            <div class="news-content">
                                                <div class="date">
                                                    <p>{{date('d',strtotime($feedbacks[$i]['created_at']))}}</p>
                                                    <small>{{date('D',strtotime($feedbacks[$i]['created_at']))}}</small>
                                                </div>
                                                <h2 class="news-title">{{ $feedbacks[$i]['email']}}</h2>
                                                
                                                <p>{{ $feedbacks[$i]['message']}}</p>
                                                
                                            </div>
                                        </div>
                                @php
                                  $pmonth  = date('m',strtotime($feedbacks[$i]['created_at'])); 
                                  $i++; 
                                  $flag = 1; 
                                  if(array_key_exists($i,$feedbacks)){
                                        if($pmonth != date('m',strtotime($feedbacks[$i]['created_at']))){
                                             $i--;
                                             $flag = 0; 
                                        } 
                                               
                                  }     

                                @endphp
                              
                                @if($flag)
                                         <div class="col-sm-6 news-item  right ">
                                            <div class="news-content">
                                                <div class="date">
                                                    <p>{{date('d',strtotime($feedbacks[$i]['created_at']))}}</p>
                                                    <small>{{date('D',strtotime($feedbacks[$i]['created_at']))}}</small>
                                                </div>
                                                <h2 class="news-title">{{ $feedbacks[$i]['email']}}</h2>
                                                
                                                <p>{{ $feedbacks[$i]['message']}}</p>
                                                
                                            </div>
                                        </div>
                                 @endif        
                                </div>
                               
                            @php
                                $pmonth  = date('m',strtotime($feedbacks[$i]['created_at']));
                            @endphp
                                
                            @else
                            break;    
                            @endif
                            @endfor

                         
                          </div>
                    </div>
               </div>
     
          </div>
     </div>
</div>



@endsection

@push('scripts')

@endpush

@if(Session::has('success'))
@push('scripts')
<script>
$(document).ready(function() {
     showNotification('success', "{{Session::get('success')}}");
});
</script>
@endpush

@php
Session::forget('success');
@endphp
@endif

@if(Session::has('error'))
@push('scripts')
<script>
$(document).ready(function() {
     showNotification('error', "{{Session::get('error')}}");
});
</script>
@endpush

@php
Session::forget('error');
@endphp
@endif