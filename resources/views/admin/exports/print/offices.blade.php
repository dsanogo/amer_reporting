@extends('admin.exports.print.header')

@section('style')
@endsection
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
                <h4>المعاملات خلال فترة موزعة على المراكز</h4>
                <h4>المنطقة: {{$district->Name}}</h4>
                <h4>فتره المعاملات: {{$daterange}}</h4>
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">المراكز</th>
                            <th style="background-color: #383838 !important;color:#ffffff !important" class="ta-header">إجمالى أعداد فاتوره</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">إجمالى أعداد المعاملات</th>
                            <th style=" background-color: #383838 !important;color:#ffffff !important" class="ta-header">إجمالى الرسوم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                        <tr> 
                            <td>{{ $invoice['office_name']}}</td>
                            <td>{{ $invoice['n_invoices']}}</td>    
                            <td>{{ $invoice['n_serviceCount']}}</td>
                            <td>{{ $invoice['total_fees']}}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                
                    <tr id="trfoo">
                        <th style=" background-color: #c6c6c6 !important;color:black !important" class="end">الاجمالي</th>
                        <th style=" background-color: #c6c6c6 !important;color:black !important" class="end">{{ $total->totalInvoices }}</th>
                        <th style=" background-color: #c6c6c6 !important;color:black !important" class="end">{{ $total->totalInvoiceDatails }}</th>
                        <th style=" background-color: #c6c6c6 !important;color:black !important" class="end">{{ $total->totalFees }}</th>
                    </tr>
                </table>
            </div>
    
            <?php $mytime = Carbon\Carbon::now(); ?>
            <htmlpagefooter name="page-footer">
            <div class="col-md-12">
          <span  style="display:inline-block"> رقم الصفحة  {PAGENO}</span>
          <span   style="text-align: center!important;"> الوقت والتاريخ  {{$mytime}} </span>
          </div>
            </htmlpagefooter>
        
        @endif
    </div>
@endsection
        

