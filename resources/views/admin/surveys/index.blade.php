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
            <form action="{{route('admin.getInvoicesByCategory')}}" method="get">
                <div class="col-md-12">
                    <div class="col-md-4 col-sm-12 col-xs-12 tabel-input rtl pull-right">
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword" class="col-md-5 col-sm-4 control-label label-tabel">الجنسية</label>
                                {{-- <input type="password" class="form-control" id="inputPassword" placeholder="مصر">\ --}}
                                <select name="category_id" id="" class="form-control" disabled>
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
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right" type="submit">جلب البيانات </button>
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 pull-right">ارسال النتائج </button>
                    </div>
                </div>
            </form>

            @if (isset($surveys))
                <div class="col-md-12 rtl tabel" >
                    <div class="text-center" style="margin: 5px;">
                        <a href="{{route('admin.exportSurveysReport')}}" class="btn btn-primary btn-lg">Excel</a>
                        <a href="{{route('admin.pdfSurveysReport')}}" class="btn btn-primary btn-lg" >PDF</a>
                        <a href="{{route('admin.printSurveysReport')}}" class="btn btn-primary btn-lg printPage">Print</a>
                    </div>
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                <th>عنوان الاستطلاع</th>
                                <th>عدد المصوتين</th>
                                <th>جيد جداً</th>
                                <th>جيد</th>
                                <th>متوسط</th>
                                <th>سىء</th>
                                <th>سىء جداً</th>
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
