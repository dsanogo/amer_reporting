@extends('admin.exports.print.header')
@section('content')    
    <div class="seciton-tabel">
        @if (isset($invoices))
            <div class="col-md-12 rtl tabel" >
                <h4>المعاملات خلال فترة حسب نوع المعاملة</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:white !important">نوع المعاملة</th>
                            <th style=" background-color: #383838 !important;color:white !important">إجمالى أعداد المعاملات</th>
                            <th style=" background-color: #383838 !important;color:white !important">إجمالى الرسوم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices['services'] as $service)
                        <tr>
                            <td>{{ $service->Name}}</td>
                            <td>{{ isset($service->invoiceCount) ? $service->invoiceCount : 0 }}</td>
                            <td>{{ isset($service->invoicetotalFees) ? $service->invoicetotalFees : 0 }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                
                    <tr id="trfoo">
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">الإجماليات</th>
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{ $total->totalInvoices }}</th>
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{ $total->totalFees }}</th>
                    </tr>
                </table>
            </div>
        @endif
    </div>
@endsection
        

