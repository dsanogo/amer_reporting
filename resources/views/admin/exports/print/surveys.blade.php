@extends('admin.exports.print.header')
@section('content')    
    <div class="seciton-tabel">
            @if (isset($surveys))
            <div class="col-md-12 rtl tabel" >
                <h4>نتائج استطلاعات الرأى خلال فترة</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">عنوان الاستطلاع</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">عدد المصوتين</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">جيد جداً</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">جيد</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">متوسط</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">سىء</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">سىء جداً</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surveys['surveys'] as $key => $survey)
                            <tr>
                                <td>{{ $survey['description'] }}</td>
                                <td>{{ $survey['numberOfSurveys'] }}</td>
                                <td>{{ $survey['excellents'] }}%</td>
                                <td>{{ $survey['veryGoods'] }}%</td>
                                <td>{{ $survey['mediums'] }}%</td>
                                <td>{{ $survey['bads'] }}%</td>
                                <td>{{ $survey['veryBads'] }}%</td>
                            </tr>
                        @endforeach
                        
                    </tbody>
            
                </table>
            </div>
        @endif
    </div>
@endsection
        

