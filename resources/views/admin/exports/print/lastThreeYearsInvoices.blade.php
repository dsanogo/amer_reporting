@extends('admin.exports.print.header')
@section('content')
<style>
@page {
	header: page-header;
	footer: page-footer;
}
</style>  
    <div class="seciton-tabel">
        @if ($data)
            <h4 style="text-align: right; padding: 0px !important;width: 100%">مواسم زيادة وقلة أعداد المعاملات</h4>
                <p  class="text-right title-f1">تزيد المعاملات خلال شهور:
                    @foreach ($trendMonths as $item)
                        {{$item . ' '}}
                    @endforeach
                </p>
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
                        @foreach ($data as $key => $invoice)
                            <tr style="color:{{isset($invoice['flag']) && $invoice['flag']=='green' ? '#ffffff !important' : ''}} ;background: {{isset($invoice['flag']) && $invoice['flag']=='green' ? '#008000 !important' : ''}}">
                                <td style="color:{{isset($invoice['flag']) && $invoice['flag']=='green' ? '#ffffff !important' : ''}} ;background: {{isset($invoice['flag']) && $invoice['flag']=='green' ? '#008000 !important' : ''}}">{{$data[$key][0]['month']}}</td>   
                                <td style="color:{{isset($invoice['flag']) && $invoice['flag']=='green' ? '#ffffff !important' : ''}} ;background: {{isset($invoice['flag']) && $invoice['flag']=='green' ? '#008000 !important' : ''}}">{{$data[$key][0]['invoice']}}</td>
                                <td style="color:{{isset($invoice['flag']) && $invoice['flag']=='green' ? '#ffffff !important' : ''}} ;background: {{isset($invoice['flag']) && $invoice['flag']=='green' ? '#008000 !important' : ''}}">{{$data[$key][1]['invoice']}}</td>    
                                <td style="color:{{isset($invoice['flag']) && $invoice['flag']=='green' ? '#ffffff !important' : ''}} ;background: {{isset($invoice['flag']) && $invoice['flag']=='green' ? '#008000 !important' : ''}}">{{$data[$key][2]['invoice']}}</td> 
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
    <?php $mytime = Carbon\Carbon::now(); ?>
            <htmlpagefooter name="page-footer">
            <div class="col-md-12">
          <span  style="display:inline-block"> رقم الصفحة  {PAGENO}</span>
          <span   style="text-align: center!important;"> الوقت والتاريخ  {{$mytime}} </span>
          </div>
            </htmlpagefooter>
@endsection
        

