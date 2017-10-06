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

	public function checkIfAlreadyFavoriteProfile($user_id, $favorite_of_id, $favorite_type_id) {
		$result = DB::table('favorite')->select(DB::raw('COUNT(1) AS total_favorited'))
		->where('favorite_type_id', '=', $favorite_type_id)
		->whereRaw('(user_id = '.$user_id.' AND favorite_of_id = '.$favorite_of_id.')')
		->orWhereRaw('(user_id = '.$favorite_of_id.' AND favorite_of_id = '.$user_id.')')->first();
		return $result;
	}

	public function getProfileFavoriteOfAuth($user_id) {
		$result = DB::table('favorite')
		->select(DB::raw('
			GROUP_CONCAT(DISTINCT(
				CASE
					WHEN user_id = \''.$user_id.'\' THEN favorite_of_id
					WHEN favorite_of_id = \''.$user_id.'\' THEN user_id
				ELSE 0
				END 
			)) AS all_profile_id'))
		->whereRaw('favorite_type_id = \'2\'
			AND (user_id = '.$user_id.' OR favorite_of_id = '.$user_id.')
			AND CASE
					WHEN user_id = \''.$user_id.'\' THEN favorite_of_id
					WHEN favorite_of_id = \''.$user_id.'\' THEN user_id 
					ELSE 0
			END != '.$user_id.'')
		->first(['all_profile_id']);
		return $result;
	}

	public function getProfileFavoriteOfAuthor($datas=[]) {
		$db = DB::table(DB::raw('
			(
				(
					SELECT
						CASE
							WHEN user_id = \''.$datas['account_id'].'\' THEN favorite_of_id
							WHEN favorite_of_id = \''.$datas['account_id'].'\' THEN user_id
							ELSE 0
						END AS profile_id,
						\'u\' AS table_note
					FROM
						favorite
					WHERE
					favorite_type_id = 2
					AND (user_id = '.$datas['account_id'].' OR favorite_of_id = '.$datas['account_id'].')
					AND CASE
							WHEN user_id = \''.$datas['account_id'].'\' THEN favorite_of_id
							WHEN favorite_of_id = \''.$datas['account_id'].'\' THEN user_id
							ELSE 0
					END = \''.$datas['auth_id'].'\'
					ORDER BY created_at DESC
				)
				UNION ALL
					(
						SELECT
							CASE
								WHEN user_id = \''.$datas['account_id'].'\' THEN favorite_of_id
								WHEN favorite_of_id = \''.$datas['account_id'].'\' THEN user_id
								ELSE 0
							END AS profile_id,
							\'u_f\'
						FROM
							favorite
						WHERE
						favorite_type_id = 2
						AND (user_id = '.$datas['account_id'].' OR favorite_of_id = '.$datas['account_id'].')
						AND CASE
								WHEN user_id = \''.$datas['account_id'].'\' THEN favorite_of_id
								WHEN favorite_of_id = \''.$datas['account_id'].'\' THEN user_id
								ELSE 0
						END IN ('.$datas['favorite_of_auth_id'].')
						ORDER BY created_at DESC

					)
				UNION ALL
					(
						SELECT
							CASE
								WHEN user_id = \''.$datas['account_id'].'\' THEN favorite_of_id
								WHEN favorite_of_id = \''.$datas['account_id'].'\' THEN user_id
								ELSE 0
							END AS profile_id,
							\'n_u_f\' AS table_note
						FROM
							favorite
						WHERE
						favorite_type_id = 2
						AND (user_id = '.$datas['account_id'].' OR favorite_of_id = '.$datas['account_id'].')
						AND CASE
								WHEN user_id = \''.$datas['account_id'].'\' THEN favorite_of_id
								WHEN favorite_of_id = \''.$datas['account_id'].'\' THEN user_id
								ELSE 0
						END NOT IN ('.$datas['auth_id'].','.$datas['favorite_of_auth_id'].')
						ORDER BY created_at DESC
					)
			) AS f
			'))
		->select(DB::raw('
				f.*,
				u.name AS user_name,
				u.image AS user_profile,
				(SELECT GROUP_CONCAT(ut.skill) FROM user_technical AS ut WHERE ut.user_id = u.id) AS user_skills
			'))
		->join('users as u', 'u.id', '=', 'f.profile_id');

		return $db;
	}

}
