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
                                <th>متوسط زمن المعاملة بالدقيقة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['offices'] as $key => $office)
                            <tr> 
                                <td>{{ $office->Name }}</td>
                                <td>{{ count($office->employees)}}</td>
                                <td>{{ $invoices[$key]->processTime }}</td>   
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            @endif
            <div class="col-md-5 pull-right rtl"><canvas id="myChart"></canvas>
            
            <canvas id="myChart-w"></canvas>
            
            </div>
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'right'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
           var top_office_name = new Array();
     var top_procees_time= new Array();
            @foreach ($topOffices as $key => $office)
                top_office_name.push('{{$office->office}}');
                top_procees_time.push('{{$office->processTime}}');
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
                          max: 50,
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
                var ctx = document.getElementById('myChart-w');
                var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["office1", "office2", "office3", "office4", "office5"],
                    datasets: [{
                    label: 'عدد المعاملات بامليون',
                    data: [12, 19, 3, 5, 2,],
                    backgroundColor: '#4e81bd',
                    borderWidth: 1
                    }]
                },
                options: {
                
                    scales: {
                    xAxes: [{
                        ticks: {
                            fontFamily: "Bahij",
                            fontColor: "#bbc3d0",
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
                          max: 50,
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
                      fontColor: "#bbc3d0",
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
                      fontColor: 'rgb(46, 148, 94)',
                      fontFamily: "Bahij",
                      radius:5
                  }
              }
                }
                });
    </script>
@endsection
