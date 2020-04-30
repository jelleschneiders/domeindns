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

use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect('home');
});

Route::get('/home', 'HomeController@index');

Route::get('/legal/tos', function () { return view('legal.tos'); });
Route::get('/legal/privacy', function () { return view('legal.privacy'); });
Route::get('/legal/responsible-disclosure', function () { return view('legal.responsible_disclosure'); })->middleware(['auth', 'verified', 'two_factor']);

Auth::routes(['verify' => true]);

Route::get('/2fa', 'TOTPController@index');
Route::post('/2fa', 'TOTPController@verify');

Route::post('/logout-to-user', 'LogoutController@logout');

Route::get('/domains', 'ZonesController@index');
Route::post('/domains', 'ZonesController@search');
Route::get('/domains/tag/{tagid}', 'ZonesController@indexTag');
Route::get('/domain/create', function () { return view('domains.create'); })->middleware(['auth', 'verified', 'two_factor']);
Route::post('/domain/create', 'ZonesController@store');
Route::get('/domain/create/template', 'ZonesController@storeTemplateView');
Route::post('/domain/create/template', 'ZonesController@storeTemplate');
Route::get('/domain/{domain}/delete', 'ZonesController@returnDeletePage');
Route::delete('/domain/{domain}/delete', 'ZonesController@destroy');
Route::get('/domain/{domain}/records', 'RecordController@index');
Route::get('/domain/{domain}/retry', 'ZoneRetryController@show');
Route::post('/domain/{domain}/retry', 'ZoneRetryController@update');
Route::get('/domain/{domain}/records/create', 'RecordController@returnCreatePage');
Route::post('/domain/{domain}/records/create', 'RecordController@store');
Route::get('/domain/{domain}/records/create/preset', 'RecordController@returnPresetPage');
Route::post('/domain/{domain}/records/create/preset', 'RecordController@storePreset');
Route::get('/domain/{domain}/records/{record}/retry', 'RecordRetryController@show');
Route::post('/domain/{domain}/records/{record}/retry', 'RecordRetryController@update');
Route::delete('domain/{domain}/records/{record}/delete', 'RecordController@destroy');
Route::get('/domain/{domain}/records/{record}/edit', 'RecordController@show');
Route::patch('/domain/{domain}/records/{record}/edit', 'RecordController@update');
Route::get('/domain/{domain}/dnssec', 'ZonesController@showDNSSEC');
Route::post('/domain/{domain}/dnssec', 'ZonesController@storeDNSSEC');
Route::delete('/domain/{domain}/dnssec', 'ZonesController@destroyDNSSEC');

Route::get('/account/api-key', function () { return view('account.api'); })->middleware(['auth', 'verified', 'two_factor']);
Route::patch('/account/api-key', 'ApiController@update');
Route::get('/account/password/change', function () { return view('account.password'); })->middleware(['auth', 'verified', 'two_factor']);
Route::patch('/account/password/change', 'UserController@updatePassword');
Route::get('/account/delete', function () { if(isset(auth()->user()->managed_by)){abort(404);} return view('account.delete'); })->middleware(['auth', 'verified', 'two_factor']);
Route::delete('/account/delete', 'UserController@destroy');
Route::get('/account/nameservers', 'NameserverController@index');
Route::get('/account/nameservers/change', 'NameserverController@show');
Route::post('/account/nameservers/change', 'NameserverController@store');
Route::delete('/account/nameservers/change', 'NameserverController@destroy');

Route::get('/account/2fa', 'UserController@return2FAView');
Route::post('/account/2fa', 'UserController@enable2FA');
Route::delete('/account/2fa', 'UserController@disable2FA');

Route::get('/templates', 'TemplateController@index');
Route::get('/template/create', function () { return view('templates.create'); })->middleware(['auth', 'verified', 'two_factor']);
Route::post('/template/create', 'TemplateController@store');
Route::get('/template/create-from-domain', 'TemplateController@showCreateDomain');
Route::post('/template/create-from-domain', 'TemplateController@storeDomain');
Route::get('/template/{id}', 'TemplateController@show');
Route::get('/template/{id}/delete', 'TemplateController@destroyView');
Route::delete('/template/{id}/delete', 'TemplateController@destroy');
Route::get('/template/{id}/records/{recordid}/edit', 'TemplateRecordController@show');
Route::patch('/template/{id}/records/{recordid}/edit', 'TemplateRecordController@update');
Route::get('/template/{id}/records/create', 'TemplateRecordController@storeView');
Route::post('/template/{id}/records/create', 'TemplateRecordController@store');
Route::delete('/template/{id}/records/{recordid}/delete', 'TemplateRecordController@destroy');

Route::get('/tags', 'TagController@index');
Route::get('/tags/create', function () { return view('tags.create'); })->middleware(['auth', 'verified', 'two_factor']);
Route::post('/tags/create', 'TagController@store');
Route::get('/tags/{id}', 'TagController@show');
Route::patch('/tags/{id}', 'TagController@update');
Route::delete('/tags/{id}', 'TagController@destroy');
Route::get('/tags/{id}/assign', 'TagController@showAssign');
Route::get('/tags/{id}/dismiss', 'TagController@showDismiss');
Route::post('/tags/{id}/assign', 'TagController@assign');
Route::post('/tags/{id}/dismiss', 'TagController@dismiss');

Route::get('/notifications', 'NotificationController@index');
Route::get('/notifications/{id}', 'NotificationController@show');
Route::delete('/notifications/{id}', 'NotificationController@destroy');

Route::get('/account/export', 'ExportController@index');
Route::post('/account/export', 'ExportController@create');
Route::personalDataExports('personal-data-exports');

Route::get('/account/settings', 'UserController@index');
Route::patch('/account/settings', 'UserController@update');

Route::get('/domains/transfer', 'TransferController@index');
Route::get('/domains/transfer/new', 'TransferController@storeView');
Route::post('/domains/transfer/new', 'TransferController@store');
Route::patch('/domains/transfer/{id}', 'TransferController@update');

// admin area
Route::get('/admin/users', 'AdminController@userIndex');
Route::get('/admin/users/{id}', 'AdminController@userView');
Route::patch('/admin/users/{id}/block', 'AdminController@blockUser');
Route::patch('/admin/users/{id}/reseller', 'AdminController@resellerUser');

Route::get('/admin/users/{id}/notification', 'AdminController@notifyUserindex');
Route::post('/admin/users/{id}/notification', 'AdminController@notifyUserstore');

Route::get('/admin/reseller/requests', 'AdminController@resellerRequestOverview');
Route::post('/admin/reseller/requests', 'AdminController@updateResellerRequest');

Route::post('/admin/users/{id}/login', 'AdminController@login');

// reseller request
Route::get('/reseller/request', 'UserController@requestResellerpage');
Route::post('/reseller/request', 'UserController@requestReseller');

// reseller area
Route::get('/reseller/users', 'ResellerController@index');
Route::get('/reseller/users/create', 'ResellerController@showCreate');
Route::post('/reseller/users/create', 'ResellerController@store');
Route::get('/reseller/users/{id}', 'ResellerController@show');
Route::patch('/reseller/users/{id}/block', 'ResellerController@blockUser');
Route::post('/reseller/users/{id}/login', 'ResellerController@login');
Route::delete('/reseller/users/{id}/delete', 'ResellerController@destroy');
Route::get('/reseller/users/{id}/edit', 'ResellerController@showedit');
Route::patch('/reseller/users/{id}/edit', 'ResellerController@edit');
Route::patch('/reseller/users/{id}/2fa', 'ResellerController@reset2fa');
