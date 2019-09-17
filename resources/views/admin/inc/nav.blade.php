<style>
 .dropdown-menu { text-align: right !important;}
</style>
<div class="nav-aamer">
    <div class="logo-amer col-md-2 col-sm-6 col-xs-6 pull-right"><img class="logo-f" src="{{asset('public/assets/img/logo-fafic.svg')}}" alt=""></div>
    <div class="col-md-4 col-sm-6 col-xs-6 pull-right">
        <p class="amaerf2">النظام الآلى لمتابعة خدمات آمر</p>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-8 left-sied">
        <div class="col-lg-5 col-md-7 col-sm-6 col-xs-6 dropdown p-l-30r text-left" > <a href="#" class="dropdown-toggle"
                data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img class="person hidden-sm hidden-xs" src="{{asset('public/assets/img/person-placeholder.png')}}" alt=""><span
                class="caret"></span>{{Session::get('user') !== null ? Session::get('user')->Name : 'Guest'}} </a>
            <ul class="dropdown-menu ">
                <li>
                    
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        Log out
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                        
                </li>

            </ul>
        </div>

        <div class="dropdown col-lg-6 col-md-5 col-sm-6 col-xs-6 text-left">
            <a class="sptop" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                aria-expanded="false"><span class="caret"></span>العربيه </a>
            <ul class="dropdown-menu ">
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
                <ul class="dropdown-menu dropdown-menusa fixaa text-right">
                  <li><a href="{{route('show.reportCategories')}}">المعاملات خلال فترة حسب نوع المعاملة</a></li>
                  <li><a href="{{route('admin.showInvovicesByDistrict')}}">المعاملات خلال فترة موزعة على المراكز</a></li>
                  <li><a href="{{route('admin.showMobileAndOfficeInvoices')}}">استخدام نظام المحمول للحصول على الخدمة</a></li>
                  <li><a href="{{route('show.reportSurveys')}}">نتائج استطلاعات الرأى خلال فترة</a></li>
                 
                </ul>
            </li>
            
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">احصائيات وقياس الاداء<span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-menusa fixaa text-right">
                    <li><a href="{{route('admin.offices.details.show')}}">احصائيات مقارنة انتاجية المراكز</a></li>
                    <li><a href="{{route('admin.monthlyInvoices.show')}}">التطور الزمني لانتاجية المراكز</a></li>
                    <li><a href="{{route('admin.offices.ProcessTimeDetails.show')}}">قياس اداء المراكز</a></li>
                    <li><a href="{{route('admin.monthlyInvoicesProcessTime.show')}}">التطور الزمني لاداء الكاتب</a></li>
                    
                </ul>
            </li> 
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">تقاير الذكاء الاصطناعي<span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menusa fixaa text-right">
                        <li><a href="{{route('admin.quarterlyInvoicesProcessTime')}}">ما هى المراكز التى يسوء أداؤها وتستدعى التدخل؟</a></li>
                        <li><a href="{{route('admin.getMobileAndOfficeInvoicesQuarterly')}}">هل اصدار المعاملات بالمراكز مفضل للمتعامل أم بنظام المحمول؟</a></li>
                        <li><a href="{{route('admin.invoices.getLastThreeYears')}}">ما هى مواسم زيادة وقلة أعداد المعاملات؟</a></li>
                    </ul>
            </li>
            <li><a href="{{route('admin.memos.index')}}"> التعميمات</a></li>
        </ul>
    </div>
</div>
