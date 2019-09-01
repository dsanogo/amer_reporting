@extends('admin.exports.print.header')
@section('content')    
    <div class="seciton-tabel">
            @if (isset($invoices))
            <div class="col-md-6 col-sm-12 col-xs-12 pull-right rtl tabel" >
                <h4>قياس اداء المكاتب</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:white !important">المكتب</th>
                            <th style=" background-color: #383838 !important;color:white !important">عدد العاملين</th>
                            <th style=" background-color: #383838 !important;color:white !important">متوسط زمن المعاملة بالدقيقة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['offices'] as $key => $office)
                        <tr> 
                            <td>{{ $office->Name }}</td>
                            <td>{{ count($office->employees)}}</td>
                            <td>{{ $invoices[$key]->processTime }}</td>   
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
        

