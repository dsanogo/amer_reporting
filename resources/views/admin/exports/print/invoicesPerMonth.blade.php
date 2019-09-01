@extends('admin.exports.print.header')
@section('content')    
    <div class="seciton-tabel">
        @if (isset($invoices))
            <div class="col-md-5 col-sm-12 col-xs-12 pull-right rtl tabel" >
                <h4>التطور الزمني لانتاجية المكاتب</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:white !important">الشهر</th>
                            <th style=" background-color: #383838 !important;color:white !important">عدد المعاملات</th>
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
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">الاجماليات</th>
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{$totalInvoices}}</th>
                        
                    </tr>
                </table>
            </div>
        @endif
    </div>
@endsection
        

