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
/**
 * 首页
 */
Route::any('backend', ['uses' => 'HomeController@index']);

/**
 * 首页-待办事项
 */
Route::any('backend/todoHandlePage/{id}', ['uses' => 'HomeController@todoHandlePage', 'middleware' => ['auth', 'permission'], 'permissions' => ['is_verified']]);

/**
 * 站址信息管理
 */
Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/siteInfo'], function () {

    //站址信息查询
    Route::any('/', ['uses' => 'SiteInfoController@indexPage', 'permissions' => ['site_view_basic', 'is_verified']]);
    //站址信息修改页
    Route::post('editPage/{id}', ['uses' => 'SiteInfoController@editPage', 'permissions' => ['site_modify', 'is_verified']]);
    //新建站新增页
    Route::any('addNewPage', ['uses' => 'SiteInfoController@addNewPage', 'permissions' => ['site_add', 'is_verified']]);
    //存量站新增页
    Route::any('addOldPage', ['uses' => 'SiteInfoController@addOldPage', 'permissions' => ['site_add', 'is_verified']]);
    //新增新建站
    Route::post('addNew', ['uses' => 'SiteInfoController@addNewDB', 'permissions' => ['site_add', 'is_verified']]);
    //新增存量站
    Route::post('addOld', ['uses' => 'SiteInfoController@addOldDB', 'permissions' => ['site_add', 'is_verified']]);
    //修改站址属性
    Route::post('update', ['uses' => 'SiteInfoController@update', 'permissions' => ['site_modify', 'is_verified']]);
    //删除站址
    Route::get('delete/{id}', ['uses' => 'SiteInfoController@delete', 'permissions' => ['site_delete', 'is_verified']]);
    //导出站址信息
    Route::post('export', ['uses' => 'ExcelController@exportSiteInfo', 'permissions' => ['site_batch_export', 'is_verified']]);
    //导入站址信息
    Route::post('import', ['uses' => 'ExcelController@importSiteInfo', 'permissions' => ['site_batch_import', 'is_verified']]);
    //下载站址信息导入模板
    Route::post('download', ['uses' => 'SiteInfoController@downloadSiteInfoTemplate', 'permissions' => ['is_verified']]);

    //返回
    Route::post('back', ['uses' => 'SiteInfoController@back', 'permissions' => ['site_view_basic']]);

    Route::any('test', ['uses' => 'SiteInfoController@test', 'permissions' => ['site_view_basic']]);

});

/**
 * 发电记录管理
 */
Route::group(['middleware' => ['auth', 'permission'], 'permissions' => ['gnr_manage', 'is_verified'], 'namespace' => 'Backend', 'prefix' => 'backend/gnrRec'], function () {
    //发电记录查询
    Route::any('/', ['uses' => 'GnrRecController@indexPage']);
    // Route::any('indexGnr', ['uses' => 'GnrRecController@indexPage_gnr']);
    //发电申请填报页
    Route::any('addPage', ['uses' => 'GnrRecController@addPage']);
    //发电结果填报页
    Route::any('handlePage/{id}', ['uses' => 'GnrRecController@handlePage']);
    //发电结果填报
    Route::any('handleGnr/{id}', ['uses' => 'GnrRecController@handleGnr']);
    // 发电申请填报
    Route::any('add', ['uses' => 'GnrRecController@addGnr']);
    //返回
    Route::any('back', ['uses' => 'GnrRecController@back']);
    Route::any('withdraw/{id}', ['uses' => 'GnrRecController@withdraw']);
    Route::any('export', ['uses' => 'ExcelController@exportGnrRec']);
    Route::any('associatedSearch', ['uses' => 'GnrRecController@associatedSearch']);
    // Route::any('{gnrID}/editPage/{siteID}/{siteChoose}/{lastGnrTime}', ['uses' => 'GnrRecController@editPage']);
    // Route::any('update', ['uses' => 'GnrRecController@update']);
    // Route::get('delete/{id}', ['uses' => 'GnrRecController@delete']);
    // Route::any('import', ['uses' => 'GnrRecController@importGnrRec']);
    // Route::post('export', ['uses' => 'ExcelController@exportGnrRec']);
});

/**
 * 账单管理
 */
Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/servBill'], function () {

    // 账单查询
    Route::any('/', ['uses' => 'ServBillController@indexPage', 'permissions' => ['bill_view', 'is_verified']]);
    Route::get('freeGnr', ['uses' => 'ServBillController@viewFreeGnrPage', 'permissions' => ['bill_view', 'is_verified']]);
    Route::get('billGnr', ['uses' => 'ServBillController@viewBillGnrPage', 'permissions' => ['bill_view', 'is_verified']]);
    Route::get('site', ['uses' => 'ServBillController@viewSitePage', 'permissions' => ['bill_view', 'is_verified']]);
    Route::get('deduction1', ['uses' => 'ServBillController@viewDeduction1Page', 'permissions' => ['bill_view', 'is_verified']]);
    Route::get('deduction2', ['uses' => 'ServBillController@viewDeduction2Page', 'permissions' => ['bill_view', 'is_verified']]);
    Route::post('createBill', ['uses' => 'ServBillController@createBill', 'permissions' => ['bill_view', 'is_verified']]);
    Route::post('doOut', ['uses' => 'ServBillController@doOut', 'permissions' => ['bill_view', 'is_verified', 'bill_out']]);
    Route::any('billCheck', ['uses' => 'ServBillController@billCheck', 'permissions' => ['bill_view', 'is_verified', 'bill_out']]);
    Route::any('billCheck/bills', ['uses' => 'ServBillController@billCheck', 'permissions' => ['bill_view', 'is_verified', 'bill_out']]);
    Route::any('billCheck/orders/{id}', ['uses' => 'ServBillController@orderCheck', 'permissions' => ['bill_view', 'is_verified', 'bill_out']]);
    Route::any('billCheck/orders/view/{id}', ['uses' => 'ServBillController@viewOrders', 'permissions' => ['bill_view', 'is_verified', 'bill_out']]);
    Route::any('billCheck/orders/editPage/{id}', ['uses' => 'ServBillController@editPage', 'permissions' => ['bill_view', 'is_verified', 'bill_out']]);
    Route::any('billCheck/orders/update/{id}', ['uses' => 'ServBillController@updateOrder', 'permissions' => ['bill_view', 'is_verified', 'bill_out']]);
    Route::any('billCheck/orders/delete/{id}', ['uses' => 'ServBillController@deleteOrder', 'permissions' => ['bill_view', 'is_verified', 'bill_out']]);
    Route::any('irontowerBillImportPage', ['uses' => 'ServBillController@irontowerBillImportPage', 'permissions' => ['bill_view', 'is_verified', 'bill_out']]);
    Route::any('irontowerBillImportPage', ['uses' => 'ServBillController@irontowerBillImportPage', 'permissions' => ['bill_view', 'is_verified', 'bill_out']]);

});

// Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/servCost'], function () {

//     // 服务费用列表
//     Route::any('/', ['uses' => 'ServCostController@indexPage', 'permissions' => ['site_view_basic', 'is_verified']]);
//     Route::any('editPage/{id}/{region}', ['uses' => 'ServCostController@editPage']);
//     Route::post('update/{id}', ['uses' => 'ServCostController@update', 'permissions' => ['single_update', 'is_verified']]);
//     Route::post('back', ['uses' => 'ServCostController@back']);
//     Route::get('delete/{id}', ['uses' => 'ServCostController@delete', 'permissions' => ['delete', 'is_verified']]);
//     Route::any('addPage', ['uses' => 'ServCostController@addPage']);
//     Route::post('add', ['uses' => 'ServCostController@add']);
//     Route::post('export', ['uses' => 'ExcelController@exportServCost', 'permissions' => ['bulk_export', 'is_verified']]);
// });

/**
 * 基准价格管理
 */
Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/rentStd'], function () {
    Route::any('/', ['uses' => 'RentStdController@indexPage', 'permissions' => ['site_view_basic', 'is_verified']]);
    Route::any('fee_std_search', ['uses' => 'RentStdController@fee_std_search', 'permissions' => ['site_view_basic', 'is_verified']]);
    Route::any('basic_fee_update/{seq}/{region}/{fee_type}', ['uses' => 'RentStdController@basic_fee_update', 'permissions' => ['site_view_basic', 'is_verified']]);
    Route::any('site_fee_update/{seq}', ['uses' => 'RentStdController@site_fee_update', 'permissions' => ['site_view_basic', 'is_verified']]);
    Route::any('elec_introduced_fee_update/{seq}', ['uses' => 'RentStdController@elec_introduced_fee_update', 'permissions' => ['site_view_basic', 'is_verified']]);
    Route::any('share_discount_update/{seq}', ['uses' => 'RentStdController@share_discount_update', 'permissions' => ['site_view_basic', 'is_verified']]);
    Route::any('update_basic_fee', ['uses' => 'RentStdController@update_basic_fee', 'permissions' => ['single_update', 'is_verified']]);
    Route::any('update_elec_introduced_fee', ['uses' => 'RentStdController@update_elec_introduced_fee', 'permissions' => ['single_update', 'is_verified']]);
    Route::any('update_site_fee', ['uses' => 'RentStdController@update_site_fee', 'permissions' => ['single_update', 'is_verified']]);
    Route::any('update_share_discount', ['uses' => 'RentStdController@update_share_discount', 'permissions' => ['single_update', 'is_verified']]);
    Route::post('exportBasicFee', ['uses' => 'ExcelController@exportBasicFee', 'permissions' => ['bulk_export', 'is_verified']]);
    Route::post('exportSiteFee', ['uses' => 'ExcelController@exportSiteFee', 'permissions' => ['bulk_export', 'is_verified']]);
    Route::post('exportElecImportFee', ['uses' => 'ExcelController@exportElecImportFee', 'permissions' => ['bulk_export', 'is_verified']]);
    Route::post('exportDiscount', ['uses' => 'ExcelController@exportDiscount', 'permissions' => ['bulk_export', 'is_verified']]);
});

// Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/elecCharge'], function () {
//     Route::any('/', ['uses' => 'ElecChargeController@indexPage']);
//     Route::any('/edit', ['uses' => 'ElecChargeController@editPage']);
//     Route::any('/back', ['uses' => 'ElecChargeController@indexPage']);
//     Route::any('/add', ['uses' => 'ElecChargeController@addPage']);

// });
Route::resource('users', 'UsersController');
/**
 * 用户注册
 */

Route::get('auth/register', 'Auth\AuthController@getRegister');
/**
 * 密码重置
 */
Route::get('auth/reset', 'Auth\AuthController@getReset');
/**
 * 修改密码
 */
Route::post('auth/update', 'Auth\AuthController@postUpdate');
/**
 * 密码重置
 */
Route::post('auth/reset', 'Auth\AuthController@postReset');

/**
 * 用户管理
 */
Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/userManage', 'permissions' => ['is_verified']], function () {
    Route::get('/', ['uses' => 'UserManageController@indexPage']);
    Route::any('verify/{id}', ['uses' => 'UserManageController@verifyPermission']);
    Route::any('update/{id}', ['uses' => 'UserManageController@updatePermission']);
});

// Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/otherCost'], function () {

//     Route::any('/', ['uses' => 'otherCostController@indexPage']);
//     Route::post('addPage', ['uses' => 'otherCostController@addPage']);
//     Route::post('add', ['uses' => 'otherCostController@addDB']);
//     Route::post('editPage/{id}/{region}', ['uses' => 'otherCostController@editPage']);
//     Route::post('edit/{id}', ['uses' => 'otherCostController@editDB']);
//     Route::post('back', ['uses' => 'otherCostController@back']);
//     Route::get('delete/{id}', ['uses' => 'otherCostController@delete']);


// });

/**
 * 上站记录管理
 */
Route::group(['middleware' => ['auth', 'permission'], 'permissions' => ['site_check_manage', 'is_verified'], 'namespace' => 'Backend', 'prefix' => 'backend/siteCheck'], function () {
    Route::any('/', ['uses' => 'SiteCheckController@indexPage']);
    Route::any('handlePage/{id}', ['uses' => 'SiteCheckController@handlePage']);
    Route::any('addPage', ['uses' => 'SiteCheckController@addPage']);
    Route::any('add', ['uses' => 'SiteCheckController@add']);
    Route::any('handle', ['uses' => 'SiteCheckController@handle']);
});

/**
 * 屏蔽记录管理
 */
Route::group(['middleware' => ['auth', 'permission'], 'permissions' => ['site_shield_manage', 'is_verified'], 'namespace' => 'Backend', 'prefix' => 'backend/siteShield'], function () {
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
    Route::any('downloadAttachment/{id}', ['uses' => 'SiteShieldController@downloadAttachment']);
    Route::any('exportSiteShields', ['uses' => 'ExcelController@exportSiteShields']);
});

/**
 * 退服原因管理
 */
Route::group(['middleware' => ['auth', 'permission'], 'permissions' => ['os_reason_manage', 'is_verified'], 'namespace' => 'Backend', 'prefix' => 'backend/osReasonFill'], function () {
    Route::any('/', ['uses' => 'OsReasonFillController@indexPage']);
    Route::any('add/{id}', ['uses' => 'OsReasonFillController@add']);
    Route::any('export', ['uses' => 'ExcelController@exportOsReasons']);
});

/**
 * 异常处理
 */
Route::group(['middleware' => ['auth', 'permission'], 'permissions' => ['site_batch_import', 'is_verified'], 'namespace' => 'Backend', 'prefix' => 'backend/excepHandle'], function () {
    Route::any('importSiteInfo', ['uses' => 'ExcepHandleController@indexPage']);
    Route::any('update/{id}', ['uses' => 'ExcepHandleController@updateSiteInfo']);
    Route::any('deny/{id}', ['uses' => 'ExcepHandleController@denySiteInfo']);
});

/**
 * 日志管理
 */
Route::group(['middleware' => ['auth', 'permission'], 'namespace' => 'Backend', 'prefix' => 'backend/eventLog'], function () {
    Route::any('/', ['uses' => 'EventLogController@indexPage']);
});

/**
 * 站址信息统计
 */
Route::group(['middleware' => ['auth', 'permission'], 'permissions' => ['site_view_advance', 'is_verified'], 'namespace' => 'Backend', 'prefix' => 'backend/siteStats'], function () {
    Route::any('/', ['uses' => 'SiteStatsController@indexPage']);
    Route::any('import', ['uses' => 'ExcelController@importBillDetail']);
    Route::any('export', ['uses' => 'ExcelController@exportSiteStats']);
    Route::any('testExport', ['uses' => 'ExcelController@exportSiteStatsTemp']);
    Route::any('test', ['uses' => 'SiteStatsController@test']);
});



