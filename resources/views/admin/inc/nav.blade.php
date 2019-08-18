<style>
 .dropdown-menu { text-align: right !important;}
</style>
<div class="nav-aamer">
    <div class="logo-amer col-md-2 col-sm-6 col-xs-6 pull-right"><img class="logo-f" src="{{asset('public/assets/img/logo-fafic.svg')}}" alt=""></div>
    <div class="col-md-2 col-sm-6 col-xs-6 pull-right">
        <p class="amaerf2">اللوحه الرئيسية</p>
    </div>
    <div class="col-md-3 col-sm-4 col-xs-8 left-sied">
        <div class="col-md-5 col-sm-6 col-xs-6 dropdown p-l-30r" style=""> <a href="#" class="dropdown-toggle"
                data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span
                    class="caret"></span>احمد حسن </a>
            <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>

            </ul>
        </div>

        <div class="dropdown col-md-6 col-sm-6 col-xs-6">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                aria-expanded="false"><span class="caret"></span>العربيه </a>
            <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>

            </ul>
        </div>
    </div>
    <div class="navbar-header col-sm-6 col-xs-4" >
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <i class="fa fa-bars mobile" aria-hidden="true"></i>
        </button>

    </div>
</div>
<div class="collapse navbar-collapse p-d-0" id="bs-example-navbar-collapse-1">
    <div class="nav-aamer-p2">
        <ul class="nav-aamer-li">
            <li><a href="{{route('admin.index')}}"> اللوحه الرئيسيه</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">تقارير جدولية <span class="caret"></span></a>
                <ul class="dropdown-menu  fixaa text-right">
                  <li><a href="{{route('show.reportCategories')}}">المعاملات خلال فترة حسب نوع المعاملة</a></li>
                  <li><a href="{{route('admin.getInvoicesByOffices')}}">المعاملات خلال فترة موزعة على المكاتب</a></li>
                  <li><a href="{{route('admin.getMobileAndOfficeInvoices')}}">استخدام نظام المحمول للحصول على الخدمة</a></li>
                  <li><a href="{{route('admin.getSurveysReport')}}">نتائج استطلاعات الرأى خلال فترة</a></li>
                 
                </ul>
              </li>
          
              <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">احصائيات وقياس الاداء<span class="caret"></span></a>
                    <ul class="dropdown-menu  fixaa text-right">
                      <li><a href="{{route('admin.offices.details')}}">احصائيات مقارنة انتاجية المكاتب</a></li>
                      <li><a href="{{route('admin.monthlyInvoices')}}">التطور الزمني لانتاجية المكاتب</a></li>
                      <li><a href="{{route('admin.getMobileAndOfficeInvoices')}}">قياس اداء المكاتب</a></li>
                      <li><a href="{{route('admin.getSurveysReport')}}">التطور الزمني لاداء الكاتب</a></li>
                     
                    </ul>
                  </li>
            <li><a href="">تقاير الذكاء الاصطناعي</a></li>
        </ul>
    </div>
</div>
