@extends('admin.exports.print.header')
@section('content')    
    <div class="seciton-tabel">
        @if (isset($invoices))
            <h4 style="text-align: right">اصدار المعاملات بالمكاتب مفضل للمتعامل أم بنظام المحمول</h4>
            <div class="col-md-12 text-right text-qu p-t-10">
                <p>{{$topServices->fromMobile !== '' ? $topServices->fromMobile : "No Service for this period"}} : أكثر نوع معاملة تم طلبها بنظام المحمول</p>
                <p>{{$topServices->fromOffice !== '' ? $topServices->fromOffice : "No Service for this period"}} : أكثر نوع معاملة تم طلبها من المكتب مباشرة</p>
            </div>
            <table class="table table-striped">
                <thead class="waleed">
                    <tr>
                        <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">المكتب</th>
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
@endsection
        

