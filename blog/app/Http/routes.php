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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::auth();


// Route::get('/', function() {
// 	return view('deploy_message');
// });
// Route::get('post-account/detail', function() {
// 	return view('deploy_message');
// });

Route::get('/', 'HomeController@index');
Route::get('/love/{name}', 'HomeController@love');
Route::get('/language', [
		'Middleware' => 'LanguageSwitcher',
		'uses'=>'LanguageController@switcher'
	]);

Route::controllers([
	'/filemanager' 	=> 'Common\FilemanagerController',
	'/information' => 'InformationController',
	'/contact-us' => 'ContactUsController',
	'/message' => 'MessageController',
	'/notification' => 'NotificationController',
	'/send-feedback' => 'SendFeedbackController',
	'/documentation' => 'DocumentationController',
	'/account' 	=> 'AccountController',
	'/category'	=> 'CategoryController',
	'/about-account'	=> 'AboutAccountController',
	'/favorite-account'  => 'FavoriteAccountController',
	'/rating-account'  => 'RatingAccountController',
	'/contact-account'	=> 'ContactAccountController',
	'/overview-account'	=> 'OverviewAccountController',
	'/post-account'		=> 'PostAccountController',
	'/posts'			=> 'PostsController',
	'/posts-groups-account'	=> 'PostsGroupsAccountController',
	'/posts-groups'	=> 'PostsGroupsController',
	'/geo-zones' 	=> 'GeoZonesController'
]);

Route::get('/email', function() {
	Mail::send('emails.welcome', [], function($message){
	    $message->from('chansophea9@gmail.com', 'Laravel');
	    $message->to('chansophea9@gmail.com');
	});
	echo 'success';
	exit();
});

Route::get('images/', function() {
	return view('errors.505');
});
Route::get('images/{cache}', function() {
	return view('errors.505');
});
Route::get('images/{cache}/{catalog}', function() {
	return view('errors.505');
});
Route::get('images/{cache}/{catalog}/{account}', function() {
	return view('errors.505');
});

Route::get('testsendemail', function() {
	Mail::send('emails.welcome', array('key' => 'value'), function($message)
	{
	    $message->to('teamkoktep@gmail.com', 'John Smith')->subject('Welcome!');
	});
	exit();
});
