<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
    * Display the Admin Welcome page.
    *
    */
    public function index()
    {
        return view('admin.index');
    }
}
