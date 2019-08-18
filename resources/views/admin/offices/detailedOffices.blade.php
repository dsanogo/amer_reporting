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
            <form action="{{route('admin.offices.details')}}" method="get">
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xs-12 tabel-input rtl pull-right">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword" class="col-md-5 col-sm-4 control-label label-tabel">المنطقة</label>
                                {{-- <input type="password" class="form-control" id="inputPassword" placeholder="مصر">\ --}}
                                <select name="office_id" id="" class="form-control" disabled>
                                    <option value="">Offices</option>
                                    @foreach ($data['offices'] as $office)
                                        <option value="{{$office->Id}}" {{isset($_GET['office_id']) && $_GET['office_id']==$office->Id ? 'selected' : ''}}>{{ $office->Name}}</option>    
                                    @endforeach
                                </select>                            
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="inputPassword"  class="col-md-5 col-sm-4 control-label label-tabel">فتره المعاملات</label>
                                <input type="text" id="daterange" name="daterange" value="{{isset($_GET['daterange']) ? $_GET['daterange'] : ''}}" class="form-control" id="inputPassword" placeholder="التاريخ">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 tabel-button col-sm-12 col-xs-12">
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right" type="submit">جلب البيانات </button>
                        <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 pull-right">ارسال النتائج </button>
                    </div>
                </div>
            </form>

            @if (isset($invoices))
                <div class="col-md-6 pull-right rtl tabel" >
                    <table class="table table-striped">
                        <thead class="waleed">
                            <tr>
                                <th>المكتب</th>
                                <th>عدد العاملين</th>
                                <th>عدد المعاملات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['offices'] as $key => $office)
                            <tr>
                                <td>{{ $office->Name }}</td>
                                <td>{{ count($office->employees)}}</td>
                                <td>{{ $invoices[$key]->count }}</td>   
                            </tr>
                            @endforeach
                            
                        </tbody>
                    
                        <tr id="trfoo">
                            <th class="end">الاجماليات</th>
                            <th class="end">{{$total->totalEmp}}</th>
                            <th class="end">{{$total->totalInvoices}}</th>
                            
                        </tr>
                    </table>
                </div>
            @endif
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
