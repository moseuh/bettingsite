@extends('admin.layout.master')

@section('content')

          <div class="page-header">
              <h3 class="page-title">
              <span class="page-title-icon bg-gradient-success text-white mr-2">
                  <i class="mdi mdi-home"></i>
              </span> Dashboard </h3>
          </div>

            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Users <i class="mdi mdi-account-multiple-outline  mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> {{ $widget['totalUsers'] }}</h2>
                    <h6 class="card-text">All User Balance :  {{$basic->currency_sym}} {{ number_format($widget['usersBalance'] , $basic->decimal)}} </h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Avaiable Users <i class="mdi mdi-account-multiple-outline  mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> {{$widget['activeUsers']}} </h2>
                    <h6 class="card-text">All User Balance :  {{$basic->currency_sym}} {{ number_format($widget['usersBalance'] , $basic->decimal)}} </h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Blocked Users<i class="mdi mdi-account-multiple-outline mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{$widget['banUsers']}} </h2>
                    <h6 class="card-text">All User Balance :  {{$basic->currency_sym}} {{ number_format($widget['usersBalance'] , $basic->decimal)}} </h6>
                  </div>
                </div>
              </div>
            </div>



            <div class="page-header">
              <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                  <i class="mdi  mdi-airballoon "></i>
              </span> Prediction Information </h3>
            </div>

            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-primary card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3"> Tournament <i class="mdi mdi-trophy   mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> {{ $pridictor['tournament'] }}</h2>
                    <h6 class="card-text">Running </h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Event  <i class="mdi  mdi-trophy-outline   mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> {{$pridictor['runningMatches']}} </h2>
                    <h6 class="card-text">Running </h6>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Event<i class="mdi  mdi-trophy-variant  mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> {{$pridictor['endMatches']}} </h2>
                    <h6 class="card-text">Closed </h6>
                  </div>
                </div>
              </div>
            </div>






            <div class="page-header">
              <h3 class="page-title">
              <span class="page-title-icon bg-gradient-danger text-white mr-2">
                  <i class="mdi  mdi-airballoon "></i>
              </span> Financial Statistics</h3>
            </div>

            <div class="row">
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3"> Total Pridicted Amount  <i class="mdi mdi-currency-usd    mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{$basic->currency_sym}} {{ number_format($pridictionInvest, $basic->decimal) }}</h2>
                    <h6 class="card-text"> </h6>
                  </div>
                </div>
              </div>

              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total  Refund Amount<i class="mdi  mdi-currency-usd   mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> {{$basic->currency_sym}} {{ number_format($pridictionRefund, $basic->decimal) }}</h2>
                  </div>
                </div>
              </div>

              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-dark card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total  Return Amount<i class="mdi  mdi-currency-usd   mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> {{$basic->currency_sym}} {{ number_format($pridictionReturn, $basic->decimal) }}</h2>
                  </div>
                </div>
              </div>

              <div class="col-md-3 stretch-card grid-margin">
                <div class="card @if($totalProfit > 0) bg-gradient-success @else bg-gradient-danger @endif card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Profit From Prediction<i class="mdi  mdi-currency-usd   mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> {{$basic->currency_sym}} {{ $totalProfit }}</h2>
                  </div>
                </div>
              </div>

              
            </div>





            <div class="page-header">
              <h3 class="page-title">
              <span class="page-title-icon bg-gradient-dark text-white mr-2">
                  <i class="mdi  mdi-hand-pointing-right "></i>
              </span> Charge From All Transaction</h3>
            </div>

            <div class="row">
              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-dark card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3"> Total Charge From Winner  <i class="mdi mdi-currency-usd    mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{$basic->currency_sym}} {{ number_format($betReturnCharge, $basic->decimal) }}</h2>
                  </div>
                </div>
              </div>

              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Charge For Deposit<i class="mdi  mdi-currency-usd   mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> {{$basic->currency_sym}} {{ number_format($depositCharge, $basic->decimal) }}</h2>
                  </div>
                </div>
              </div>

              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-primary card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total  Withdraw Charge <i class="mdi  mdi-currency-usd   mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> {{$basic->currency_sym}} {{ number_format($withdrawCharge, $basic->decimal) }}</h2>
                  </div>
                </div>
              </div>

              <div class="col-md-3 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Transfer Charge<i class="mdi  mdi-currency-usd   mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5"> {{$basic->currency_sym}} {{ number_format($transferCharge, $basic->decimal) }}</h2>
                  </div>
                </div>
              </div>

              
            </div>





            <div class="row">
              
              <div class="col-md-6">
                  <div class="page-header">
                    <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-primary text-white mr-2">
                        <i class="mdi  mdi-hand-pointing-right "></i>
                    </span> Payment Method</h3>
                  </div>
                  <div class="row">
                      <div class="col-md-6 stretch-card grid-margin">
                        <div class="card bg-gradient-primary card-img-holder text-white">
                          <div class="card-body">
                            <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                            <h4 class="font-weight-normal mb-3"> Total Payment Menthod  <i class="mdi mdi-numeric  mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5"> {{$deposit }}</h2>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 stretch-card grid-margin">
                        <div class="card bg-gradient-info card-img-holder text-white">
                          <div class="card-body">
                            <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">Total Deposit<i class="mdi  mdi-numeric  mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5"> {{ $depositLog}}</h2>
                          </div>
                        </div>
                      </div>

                  </div>
              </div>



              <div class="col-md-6">
                  <div class="page-header">
                    <h3 class="page-title">
                    <span class="page-title-icon bg-gradient-success text-white mr-2">
                        <i class="mdi  mdi-hand-pointing-right "></i>
                    </span> Withdraw Method</h3>
                  </div>
                  <div class="row">
                      <div class="col-md-6 stretch-card grid-margin">
                        <div class="card bg-gradient-success card-img-holder text-white">
                          <div class="card-body">
                            <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                            <h4 class="font-weight-normal mb-3"> Total Withdraw Method  <i class="mdi mdi-numeric  mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5">{{$withdrawMethod}} </h2>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6 stretch-card grid-margin">
                        <div class="card bg-gradient-danger card-img-holder text-white">
                          <div class="card-body">
                            <img src="{{asset('public/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image" />
                            <h4 class="font-weight-normal mb-3">New Withdraw Request<i class="mdi  mdi-numeric    mdi-24px float-right"></i>
                            </h4>
                            <h2 class="mb-5"> {{$withdrawLog}}</h2>
                          </div>
                        </div>
                      </div>

                  </div>
              </div>

              
              

              
            </div>


            <div class="row">

              <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="clearfix">
                      <h4 class="card-title float-left">Pridiction Statistics</h4>
                      <div id="pridiction-legend" class="rounded-legend legend-horizontal legend-top-right float-right"></div>
                    </div>
                    <canvas id="pridiction" data-month="@json($betInvest_counter['month'])" class="mt-4"></canvas>
                  </div>
                </div>
              </div>
      
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Withdraw By Gateway</h4>
                    <canvas id="user_withdraw_counter"></canvas>
                    <div id="user_withdraw_counter-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
                  </div>
                </div>
              </div>

            </div>


            <div class="row ">

            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Payment By Gateway</h4>
                    <canvas id="user_deposit_counter"></canvas>
                    <div id="user_deposit_counter-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
                  </div>
                </div>
              </div>
              

              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> Browser  Traffic</h4>
                    <canvas id="user_browser_counter"></canvas>
                    <div id="user_browser_counter-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
                  </div>
                </div>
              </div>


              
              <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title"> User Country  Traffic</h4>
                    <canvas id="user_country_counter"></canvas>
                    <div id="user_country_counter-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4"></div>
                  </div>
                </div>
              </div>
            </div>


            

@endsection


@section('script')

<script>

if ($("#pridiction").length) {
      var ctx = document.getElementById('pridiction').getContext("2d");


      
      var gradientStrokeViolet = ctx.createLinearGradient(0, 0, 0, 181);
      gradientStrokeViolet.addColorStop(0, 'rgba(218, 140, 255, 1)');
      gradientStrokeViolet.addColorStop(1, 'rgba(154, 85, 255, 1)');
      var gradientLegendViolet = 'linear-gradient(to right, rgba(218, 140, 255, 1), rgba(154, 85, 255, 1))';

      var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 360);
      gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
      gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
      var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

      var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
      gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
      var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';


      var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: @json($betInvest_counter['month']),
              datasets: [
                {
                  label: "Pridiction Amount",
                  borderColor: gradientStrokeBlue,
                  backgroundColor: gradientStrokeBlue,
                  hoverBackgroundColor: gradientStrokeBlue,
                  legendColor: gradientLegendBlue,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 1,
                  fill: 'origin',
                  data: @json($betInvest_counter['bet_invest_amount'])
                },
                {
                  label: "Return Back Amount",
                  borderColor: gradientStrokeRed,
                backgroundColor: gradientStrokeRed,
                hoverBackgroundColor: gradientStrokeRed,
                legendColor: gradientLegendRed,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 1,
                  fill: 'origin',
                  data: @json($betInvest_counter['bet_return_amount'])
                },
                {
                  label: "Refund Amount",
                  borderColor: gradientStrokeViolet,
                  backgroundColor: gradientStrokeViolet,
                  hoverBackgroundColor: gradientStrokeViolet,
                  legendColor: gradientLegendViolet,
                  pointRadius: 0,
                  fill: false,
                  borderWidth: 1,
                  fill: 'origin',
                  data: @json($betInvest_counter['bet_refund_amount'])
                }
            ]
          },
          options: {
              legend: {
                  display: false
              },
              scales: {
                  yAxes: [{
                      ticks: {
                          display: false,
                          min: 0,
                          stepSize: 10
                      },
                      gridLines: {
                        drawBorder: false,
                        display: false
                      }
                  }],
                  xAxes: [{
                      gridLines: {
                        display:false,
                        drawBorder: false,
                        color: 'rgba(0,0,0,1)',
                        zeroLineColor: '#eeeeee'
                      },
                      ticks: {
                          padding: 20,
                          fontColor: "#9c9fa6",
                          autoSkip: true,
                      },
                      barPercentage: 0.7
                  }]
                }
              },
              elements: {
                point: {
                  radius: 0
                }
              }
            })
    }




if ($("#user_withdraw_counter").length) {
  
  var ctx = document.getElementById('user_withdraw_counter').getContext("2d");
      var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 181);
      gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
      gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
      var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

      var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 50);
      gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
      gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
      var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';

      var gradientStrokeGreen = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStrokeGreen.addColorStop(0, 'rgba(6, 185, 157, 1)');
      gradientStrokeGreen.addColorStop(1, 'rgba(132, 217, 210, 1)');
      var gradientLegendGreen = 'linear-gradient(to right, rgba(6, 185, 157, 1), rgba(132, 217, 210, 1))';      

      var trafficChartData = {
        datasets: [{
          data: {{ $chart['user_withdraw_counter']->flatten() }},
          backgroundColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          hoverBackgroundColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          borderColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          legendColor: [
            gradientLegendBlue,
            gradientLegendGreen,
            gradientLegendRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ]
        }],
    
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels:  @json($chart['user_withdraw_counter']->keys())
      };
      var trafficChartOptions = {
        responsive: true,
        animation: {
          animateScale: true,
          animateRotate: true
        },
        legend: false,
        legendCallback: function(chart) {
          var text = []; 
          text.push('<ul>'); 
          for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) { 
              text.push('<li><span class="legend-dots" style="background:' + 
              trafficChartData.datasets[0].legendColor[i] + 
                          '"></span>'); 
              if (trafficChartData.labels[i]) { 
                  text.push(trafficChartData.labels[i]); 
              }
              text.push('<span class="float-right">'+trafficChartData.datasets[0].data[i]+" {{$basic->currency_sym}}"+'</span>')
              text.push('</li>'); 
          } 
          text.push('</ul>'); 
          return text.join('');
        }
      };
      var trafficChartCanvas = $("#user_withdraw_counter").get(0).getContext("2d");
      var trafficChart = new Chart(trafficChartCanvas, {
        type: 'doughnut',
        data: trafficChartData,
        options: trafficChartOptions
      });
      $("#user_withdraw_counter-legend").html(trafficChart.generateLegend());      
    }


if ($("#user_deposit_counter").length) {
  
  var ctx = document.getElementById('user_deposit_counter').getContext("2d");
      var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 181);
      gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
      gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
      var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

      var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 50);
      gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
      gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
      var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';

      var gradientStrokeGreen = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStrokeGreen.addColorStop(0, 'rgba(6, 185, 157, 1)');
      gradientStrokeGreen.addColorStop(1, 'rgba(132, 217, 210, 1)');
      var gradientLegendGreen = 'linear-gradient(to right, rgba(6, 185, 157, 1), rgba(132, 217, 210, 1))';      

      var trafficChartData = {
        datasets: [{
          data: {{ $chart['user_deposit_counter']->flatten() }},
          backgroundColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          hoverBackgroundColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          borderColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          legendColor: [
            gradientLegendBlue,
            gradientLegendGreen,
            gradientLegendRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ]
        }],
    
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels:  @json($chart['user_deposit_counter']->keys())
      };
      var trafficChartOptions = {
        responsive: true,
        animation: {
          animateScale: true,
          animateRotate: true
        },
        legend: false,
        legendCallback: function(chart) {
          var text = []; 
          text.push('<ul>'); 
          for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) { 
              text.push('<li><span class="legend-dots" style="background:' + 
              trafficChartData.datasets[0].legendColor[i] + 
                          '"></span>'); 
              if (trafficChartData.labels[i]) { 
                  text.push(trafficChartData.labels[i]); 
              }
              text.push('<span class="float-right">'+trafficChartData.datasets[0].data[i]+" {{$basic->currency_sym}}"+'</span>')
              text.push('</li>'); 
          } 
          text.push('</ul>'); 
          return text.join('');
        }
      };
      var trafficChartCanvas = $("#user_deposit_counter").get(0).getContext("2d");
      var trafficChart = new Chart(trafficChartCanvas, {
        type: 'doughnut',
        data: trafficChartData,
        options: trafficChartOptions
      });
      $("#user_deposit_counter-legend").html(trafficChart.generateLegend());      
    }




if ($("#user_browser_counter").length) {
  
  var ctx = document.getElementById('user_browser_counter').getContext("2d");
      var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 181);
      gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
      gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
      var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

      var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 50);
      gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
      gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
      var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';

      var gradientStrokeGreen = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStrokeGreen.addColorStop(0, 'rgba(6, 185, 157, 1)');
      gradientStrokeGreen.addColorStop(1, 'rgba(132, 217, 210, 1)');
      var gradientLegendGreen = 'linear-gradient(to right, rgba(6, 185, 157, 1), rgba(132, 217, 210, 1))';      

      var trafficChartData = {
        datasets: [{
          data: {{ $chart['user_browser_counter']->flatten() }},
          backgroundColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          hoverBackgroundColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          borderColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          legendColor: [
            gradientLegendBlue,
            gradientLegendGreen,
            gradientLegendRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ]
        }],
    
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels:  @json($chart['user_browser_counter']->keys())
      };
      var trafficChartOptions = {
        responsive: true,
        animation: {
          animateScale: true,
          animateRotate: true
        },
        legend: false,
        legendCallback: function(chart) {
          var text = []; 
          text.push('<ul>'); 
          for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) { 
              text.push('<li><span class="legend-dots" style="background:' + 
              trafficChartData.datasets[0].legendColor[i] + 
                          '"></span>'); 
              if (trafficChartData.labels[i]) { 
                  text.push(trafficChartData.labels[i]); 
              }
              text.push('<span class="float-right">'+trafficChartData.datasets[0].data[i]+"%"+'</span>')
              text.push('</li>'); 
          } 
          text.push('</ul>'); 
          return text.join('');
        }
      };
      var trafficChartCanvas = $("#user_browser_counter").get(0).getContext("2d");
      var trafficChart = new Chart(trafficChartCanvas, {
        type: 'doughnut',
        data: trafficChartData,
        options: trafficChartOptions
      });
      $("#user_browser_counter-legend").html(trafficChart.generateLegend());      
    }



    
if ($("#user_country_counter").length) {
  
  var ctx = document.getElementById('user_country_counter').getContext("2d");
      var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 181);
      gradientStrokeBlue.addColorStop(0, 'rgba(54, 215, 232, 1)');
      gradientStrokeBlue.addColorStop(1, 'rgba(177, 148, 250, 1)');
      var gradientLegendBlue = 'linear-gradient(to right, rgba(54, 215, 232, 1), rgba(177, 148, 250, 1))';

      var gradientStrokeRed = ctx.createLinearGradient(0, 0, 0, 50);
      gradientStrokeRed.addColorStop(0, 'rgba(255, 191, 150, 1)');
      gradientStrokeRed.addColorStop(1, 'rgba(254, 112, 150, 1)');
      var gradientLegendRed = 'linear-gradient(to right, rgba(255, 191, 150, 1), rgba(254, 112, 150, 1))';

      var gradientStrokeGreen = ctx.createLinearGradient(0, 0, 0, 300);
      gradientStrokeGreen.addColorStop(0, 'rgba(6, 185, 157, 1)');
      gradientStrokeGreen.addColorStop(1, 'rgba(132, 217, 210, 1)');
      var gradientLegendGreen = 'linear-gradient(to right, rgba(6, 185, 157, 1), rgba(132, 217, 210, 1))';      

      var trafficChartData = {
        datasets: [{
          data: {{ $chart['user_country_counter']->flatten() }},
          backgroundColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          hoverBackgroundColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          borderColor: [
            gradientStrokeBlue,
            gradientStrokeGreen,
            gradientStrokeRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ],
          legendColor: [
            gradientLegendBlue,
            gradientLegendGreen,
            gradientLegendRed,
            '#e74c3c',
            '#9b59b6',
            '#34495e',
            '#e67e22',
            '#f1c40f',
            '#7f8c8d',
            '#3498db'
          ]
        }],
    
        // These labels appear in the legend and in the tooltips when hovering different arcs
        labels:  @json($chart['user_country_counter']->keys())
      };
      var trafficChartOptions = {
        responsive: true,
        animation: {
          animateScale: true,
          animateRotate: true
        },
        legend: false,
        legendCallback: function(chart) {
          var text = []; 
          text.push('<ul>'); 
          for (var i = 0; i < trafficChartData.datasets[0].data.length; i++) { 
              text.push('<li><span class="legend-dots" style="background:' + 
              trafficChartData.datasets[0].legendColor[i] + 
                          '"></span>'); 
              if (trafficChartData.labels[i]) { 
                  text.push(trafficChartData.labels[i]); 
              }
              text.push('<span class="float-right">'+trafficChartData.datasets[0].data[i]+"%"+'</span>')
              text.push('</li>'); 
          } 
          text.push('</ul>'); 
          return text.join('');
        }
      };
      var trafficChartCanvas = $("#user_country_counter").get(0).getContext("2d");
      var trafficChart = new Chart(trafficChartCanvas, {
        type: 'doughnut',
        data: trafficChartData,
        options: trafficChartOptions
      });
      $("#user_country_counter-legend").html(trafficChart.generateLegend());      
    }
</script>

@stop