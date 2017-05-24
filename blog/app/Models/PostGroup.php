<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PostGroup extends Model
{
    protected $table = 'post_group';
	protected $fillable = ['value', 'sort_order', 'status'];

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
                    '))->orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
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
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : '.$datas['message'].' post group unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}
}