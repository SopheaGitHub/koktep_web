<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Layout extends Model {

	protected $table = 'layout';
	protected $fillable = ['name'];

	public function getLayout($layout_id) {
		$result = Layout::where('layout_id', '=', $layout_id)->first();
		return $result;
	}

	public function getLayouts($filter_data=[]) {
		$db = Layout::orderBy($filter_data['sort'], $filter_data['order']);
		return $db;
	}

	public function getLayoutRoutes($layout_id) {
		$result = DB::select("SELECT * FROM layout_route WHERE layout_id = '" . $layout_id . "'");
		return $result;
	}

	public function getLayoutModules($layout_id) {
		$result = DB::select("SELECT * FROM layout_module WHERE layout_id = '" . $layout_id . "'");
		return $result;
	}

	public function insertLayoutRoute($datas=[]) {
		$sql = '';
		if(isset($datas['layout_route']) && count($datas['layout_route']) > 0) {
			foreach ($datas['layout_route'] as $layout_route_info) {
				$sql .= " INSERT INTO layout_route (layout_id, website_id, route) VALUES ('".$datas['layout_id']."', '".$layout_route_info['website_id']."', '".$layout_route_info['route']."'); ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function insertLayoutModule($datas=[]) {
		$sql = '';
		if(isset($datas['layout_module']) && count($datas['layout_module']) > 0) {
			foreach ($datas['layout_module'] as $layout_module_info) {
				$sql .= " INSERT INTO layout_module (layout_id, code, position, sort_order) VALUES ('".$datas['layout_id']."', '".$layout_module_info['code']."', '".$layout_module_info['position']."', '".$layout_module_info['sort_order']."'); ";
			}
			DB::connection()->getPdo()->exec($sql);
		}
	}

	public function deletedLayoutRoute($layout_id) {
		DB::table('layout_route')->where('layout_id', '=', $layout_id)->delete();
	}

	public function deletedLayoutModule($layout_id) {
		DB::table('layout_module')->where('layout_id', '=', $layout_id)->delete();
	}

	public function destroyLayouts($array_id) {
		DB::table('layout')->whereIn('layout_id', $array_id)->delete();
		DB::table('layout_route')->whereIn('layout_id', $array_id)->delete();
		DB::table('layout_module')->whereIn('layout_id', $array_id)->delete();
	}

	public function validationForm($datas=[]) {
		$error = false;
		$rules = [
            'name'			=> 'required',
        ];

        $messages = [
        	'name.required' => 'The <b>Layout Name</b> field is required.',
        ];

        if(isset($datas['request']['layout_module'])) {
        	$i = 1;
        	foreach($datas['request']['layout_module'] as $key => $val) {
				$rules['layout_module.'.$key.'.sort_order'] = 'integer';
				$messages['layout_module.'.$key.'.sort_order.integer'] = 'The <b>Module ('.$i.') Sort Order </b> must be an integer.';
				$i++;
			}
        }

		$validator = \Validator::make($datas['request'], $rules, $messages);
		if ($validator->fails()) {
			$error = ['error'=>'1','success'=>'0','msg'=>'Warning : save layout unsuccessfully!','validatormsg'=>$validator->messages()];
        }
		return $error;
	}

}
