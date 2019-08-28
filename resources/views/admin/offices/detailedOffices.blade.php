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
            <form action="{{route('admin.offices.details')}}" method="get">
                <div class="col-md-12">
                    <div class="col-md-8 col-sm-12 col-xs-12 tabel-input rtl pull-right">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword" class="col-md-5 col-sm-4 control-label label-tabel">المنطقة</label>
                                {{-- <input type="password" class="form-control" id="inputPassword" placeholder="مصر">\ --}}
                                <select name="office_id" id="" class="form-control" disabled>
                                    <option value="">Offices</option>
                                    @foreach ($data['offices'] as $office)
                                        <option value="{{$office->Id}}" {{isset($_GET['office_id']) && $_GET['office_id']==$office->Id ? 'selected' : ''}}>{{ $office->Name}}</option>    
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
                    <div class="col-md-4 tabel-button col-sm-12 col-xs-12">
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right" type="submit">جلب البيانات </button>
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 pull-right">ارسال النتائج </button>
                    </div>
                </div>
            </form>

            @if (isset($invoices))
                <div class="col-md-6 pull-right rtl tabel" >
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                <th>المكتب</th>
                                <th>عدد العاملين</th>
                                <th>عدد المعاملات</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['offices'] as $key => $office)
                            <tr>
                                <td>{{ $office->Name }}</td>
                                <td>{{ count($office->employees)}}</td>
                                <td>{{ $invoices[$key]->count }}</td>   
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
    <div class="col-md-6 pull-right rtl">

    <canvas id="myChart"></canvas>
    <canvas id="pie"></canvas>
    </div>
        </div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.js"></script>

    <script>
     var top_office_name = new Array();
     var top_office_count= new Array();
            @foreach ($topOffices as $key => $office)
                top_office_name.push('{{$office->office}}');
                top_office_count.push('{{$office->count}}');
            @endforeach
    
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'right'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
             var ctx = document.getElementById('myChart');
                var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels:top_office_name,
                    datasets: [{
                    label: 'عدد المعاملات بامليون',
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
                          max: 20,
                           stepSize: 2,
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
                      radius:5
                  }
              }
                }
                });


                var ctx = document.getElementById("pie").getContext('2d');
            var myChart = new Chart(ctx, {
            type: 'doughnut',
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
