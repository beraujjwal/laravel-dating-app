<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GendersController;
use App\Http\Controllers\AgeGroupsController;
use App\Http\Controllers\FaceBookController;
use App\Http\Controllers\FirebasesController;
use App\Http\Controllers\GooglesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ProfessionsController;
use App\Http\Controllers\InterestsController;
use App\Http\Controllers\FriendsController;
use App\Http\Controllers\CallsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/login', [UsersController::class, 'accessdeny'])->name('login');

// Facebook Login URL
Route::prefix('facebook')->name('facebook.')->group( function(){
    Route::get('auth', [FaceBookController::class, 'loginUsingFacebook'])->name('login');
    Route::get('callback', [FaceBookController::class, 'callbackFromFacebook'])->name('callback');
});



// Facebook Login URL
Route::prefix('v1')->name('api.')->group( function(){

    Route::prefix('genders')->name('genders.')->group( function(){
        Route::get('/', [GendersController::class, 'index'])->name('genders');
    });

    Route::prefix('agegroups')->name('agegroups.')->group( function(){
        Route::get('/', [AgeGroupsController::class, 'index'])->name('agegroups');
        Route::get('/{gender}', [AgeGroupsController::class, 'age_groups_by_gender'])->name('agegroupsbysex');
    });

    Route::prefix('professions')->name('professions.')->group( function(){
        Route::get('/', [ProfessionsController::class, 'index'])->name('professions');
    });

    Route::prefix('interests')->name('interests.')->group( function(){
        Route::get('/', [InterestsController::class, 'index'])->name('interests');
    });

    Route::prefix('auth')->name('auth.')->group( function(){
        Route::prefix('facebook')->name('facebook.')->group( function(){
            Route::get('/login', [FaceBookController::class, 'facebookLoginUrl'])->name('login');
            Route::get('/callback', [FaceBookController::class, 'facebookLoginCallback'])->name('callback');
        });
        Route::prefix('google')->name('facebook.')->group( function(){
            Route::get('/login', [GooglesController::class, 'googleLoginUrl'])->name('login');
            Route::get('/callback', [GooglesController::class, 'googleLoginCallback'])->name('callback');
        });
        Route::post('/firebase', [FirebasesController::class, 'index'])->name('firebase');

        Route::prefix('user')->name('user.')->group( function(){
            Route::post('/loginorregister', [UsersController::class, 'doLoginOrRegister'])->name('login');
            
        });
    });

});



Route::group(['middleware' => ['auth:api'], 'prefix' => 'v1'], function () {
    Route::prefix('user')->name('user.')->group( function(){
        Route::get('/get-profile', [UsersController::class, 'getProfile'])->name('profile');
        Route::post('/update-profile', [UsersController::class, 'updateProfile'])->name('update');
    });

    Route::prefix('user')->name('user.')->group( function(){
        Route::post('/friend-request-send', [FriendsController::class, 'friendRequestSend'])->name('request');
        Route::post('/friend-request-accept', [FriendsController::class, 'friendRequestAccept'])->name('accept');

        Route::get('/friends-list', [FriendsController::class, 'friendsList'])->name('friend-list');
        Route::get('/friend-request-sent', [FriendsController::class, 'friendRequestSent'])->name('request-sent');
        Route::get('/friend-request-received', [FriendsController::class, 'friendRequestReceived'])->name('request-received');
    });

    Route::prefix('user')->name('user.')->group( function(){
        Route::post('/called', [CallsController::class, 'called'])->name('called');
        
        Route::get('/all-call', [CallsController::class, 'allCallList'])->name('all-call');
        Route::get('/received-call', [CallsController::class, 'receivedCallList'])->name('received-call');
        Route::get('/dialed-call', [CallsController::class, 'dialedCallList'])->name('dialed-call');
        Route::get('/missed-call', [CallsController::class, 'missedCallList'])->name('missed-call');
    });
    
});
