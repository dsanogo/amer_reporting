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
        #myChart{
            width: 90% !important;
            height: 350px !important;
            margin-top: 50px;
            margin-right: 20px;
        }
        #pie{
            margin-bottom: 30px;
        }
    </style>
@endsection
@section('content')
    <body>
        <!-- section one-->
        <div class="seciton-tabel">
            <div class="col-md-12"><p class="text-center title-f1">احصائيات مقارنة انتاجية المراكز</p></div>
            <form action="{{route('admin.offices.details')}}" method="get">
                <div class="col-md-12">
                    <div class="col-md-8 col-sm-12 col-xs-12 tabel-input rtl pull-right">
                    <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword" class="col-md-5 col-sm-4 control-label label-tabel">المنطقة</label>

                                <select name="district_id" id="" class="form-control" >
                                    @foreach ($districts as $district)
                                        <option value="{{$district->Id}}" {{isset($_GET['district_id']) && $_GET['district_id']==$district->Id ? 'selected' : ''}}>{{$district->Name}}</option>    
                                    @endforeach
                                </select>    
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword"  class="col-md-5 col-sm-4 control-label label-tabel">فتره المعاملات</label>
                                <input type="text" id="daterange" name="daterange" value="{{isset($_GET['daterange']) ? $_GET['daterange'] : ''}}" class="form-control" id="inputPassword" placeholder="التاريخ">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 tabel-button col-sm-12 col-xs-12  pull-right">
                        <button class="col-md-4 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right" type="submit">بحث </button>
                        {{-- <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 pull-right">ارسال النتائج </button> --}}
                    </div>
                </div>
            </form>

            @if (isset($invoices) && count($invoices) == 0)
                <div class="col-md-12 rtl text-center alert alert-danger block-center" >
                    <h5>No Result found for this period</h5>
                </div>
            @endif

            @if (isset($invoices) && count($invoices) > 0)

                <?php 
                    $district_id = isset($_GET['district_id']) ? $_GET['district_id'] : '';
                    $date_range = isset($_GET['daterange']) ? $_GET['daterange'] : '';
                ?>
                <div class="col-md-6 col-sm-12 col-xs-12 pull-right rtl tabel" >
                    <div class="text-center" style="margin: 5px;">
                        @if(session()->has('success'))
                            <div style="width: 300px;" class="alert alert-success center-block">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        {{-- <a href="{{route('admin.offices.exportDetails', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg">Excel</a> --}}
                        <a href="{{route('admin.offices.pdfDetails', ['district_id' => $district_id, 'daterange' => $date_range])}}" class="btn btn-primary btn-lg" >PDF</a>
                        <a class="btn btn-primary btn-lg sendmail" >Send to mail</a>
                        <a href="{{route('admin.offices.printDetails', ['district_id' => $district_id, 'daterange' => $date_range])}}" class="btn btn-primary btn-lg printPage">Print</a>
                        {{-- Email form  --}}
                        <form class="form-inline emailForm" action="{{route('admin.offices.pdfDetails')}}" style="display: none">
                            <div class="form-group center-block" style="width:270px;margin: 10px 0;">
                                <input type="hidden" name="byMail" value="true">
                                <input type="hidden" name="daterange" value="{{$date_range}}">
                                <input type="hidden" name="district_id" value="{{$district_id}}">
                                <input type="email" style="width: 270px;height: 35px;" class="form-group form-control" id="email" name="email" placeholder="Enter email">
                            </div>
                            <button type="submit" style="font-size: 15px;padding: 3px 14px;height: 35px;border-radius: 0;" class="btn btn-sm btn-primary">Send</button>
                        </form>
                        {{-- End Emial Form --}}
                    </div>
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                <th>المراكز</th>
                                <th>عدد العاملين</th>
                                <th>عدد المعاملات</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $office)
                            <tr>
                                <td>{{ $office['office_name'] }}</td>
                                <td>{{ $office['nb_employee'] }}</td>
                                <td>{{ $office['nb_invoices'] }}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    
                        <tr id="trfoo">
                            <th class="end">الاجماليات</th>
                            <th class="end">{{$total->totalEmp}}</th>
                            <th class="end">{{$total->totalInvoices}}</th>
                            
                        </tr>
                    </table>
            @endif
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12 pull-right rtl">

    <canvas id="myChart"></canvas>
        <p class="text-center title">نسب انتاجية المراكز بالمناطق</p>
    <canvas id="pie"></canvas>
    </div>
    </div>
    <script>
        $(document).ready(function() {
            $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'right'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
        });
    </script>  
@endsection
@if (isset($invoices))
    
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.js"></script>

    <script>
     var top_office_name = new Array();
     var top_office_count= new Array();
            @foreach ($topOffices as $key => $office)
            @if ($office['nb_invoices'] > 0)
                top_office_name.push("{{$office['office_name']}}");
                top_office_count.push('{{$office["nb_invoices"]}}');
            @endif
            @endforeach
    
             var ctx = document.getElementById('myChart');
                var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels:top_office_name,
                    datasets: [{
                    label: 'أعلى خمسة مراكز فى أعداد المعاملات',
                    data: top_office_count,
                    backgroundColor: [
                        "#356eb3",
                        "#bb3835",
                        "#8db241",
                        "#73529c",
                        "#34aacb"
                    ],
                    borderWidth: 1
                    }]
                },
                options: {
                
                    scales: {
                    xAxes: [{
                        ticks: {
                            fontFamily: "Bahij",
                            fontColor: "#356eb3",
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
                          steps: 2,
                          stepValue: 2,
                          max: {{isset($invoices[0]) ? $invoices[0]['nb_invoices'] : 20}} + 20,
                           stepSize: {{isset($invoices[4]) ? $invoices[4]['nb_invoices'] : 2}},
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
                      fontColor: "#bbc3d0",
                      fontSize: 14,
                      stepSize: 1,
                      beginAtZero: true,
                      maxRotation: 45,
                      minRotation: 45
                  },
                  barPercentage: 0.6,
                  
                  maxBarThickness: 30,
                  minBarLength: 2
                 
              }]
                    }, legend: {
                  
                  labels: {
                      // This more specific font property overrides the global property
                      fontColor: '#356eb3',
                      fontFamily: "Bahij",
                      fontSize: 18,
                      radius:5
                  }
              }
                }
                });

            var ctx = document.getElementById("pie").getContext('2d');
            var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: top_office_name,
                datasets: [{
                backgroundColor: [
                    "#356eb3",
                    "#bb3835",
                    "#8db241",
                    "#73529c",
                    "#34aacb"
                ],
                data: top_office_count
                }]
            }
            });     
    </script>
@endsection
@endif