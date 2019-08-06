@extends('admin.inc.main')
@section('style')
    <style>

        @media screen and (min-width: 320px) and (max-width: 479px)
        { 
            .amaerf2 {
                font-size: 12px;
                color: white;
                padding: 25px 0 5px 0;
                text-align: right;
                font-family: "Bahij";
            }
        }
    </style>
@endsection
@section('content')
    <body>
        <!-- section one-->
        
        <div class="seciton-tabel">
            <div class="row">
            <div class="col-md-8 col-sm-12 col-xs-12 tabel-input rtl pull-right">
                <div class="col-md-6">
                   
                            <div class="form-group">
                            <input type="password" class="form-control" id="inputPassword" placeholder="مصر">
                       
                        <label for="inputPassword" class="col-md-5 col-sm-4 control-label label-tabel">الجنسية</label>
                    </div>
                   
                   
                </div>
                <div class="col-md-6">
                  
                   
                                <div class="form-group">
                            <input type="text" id="daterange" name="daterange" class="form-control" id="inputPassword" placeholder="التاريخ">
                        
                        <label for="inputPassword"  class="col-md-5 col-sm-4 control-label label-tabel">فتره المعاملات</label>
                
                    </div>
                 
                </div>
            </div>
            <div class="col-md-4 tabel-button col-sm-12 col-xs-12">
                <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right">جلب البيانات </button>
                <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 pull-right">ارسال النتائج </button>

            </div>
        </div>
            <div class="col-md-12 rtl tabel" >
                <table class="table table-striped">
                    <thead class="waleed">
                        <tr>
                         
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                           
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                          
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                        
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
            
                            <tr id="trfoo">
                             
                                <th class="end">First Name</th>
                                <th class="end">Last Name</th>
                                <th class="end">Username</th>
                            </tr>
             
                </table>
            </div>
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'right'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>
@endsection
