<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/', 'DashboardController@index');

    // Get all service Categories
    Route::get('categories', 'ServiceCategoryController@getCategories');

    // Get Invoices for Each services by Category
    Route::get('category/{category}/invoices', 'InvoiceController@getInvoicesByServiceCategory');

    // Get Invoices for Each services by Category
    Route::get('offices-invoices', 'InvoiceController@getInvoicesByOffice');

    // Get Invoices for per Requests done from Mobile and those done from Office
    Route::get('mobile-and-offices-invoices', 'InvoiceController@getInvoicesByMobileRequestByOffice');
    
});
