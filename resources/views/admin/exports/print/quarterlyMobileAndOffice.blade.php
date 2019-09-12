@extends('admin.exports.print.header')
@section('content')    
    <div class="seciton-tabel">
        @if (isset($invoices))
            <h4 style="text-align: right">اصدار المعاملات بالمراكز مفضل للمتعامل أم بنظام المحمول</h4>
            <table class="table table-striped">
                <thead class="waleed">
                    <tr>
                        <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">المراكز</th>
                        <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">أعداد المعاملات من نظام المحمول</th>
                        <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">أعداد المعاملات بالمكاتب</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $key => $office)
                    <tr>
                            <td>{{ $office['office_name']}}</td>
                            <td>{{ $office['nb_mobile_invoices']}}</td>
                            <td>{{ $office['nb_office_invoices']}}</td>
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
@endsection
        

