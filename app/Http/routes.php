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
    return view('welcome');
});

// Deal with locations
Route::get('/locations', ['as'=>'locations', 'uses'=>'LocationController@getAll']);
Route::get('/locations/{id}', ['as'=>'single location', 'uses'=>'LocationController@getSingle']);
Route::get('/locations/measurements/{location_id}/{type}/{format?}',
      ['as'=>'measurements',
      'uses'=>'LocationController@getMeasurement']);

Route::auth();

Route::get('/home', 'HomeController@index');

//Route::resource('measurement', 'MeasurementController');
Route::get('/measurement', ['as'=>'measurement', 'uses'=>'MeasurementController@getMeasurement']);

// deal with users
Route::get('/admin', ['middleware'=>'auth', 'as'=>'admin', 'uses'=>'AdminController@getAdmin']);
Route::get('/admin/users', ['middleware'=>'auth', 'as'=>'show users','uses'=>'AdminController@users']);
Route::post('/admin/users', ['middleware'=>'auth', 'uses'=>'AdminController@approve']);

// deal with probes
Route::get('/admin/probe/{id?}', ['middleware'=>'auth', 'as'=>'add or edit probe',
        'uses'=>'AdminController@getProbe']);
Route::post('/admin/probe/{id?}', ['middleware'=>'auth', 'uses'=>'AdminController@postProbe']);
Route::get('/admin/allprobes', ['middleware'=>'auth', 'as'=>'see all probes',
        'uses'=>'AdminController@getAllprobes']);

//Deal with machines
Route::get('/machine/add', ['middleware'=>'auth', 'as'=>'add machine','uses'=>'MachineController@getAdd']);
Route::post('/machine/add', ['middleware'=>'auth', 'uses'=>'MachineController@postAdd']);
Route::get('/machine/edit/{id}', ['middleware'=>'auth', 'as'=>'machine edit', 'uses'=>'MachineController@getEdit']);
Route::post('/machine/edit/{id}', ['middleware'=>'auth', 'uses'=>'MachineController@postEdit']);
Route::get('/admin/allmachines', ['middleware'=>'auth', 'as'=>'see all machines',
        'uses'=>'AdminController@getAllmachines']);
