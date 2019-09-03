@extends('admin.exports.print.header')
@section('content')    
    <div class="seciton-tabel">
            @if (isset($invoices))
            <div class="col-md-5 col-sm-12 col-xs-12 pull-right rtl tabel" >
                <h4>التطور الزمني لاداء الكاتب</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">الشهر</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">متوسط زمن المعاملة بالدقيقة</th>
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
    </div>
@endsection
        

