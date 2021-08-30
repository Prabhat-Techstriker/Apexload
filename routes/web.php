<?php
Route::get('index/', function () {
    return view('site/index');
});

Route::get('about-us/', function () {
    return view('site/about_us');
});

Route::get('contact-us/', function () {
    return view('site/contact_us');
});



Route::post('/contact', 'ContactsController@mailContactForm')->name('contactus');
Route::post('/newslatter', 'ContactsController@newsLatter')->name('newslatter');

Route::redirect('/', 'index');

Auth::routes(['register' => false]);

//Route::get('signup', 'Auth\RegisterController@create')->name('signup');
Route::post('signup', 'AuthController@webSiteSignup')->name('signup-web');
Route::post('byemailotp', 'AuthController@byemailActivate')->name('byemail-otp');
Route::post('loginOtpWithphone', 'AuthController@loginOtp')->name('loginOtpWithphone');
Route::post('regenerate-otp', 'AuthController@generateOtp')->name('regenerate-otp');
Route::post('loginWeb', 'AuthController@login')->name('loginWeb');

// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');



Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/dashborad', 'HomeController@index')->name('dashborad');
    Route::resource('permissions', 'Admin\PermissionsController');
    Route::delete('permissions_mass_destroy', 'Admin\PermissionsController@massDestroy')->name('permissions.mass_destroy');
    Route::resource('roles', 'Admin\RolesController');
    Route::delete('roles_mass_destroy', 'Admin\RolesController@massDestroy')->name('roles.mass_destroy');
    Route::resource('users', 'Admin\UsersController');
    Route::delete('users_mass_destroy', 'Admin\UsersController@massDestroy')->name('users.mass_destroy');

    //shipper
    Route::get('shippers', 'Admin\UsersController@shippers')->name('shippers');
    Route::get('/show-shipper/{id}', 'Admin\UsersController@shippersShow')->name('shipper.show');
    Route::get('edit-shipper/{id}', 'Admin\UsersController@shipperEdit')->name('shipper.edit');
    Route::match(['put', 'patch'], '/update-shipper/{id}','Admin\UsersController@shipperUpdate')->name('shipper.update');
    Route::delete('shipper_destroy', 'Admin\UsersController@shipperDestroy')->name('shipper.delete');
    Route::resource('post-loasds', 'JobsController');

    //driver
    Route::get('drivers', 'Admin\UsersController@drivers')->name('drivers');
    Route::get('/show-driver/{id}', 'Admin\UsersController@driverShow')->name('driver.show');
    Route::get('edit-driver/{id}', 'Admin\UsersController@driverEdit')->name('driver.edit');
    Route::match(['put', 'patch'], '/update-driver/{id}','Admin\UsersController@driverUpdate')->name('driver.update');
    Route::delete('deriver_destroy', 'Admin\UsersController@driverDestroy')->name('driver.delete');
    Route::resource('trucks', 'VehiclesController');


    Route::get('/all-responsibility', 'ResponsibilitiesController@index')->name('responsibility');
    Route::get('/add-responsibility', 'ResponsibilitiesController@create')->name('responsibility.create');
    Route::post('/addresponsibility', 'ResponsibilitiesController@store')->name('responsibility.addresponsibility');
    Route::get('/edit-responsibility/{id}', 'ResponsibilitiesController@edit')->name('responsibility.edit');
    Route::get('/show-responsibility/{id}', 'ResponsibilitiesController@show')->name('responsibility.show');
    Route::match(['put', 'patch'], '/update-responsibility/{id}','ResponsibilitiesController@update')->name('responsibility.update');
    Route::post('/destroy-responsibility', 'ResponsibilitiesController@destroy')->name('responsibility.destroy');

    Route::post('/addaccounttype', 'ResponsibilitiesController@addAccounttype')->name('accounts.addaccounttype');;
    Route::post('/accountType/', 'ResponsibilitiesController@editAccount')->name('account.editAccounts');
    Route::post('/accountType/update', 'ResponsibilitiesController@updateAccount')->name('account.updateAccounts');
    Route::post('/accountType/detetedProperty', 'ResponsibilitiesController@detetedAccount')->name('account.detetedAccounts');

    Route::delete('responsibility_mass_destroy', 'ResponsibilitiesController@massDestroy')->name('responsibility_mass_destroy');

    Route::resource('brands', 'VehicleBrandsController');
    Route::delete('brands_mass_destroy', 'VehicleBrandsController@massDestroy')->name('brands.mass_destroy');

    Route::resource('equipments', 'EquipmentsController');
    Route::delete('equipments_mass_destroy', 'EquipmentsController@massDestroy')->name('equipments.mass_destroy');

    Route::get('/contacts', 'ContactsController@show')->name('contacts');
    Route::get('/newslatters', 'ContactsController@newsLatterList')->name('newslatters');


    Route::get('add-slider-logo','LogoSlidersController@create')->name('logoslider.add');
    Route::post('add-logo','LogoSlidersController@store')->name('addLogo');
    Route::get('logo-slider','LogoSlidersController@index')->name('logoslider');
    Route::get('logo-edit/{id}','LogoSlidersController@edit')->name('logoslider.edit');
    Route::delete('/destroy-logo/{id}', 'LogoSlidersController@destroy')->name('logoslider.destroy');
    Route::match(['put', 'patch'], '/update-logo/{id}','LogoSlidersController@update')->name('logoslider.update');

    Route::resource('testimonials', 'TestimonialsController');

    Route::post('get-account-responsibity','AuthController@getAccountByresponsibityId')->name('get-account-responsibity');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'web', 'as' => 'web.'], function () {

    Route::get('create-profile','AuthController@getResponsbility')->name('create-profile');
    Route::post('webupdateProfile', 'Admin\UsersController@webUpdateProfile')->name('update-profile');

    Route::get('user-dashboard','AuthController@userDashboard')->name('user-dashboard');

    Route::get('post-load','DashboardController@postLoad')->name('post-load');
    Route::post('jobPost', 'DashboardController@jobPost');
    Route::get('post-load-list', 'DashboardController@jobPostList');
    Route::get('post-load-edit/{id}', 'DashboardController@postloadedit');
    Route::post('post-load-edit', 'DashboardController@editjobPost');
    Route::delete('/post-load-delete/{id}', 'JobsController@destroy');

    Route::get('vehicle-list', 'DashboardController@vehicleList')->name('vehicle-list');
    Route::get('vehicle-post', 'DashboardController@vehiclePost');
    Route::post('vehicle-post-add', 'DashboardController@vehiclePostAdd');
    Route::delete('/vehicle-delete/{id}', 'VehiclesController@destroy');
    Route::get('vehicle-edit/{id}', 'DashboardController@vehicleEdit');
    Route::post('vehicle-post-edit', 'DashboardController@vehiclePostEdit');
    Route::get('setting', 'DashboardController@setting');
    Route::get('prefrences', 'DashboardController@prefrences');

    Route::get('complete-job', 'BookingsController@getCompletedJobWeb');
    Route::get('history', 'BookingsController@getHistoryWeb');

    Route::get('history-view/{id}', 'BookingsController@historyView');
    Route::get('history-view-shipper/{id}', 'BookingsController@historyViewShipper');
    Route::get('getAllrequeststrucks', 'BookingsController@getAllrequesttrucksByuserWeb');
    Route::get('getPostAllrequests', 'BookingsController@getAllrequestpostloadByuserWeb');
    Route::post('approveRequestWeb', 'BookingsController@approveRequestWeb');
    Route::post('hiredRequestWeb', 'BookingsController@hiredRequestWeb');
    Route::get('discussion/{requested_by}/{posted_by}/{request_id}', 'BookingsController@discussion');
    Route::get('discussionAjax/{requested_by}/{posted_by}/{request_id}', 'BookingsController@discussionAjax');
    Route::post('send-message', 'BookingsController@sendMessage');

    Route::post('saveOriginDestinationWeb', 'Admin\UsersController@saveOriginDestinationWeb');
    Route::get('myprofile', 'DashboardController@myprofile');
    Route::post('updatemyprofile', 'DashboardController@updatemyprofile');
    

});