@if ($message = Session::get('success'))
    <div class="container-fluid">
        <div class="col-md-12 alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    </div>
@endif


@if ($message = Session::get('error'))
    <div class="container-fluid">
        <div class="col-md-12 alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    </div>
@endif


@if ($message = Session::get('warning'))
    <div class="container-fluid">
        <div class="col-md-12 alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    </div>
@endif


@if ($message = Session::get('info'))
    <div class="container-fluid">
        <div class="col-md-12 alert alert-info alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
    </div>
@endif

@if (session('status'))
    <div class="container-fluid">
        <div class="col-md-12 alert alert-info alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ session('status') }}</strong>
        </div>
    </div>
@endif

@if ($errors->any())
    <div class="col-md-12 alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        Please check the form below for errors
    </div>
@endif

