@extends('admin.inc.main')
@section('style')
    <style>
.tabel {
    padding-top: 15px;
}
.text-qu{
    PADDING-RIGHT: 49PX;FONT-SIZE: 19PX;+
}
label{
    background: transparent!important;
}
.p-t-10{
    padding-top:20px;
}
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
                <div class="col-md-12 text-right text-qu p-t-10">
                    <p>{{$topServices->fromMobile !== '' ? $topServices->fromMobile : "No Service for this period"}} : أكثر نوع معاملة تم طلبها بنظام المحمول</p>
                    <p>{{$topServices->fromOffice !== '' ? $topServices->fromOffice : "No Service for this period"}} : أكثر نوع معاملة تم طلبها من المكتب مباشرة</p>
                </div>
         
            @if (isset($invoices))

                <div class="col-md-12 rtl tabel" >
                    <div class="text-center" style="margin: 5px;">
                        <a href="#" class="btn btn-primary btn-lg">Excel</a>
                        <a href="#" class="btn btn-primary btn-lg" >PDF</a>
                        <a href="{{route('admin.printMobileAndOfficeInvoicesQuarterly')}}" class="btn btn-primary btn-lg printPage">Print</a>
                    </div>
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                <th>المكتب</th>
                                <th>أعداد المعاملات من نظام المحمول</th>
                                <th>أعداد المعاملات بالمكاتب</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $key => $invoice)
                            <tr>
                                <td>{{ $invoice->office}}</td>
                                <td>{{ $invoice->mobileInvoices}}</td>
                                <td>{{ $invoice->officeInvoices}}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    
                        <tr id="trfoo">
                            <th class="end">الإجماليات</th>
                            <th class="end">{{ $total->sumMobileInvoices }}</th>
                            <th class="end">{{ $total->sumOfficeInvoices }}</th>
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
