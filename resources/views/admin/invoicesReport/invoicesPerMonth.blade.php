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
        /* #myChart{
            width: 100% !important;
            height: 380px !important;
            margin-top: 20px;
            margin-left:80px

        } */
        #myChart {
    height: auto;
    padding-left: 100px;
    position: relative;
    top: 50px;
}
    </style>
@endsection
@section('content')
    <body>
        <!-- section one-->
        <div class="seciton-tabel">
            <form action="{{route('admin.monthlyInvoices')}}" method="get">
                <div class="col-md-12">
                    <div class="col-md-4 col-sm-12 col-xs-12 tabel-input rtl pull-right">
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword" class="col-md-5 col-sm-4 control-label label-tabel">المنطقة</label>
                                {{-- <input type="password" class="form-control" id="inputPassword" placeholder="مصر">\ --}}
                                <select name="office_id" id="" class="form-control" disabled>
                                    <option value="">Offices</option>
                                    {{-- @foreach ($data['offices'] as $office)
                                        <option value="{{$office->Id}}" {{isset($_GET['office_id']) && $_GET['office_id']==$office->Id ? 'selected' : ''}}>{{ $office->Name}}</option>    
                                    @endforeach --}}
                                </select>                            
                            </div>
                        </div> -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputPassword"  class="col-md-5 col-sm-4 control-label label-tabel">فتره المعاملات</label>
                                <input type="text" id="daterange" name="daterange" value="{{isset($_GET['daterange']) ? $_GET['daterange'] : ''}}" class="form-control" id="inputPassword" placeholder="التاريخ">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 tabel-button col-sm-12 col-xs-12 pull-right">
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right" type="submit">جلب البيانات </button>
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 pull-right">ارسال النتائج </button>
                    </div>
                </div>
            </form>

            @if (isset($invoices))
                <div class="col-md-5 col-sm-12 col-xs-12 pull-right rtl tabel" >
                    <div class="text-center" style="margin: 5px;">
                        <a href="{{route('admin.exportMonthlyInvoices')}}" class="btn btn-primary btn-lg">Excel</a>
                        <a href="#" class="btn btn-primary btn-lg" >PDF</a>
                        <a href="{{route('admin.printMonthlyInvoices')}}" class="btn btn-primary btn-lg printPage">Print</a>
                    </div>
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                <th>الشهر</th>
                                <th>عدد المعاملات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->month . ' ' . $invoice->year }}</td>
                                <td>{{ $invoice->total_invoices }}</td>   
                            </tr>
                            @endforeach
                            
                        </tbody>
                    
                        <tr id="trfoo">
                            <th class="end">الاجماليات</th>
                            <th class="end">{{$totalInvoices}}</th>
                            
                        </tr>
                    </table>
                </div>
            @endif
            <div class="col-md-6 col-sm-12 col-xs-12">
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
        });
        var month = new Array();
        var invoices= new Array();
        @foreach ($invoices as $invoice)
              month.push('{{ $invoice->month . ' ' . $invoice->year }}');
               invoices.push('{{$invoice->total_invoices}}');
        @endforeach
     
        new Chart(document.getElementById("myChart"), { 
        "type": "line", 
        "data": { 
            "labels": month,
             "datasets": [{ 
                 "label": " المتوسط المحدد لزمن المعاملة",
                  "data": invoices, 
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
    </script>
@endsection
