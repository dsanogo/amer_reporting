<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Memo;

class RestMemoController extends Controller
{
    public function __construct(Memo $memo)
    {
        $this->model = $memo;
    }

    public function postAjax(Request $request)
    {
        $inputs = $request->all();
        $orderBy = $inputs['columns'][$inputs['order'][0]['column']]['data'];
        $dir = $inputs['order'][0]['dir'];
        $start = $inputs['start'];
        $length = $inputs['length'];
        $search = $inputs['search']['value'];
        $data = $this->model->getMemosFilter($orderBy, $dir, $start, $length, $search);
        return response()->json(['draw' => $inputs['draw'], 'recordsTotal' => $data->count(), 'recordsFiltered' => $this->model->getTotal(), 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }
}
