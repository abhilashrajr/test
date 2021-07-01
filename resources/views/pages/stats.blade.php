@extends('layouts.app', [
'class' => '',
'elementActive' => 'stats',
'title' => 'Stats',
])
@push('styles')
<link rel="stylesheet" type="text/css" media="screen" href="{{asset('paper') }}/css/tempusdominus-bootstrap-4.css">
<style>
td.new, td.old{
     visibility:hidden;
}
</style>
@endpush
@section('content')

<div class="content">


     <div class="row">
          <div class=" col  mx-auto" style="max-width: max-content;">
               <div class="card card-stats" style="padding: 0px 10px;">
                    <div class="card-body p-0 align-items-center d-flex justify-content-center">
                         <form method="POST" action="{{ route('stats') }}" class="form-inline ">
                         @csrf
                              <div class="form-group" style="padding-right: 6px;margin-bottom:0px;">

                              <input type="text" name="from" value="{{$request->from ?? old('from')}}" class="form-control datetimepicker-input" id="datetimepicker1" placeholder="From" data-toggle="datetimepicker" data-target="#datetimepicker1" style="height: calc(2.25rem + 2px);"/>
                            
                              </div>

                              <div class="form-group" style="padding-right: 5px;margin-bottom:0px;">

                              <input type="text" name="to" value="{{$request->to ?? old('to')}}" class="form-control datetimepicker-input" id="datetimepicker2" placeholder="To" data-toggle="datetimepicker" data-target="#datetimepicker2" style="height: calc(2.25rem + 2px);"/>

                              </div>
                              <div class="form-group" style="margin-bottom:0px;">
                                   <button type="submit" class="btn btn-fill btn-c1">Go</button>
                              </div>
                         </form>

                    </div>
               </div>
          </div>
          <a href="{{ route('exportstats', ['from' => $request->from, 'to' => $request->to]) }}" style="font-size:16px;padding: 7px 10px;min-width:120px;height:35px;border-radius: 20px;text-transform: capitalize;margin-right: 10px;"
                                             class="btn btn-wd btn-info btn-fill  pull-right " role="button"><span
                                                  class="btn-label">
                                                  <i class="fa fa-download" style="padding-right:5px;"></i>
                                             </span>
                                             Export</a>

                                           
     </div>
     <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                    <div class="card-body ">
                         <div class="row">
                              <div class="col-5 col-md-4">
                                   <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-money-coins text-success"></i>
                                   </div>
                              </div>
                              <div class="col-7 col-md-8">
                                   <div class="numbers">
                                        <p class="card-category">Cash & Card</p>
                                        <p class="card-title">£ {{number_format(($summary[0]['revenue'] ?? 0)+($summary[1]['revenue'] ?? 0),2)}}
                                        <p>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="card-footer ">
                         <hr>
                         <div class="stats">
                              <i class="fa fa-info-circle"></i> {{($summary[0]['total'] ?? 0)+ ($summary[1]['total'] ?? 0)}} Orders
                         </div>
                    </div>
               </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                    <div class="card-body ">
                         <div class="row">
                              <div class="col-5 col-md-4">
                                   <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-credit-card text-warning"></i>
                                   </div>
                              </div>
                              <div class="col-7 col-md-8">
                                   <div class="numbers">
                                        <p class="card-category">Card Payments</p>
                                        <p class="card-title">£ {{number_format( ($summary[0]['revenue'] ?? 0),2)}}
                                        <p>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="card-footer ">
                         <hr>
                         <div class="stats">
                              <i class="fa fa-info-circle"></i>  {{($summary[0]['total'] ?? 0)}} Orders
                         </div>
                    </div>
               </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                    <div class="card-body ">
                         <div class="row">
                              <div class="col-5 col-md-4">
                                   <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon  nc-single-copy-04 text-danger"></i>
                                   </div>
                              </div>
                              <div class="col-7 col-md-8">
                                   <div class="numbers">
                                        <p class="card-category">Cash Payments</p>
                                        <p class="card-title"> £ {{number_format( ($summary[1]['revenue'] ?? 0),2)}}
                                        <p>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="card-footer ">
                         <hr>
                         <div class="stats">
                         <i class="fa fa-info-circle"></i> {{($summary[1]['total'] ?? 0)}} Orders
                         </div>
                    </div>
               </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
               <div class="card card-stats">
                    <div class="card-body ">
                         <div class="row">
                              <div class="col-5 col-md-4">
                                   <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-tap-01 text-primary"></i>
                                   </div>
                              </div>
                              <div class="col-7 col-md-8">
                                   <div class="numbers">
                                        <p class="card-category">Bookings</p>
                                        <p class="card-title">  {{round($bookings[0]['total']) ?? 0}}
                                        <p>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="card-footer ">
                         <hr>
                         <div class="stats">
                         <i class="fa fa-info-circle"></i> Total
                         </div>
                    </div>
               </div>
          </div>
     </div>
    

     <div class="row">
         
          <div class="col-md-8">
               <div class="card ">
                    <div class="card-header ">
                         <h5 class="card-title">Revenue</h5>
                         <p class="card-category">&nbsp;</p>
                    </div>
                    <div class="card-body ">
                         <canvas id=revenueChart width="400" height="100"></canvas>
                    </div>
                    <div class="card-footer ">
                          <div class="chart-legend">
                              <i class="fa fa-circle text-danger"></i> Card
                              <i class="fa fa-circle text-success"></i> Cash
                         </div>
                         <hr>
                         <div class="stats">
                              <i class="fa fa-history"></i> Revenue per month
                         </div>
                    </div>
               </div>
          </div>
          <div class="col-md-4">
               <div class="card ">
                    <div class="card-header ">
                         <h5 class="card-title">Revenue Statistics</h5>
                         <p class="card-category">&nbsp;</p>
                    </div>
                    <div class="card-body ">
                         <canvas id="revenueStats"></canvas>
                    </div>
                    <div class="card-footer ">
                         <div class="legend">
                              <i class="fa fa-circle text-danger"></i> Card
                              <i class="fa fa-circle text-success"></i> Cash
                         </div>
                         <hr>
                         <div class="stats">
                              <i class="fa fa-calendar"></i> Revenue percentage
                         </div>
                    </div>
               </div>
          </div>
     </div>
     <div class="row">
     <div class="col-md-4">
               <div class="card ">
                    <div class="card-header ">
                         <h5 class="card-title">Order Statistics</h5>
                         <p class="card-category">&nbsp;</p>
                    </div>
                    <div class="card-body ">
                         <canvas id="chartEmail"></canvas>
                    </div>
                    <div class="card-footer ">
                         <div class="legend">
                              <i class="fa fa-circle text-primary"></i> Card
                              <i class="fa fa-circle text-warning"></i> Cash
                          
                         </div>
                         <hr>
                         <div class="stats">
                              <i class="fa fa-calendar"></i> Orders percentage
                          </div>
                    </div>
               </div>
          </div>
          <div class="col-md-8">
               <div class="card card-chart">
                    <div class="card-header">
                         <h5 class="card-title">Orders</h5>
                         <p class="card-category">&nbsp;</p>
                    </div>
                    <div class="card-body">
                         <canvas id="speedChart" width="400" height="100"></canvas>
                    </div>
                    <div class="card-footer">
                         <div class="chart-legend">
                              <i class="fa fa-circle text-info"></i> Card
                              <i class="fa fa-circle text-warning"></i> Cash
                         </div>
                         <hr />
                         <div class="card-stats">
                              <i class="fa fa-check"></i>  Orders per month 
                         </div>
                    </div>
               </div>

          </div>
          
     </div>
</div>
@endsection
@php
$month = [];
$revenue = [];
if(!empty($chart_data)){
foreach($chart_data as $item)
{
$month[] = $item->month;
$revenue[] = $item->revenue;
}
}
@endphp
@push('scripts')
<script type="text/javascript" src="{{asset('paper') }}/js/moment.min.js"></script>
<script type="text/javascript" src="{{asset('paper') }}/js/tempusdominus-bootstrap-4.js"></script>
<script>
$(document).ready(function() {
$('#datetimepicker1').datetimepicker({
          format: 'YYYY-MM-DD'
     });
     $('#datetimepicker2').datetimepicker({
          format: 'YYYY-MM-DD'
     });
     @if($errors->has('from'))
           showNotification('error', "please fill from date");
     @endif
     @if($errors->has('to'))
           showNotification('error', "please fill to date");
     @endif
});

demo = {
     initPickColor: function() {
          $('.pick-class-label').click(function() {
               var new_class = $(this).attr('new-class');
               var old_class = $('#display-buttons').attr('data-class');
               var display_div = $('#display-buttons');
               if (display_div.length) {
                    var display_buttons = display_div.find('.btn');
                    display_buttons.removeClass(old_class);
                    display_buttons.addClass(new_class);
                    display_div.attr('data-class', new_class);
               }
          });
     },

     checkFullPageBackgroundImage: function() {
          $page = $('.full-page');
          image_src = $page.data('image');

          if (image_src !== undefined) {
               image_container = '<div class="full-page-background" style="background-image: url(' +
                    image_src + ') "/>';
               $page.append(image_container);
          }
     },

     initDocChart: function() {

          var ctx = document.getElementById('revenueChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo '"'.implode('","', $data['month']).'"' ?>],
        datasets: [{
            label: 'Card',
            data: [<?php echo '"'.implode('","', $data['card_revenue']).'"' ?>],
            borderColor: "#f17e5d",
            backgroundColor: "#f17e5d",
            borderWidth: 1
        },{
            label: 'Cash',
            data: [<?php echo '"'.implode('","', $data['cash_revenue']).'"' ?>],
            borderColor: "#6bd098",
            backgroundColor: "#6bd098",
            borderWidth: 1
        }
     
     ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        },
        tooltips: {
                enabled: false
          },
          legend: {
               display: false
          }
    }
});


ctx = document.getElementById('revenueStats').getContext("2d");

myChart = new Chart(ctx, {
     type: 'pie',
     data: {
          labels: [1, 2],
          datasets: [{
               label: "Orders",
               pointRadius: 0,
               pointHoverRadius: 0,
               backgroundColor: [
                    '#6bd098',
                    '#f17e5d'                   
               ],
               borderWidth: 0,
              data: [{{array_sum( $data['cash_revenue'])}},{{array_sum($data['card_revenue'])}},]
             
          }]
     },

     options: {

          legend: {
               display: false
          },

          pieceLabel: {
               render: 'percentage',
               fontColor: ['white'],
               precision: 2
          },

          tooltips: {
               enabled: false
          },

          scales: {
               yAxes: [{

                    ticks: {
                         display: false
                    },
                    gridLines: {
                         drawBorder: false,
                         zeroLineColor: "transparent",
                         color: 'rgba(255,255,255,0.05)'
                    }

               }],

               xAxes: [{
                    barPercentage: 1.6,
                    gridLines: {
                         drawBorder: false,
                         color: 'rgba(255,255,255,0.1)',
                         zeroLineColor: "transparent"
                    },
                    ticks: {
                         display: false,
                    }
               }]
          },
     }
});


     },

     initChartsPages: function() {
          chartColor = "#FFFFFF";
/*
          ctx = document.getElementById('chartHours').getContext("2d");

          myChart = new Chart(ctx, {
               type: 'line',

               data: {
                    labels: [<?php echo '"'.implode('","', $data['month']).'"' ?>],
                    datasets: [
                         {
                              borderColor: "#68b3c8",
                              backgroundColor: "#68b3c8",
                              pointRadius: 0,
                              pointHoverRadius: 0,
                              borderWidth: 3,
                              data: [<?php echo '"'.implode('","', $data['cash_revenue']).'"' ?>]
                         },
                         
                         {
                              borderColor: "#f17e5d",
                              backgroundColor: "#f17e5d",
                              pointRadius: 0,
                              pointHoverRadius: 0,
                              borderWidth: 3,
                              data: [<?php echo '"'.implode('","', $data['revenue']).'"' ?>]
                         },
                         
                        
                         
                         
                        
                    ]
               },
               options: {
                    legend: {
                         display: false
                    },

                    tooltips: {
                         enabled: false
                    },

                    scales: {
                         yAxes: [{

                              ticks: {
                                   fontColor: "#9f9f9f",
                                   beginAtZero: false,
                                   maxTicksLimit: 5,
                                   //padding: 20
                              },
                              gridLines: {
                                   drawBorder: false,
                                   zeroLineColor: "#ccc",
                                   color: 'rgba(255,255,255,0.05)'
                              }

                         }],

                         xAxes: [{
                              barPercentage: 1.6,
                              gridLines: {
                                   drawBorder: false,
                                   color: 'rgba(255,255,255,0.1)',
                                   zeroLineColor: "transparent",
                                   display: false,
                              },
                              ticks: {
                                   padding: 20,
                                   fontColor: "#9f9f9f"
                              }
                         }]
                    },
               }
          });
*/

          ctx = document.getElementById('chartEmail').getContext("2d");

          myChart = new Chart(ctx, {
               type: 'pie',
               data: {
                    labels: [1, 2],
                    datasets: [{
                         label: "Orders",
                         pointRadius: 0,
                         pointHoverRadius: 0,
                         backgroundColor: [
                              '#f3bb45',
                              '#68b3c8'
                         ],
                         borderWidth: 0,
                         data: [{{array_sum($data['cash_order'])}},{{array_sum( $data['card_order'])}}]
                       
                    }]
               },

               options: {

                    legend: {
                         display: false
                    },

                    pieceLabel: {
                         render: 'percentage',
                         fontColor: ['white'],
                         precision: 2
                    },

                    tooltips: {
                         enabled: false
                    },

                    scales: {
                         yAxes: [{

                              ticks: {
                                   display: false
                              },
                              gridLines: {
                                   drawBorder: false,
                                   zeroLineColor: "transparent",
                                   color: 'rgba(255,255,255,0.05)'
                              }

                         }],

                         xAxes: [{
                              barPercentage: 1.6,
                              gridLines: {
                                   drawBorder: false,
                                   color: 'rgba(255,255,255,0.1)',
                                   zeroLineColor: "transparent"
                              },
                              ticks: {
                                   display: false,
                              }
                         }]
                    },
               }
          });

          var speedCanvas = document.getElementById("speedChart");

          var dataFirst = {
               data: [<?php echo '"'.implode('","', $data['cash_order']).'"' ?>],
               fill: false,
               borderColor: '#fbc658',
               backgroundColor: 'transparent',
               pointBorderColor: '#fbc658',
               pointRadius: 4,
               pointHoverRadius: 4,
               pointBorderWidth: 8,
          };

          var dataSecond = {
               data: [<?php echo '"'.implode('","', $data['card_order']).'"' ?>],
               fill: false,
               borderColor: '#51CACF',
               backgroundColor: 'transparent',
               pointBorderColor: '#51CACF',
               pointRadius: 4,
               pointHoverRadius: 4,
               pointBorderWidth: 8
          };

          var speedData = {
               labels: [<?php echo '"'.implode('","', $data['month']).'"' ?>],
               datasets: [dataFirst, dataSecond]
          };

          var chartOptions = {
               legend: {
                    display: false,
                    position: 'top'
               }
          };

          var lineChart = new Chart(speedCanvas, {
               type: 'line',
               hover: false,
               data: speedData,
               options: chartOptions
          });
     },

     initGoogleMaps: function() {
          var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
          var mapOptions = {
               zoom: 13,
               center: myLatlng,
               scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
               styles: [{
                    "featureType": "water",
                    "stylers": [{
                         "saturation": 43
                    }, {
                         "lightness": -11
                    }, {
                         "hue": "#0088ff"
                    }]
               }, {
                    "featureType": "road",
                    "elementType": "geometry.fill",
                    "stylers": [{
                         "hue": "#ff0000"
                    }, {
                         "saturation": -100
                    }, {
                         "lightness": 99
                    }]
               }, {
                    "featureType": "road",
                    "elementType": "geometry.stroke",
                    "stylers": [{
                         "color": "#808080"
                    }, {
                         "lightness": 54
                    }]
               }, {
                    "featureType": "landscape.man_made",
                    "elementType": "geometry.fill",
                    "stylers": [{
                         "color": "#ece2d9"
                    }]
               }, {
                    "featureType": "poi.park",
                    "elementType": "geometry.fill",
                    "stylers": [{
                         "color": "#ccdca1"
                    }]
               }, {
                    "featureType": "road",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                         "color": "#767676"
                    }]
               }, {
                    "featureType": "road",
                    "elementType": "labels.text.stroke",
                    "stylers": [{
                         "color": "#ffffff"
                    }]
               }, {
                    "featureType": "poi",
                    "stylers": [{
                         "visibility": "off"
                    }]
               }, {
                    "featureType": "landscape.natural",
                    "elementType": "geometry.fill",
                    "stylers": [{
                         "visibility": "on"
                    }, {
                         "color": "#b8cb93"
                    }]
               }, {
                    "featureType": "poi.park",
                    "stylers": [{
                         "visibility": "on"
                    }]
               }, {
                    "featureType": "poi.sports_complex",
                    "stylers": [{
                         "visibility": "on"
                    }]
               }, {
                    "featureType": "poi.medical",
                    "stylers": [{
                         "visibility": "on"
                    }]
               }, {
                    "featureType": "poi.business",
                    "stylers": [{
                         "visibility": "simplified"
                    }]
               }]

          }
          var map = new google.maps.Map(document.getElementById("map"), mapOptions);

          var marker = new google.maps.Marker({
               position: myLatlng,
               title: "Hello World!"
          });

          // To add the marker to the map, call setMap();
          marker.setMap(map);
     }











};
$(document).ready(function() {
     // Javascript method's body can be found in assets/assets-for-demo/js/demo.js
     demo.initChartsPages();
     demo.initDocChart();

     
});
</script>
@endpush