@extends('admin.exports.print.header')

@section('style')
@endsection
@section('content')    
    <div class="seciton-tabel">
        @if (isset($invoices))
            <div class="col-md-12 rtl tabel" >
                <h4>المعاملات خلال فترة موزعة على المراكز</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">المراكز</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">إجمالى أعداد المعاملات</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">إجمالى الرسوم</th>
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
                        <th style=" background-color: #c6c6c6 !important;color:black !important">الإجماليات</th>
                        <th style=" background-color: #c6c6c6 !important;color:black !important">{{ $total->totalInvoices }}</th>
                        <th style=" background-color: #c6c6c6 !important;color:black !important">{{ $total->totalFees }}</th>
                    </tr>
                </table>
            </div>
        @endif
    </div>
@endsection
        

