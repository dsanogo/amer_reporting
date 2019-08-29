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
            <form action="{{route('admin.getInvoicesByCategory')}}" method="get">
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
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right" type="submit">جلب البيانات </button>
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 pull-right">ارسال النتائج </button>
                    </div>
                </div>
            </form>

            @if (isset($invoices))
                <div class="col-md-12 rtl tabel" >
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                <th>Office Name</th>
                                <th>Number of invoices</th>
                                <th>Total Fees</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->office}}</td>
                                <td>{{ isset($invoice->count) ? $invoice->count : 0 }}</td>    
                                <td>{{ isset($invoice->totalFees) ? $invoice->totalFees : 0 }}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    
                        <tr id="trfoo">
                            <th class="end">Total</th>
                            <th class="end">{{ $total->totalInvoices }}</th>
                            <th class="end">{{ $total->totalFees }}</th>
                        </tr>
                    </table>
                </div>
            @endif
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
    </script>
@endsection
