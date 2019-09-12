@extends('admin.exports.print.header')
@section('content')    
    <div class="seciton-tabel">
            @if (isset($invoices))
            <div class="col-md-6 col-sm-12 col-xs-12 pull-right rtl tabel" >
                <h4>قياس اداء المراكز</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">المراكز</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">عدد العاملين</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">متوسط زمن المعاملة بالدقيقة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $office)
                        <tr> 
                            <td>{{ $office['office'] }}</td>
                            <td>{{ $office['nb_employee'] }}</td>
                            <td>{{ $office['proc_time'] }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
        

