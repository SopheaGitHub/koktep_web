<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Documentation extends Model
{
    protected $table = 'documentation';
	protected $fillable = ['image', 'parent_id', 'top', 'column', 'sort_order', 'status'];

	public function getDocumentation($documentation_id, $language_id = false) {
		$db = DB::table(DB::raw('
				(SELECT DISTINCT
					d.*, dd2.name, (
						SELECT
							GROUP_CONCAT(
								dd1. NAME
								ORDER BY
									LEVEL SEPARATOR \'&nbsp;&nbsp;&gt;&nbsp;&nbsp;\'
							)
						FROM
							documentation_path dp
						LEFT JOIN documentation_description dd1 ON (
							dp.path_id = dd1.documentation_id
							AND dp.documentation_id != dp.path_id AND dd1.language_id = \'1\'
						)
						WHERE
							dp.documentation_id = d.documentation_id
						GROUP BY
							dp.documentation_id
					) AS path,
					(
						SELECT DISTINCT
							keyword
						FROM
							url_alias
						WHERE
							QUERY = \'documentation_id='.$documentation_id.'\'
					) AS keyword
				FROM
					documentation d
				LEFT JOIN documentation_description dd2 ON (
					d.documentation_id = dd2.documentation_id AND dd2.language_id = \'1\'
				)
				WHERE
					d.documentation_id = \''.$documentation_id.'\') AS documentation
			'));
		$result = $db->first();
		return $result;
	}

	public function getDocumentationDescriptionsByLanguage($documentation_id, $language_id = false) {
		$result = DB::table(DB::raw('
				(SELECT
					dd.*
				FROM
					documentation AS d
				LEFT JOIN documentation_description AS dd ON dd.documentation_id = d.documentation_id AND dd.language_id = "'.$language_id.'"
				WHERE d.documentation_id = "'.$documentation_id.'") AS documentation_description
			'))->first();
		return $result;
	}

	public function getAllDocumentationByLanguage($filter_data=[]) {
		$db = DB::table(DB::raw('
				(
					SELECT d.*, dd.name AS name FROM documentation d
					LEFT JOIN documentation_description dd ON (d.documentation_id = dd.documentation_id AND dd.language_id = \''.$filter_data['language_id'].'\')
					WHERE d.parent_id = \''.$filter_data['parent_id'].'\'
				) AS documentation
			'))->orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

}
