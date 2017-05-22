<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerImage extends Model {

	public $timestamps = false;

	protected $table = 'banner_image';
	protected $fillable = ['banner_id', 'link', 'image', 'sort_order'];

}
