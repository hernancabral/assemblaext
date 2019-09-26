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

Route::get('/redirect', 'Auth\LoginController@redirectToProvider')->name('google.redirect');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

Route::group(['middleware' => ['auth']], function () { 

    Route::get('/', function () {
        return redirect('/dashboard');
    });
    
    
    Route::patch('/users/{id}/reset','UserController@reset')->name('users.reset');
    Route::get('/users/{id}/reset', 'UserController@resetview')->name('users.reset');
    //Route::get('/ticket/{id}/clone', 'TicketController@clone')->name('ticket.clone');
    // Route::get('/spaces', 'SpaceController@update_spaces');
    Route::resource('users', 'UserController');
    Route::resource('dashboard', 'DashBoardController');
    Route::resource('tag', 'TagController');
    Route::resource('brand', 'BrandController');
    Route::resource('milestone', 'MilestoneController');
    Route::resource('planning', 'PlanningController');
    Route::resource('team', 'TeamController');
    Route::resource('people', 'PeopleController');
    Route::resource('ticket', 'TicketController');
    Route::put('prioritized', 'PrioritizedController@updateOrder');
    Route::get('prioritized/{prioritized}/refresh', 'PrioritizedController@refresh')->name('prioritized.refresh');;
    Route::get('prioritized/refresh_all', 'PrioritizedController@refresh_all')->name('prioritized.refresh_all');;
    Route::resource('prioritized', 'PrioritizedController');
    Route::resource('cloneticket', 'CloneTicketController');
    Route::post('migratetojira/migrate', 'MigrateToJiraController@migrate')->name('migratetojira.migrate');
    Route::get('migratetojira/nextStep', 'MigrateToJiraController@nextStep')->name('migratetojira.nextStep');
    Route::resource('migratetojira', 'MigrateToJiraController');
    
});


Auth::routes();
Route::get('/home', function (){
    return redirect('/dashboard');
});
// Route::get('/home', 'HomeController@index')->name('home');
