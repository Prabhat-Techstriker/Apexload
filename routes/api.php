<?php

use Illuminate\Http\Request;

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

});


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('byEmailOtp', 'AuthController@byemailActivate');
    Route::post('/byPhoneOtp', 'AuthController@loginOtp')->name('byPhoneOtp');
    Route::post('/forgetpassword', 'Auth\ForgotPasswordController@forgetPassword');
    Route::post('/checkOtp', 'Auth\ForgotPasswordController@checkOtp');
    Route::post('/changePassword', 'Auth\ForgotPasswordController@changePassword');
    Route::post('/generateOtp', 'AuthController@generateOtp');
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::post('updateProfile', 'Admin\UsersController@updateProfile');
        Route::post('saveSetting', 'Admin\UsersController@saveSetting');
        Route::get('getProfile', 'Admin\UsersController@getProfile');
        Route::post('saveOriginDestination', 'Admin\UsersController@saveOriginDestination');
        Route::get('getPreferredlocation', 'Admin\UsersController@getPreferredlocation');
        Route::post('addPeople', 'Admin\UsersController@addPeople');

        Route::get('getResponsibility', 'ResponsibilitiesController@getResponsibility');
        Route::post('getAccountByresponsibityId', 'ResponsibilitiesController@getAccountByresponsibityId');
        
        Route::post('jobPost', 'JobsController@jobPost');
        Route::post('editjobPost', 'JobsController@editjobPost');
        Route::post('getNearbyLoadPost', 'JobsController@getNearbyLocationJobsPost');
        Route::get('getJobsPostlist', 'JobsController@getJobsPostlist');
        Route::post('searchPostLoads', 'JobsController@searchPostLoads');

        Route::post('vehiclePost', 'VehiclesController@vehiclePost');
        Route::post('vehicleEditPost', 'VehiclesController@vehicleEditPost');
        Route::post('getNearbyVehiclePost', 'VehiclesController@getNearbyVehiclePost');
        Route::get('getallTruckslist', 'VehiclesController@getallTruckslist');
        Route::post('searchTrucks', 'VehiclesController@searchTrucks');

        Route::get('getVehicleBrand', 'VehicleBrandsController@getVehicleBrand');
       
        Route::get('getEquipmentType', 'EquipmentsController@getEquipmentType');

        Route::post('makeRequest', 'BookingsController@makeRequest');
        Route::get('getPostAllrequests', 'BookingsController@getAllrequestpostloadByuser');
        Route::get('getAllrequeststrucks', 'BookingsController@getAllrequesttrucksByuser');

        Route::post('approveRequest', 'BookingsController@approveRequest');
        Route::post('hiredRequest', 'BookingsController@hiredRequest');
        Route::post('startRide', 'BookingsController@startRide');
        Route::post('completedJob', 'BookingsController@completedJob');
        Route::get('getcompletedJob', 'BookingsController@getCompletedJob');
        Route::get('getHistory', 'BookingsController@getHistory');
        Route::get('getNotifications', 'BookingsController@getNotifications');
        
        Route::post('writeRating', 'RatingsController@writeRating');

        Route::get('recentSearch', 'SearchesController@recentSearchByuser');
        Route::get('favoriteSearch', 'SearchesController@favoriteSearchByuser');
    });
});