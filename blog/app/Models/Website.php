<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model {

	public $timestamps = false;

	protected $table = 'website';
	protected $fillable = ['name', 'url', 'ssl'];

	public function getWebsites($filter_data=[]) {
		$db = Website::orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

}
