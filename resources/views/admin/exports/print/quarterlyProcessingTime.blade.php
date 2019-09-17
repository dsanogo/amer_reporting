@extends('admin.exports.print.header')
@section('content')    
<style>
@page {
	header: page-header;
	footer: page-footer;
}
</style>  
    <div class="seciton-tabel">
        @if (isset($invoices))
            <h4 style="text-align: right">بناءاً على أداء آخر 3 شهور،المراكز الموضحة فى الجدول أسفله يسوء أداؤها</h4>

            <table class="table table-responsive table-striped" >
                    <tr>
                        <td rowspan="2" style="padding: 30px;background-color: #383838 !important;color:#ffffff !important" class="bordered">المراكز</td>
                        <td colspan="{{count($months)}}" class="bordered" style=" background-color: #383838 !important;color:#ffffff !important;padding: 10px !important">متوسط زمن المعاملة</td>
                    </tr>
                    <tr>
                        @foreach ($months as $month)
                            <td class="bordered" style=" background-color: #383838 !important;color:#ffffff !important; padding: 10px !important" >{{$month['name']}}</td>
                        @endforeach
                    </tr>
                    <?php 
                        $count = 0;
                    ?>
                    @foreach ($invoices as $key => $invoice)
                        @if (isset($invoice['flag']) && $invoice['flag'] == 'red')
                            <tr style="background: {{isset($invoice['flag']) && $invoice['flag']=='red' ? 'red' : ''}}">
                                <td>{{$invoices[$key][0]['office_name']}}</td>   
                                <td>{{$invoices[$key][0]['procTime']}}</td>   
                                <td>{{$invoices[$key][1]['procTime']}}</td>    
                                <td>{{$invoices[$key][2]['procTime']}}</td> 
                            </tr>
                        <?php $count +=1;?>
                    @endif
                    @endforeach
                </table>
            @if ($count == 0)
                <div class="col-md-12 alert alert-info">
                    <p class="text-center">لا يوجد مراكز تسواء</p>
                </div>
            @endif
        </div>
        @endif
        <?php $mytime = Carbon\Carbon::now(); ?>
            <htmlpagefooter name="page-footer">
            <div class="col-md-12">
          <span  style="display:inline-block"> رقم الصفحة  {PAGENO}</span>
          <span   style="text-align: center!important;"> الوقت والتاريخ  {{$mytime}} </span>
          </div>
            </htmlpagefooter>
@endsection
        

