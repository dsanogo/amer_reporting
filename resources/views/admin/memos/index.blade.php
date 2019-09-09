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
</style>
@endsection
@section('content')

<body>
    <div class="seciton-tabel">

        <div class="col-md-12">
            <div class="col-md-4 tabel-button col-sm-12 col-xs-12 pull-right">
                <button class="col-md-5 col-sm-6 col-xs-6 m-r-0 btn p-d-0 colorbtn pull-right">اضافة تعميم جديد</button>
            </div>
            <div class="col-md-12 rtl tabel">
                <table id="menos-datatables" class="table table-striped nowrap" style="width:100%">
                    <thead class="waleed">
                        <tr>
                            <th>رقم التعميم</th>
                            <th>تاريخ التعميم</th>
                            <th>النوع</th>
                            <th>صادر من</th>
                            <th>نبذه مختصره</th>
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
                            else return row.Brief;
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
                            html += '<a class="edit" href="shop-data/view/' + row.Id + '"> <i class="material-icons edit-row">edit</i> </a>';
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