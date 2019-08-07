@extends('admin.inc.main')
@section('content')
<style>
.gm-style-iw{
    max-width: 300px !important;
    max-height: 308px;
}</style>
<body>
    <div class="container col-md-12 p-d-0 col-sm-12 col-xs-12">
        <!-- section one-->
        <div class="section-one">
            <div class="section-a">
                <div class="section-f1">
                    <i class="material-icons bar_chart">bar_chart</i>
                    <p class="section-2ts">احصائيات عامه</p>
                </div>
                <div class="border">
                    <div class="col-md-8 p-d-0" style="margin-top: 20px;padding-left: 25px;">
                        <canvas id="myChart" height="40" width="100%"></canvas>
                    </div>
                    <div class="col-md-4 section-f2 p-d-0">
                        <div class="section-f3s">
                            <i class="fas fa-user-friends user"></i>
                            <p class="user-f1s">اجمالي عدد العاملين</p>
                            <p class="user-f2s"><span>1400</span>موظف </p>
                        </div>

                        <div class="section-f3s">
                            <i class="material-icons  receipt "> receipt </i>
                            <p class="user-f1">اجمالي المعاملات</p>
                            <p class="user-f2"><span class="color2">21,235,366</span>معاملة </p>
                        </div>

                        <div class="section-f3s">
                            <i class="material-icons wallet">account_balance_wallet</i>
                            <p class="user-f1">اجمالي المبالغ المحصلة</p>
                            <p class="user-f2"><span class="color3">1,698,826,880.00</span>درهم </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- section two-->
        <div class="section-two">
            <div class="section-a">
                <div class="section-f1 section-f1s" style="padding-top:5px">
                    <i class="material-icons domain">domain</i>
                    <p class="section-2ts">قائمه المركز</p>
                    <span class="section-2t pull-left circal">12 </span>
                    <p id="map" class="section-2t pull-left"><i class="material-icons public"> public</i>عرض عل الخريطة
                    </p>
                    <p id="net" class="section-2t pull-left"><i class="material-icons view_module">view_module</i>عرض
                        شبكي </p>
                    <p id="tabel" class="section-2t pull-left active"> <i class="material-icons list"> list</i>عرض
                        القوائم </p>

                </div>
                <div class="border border-h">

                    <div class="table-responsive col-md-12 col-sm-12 col-sm-12 left">
                        <div class="col-md-12">
                            <input class="aamer-input col-md-2" type="text" placeholder="بحث">
                        </div>
                        <table class="table table-bordered table-striped" id="">
                            <thead>
                                <tr>
                                    <th>اسم المركز</th>
                                    <th>عدد العاملين</th>
                                    <th>عدد المعاملات</th>
                                    <th>اجمالي المبالغ</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>
                                <tr>

                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>
                                <tr>

                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>
                                <tr>

                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>
                                <tr>

                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>
                                <tr>

                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>
                                <tr>

                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>
                                <tr>

                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>
                                <tr>

                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>
                                <tr>

                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>
                                <tr>

                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>
                                <tr>

                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>
                                    <td>Table cell</td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div id="Allthumbnail" class="col-md-12" style="display:none ">
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-4 col-md-2 rtl">
                            <div class="thumbnail-header">
                                <p class="title-inthumbnail">الدايره</p>
                            </div>
                            <div href="#" class="thumbnail">
                                <p class="f1"><i class="fas fa-user-friends "></i>11</p>
                                <p class="f1"><i class="fas fa-user-friends "></i>160.125</p>
                                <p class="f1"><i class="fas fa-user-friends "></i> 12,154,151,123</p>
                            </div>
                        </div>
                    </div>
                    <div class="map-amaer" style="display:none">
                        <div class="col-md-12 col-sm-12 col-sm-12">
                            <input class="aamer-input col-md-2" type="text" placeholder="بحث">
                        </div>
                        <div class="col-md-10 col-sm-12 col-sm-12 map-amaer-s1">
                         <div id="map-wa" class="map" style="height: 500px;"></div>

                        </div>
                        <div class="col-md-2 loclitons col-sm-12 col-sm-12">
                            <div class="locliton col-md-12">
                                <i class="material-icons col-md-2 pull-right p-d-0 location_on">location_on </i>
                                <div class="col-md-10 pull-right p-d-0 loc-s">
                                    <p class="C-1"> الديره 1</p>
                                    <p class="C-2">اجمالي المبالغ المحصلة</p>
                                    <p class="C-3"> د.ر12,810,000.00</p>
                                </div>
                            </div>
                            <div class="locliton col-md-12">
                                <i class="material-icons col-md-2 pull-right p-d-0 location_on">location_on </i>
                                <div class="col-md-10 pull-right p-d-0 loc-s">
                                    <p class="C-1"> الديره 1</p>
                                    <p class="C-2">اجمالي المبالغ المحصلة</p>
                                    <p class="C-3"> د.ر12,810,000.00</p>
                                </div>
                            </div>
                            <div class="locliton col-md-12">
                                <i class="material-icons col-md-2 pull-right p-d-0 location_on">location_on </i>
                                <div class="col-md-10 pull-right p-d-0 loc-s">
                                    <p class="C-1"> الديره 1</p>
                                    <p class="C-2">اجمالي المبالغ المحصلة</p>
                                    <p class="C-3"> د.ر12,810,000.00</p>
                                </div>
                            </div>
                            <div class="locliton col-md-12">
                                <i class="material-icons col-md-2 pull-right p-d-0 location_on">location_on </i>
                                <div class="col-md-10 pull-right p-d-0 loc-s">
                                    <p class="C-1"> الديره 1</p>
                                    <p class="C-2">اجمالي المبالغ المحصلة</p>
                                    <p class="C-3"> د.ر12,810,000.00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- section there-->
                  <script>
        function initMap() {
                var contentString = 
                '<div class="container-map">' + 
                '<h2 class="title-Abou-El-Ghaly titea">  الدايره</h2>' + 
                    '<h2 class="title-Abou-El-Ghaly">  11<i class="fas fa-user-friends sc"></i></h2>' + 
                    '<p class="p-title-1">160.125    <i class="material-icons sx"> receipt </i></p>' +
                    '<p class="p-title-2"> 12,810,000,000 <i class="material-icons sf">account_balance_wallet</i></p>' +
                    '<h3 class="Waste"> <button class="btn btn-wa col-md-12">المزيد</button></h3>' +
   
                '</div>';
                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });
                var myLatLng = {lat: 29.9833135, lng: 31.3168272};
                var map = new google.maps.Map(document.getElementById('map-wa'), {
                    zoom: 13.79,
                    center: myLatLng
                });
                var marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: 'Unicom group'
                });
                marker.addListener("click", function () {
                    infowindow.open(map, marker);
                })
            }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=&callback=initMap"
    async defer></script> 
@endsection