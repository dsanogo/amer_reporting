@extends('admin.inc.main')
@section('style')
<style>

</style>
@endsection
@section('content')
<div class="content-wrapper content-wrapper-home">
    <div class="container-fluid">
        <div class="navbar-table-top d-flex">
            <div class="col Employees">تعميم جديد </div>
        </div>
        <div class="col-md-12 border">
            <div class="col Employees">
                <font color="red">*</font> حقول يجب ان تكون صحيحة
            </div>
            <form action="{{ route('admin.memos.post.create') }}" method="POST" id="create-form"
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