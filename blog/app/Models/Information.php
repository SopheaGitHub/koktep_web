<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Language;
use DB;

class Information extends Model {

	protected $table = 'information';
	protected $fillable = ['bottom', 'sort_order', 'status'];

	public function getInformation($information_id) {
		$result = DB::table(DB::raw('
				(SELECT
				DISTINCT *, (
						SELECT
							keyword
						FROM
							url_alias
						WHERE
							QUERY = \'information_id=\'"'.$information_id.'"
					) AS keyword
				FROM
					information
				WHERE
					information_id = "'.$information_id.'") AS information
			'))->first();
		return $result;
	}

	public function getInformationDescriptions($information_id) {
		$result = DB::table(DB::raw('
				(SELECT
					id.*
				FROM
					information AS i
				LEFT JOIN information_description AS id ON id.information_id = i.information_id
				WHERE i.information_id = "'.$information_id.'") AS information_description
			'))->get();
		return $result;
	}

	public function getInformationDescriptionByCode($filter_data=[]) {
		$db = DB::table(DB::raw('
				(SELECT
					id.*
				FROM
					information AS i
				LEFT JOIN information_description AS id ON id.information_id = i.information_id AND id.language_id = \''.$filter_data['language_id'].'\'
				WHERE i.information_id = "'.$filter_data['information_id'].'") AS information_description
			'));

		$result = $db->first();
		return $result;
	}

	public function getInformationToLayouts($information_id) {
		$result = DB::table(DB::raw('
				(SELECT
					itl.*
				FROM
					information AS i
				LEFT JOIN information_to_layout AS itl ON itl.information_id = i.information_id
				WHERE i.information_id = "'.$information_id.'") AS information_to_layout
			'))->get();
		return $result;
	}

	public function getAllInformation($filter_data=[]) {
		$db = DB::table(DB::raw('
				(
					SELECT
						i.information_id AS information_id,
						i.created_at AS created_at,
						i.sort_order AS sort_order,
						id.title AS title
					FROM
						information AS i
					LEFT JOIN information_description AS id ON id.information_id = i.information_id
					AND id.language_id = \'1\'
				) AS information
			'))
		->orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function getInformations($filter_data=[]) {
		$db = DB::table(DB::raw('
				(
					SELECT
						i.information_id AS information_id,
						i.created_at AS created_at,
						i.sort_order AS sort_order,
						i.icon AS icon,
						id.title AS title
					FROM
						information AS i
					LEFT JOIN information_description AS id ON id.information_id = i.information_id
					AND id.language_id = \''.$filter_data['language_id'].'\'
				) AS information
			'))
		->orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function insertInformationDescription($datas=[]) {
		$sql = '';
		if(isset($datas['information_description_datas']) && count($datas['information_description_datas']) > 0) {
			foreach ($datas['information_description_datas'] as $language_id => $information_description) {
				$sql .= " INSERT INTO `information_description`(`information_id`, `language_id`, `title`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES ('".$datas['information_id']."', '".$language_id."', '".$information_description['title']."', '".$information_description['description']."', '".$information_description['meta_title']."', '".$information_description['meta_description']."', '".$information_description['meta_keyword']."'); ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function insertInformationToLayout($datas=[]) {
		$sql = '';
		if(isset($datas['information_to_layout_datas']) && count($datas['information_to_layout_datas']) > 0) {
			foreach ($datas['information_to_layout_datas'] as $information_to_layout) {
				$sql .= " INSERT INTO `information_to_layout`(`information_id`, `website_id`, `layout_id`) VALUES ('".$information_to_layout['information_id']."', '".$information_to_layout['website_id']."', '".$information_to_layout['layout_id']."'); ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function deletedInformationDescription($information_id) {
		DB::table('information_description')->where('information_id', '=', $information_id)->delete();
	}

	public function deletedUrlAlias($information_id) {
		DB::table('url_alias')->where('query', '=', 'information_id='.$information_id)->delete();
	}

	public function deletedInformationToLayout($information_id) {
		DB::table('information_to_layout')->where('information_id', '=', $information_id)->delete();
	}

	public function destroyInformation($array_id) {
		DB::table('information')->whereIn('information_id', $array_id)->delete();
		DB::table('information_description')->whereIn('information_id', $array_id)->delete();
		DB::table('information_to_layout')->whereIn('information_id', $array_id)->delete();
	}

	public function validationForm($datas=[]) {
		$this->language = new Language();
		$languages = $this->language->getLanguages(['sort'=>'name', 'order'=>'asc'])->get();
		$error = false;
		$rules = [];
		$messages = [];

		foreach ($languages as $language) {
			$rules['information_description.'.$language->language_id.'.title'] = 'required';
			$rules['information_description.'.$language->language_id.'.description'] = 'required';
			$description_len = str_replace(['<p>','</p>','<br>','</br>'], ['','','',''], $datas['request']['information_description'][$language->language_id]['description']);
			if(mb_strlen($description_len) < 5){
				$rules['description_len'.$language->language_id] = 'required';
			}
			$rules['information_description.'.$language->language_id.'.meta_title'] = 'required';
		}
		$rules['sort_order'] = 'integer';

		foreach ($languages as $language) {
			$messages['information_description.'.$language->language_id.'.title.required'] = 'The <b>Information Title "'.$language->name.'"</b> field is required.';
			$messages['information_description.'.$language->language_id.'.description.required'] = 'The <b>Description "'.$language->name.'"</b> field is required.';
			$messages['description_len'.$language->language_id.'.required'] = 'The <b>Description "'.$language->name.'"</b> must be at least 5 characters.';
			$messages['information_description.'.$language->language_id.'.meta_title.required'] = 'The <b>Meta Tag Title "'.$language->name.'"</b> field is required.';
		}

		$messages['sort_order.integer'] = 'The <b>Sort Order</b> must be an integer.';

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : save information unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}
