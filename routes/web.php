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
    Route::get('show-surveys', 'DashboardController@showSurveys')->name('show.reportSurveys');

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
    // Generate PDF Invoices for Each services by Category
    Route::get('pdf-category-invoices', 'ExportController@genPdfInvoicesByServiceCategory')->name('admin.pdfInvoicesByCategory');

    // Get Invoices for Each services by Offices
    Route::get('offices-invoices', 'InvoiceController@getInvoicesForOffices')->name('admin.getInvoicesByOffices');
    // Print Invoices for Each services by Offices
    Route::get('print-offices-invoices', 'InvoiceController@printInvoicesForOffices')->name('admin.printInvoicesByOffices');
    // Export Invoices for Each services by Offices
    Route::get('export-offices-invoices', 'ExportController@exportInvoicesForOffices')->name('admin.exportInvoicesByOffices');
    // PDF Invoices for Each services by Offices
    Route::get('pdf-offices-invoices', 'ExportController@pdfInvoicesForOffices')->name('admin.pdfInvoicesByOffices');

    // Get Invoices for per Requests done from Mobile and those done from Office
    Route::get('mobile-and-offices-invoices', 'InvoiceController@getInvoicesByMobileRequestByOffice')->name('admin.getMobileAndOfficeInvoices');
    // Print Invoices for per Requests done from Mobile and those done from Office
    Route::get('print-mobile-and-offices-invoices', 'InvoiceController@printInvoicesByMobileRequestByOffice')->name('admin.printMobileAndOfficeInvoices');
    // Export Invoices for per Requests done from Mobile and those done from Office
    Route::get('export-mobile-and-offices-invoices', 'ExportController@exportInvoicesByMobileRequestByOffice')->name('admin.exportMobileAndOfficeInvoices');
    // PDF Invoices for per Requests done from Mobile and those done from Office
    Route::get('pdf-mobile-and-offices-invoices', 'ExportController@pdfInvoicesByMobileRequestByOffice')->name('admin.pdfMobileAndOfficeInvoices');

    // Get Invoices for per Requests done from Mobile and those done from Office
    Route::get('quarterly-mobile-and-offices-invoices', 'InvoiceController@getQuarterInvoicesByMobileRequestByOffice')->name('admin.getMobileAndOfficeInvoicesQuarterly');
    // Print Invoices for per Requests done from Mobile and those done from Office
    Route::get('print-quarterly-mobile-and-offices-invoices', 'InvoiceController@printQuarterInvoicesByMobileRequestByOffice')->name('admin.printMobileAndOfficeInvoicesQuarterly');
    // export Invoices for per Requests done from Mobile and those done from Office
    Route::get('export-quarterly-mobile-and-offices-invoices', 'ExportController@exportQuarterInvoicesByMobileRequestByOffice')->name('admin.exportMobileAndOfficeInvoicesQuarterly');
    // pdf Invoices for per Requests done from Mobile and those done from Office
    Route::get('pdf-quarterly-mobile-and-offices-invoices', 'ExportController@pdfQuarterInvoicesByMobileRequestByOffice')->name('admin.pdfMobileAndOfficeInvoicesQuarterly');

    // Get all the TotalFeesPerMonth and their corresponding  ratings
    Route::get('get-invoices-per-month', 'InvoiceController@getInvoicesPerMonth')->name('admin.getInvoicesPerMonth');

    // Get all the serveySubjects and their corresponding  ratings
    Route::get('surveys', 'SurveyController@getSurveysReport')->name('admin.getSurveysReport');
    // Print all the serveySubjects and their corresponding  ratings
    Route::get('print-surveys', 'SurveyController@printSurveysReport')->name('admin.printSurveysReport');
    // export all the serveySubjects and their corresponding  ratings
    Route::get('export-surveys', 'ExportController@exportSurveysReport')->name('admin.exportSurveysReport');
    // PDF all the serveySubjects and their corresponding  ratings
    Route::get('pdf-surveys', 'ExportController@pdfSurveysReport')->name('admin.pdfSurveysReport');

    //show offices details page
    Route::get('/show/offices-details', 'DashboardController@showOfficesDetails')->name('admin.offices.details.show');
    //Get Offices Details
    Route::get('offices-details', 'OfficeController@getOfficesDetails')->name('admin.offices.details');
    //Print Offices Details
    Route::get('print-offices-details', 'OfficeController@printOfficesDetails')->name('admin.offices.printDetails');
    //export Offices Details
    Route::get('export-offices-details', 'ExportController@exportOfficesDetails')->name('admin.offices.exportDetails');
    //PDF Offices Details
    Route::get('pdf-offices-details', 'ExportController@pdfOfficesDetails')->name('admin.offices.pdfDetails');

    //Get Offices Details with Average time
    Route::get('offices-details-with-process-time', 'OfficeController@getOfficesDetailsWithAverage')->name('admin.offices.ProcessTimeDetails');
    //Print Offices Details with Average time
    Route::get('print-offices-details-with-process-time', 'OfficeController@printOfficesDetailsWithAverage')->name('admin.offices.printProcessTimeDetails');
    //export Offices Details with Average time
    Route::get('export-offices-details-with-process-time', 'ExportController@exportOfficesDetailsWithAverage')->name('admin.offices.exportProcessTimeDetails');
    //pdf Offices Details with Average time
    Route::get('pdf-offices-details-with-process-time', 'ExportController@pdfOfficesDetailsWithAverage')->name('admin.offices.pdfProcessTimeDetails');

    //Get Invoices Per Month
    Route::get('monthly-invoices', 'InvoiceController@getInvoiceMonthly')->name('admin.monthlyInvoices');
    //Print Invoices Per Month
    Route::get('print-monthly-invoices', 'InvoiceController@printInvoiceMonthly')->name('admin.printMonthlyInvoices');
    //export Invoices Per Month
    Route::get('export-monthly-invoices', 'ExportController@exportInvoiceMonthly')->name('admin.exportMonthlyInvoices');
    //pdf Invoices Per Month
    Route::get('pdf-monthly-invoices', 'ExportController@pdfInvoiceMonthly')->name('admin.pdfMonthlyInvoices');

    //Get Invoices Per Month And their Process Time
    Route::get('monthly-invoices-per-process-time', 'InvoiceController@getInvoiceMonthlyProcessTime')->name('admin.monthlyInvoicesProcessTime');
    //Print Invoices Per Month And their Process Time
    Route::get('print-monthly-invoices-per-process-time', 'InvoiceController@printInvoiceMonthlyProcessTime')->name('admin.printMonthlyInvoicesProcessTime');
    //export Invoices Per Month And their Process Time
    Route::get('export-monthly-invoices-per-process-time', 'ExportController@exportInvoiceMonthlyProcessTime')->name('admin.exportMonthlyInvoicesProcessTime');
    //pdf Invoices Per Month And their Process Time
    Route::get('pdf-monthly-invoices-per-process-time', 'ExportController@pdfInvoiceMonthlyProcessTime')->name('admin.pdfMonthlyInvoicesProcessTime');

    //Get Invoices Quarterly And their Process Time
    Route::get('quarterly-invoices-per-process-time', 'InvoiceController@getInvoiceQuarterlyProcessTime')->name('admin.quarterlyInvoicesProcessTime');

    //Get Invoices for the last 3 years
    Route::get('last-three-years-invoices', 'InvoiceController@getLastThreeYearsInvoices')->name('admin.invoices.getLastThreeYears');
    //Print Invoices for the last 3 years
    Route::get('print-last-three-years-invoices', 'InvoiceController@printLastThreeYearsInvoices')->name('admin.invoices.printLastThreeYears');
    //export Invoices for the last 3 years
    Route::get('export-last-three-years-invoices', 'ExportController@exportLastThreeYearsInvoices')->name('admin.invoices.exportLastThreeYears');
    //pdf Invoices for the last 3 years
    Route::get('pdf-last-three-years-invoices', 'ExportController@pdfLastThreeYearsInvoices')->name('admin.invoices.pdfLastThreeYears');

    Route::get('memos', 'MemoController@index')->name('admin.memos.index');
    Route::post('memos/ajax', 'RestMemoController@postAjax');

    Route::get('memo/create', 'MemoController@create')->name('admin.memos.get.create');
    Route::post('memo/store', 'MemoController@postCreate')->name('admin.memos.post.create');
    Route::get('memo/edit/{id}', 'MemoController@getEdit')->name('admin.memos.get.edit');
    Route::post('memo/edit', 'MemoController@postEdit')->name('admin.memos.post.edit');
});
