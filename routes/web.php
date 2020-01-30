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


Route::get('/login', [
	'uses' => 'UserController@getLogin',
	'as' => 'admin.login'
]);

Route::post('/login', [
	'uses' => 'UserController@postLogin',
	'as' => 'admin.login'
]);

Route::group([
	'middleware' => 'auth'
], function () {
    Route::get('/logout', [
		'uses' => 'UserController@getLogout',
		'as' => 'admin.logout'
    ]);
    
    Route::get('/', [
        'uses' => 'SetoranController@getSetoranIndex',
        'as' => 'admin.setoran'
    ]);
    
    // Pengolahan Data Sapi
    Route::get('/sapi', [
        'uses' => 'SapiController@getSapiIndex',
        'as' => 'admin.sapi'
    ]);
    Route::get('/sapi/create', [
        'uses' => 'SapiController@getCreateSapi',
        'as' => 'admin.sapi.create'
    ]);
    Route::post('/sapi/create', [
        'uses' => 'SapiController@postCreateSapi',
        'as' => 'admin.sapi.create'
    ]);
    Route::get('/sapi/delete/{kode_sapi}', [
        'uses' => 'SapiController@getDeleteSapi',
        'as' => 'admin.sapi.delete'
    ]);
    Route::get('/sapi/edit/{kode_sapi}', [
        'uses' => 'SapiController@getUpdateSapi',
        'as' => 'admin.sapi.edit'
    ]);
    Route::post('/sapi/update', [
        'uses' => 'SapiController@postUpdateSapi',
        'as' => 'admin.sapi.update'
    ]);

    // Pengolahan Data Pakan
    Route::get('/pakan', [
        'uses' => 'PakanController@getPakanIndex',
        'as' => 'admin.pakan'
    ]);
    Route::get('/pakan/create', [
        'uses' => 'PakanController@getCreatePakan',
        'as' => 'admin.pakan.create'
    ]);
    Route::post('/pakan/create', [
        'uses' => 'PakanController@postCreatePakan',
        'as' => 'admin.pakan.create'
    ]);
    Route::get('/pakan/edit/{id_penyetokan}', [
        'uses' => 'PakanController@getUpdatePakan',
        'as' => 'admin.pakan.edit'
    ]);
    Route::post('/pakan/update', [
        'uses' => 'PakanController@postUpdatePakan',
        'as' => 'admin.pakan.update'
    ]);
    Route::get('/pakan/delete/{id_penyetokan}', [
        'uses' => 'PakanController@getDeletePakan',
        'as' => 'admin.pakan.delete'
    ]);
    Route::get('/pakan/detail/{id_penyetokan}', [
        'uses' => 'PakanController@getDetailPenyetokan',
        'as' => 'admin.pakan.detail'
    ]);
    Route::get('/pakan/cetak_pdf/{id_penyetokan}', [
        'uses' => 'PakanController@cetak_pdf',
        'as' => 'admin.pakan_detail.cetak_pdf'
    ]);


    // Pembagian Pakan
    Route::get('/pembagian_pakan', [
        'uses' => 'PembagianPakanController@getPembagianPakanIndex',
        'as' => 'admin.pembagian_pakan'
    ]);
    Route::get('/pembagian_pakan/cetak_pdf', [
        'uses' => 'PembagianPakanController@cetak_pdf',
        'as' => 'admin.pembagian_pakan.cetak_pdf'
    ]);

    // Pengelolaan Hasil Perahan
    Route::get('/perahan', [
        'uses' => 'PerahanController@getPerahanIndex',
        'as' => 'admin.perahan'
    ]);
    Route::get('/perahan/create', [
        'uses' => 'PerahanController@getCreatePerahan',
        'as' => 'admin.perahan.create'
    ]);
    Route::post('/perahan/create', [
        'uses' => 'PerahanController@postCreatePerahan',
        'as' => 'admin.perahan.create'
    ]);
    Route::get('/perahan/edit/{id_pemerahan}', [
        'uses' => 'PerahanController@getUpdatePerahan',
        'as' => 'admin.perahan.edit'
    ]);
    Route::post('/perahan/update', [
        'uses' => 'PerahanController@postUpdatePerahan',
        'as' => 'admin.perahan.update'
    ]);
    Route::get('/perahan/delete/{id_pemerahan}', [
        'uses' => 'PerahanController@getDeletePerahan',
        'as' => 'admin.perahan.delete'
    ]);

    // Pengelolaan Setoran
    Route::get('/setoran', [
        'uses' => 'SetoranController@getSetoranIndex',
        'as' => 'admin.setoran'
    ]);
    Route::get('/setoran/create', [
        'uses' => 'SetoranController@getCreateSetoran',
        'as' => 'admin.setoran.create'
    ]);
    Route::post('/setoran/create', [
        'uses' => 'SetoranController@postCreateSetoran',
        'as' => 'admin.setoran.create'
    ]);
    Route::get('/setoran/edit/{kode_setoran}', [
        'uses' => 'SetoranController@getUpdateSetoran',
        'as' => 'admin.setoran.edit'
    ]);
    Route::post('/setoran/update', [
        'uses' => 'SetoranController@postUpdateSetoran',
        'as' => 'admin.setoran.update'
    ]);
    Route::get('/setoran/delete/{kode_setoran}', [
        'uses' => 'SetoranController@getDeleteSetoran',
        'as' => 'admin.setoran.delete'
    ]);
    Route::get('/setoran/cetak_pdf', [
        'uses' => 'SetoranController@cetak_pdf',
        'as' => 'admin.setoran.cetak_pdf'
    ]);
});