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
                <h4>التطور الزمني لاداء المراكز</h4>
                <h4>المنطقة: {{$district->Name}}</h4>
                <h4>فتره المعاملات: {{$daterange}}</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">الشهر</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">متوسط زمن المعاملة بالدقيقة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->month . ' ' . $invoice->year }}</td>
                            <td>{{ $invoice->process_time }}</td>   
                        </tr>
                        @endforeach
                        
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
        

