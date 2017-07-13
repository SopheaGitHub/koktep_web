<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;
use App\Http\Controllers\Controller;
use DB;

class Post extends Model {

	protected $table = 'post';
	protected $fillable = ['author_id', 'updated_by_author_id', 'image', 'watermark_status', 'sort_order', 'status', 'viewed'];

	public function getPost($post_id) {
		$result = DB::table(DB::raw('
				(SELECT
				DISTINCT p.*,(SELECT COUNT(1) FROM post_comment WHERE post_id = p.post_id) AS commented, u.name as author_name, u.image AS author_image,
					(
						SELECT
							keyword
						FROM
							url_alias
						WHERE
							QUERY = \'p.post_id=\'"'.$post_id.'"
					) AS keyword
					, (SELECT title FROM post_description AS pd WHERE pd.post_id = "'.$post_id.'" AND pd.language_id=\'1\') AS title
				FROM
					post AS p
				INNER JOIN users as u ON u.id = p.author_id
				WHERE
					p.post_id = "'.$post_id.'" AND p.status IN (\'0\', \'1\')
				) AS post
			'))->first();
		return $result;
	}

	public function getPostRating($post_id) {
		$result = DB::table(DB::raw('
				(SELECT CEIL((SUM(rating) / COUNT(1))) AS average_rating FROM post_comment WHERE post_id = '.$post_id.') AS average_rating
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

	public function getPostDescription($post_id) {
		$result = DB::table(DB::raw('
				(SELECT
					pd.*
				FROM
					post AS p
				LEFT JOIN post_description AS pd ON pd.post_id = p.post_id AND pd.language_id = \'1\'
				WHERE p.post_id = "'.$post_id.'") AS post_description
			'))->first();
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
		$db = DB::table('post as p')
		->select(DB::raw('p.post_id as post_id,
								p.viewed as viewed,
								(SELECT COUNT(1) FROM post_comment WHERE post_id = p.post_id) AS commented,
								(SELECT CEIL((SUM(rating) / COUNT(1))) AS average_rating FROM post_comment WHERE post_id = p.post_id) AS average_rating,
								(SELECT COUNT(1) FROM post_image WHERE post_id = p.post_id) AS total_post_image,
								p.image as image,
								p.created_at as created_at,
								p.watermark_status as watermark_status,
								pd.title as title,
								pd.description as description,
								pd.tag AS tag,
								u.id as author_id,
								u.name as author_name,
								u.image AS author_image,
								p.status as status,
								cd.category_id as category_id,
								cd.name as category_name'))
		->join('users as u', 'u.id', '=', 'p.author_id')
		->leftJoin('post_description as pd', function($join) {
		  $join->on('p.post_id', '=', 'pd.post_id');
		  $join->on('pd.language_id', '=', DB::raw('1'));
		});

		// category condition join
		if($filter_data['category_id']!='') {
			$category_id = $filter_data['category_id'];
			$db->join('post_to_category as ptc', function($join) use ($category_id) {
			  $join->on('p.post_id', '=', 'ptc.post_id');
			  $join->on('ptc.category_id', '=', DB::raw(''.$category_id.''));
			});
		}else {
			$db->leftJoin('post_to_category as ptc', function($join) {
			  $join->on('p.post_id', '=', 'ptc.post_id');
			});
		}
		$db->leftJoin('category_description as cd', function($join) {
		  	$join->on('cd.category_id', '=', 'ptc.category_id');
		  	$join->on('cd.language_id', '=', DB::raw('1'));
		});
		// End category condition join

		if($filter_data['author_id']!='') {
			$db->where('p.author_id', $filter_data['author_id']);
		}

		if($filter_data['search']!='') {
			$db->whereRaw("( pd.title LIKE '%".$filter_data['search']."%' OR pd.description LIKE '%".$filter_data['search']."%' OR pd.tag LIKE '%".$filter_data['search']."%') ");
		}

		if($filter_data['time']!='') {
			switch ($filter_data['time']) {
				case 'today':
					$db->whereRaw(" DATE(p.created_at) = '" . date('Y-m-d') . "' ");
					break;
				case 'this_week':
					$db->whereRaw(" DATE(p.created_at) BETWEEN '".date('Y-m-d', strtotime('monday this week'))."' AND '".date('Y-m-d', strtotime('sunday this week'))."' ");
					break;
				case 'this_month':
					$db->whereRaw(" DATE(p.created_at) BETWEEN '".date('Y-m-d', strtotime('first day of this month'))."' AND '".date('Y-m-d', strtotime('last day of this month'))."' ");
					break;
				case 'this_year':
					$db->whereRaw(" DATE(p.created_at) BETWEEN '".date('Y-m-d', strtotime('first day of January '.date('Y') ))."' AND '".date('Y-m-d', strtotime('last day of December '.date('Y') ))."' ");
					break;
				default:
					# code...
					break;
			}
		}

		if($filter_data['alpha']!='') {
			$db->whereRaw(" pd.title LIKE '".$filter_data['alpha']."%' ");
		}

		if($filter_data['country_id']!='') {
			$db->join(DB::raw("(SELECT uac.country_id, uac.user_id FROM user_address AS uac WHERE uac.country_id = '".$filter_data['country_id']."' ORDER BY uac.sort_order DESC LIMIT 1) AS country"), 'country.user_id', '=', 'u.id');
		}

		if($filter_data['zone_id']!='') {
			$db->join(DB::raw("(SELECT uaz.zone_id, uaz.user_id FROM user_address AS uaz WHERE uaz.zone_id = '".$filter_data['zone_id']."' ORDER BY uaz.sort_order DESC LIMIT 1) AS zone"), 'zone.user_id', '=', 'u.id');
		}
		
		if($filter_data['browse']!='') {
			$db->orderBy($filter_data['browse'], $filter_data['order']);
		}
		
		$db->whereIn('p.status', $filter_data['status'])->orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function getPostsByArrayPostID($array_post_id) {
		$db = DB::table('post as p')
		->select(DB::raw('p.post_id as post_id,
								p.viewed as viewed,
								(SELECT COUNT(1) FROM post_image WHERE post_id = p.post_id) AS total_post_image,
								p.image as image,
								p.created_at as created_at,
								pd.title as title,
								pd.description as description,
								pd.tag AS tag,
								u.id as author_id,
								u.name as author_name,
								u.image AS author_image,
								p.status as status,
								cd.category_id as category_id,
								cd.name as category_name'))
		->join('users as u', 'u.id', '=', 'p.author_id')
		->leftJoin('post_description as pd', function($join) {
		  $join->on('p.post_id', '=', 'pd.post_id');
		  $join->on('pd.language_id', '=', DB::raw('1'));
		});
		$db->leftJoin('post_to_category as ptc', function($join) {
			  $join->on('p.post_id', '=', 'ptc.post_id');
			});
		$db->leftJoin('category_description as cd', function($join) {
		  	$join->on('cd.category_id', '=', 'ptc.category_id');
		  	$join->on('cd.language_id', '=', DB::raw('1'));
		});
		$db->whereIn('p.post_id', $array_post_id)->where('p.status', '=', '1')->orderByRaw(\DB::raw("FIELD(p.post_id, ".implode(",",$array_post_id).")"));
		$result = $db->get();
		return $result;
	}

	public function getPostsByPostGroup($filter_data=[]) {
		$db = DB::table('post as p')
		->select(DB::raw('p.post_id as post_id,
								p.image as image,
								p.created_at as created_at,
								pd.title as title,
								pd.description as description,
								u.id as author_id,
								u.name as author_name,
								p.status as status,
								cd.category_id as category_id,
								cd.name as category_name'))
		->join('users as u', 'u.id', '=', 'p.author_id')
		->leftJoin('post_description as pd', function($join) {
		  $join->on('p.post_id', '=', 'pd.post_id');
		  $join->on('pd.language_id', '=', DB::raw('1'));
		})
		->leftJoin('post_to_category as ptc', function($join) {
			  $join->on('p.post_id', '=', 'ptc.post_id');
			})
		->leftJoin('category_description as cd', function($join) {
		  	$join->on('cd.category_id', '=', 'ptc.category_id');
		  	$join->on('cd.language_id', '=', DB::raw('1'));
		})
		->whereIn('p.post_id', $filter_data['array_post_group_id'])
		->where('p.status', '=', '1')
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
		$db->where('status', '=', '1');
		$db->orderBy($filter_data['sort'], $filter_data['order'])->take($filter_data['limit']);
		$result = $db->get();
		return $result;
	}

	public function getPostsToUser($author_id) {
		$post_data = [];
		$posts_to_user = Post::where('author_id', '=', $author_id)->whereIn('status', ['1'])->orderBy('created_at', 'DESC')->take(5)->get();
		foreach ($posts_to_user as $result) {
			$post_data[] = $result->post_id;
		}
		return $post_data;
	}

	public function insertPostDescription($datas=[]) {
		$controller = new Controller();
		$sql = '';
		if(isset($datas['post_description_datas']) && count($datas['post_description_datas']) > 0) {
			foreach ($datas['post_description_datas'] as $language_id => $post_description) {
				$sql .= " INSERT INTO `post_description`(`post_id`, `language_id`, `title`, `description`, `tag`, `meta_title`, `meta_description`, `meta_keyword`) VALUES ('".$datas['post_id']."', '".$language_id."', '".$controller->escape($post_description['title'])."', '".$controller->escape($post_description['description'])."', '".$controller->escape($post_description['tag'])."', '".$controller->escape($post_description['title'])."', '".$controller->escape($post_description['title'])."', '".$controller->escape($post_description['title'])."'); ";
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
		$controller = new Controller();
		$sql = '';
		if (isset($datas['post_images']) && count($datas['post_images']) > 0) {
			foreach ($datas['post_images'] as $post_image) {
				$sql .= "INSERT INTO post_image SET post_id = '" . $datas['post_id'] . "', image = '" . $controller->escape($post_image['image']) . "', watermark_status = '" . $controller->escape( ((isset($post_image['watermark']))? $post_image['watermark']:'0') ) . "', sort_order = '" . $controller->escape($post_image['sort_order']) . "'; ";
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
			$messages['post_description.'.$language->language_id.'.title.required'] = trans('text.title_required');
			$messages['post_description.'.$language->language_id.'.description.required'] = trans('text.description_required');
			$messages['description_len'.$language->language_id.'.required'] = trans('text.description_min_len');
		}

		if(isset($datas['request']['post_image'])) {
        	$i = 1;
        	foreach($datas['request']['post_image'] as $key => $val) {
        		$rules['post_image.'.$key.'.image'] = 'required';
				$rules['post_image.'.$key.'.sort_order'] = 'integer';
				$messages['post_image.'.$key.'.image.required'] = trans('text.before_add_image_required').' ('.$i.') '.trans('text.after_add_image_required');
				$messages['post_image.'.$key.'.sort_order.integer'] = trans('text.before_sort_order_integer').' ('.$i.') '.trans('text.after_sort_order_integer');
				$i++;
			}
        }

        $messages['image.required'] = trans('text.image_required');

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=> (($datas['action']=='create')? trans('text.save'):trans('text.save_change')).' '.trans('text.unsuccessfully').'!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

	public function validationDeleteForm($datas=[]) {
		$error = false;
		$rules = [];
		$messages = [];

		$rules['post_invalid'] = 'required';
		$messages['post_invalid.required'] = trans('text.post_invalid');

		$rules['post_id'] = 'required';
		$messages['post_id.required'] = trans('text.post_id_required');

		$rules['author_id'] = 'required|in:'.$datas['request']['post_author_id'];
		$messages['author_id.required'] = trans('text.author_id_required');
		$messages['author_id.in'] = trans('text.author_id_invalid');

        $validator = \Validator::make($datas['request'], $rules, $messages);
        if ($validator->fails()) {
            $error = ['error'=>'1','success'=>'0','msg'=> trans('text.delete').' '.trans('text.unsuccessfully').'!','validatormsg'=>$validator->messages()];
        }
        return $error;
	}

	public function validationCommentForm($datas=[]) {
		$error = false;
		$rules = [];
		$messages = [];

		$rules['comment'] = 'required|min:5';
		$messages['comment.required'] = trans('text.comment_required');
		$messages['comment.min'] = trans('text.comment_min');

		$rules['rating'] = 'required';
		$messages['rating.required'] = trans('text.rating_required');

        $validator = \Validator::make($datas['request'], $rules, $messages);
        if ($validator->fails()) {
            $error = ['error'=>'1','success'=>'0','msg'=> trans('text.send_comment').' '.trans('text.unsuccessfully').'!','validatormsg'=>$validator->messages()];
        }
        return $error;
	}

}
