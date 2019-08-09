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

Route::get('/', 'FtLogsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('groups', 'GroupsController');
Route::resource('users', 'UsersController');
Route::resource('jobs', 'JobsController');
Route::resource('methods', 'MethodsController');
Route::resource('products', 'ProductsController');
Route::resource( 'packages', 'PackagesController');
Route::resource('shifts', 'ShiftsController');
Route::resource('units', 'UnitsController');
Route::resource('ft_masters', 'FtMastersController');
Route::resource('plannings', 'PlanningsController');
Route::resource('ft_logs', 'FtLogsController');
Route::resource( 'ft-log-packs', 'FtLogPacksController');
Route::resource('std-processs', 'StdProcesssController');
Route::resource('std-packs', 'StdPacksController');
Route::resource('orders', 'OrdersController');
Route::resource('timeslots', 'TimeslotsController');
Route::resource('product-groups', 'ProductGroupsController');
Route::resource('iqf-jobs', 'IqfJobsController');
Route::resource('mechines', 'MechinesController');
Route::resource('std-iqfs', 'StdIqfsController');
Route::resource('ft-log-iqfs', 'FtLogIqfsController');
Route::resource('iqf-map-cols', 'IqfMapColsController');
Route::resource('ft-log-freezes', 'FtLogFreezesController');
Route::resource('pre-prods', 'PreProdsController');
Route::resource('std-pre-prods', 'StdPreProdsController');
Route::resource('ft-log-pres', 'FtLogPresController');
Route::resource('freeze-ms','FreezeMsController');

Route::get('/import', 'AutoImportController@test');
Route::get('/reports/daily', 'ReportsController@daily')->name('reports.daily');
Route::get('/reports/range', 'ReportsController@range')->name('reports.range');
Route::post('/reports/reportAction', 'ReportsController@reportAction');
Route::get('/reports/dailypack', 'ReportsController@dailypack')->name('reports.dailypack');
Route::get('/reports/rangepack', 'ReportsController@rangepack')->name('reports.rangepack');
Route::post('/reports/reportPackAction', 'ReportsController@reportPackAction');
Route::get('/reports/dailyfreeze', 'ReportsController@dailyfreeze')->name('reports.dailyfreeze');
Route::get('/reports/rangefreeze', 'ReportsController@rangefreeze')->name('reports.rangefreeze');
Route::post('/reports/reportFreezeAction', 'ReportsController@reportFreezeAction');
Route::get('/reports/dailypreprod', 'ReportsController@dailypreprod')->name( 'reports.dailypreprod');
Route::get('/reports/rangepreprod', 'ReportsController@rangepreprod')->name( 'reports.rangepreprod');
Route::post('/reports/reportPreprodAction', 'ReportsController@reportPreprodAction');
Route::get('/reports/dailyfreeze2', 'ReportsController@dailyfreeze2')->name('reports.dailyfreeze2');
Route::get('/reports/rangefreeze2', 'ReportsController@rangefreeze2')->name('reports.rangefreeze2');
Route::post('/reports/reportFreeze2Action', 'ReportsController@reportFreeze2Action');

Route::get('/dashboard', 'DashboardController@home');
Route::get('/chart/{selecteddate}', 'DashboardController@datechart');
Route::get('/charttime/{selecteddate}', 'DashboardController@timechart');
Route::get('/charttimeproduct/{selecteddate}/{product_id}', 'DashboardController@timechartandproduct');
Route::get('/charttimeproductshift/{selecteddate}/{product_id}/{shift_id}', 'DashboardController@timechartandproductshift');
Route::post('dynamic-list/shiftfetch', 'DynamicListController@shiftfetch')->name('dynamic-list.fetch');
Route::post('dynamic-list/stdpackfetch', 'DynamicListController@stdpackfetch')->name( 'dynamic-list.stdpackfetch');
Route::get('dynamic-list/getpackage', 'DynamicListController@getpackage');
Route::get('dynamic-list/getorder', 'DynamicListController@getorder');
Route::get('/summary/{date}', 'DashboardController@summary');
Route::get('/main', 'DashboardController@main');
Route::get('/chart/packdatepackage/{selecteddate}/{package_id}/{method_id}', 'DashboardController@dtPackByDatePack');
Route::get('/chart/packdatepackageshift/{selecteddate}/{package_id}/{method_id}/{shift_id}', 'DashboardController@dtPackByDatePackShift');
Route::get('/chart/freezebydate/{selecteddate}', 'DashboardController@graphFreezeByDate');
Route::get('/testgraph', 'TestController@test');
Route::get('/graph/gengraph/{selecteddate}/{product_id}', 'TestController@gengraph');
Route::get('/ft-log-freezes/recaldelete/{code}/{id}', 'FtLogFreezesController@recaldelete');
Route::get( '/charttime/prepareoutput/{selecteddate}/{pre_prod_id}/{shift_id}', 'DashboardController@graphOutputPrepareByDateProdShift');
Route::get('/charttime/prepareinput/{selecteddate}/{pre_prod_id}/{shift_id}', 'DashboardController@graphInputPrepareByDateProdShift');
Route::get('/reports/orderreport', 'ReportsController@orderreport')->name('reports.orderreport');
Route::get('/reports/packorderaction', 'ReportsController@packOrderAction');

Route::get('/planner/dashboard', 'PlannersController@dashboard');
Route::get('/planner/selectbyyearmonth/{yearmonth}/{type}', 'PlannersController@selectbyyearmonth');

Route::get('/orders/listDetail/{order_id}', 'OrdersController@listDetail');
Route::get('/orders/createDetail/{order_id}', 'OrdersController@createDetail');
Route::post('/orders/storeDetail/{order_id}', 'OrdersController@storeDetail');
Route::get('/orders/editDetail/{id}', 'OrdersController@editDetail');
Route::post('/orders/updateDetail/{id}', 'OrdersController@updateDetail');
Route::get('/orders/deleteDetail/{id}/{order_id}', 'OrdersController@deleteDetail');

Route::get('/freeze-ms/createDetail/{freeze_m_id}', 'FreezeMsController@createDetail');
Route::post('/freeze-ms/storeDetail/{freeze_m_id}', 'FreezeMsController@storeDetail');
Route::get('/freeze-ms/editDetail/{id}', 'FreezeMsController@editDetail');
Route::post('/freeze-ms/updateDetail/{id}', 'FreezeMsController@updateDetail');
Route::get('/freeze-ms/deleteDetail/{id}/{order_id}', 'FreezeMsController@deleteDetail');
Route::get('/freeze-ms/graph/{freeze_m_id}', 'FreezeMsController@graph');
Route::get('/freeze-ms/changestatus/{freeze_m_id}', 'FreezeMsController@changestatus');