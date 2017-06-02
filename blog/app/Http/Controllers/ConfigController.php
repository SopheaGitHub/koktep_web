<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ConfigController extends Controller {

	// image path
	// public $dir_image = "C:/xampp/htdocs/development/koktep_web/blog/public/images/";
	public $dir_image = "C:/wamp/www/my_projects/koktep_web/blog/public/images/";

	// application path
	// public $dir_application_http = "C:/xampp/htdocs/development/koktep_web/blog/app/Http/";
	public $dir_application_http = "C:/wamp/www/my_projects/koktep_web/blog/app/Http/";

	// http best path
	// public $http_best_path = "http://localhost/development/koktep_web/blog/public/";
	public $http_best_path = "http://localhost:81/my_projects/koktep_web/blog/public/";

	// https best path
	// public $https_best_path = "https://localhost/development/koktep_web/blog/public/";
	public $https_best_path = "http://localhost:81/my_projects/koktep_web/blog/public/";

	// system status
	public $status = ['1' => 'Enabled', '0'	=> 'Disabled'];

}
