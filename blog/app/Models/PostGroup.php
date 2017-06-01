<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PostGroup extends Model
{
    protected $table = 'post_group';
	protected $fillable = ['value', 'author_id', 'updated_by_author_id', 'sort_order', 'status'];

	public function getPostGroup($post_group_id) {
		$result = DB::table(DB::raw('
				(SELECT
				DISTINCT *, (SELECT name FROM post_group_description AS pgd WHERE pgd.post_group_id = "'.$post_group_id.'" AND pgd.language_id=\'1\') AS name
				FROM
					post_group
				WHERE
					post_group_id = "'.$post_group_id.'") AS post_group
			'))->first();
		return $result;
	}

	public function getPostsGroups($filter_data=[]) {
		$db = DB::table(DB::raw('
                        (
							SELECT
								pg.author_id AS author_id,
								pg.post_group_id AS post_group_id,
								pg.value AS value,
								pg.status AS status,
								pg.created_at AS created_at,
								pgd.name AS name
							FROM
								post_group AS pg
							LEFT JOIN post_group_description AS pgd ON pgd.post_group_id = pg.post_group_id
							AND pgd.language_id = \'1\'
						) AS posts_groups
                    '));

				if($filter_data['account_id']!='') {
					$db->where('author_id', '=', $filter_data['account_id']);
				}

				$db->orderBy($filter_data['sort'], $filter_data['order']);

		return $db;
	}

	public function getPostGroupDescriptions($post_group_id) {
		$result = DB::table(DB::raw('
				(SELECT
					pgd.*
				FROM
					post_group AS pg
				LEFT JOIN post_group_description AS pgd ON pgd.post_group_id = pg.post_group_id
				WHERE pg.post_group_id = "'.$post_group_id.'") AS post_group_description
			'))->get();
		return $result;
	}

	public function insertPostGroupDescription($datas=[]) {
		$sql = '';
		if(isset($datas['post_group_description_datas']) && count($datas['post_group_description_datas']) > 0) {
			foreach ($datas['post_group_description_datas'] as $language_id => $post_group_description) {
				$sql .= " INSERT INTO post_group_description(post_group_id, language_id, name) VALUES ('".$datas['post_group_id']."', '".$language_id."', '".$post_group_description['name']."'); ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function deletedPostGroupDescription($post_group_id) {
		DB::table('post_group_description')->where('post_group_id', '=', $post_group_id)->delete();
	}

	public function validationForm($datas=[]) {
		$this->language = new Language();
		$languages = $this->language->getLanguages(['sort'=>'name', 'order'=>'asc'])->get();
		$error = false;
		$rules = [];
		$messages = [];

		foreach ($languages as $language) {
			$rules['post_group_description.'.$language->language_id.'.name'] = 'required';
			$messages['post_group_description.'.$language->language_id.'.name.required'] = 'The <b>Post Group Name</b> field is required.';
		}

		if(isset($datas['request']['post_related'])) {
			if(count($datas['request']['post_related']) < 2) {
				$rules['post_min_2'] = 'required';
				$messages['post_min_2.required'] = 'The <b>Posts</b> must be at least 2 item';
			}
		}else {
			$rules['post_required'] = 'required';
			$messages['post_required.required'] = 'The <b>Posts</b> field is required.';
		}
		

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : '.(($datas['action']=='create')? 'save':'save change').' post group unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

	public function validationDeleteForm($datas=[]) {
		$error = false;
		$rules = [];
		$messages = [];

		$rules['post_group_invalid'] = 'required';
		$messages['post_group_invalid.required'] = 'This <b>Post Group</b> is invalid.';

		$rules['post_group_id'] = 'required';
		$messages['post_group_id.required'] = 'The <b>Post Group</b> field is required.';

		$rules['author_id'] = 'required|in:'.$datas['request']['post_group_author_id'];
		$messages['author_id.required'] = 'The <b>Author</b> field is required.';
		$messages['author_id.in'] = 'The <b>Author</b> is invalid to delete this post_group.';

        $validator = \Validator::make($datas['request'], $rules, $messages);
        if ($validator->fails()) {
            $error = ['error'=>'1','success'=>'0','msg'=>'Warning : delete post group unsuccessfully!','validatormsg'=>$validator->messages()];
        }
        return $error;
	}

}
