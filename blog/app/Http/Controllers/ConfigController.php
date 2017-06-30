<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ConfigController extends Controller {

	// image path
	public $dir_image = "C:/xampp/htdocs/development/koktep_storage/images/";
	// public $dir_image = "C:/xampp/htdocs/development/koktep_web/blog/public/images/";
	// public $dir_image = "C:/wamp/www/my_projects/koktep_web/blog/public/images/";

	// logs path
	public $dir_logs = "C:/xampp/htdocs/development/koktep_storage/logs/";

	// application path
	public $dir_application_http = "C:/xampp/htdocs/development/koktep_web/blog/app/Http/";
	// public $dir_application_http = "C:/wamp/www/my_projects/koktep_web/blog/app/Http/";

	// http best path
	public $http_best_path = "http://localhost/development/koktep_storage/";
	// public $http_best_path = "http://localhost/development/koktep_web/blog/public/";
	// public $http_best_path = "http://localhost:81/my_projects/koktep_web/blog/public/";

	// https best path
	public $https_best_path = "https://localhost/development/koktep_storage/";
	// public $https_best_path = "https://localhost/development/koktep_web/blog/public/";
	// public $https_best_path = "http://localhost:81/my_projects/koktep_web/blog/public/";

	// system status
	public function status() {
		return $status = ['1' => trans('text.enabled'), '0'	=> trans('text.disabled')];
	}

	// system watermark position
	public function watermark_positions() {
		return $position = [
			'topleft' 		=> trans('text.top_left'), 
			'topright' 		=> trans('text.top_right'),
			'centerleft' 	=> trans('text.center_left'),
			'centerrigth' 	=> trans('text.center_rigth'),
			'center' 		=> trans('text.center'),
			'centertop' 	=> trans('text.center_top'),
			'centerbottom' 	=> trans('text.center_bottom'),
			'bottomleft' 	=> trans('text.bottom_left'), 
			'bottomright'	=> trans('text.bottom_right')
		];
	}

	public function escape($value) {
		return str_replace(array("\\", "\0", "\n", "\r", "\x1a", "'", '"'), array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'), htmlspecialchars($value));
	}

}
