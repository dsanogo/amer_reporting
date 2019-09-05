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
        @if (count($data) == 0)
            <div class="col-md-12 rtl text-center alert alert-danger block-center" >
                <h5>No Result found for this period</h5>
            </div>
        @endif
        @if ($data && count($data) > 0)
            <?php 
                $date_range = isset($_GET['daterange']) ? $_GET['daterange'] : '';
            ?>
            <div class="col-md-12 pull-right rtl tabel" >
                <div class="text-center" style="margin: 5px;">
                    @if(session()->has('success'))
                        <div style="width: 300px;" class="alert alert-success center-block">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <a href="{{route('admin.invoices.exportLastThreeYears', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg">Excel</a>
                    <a href="{{route('admin.invoices.pdfLastThreeYears', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg" >PDF</a>
                    <a class="btn btn-primary btn-lg sendmail" >Send to mail</a>
                    <a href="{{route('admin.invoices.printLastThreeYears', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg printPage">Print</a>
                    {{-- Email form  --}}
                    <form class="form-inline emailForm" action="{{route('admin.invoices.pdfLastThreeYears')}}" style="display: none">
                        <div class="form-group center-block" style="width:270px;margin: 10px 0;">
                            <input type="hidden" name="byMail" value="true">
                            <input type="hidden" name="daterange" value="{{$date_range}}">
                            <input type="email" style="width: 270px;height: 35px;" class="form-group form-control" id="email" name="email" placeholder="Enter email">
                        </div>
                        <button type="submit" style="font-size: 15px;padding: 3px 14px;height: 35px;border-radius: 0;" class="btn btn-sm btn-primary">Send</button>
                    </form>
                    {{-- End Emial Form --}}
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