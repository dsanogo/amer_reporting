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
    // Export Invoices for Each services by Offices
    Route::get('export-offices-invoices', 'ExportController@exportInvoicesForOffices')->name('admin.exportInvoicesByOffices');

    // Get Invoices for per Requests done from Mobile and those done from Office
    Route::get('mobile-and-offices-invoices', 'InvoiceController@getInvoicesByMobileRequestByOffice')->name('admin.getMobileAndOfficeInvoices');
    // Print Invoices for per Requests done from Mobile and those done from Office
    Route::get('print-mobile-and-offices-invoices', 'InvoiceController@printInvoicesByMobileRequestByOffice')->name('admin.printMobileAndOfficeInvoices');
    // Export Invoices for per Requests done from Mobile and those done from Office
    Route::get('export-mobile-and-offices-invoices', 'ExportController@exportInvoicesByMobileRequestByOffice')->name('admin.exportMobileAndOfficeInvoices');


    // Get Invoices for per Requests done from Mobile and those done from Office
    Route::get('quarterly-mobile-and-offices-invoices', 'InvoiceController@getQuarterInvoicesByMobileRequestByOffice')->name('admin.getMobileAndOfficeInvoicesQuarterly');
    // Print Invoices for per Requests done from Mobile and those done from Office
    Route::get('print-quarterly-mobile-and-offices-invoices', 'InvoiceController@printQuarterInvoicesByMobileRequestByOffice')->name('admin.printMobileAndOfficeInvoicesQuarterly');
   // export Invoices for per Requests done from Mobile and those done from Office
   Route::get('export-quarterly-mobile-and-offices-invoices', 'ExportController@exportQuarterInvoicesByMobileRequestByOffice')->name('admin.exportMobileAndOfficeInvoicesQuarterly');

    // Get all the TotalFeesPerMonth and their corresponding  ratings
    Route::get('get-invoices-per-month', 'InvoiceController@getInvoicesPerMonth')->name('admin.getInvoicesPerMonth');

    // Get all the serveySubjects and their corresponding  ratings
    Route::get('surveys', 'SurveyController@getSurveysReport')->name('admin.getSurveysReport');
    // Print all the serveySubjects and their corresponding  ratings
    Route::get('print-surveys', 'SurveyController@printSurveysReport')->name('admin.printSurveysReport');
    // export all the serveySubjects and their corresponding  ratings
    Route::get('export-surveys', 'ExportController@exportSurveysReport')->name('admin.exportSurveysReport');

    //Get Offices Details
    Route::get('offices-details', 'OfficeController@getOfficesDetails')->name('admin.offices.details');
    //Print Offices Details
    Route::get('print-offices-details', 'OfficeController@printOfficesDetails')->name('admin.offices.printDetails');
    //export Offices Details
    Route::get('export-offices-details', 'ExportController@exportOfficesDetails')->name('admin.offices.exportDetails');

    //Get Offices Details with Average time
    Route::get('offices-details-with-process-time', 'OfficeController@getOfficesDetailsWithAverage')->name('admin.offices.ProcessTimeDetails');
    //Print Offices Details with Average time
    Route::get('print-offices-details-with-process-time', 'OfficeController@printOfficesDetailsWithAverage')->name('admin.offices.printProcessTimeDetails');
    //export Offices Details with Average time
    Route::get('export-offices-details-with-process-time', 'ExportController@exportOfficesDetailsWithAverage')->name('admin.offices.exportProcessTimeDetails');

    //Get Invoices Per Month
    Route::get('monthly-invoices', 'InvoiceController@getInvoiceMonthly')->name('admin.monthlyInvoices');
    //Print Invoices Per Month
    Route::get('print-monthly-invoices', 'InvoiceController@printInvoiceMonthly')->name('admin.printMonthlyInvoices');
    //export Invoices Per Month
    Route::get('export-monthly-invoices', 'ExportController@exportInvoiceMonthly')->name('admin.exportMonthlyInvoices');

    //Get Invoices Per Month And their Process Time
    Route::get('monthly-invoices-per-process-time', 'InvoiceController@getInvoiceMonthlyProcessTime')->name('admin.monthlyInvoicesProcessTime');
    //Print Invoices Per Month And their Process Time
    Route::get('print-monthly-invoices-per-process-time', 'InvoiceController@printInvoiceMonthlyProcessTime')->name('admin.printMonthlyInvoicesProcessTime');
    //export Invoices Per Month And their Process Time
    Route::get('export-monthly-invoices-per-process-time', 'ExportController@exportInvoiceMonthlyProcessTime')->name('admin.exportMonthlyInvoicesProcessTime');

    //Get Invoices Quarterly And their Process Time
    Route::get('quarterly-invoices-per-process-time', 'InvoiceController@getInvoiceQuarterlyProcessTime')->name('admin.quarterlyInvoicesProcessTime');

    //Get Invoices for the last 3 years
    Route::get('last-three-years-invoices', 'InvoiceController@getLastThreeYearsInvoices')->name('admin.invoices.getLastThreeYears');
    //Print Invoices for the last 3 years
    Route::get('print-last-three-years-invoices', 'InvoiceController@printLastThreeYearsInvoices')->name('admin.invoices.printLastThreeYears');
    //export Invoices for the last 3 years
    Route::get('export-last-three-years-invoices', 'ExportController@exportLastThreeYearsInvoices')->name('admin.invoices.exportLastThreeYears');
});
