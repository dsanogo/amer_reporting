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
            <form action="{{route('admin.monthlyInvoicesProcessTime')}}" method="get">
                <div class="col-md-12">
                    <div class="col-md-8 col-sm-12 col-xs-12 tabel-input rtl pull-right">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword" class="col-md-5 col-sm-4 control-label label-tabel">المنطقة</label>
                                {{-- <input type="password" class="form-control" id="inputPassword" placeholder="مصر">\ --}}
                                <select name="office_id" id="" class="form-control">
                                    <option value="">Offices</option>
                                    @foreach ($offices as $office)
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
            <?php 
                $office_id = isset($_GET['office_id']) ? $_GET['office_id'] : '';
                $date_range = isset($_GET['daterange']) ? $_GET['daterange'] : '';
            ?>
                <div class="col-md-5 col-sm-12 col-xs-12 pull-right rtl tabel" >
                    <div class="text-center" style="margin: 5px;">
                        <a href="{{route('admin.exportMonthlyInvoicesProcessTime', ['office_id'=> $office_id, 'daterange' => $date_range])}}" class="btn btn-primary btn-lg">Excel</a>
                        <a href="{{route('admin.pdfMonthlyInvoicesProcessTime', ['office_id'=> $office_id, 'daterange' => $date_range])}}" class="btn btn-primary btn-lg" >PDF</a>
                        <a href="{{route('admin.printMonthlyInvoicesProcessTime', ['office_id'=> $office_id, 'daterange' => $date_range])}}" class="btn btn-primary btn-lg printPage">Print</a>
                    </div>
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                <th>الشهر</th>
                                <th>متوسط زمن المعاملة بالدقيقة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->month . ' ' . $invoice->year }}</td>
                                <td>{{ $invoice->process_time }}</td>   
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            @endif
            <div class='col-md-5 col-sm-12 col-xs-12 pull-right rtl'>
            <canvas id="myChart"></canvas>
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

            var month = new Array();
            var process_time= new Array();
            @foreach ($invoices as $invoice)
                month.push('{{ $invoice->month . ' ' . $invoice->year }}');
                process_time.push('{{$invoice->process_time}}');
            @endforeach
     
            new Chart(document.getElementById("myChart"), { 
        "type": "line", 
        "data": { 
            "labels": month,
             "datasets": [{ 
                 "label": " المتوسط المحدد لزمن المعاملة",
                  "data": process_time, 
                  "fill": false, 
                  "borderColor": "#5081bd", 
                  "lineTension": 0.1 }] },
                  
                  
                  
                   "options": {xAxes: [{
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
                 
              }]} });
        });
    </script>
@endsection
