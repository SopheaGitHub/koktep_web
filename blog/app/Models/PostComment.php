<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PostComment extends Model
{
    protected $table = 'post_comment';
	protected $fillable = ['user_id', 'post_id', 'comment', 'rating', 'parent_id'];

	public function getPostCommentsByPostId($post_id) {
		$result = DB::table(DB::raw('
				(SELECT
					pc.post_comment_id AS post_comment_id,
					pc.comment AS comment,
					pc.created_at AS created_at,
					pc.rating AS rating,
					u.id AS user_id,
					u.name AS user_name,
					u.image AS image
				FROM
					post_comment AS pc
				INNER JOIN users AS u ON u.id = pc.user_id
				WHERE pc.post_id = "'.$post_id.'") AS post_comment
			'))->orderBy('post_comment_id', 'desc')->get();
		return $result;

	}

}
