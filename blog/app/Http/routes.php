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

Route::get('/', 'HomeController@index');
Route::get('/language', [
		'Middleware' => 'LanguageSwitcher',
		'uses'=>'LanguageController@switcher'
	]);

Route::controllers([
	'/filemanager' 	=> 'Common\FilemanagerController',
	'/information' => 'InformationController',
	'/contact-us' => 'ContactUsController',
	'/message' => 'MessageController',
	'/send-feedback' => 'SendFeedbackController',
	'/documentation' => 'DocumentationController',
	'/account' 	=> 'AccountController',
	'/category'	=> 'CategoryController',
	'/about-account'	=> 'AboutAccountController',
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
