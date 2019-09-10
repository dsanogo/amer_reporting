@extends('admin.inc.main')
@section('style')
<style>
    .form-group {
        position: relative;
    }

    .inputMaterial {
        font-size: 18px;
        display: block;
        padding: 0 18px 0 0 !important;
        border: 1px solid rgba(25, 25, 25, 0.32) !important;
        text-align: right;
        border-radius: 4px !important;
        -webkit-border-radius: 4px !important;
        -moz-border-radius: 4px !important;
        -ms-border-radius: 4px !important;
        -o-border-radius: 4px !important;
        margin-bottom: 0 !important;
        height: 40px !important;
        line-height: 40px;
        width: 100%;
    }

    .form {
        margin-top: 30px;
    }

    .check {
        display: inline-block;
        margin: 0 5px;
    }
</style>



@endsection
@section('content')

<div class="content-wrapper content-wrapper-home">
    @include('admin.inc.flash-message')
    <div class="container-fluid">
        <div class="navbar-table-top d-flex">

        </div>
    </div>
    <div class="row">
        <div class="col-md-6 pull-right">
            <form action="{{ route('admin.memos.post.create') }}" method="POST" class="form" id="create-form"
                enctype="multipart/form-data">
                @csrf
                @include('admin.memos.form')
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
            
    });
</script>
@endsection