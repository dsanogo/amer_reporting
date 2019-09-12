@extends('admin.exports.print.header')
@section('content')    
    <div class="seciton-tabel">
            @if (isset($surveys))
            <h3 class="text-center">{{$subject->Description}} :عدد المصوتين {{$totalSurveys}}</h3>
            <div class="col-md-12 rtl tabel" >
                <h4>نتائج استطلاعات الرأى خلال فترة</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            @foreach ($surveys as $survey)
                                <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">{{$survey['evalName']}}</th>    
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($surveys as $survey)
                                <th>{{$survey['percentage']}}%</th>    
                            @endforeach
                        </tr>                        
                    </tbody>
            
                </table>
            </div>
        @endif
    </div>
@endsection
        

