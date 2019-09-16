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

    #memos-form .dropdown {
        z-index: 1000000;
    }

    #memos-form .dropdown a {
        color: black;
        font-size: 18px;
        font-weight: initial;
    }

    #memos-form .dropdown dd,
    #memos-form .dropdown dt {
        margin: 0px;
        padding: 0px;
    }

    #memos-form .dropdown ul {
        margin: -1px 0 0 0;
    }

    #memos-form .dropdown dd {
        position: relative;
    }

    #memos-form .dropdown a,
    #memos-form .dropdown a:visited {
        text-decoration: none;
        outline: none;
    }

    #memos-form .dropdown dt a {
        cursor: pointer;
        background-color: rgb(221, 221, 221);
        display: block;
        padding: 0 18px 0 0;
        min-height: 40px;
        line-height: 24px;
        overflow: hidden;
        border: 1px solid rgba(25, 25, 25, 0.32);
        border-radius: 5px;
    }

    #memos-form .dropdown dt a span,
    .multiSel span {
        cursor: pointer;
        display: inline-block;
        padding: 7px 3px 2px 0;
    }

    #memos-form .dropdown dd ul {
        background-color: rgb(221, 221, 221);
        border: 1px solid rgba(25, 25, 25, 0.32);
        color: black;
        display: none;
        padding: 2px 15px 2px 5px;
        position: absolute;
        top: 2px;
        width: 500px;
        list-style: none;
        height: 300px;
        overflow: auto;
    }

    #memos-form .dropdown span.value {
        display: none;
    }

    #memos-form .dropdown dd ul li a {
        padding: 5px;
        display: block;
    }

    #memos-form .dropdown dd ul li span {
        padding: 0 10px 0 10px;
        font-size: 18px;
    }

    #memos-form .dropdown dd ul li a:hover {
        background-color: #fff;
    }

    #memos-form .dropdown button {
        background-color: #6BBE92;
        width: 302px;
        border: 0;
        padding: 10px 0;
        margin: 5px 0;
        text-align: center;
        color: #fff;
        font-weight: bold;
    }

    .is-invalid label,
    .invalid-feedback {
        color: red;
    }

    .daterangepicker {
        z-index: 1000000;
    }

    .add-btn {
        height: 40px;
        border-radius: 7px;
        background-color: #3c763d;
        border: none;
        font-size: 17px;
        margin: 0 5px 0 5px;
    }

    .input-group-btn:last-child>.btn {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-top-left-radius: 7 !important;
        border-bottom-left-radius: 7 !important;
    }

    .input-group-btn:last-child>.btn {
        margin-right: -1px;
    }

    div.gallery {
        margin: 5px;
        border: 1px solid #ccc;
        float: left;
        width: 180px;
    }

    div.gallery:hover {
        border: 1px solid #777;
    }

    div.gallery img {
        width: 100%;
        height: auto;
    }

    div.desc {
        padding: 15px;
        text-align: center;
    }
    .btn-danger{
        margin-right: 10px !important;
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
    <div class="col-md-12">
        <div class="col-md-3 pull-right"></div>
        <div class="col-md-6 pull-right">
            <form id="memos-form" action="{{ route('admin.memos.post.edit') }}" method="POST" class="form"
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
        /*
        Dropdown with Multiple checkbox select with jQuery - May 27, 2013
        (c) 2013 @ElmahdiMahmoud
        license: https://www.opensource.org/licenses/mit-license.php
        2019-09-14
        */
        // $('.input-group.date').datepicker({format: "yyyy-mm-dd"}); 

        $('input[name="Time"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2019,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });


        $(".btn-success").click(function(){ 

        var lsthmtl = $(".clone").html();

        $(".increment").after(lsthmtl);

        });

        $("body #memos-form").on("click",".btn-danger",function(){ 
            $(this).parents().eq(0).prev().attr('name', '');
            $(this).parents().eq(0).parent().remove();
        });

        var currenttitle = $(".hida").text();

        $(".dropdown dt a").on('click', function() {
            $(".dropdown dd ul").slideToggle('fast');
        });

        $(".dropdown dd ul li a").on('click', function() {
            $(".dropdown dd ul").hide();
        });

        function getSelectedValue(id) {
            return $("#" + id).find("dt a span.value").html();
        }

        $(document).bind('click', function(e) {
            var $clicked = $(e.target);
            if (!$clicked.parents().hasClass("dropdown")) $(".dropdown dd ul").hide();
        });

        $("#select-all").click(function(){
            $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
        });

        $('.mutliSelect input[type="checkbox"]').on('click', function() {

            var title = $(this).next().text() + ",";

            if ($(this).is(':checked')) {
                var html = '<span title="' + title + '">' + title + '</span>';
                $('.multiSel').show();
                $('.multiSel').append(html);
                $(".hida").hide();
            } else {
                $('span[title="' + title + '"]').remove();
                var ret = $(".hida");
                $('.dropdown dt a').append(ret);
            }

            if ($("#memos-form input:checkbox:checked").length < 1)
            {
                $(".hida").text(currenttitle);
                $(".hida").show();
                $('.multiSel').hide();
            }
    
        });
    });
</script>
@endsection