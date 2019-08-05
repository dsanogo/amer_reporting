<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\Service;

class ServiceCategoryController extends Controller
{
    public function getCategoryServices(ServiceCategory $category)
    {        
        $services = Service::where('ServicesCategoryId', $category->Id)->get();
        $data['category'] = $category;
        $data['category']['services'] = $services;
        
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }
}
