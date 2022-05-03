<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\GendersController;
use App\Http\Controllers\AgeGroupsController;
use App\Http\Controllers\ProfessionsController;
use App\Http\Controllers\InterestsController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/privacy-policy', function () {
    return view('welcome');
});
Route::get('/terms', function () {
    return view('welcome');
});

Route::group(['middleware' => 'web'], function () {

    Route::get('/admin', [UsersController::class, 'login'])->name('admin-login');
    Route::post('/admin', [UsersController::class, 'doLogin'])->name('admin-dologin');

    Route::prefix('admin')->name('admin.')->group( function(){
        Route::get('/logout', [UsersController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [UsersController::class, 'dashboard'])->name('dashboard');

        //User web route
        Route::get('/users', [UsersController::class, 'usersList'])->name('users');
        Route::get('/users-by-ajax', [UsersController::class, 'usersListbyAjax'])->name('users-by-ajax');
        Route::get('/user/edit/{user}', [UsersController::class, 'userEdit'])->name('user-edit');
        Route::post('/user/update/{user}', [UsersController::class, 'userUpdate'])->name('user-update');
        Route::delete('/user/delete/{user}', [UsersController::class, 'userDelete'])->name('user-delete');

        //Gender web route
        Route::get('/genders', [GendersController::class, 'gendersList'])->name('genders');
        Route::get('/gender/add', [GendersController::class, 'genderAdd'])->name('gender-add');
        Route::post('/gender/store', [GendersController::class, 'genderStore'])->name('gender-store');
        Route::get('/gender/edit/{gender}', [GendersController::class, 'genderEdit'])->name('gender-edit');
        Route::post('/gender/update/{gender}', [GendersController::class, 'genderUpdate'])->name('gender-update');
        Route::delete('/gender/delete/{gender}', [GendersController::class, 'genderDelete'])->name('gender-delete');

        //Profession web route
        Route::get('/professions', [ProfessionsController::class, 'professionsList'])->name('professions');
        Route::get('/profession/add', [ProfessionsController::class, 'professionAdd'])->name('profession-add');
        Route::post('/profession/store', [ProfessionsController::class, 'professionStore'])->name('profession-store');
        Route::get('/profession/edit/{profession}', [ProfessionsController::class, 'professionEdit'])->name('profession-edit');
        Route::post('/profession/update/{profession}', [ProfessionsController::class, 'professionUpdate'])->name('profession-update');
        Route::delete('/profession/delete/{profession}', [ProfessionsController::class, 'professionDelete'])->name('profession-delete');

        //Interest web route
        Route::get('/interests', [InterestsController::class, 'interestsList'])->name('interests');
        Route::get('/interest/add', [InterestsController::class, 'interestAdd'])->name('interest-add');
        Route::post('/interest/store', [InterestsController::class, 'interestStore'])->name('interest-store');
        Route::get('/interest/edit/{interest}', [InterestsController::class, 'interestEdit'])->name('interest-edit');
        Route::post('/interest/update/{interest}', [InterestsController::class, 'interestUpdate'])->name('interest-update');
        Route::delete('/interest/delete/{interest}', [InterestsController::class, 'interestDelete'])->name('interest-delete');

        //Interest web route
        Route::get('/agegroups', [AgeGroupsController::class, 'agegroupsList'])->name('agegroups');
        Route::get('/agegroup/add', [AgeGroupsController::class, 'agegroupAdd'])->name('agegroup-add');
        Route::post('/agegroup/store', [AgeGroupsController::class, 'agegroupStore'])->name('agegroup-store');
        Route::get('/agegroup/edit/{agegroup}', [AgeGroupsController::class, 'agegroupEdit'])->name('agegroup-edit');
        Route::post('/agegroup/update/{agegroup}', [AgeGroupsController::class, 'agegroupUpdate'])->name('agegroup-update');
        Route::delete('/agegroup/delete/{agegroup}', [AgeGroupsController::class, 'agegroupDelete'])->name('agegroup-delete');


    });



});
