<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Favorite extends Model
{
    protected $table = 'favorite';
	protected $fillable = ['user_id', 'favorite_of_id', 'favorite_type_id'];

	public function checkIfAlreadyFavorite($user_id, $favorite_of_id, $favorite_type_id) {
		$result = DB::table('favorite')->where('user_id', '=', $user_id)->where('favorite_of_id', '=', $favorite_of_id)->where('favorite_type_id', '=', $favorite_type_id)->first(['user_id']);
		return $result;
	}

	public function getTotalFavoritePostByPostId($favorite_of_id, $favorite_type_id) {
		$result = DB::table('favorite')->select(DB::raw('COUNT(1) AS total_favorite'))->where('favorite_of_id', '=', $favorite_of_id)->where('favorite_type_id', '=', $favorite_type_id)->first();
		return $result;
	}

	public function getPostFavoriteByPostId($post_id) {
		$db = DB::table('favorite AS f')
		->select(DB::raw('u.id AS user_id,
				u.name AS user_name,
				u.image AS user_profile,
				(SELECT GROUP_CONCAT(ut.skill) FROM user_technical AS ut WHERE ut.user_id = u.id) AS user_skills,
				f.created_at AS rating_date'))
		->join('users as u', 'u.id', '=', 'f.user_id')
		->where('f.favorite_of_id', '=', $post_id)
		->where('f.favorite_type_id', '=', '1')
		->orderBy('f.created_at', 'desc');
		return $db;
	}
}
