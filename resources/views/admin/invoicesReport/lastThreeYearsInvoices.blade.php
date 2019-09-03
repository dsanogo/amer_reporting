@extends('admin.inc.main')
@section('style')
    <style>

        @media screen and (min-width: 320px) and (max-width: 479px)
        { 
            .amaerf2 {
                font-size: 12px;
                color: white;
                padding: 25px 0 5px 0;
                text-align: right;
                font-family: "Bahij";
            }
        }
        .bordered{
            border: 1px solid black !important;
            background: lightblue;
            font-size: 18px;
        }
        tr>td{
            border: 1px solid black !important;
        }
    .colored {
        background: lightgray !important;
        color: red;
        font-weight: bold;
        font-size: 20px;
    }
    </style>
@endsection
@section('content')
    <body>
        <!-- section one-->
        <div class="seciton-tabel">
        @if ($data)
            <div class="col-md-12 pull-right rtl tabel" >
                <div class="text-center" style="margin: 5px;">
                    <a href="{{route('admin.invoices.exportLastThreeYears')}}" class="btn btn-primary btn-lg">Excel</a>
                    <a href="{{route('admin.invoices.pdfLastThreeYears')}}" class="btn btn-primary btn-lg" >PDF</a>
                    <a href="{{route('admin.invoices.printLastThreeYears')}}" class="btn btn-primary btn-lg printPage">Print</a>
                </div>
                <table class="table table-responsive table-striped" >
                    <tr>
                        <td rowspan="2" style="padding-top: 30px;" class="bordered">الشهور</td>
                        <td colspan="{{count($years)}}" class="bordered">السنوات</td>
                    </tr>
                    <tr>
                        @foreach ($years as $year)
                            <td class="bordered">{{$year}}</td>
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
                        <td>الإجماليات</td>
                        @foreach ($yearsCount as $total)
                        <td>{{$total}}</td>
                        @endforeach    
                    </tr>           
                </table>
            </div>
            
            @endif
        
        </div>

@endsection