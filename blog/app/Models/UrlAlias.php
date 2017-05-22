<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrlAlias extends Model {

	public $timestamps = false;

	protected $table = 'url_alias';
	protected $fillable = ['query', 'keyword'];

}
