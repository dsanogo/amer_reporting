@extends('admin.exports.print.header')
@section('content')
    <div class="seciton-tabel">
        @if ($data)
            <h4 style="text-align: right; padding: 0px !important;width: 100%">مواسم زيادة وقلة أعداد المعاملات</h4>
            <div class="col-md-12 rtl tabel" style="padding: 10px !important;width: 100%" >
                <div class="col-md-12 pull-right rtl tabel" style="padding: 0px !important;width: 100%">
                    <table class="table table-responsive table-striped" style="width: 100%">
                        <tr>
                            <td rowspan="2" style="padding-top: 30px;background-color: #383838 !important;color:#ffffff !important" class="bordered ta-header">الشهور</td>
                            <td colspan="{{count($years)}}" class="bordered ta-header" style=" background-color: #383838 !important;color:#ffffff !important">السنوات</td>
                        </tr>
                        <tr>
                            @foreach ($years as $year)
                                <td class="bordered ta-header" style=" background-color: #383838 !important;color:#ffffff !important">{{$year}}</td>
                            @endforeach
                        </tr>
                        @foreach ($data as $key => $value)
                            <tr>
                                <td>{{$key}}</td>
                                @foreach ($data[$key] as $values)
                                    <td>{{$values['invoice']}}</td>
                                @endforeach
                            </tr>
                        @endforeach
                        <tr class="colored">
                            <td style=" background-color: #c6c6c6 !important;color:black !important; font-size: 18px !important; font-size: 15px; padding: 5px">الإجماليات</td>
                            @foreach ($yearsCount as $total)
                                <td style=" background-color: #c6c6c6 !important;color:black !important; font-size: 18px !important; font-size: 15px; padding: 5px">{{$total}}</td>
                            @endforeach    
                        </tr>           
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
        

