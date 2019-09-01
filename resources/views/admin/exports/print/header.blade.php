<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/aamer.css')}}" rel="stylesheet">
    
 <style>
 @media print {

    body {
  -webkit-print-color-adjust: exact !important;
}


    .nav-aamer{
        background-color: #251e54 !important;
    }
    .amaerf2{
        color: #ffffff!important ;
    }
}
</style>
</head>
<body>
    @if (isset($export) && $export == false)
    <div class="nav-aamer">
        <div class="logo-amer col-md-2 col-sm-6 col-xs-6 pull-right"><img class="logo-f" src="{{asset('public/assets/img/logo-fafic.svg')}}" alt=""></div>
        <div class="col-md-2 col-sm-6 col-xs-6 pull-right">
            <p class="amaerf2">نظام المتابعة والتحكم</p>
        </div>
    </div>
    @endif
    
@yield('content')

</body>
</html>