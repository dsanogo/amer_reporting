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
            <div class="col-md-5 col-sm-12 col-xs-12 pull-right rtl tabel" >
                <h4>التطور الزمني لانتاجية المراكز</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">الشهر</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">عدد المعاملات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $month)
                        <tr>
                            <td>{{$month['month']}}</td>
                            <td>{{$month['nb_invoices']}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                
                    <tr id="trfoo">
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">الاجماليات</th>
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{$totalInvoices}}</th>
                        
                    </tr>
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
        

