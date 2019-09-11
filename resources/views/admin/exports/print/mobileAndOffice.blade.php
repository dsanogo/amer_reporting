@extends('admin.exports.print.header')
@section('content')    
    <div class="seciton-tabel">
        @if (isset($invoices))
            <div class="col-md-12 rtl tabel" >
                <h4>استخدام نظام المحمول للحصول على الخدمة</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">المراكز</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">أعداد المعاملات من نظام المحمول</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">أعداد المعاملات بالمكاتب</th>
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
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">الإجماليات</th>
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{ $total->sumMobileInvoices }}</th>
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{ $total->sumOfficeInvoices }}</th>
                    </tr>
                </table>
            </div>
        @endif
    </div>
@endsection
        

