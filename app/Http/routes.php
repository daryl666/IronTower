<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('auth/login');
});


Route::auth();
Route::any('backend', 'HomeController@index');
Route::any('backend/todoHandlePage/{id}', 'HomeController@todoHandlePage');

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/siteInfo'], function () {
    // 基站

    Route::any('/', ['uses' => 'SiteInfoController@indexPage', 'permissions' => ['view', 'is_verified']]);
    Route::post('editPage/{id}', ['uses' => 'SiteInfoController@editPage', 'permissions' => ['view', 'is_verified']]);
//    Route::any('addPage', ['uses' => 'SiteInfoController@addPage', 'permissions'=>['view','is_verified']]);
    Route::any('addNewPage', ['uses' => 'SiteInfoController@addNewPage', 'permissions' => ['view', 'is_verified']]);
    Route::any('addOldPage', ['uses' => 'SiteInfoController@addOldPage', 'permissions' => ['view', 'is_verified']]);
    Route::post('addNew', ['uses' => 'SiteInfoController@addNewDB', 'permissions' => ['view', 'is_verified']]);
    Route::post('addOld', ['uses' => 'SiteInfoController@addOldDB', 'permissions' => ['view', 'is_verified']]);
    Route::post('update', ['uses' => 'SiteInfoController@update', 'permissions' => ['view', 'single_update', 'is_verified']]);
    Route::get('delete/{id}', ['uses' => 'SiteInfoController@delete', 'permissions' => ['view', 'delete', 'is_verified']]);
    Route::post('export', ['uses' => 'ExcelController@exportSiteInfo', 'permissions' => ['view', 'bulk_export', 'is_verified']]);
    Route::post('import', ['uses' => 'ExcelController@importSiteInfo', 'permissions' => ['view', 'bulk_import', 'is_verified']]);
    Route::post('importIronTowerSiteInfo', ['uses' => 'ExcelController@transIronTowerSiteInfo', 'permissions' => ['view', 'bulk_import', 'is_verified']]);
    Route::post('bulkUpdate', ['uses' => 'ExcelController@bulkUpdateSiteInfo', 'permissions' => ['view', 'bulk_update', 'is_verified']]);
    Route::post('back', ['uses' => 'SiteInfoController@back', 'permissions' => ['view']]);
    Route::get('test', ['uses' => 'SiteInfoController@test']);


});


Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/gnrRec'], function () {

    // 发电记录列表

    Route::any('/', ['uses' => 'GnrRecController@indexPage', 'permissions' => ['view', 'is_verified']]);
    Route::any('indexGnr', ['uses' => 'GnrRecController@indexPage_gnr', 'permissions' => ['view', 'is_verified']]);
    Route::any('addPage', ['uses' => 'GnrRecController@addPage', 'permissions' => ['view', 'is_verified']]);
    Route::any('handlePage/{id}', ['uses' => 'GnrRecController@handlePage', 'permissions' => ['view', 'is_verified']]);
    Route::any('handleGnr/{id}', ['uses' => 'GnrRecController@handleGnr', 'permissions' => ['view', 'is_verified']]);
    Route::any('{gnrID}/editPage/{siteID}/{siteChoose}/{lastGnrTime}', ['uses' => 'GnrRecController@editPage', 'permissions' => ['view', 'is_verified']]);
    Route::any('add', ['uses' => 'GnrRecController@addGnr', 'permissions' => ['view', 'is_verified']]);
    Route::any('update', ['uses' => 'GnrRecController@update', 'permissions' => ['view', 'single_update', 'is_verified']]);
    Route::any('back', ['uses' => 'GnrRecController@back']);
    Route::get('delete/{id}', ['uses' => 'GnrRecController@delete', 'permissions' => ['view', 'delete', 'is_verified']]);
    Route::any('import', ['uses' => 'GnrRecController@importGnrRec', 'permissions' => ['view', 'bulk_import', 'is_verified']]);
    Route::post('export', ['uses' => 'ExcelController@exportGnrRec', 'permissions' => ['view', 'bulk_export', 'is_verified']]);


});

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/servBill'], function () {

    // 服务账单列表
    Route::any('/', ['uses' => 'ServBillController@indexPage', 'permissions' => ['view', 'is_verified']]);
    Route::get('freeGnr', ['uses' => 'ServBillController@viewFreeGnrPage', 'permissions' => ['view', 'is_verified']]);
    Route::get('billGnr', ['uses' => 'ServBillController@viewBillGnrPage', 'permissions' => ['view', 'is_verified']]);
    Route::get('site', ['uses' => 'ServBillController@viewSitePage', 'permissions' => ['view', 'is_verified']]);
    Route::get('deduction1', ['uses' => 'ServBillController@viewDeduction1Page', 'permissions' => ['view', 'is_verified']]);
    Route::get('deduction2', ['uses' => 'ServBillController@viewDeduction2Page', 'permissions' => ['view', 'is_verified']]);
    Route::post('createBill', ['uses' => 'ServBillController@createBill', 'permissions' => ['view', 'is_verified']]);
    Route::post('doOut', ['uses' => 'ServBillController@doOut', 'permissions' => ['view', 'is_verified', 'account_out']]);

//    Route::get('freeGnr', 'ServBillController@viewFreeGnrPage');
//    Route::get('billGnr', 'ServBillController@viewBillGnrPage');
//    Route::get('site', 'ServBillController@viewSitePage');
//    Route::post('createBill', 'ServBillController@createBill');
//    Route::post('doOut', 'ServBillController@doOut');
});

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/servCost'], function () {

    // 服务费用列表
    Route::any('/', ['uses' => 'ServCostController@indexPage', 'permissions' => ['view', 'is_verified']]);
    Route::any('editPage/{id}/{region}', ['uses' => 'ServCostController@editPage']);
    Route::post('update/{id}', ['uses' => 'ServCostController@update', 'permissions' => ['single_update', 'is_verified']]);
    Route::post('back', ['uses' => 'ServCostController@back']);
    Route::get('delete/{id}', ['uses' => 'ServCostController@delete', 'permissions' => ['delete', 'is_verified']]);
    Route::any('addPage', ['uses' => 'ServCostController@addPage']);
    Route::post('add', ['uses' => 'ServCostController@add']);
    Route::post('export', ['uses' => 'ExcelController@exportServCost', 'permissions' => ['bulk_export', 'is_verified']]);

//    Route::get('{id}/editPage/{beginDate}/{endDate}','ServCostController@editPage');
//    Route::post('update','ServCostController@update');
//    Route::post('back','ServCostController@back');
//    Route::get('delete/{id}','ServCostController@delete');
//    Route::post('addPage','ServCostController@addPage');
//    Route::post('add','ServCostController@add');
//    Route::post('export','ExcelController@exportServCost');

});

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/rentStd'], function () {

    // 服务价格列表
    Route::any('/', ['uses' => 'RentStdController@indexPage', 'permissions' => ['view', 'is_verified']]);
    Route::any('fee_std_search', ['uses' => 'RentStdController@fee_std_search', 'permissions' => ['view', 'is_verified']]);
    Route::any('basic_fee_update/{seq}/{region}/{fee_type}', ['uses' => 'RentStdController@basic_fee_update', 'permissions' => ['view', 'is_verified']]);
    Route::any('site_fee_update/{seq}', ['uses' => 'RentStdController@site_fee_update', 'permissions' => ['view', 'is_verified']]);
    Route::any('elec_introduced_fee_update/{seq}', ['uses' => 'RentStdController@elec_introduced_fee_update', 'permissions' => ['view', 'is_verified']]);
    Route::any('share_discount_update/{seq}', ['uses' => 'RentStdController@share_discount_update', 'permissions' => ['view', 'is_verified']]);
    Route::any('update_basic_fee', ['uses' => 'RentStdController@update_basic_fee', 'permissions' => ['single_update', 'is_verified']]);
    Route::any('update_elec_introduced_fee', ['uses' => 'RentStdController@update_elec_introduced_fee', 'permissions' => ['single_update', 'is_verified']]);
    Route::any('update_site_fee', ['uses' => 'RentStdController@update_site_fee', 'permissions' => ['single_update', 'is_verified']]);
    Route::any('update_share_discount', ['uses' => 'RentStdController@update_share_discount', 'permissions' => ['single_update', 'is_verified']]);
    Route::post('exportBasicFee', ['uses' => 'ExcelController@exportBasicFee', 'permissions' => ['bulk_export', 'is_verified']]);
    Route::post('exportSiteFee', ['uses' => 'ExcelController@exportSiteFee', 'permissions' => ['bulk_export', 'is_verified']]);
    Route::post('exportElecImportFee', ['uses' => 'ExcelController@exportElecImportFee', 'permissions' => ['bulk_export', 'is_verified']]);
    Route::post('exportDiscount', ['uses' => 'ExcelController@exportDiscount', 'permissions' => ['bulk_export', 'is_verified']]);

//    Route::any('fee_std_search','RentStdController@fee_std_search');
//    Route::any('basic_fee_update/{seq}','RentStdController@basic_fee_update');
//    Route::any('site_fee_update/{seq}','RentStdController@site_fee_update');
//    Route::any('elec_introduced_fee_update/{seq}','RentStdController@elec_introduced_fee_update');
//    Route::any('share_discount_update/{seq}','RentStdController@share_discount_update');
//    Route::any('update_basic_fee','RentStdController@update_basic_fee');
//    Route::any('update_elec_introduced_fee','RentStdController@update_elec_introduced_fee');
//    Route::any('update_site_fee','RentStdController@update_site_fee');
//    Route::any('update_share_discount','RentStdController@update_share_discount');
//    Route::post('exportBasicFee','ExcelController@exportBasicFee');
//    Route::post('exportSiteFee','ExcelController@exportSiteFee');
//    Route::post('exportElecImportFee','ExcelController@exportElecImportFee');
//    Route::post('exportDiscount','ExcelController@exportDiscount');

});

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/elecCharge'], function () {
    Route::any('/', ['uses' => 'ElecChargeController@indexPage']);
    Route::any('/edit', ['uses' => 'ElecChargeController@editPage']);
    Route::any('/back', ['uses' => 'ElecChargeController@indexPage']);
    Route::any('/add', ['uses' => 'ElecChargeController@addPage']);

});


Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::get('auth/reset', 'Auth\AuthController@getReset');
Route::post('auth/update', 'Auth\AuthController@postUpdate');
Route::post('auth/reset', 'Auth\AuthController@postReset');

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/userManage'], function () {

    Route::get('/', ['uses' => 'UserManageController@indexPage']);
    Route::any('verify/{id}', ['uses' => 'UserManageController@verifyPermission']);
    Route::any('update/{id}', ['uses' => 'UserManageController@updatePermission']);


});

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/otherCost'], function () {

    Route::any('/', ['uses' => 'otherCostController@indexPage']);
    Route::post('addPage', ['uses' => 'otherCostController@addPage']);
    Route::post('add', ['uses' => 'otherCostController@addDB']);
    Route::post('editPage/{id}/{region}', ['uses' => 'otherCostController@editPage']);
    Route::post('edit/{id}', ['uses' => 'otherCostController@editDB']);
    Route::post('back', ['uses' => 'otherCostController@back']);
    Route::get('delete/{id}', ['uses' => 'otherCostController@delete']);


});

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/siteCheck'], function () {

    Route::any('/', ['uses' => 'SiteCheckController@indexPage']);
    Route::any('handlePage/{id}', ['uses' => 'SiteCheckController@handlePage']);
    Route::any('addPage', ['uses' => 'SiteCheckController@addPage']);
    Route::any('add', ['uses' => 'SiteCheckController@add']);
    Route::any('handle', ['uses' => 'SiteCheckController@handle']);


});

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/siteShield'], function () {

    Route::any('/', ['uses' => 'SiteShieldController@indexPage']);
    Route::any('addShieldPage', ['uses' => 'SiteShieldController@addShieldPage']);
    Route::any('checkShieldPage', ['uses' => 'SiteShieldController@checkShieldPage']);
    Route::any('checkUnshieldPage', ['uses' => 'SiteShieldController@checkUnshieldPage']);
    Route::any('shieldPage', ['uses' => 'SiteShieldController@shieldPage']);
    Route::any('unshieldPage', ['uses' => 'SiteShieldController@unshieldPage']);
    Route::any('shieldCheckingPage', ['uses' => 'SiteShieldController@shieldCheckingPage']);


    Route::any('addUnshieldPage/{id}', ['uses' => 'SiteShieldController@addUnshieldPage']);
    Route::any('addShield', ['uses' => 'SiteShieldController@addShield']);
    Route::any('addUnshield/{id}', ['uses' => 'SiteShieldController@addUnshield']);
    Route::any('withdrawShield/{id}', ['uses' => 'SiteShieldController@withdrawShield']);
    Route::any('withdrawUnshield/{id}', ['uses' => 'SiteShieldController@withdrawUnshield']);
    Route::any('approveShield/{id}', ['uses' => 'SiteShieldController@approveShield']);
    Route::any('approveUnshield/{id}', ['uses' => 'SiteShieldController@approveUnshield']);
    Route::any('denyShield/{id}', ['uses' => 'SiteShieldController@denyShield']);
    Route::any('denyUnshield/{id}', ['uses' => 'SiteShieldController@denyUnshield']);


});

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/osReasonFill'], function () {

    Route::any('/', ['uses' => 'OsReasonFillController@indexPage']);
    Route::any('add/{id}', ['uses' => 'OsReasonFillController@add']);
});

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/excepHandle'], function () {

    Route::any('importSiteInfo', ['uses' => 'ExcepHandleController@indexPage']);
    Route::any('update/{id}', ['uses' => 'ExcepHandleController@updateSiteInfo']);
    Route::any('deny/{id}', ['uses' => 'ExcepHandleController@denySiteInfo']);
});

Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/eventLog'], function () {

    Route::any('/', ['uses' => 'EventLogController@indexPage']);
});


Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/siteStats'], function () {

    Route::any('/', ['uses' => 'SiteStatsController@indexPage']);
});





