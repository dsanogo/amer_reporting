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
    </style>
@endsection
@section('content')
    <body>
        <!-- section one-->
        <div class="seciton-tabel">

            @if ($invoices)
            <div class="col-md-12 pull-right rtl tabel" >

                <table class="table table-responsive table-striped" border="1">
            
                    <tr>
                        <td rowspan="2" style="padding-top: 30px;">Months</td>
                        <td colspan="{{count($years)}}">Years</td>
                    </tr>
                    <tr>
                   
                        @foreach ($years as $year)
                            <td>{{$year}}</td>
                        @endforeach
                    </tr>                 
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{$invoice->month}}</td>
                            @foreach ($years as $year)
                                @if ($invoice->year == $year)
                                    <td>{{$invoice->total_invoices}}</td>
                                @else
                                    <td>0</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </table>
            </div>
            
            @endif
        
        </div>

@endsection