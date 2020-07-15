<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('website.home');
});

// Route::get('/form-details', function () {
//     return view('website.plan.view_form');
// });


// Route::get('/plan', function () {
//     return view('website.plan.plan');
// });

// Route::get('/profile', function () {
//     return view('website.profile.view_profile');
// });


Route::get('/forgot', function () {
    return view('website.profile.forgot');
});


Route::get('/signup/{lession_id?}', function () {
    if(\Auth::check()){
        return redirect('/');
    }
    return view('website.profile.signup');
});

Route::get('/otp', function () {
    return view('website.profile.otp');
});

Route::get('/how-to-use', function () {
    return view('website.how_to_use');
});

Route::get('/delete-plan/{id}', 'Website\PlanController@deletePlan');
Route::get('/pdf/{id}', 'Website\PlanController@generatePdf');

Route::get('/units-and-skills', 'Website\PlanController@create');
Route::post('add-plan-form', 'Website\PlanController@store')->name('add-plan-form');
Route::post('share-plan', 'Website\PlanController@shareLesson')->name('share-plan');
Route::get('edit-plan-form/{id}', 'Website\PlanController@edit')->name('edit-plan-form');
Route::post('update-plan-form', 'Website\PlanController@update')->name('update-plan-form');
Route::get('/plan', 'Website\PlanController@getList')->name('plan');
Route::get('/form-details/{id}', 'Website\PlanController@getById');
Route::get('form-copy/{id}', 'Website\PlanController@formCopy');
// import sheet demo
Route::get('import-grade-field', 'Website\PlanController@importGradeField');
Route::get('create-database', 'Website\PlanController@createDatabase');
Route::post('create-database', 'Website\PlanController@storeDatabase');
Route::post('import-main-grade', 'Website\PlanController@importMainGrade');
Route::get('method-database','Website\PlanController@methodData');
Route::post('upload-method-data','Website\PlanController@uploadMethodData');

// Route::get('/form-details', function () {
//     return view('website.plan.view_form');
// });



Route::get('/get-field-options/{type}', 'Website\FieldOptionsController@getFieldOptionList')->name('get-field-options');
Route::get('/create-grade-options', 'Website\FieldOptionsController@create');
Route::post('/add-grade-options', 'Website\FieldOptionsController@store')->name('add-grade-options');
Route::post('/get-grade-options', 'Website\FieldOptionsController@getOptions')->name('get-grade-options');

Route::post('/upload-user-sheet', 'Website\PlanController@uploadSheetData');
Route::get('seo-meta', 'Website\PlanController@seo');
Route::post('seo', 'Website\PlanController@storeSeo');


Auth::routes(['register' => false, 'login' => false]);

// Route::get('login', function () {
//     if(\Auth::check()){
//         return redirect('/');
//     }
//     return view('website.profile.login');
// })->name('login');
Route::get('web-login/{lession_id?}', 'Website\UserController@checkLogin')->name('web-login');


// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/profile', function () {
//     return view('website.profile.view_profile');
// });
Route::get('/profile', 'Website\UserController@viewProfile');
Route::post('/send-otp', 'Website\UserController@sendOtp')->name('send-otp');

Route::post('user/update', 'Website\UserController@update');
Route::post('user/change-password', 'Website\UserController@changePassword');

Route::post('/user/register', 'Website\UserController@register');
Route::post('/user/verify-otp', 'Website\UserController@verifyOtp');
Route::post('/user/login-check', 'Website\UserController@login');
Route::get('logout', 'Website\UserController@logout');