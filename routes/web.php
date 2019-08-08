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

Route::get('/', 'HomeController@index');   

Auth::routes();

Route::prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/', 'DashboardController@index')->name('admin.index');

    Route::get('invoices-by-category', 'DashboardController@showInvoicesByCategory')->name('show.reportCategories');
    Route::get('invoices-by-offices', 'DashboardController@showInvoicesByOffices')->name('show.reportOffices');
    Route::get('invoices-by-mobile-offices', 'DashboardController@showInvoicesByMobileAndOffices')->name('show.reportMobileOffices');
    Route::get('surveys', 'DashboardController@showSurveys')->name('show.reportSurveys');

    // Get all service Categories
    Route::get('categories', 'ServiceCategoryController@getCategories')->name('admin.categories');

    // Get all offices
    Route::get('offices', 'OfficeController@getOffices')->name('admin.offices');

    // Get Invoices for Each services by Category
    Route::get('category/invoices', 'InvoiceController@getInvoicesByServiceCategory')->name('admin.getInvoicesByCategory');

    // Get Invoices for Each services by Offices
    Route::get('offices-invoices', 'InvoiceController@getInvoicesForOffices')->name('admin.getInvoicesByOffices');

    // Get Invoices for per Requests done from Mobile and those done from Office
    Route::get('mobile-and-offices-invoices', 'InvoiceController@getInvoicesByMobileRequestByOffice')->name('admin.getMobileAndOfficeInvoices');

    // Get all the TotalFeesPerMonth and their corresponding  ratings
    Route::get('get-invoices-per-month', 'InvoiceController@getInvoicesPerMonth')->name('admin.getInvoicesPerMonth');

    // Get all the serveySubjects and their corresponding  ratings
    Route::get('surveys', 'SurveyController@getSurveysReport')->name('admin.getSurveysReport');
    
});
