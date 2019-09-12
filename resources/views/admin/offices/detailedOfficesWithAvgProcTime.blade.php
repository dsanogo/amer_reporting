@extends('admin.inc.main')
@section('style')
    <style>

        @media screen and (min-width: 320px) and (max-width: 479px)
        { 
            .amaerf2 {
                font-size: 12px;
                color: white;
                padding: 25px 0 5px 0;
                text-align: right;
                font-family: "Bahij";
            }
        }
        .m-t-r{
            margin-top: 50px
        }
    </style>
@endsection
@section('content')
    <body>
        <!-- section one-->
        <div class="seciton-tabel">
            <div class="col-md-12"><p class="text-center title-f1">قياس اداء المراكز</p></div>
            <form action="{{route('admin.offices.ProcessTimeDetails')}}" method="get">
                <div class="col-md-12">
                    <div class="col-md-4 col-sm-12 col-xs-12 tabel-input rtl pull-right">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputPassword"  class="col-md-5 col-sm-4 control-label label-tabel">فتره المعاملات</label>
                                <input type="text" id="daterange" name="daterange" value="{{isset($_GET['daterange']) ? $_GET['daterange'] : ''}}" class="form-control" id="inputPassword" placeholder="التاريخ">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 tabel-button col-sm-12 col-xs-12 pull-right">
                        <button class="col-md-4 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right" type="submit">بحث </button>
                        {{-- <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 pull-right">ارسال النتائج </button> --}}
                    </div>
                </div>
            </form>

            @if (count($invoices) == 0)
                <div class="col-md-12 rtl text-center alert alert-danger block-center" >
                    <h5>No Result found for this period</h5>
                </div>
            @endif

            @if (isset($invoices) && count($invoices) > 0)
                <?php 
                    $date_range = isset($_GET['daterange']) ? $_GET['daterange'] : '';
                ?>
                <div class="col-md-6 col-sm-12 col-xs-12 pull-right rtl tabel" >
                    <div class="text-center" style="margin: 5px;">
                        @if(session()->has('success'))
                            <div style="width: 300px;" class="alert alert-success center-block">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        {{-- <a href="{{route('admin.offices.exportProcessTimeDetails', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg">Excel</a> --}}
                        <a href="{{route('admin.offices.pdfProcessTimeDetails', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg" >PDF</a>
                        <a class="btn btn-primary btn-lg sendmail" >Send to mail</a>
                        <a href="{{route('admin.offices.printProcessTimeDetails', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg printPage">Print</a>
                        {{-- Email form  --}}
                        <form class="form-inline emailForm" action="{{route('admin.offices.pdfProcessTimeDetails')}}" style="display: none">
                            <div class="form-group center-block" style="width:270px;margin: 10px 0;">
                                <input type="hidden" name="byMail" value="true">
                                <input type="hidden" name="daterange" value="{{$date_range}}">
                                <input type="email" style="width: 270px;height: 35px;" class="form-group form-control" id="email" name="email" placeholder="Enter email">
                            </div>
                            <button type="submit" style="font-size: 15px;padding: 3px 14px;height: 35px;border-radius: 0;" class="btn btn-sm btn-primary">Send</button>
                        </form>
                        {{-- End Emial Form --}}
                    </div>
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                <th>المكتب</th>
                                <th>عدد العاملين</th>
                                <th>متوسط زمن المعاملة بالدقيقة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $office)
                            <tr> 
                                <td>{{ $office['office'] }}</td>
                                <td>{{ $office['nb_employee'] }}</td>
                                <td>{{ $office['proc_time'] }}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="col-md-5 col-sm-12 col-xs-12 pull-right rtl m-t-r">
                <canvas id="myChart"></canvas>
            
            
            
            </div>
    </div>
    <script>
            $(function() {
                $('input[name="daterange"]').daterangepicker({
                    opens: 'right'
                }, function(start, end, label) {
                    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                });
            });
        </script>
@endsection
@if (count($invoices) > 0)
    
@section('script')
    <script>
           var top_office_name = new Array();
           var top_procees_time= new Array();
            @foreach ($topOffices as $key => $office)
                top_office_name.push('{{$office["office"]}}');
                top_procees_time.push('{{$office["proc_time"]}}');
            @endforeach
        var ctx = document.getElementById('myChart');
                var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: top_office_name,
                    datasets: [{
                    label: 'المتوسط المحدد لزمن المعاملة',
                    data: top_procees_time,
                    backgroundColor: '#4e81bd',
                    borderWidth: 1
                    }]
                },
                options: {
                
                    scales: {
                    xAxes: [{
                        ticks: {
                            fontFamily: "Bahij",
                            fontColor: "#4e81bd",
                            fontSize: 14,
                            stepSize: 1,
                            beginAtZero: true,
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }],
                    yAxes: [{
                    id: 'FeesAmount',
                      stacked: true,
                      position: 'left',
                      gridLines: {
                        drawBorder: false
                      },
                      ticks: {
                          beginAtZero: true,
                          steps: 10,
                          stepValue: 10,
                          max: {{$topOffices[0]['proc_time']+10}},
                           stepSize: 10,
                           fontColor: "rgba(51, 51, 51, 1)",
                        //    callback: function(label, index, labels) {
                        //        if(maxFees < 100){
                        //             return label;
                        //        }else if(maxFees > 1000) {
                        //             return label/1000+'k';
                        //        }
                                
                        //     }
                      },
                          
                  }],xAxes: [{
                  ticks: {
                      fontFamily: "Bahij",
                      fontColor: "#4e81bd",
                      fontSize: 14,
                      stepSize: 1,
                      beginAtZero: true,
                      maxRotation: 45,
                      minRotation: 45
                  },
                  barPercentage: 0.9,
                  
                  maxBarThickness: 30,
                  minBarLength: 2
                 
              }]
                    }, legend: {
                  
                  labels: {
                      // This more specific font property overrides the global property
                      fontColor: '#4e81bd',
                      fontFamily: "Bahij",
                      radius:5
                  }
              }
                }
        });
               
              
    </script>
@endsection
@endif
