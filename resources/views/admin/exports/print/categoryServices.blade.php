@extends('admin.exports.print.header')
@section('style')
<style type="text/css">

    @page {
        header: page-header;
        footer: page-footer;
    }

    htmlpageheader {
        height: 100px !important;
    }

    body {
        direction: rtl;
        -webkit-print-color-adjust: exact !important;
    }

    #print-report table, th, td {
        border: #4b5257 solid 1px;
    }

    table, th, td{
        border: none;
        color: black;
        border-collapse: collapse;
        text-align: center;
    }

    table thead td {
        background-color: #4b5257 !important;
        color: white;
        text-align: center;
        font-weight: 700;
        font-size: 17px;
        padding: 10px;
    }
    .ta-header{
        background-color: #4b5257 !important;
        color: white !important;
        text-align: center;
        font-weight: 700;
        font-size: 17px;
        padding: 10px;

    }
   

</style>
<style>
@page {
	header: page-header;
	footer: page-footer;
}
</style>  
@endsection
@section('content')    
    <div class="seciton-tabel">
        @if (isset($invoices))
            <div class="col-md-12 rtl " >
                <h4>المعاملات خلال فترة حسب نوع المعاملة</h4>
                <h4>نوع المعاملة: {{$category->Name}}</h4>
                <h4>فتره المعاملات: {{$daterange}}</h4>
                <table class="table">
                    <thead class="waleed">
                        <tr>
                            <th style="background-color: #4b5257 !important;color:#ffffff !important">نوع المعاملة</th>
                            <th style="background-color: #4b5257 !important;color:#ffffff !important">إجمالى أعداد المعاملات</th>
                            <th style="background-color: #4b5257 !important;color:#ffffff !important">إجمالى الرسوم</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $service)
                        <tr>
                            <td>{{ $service['service_name']}}</td>
                            <td>{{ $service['count_invoices']}}</td>
                            <td>{{ $service['totalFees'] }}</td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                
                    <tr id="trfoo">
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">الإجماليات</th>
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{ $total->totalInvoices }}</th>
                        <th class="end" style=" background-color: #c6c6c6 !important;color:black !important">{{ $total->totalFees }}</th>
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
        

