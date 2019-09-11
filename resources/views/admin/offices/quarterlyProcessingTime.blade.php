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
            <div class="col-md-12"><p class="text-center title-f1">ما هى المراكز التى يسوء أداؤها وتستدعى التدخل؟</p></div>
        @if (isset($invoices) && count($invoices) > 0)
            <p class="text-right title-f1">بناءاً على أداء آخر 3 شهور،المراكز الموضحة فى الجدول أسفله يسوء أداؤها</p>
            <div class="col-md-12 pull-right rtl tabel" >
                <div class="text-center" style="margin: 5px;">
                    @if(session()->has('success'))
                        <div style="width: 300px;" class="alert alert-success center-block">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    {{-- <a href="{{route('admin.invoices.exportLastThreeYears')}}" class="btn btn-primary btn-lg">Excel</a> --}}
                    <a href="{{route('admin.invoices.pdfLastThreeYears')}}" class="btn btn-primary btn-lg" >PDF</a>
                    <a class="btn btn-primary btn-lg sendmail" >Send to mail</a>
                    <a href="{{route('admin.invoices.printLastThreeYears')}}" class="btn btn-primary btn-lg printPage">Print</a>
                    
                    <form class="form-inline emailForm" action="{{route('admin.invoices.pdfLastThreeYears')}}" style="display: none">
                        <div class="form-group center-block" style="width:270px;margin: 10px 0;">
                            <input type="hidden" name="byMail" value="true">
                            <input type="email" style="width: 270px;height: 35px;" class="form-group form-control" id="email" name="email" placeholder="Enter email">
                        </div>
                        <button type="submit" style="font-size: 15px;padding: 3px 14px;height: 35px;border-radius: 0;" class="btn btn-sm btn-primary">Send</button>
                    </form>
                    
                </div>
                <table class="table table-responsive table-striped" >
                    <tr>
                        <td rowspan="2" style="padding-top: 30px;" class="bordered">المراكز</td>
                        <td colspan="{{count($months)}}" class="bordered">متوسط زمن المعاملة</td>
                    </tr>
                    <tr>
                        @foreach ($months as $month)
                            <td class="bordered">{{$month['name']}}</td>
                        @endforeach
                    </tr>
                    @foreach ($invoices as $key => $invoice)
                    <tr>                        
                        <td>{{$key}}</td>
                        @foreach ($invoices[$key] as $i => $item)
                            <td>{{$item['procTime']}}</td>
                        @endforeach         
                    </tr>
                    @endforeach
                </table>
            </div>
            
            @endif
        
        </div>

@endsection