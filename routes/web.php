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

Route::get('/', 'LogSelectMsController@index');

Auth::routes();

Route::post('/seed-drop-packs/getkey', 'SeedDropPacksController@getkey');

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('groups', 'GroupsController');
Route::resource('users', 'UsersController');
Route::resource('jobs', 'JobsController');
Route::resource('methods', 'MethodsController');
Route::resource('products', 'ProductsController');
Route::resource('packages', 'PackagesController');
Route::resource('shifts', 'ShiftsController');
Route::resource('units', 'UnitsController');
Route::resource('ft_masters', 'FtMastersController');
Route::resource('plannings', 'PlanningsController');
Route::resource('ft_logs', 'FtLogsController');
Route::resource('ft-log-packs', 'FtLogPacksController');
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
Route::resource('freeze-ms', 'FreezeMsController');
Route::resource('log-prepare-ms', 'LogPrepareMsController');
Route::resource('log-pack-ms', 'LogPackMsController');
Route::resource('log-select-ms', 'LogSelectMsController');
Route::resource('log-pst-selects', 'LogPstSelectsController');
Route::resource('pst-products', 'PstProductsController');
Route::resource('std-select-psts', 'StdSelectPstsController');
Route::resource('stamp-machines', 'StampMachinesController');
Route::resource('mat-packs', 'MatPacksController');
Route::resource('mat-pack-rates', 'MatPackRatesController');
Route::resource('stamp-ms', 'StampMsController');
Route::resource('crops', 'CropsController');
Route::resource('seed-drop-packs', 'SeedDropPacksController');
Route::resource('seed-drop-selects', 'SeedDropSelectsController');
Route::resource('plan-rpt', 'PlanRptController');

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
Route::get('/reports/dailypreprod', 'ReportsController@dailypreprod')->name('reports.dailypreprod');
Route::get('/reports/rangepreprod', 'ReportsController@rangepreprod')->name('reports.rangepreprod');
Route::post('/reports/reportPreprodAction', 'ReportsController@reportPreprodAction');
Route::get('/reports/dailyfreeze2', 'ReportsController@dailyfreeze2')->name('reports.dailyfreeze2');
Route::get('/reports/rangefreeze2', 'ReportsController@rangefreeze2')->name('reports.rangefreeze2');
Route::post('/reports/reportFreeze2Action', 'ReportsController@reportFreeze2Action');
Route::get('/reports/dailypreprod2', 'ReportsController@dailypreprod2')->name('reports.dailypreprod2');
Route::get('/reports/rangepreprod2', 'ReportsController@rangepreprod2')->name('reports.rangepreprod2');
Route::post('/reports/reportPreprod2Action', 'ReportsController@reportPreprod2Action');
Route::get('/reports/dailypack2', 'ReportsController@dailypack2')->name('reports.dailypack2');
Route::get('/reports/rangepack2', 'ReportsController@rangepack2')->name('reports.rangepack2');
Route::post('/reports/reportPack2Action', 'ReportsController@reportPack2Action');
Route::get('/reports/dailyselect2', 'ReportsController@dailyselect2')->name('reports.dailyselect2');
Route::get('/reports/rangeselect2', 'ReportsController@rangeselect2')->name('reports.rangeselect2');
Route::post('/reports/reportSelect2Action', 'ReportsController@reportSelect2Action');
Route::get('/reports/dailypst', 'ReportsController@dailypst')->name('reports.dailypst');
Route::get('/reports/rangepst', 'ReportsController@rangepst')->name('reports.rangepst');
Route::post('/reports/reportPstAction', 'ReportsController@reportPstAction');
Route::get('/reports/report_pl/{type}', 'ReportsController@reportPL');
Route::post('/reports/reportPlAction/{type}', 'ReportsController@reportPLAction');
Route::get('/reports/dailypreprod3', 'ReportsController@dailypreprod3')->name('reports.dailypreprod3');
Route::get('/reports/rangepreprod3', 'ReportsController@rangepreprod3')->name('reports.rangepreprod3');
Route::post('/reports/reportPreprod3Action', 'ReportsController@reportPreprod3Action');
Route::get('/reports/rangseeddroppack', 'ReportsController@seedDropPackReport')->name('reports.rangeseeddroppack');
Route::post('/reports/seedDropPackReportAction', 'ReportsController@seedDropPackReportAction');
Route::get('/reports/rangseeddropselect', 'ReportsController@seedDropSelectReport')->name('reports.rangeseeddropselect');
Route::post('/reports/seedDropSelectReportAction', 'ReportsController@seedDropSelectReportAction');

Route::get('/dashboard', 'DashboardController@home');
Route::get('/chart/{selecteddate}', 'DashboardController@datechart');
Route::get('/charttime/{selecteddate}', 'DashboardController@timechart');
Route::get('/charttimeproduct/{selecteddate}/{product_id}', 'DashboardController@timechartandproduct');
Route::get('/charttimeproductshift/{selecteddate}/{product_id}/{shift_id}', 'DashboardController@timechartandproductshift');
Route::post('dynamic-list/shiftfetch', 'DynamicListController@shiftfetch')->name('dynamic-list.fetch');
Route::post('dynamic-list/stdpackfetch', 'DynamicListController@stdpackfetch')->name('dynamic-list.stdpackfetch');
Route::get('dynamic-list/getpackage', 'DynamicListController@getpackage');
Route::get('dynamic-list/getpackageById', 'DynamicListController@getpackageById');
Route::get('dynamic-list/getorder', 'DynamicListController@getorder');
Route::get('/summary/{date}', 'DashboardController@summary');
Route::get('/main', 'DashboardController@main');
Route::get('/chart/packdatepackage/{selecteddate}/{package_id}/{method_id}', 'DashboardController@dtPackByDatePack');
Route::get('/chart/packdatepackageshift/{selecteddate}/{package_id}/{method_id}/{shift_id}', 'DashboardController@dtPackByDatePackShift');
Route::get('/chart/freezebydate/{selecteddate}', 'DashboardController@graphFreezeByDate');
Route::get('/testgraph', 'TestController@test');
Route::get('/graph/gengraph/{selecteddate}/{product_id}', 'TestController@gengraph');
Route::get('/ft-log-freezes/recaldelete/{code}/{id}', 'FtLogFreezesController@recaldelete');
Route::get('/charttime/prepareoutput/{selecteddate}/{pre_prod_id}/{shift_id}', 'DashboardController@graphOutputPrepareByDateProdShift');
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

Route::get('/log-prepare-ms/createDetail/{log_prepare_m_id}', 'LogPrepareMsController@createDetail');
Route::post('/log-prepare-ms/storeDetail/{log_prepare_m_id}', 'LogPrepareMsController@storeDetail');
Route::get('/log-prepare-ms/editDetail/{id}', 'LogPrepareMsController@editDetail');
Route::post('/log-prepare-ms/updateDetail/{id}', 'LogPrepareMsController@updateDetail');
Route::get('/log-prepare-ms/deleteDetail/{id}/{log_prepare_m_id}', 'LogPrepareMsController@deleteDetail');
Route::get('/log-prepare-ms/graph/{log_prepare_m_id}', 'LogPrepareMsController@graph');
Route::get('/log-prepare-ms/changestatus/{log_prepare_m_id}', 'LogPrepareMsController@changestatus');
Route::get('/log-prepare-ms/graph2/{log_prepare_m_id}', 'LogPrepareMsController@graph2');

Route::get('/log-pack-ms/createDetail/{log_pack_m_id}', 'LogPackMsController@createDetail');
Route::post('/log-pack-ms/storeDetail/{log_pack_m_id}', 'LogPackMsController@storeDetail');
Route::get('/log-pack-ms/editDetail/{id}', 'LogPackMsController@editDetail');
Route::post('/log-pack-ms/updateDetail/{id}', 'LogPackMsController@updateDetail');
Route::get('/log-pack-ms/deleteDetail/{id}/{log_pack_m_id}', 'LogPackMsController@deleteDetail');
Route::get('/log-pack-ms/changestatus/{log_pack_m_id}', 'LogPackMsController@changestatus');
Route::get('/log-pack-ms/graph/{log_pack_m_id}', 'LogPackMsController@graph');
Route::get('/log-pack-ms/forecast/{log_pack_m_id}', 'LogPackMsController@forecast');

Route::get('/log-select-ms/createDetail/{log_select_m_id}', 'LogSelectMsController@createDetail');
Route::post('/log-select-ms/storeDetail/{log_select_m_id}', 'LogSelectMsController@storeDetail');
Route::get('/log-select-ms/editDetail/{id}', 'LogSelectMsController@editDetail');
Route::post('/log-select-ms/updateDetail/{id}', 'LogSelectMsController@updateDetail');
Route::get('/log-select-ms/deleteDetail/{id}/{log_select_m_id}', 'LogSelectMsController@deleteDetail');
Route::get('/log-select-ms/changestatus/{log_select_m_id}', 'LogSelectMsController@changestatus');
Route::get('/log-select-ms/graph/{log_pack_m_id}', 'LogSelectMsController@graph');
Route::get('/log-select-ms/forecast/{log_select_m_id}', 'LogSelectMsController@forecast');

Route::get('/log-pst-selects/createDetail/{log_pst_select_m_id}', 'LogPstSelectsController@createDetail');
Route::post('/log-pst-selects/storeDetail/{log_pst_select_m_id}', 'LogPstSelectsController@storeDetail');
Route::get('/log-pst-selects/editDetail/{id}', 'LogPstSelectsController@editDetail');
Route::post('/log-pst-selects/updateDetail/{id}', 'LogPstSelectsController@updateDetail');
Route::get('/log-pst-selects/deleteDetail/{id}/{log_pst_select_m_id}', 'LogPstSelectsController@deleteDetail');
Route::get('/log-pst-selects/changestatus/{log_pst_select_m_id}', 'LogPstSelectsController@changestatus');
Route::get('/log-pst-selects/graph/{log_pack_m_id}', 'LogPstSelectsController@graph');
Route::get('/log-pst-selects/forecast/{log_pst_select_m_id}', 'LogPstSelectsController@forecast');
Route::get('/log-pst-selects/groupgraph/{date}/{pst_type_id}', 'LogPstSelectsController@groupgraph');

Route::get('/mains/index/{date}', 'MainsController@index');
Route::get('/mains/weight/{date}', 'MainsController@weightindex');
Route::get('/mains/weight1/{date}', 'MainsController@weight1index');
Route::get('/mains/weight2/{date}', 'MainsController@weight2index');
Route::get('/mains/weight3/{date}', 'MainsController@weight3index');

Route::post('/mat-pack-rates/getrate', 'MatPackRatesController@getrate');
Route::get('/stamp-ms/createDetail/{stamp_m_id}', 'StampMsController@createDetail');
Route::post('/stamp-ms/storeDetail/{stamp_m_id}', 'StampMsController@storeDetail');
Route::get('/stamp-ms/editDetail/{id}', 'StampMsController@editDetail');
Route::post('/stamp-ms/updateDetail/{id}', 'StampMsController@updateDetail');
Route::get('/stamp-ms/changestatus/{stamp_m_id}', 'StampMsController@changestatus');
Route::get('/stamp-ms/graph/{stamp_m_id}', 'StampMsController@graph');
Route::get('/stamp-ms/forecast/{stamp_m_id}', 'StampMsController@forecast');

Route::get('/reports/dailystamp', 'ReportsController@dailystamp')->name('reports.dailystamp');
Route::get('/reports/rangestamp', 'ReportsController@rangestamp')->name('reports.rangestamp');
Route::post('/reports/reportStampAction', 'ReportsController@reportStampAction');


Route::get('/reports/plreportdaily', 'ReportsController@plreportdaily')->name('reports.plreportdaily');
Route::get('/reports/plreportrang', 'ReportsController@plreportrang')->name('reports.plreportrang');
Route::post('/reports/plreportaction', 'ReportsController@plreportaction');

Route::get('/reports/checkweightreportdaily', 'ReportsController@checkweightreportdaily')->name('reports.checkweightreportdaily');
Route::get('/reports/checkweightreportrang', 'ReportsController@checkweightreportrang')->name('reports.checkweightreportrang');
Route::post('/reports/checkweightreportaction', 'ReportsController@checkweightreportaction');

Route::get('/mains/realtimechart', 'MainsController@realtimechart');
Route::get('/mains/realsummarytimechart', 'MainsController@realsummarytimechart');

Route::get('/planrpt/getprevdata/{month}/{year}', 'PlanRptController@getprevdata');

