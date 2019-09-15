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
            <div class="col-md-12 rtl tabel" >
                <h4>استخدام نظام المحمول للحصول على الخدمة</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">المراكز</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">أعداد المعاملات من نظام المحمول</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">أعداد المعاملات بالمكاتب</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $key => $office)
                        <tr>
                            <td>{{ $office['office_name']}}</td>
                            <td>{{ $office['nb_mobile_invoices']}}</td>
                            <td>{{ $office['nb_office_invoices']}}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                
                    <tr id="trfoo">
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">الإجماليات</th>
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{ $total->sumMobileInvoices }}</th>
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{ $total->sumOfficeInvoices }}</th>
                    </tr>
                </table>
            </div>
        @endif
        <?php $mytime = Carbon\Carbon::now(); ?>
            <htmlpagefooter name="page-footer">
            <div class="col-md-12">
          <span  style="display:inline-block"> رقم الصفحة  {PAGENO}</span>
          <span   style="text-align: center!important;"> الوقت والتاريخ  {{$mytime}} </span>
          </div>
            </htmlpagefooter>
    </div>
   
@endsection
        

