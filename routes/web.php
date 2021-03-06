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

Route::get('/', ['as' => 'landing page', 'uses' => 'Home\SurveyController@index']);
Route::get('/test', function(){
  return view('employee-tree');
});
Route::get('/test2', function(){
  return view('special-child-question');
});

Route::group(['middleware' => ['role:super_admin|admin|cxo|manager|emp|sys']], function(){
  Route::get('/s/{slug}', ['as' => 'survey page', 'uses' => 'Home\SurveyController@getSurvey']);
  Route::post('/s/getquestions', ['as' => 'ajax getquestions', 'uses' => 'Home\SurveyController@getQuestions']);
  Route::post('/s/savesection', ['as' => 'ajax savesection', 'uses' => 'Home\SurveyController@saveSection']);
  Route::post('/s/sectionprogress', ['as' => 'ajax sectionprogress', 'uses' => 'Home\SurveyController@getSectionProgress']);
  Route::post('/s/progress', ['as' => 'ajax surveyprogress', 'uses' => 'Home\SurveyController@getSurveyProgress']);
  Route::post('/s/employees-directory', ['as' => 'ajax employee directory', 'uses' => 'Home\SurveyController@getEmployeeDirectory']);
  Route::post('/s/employees-list', ['as' => 'ajax employee list', 'uses' => 'Home\SurveyController@getEmployeeList']);
  Route::post('/s/question-panel', ['as' => 'ajax question panel', 'uses' => 'Home\SurveyController@getQuestionPanel']);
  Route::post('/s/question-list', ['as' => 'ajax question panel list', 'uses' => 'Home\SurveyController@getQuestionlist']);
  Route::post('/s/submit-survey', ['as' => 'ajax submit survey', 'uses' => 'Home\SurveyController@submitSurvey']);
  Route::post('/s/q-section-prog', ['as' => 'ajax question section progress', 'uses' => 'Home\SurveyController@getQuestionSectionProgress']);
});

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

    CRUD::resource('submitted_survey', 'Admin\Submitted_surveyCrudController');
});

Route::group(['prefix' => 'admin', 'middleware' => ['role:super_admin|admin|sys']], function() {
    CRUD::resource('user', 'Admin\UserCrudController');
});
