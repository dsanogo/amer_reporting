@extends('admin.inc.main')
@section('style')
<style>
    .pagination {
        display: inline-block;
        padding-left: 0;
        margin: 20px 0;
        border-radius: 4px;
        display: flex;
    }
    input[type=search]{
        -moz-appearance: none;/* older firefox */
        -webkit-appearance: none; /* safari, chrome, edge and ie mobile */
        appearance: none; /* rest */
        /* border:2px solid black; */
        width: 300px;
        }
    div.dataTables_wrapper div.dataTables_filter input {
        margin-left: 0.5em;
        display: inline-block;
       
        height: 45px;
        width: 300px;
        
    }
    div.dataTables_wrapper div.dataTables_filter label {
        font-weight: normal;
        white-space: nowrap;
        text-align: left;
        padding-right: 40px;
    }
</style>
@endsection
@section('content')

<body>
    <div class="seciton-tabel">

        <div class="col-md-12">
                @include('admin.inc.flash-message')
            <div class="col-md-4 tabel-button col-sm-12 col-xs-12 pull-right">
            <a href="{{ route('admin.memos.get.create') }}" class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right" style='padding-top: 11px;'>اضافة تعميم جديد</a>
            </div>
            <div class="col-md-12 rtl tabel">
                <table id="menos-datatables" class="table table-striped nowrap" style="width:100%">
                    <thead class="waleed">
                        <tr>
                            <th>رقم التعميم</th>
                            <th>تاريخ التعميم</th>
                            <th>النوع</th>
                            <th>صادر من</th>
                            <th>نص التعميم</th>
                            <th>الاجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-content">
                    </tbody>
                    <tfoot class="thead-dark">
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="dt-head-center"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</body>
@endsection

@section('script')
<script>
    $(document).ready(function () {
            let table = $('#menos-datatables').DataTable({
                
                "language": {
                    "search": "البحث: ",
                    "searchPlaceholder": "البحث",
                    "paginate": {
                        "previous": "السابق",
                        "next": "التالي",
                        "first": "الاول",
                        "last": "الاخير",
                    }
                    
                },
                'scrollX':true,
                'scrollCollapse':true,
                'processing': true,
                'serverSide': true,
                'responsive': {'details': false},
                'sPaginationType': 'full_numbers',
                'ajax': {
                    'url': 'memos/ajax',
                    'type': 'POST',
                    'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                },
                'columns': [
                    {'data': 'Number'},
                    {'data': 'Time'},
                    {'data': 'MemoTypesDescription'},
                    {'data': 'SupervisingOrgsDescription'},
                    {'data': 'Brief'},
                ],
                'columnDefs': [
                    {"width": "5%", "targets": 0},
                    {"width": "10%", "targets": 1},
                    {"width": "10%", "targets": 2},
                    {"width": "8%", "targets": -1},
                    {
                        'targets': 0,
                        'render': function (data, type, row) {
                            // console.log(row);
                            if (row.Number === null) return 'لايوجد';
                            return row.Number;
                        }
                    },
                    {
                        'targets': 1,
                        'render': function (data, type, row) {
                            // console.log(row);
                            if (row.Time === null) return 'لايوجد';
                            let str = row.Time.split(" ");;
                            return str[0];
                        }
                    },
                    {
                        'targets': 2,
                        'render': function (data, type, row) {
                            //console.log(data);
                            if (row.MemoTypesDescription === null) return 'لايوجد';
                            let str = row.MemoTypesDescription;
                            if (str.length > 20) str = str.slice(0, 20) + ' ...';
                            return str;
                        }
                    },
                    {
                        'targets': 3,
                        'render': function (data, type, row) {
                            //console.log(data);
                            if (row.SupervisingOrgsDescription === null) return 'لايوجد';
                            let str = row.SupervisingOrgsDescription;
                            if (str.length > 20) str = str.slice(0, 20) + ' ...';
                            return str;
                        }
                    },
                    {
                        'targets': 4,
                        'render': function (data, type, row) {
                            //console.log(data);
                            if (row.Brief === null) return 'لايوجد';
                            let str = row.Brief;
                            if (str.length > 180) str = str.slice(0, 180) + ' ...';
                            return str;
                        }
                    },
                    {
                        'targets': 5,
                        'data': null,
                        'className': 'dt-body-center',
                        "orderable": false,
                        'render': function (data, type, row) {
                            let name = row.Number === null ? 'لايوجد' : row.Number;
                            let html = '';
                            html += '<a class="edit" href="{!! URL::to("/admin/memo/edit") !!}/' + row.Id + '"> <i class="material-icons edit-row">edit</i> </a>';
                            return html;
                        }
                    },
                    {
                        "targets": 'no-sort',
                        "orderable": false
                    },
                ],
            });
        });
</script>
@endsection