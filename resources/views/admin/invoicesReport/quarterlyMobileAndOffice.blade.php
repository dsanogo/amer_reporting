@extends('admin.inc.main')
@section('style')
    <style>
.tabel {
    padding-top: 15px;
}
.text-qu{
    PADDING-RIGHT: 49PX;FONT-SIZE: 19PX;+
}
label{
    background: transparent!important;
}
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
            <form action="{{route('admin.getInvoicesByCategory')}}" method="get">
                <div class="col-md-12">
                    <div class="col-md-8 col-sm-12 col-xs-12 tabel-input rtl pull-right">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword" class="col-md-5 col-sm-4 control-label label-tabel">الجنسية</label>
                                {{-- <input type="password" class="form-control" id="inputPassword" placeholder="مصر">\ --}}
                                <select name="office_id" id="" class="form-control" disabled>
                                    <option value=""></option>
                                </select>                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword"  class="col-md-5 col-sm-4 control-label label-tabel">فتره المعاملات</label>
                                <input disabled type="text" id="daterange" name="daterange" value="{{isset($_GET['daterange']) ? $_GET['daterange'] : ''}}" class="form-control" id="inputPassword" placeholder="التاريخ">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 tabel-button col-sm-12 col-xs-12">
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right" type="submit">جلب البيانات </button>
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 pull-right">ارسال النتائج </button>
                    </div>
                </div>
            </form>
                <div class="col-md-12 text-right text-qu">
                    <p>{{$topServices->fromMobile !== '' ? $topServices->fromMobile : "No Service for this period"}} : أكثر نوع معاملة تم طلبها بنظام المحمول</p>
                    <p>{{$topServices->fromOffice !== '' ? $topServices->fromOffice : "No Service for this period"}} : أكثر نوع معاملة تم طلبها من المكتب مباشرة</p>
                </div>
         
            @if (isset($invoices))

                <div class="col-md-12 rtl tabel" >
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                <th>Office Name</th>
                                <th>Number of invoices From Mobile</th>
                                <th>Number of invoices From Office</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $key => $invoice)
                            <tr>
                                <td>{{ $invoice->office}}</td>
                                <td>{{ $invoice->mobileInvoices}}</td>
                                <td>{{ $invoice->officeInvoices}}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    
                        <tr id="trfoo">
                            <th class="end">Total</th>
                            <th class="end">{{ $total->sumMobileInvoices }}</th>
                            <th class="end">{{ $total->sumOfficeInvoices }}</th>
                        </tr>
                    </table>
                </div>
            @endif
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'right'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection
