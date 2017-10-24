<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;
use DB;

class Category extends Model {

	protected $table = 'category';
	protected $fillable = ['image', 'parent_id', 'top', 'column', 'sort_order', 'status'];

	public function getCategory($category_id, $language_id = false) {
		$db = DB::table(DB::raw('
				(SELECT DISTINCT
					c.*, cd2.name, (
						SELECT
							GROUP_CONCAT(
								cd1. NAME
								ORDER BY
									LEVEL SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\'
							)
						FROM
							category_path cp
						LEFT JOIN category_description cd1 ON (
							cp.path_id = cd1.category_id
							AND cp.category_id != cp.path_id AND cd1.language_id = \''.(($language_id)? $language_id:'1').'\'
						)
						WHERE
							cp.category_id = c.category_id
						GROUP BY
							cp.category_id
					) AS path,
					(
						SELECT DISTINCT
							keyword
						FROM
							url_alias
						WHERE
							QUERY = \'category_id='.$category_id.'\'
					) AS keyword
				FROM
					category c
				LEFT JOIN category_description cd2 ON (
					c.category_id = cd2.category_id AND cd2.language_id = \''.(($language_id)? $language_id:'1').'\'
				)
				WHERE
					c.category_id = \''.$category_id.'\') AS category
			'));

		$result = $db->first();
		return $result;
	}

	public function getCategoryDescriptions($category_id) {
		$result = DB::table(DB::raw('
				(SELECT
					cd.*
				FROM
					category AS c
				LEFT JOIN category_description AS cd ON cd.category_id = c.category_id
				WHERE c.category_id = "'.$category_id.'") AS category_description
			'))->get();
		return $result;
	}

	public function getCategoryToLayouts($category_id) {
		$result = DB::table(DB::raw('
				(SELECT
					ctl.*
				FROM
					category AS c
				LEFT JOIN category_to_layout AS ctl ON ctl.category_id = c.category_id
				WHERE c.category_id = "'.$category_id.'") AS category_to_layout
			'))->get();
		return $result;
	}

	public function getCategories($filter_data=[]) {
		$db = DB::table(DB::raw('
				(
					SELECT
						cp.category_id AS category_id,
						GROUP_CONCAT(
							cd1. name
							ORDER BY
								cp. LEVEL SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\'
						) AS name,
						c1.parent_id,
						c1.sort_order AS sort_order
					FROM
						category_path cp
					LEFT JOIN category c1 ON (
						cp.category_id = c1.category_id
					)
					LEFT JOIN category c2 ON (cp.path_id = c2.category_id)
					LEFT JOIN category_description cd1 ON (cp.path_id = cd1.category_id AND cd1.language_id = \'1\')
					LEFT JOIN category_description cd2 ON (cp.category_id = cd2.category_id AND cd2.language_id = \'1\')
					GROUP BY
						cp.category_id
				) AS category
			'))->orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function getArrayCategories() {
		$categories = [];
		$result = DB::select(DB::raw('SELECT c.category_id AS category_id, cd.name AS category_name FROM category AS c INNER JOIN category_description AS cd ON c.category_id = cd.category_id AND cd.language_id = 1 ORDER BY category_id ASC'));
		foreach ($result as $value) {
			$categories[$value->category_id] = $value->category_name;
		}
		return $categories;
	}

	public function getCategoriesByLanguage($filter_data=[]) {
		$db = DB::table(DB::raw('
				(
					SELECT c.*, cd.name AS name FROM category c
					LEFT JOIN category_description cd ON (c.category_id = cd.category_id AND cd.language_id = \''.$filter_data['language_id'].'\')
					WHERE c.parent_id = \''.$filter_data['parent_id'].'\'
				) AS category
			'))->orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function getAutocompleteCategories($filter_data=[]) {
		$db = DB::table(DB::raw('
				(
					SELECT
						cp.category_id AS category_id,
						GROUP_CONCAT(
							cd1. name
							ORDER BY
								cp. LEVEL SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\'
						) AS name,
						c1.parent_id,
						c1.sort_order
					FROM
						category_path cp
					LEFT JOIN category c1 ON (
						cp.category_id = c1.category_id
					)
					LEFT JOIN category c2 ON (cp.path_id = c2.category_id)
					LEFT JOIN category_description cd1 ON (cp.path_id = cd1.category_id AND cd1.language_id = \''.$filter_data['language_id'].'\')
					LEFT JOIN category_description cd2 ON (cp.category_id = cd2.category_id AND cd2.language_id = \''.$filter_data['language_id'].'\')
					GROUP BY
						cp.category_id
				) AS category
			'));
		if ($filter_data['filter_name']!='') {
			$db->where('name', 'like', '%'.$filter_data['filter_name'].'%');
		}
		$db->orderBy($filter_data['sort'], $filter_data['order'])->take($filter_data['limit']);
		$result = $db->get();
		return $result;
	}

	public function insertCategoryDescription($datas=[]) {
		$sql = '';
		if(isset($datas['category_description_datas']) && count($datas['category_description_datas']) > 0) {
			foreach ($datas['category_description_datas'] as $language_id => $category_description) {
				$sql .= " INSERT INTO `category_description`(`category_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES ('".$datas['category_id']."', '".$language_id."', '".$category_description['name']."', '".$category_description['description']."', '".$category_description['meta_title']."', '".$category_description['meta_description']."', '".$category_description['meta_keyword']."'); ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function insertCategoryToLayout($datas=[]) {
		$sql = '';
		if(isset($datas['category_to_layout_datas']) && count($datas['category_to_layout_datas']) > 0) {
			foreach ($datas['category_to_layout_datas'] as $category_to_layout) {
				$sql .= " INSERT INTO `category_to_layout`(`category_id`, `website_id`, `layout_id`) VALUES ('".$category_to_layout['category_id']."', '".$category_to_layout['website_id']."', '".$category_to_layout['layout_id']."'); ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function insertCategoryPath($datas=[]) {
		// MySQL Hierarchical Data Closure Table Pattern
		$level = 0;
		$sql = '';

		$category_path = DB::table('category_path')->where('category_id', '=', $datas['parent_id'])->orderBy('level', 'asc')->get();

		foreach ($category_path as $result) {
			$sql .= "INSERT INTO `category_path` SET `category_id` = '" . $datas['category_id'] . "', `path_id` = '" . $result->path_id . "', `level` = '" . $level . "'; ";
			$level++;
		}

		$sql .= "INSERT INTO `category_path` SET `category_id` = '" . $datas['category_id'] . "', `path_id` = '" . $datas['category_id'] . "', `level` = '" . $level . "'; ";
		DB::connection()->getPdo()->exec($sql);
	}

	public function deletedCategoryDescription($category_id) {
		DB::table('category_description')->where('category_id', '=', $category_id)->delete();
	}

	public function deletedUrlAlias($category_id) {
		DB::table('url_alias')->where('query', '=', 'category_id='.$category_id)->delete();
	}

	public function deletedCategoryToLayout($category_id) {
		DB::table('category_to_layout')->where('category_id', '=', $category_id)->delete();
	}

	public function deletedCategoryPath($category_id) {
		DB::table('category_path')->where('category_id', '=', $category_id)->delete();
	}

	public function destroyCategories($array_id) {
		DB::table('category')->whereIn('category_id', $array_id)->delete();
		DB::table('category_path')->whereIn('category_id', $array_id)->delete();
		DB::table('category_to_layout')->whereIn('category_id', $array_id)->delete();
		DB::table('category_description')->whereIn('category_id', $array_id)->delete();
	}

	public function validationForm($datas=[]) {
		$this->language = new Language();
		$languages = $this->language->getLanguages(['sort'=>'name', 'order'=>'asc'])->get();
		$error = false;
		$rules = [];
		$messages = [];

		foreach ($languages as $language) {
			$rules['category_description.'.$language->language_id.'.name'] = 'required';
			$rules['category_description.'.$language->language_id.'.description'] = 'required';
			$description_len = str_replace(['<p>','</p>','<br>','</br>'], ['','','',''], $datas['request']['category_description'][$language->language_id]['description']);
			if(mb_strlen($description_len) < 5){
				$rules['description_len'.$language->language_id] = 'required';
			}
			$rules['category_description.'.$language->language_id.'.meta_title'] = 'required';
		}
		$rules['column'] = 'integer';
		$rules['sort_order'] = 'integer';

		foreach ($languages as $language) {
			$messages['category_description.'.$language->language_id.'.name.required'] = 'The <b>Category Name "'.$language->name.'"</b> field is required.';
			$messages['category_description.'.$language->language_id.'.description.required'] = 'The <b>Description "'.$language->name.'"</b> field is required.';
			$messages['description_len'.$language->language_id.'.required'] = 'The <b>Description "'.$language->name.'"</b> must be at least 5 characters.';
			$messages['category_description.'.$language->language_id.'.meta_title.required'] = 'The <b>Meta Tag Title "'.$language->name.'"</b> field is required.';
		}

		$messages['column.integer'] = 'The <b>Column</b> must be an integer.';
		$messages['sort_order.integer'] = 'The <b>Sort Order</b> must be an integer.';

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : save category unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}
