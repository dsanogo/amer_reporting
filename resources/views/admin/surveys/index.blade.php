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
            <div class="col-md-12"><p class="text-center title-f1">نتائج استطلاعات الرأى خلال فترة</p></div>
            <form action="{{route('admin.getSurveysReport')}}" method="get">
                <div class="col-md-12">
                    <div class="col-md-8 col-sm-12 col-xs-12 tabel-input rtl pull-right">
                        <div class="col-md-6">
                                <div class="form-group">
                                        
                                    <label for="inputPassword" class="col-md-5 col-sm-4 control-label label-tabel">  الاستطلاعات</label>
                                    <select name="survey_id" id="" class="form-control">
                                        
                                        @foreach ($surveySubjects as $surveySubject)
                                        
                                            <option value="{{$surveySubject->Id}}" {{isset($_GET['survey_id']) && $_GET['survey_id']==$surveySubject->Id ? 'selected' : ''}}>{{ $surveySubject->Name}}</option>    
                                        @endforeach
                                    </select>                            
                                </div>
                        </div>
                        <div class="col-md-6">
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

            @if (isset($surveys) && count($surveys) == 0)
                <div class="col-md-12 rtl text-center alert alert-danger block-center" >
                    <h5>No Result found for this period</h5>
                </div>
            @endif
            

            @if (isset($surveys) && count($surveys) > 0)
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
                        {{-- <a href="{{route('admin.exportSurveysReport', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg">Excel</a> --}}
                        <a href="{{route('admin.pdfSurveysReport', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg" >PDF</a>
                        <a class="btn btn-primary btn-lg sendmail" >Send to mail</a>
                        <a href="{{route('admin.printSurveysReport', ['daterange' => $date_range])}}" class="btn btn-primary btn-lg printPage">Print</a>
                        {{-- Email form  --}}
                        <form class="form-inline emailForm" action="{{route('admin.pdfSurveysReport')}}" style="display: none">
                            <div class="form-group center-block" style="width:270px;margin: 10px 0;">
                                <input type="hidden" name="byMail" value="true">
                                <input type="hidden" name="daterange" value="{{$date_range}}">
                                <input type="email" style="width: 270px;height: 35px;" class="form-group form-control" id="email" name="email" placeholder="Enter email">
                            </div>
                            <button type="submit" style="font-size: 15px;padding: 3px 14px;height: 35px;border-radius: 0;" class="btn btn-sm btn-primary">Send</button>
                        </form>
                        {{-- End Emial Form --}}
                    </div>
                    <h3 class="text-center">{{$subject->Description}} :عدد المصوتين {{$totalSurveys}}</h3>
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                @foreach ($surveys as $survey)
                                    <th>{{$survey['evalName']}}</th>    
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($surveys as $surveys)
                                    <th>{{$survey['percentage']}}%</th>    
                                @endforeach
                            </tr>
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
