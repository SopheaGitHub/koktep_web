<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Rating extends Model
{
    protected $table = 'rating';
	protected $fillable = ['user_id', 'rating_of_id', 'rating_type_id', 'star'];

	public function checkIfAlreadyRating($user_id, $rating_of_id, $rating_type_id) {
		$result = DB::table('rating')->where('user_id', '=', $user_id)->where('rating_of_id', '=', $rating_of_id)->where('rating_type_id', '=', $rating_type_id)->first(['star']);
		return $result;
	}

	public function getTotalRatingPostByPostId($rating_of_id, $rating_type_id) {
		$result = DB::table('rating')->select(DB::raw('CEIL((SUM(star) / COUNT(1))) AS average_rating'))->where('rating_of_id', '=', $rating_of_id)->where('rating_type_id', '=', $rating_type_id)->first();
		return $result;
	}

	public function getPostRatingsByPostId($post_id) {
		$db = DB::table('rating AS r')
		->select(DB::raw('u.id AS user_id,
				u.name AS user_name,
				u.image AS user_profile,
				(SELECT GROUP_CONCAT(ut.skill) FROM user_technical AS ut WHERE ut.user_id = u.id) AS user_skills,
				r.star,
				r.created_at AS rating_date'))
		->join('users as u', 'u.id', '=', 'r.user_id')
		->where('r.rating_of_id', '=', $post_id)
		->where('r.rating_type_id', '=', '1')
		->orderBy('r.created_at', 'desc');
		return $db;
	}

}
