<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Favorite;
use DB;

class Notification extends Model
{
    protected $table = 'notification';
	protected $fillable = ['user_id', 'notification_action_id', 'notification_type_id', 'notification_of_id'];

	public function getNotificationByUserId($user_id, $locale=1) {
		$result = [];
		$getLastViewedDate = DB::table('notification_viewed')->where('user_id', '=', $user_id)->orderBy('updated_at', 'desc')->first(['updated_at']);
		$filter_data = ['last_notification_viewed_date'=> (($getLastViewedDate)? $getLastViewedDate->updated_at:'') ];
		$sql = $this->getNotificationSql($user_id, $locale, $filter_data);

		$datas = $sql->limit(10)->get();
		$totals = $this->getTotalNotification($sql, $filter_data);

		$result = ['datas'=>$datas, 'total'=>$totals];
		return $result;
	}

	public function getNotificationSql($user_id, $locale=1, $filter_data=[]) {
		$favoriteObj = new Favorite();
		$user_favorite_auth = $favoriteObj->getProfileFavoriteOfAuth($user_id);

        if( $user_favorite_auth->all_profile_id != '' ) {
            $all_user_favorite_auth = $user_favorite_auth->all_profile_id;
        }else{
            $all_user_favorite_auth = '0';
        }

        if(isset($filter_data['last_notification_viewed_date']) && $filter_data['last_notification_viewed_date']!='') {
        	$last_date = $filter_data['last_notification_viewed_date'];
        }else {
        	$last_date = '0000-00-00 00:00:00';
        }

		$db = DB::table('notification as n')
		->select(DB::raw('
				u.name AS user_name,
				u.image AS user_profile,
				n.id,
				n.user_id,
				n.notification_action_id,
				n.notification_type_id,
				n.notification_of_id,
				n.created_at AS notification_date,
				na.text,
				na.link,
				CASE 
					WHEN n.created_at > \''.$last_date.'\' THEN \'new\'
					ELSE \'old\'
				END AS viewed_status,
				CASE 
					WHEN notification_type_id = 1 THEN post.author_id
					WHEN notification_type_id = 2 THEN n.user_id
					ELSE null 
				END AS author_id,
				CASE 
					WHEN notification_type_id = 1 THEN post.post_id
					ELSE null 
				END AS post_id,
				CASE 
					WHEN notification_type_id = 1 THEN post.title
					ELSE null 
				END AS post_title,
				CASE 
					WHEN notification_type_id = 1 THEN (SELECT CONCAT(ptc.category_id,\'-\',cd.name) FROM post_to_category AS ptc INNER JOIN category_description AS cd ON cd.category_id = ptc.category_id WHERE ptc.post_id = post.post_id AND cd.language_id = '.$locale.' ORDER BY ptc.category_id DESC LIMIT 1)
					ELSE null
				END AS category_id
			'))
		->join('users as u', 'u.id', '=', 'n.user_id')
		->join('notification_action AS na', 'na.id', '=', 'n.notification_action_id')
		->leftJoin(DB::raw('(SELECT p.post_id, p.author_id, pd.title FROM post AS p INNER JOIN post_description AS pd ON pd.post_id = p.post_id AND language_id = '.$locale.') AS post'), 'post.post_id', '=', 'n.notification_of_id')
		->leftJoin('users AS nou', 'nou.id', '=', 'n.notification_of_id')
		->whereRaw('COALESCE(post.post_id, nou.id) IS NOT NULL')
		->whereRaw('( 
				CASE 
					WHEN n.notification_action_id = 1 OR n.notification_action_id = 2 OR n.notification_action_id = 3 THEN n.user_id
					ELSE null
				-- all favorited with auth id notification without auth id logged
				END IN ('.$all_user_favorite_auth.')
				OR 
				CASE 
					WHEN n.notification_type_id = 1 THEN
						CASE
							WHEN n.notification_action_id = 4 OR n.notification_action_id = 5 OR n.notification_action_id = 6 OR n.notification_action_id = 7 THEN post.author_id
							ELSE null
						END
					WHEN n.notification_type_id = 2 THEN n.notification_of_id
					ELSE null
				-- auth id logged in
				END = '.$user_id.'
				)')
		->orderBy('n.created_at', 'DESC');
		return $db;
	}

	public function getTotalNotification($db, $filter_data=[]) {
		if(isset($filter_data['last_notification_viewed_date']) && $filter_data['last_notification_viewed_date']!='') {
			$db->whereRaw('n.created_at > \''.$filter_data['last_notification_viewed_date'].'\' ');
		}
		$getSql = $db->toSql();
		$result = DB::select('
				SELECT COUNT(1) AS total FROM ('.$getSql.') AS total_table
			')[0]->total;
		return $result;
	}

	public function getAllNotifications($user_id, $locale, $filter_data=[]) {
		$sql = $this->getNotificationSql($user_id, $locale, $filter_data);
		return $sql;
	}

}
