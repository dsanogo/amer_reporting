<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title></title>

    <!-- Bootstrap -->
    <link href="{{asset('public/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/aamer.css')}}" rel="stylesheet">

    <link href="{{asset('public/assets/css/font-awesome.min.css')}}" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="{{asset('public/assets/js/9306c8c5d1.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/datatables.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('public/assets/css/daterangepicker.css')}}" />

    <script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
        <style>
        /* fallback */
                @font-face {
                font-family: 'Material Icons';
                font-style: normal;
                font-weight: 400;
                src: url("{{asset('public/assets/css/flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2')}}") format('woff2');
                }

                .material-icons {
                font-family: 'Material Icons';
                font-weight: normal;
                font-style: normal;
                font-size: 24px;
                line-height: 1;
                letter-spacing: normal;
                text-transform: none;
                display: inline-block;
                white-space: nowrap;
                word-wrap: normal;
                direction: ltr;
                -webkit-font-feature-settings: 'liga';
                -webkit-font-smoothing: antialiased;
                }
        </style>
    @yield('style')
</head>
