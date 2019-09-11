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
            <div class="col-md-12"><p class="text-center title-f1">استخدام نظام المحمول للحصول على الخدمة</p></div>
            <form action="{{route('admin.getMobileAndOfficeInvoices')}}" method="get">
                <div class="col-md-12">
                    <div class="col-md-4 col-sm-12 col-xs-12 tabel-input rtl pull-right">
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword" class="col-md-5 col-sm-4 control-label label-tabel">الجنسية</label>
                                {{-- <input type="password" class="form-control" id="inputPassword" placeholder="مصر">\ --}}
                                <select name="office_id" id="" class="form-control" disabled>
                                    <option value=""></option>
                                </select>                            
                            </div>
                        </div> -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="inputPassword"  class="col-md-5 col-sm-4 control-label label-tabel">فتره المعاملات</label>
                                <input type="text" id="daterange" name="daterange" value="{{isset($_GET['daterange']) ? $_GET['daterange'] : ''}}" class="form-control" id="inputPassword" placeholder="التاريخ">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 tabel-button col-sm-12 col-xs-12 pull-right">
                        <button class="col-md-4 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right" type="submit">بحث </button>
                        {{-- <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 pull-right">ارسال النتائج </button> --}}
                    </div>
                </div>
            </form>
            @if (count($invoices) == 0)
                <div class="col-md-12 rtl text-center alert alert-danger block-center" >
                    <h5>No Result found for this period</h5>
                </div>
            @endif
            @if (isset($invoices) && count($invoices) >0)
                <?php 
                    $date_range = isset($_GET['daterange']) ? $_GET['daterange'] : '';
                ?>
                <div class="col-md-12 rtl tabel" >
                    <div class="text-center" style="margin: 5px;">
                        @if(session()->has('success'))
                            <div style="width: 300px;" class="alert alert-success center-block">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <a href="{{route('admin.exportMobileAndOfficeInvoices', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg">Excel</a>
                        <a href="{{route('admin.pdfMobileAndOfficeInvoices', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg" >PDF</a>
                        <a class="btn btn-primary btn-lg sendmail" >Send to mail</a>
                        <a href="{{route('admin.printMobileAndOfficeInvoices', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg printPage">Print</a>

                        {{-- Email form  --}}
                        <form class="form-inline emailForm" action="{{route('admin.pdfMobileAndOfficeInvoices')}}" style="display: none">
                            <div class="form-group center-block" style="width:270px;margin: 10px 0;">
                                <input type="hidden" name="byMail" value="true">
                                <input type="hidden" name="daterange" value="{{$date_range}}">
                                <input type="email" style="width: 270px;height: 35px;" class="form-group form-control" id="email" name="email" placeholder="Enter email">
                            </div>
                            <button type="submit" style="font-size: 15px;padding: 3px 14px;height: 35px;border-radius: 0;" class="btn btn-sm btn-primary">Send</button>
                        </form>
                        {{-- End Emial Form --}}
                    </div>
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                <th>المكتب</th>
                                <th>أعداد المعاملات من نظام المحمول</th>
                                <th>أعداد المعاملات بالمكاتب</th>
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
                            <th class="end">الإجماليات</th>
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
