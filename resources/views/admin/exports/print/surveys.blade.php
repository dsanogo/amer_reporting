@extends('admin.exports.print.header')
@section('content')  
<style>
@page {
	header: page-header;
	footer: page-footer;
}
</style>    
    <div class="seciton-tabel">
            @if (isset($surveys))
            <h3 class="text-center">{{$subject->Description}} :عدد المصوتين - {{$totalSurveys}}</h3>
            <h4>نتائج استطلاعات الرأى خلال فترة</h4>
            <h4>فتره المعاملات: {{$daterange}}</h4>
            <div class="col-md-12 rtl tabel" >
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
    <?php $mytime = Carbon\Carbon::now(); ?>
            <htmlpagefooter name="page-footer">
            <div class="col-md-12">
          <span  style="display:inline-block"> رقم الصفحة  {PAGENO}</span>
          <span   style="text-align: center!important;"> الوقت والتاريخ  {{$mytime}} </span>
          </div>
            </htmlpagefooter>
@endsection
        

