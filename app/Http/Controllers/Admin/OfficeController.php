<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office;

class OfficeController extends Controller
{
    public function getOffices()
    {
        try {
            $offices = Office::select('Id', 'Name')->get();
            return response()->json(['status' => 'success', 'data' => $offices], 200);
        } catch (\Exception $ex) {
            return response()->json(['status' => 'error', 'data' => $ex->getMessage()], 200);
        }
    }
}
