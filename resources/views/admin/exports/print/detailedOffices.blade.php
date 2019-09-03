@extends('admin.exports.print.header')
@section('content')    
    <div class="seciton-tabel">
            @if (isset($invoices))
            <div class="col-md-6 col-sm-12 col-xs-12 pull-right rtl tabel" >
                <h4>احصائيات مقارنة انتاجية المكاتب</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:#fff !important" class="ta-header">المكتب</th>
                            <th style=" background-color: #383838 !important;color:#fff !important" class="ta-header">عدد العاملين</th>
                            <th style=" background-color: #383838 !important;color:#fff !important" class="ta-header">عدد المعاملات</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['offices'] as $key => $office)
                        <tr>
                            <td>{{ $office->Name }}</td>
                            <td>{{ count($office->employees)}}</td>
                            <td>{{ $invoices[$key]->count }}</td>   
                        </tr>
                        @endforeach
                        
                    </tbody>
                
                <tr id="trfoo">
                    <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">الاجماليات</th>
                    <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{$total->totalEmp}}</th>
                    <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{$total->totalInvoices}}</th>
                </tr>
            </table>
        @endif
    </div>
@endsection

        

