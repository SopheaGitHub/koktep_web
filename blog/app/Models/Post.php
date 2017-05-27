<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;
use DB;

class Post extends Model {

	protected $table = 'post';
	protected $fillable = ['post_type_id', 'author_id', 'updated_by_author_id', 'image', 'sort_order', 'status', 'viewed'];

	public function getPost($post_id) {
		$result = DB::table(DB::raw('
				(SELECT
				DISTINCT *, (
						SELECT
							keyword
						FROM
							url_alias
						WHERE
							QUERY = \'post_id=\'"'.$post_id.'"
					) AS keyword
					, (SELECT title FROM post_description AS pd WHERE pd.post_id = "'.$post_id.'" AND pd.language_id=\'1\') AS title
				FROM
					post
				WHERE
					post_id = "'.$post_id.'") AS post
			'))->first();
		return $result;
	}

	public function getPostDescriptions($post_id) {
		$result = DB::table(DB::raw('
				(SELECT
					pd.*
				FROM
					post AS p
				LEFT JOIN post_description AS pd ON pd.post_id = p.post_id
				WHERE p.post_id = "'.$post_id.'") AS post_description
			'))->get();
		return $result;
	}

	public function getPostToLayouts($post_id) {
		$result = DB::table(DB::raw('
				(SELECT
					ptl.*
				FROM
					post AS p
				LEFT JOIN post_to_layout AS ptl ON ptl.post_id = p.post_id
				WHERE p.post_id = "'.$post_id.'") AS post_to_layout
			'))->get();
		return $result;
	}

	public function getPosts($filter_data=[]) {
		$db = DB::table(DB::raw('
                        (
							SELECT
								p.post_id AS post_id,
								p.image AS image,
								p.created_at AS created_at,
								pd.title AS title,
								pd.description AS description,
								u.name AS author_name,
								p.status AS status
							FROM
								post AS p
							INNER JOIN users AS u ON u.id = p.author_id
							LEFT JOIN post_description AS pd ON p.post_id = pd.post_id AND pd.language_id = \'1\'
						) AS posts
                    '))->orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function getPostsByAccountID($filter_data=[]) {
		$db = DB::table('post as p')
		->select(DB::raw('p.post_id as post_id,
								p.image as image,
								p.created_at as created_at,
								pd.title as title,
								pd.description as description,
								u.id as author_id,
								u.name as author_name,
								p.status as status'))
		->join('users as u', 'u.id', '=', 'p.author_id')
		->leftJoin('post_description as pd', function($join) {
		  $join->on('p.post_id', '=', 'pd.post_id');
		  $join->on('pd.language_id', '=', DB::raw('1'));
		})
		->where('p.author_id', $filter_data['author_id'])
		->orderBy($filter_data['sort'], $filter_data['order']);

		return $db;
	}

	public function getPostsByPostGroup($filter_data=[]) {
		$db = DB::table('post as p')
		->select(DB::raw('p.post_id as post_id,
								p.image as image,
								p.created_at as created_at,
								pd.title as title,
								pd.description as description,
								u.name as author_name,
								p.status as status'))
		->join('users as u', 'u.id', '=', 'p.author_id')
		->leftJoin('post_description as pd', function($join) {
		  $join->on('p.post_id', '=', 'pd.post_id');
		  $join->on('pd.language_id', '=', DB::raw('1'));
		})
		->whereIn('p.post_id', $filter_data['array_post_group_id'])
		->orderByRaw(\DB::raw("FIELD(p.post_id, ".implode(",",$filter_data['array_post_group_id']).")"));

		return $db;
	}

	public function getPostCategories($post_id) {
		$result = DB::table('post_to_category')->where('post_id', '=', $post_id)->get();
		return $result;
	}

	public function getPostRelated($post_id) {
		$post_related_data = [];
		$post_relateds = DB::table('post_related')->where('post_id', '=', $post_id)->get();
		foreach ($post_relateds as $result) {
			$post_related_data[] = $result->related_id;
		}
		return $post_related_data;
	}

	public function getPostImages($post_id) {
		$result = DB::table('post_image')->where('post_id', '=', $post_id)->orderBy('sort_order', 'ASC')->get();
		return $result;
	}

	public function getAutocompletePosts($filter_data=[]) {
		$db = DB::table(DB::raw('
				(
					SELECT
						p.post_id AS post_id,
						p.created_at AS created_at,
						pd.title AS title,
						u.name AS author_name,
						p.status AS status
					FROM
						post AS p
					INNER JOIN users AS u ON u.id = p.author_id
					LEFT JOIN post_description AS pd ON p.post_id = pd.post_id AND pd.language_id = \'1\'
				) AS posts
			'));
		if ($filter_data['filter_title']!='') {
			$db->where('title', 'like', '%'.$filter_data['filter_title'].'%');
		}
		$db->orderBy($filter_data['sort'], $filter_data['order'])->take($filter_data['limit']);
		$result = $db->get();
		return $result;
	}

	public function insertPostDescription($datas=[]) {
		$sql = '';
		if(isset($datas['post_description_datas']) && count($datas['post_description_datas']) > 0) {
			foreach ($datas['post_description_datas'] as $language_id => $post_description) {
				$sql .= " INSERT INTO `post_description`(`post_id`, `language_id`, `title`, `description`, `tag`, `meta_title`, `meta_description`, `meta_keyword`) VALUES ('".$datas['post_id']."', '".$language_id."', '".$post_description['title']."', '".$post_description['description']."', '".$post_description['tag']."', '".$post_description['title']."', '".$post_description['title']."', '".$post_description['title']."'); ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function insertPostToLayout($datas=[]) {
		$sql = '';
		if(isset($datas['post_to_layout_datas']) && count($datas['post_to_layout_datas']) > 0) {
			foreach ($datas['post_to_layout_datas'] as $post_to_layout) {
				$sql .= " INSERT INTO `post_to_layout`(`post_id`, `website_id`, `layout_id`) VALUES ('".$post_to_layout['post_id']."', '".$post_to_layout['website_id']."', '".$post_to_layout['layout_id']."'); ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function insertPostCategory($datas=[]) {
		$sql = '';
		if(isset($datas['post_category_datas']) && count($datas['post_category_datas']) > 0) {
			foreach ($datas['post_category_datas'] as $post_category_value) {
				$sql .= " INSERT INTO `post_to_category`(`post_id`, `category_id`) VALUES ('".$datas['post_id']."', '".$post_category_value."'); ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function insertPostImage($datas=[]) {
		$sql = '';
		if (isset($datas['post_images']) && count($datas['post_images']) > 0) {
			foreach ($datas['post_images'] as $post_image) {
				$sql .= "INSERT INTO post_image SET post_id = '" . $datas['post_id'] . "', image = '" . $post_image['image'] . "', sort_order = '" . $post_image['sort_order'] . "'; ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function insertPostRelated($datas=[]) {
		$sql = '';
		if (isset($datas['posts_related']) && count($datas['posts_related']) > 0) {
			foreach ($datas['posts_related'] as $related_id) {
				$sql .= "DELETE FROM post_related WHERE post_id = '" . $datas['post_id'] . "' AND related_id = '" . $related_id . "'; ";
				$sql .= "INSERT INTO post_related SET post_id = '" . $datas['post_id'] . "', related_id = '" . $related_id . "'; ";
				$sql .= "DELETE FROM post_related WHERE post_id = '" . $related_id . "' AND related_id = '" . $datas['post_id'] . "'; ";
				$sql .= "INSERT INTO post_related SET post_id = '" . $related_id . "', related_id = '" . $datas['post_id'] . "'; ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function deletedPostDescription($post_id) {
		DB::table('post_description')->where('post_id', '=', $post_id)->delete();
	}

	public function deletedUrlAlias($post_id) {
		DB::table('url_alias')->where('query', '=', 'post_id='.$post_id)->delete();
	}

	public function deletedPostToLayout($post_id) {
		DB::table('post_to_layout')->where('post_id', '=', $post_id)->delete();
	}

	public function deletedPostToCategory($post_id) {
		DB::table('post_to_category')->where('post_id', '=', $post_id)->delete();
	}

	public function deletedPostImage($post_id) {
		DB::table('post_image')->where('post_id', '=', $post_id)->delete();
	}

	public function deletedPostRelated($post_id) {
		DB::table('post_related')->where('post_id', '=', $post_id)->delete();
		DB::table('post_related')->where('related_id', '=', $post_id)->delete();
	}

	public function destroyPosts($array_id) {
		DB::table('post')->whereIn('post_id', $array_id)->delete();
		DB::table('post_to_category')->whereIn('post_id', $array_id)->delete();
		DB::table('post_description')->whereIn('post_id', $array_id)->delete();
		DB::table('post_to_layout')->whereIn('post_id', $array_id)->delete();
	}

	public function validationForm($datas=[]) {
		$this->language = new Language();
		$languages = $this->language->getLanguages(['sort'=>'name', 'order'=>'asc'])->get();
		$error = false;
		$rules = [];
		$messages = [];

		foreach ($languages as $language) {
			$rules['post_description.'.$language->language_id.'.title'] = 'required';
			$rules['post_description.'.$language->language_id.'.description'] = 'required';
			$description_len = str_replace(['<p>','</p>','<br>','</br>'], ['','','',''], $datas['request']['post_description'][$language->language_id]['description']);
			if(mb_strlen($description_len) < 5){
				$rules['description_len'.$language->language_id] = 'required';
			}
		}
		$rules['image'] = 'required';

		foreach ($languages as $language) {
			$messages['post_description.'.$language->language_id.'.title.required'] = 'The <b>Post Title</b> field is required.';
			$messages['post_description.'.$language->language_id.'.description.required'] = 'The <b>Description</b> field is required.';
			$messages['description_len'.$language->language_id.'.required'] = 'The <b>Description</b> must be at least 5 characters.';
		}

		if(isset($datas['request']['post_image'])) {
        	$i = 1;
        	foreach($datas['request']['post_image'] as $key => $val) {
        		$rules['post_image.'.$key.'.image'] = 'required';
				$rules['post_image.'.$key.'.sort_order'] = 'integer';
				$messages['post_image.'.$key.'.image.required'] = 'The <b>Add Image ('.$i.') Image</b> field is required.';
				$messages['post_image.'.$key.'.sort_order.integer'] = 'The <b>Add Image ('.$i.') Sort Order </b> must be an integer.';
				$i++;
			}
        }

        $messages['image.required'] = 'The <b>Image</b> field is required.';

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : '.(($datas['action']=='create')? 'save':'save change').' post unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}
