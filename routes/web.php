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
    // Print Invoices for Each services by Category
    Route::get('print-category-invoices', 'InvoiceController@printInvoicesByServiceCategory')->name('admin.printInvoicesByCategory');
    // Print Invoices for Each services by Category
    Route::get('export-category-invoices', 'ExportController@exportInvoicesByServiceCategory')->name('admin.exportInvoicesByCategory');

    // Get Invoices for Each services by Offices
    Route::get('offices-invoices', 'InvoiceController@getInvoicesForOffices')->name('admin.getInvoicesByOffices');
    // Print Invoices for Each services by Offices
    Route::get('print-offices-invoices', 'InvoiceController@printInvoicesForOffices')->name('admin.printInvoicesByOffices');

    // Get Invoices for per Requests done from Mobile and those done from Office
    Route::get('mobile-and-offices-invoices', 'InvoiceController@getInvoicesByMobileRequestByOffice')->name('admin.getMobileAndOfficeInvoices');
    // Print Invoices for per Requests done from Mobile and those done from Office
    Route::get('print-mobile-and-offices-invoices', 'InvoiceController@printInvoicesByMobileRequestByOffice')->name('admin.printMobileAndOfficeInvoices');


    // Get Invoices for per Requests done from Mobile and those done from Office
    Route::get('quarterly-mobile-and-offices-invoices', 'InvoiceController@getQuarterInvoicesByMobileRequestByOffice')->name('admin.getMobileAndOfficeInvoicesQuarterly');
    // Print Invoices for per Requests done from Mobile and those done from Office
    Route::get('print-quarterly-mobile-and-offices-invoices', 'InvoiceController@printQuarterInvoicesByMobileRequestByOffice')->name('admin.printMobileAndOfficeInvoicesQuarterly');

    // Get all the TotalFeesPerMonth and their corresponding  ratings
    Route::get('get-invoices-per-month', 'InvoiceController@getInvoicesPerMonth')->name('admin.getInvoicesPerMonth');

    // Get all the serveySubjects and their corresponding  ratings
    Route::get('surveys', 'SurveyController@getSurveysReport')->name('admin.getSurveysReport');
    // Print all the serveySubjects and their corresponding  ratings
    Route::get('print-surveys', 'SurveyController@printSurveysReport')->name('admin.printSurveysReport');

    //Get Offices Details
    Route::get('offices-details', 'OfficeController@getOfficesDetails')->name('admin.offices.details');
    //Print Offices Details
    Route::get('primt-offices-details', 'OfficeController@printOfficesDetails')->name('admin.offices.printDetails');

    //Get Offices Details with Average time
    Route::get('offices-details-with-process-time', 'OfficeController@getOfficesDetailsWithAverage')->name('admin.offices.ProcessTimeDetails');
    //Get Offices Details with Average time
    Route::get('print-offices-details-with-process-time', 'OfficeController@printOfficesDetailsWithAverage')->name('admin.offices.printProcessTimeDetails');

    //Get Invoices Per Month
    Route::get('monthly-invoices', 'InvoiceController@getInvoiceMonthly')->name('admin.monthlyInvoices');
    //Print Invoices Per Month
    Route::get('print-monthly-invoices', 'InvoiceController@printInvoiceMonthly')->name('admin.printMonthlyInvoices');

    //Get Invoices Per Month And their Process Time
    Route::get('monthly-invoices-per-process-time', 'InvoiceController@getInvoiceMonthlyProcessTime')->name('admin.monthlyInvoicesProcessTime');
    //Print Invoices Per Month And their Process Time
    Route::get('print-monthly-invoices-per-process-time', 'InvoiceController@printInvoiceMonthlyProcessTime')->name('admin.printMonthlyInvoicesProcessTime');

    //Get Invoices Quarterly And their Process Time
    Route::get('quarterly-invoices-per-process-time', 'InvoiceController@getInvoiceQuarterlyProcessTime')->name('admin.quarterlyInvoicesProcessTime');

    //Get Invoices for the last 3 years
    Route::get('last-three-years-invoices', 'InvoiceController@getLastThreeYearsInvoices')->name('admin.invoices.getLastThreeYears');
    //Get Invoices for the last 3 years
    Route::get('print-last-three-years-invoices', 'InvoiceController@printLastThreeYearsInvoices')->name('admin.invoices.printLastThreeYears');
});
