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
                            <p class="user-f2s"><span>{{ $data['employees']}}</span>موظف </p>
                        </div>

                        <div class="section-f3s">
                            <i class="material-icons  receipt "> receipt </i>
                            <p class="user-f1">اجمالي المعاملات</p>
                            <p class="user-f2"><span class="color2">{{ $data['numberOfInvoices']}}</span>معاملة </p>
                        </div>

                        <div class="section-f3s">
                            <i class="material-icons wallet">account_balance_wallet</i>
                            <p class="user-f1">اجمالي المبالغ المحصلة</p>
                            <p class="user-f2"><span class="color3">{{ $data['totalFees']}}</span>درهم </p>
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

                                @foreach ($data['offices'] as $key => $office)
                                    <tr>
                                    <td>{{ $office->Name }}</td>
                                    <td>{{ count($office->employees)}}</td>
                                    <td>{{ $invoices[$key]->count }}</td>    
                                    <td>{{ $invoices[$key]->totalFees }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="Allthumbnail" class="col-md-12 " style="display:none; ">
                        @foreach ($data['offices'] as $key => $office)
                            <div class="col-xs-6 col-sm-4 col-md-2 rtl pull-right">
                                <div class="thumbnail-header">
                                    <p class="title-inthumbnail">{{ $office->Name }}</p>
                                </div>
                                <div href="#" class="thumbnail">
                                    <p class="f1"><i class="fas fa-user-friends "></i>{{ count($office->employees)}}</p>
                                    <p class="f1"><i class="fas fa-user-friends "></i>{{ $invoices[$key]->count }}</p>
                                    <p class="f1"><i class="fas fa-user-friends "></i> {{ $invoices[$key]->totalFees }}</p>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                    <div class="map-amaer" style="display:none">
                        <div class="col-md-12 col-sm-12 col-sm-12">
                            <input class="aamer-input col-md-2" type="text" placeholder="بحث">
                        </div>
                        <div class="col-md-10 col-sm-12 col-sm-12 map-amaer-s1">
                         <div id="map-wa" class="map" style="height: 500px;"></div>

                        </div>
                        <div class="col-md-2 loclitons col-sm-12 col-sm-12 " style="overflow-y: scroll;">
                                @foreach ($data['offices'] as $key => $office)
                            <div class="locliton col-md-12" >
                                <i class="material-icons col-md-2 pull-right p-d-0 location_on">location_on </i>
                                <div class="col-md-10 pull-right p-d-0 loc-s">
                                    <p class="C-1"> {{ $office->Name }}</p>
                                    <p class="C-2">اجمالي المبالغ المحصلة</p>
                                    <p class="C-3"> د.ر{{ $invoices[$key]->totalFees }}</p>
                                </div>
                            </div>
                           @endforeach
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
@section('script')
<script>
   $(document).ready(function () {
        var url = "{{route('admin.getInvoicesPerMonth')}}";
        var maxFees = 0;
        var maxInvoices = 0;
        var FeesMonths = [];
        var FeesAmount = [];
        var invoiceMonths = [];
        var invoiceCounts = [];
        var allMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    
        $.get(url, function(response) {
            
            maxFees = parseInt(response.maxFees.max_fees);
            maxInvoices = parseInt(response.maxInvoices.max_invoices);

            response.totalFeesPerMonth.forEach(function(data) {
                FeesAmount.push(data.total_fees);
                FeesMonths.push(data.month);
            });

            response.totalInvoicesPerMonth.forEach(function(data) {
                invoiceMonths.push(data.month);
                invoiceCounts.push(data.total_invoices);
            });

        var ctx = document.getElementById('myChart').getContext('2d');
      
      var chart = new Chart(ctx, {
          // The type of chart we want to create
          type: 'bar',
      
          // The data for our dataset
          data: {
              labels: allMonths,
              datasets: [{
                  label: 'عدد المعاملات',
                  backgroundColor: 'rgb(46, 148, 94)',
                  borderWidth: 1,
                  data: [
                        invoiceMonths.includes("1") ? invoiceCounts[invoiceMonths.indexOf("1")] : 0, 
                        invoiceMonths.includes("2") ? invoiceCounts[invoiceMonths.indexOf("2")] : 0, 
                        invoiceMonths.includes("3") ? invoiceCounts[invoiceMonths.indexOf("3")] : 0, 
                        invoiceMonths.includes("4") ? invoiceCounts[invoiceMonths.indexOf("4")] : 0, 
                        invoiceMonths.includes("5") ? invoiceCounts[invoiceMonths.indexOf("5")] : 0, 
                        invoiceMonths.includes("6") ? invoiceCounts[invoiceMonths.indexOf("6")] : 0, 
                        invoiceMonths.includes("7") ? invoiceCounts[invoiceMonths.indexOf("7")] : 0, 
                        invoiceMonths.includes("8") ? invoiceCounts[invoiceMonths.indexOf("8")] : 0, 
                        invoiceMonths.includes("9") ? invoiceCounts[invoiceMonths.indexOf("9")] : 0, 
                        invoiceMonths.includes("10") ? invoiceCounts[invoiceMonths.indexOf("10")] : 0, 
                        invoiceMonths.includes("11") ? invoiceCounts[invoiceMonths.indexOf("11")] : 0, 
                        invoiceMonths.includes("12") ? invoiceCounts[invoiceMonths.indexOf("12")] : 0, 
                  ],
                  yAxisID: 'invoiceCounts'
              },
              {
                  label: 'قيمه المبالغ المحصله',
                  data: [
                        FeesMonths.includes("1") ? FeesAmount[FeesMonths.indexOf("1")] : 0, 
                        FeesMonths.includes("2") ? FeesAmount[FeesMonths.indexOf("2")] : 0, 
                        FeesMonths.includes("3") ? FeesAmount[FeesMonths.indexOf("3")] : 0, 
                        FeesMonths.includes("4") ? FeesAmount[FeesMonths.indexOf("4")] : 0, 
                        FeesMonths.includes("5") ? FeesAmount[FeesMonths.indexOf("5")] : 0, 
                        FeesMonths.includes("6") ? FeesAmount[FeesMonths.indexOf("6")] : 0, 
                        FeesMonths.includes("7") ? FeesAmount[FeesMonths.indexOf("7")] : 0, 
                        FeesMonths.includes("8") ? FeesAmount[FeesMonths.indexOf("8")] : 0, 
                        FeesMonths.includes("9") ? FeesAmount[FeesMonths.indexOf("9")] : 0, 
                        FeesMonths.includes("10") ? FeesAmount[FeesMonths.indexOf("10")] : 0, 
                        FeesMonths.includes("11") ? FeesAmount[FeesMonths.indexOf("11")] : 0, 
                        FeesMonths.includes("12") ? FeesAmount[FeesMonths.indexOf("12")] : 0, 
                    ],             
                  yAxisID: 'FeesAmount',
                  backgroundColor: 'rgba(4, 0, 255, 0.05)',
                  borderWidth: 2,
                  pointBorderColor: 'rgb(46, 93, 247)',
                  pointBackgroundColor: 'rgb(255, 255, 255)',
           
                  borderColor: 'rgb(46, 93, 247)',
                  // Changes this dataset to become a line
                  type: 'line'
              }],
              labels: allMonths,
          },
      
          // Configuration options go here
          options: {
              scales: {
                  yAxes: [{
                    id: 'FeesAmount',
                      stacked: true,
                      position: 'right',
                      gridLines: {
                        drawBorder: false
                      },
                      ticks: {
                          beginAtZero: true,
                          steps: 10,
                          stepValue: 10,
                          max:  maxFees + 1000,
                           stepSize: 10000,
                           fontColor: "#2e5bff",
                           callback: function(label, index, labels) {
                               if(maxFees < 100){
                                    return label;
                               }else if(maxFees > 1000) {
                                    return label/1000+'k';
                               }
                                
                            }
                      },
                          
                  },
                  { 
                    id: 'invoiceCounts',
                    stacked: true,
                    position: 'left',
                    gridLines: {
                    drawBorder: false
                    },
                    ticks: {
                        beginAtZero: true,
                        steps: 10,
                        stepValue: 10,
                        max: maxInvoices + 10,
                        stepSize: 2,
                        fontColor: "#2e9658",
                        callback: function(label, index, labels) {
                               if(maxInvoices < 100){
                                    return label;
                               }else if(maxInvoices > 1000) {
                                    return label/1000+'k';
                               }
                                
                            }
                      },
                          
                  }],
              
              xAxes: [{
                  ticks: {
                      fontFamily: "Bahij",
                      fontColor: "#bbc3d0",
                      fontSize: 14,
                      stepSize: 1,
                      beginAtZero: true,
                      maxRotation: 45,
                      minRotation: 45
                  },
                  barPercentage: 0.8,
                  
                  maxBarThickness: 30,
                  minBarLength: 2
                 
              }]
      
              },
              legend: {
                  
                  labels: {
                      // This more specific font property overrides the global property
                      fontColor: 'rgb(46, 148, 94)',
                      fontFamily: "Bahij",
                      radius:5
                  }
              }
          }
      });

    });        
});
</script>

@endsection