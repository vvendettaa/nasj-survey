<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('landing.home');
});

Route::get('/import', ['as' => 'import', 'uses' => 'Admin\ImportController@index']);

Route::get('admin/test-view', ['as' => 'test-view', 'uses' => 'Admin\EmployeeCrudController@view_test']);
Route::get('admin/test-view/employees', ['as' => 'get-tree-employees', 'uses' => 'Admin\EmployeeCrudController@get_employees']);
Route::post('admin/test-view/employees', ['as' => 'get-tree-employees', 'uses' => 'Admin\EmployeeCrudController@get_employees']);


Route::auth();
Route::get('logout', 'Auth\LoginController@logout');

Route::group(['prefix' => 'admin', 'middleware' => ['role:super_admin|admin|cxo|manager|sys']], function() {
  Route::get('/', 'Admin\AdminController@index');
});

Route::group(['prefix' => 'admin', 'middleware' => ['role:super_admin|admin|cxo|manager']], function() {
    Route::get('/dashboard', 'Admin\AdminController@dashboard');
});

Route::group(['prefix' => 'admin', 'middleware' => ['role:super_admin|admin']], function() {
    CRUD::resource('survey', 'Admin\SurveyCrudController');
    CRUD::resource('question_section', 'Admin\Question_sectionCrudController');
    CRUD::resource('question', 'Admin\QuestionCrudController');

    CRUD::resource('employee', 'Admin\EmployeeCrudController');
    CRUD::resource('directory_import', 'Admin\Directory_importCrudController');
    CRUD::resource('question_import', 'Admin\Question_importCrudController');
});

Route::group(['prefix' => 'admin', 'middleware' => ['role:super_admin|admin|sys']], function() {
    CRUD::resource('user', 'Admin\UserCrudController');
});
